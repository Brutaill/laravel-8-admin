<?php

namespace App\Models;

use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Client;

class Task extends Model
{
    use HasFactory;

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
        'completed_at',
    ];


    public function getStatusAttribute() {
        return ($this->completed_at) ? self::TASK_CLOSE : self::TASK_OPEN;
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
