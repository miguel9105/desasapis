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
        $users=User::included()->get();
         // $categories=Category::included()->filter()->get();
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'password' => 'required|max:255',
        ]);

        $user = User::create($request->all());

        return response()->json($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id) //si se pasa $id se utiliza la comentada
    {
        $user = User::findOrFail($id);
        // $category = Category::with(['posts.user'])->findOrFail($id);
        // $category = Category::with(['posts'])->findOrFail($id);
        return response()->json($user);
    }

     public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255'.$user->id,
            'password' => 'required|max:255'.$user->id,

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

