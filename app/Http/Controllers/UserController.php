<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    // Método para listar todos los usuarios
    public function index()
    {
        // Recupera todos los usuarios con relaciones incluidas
        //$users = User::included()->get();

        // Aplica filtros si están definidos en la query y vuelve a obtener usuarios
        $users = User::included()->filter()->get();

        // Retorna la lista de usuarios en formato JSON
        return response()->json($users);
    }

    /**
     * Guarda un nuevo usuario en la base de datos.
     */
    public function store(Request $request)
    {
        // Valida los campos requeridos del formulario
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'password' => 'required|max:255',
        ]);

        // Crea el usuario con los datos del request
        $user = User::create($request->all());

        // Retorna el usuario creado en formato JSON
        return response()->json($user);
    }

    /**
     * Muestra un usuario específico por su ID.
     */
    public function show($id) //si se pasa $id se utiliza la comentada
    {
        // Busca el usuario por ID, si no lo encuentra lanza un error 404
        $user = User::findOrFail($id);

        // Retorna el usuario encontrado en formato JSON
        return response()->json($user);
    }

    // Actualiza los datos de un usuario existente
    public function update(Request $request, User $user)
    {
        // Valida los datos enviados, asegurando que los campos no excedan 255 caracteres
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255' . $user->id,
            'password' => 'required|max:255' . $user->id,
        ]);

        // Actualiza el usuario con los nuevos datos
        $user->update($request->all());

        // Retorna el usuario actualizado
        return $user;
    }

    // Elimina un usuario de la base de datos
    public function destroy(User $user)
    {
        // Ejecuta el borrado del usuario
        $user->delete();

        // Retorna el usuario eliminado (opcional)
        return $user;
    }
}
