<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Modelo Message
 *
 * Representa un mensaje enviado en el sistema de chat.
 * Puede ser de un administrador o de un usuario con un rol determinado.
 */
class Message extends Model
{
    use HasFactory;

    /**
     * Campos que pueden asignarse masivamente (por ejemplo, al crear un mensaje).
     */
    protected $fillable = ['content', 'is_admin_message', 'is_read', 'role_id'];

    /**
     * Relaciones que se pueden incluir dinámicamente vía query string (scopeIncluded).
     * Ejemplo: ?include=role
     */
    protected $allowIncluded = ['role'];

    /**
     * Filtros que se pueden aplicar dinámicamente vía query string (scopeFilter).
     * Ejemplo: ?filter[is_read]=0
     */
    protected $allowFilter = ['content', 'is_admin_message', 'is_read', 'role_id'];

    /**
     * Relación inversa: Un mensaje pertenece a un rol.
     *
     * Esto permite acceder al rol que emitió o recibió el mensaje.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Scope: incluir relaciones dinámicamente si son válidas.
     *
     * Permite hacer:
     * GET /api/messages?include=role
     */
    public function scopeIncluded(Builder $query)
    {
        // Si no hay relaciones permitidas o no se especificaron, no se hace nada
        if (empty($this->allowIncluded) || empty(request('include'))) {
            return $query;
        }

        $relations = explode(',', request('include')); // Relaciones solicitadas en la URL
        $allowIncluded = collect($this->allowIncluded); // Lista blanca de relaciones

        // Se eliminan las relaciones no permitidas
        foreach ($relations as $key => $relationship) {
            if (!$allowIncluded->contains($relationship)) {
                unset($relations[$key]);
            }
        }

        // Se agregan las relaciones válidas a la consulta
        return $query->with($relations);
    }

    /**
     * Scope: aplicar filtros dinámicamente según query string.
     *
     * Ejemplo:
     * GET /api/messages?filter[is_admin_message]=1
     */
    public function scopeFilter(Builder $query)
    {
        // Si no hay filtros definidos o no se enviaron, no se hace nada
        if (empty($this->allowFilter) || empty(request('filter'))) {
            return $query;
        }

        $filters = request('filter');
        $allowFilter = collect($this->allowFilter);

        // Se recorren todos los filtros enviados por la URL
        foreach ($filters as $filter => $value) {
            if ($allowFilter->contains($filter)) {
                // Si el filtro es booleano o ID, se aplica directamente
                if (in_array($filter, ['is_admin_message', 'is_read', 'role_id'])) {
                    $query->where($filter, $value);
                } else {
                    // Si es texto, se aplica búsqueda parcial (LIKE)
                    $query->where($filter, 'LIKE', '%' . $value . '%');
                }
            }
        }

        return $query;
    }
}
