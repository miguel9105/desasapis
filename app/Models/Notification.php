<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    /** @use HasFactory<\Database\Factories\NotificationFactory> */
    use HasFactory;
    // una notificacion pertenece a una publicacion
    public function publication()
    {
        return $this->belongsTo(Publication::class);
    }
}
