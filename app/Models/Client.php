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

    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i:s',
        'updated_at' => 'datetime:d/m/Y H:i:s',
    ];

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


}
