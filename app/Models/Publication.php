<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;

    // campos que se pueden asignar masivamente
    protected $fillable = [
        'title_publication',
        'type_publication',
        'severity_publication',
        'location_publication',
        'description_publication',
        'url_imagen',
        'role_id'
    ];

    // relaciones permitidas para incluir en consultas
    protected $allowIncluded = [
        'categories', 
        'categories.user', 
        'role'
    ];

    // campos permitidos para filtrar
    protected $allowFilter = [
        'id',
        'title_publication',
        'severity_publication',
        'type_publication',
        'location_publication'
    ];

    // relacion muchos a muchos con categorias
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    // relacion muchos a uno con roles
    public function role()
    {
      return $this->belongsTo(Role::class);
    }

    // relacion muchos a muchos con notificaciones
    public function notification()
    {
        return $this->belongsToMany(Notification::class);
    }

    // scope para incluir relaciones permitidas en la consulta
    public function scopeIncluded(Builder $query)
    {
        if (empty($this->allowIncluded) || empty(request('included'))) {
            return $query;
        }

        $relations = explode(',', request('included'));
        $allowIncluded = collect($this->allowIncluded);

        foreach ($relations as $key => $relationship) {
            if (!$allowIncluded->contains($relationship)) {
                unset($relations[$key]);
            }
        }

        return $query->with($relations);
    }

    // scope para filtrar por campos permitidos
    public function scopeFilter(Builder $query)
    {
        if (empty($this->allowFilter) || empty(request('filter'))) {
            return;
        }

        $filters = request('filter');
        $allowFilter = collect($this->allowFilter);

        foreach ($filters as $filter => $value) {
            if ($allowFilter->contains($filter)) {
                $query->where($filter, 'LIKE', '%' . $value . '%');
            }
        }
    }
}
