<?php


// Definimos el espacio de nombres del modelo
namespace App\Models;

// Importamos clases necesarias de Eloquent
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Definimos la clase User que extiende del modelo Eloquent
class User extends Model
{
    // Lista de atributos que se pueden asignar masivamente
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Atributos que se ocultarán al serializar el modelo (por ejemplo, al devolver en JSON)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Definimos los tipos de datos que deben ser convertidos automáticamente
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime', // Convierte a tipo fecha
            'password' => 'hashed', // Aplica hashing automático al password
        ];
    }

    // Relación muchos a muchos con el modelo Role
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    // Lista blanca: relaciones permitidas para incluir en consultas (ej. con ?included=rol)
    protected $allowIncluded = ['rol', 'rol.user'];

    // Lista blanca: filtros permitidos en consultas (ej. ?filter[name]=Adriana)
    protected $allowFilter = ['id', 'name'];

    // Habilitamos la factoría para pruebas y seeders
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    // Scope para incluir relaciones dinámicamente si están permitidas
    public function scopeIncluded(Builder $query)
    {
        // Verificamos que exista la lista blanca y el parámetro included en la URL
        if (empty($this->allowIncluded) || empty(request('included'))) {
            return;
        }

        // Obtenemos y separamos las relaciones solicitadas en el parámetro included
        $relations = explode(',', request('included'));

        // Convertimos la lista blanca a colección para poder usar métodos de Laravel
        $allowIncluded = collect($this->allowIncluded);

        // Recorremos las relaciones solicitadas y eliminamos las no permitidas
        foreach ($relations as $key => $relationship) {
            if (!$allowIncluded->contains($relationship)) {
                unset($relations[$key]);
            }
        }

        // Aplicamos las relaciones válidas al query
        $query->with($relations);
    }

    // Scope para aplicar filtros a la consulta según la lista blanca
    public function scopeFilter(Builder $query)
    {
        // Verificamos que existan filtros permitidos y que se haya enviado el parámetro filter
        if (empty($this->allowFilter) || empty(request('filter'))) {
            return;
        }

        // Obtenemos los filtros desde la petición
        $filters = request('filter');

        // Convertimos la lista blanca de filtros en una colección
        $allowFilter = collect($this->allowFilter);

        // Recorremos los filtros y aplicamos los que estén permitidos
        foreach ($filters as $filter => $value) {
            if ($allowFilter->contains($filter)) {
                // Aplicamos el filtro con un LIKE para coincidencias parciales
                $query->where($filter, 'LIKE', '%' . $value . '%');
            }
        }
