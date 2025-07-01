<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    protected static $allowIncluded = ['posts', 'posts.user'];
    protected static $allowFilter = ['id', 'name'];

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
    public function scopeIncluded(Builder $query)
    {
        $allowIncluded = static::$allowIncluded;
        if (empty($allowIncluded) || empty(request('included'))) {
            return;
        }
        $relations = explode(',', request('included'));
        $allowed = collect($allowIncluded);
        foreach ($relations as $key => $relationship) {
            if (!$allowed->contains($relationship)) {
                unset($relations[$key]);
            }
        }
        $query->with($relations);
    }
    
    public function scopeFilter(Builder $query)
    {
        $allowFilter = static::$allowFilter;
        if (empty($allowFilter) || empty(request('filter'))) {
            return;
        }
        
        $filters = request('filter');
        $allowed = collect($allowFilter);
        foreach ($filters as $filter => $value) {
            if ($allowed->contains($filter)) {
                $query->where($filter, 'LIKE', '%' . $value . '%');
            }
        }
    }
}