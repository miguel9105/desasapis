<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    /** @use HasFactory<\Database\Factories\PublicationFactory> */
    use HasFactory;
    
   //relaciones
    public function category() {
        return $this->belongsToMany('App\Models\Category');
    }

    public function rol() {
        return $this->belongsTo('App\Models\Role');
    }

    public function notification() {
        return $this->belongsToMany('App\Models\Notification');
    }
}
