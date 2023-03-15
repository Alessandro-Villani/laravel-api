<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user_details.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'address' => 'nullable|string',
            'profile_pic' => 'image|nullable|mimes:jpg,jpeg,bmp,png',
            'user_id' => 'exists:users,id'
        ]);

        $data = $request->all();

        if (array_key_exists('profile_pic', $data)) {

            $profile_pic = Storage::put('users', $data['profile_pic']);
            $data['profile_pic'] = $profile_pic;
        }

        $user_details = new UserDetail();
        $user_details->fill($data);
        $user_details->save();

        return to_route('admin.home');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.user_details.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserDetail $user_detail)
    {
        $request->validate([
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'address' => 'nullable|string',
            'profile_pic' => 'image|nullable|mimes:jpg,jpeg,bmp,png',
        ]);

        $data = $request->all();

        if (array_key_exists('profile_pic', $data)) {

            if ($user_detail->profile_pic) Storage::delete($user_detail->profile_pic);
            $profile_pic = Storage::put('users', $data['profile_pic']);
            $data['profile_pic'] = $profile_pic;
        }

        $user_detail->fill($data);
        $user_detail->save();

        return to_route('admin.home');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
