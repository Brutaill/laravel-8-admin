<?php

namespace App\Models;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'address', 'vat',
    ];

    public function scopeFilter($query, array $filters)   {        

        if(!empty($filters['search'])) {
            return $query->where('name', 'LIKE', '%'.$filters['search'].'%')
                        ->orWhere('address', 'LIKE', '%'.$filters['search'].'%');
        } 

    }

    public function projects() {
        return $this->hasMany(Project::class);
    }


}
