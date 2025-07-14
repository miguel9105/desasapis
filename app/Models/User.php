<?php

namespace App\Http\Controllers;

// Importación del modelo User
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    // Método para obtener todos los usuarios
    public function index()
    {
        // Obtiene los usuarios con relaciones incluidas (según la lógica definida en el modelo)
        $users=User::included()->get();

        // Aplica filtros personalizados definidos en el modelo y obtiene nuevamente los usuarios
        $users=User::included()->filter()->get();

        // Devuelve los usuarios en formato JSON
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // Método para crear un nuevo usuario
    public function store(Request $request)
    {
        // Validación de campos requeridos para crear el usuario
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'password' => 'required|max:255',
        ]);

        // Crea un nuevo usuario con los datos del request
        $user = User::create($request->all());

        // Retorna el usuario creado en formato JSON
        return response()->json($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $category
     * @return \Illuminate\Http\Response
     */
    // Método para mostrar un usuario específico por su ID
    public function show($id) //si se pasa $id se utiliza la comentada
    {
        // Busca el usuario por ID; si no existe, lanza un error 404
        $user = User::findOrFail($id);

        // Retorna el usuario encontrado en formato JSON
        return response()->json($user);
    }

    // Método para actualizar un usuario existente
    public function update(Request $request, User $user)
    {
        // Validación de campos requeridos para la actualización
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255'.$user->id,
            'password' => 'required|max:255'.$user->id,
        ]);

        // Actualiza el usuario con los datos del request
        $user->update($request->all());

        // Retorna el usuario actualizado
        return $user;
    }

    // Método para eliminar un usuario
    public function destroy(User $user)
    {
        // Elimina el usuario de la base de datos
        $user->delete();

        // Retorna el usuario eliminado
        return $user;
    }
}
