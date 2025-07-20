<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publication;

class PublicationController extends Controller
{
    // metodo para listar todas las publicaciones
    public function index()
    {
        // obtiene todas las publicaciones incluyendo relaciones si el metodo included esta definido
        $publications = Publication::included()->get();
        return response()->json($publications);
    }

    // metodo para crear una nueva publicacion
    public function store(Request $request)
    {
        // valida los datos recibidos
        $request->validate([
            'title_publication' => 'required|string|max:255',
            'type_publication' => 'required|string|max:255',
            'severity_publication' => 'required|string|max:255',
            'location_publication' => 'required|string|max:255',
            'description_publication' => 'required|string',
            'role_id' => 'required|exists:roles,id',
            'url_imagen' => 'nullable|string|max:255',
        ]);

        // crea la publicacion
        $publication = Publication::create($request->all());
        return response()->json($publication, 201);
    }

    // metodo para mostrar una publicacion por id
    public function show($id)
    {
        // busca la publicacion o lanza excepcion si no existe
        $publication = Publication::findOrFail($id);
        return response()->json($publication);
    }

    // metodo para actualizar una publicacion existente
    public function update(Request $request, Publication $publication)
    {
        // valida los datos recibidos si estan presentes
        $request->validate([
            'title_publication' => 'sometimes|required|string|max:255',
            'type_publication' => 'sometimes|required|string|max:255',
            'severity_publication' => 'sometimes|required|string|max:255',
            'location_publication' => 'sometimes|required|string|max:255',
            'description_publication' => 'sometimes|required|string',
            'role_id' => 'sometimes|required|exists:roles,id',
            'url_imagen' => 'nullable|string|max:255',
        ]);

        // actualiza la publicacion
        $publication->update($request->all());
        return response()->json($publication);
    }

    // metodo para eliminar una publicacion
    public function destroy(Publication $publication)
    {
        $publication->delete();
        return response()->json(['message' => 'publicacion eliminada correctamente']);
    }
}
