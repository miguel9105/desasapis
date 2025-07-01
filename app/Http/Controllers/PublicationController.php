<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publication;

class PublicationController extends Controller
{
    public function index()
    {
        // Muestra con relaciones incluidas (ejemplo: role o categorías si las agregas)
        $publications = Publication::included()->get();
        // $publications = Publication::included()->filter()->get();
        return response()->json($publications);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_publication' => 'required|string|max:255',
            'type_publication' => 'required|string|max:255',
            'severity_publication' => 'required|string|max:255',
            'location_publication' => 'required|string|max:255',
            'description_publication' => 'required|string',
            'role_id' => 'required|exists:roles,id',
            'url_imagen' => 'nullable|string|max:255',
        ]);

        $publication = Publication::create($request->all());
        return response()->json($publication, 201);
    }

    public function show($id)
    {
        $publication = Publication::findOrFail($id);
        // $publication = Publication::with(['role'])->findOrFail($id); // si tienes relaciones
        return response()->json($publication);
    }

    public function update(Request $request, Publication $publication)
    {
        $request->validate([
            'title_publication' => 'sometimes|required|string|max:255',
            'type_publication' => 'sometimes|required|string|max:255',
            'severity_publication' => 'sometimes|required|string|max:255',
            'location_publication' => 'sometimes|required|string|max:255',
            'description_publication' => 'sometimes|required|string',
            'role_id' => 'sometimes|required|exists:roles,id',
            'url_imagen' => 'nullable|string|max:255',
        ]);

        $publication->update($request->all());
        return response()->json($publication);
    }

    public function destroy(Publication $publication)
    {
        $publication->delete();
        return response()->json(['message' => 'Publicación eliminada correctamente.']);
    }
}
