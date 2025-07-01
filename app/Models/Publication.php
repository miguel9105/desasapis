<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_publication',
        'type_publication',
        'severity_publication',
        'location_publication',
        'description_publication',
        'url_imagen',
        'role_id'
    ];

    // LISTAS BLANCAS
    protected $allowIncluded = [
        'categories', 
        'categories.user', 
        'role'
    ];

    protected $allowFilter = [
        'id',
        'title_publication',
        'severity_publication',
        'type_publication',
        'location_publication'
    ];

    // Relaciones
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function role()
    {
      return $this->belongsTo(Role::class);
    }

    public function notification()
    {
        return $this->belongsToMany(Notification::class);
    }

    public function scopeIncluded(Builder $query)
    {
        if (empty($this->allowIncluded) || empty(request('included'))) {
            return $query; // ← Asegúrate de retornar el query
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

    // Scope para aplicar filtros: ?filter[title]=Alerta
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
