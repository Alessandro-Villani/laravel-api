<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TechnologyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $technologies = Technology::orderBy('id')->paginate(10);
        return view('admin.technologies.index', compact('technologies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return to_route('admin.technologies.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:technologies',
            'icon' => 'required|string',
            'color' => 'nullable|size:7'
        ]);

        $data = $request->all();

        $new_technology = new Technology();
        $new_technology->fill($data);
        $new_technology->save();

        return to_route('admin.technologies.index')->with('message', "la tecnologia <strong>" . strtoupper($new_technology->name) . "</strong> è stata aggiunta con successo")->with('type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return to_route('admin.technologies.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return to_route('admin.technologies.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Technology $technology)
    {
        $request->validate([
            'name' => ['required', 'string', Rule::unique('technologies')->ignore($technology->id)],
            'icon' => 'required|string',
            'color' => 'nullable|size:7'
        ]);

        $data = $request->all();

        $technology->fill($data);
        $technology->save();

        return to_route('admin.technologies.index')->with('message', "la tecnologia <strong>" . strtoupper($technology->name) . "</strong> è stata modificata con successo")->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Technology $technology)
    {
        $technology->delete();

        return to_route('admin.technologies.index')->with('message', "la tecnologia <strong>" . strtoupper($technology->name) . "</strong> è stata rimossa con successo")->with('type', 'success');
    }
}
