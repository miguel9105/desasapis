<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Support\Facades\Request;

class RoleController extends Controller
{
 // obtiene todos los roles aplicando included y filter si vienen en la peticion
    public function index()
    {
        $roles = Role::included()->filter()->get();
        return response()->json($roles);
    }

// crea un nuevo rol con el campo name
    public function store(Request $request)
    {
        $role = Role::create($request->only(['name']));
        return response()->json($role, 201);
    }

    // muestra un rol especifico por su id
    public function show($id)
    {
        $role = Role::findOrFail($id);
        return response()->json($role);
    }
// actualiza el nombre de un rol existente
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->update($request->only(['name']));
        return response()->json($role);
    }
    // elimina un rol por su id
    public function destroy($id)
    {
        Role::destroy($id);
        return response()->json(['message' => 'Rol eliminado correctamente']);
    }
}
