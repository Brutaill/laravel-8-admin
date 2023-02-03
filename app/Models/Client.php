<?php

namespace App\Models;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'address', 'vat',
    ];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i:s',
        'updated_at' => 'datetime:d/m/Y H:i:s',
    ];

    public function getFullAddressAttribute() {
        return $this->address .', '. $this->vat;
    }

    public function scopeFilter($query, array $filters)   {        

        $query->when($filters['search'] ?? false, function($query) {
            $query->where(function($query) {
                $query->where('name', 'like', '%'.request('search').'%')
                    ->orWhere('address', 'like', '%'.request('search').'%');
            });
        });

    }

    public function projects() {
        return $this->hasMany(Project::class);
    }

    public function tasks() {
        return $this->hasMany(Task::class);
    }

    public function users() {
        return $this->hasManyThrough(User::class, Task::class, 'client_id', 'id', 'id', 'user_id');
    }


}
