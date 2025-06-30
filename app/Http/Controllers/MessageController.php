<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::included()->filter()->get();
        return response()->json($messages);
    }

    public function store(Request $request)
    {
        $message = Message::create($request->only(['content', 'is_admin_message', 'is_read', 'role_id']));
        return response()->json($message, 201);
    }

    public function show($id)
    {
        return Message::findOrFail($id);
    }

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