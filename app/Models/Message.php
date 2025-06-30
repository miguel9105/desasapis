<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'is_admin_message', 'is_read', 'role_id'];

    // Relaciones permitidas para incluir
    protected $allowIncluded = ['role'];

    // Filtros permitidos
    protected $allowFilter = ['content', 'is_admin_message', 'is_read', 'role_id'];

    // Relación con Role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Scope para incluir relaciones dinámicamente
    public function scopeIncluded(Builder $query)
    {
        if (empty($this->allowIncluded) || empty(request('include'))) {
            return $query;
        }

        $relations = explode(',', request('include'));
        $allowIncluded = collect($this->allowIncluded);

        foreach ($relations as $key => $relationship) {
            if (!$allowIncluded->contains($relationship)) {
                unset($relations[$key]);
            }
        }

        return $query->with($relations);
    }

    // Scope para aplicar filtros dinámicos
    public function scopeFilter(Builder $query)
    {
        if (empty($this->allowFilter) || empty(request('filter'))) {
            return $query;
        }

        $filters = request('filter');
        $allowFilter = collect($this->allowFilter);

        foreach ($filters as $filter => $value) {
            if ($allowFilter->contains($filter)) {
                // Si es booleano, filtramos directamente
                if (in_array($filter, ['is_admin_message', 'is_read', 'role_id'])) {
                    $query->where($filter, $value);
                } else {
                    $query->where($filter, 'LIKE', '%' . $value . '%');
                }
            }
        }

        return $query;
    }
}