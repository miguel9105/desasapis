<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
     // $role = Role::included()->findOrFail(2);
        $roles=Role::included()->get();
         // $roles=Role::included()->filter()->get();
        return response()->json($roles);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
         $request->validate([
            'name' => 'required|max:255',
        ]);

        $role = Role::create($request->all());

        return response()->json($role);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
    $role = Role::findOrFail($id);
        // $role = Role::with(['posts.user'])->findOrFail($id);
        // $role = Role::with(['posts'])->findOrFail($id);
        return response()->json($role);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:categories,slug,'.$role->id,

        ]);

        $role->update($request->all());

        return $role;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return $role;
    }
}
