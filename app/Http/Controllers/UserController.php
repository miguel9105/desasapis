<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
   public function index()
    {
      // $category = Category::included()->findOrFail(2);
        //$users=User::included()->get();
         // $categories=Category::included()->filter()->get();
        //return response()->json($users);
        return 'hola';
    }

  
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|max:255',
        ]);

        $users = User::create($request->all());

        return response()->json($users);
    }

   
    public function show($id) //si se pasa $id se utiliza la comentada
    {
        $users = User::findOrFail($id);
        // $category = Category::with(['posts.user'])->findOrFail($id);
        // $category = Category::with(['posts'])->findOrFail($id);
        return response()->json($users);
    }

     public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:categories,slug,'.$user->id,

        ]);

        $user->update($request->all());

        return $user;
    }

    public function destroy(User $user)
    {
        $user->delete();
        return $user;
    }
}

