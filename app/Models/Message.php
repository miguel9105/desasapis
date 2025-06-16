<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /** @use HasFactory<\Database\Factories\MessageFactory> */
    use HasFactory;


     // Relación uno a muchos inversa con el modelo Role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
