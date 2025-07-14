<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
class Role extends Model
{
    use HasFactory;

  // Campos que se pueden llenar por asignación masiva
    protected $fillable = ['name'];

     // relaciones que se pueden incluir en la respuesta usando ?included=
    protected static $allowIncluded = [
        'users',
        'messages',
        'publications',
    ];

    // campos que se pueden usar para filtrar registros (propios y relacionados)
    protected static $allowFilter = [
    // campos propios del modelo role
        'id',
        'name',

    // campos del modelo user relacionado
        'users.id',
        'users.name',
        'users.email',
    //    'users.email_verified_at',
    //    'users.created_at',

     // campos del modelo message relacionado
        'messages.id',
        'messages.content',
        'messages.is_admin_message',
        'messages.is_read',
    //    'messages.created_at',

    // campos del modelo publication relacionado
        'publications.id',
        'publications.title',
        'publications.type',
        'publications.severity',
        'publications.location',
        'publications.description',
    //    'publications.created_at',

        // Publication's user (relación anidada)
        'publications.user.id',
        'publications.user.name',
        'publications.user.email',
    ];


    //Relaciones
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
 // scope para incluir relaciones de forma segura en la consulta
    // este metodo permite usar ?included=users,publications para cargar relaciones
    // pero solo si esas relaciones estan en la lista blanca $allowIncluded
    public function scopeIncluded(Builder $query)
    {
        $allowIncluded = static::$allowIncluded;

        // si no hay relaciones permitidas o no se pidieron relaciones, se sale del metodo
        if (empty($allowIncluded) || empty(request('included'))) {
            return;
        }

        // separa las relaciones pedidas por coma, ejemplo: ?included=users,messages
        $relations = explode(',', request('included'));

        // convierte la lista blanca en una coleccion para facilitar la validacion
        $allowed = collect($allowIncluded);

        // recorre cada relacion pedida y elimina las que no estan permitidas
        foreach ($relations as $key => $relationship) {
            if (!$allowed->contains($relationship)) {
                unset($relations[$key]);
            }
        }

        // aplica solo las relaciones permitidas usando with()
        $query->with($relations);
    }

    // scope para aplicar filtros a la consulta
    // permite filtrar por campos propios o por campos de relaciones
    public function scopeFilter(Builder $query)
    {
        $allowFilter = static::$allowFilter;

        // si no hay filtros permitidos o no se recibieron filtros, se sale del metodo
        if (empty($allowFilter) || empty(request('filter'))) {
            return;
        }

        $filters = request('filter'); // obtiene los filtros enviados por query string
        $allowed = collect($allowFilter); // convierte la lista blanca en coleccion

        foreach ($filters as $filter => $value) {
            if ($allowed->contains($filter)) {
                // si el filtro tiene un punto, significa que es de una relacion (ej: users.name)
                if (str_contains($filter, '.')) {
                    // separa el nombre de la relacion y el campo
                    [$relation, $field] = explode('.', $filter, 2);

                    // aplica whereHas para filtrar a traves de la relacion
                    $query->whereHas($relation, function ($q) use ($field, $value) {
                        $q->where($field, 'LIKE', '%' . $value . '%');
                    });
                } else {
                    // si es un campo directo del modelo, aplica where normal
                    $query->where($filter, 'LIKE', '%' . $value . '%');
                }
            }
        }
    }
}