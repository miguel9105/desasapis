<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
/**
 * Controlador que gestiona las operaciones CRUD para los mensajes del sistema.
 * Utilizado principalmente en el módulo de chat entre usuarios y administradores.
 */

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::included()->filter()->get();
        return response()->json($messages);
    }
/**
     * Almacenar un nuevo mensaje en la base de datos.
     *
     * Requiere que el frontend envíe:
     * - content: Texto del mensaje
     * - is_admin_message: booleano (si lo envía un administrador)
     * - is_read: booleano (por defecto false)
     * - role_id: ID del rol asociado al remitente (opcional)
     */
    public function store(Request $request)
    {
        $message = Message::create($request->only(['content', 'is_admin_message', 'is_read', 'role_id']));
        return response()->json($message, 201);
    }

    public function show($id)
    {
        return Message::findOrFail($id);
    }
/* Actualizar los datos de un mensaje existente */
    public function update(Request $request, $id)
    {
        $message = Message::findOrFail($id);
        $message->update($request->only(['content', 'is_admin_message', 'is_read', 'role_id']));
        return response()->json($message, 200);
    }

    public function destroy($id)
    {
        Message::destroy($id);
        return response()->json(null, 204);
    }
}