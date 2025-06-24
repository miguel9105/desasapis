<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublicationController extends Controller
{
    // Obtener todas las publicaciones, con relaciones incluidas y filtros
    public function index()
    {
        $publications = Publication::included()->filter()->get();
        return response()->json($publications);
    }

    // Crear nueva publicación
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'description' => 'required',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($data['title']);

        $publication = Publication::create($data);

        return response()->json($publication, 201);
    }

    // Mostrar publicación individual con relaciones incluidas
    public function show($id)
    {
        $publication = Publication::included()->findOrFail($id);
        return response()->json($publication);
    }

    // Actualizar publicación
    public function update(Request $request, Publication $publication)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'description' => 'required',
            'slug' => 'required|max:255|unique:publications,slug,' . $publication->id,
        ]);

        $publication->update($request->all());

        return response()->json($publication);
    }

    // Eliminar publicación
    public function destroy(Publication $publication)
    {
        $publication->delete();

        return response()->json(['message' => 'Publicación eliminada correctamente.']);
    }
}
