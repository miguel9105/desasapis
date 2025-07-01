<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Support\Facades\Request;

class RoleController extends Controller
{

    public function index()
    {
        $roles = Role::included()->filter()->get();
        return response()->json($roles);
    }


    public function store(Request $request)
    {
        $role = Role::create($request->only(['name']));
        return response()->json($role, 201);
    }


    public function show($id)
    {
        $role = Role::findOrFail($id);
        return response()->json($role);
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->update($request->only(['name']));
        return response()->json($role);
    }

    public function destroy($id)
    {
        Role::destroy($id);
        return response()->json(['message' => 'Rol eliminado correctamente']);
    }
}
