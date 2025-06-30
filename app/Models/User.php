<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
   
   
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


     public function roles()
    {
        return $this->belongsToMany(Role::class );
    }


    //LISTAS BLANCAS
    protected $allowIncluded = ['rol', 'rol.user']; //las posibles Querys que se pueden realizar
    protected $allowFilter = ['id', 'name'];

    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;


    public function scopeIncluded(Builder $query)
    {
        if (empty($this->allowIncluded) || empty(request('included'))) { // validamos que la lista blanca y la variable included enviada a travez de HTTP no este en vacia.
            return;
        }

        $relations = explode(',', request('included')); //['posts','relation2']//recuperamos el valor de la variable included y separa sus valores por una coma

        //return $relations;


        $allowIncluded = collect($this->allowIncluded); //colocamos en una colecion lo que tiene $allowIncluded en este caso = ['posts','posts.user']

        foreach ($relations as $key => $relationship) { //recorremos el array de relaciones

            if (!$allowIncluded->contains($relationship)) {
                unset($relations[$key]);
            }
        }

       // return $relations;

        $query->with($relations); //se ejecuta el query con lo que tiene $relations en ultimas es el valor en la url de included

    }

    public function scopeFilter(Builder $query)
    {

        if (empty($this->allowFilter) || empty(request('filter'))) {
            return;
        }

        $filters = request('filter');

        $allowFilter = collect($this->allowFilter);

        foreach ($filters as $filter => $value) {

            if ($allowFilter->contains($filter)) {

                $query->where($filter, 'LIKE', '%' . $value . '%');//nos retorna todos los registros que conincidad, asi sea en una porcion del texto
            }
        }



    }
}
