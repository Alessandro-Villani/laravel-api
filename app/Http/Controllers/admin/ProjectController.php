<?php

namespace App\Http\Controllers\admin;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Technology;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\Type;
use Illuminate\Support\Arr;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = $request->query('status-filter');


        $selected = $filter ? $filter : 'all';


        $query = Project::orderBy('updated_at', 'DESC');

        if ($filter) {
            $filter_value = $filter === 'published' ? 1 : 0;
            $query->where('is_published', $filter_value);
        }

        $projects = $query->paginate(10);


        return view('admin.projects.index', compact('projects', 'selected'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Type::orderBy('id')->get();
        $technologies = Technology::orderBy('id')->get();
        $project = new Project();

        return view('admin.projects.create', compact('project', 'types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|unique:projects',
            'description' => 'required|string',
            'project_url' => 'required|url',
            'image_url' => 'image|nullable|mimes:jpg,jpeg,bmp,png',
            'type_id' => 'nullable|exists:types,id'
        ]);

        $data = $request->all();




        if (array_key_exists('image_url', $data)) {

            $image_url = Storage::put('projects', $data['image_url']);
            $data['image_url'] = $image_url;
        }

        $new_project = new Project();

        $new_project->fill($data);
        $new_project->save();

        if (Arr::exists($data, 'technologies')) $new_project->technologies()->attach($data['technologies']);

        return to_route('admin.projects.show', $new_project->id)->with('message', "Il progetto <strong>" . strtoupper($new_project->name) . "</strong> è stato aggiunto con successo")->with('type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $project = Project::withTrashed()->findOrFail($id);
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $types = Type::orderBy('id')->get();
        $technologies = Technology::orderBy('id')->get();
        $project = Project::withTrashed()->findOrFail($id);
        $project_technologies = $project->technologies->pluck('id')->toArray();

        return view('admin.projects.edit', compact('project', 'types', 'technologies', 'project_technologies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => ['required', 'string', Rule::unique('projects')->ignore($project->id)],
            'description' => 'required|string',
            'project_url' => 'required|url',
            'image_url' => 'image|nullable|mimes:jpg,jpeg,bmp,png',
            'type_id' => 'nullable|exists:types,id'
        ]);

        $data = $request->all();

        if (array_key_exists('image_url', $data)) {

            if ($project->hasUploadedImage()) Storage::delete($project->image_url);
            $image_url = Storage::put('projects', $data['image_url']);
            $data['image_url'] = $image_url;
        }

        $project->fill($data);
        $project->save();

        if (Arr::exists($data, 'technologies')) $project->technologies()->sync($data['technologies']);
        else if (count($project->technologies)) $project->technologies()->detach();

        return to_route('admin.projects.show', $project->id)->with('message', "Il progetto <strong>" . strtoupper($project->name) . "</strong> è stato modificato con successo")->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {

        $project->delete();

        return to_route('admin.projects.index')->with('message', "Il progetto <strong>" . strtoupper($project->name) . "</strong> è stato eliminato con successo")->with('type', 'success');
    }

    /**
     * Toggle pubblication status.
     */
    public function toggleStatus(Project $project)
    {
        $project->is_published = !$project->is_published;

        $message = $project->is_published ? 'è stato pubblicato con successo.' : 'è stato spostato in bozze.';

        $project->save();

        return redirect()->back()->with('message', "Il progetto <strong>" . strtoupper($project->name) . "</strong> " . $message)->with('type', 'success');
    }

    /**
     * Display a listing of trashed resources.
     */
    public function trash()
    {
        $projects = Project::onlyTrashed()->orderBy('deleted_at', 'DESC')->paginate(10);

        return view('admin.projects.trash.index', compact('projects'));
    }


    public function restore(int $id)
    {
        $project = Project::onlyTrashed()->findOrFail($id);
        $project->restore();
        return to_route('admin.projects.index')->with('message', "Il progetto <strong>" . strtoupper($project->name) . "</strong> è stato ripristinato con successo")->with('type', 'success');
    }

    public function permanentDelete(int $id)
    {
        $project = Project::onlyTrashed()->findOrFail($id);

        if ($project->hasUploadedImage()) Storage::delete($project->image_url);

        if (count($project->technologies)) $project->technologies()->detach();

        $project->forceDelete();

        return to_route('admin.projects.trash.index')->with('message', "Il progetto <strong>" . strtoupper($project->name) . "</strong> è stato eliminato definitivamente")->with('type', 'success');
    }
}
