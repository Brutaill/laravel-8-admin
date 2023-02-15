<?php

namespace App\Models;

use App\Models\Task;
use App\Models\User;
use App\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    const PROJECT_OPEN = 'open';
    const PROJECT_CLOSE = 'close';

    protected $fillable = [
        'title', 'description', 'deadline', 'client_id',
    ];

    protected $dates = [
        'deadline' => 'datetime:d.m.Y H:i:s',
        'created_at' => 'datetime:d.m.Y H:i:s',
        'updated_at' => 'datetime:d.m.Y H:i:s',
    ];

    protected $casts = [
        'deadline' => 'datetime:d.m.Y H:i:s',
        'created_at' => 'datetime:d.m.Y H:i:s',
        'updated_at' => 'datetime:d.m.Y H:i:s',
    ];

    public function getCreatedAtAttribute(string $value) : string 
    {
        return Carbon::make($value)->format('d.m.Y H:i:s');
    }

    public function getUpdatedAtAttribute(string $value) : string 
    {
        return Carbon::make($value)->format('d.m.Y H:i:s');
    }

    public function getDeadlineAttribute(string $value) : string 
    {
        return Carbon::make($value)->format('d.m.Y H:i:s');
    }

    public function getDeadlineDateAttribute() {
        return Carbon::make($this->deadline)->format('Y-m-d');
    }  
    
    public function getDeadlineTimeAttribute() {
        return Carbon::make($this->deadline)->format('H:i:s');
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
        return $this->belongsToMany(User::class)->withTimestamps()->withTrashed();
    }

    public function tasks() {
        return $this->hasMany(Task::class)->withTrashed();
    }

    public function tasks_completed() {
        return $this->hasMany(Task::class)->whereNotNull('completed_at')->withTrashed();
    }

    public function client() {
        return $this->belongsTo(Client::class)->withTrashed();
    }
}
