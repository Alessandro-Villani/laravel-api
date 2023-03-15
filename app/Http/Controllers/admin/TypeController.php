<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = Type::orderBy('id')->paginate(10);
        return view('admin.types.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return to_route('admin.types.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'label' => 'required|string|unique:types',
            'color' => 'nullable|size:7'
        ]);

        $data = $request->all();

        $new_type = new Type();
        $new_type->fill($data);
        $new_type->save();

        return to_route('admin.types.index')->with('message', "il tipo <strong>" . strtoupper($new_type->label) . "</strong> è stato aggiunto con successo")->with('type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return to_route('admin.types.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return to_route('admin.types.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Type $type)
    {
        $request->validate([
            'label' => ['required', 'string', Rule::unique('types')->ignore($type->id)],
            'color' => 'nullable|size:7'
        ]);

        $data = $request->all();

        $type->fill($data);
        $type->save();

        return to_route('admin.types.index')->with('message', "il tipo <strong>" . strtoupper($type->label) . "</strong> è stato modificato con successo")->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Type $type)
    {
        $type->delete();

        return to_route('admin.types.index')->with('message', "il tipo <strong>" . strtoupper($type->label) . "</strong> è stato rimosso con successo")->with('type', 'success');
    }
}
