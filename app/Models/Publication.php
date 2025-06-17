<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'description',
        'slug'
    ];

    // LISTAS BLANCAS
    protected $allowIncluded = ['categories', 'categories.user'];
    protected $allowFilter = ['id', 'title', 'description'];

    // Relaciones
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function rol()
    {
        return $this->belongsTo(Role::class);
    }

    public function notification()
    {
        return $this->belongsToMany(Notification::class);
    }

    // Scope para incluir relaciones dinámicamente desde la URL: ?included=categories,...
    public function scopeIncluded(Builder $query)
    {
        if (empty($this->allowIncluded) || empty(request('included'))) {
            return;
        }

        $relations = explode(',', request('included'));
        $allowIncluded = collect($this->allowIncluded);

        foreach ($relations as $key => $relationship) {
            if (!$allowIncluded->contains($relationship)) {
                unset($relations[$key]);
            }
        }

        $query->with($relations);
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
