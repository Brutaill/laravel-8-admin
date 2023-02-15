<?php

namespace App\Models;

use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    const TASK_OPEN = 'open';
    const TASK_CLOSE = 'close';

    protected $fillable = [
        'description',
        'client_id',
        'project_id',
        'user_id',
        'completed_at',
    ];

    protected $dates = [
        'completed_at' => 'datetime',
    ];

    public function getCreatedAtAttribute(string $value) : string 
    {
        return Carbon::make($value)->format('d.m.Y H:i:s');
    }

    public function getUpdatedAtAttribute(string $value) : string 
    {
        return Carbon::make($value)->format('d.m.Y H:i:s');
    }

    public function getCompletedAtAttribute(string $value = null) : string 
    {
        return !is_null($value) ? Carbon::make($value)->format('d.m.Y H:i:s') : false;
    }

    public function getStatusAttribute() {
        return ($this->completed_at) ? self::TASK_CLOSE : self::TASK_OPEN;
    }

    public function scopeFilter($query, array $filters) {
        
        // if role taskUser
        $query->where('user_id', auth()->id());
    }
    
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function project()
    {
        return $this->belongsTo(Project::class)->withTrashed();
    }

    public function client()
    {
        return $this->belongsTo(Client::class)->withTrashed();
    }
}
