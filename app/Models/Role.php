<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /** @use HasFactory<\Database\Factories\RoleFactory> */
    use HasFactory;

     public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function publications()
    {
        return $this->hasMany(Publication::class);
    }
    
}
