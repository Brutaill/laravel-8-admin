<?php

namespace App\Models;

use App\Models\User;
use App\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    const PROJECT_OPEN = 'open';
    const PROJECT_CLOSE = 'close';

    protected $fillable = [
        'title', 'description', 'deadline', 'client_id',
    ];

    protected $dates = ['deadline'];

    public function getDeadlineAttribute(string $value) : string 
    {
        return date('d.m.Y H:i:s', strtotime($value));
    }

    public function getDeadlineDateAttribute() {
        return date('Y-m-d', strtotime($this->deadline));
    }  
    
    public function getDeadlineTimeAttribute() {
        return date('H:i:s', strtotime($this->deadline));
    } 

    public function getStatusAttribute() {
        return ($this->completed_at) ? self::PROJECT_CLOSE : self::PROJECT_OPEN;
    }

    public function scopeFilter($query, array $filters)   {        

        if(!empty($filters['search'])) {
            return $query->where(function($query) use ($filters) {
                $query
                    ->where('title', 'LIKE', '%'.$filters['search'].'%')
                    ->orWhere('description', 'LIKE', '%'.$filters['search'].'%');
            });
        }       

    }

    public function users() {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function client() {
        return $this->belongsTo(Client::class);
    }
}
