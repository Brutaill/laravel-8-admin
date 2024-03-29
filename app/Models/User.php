<?php

namespace App\Models;

use App\Models\Project;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements Authorizable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // mutator for password
    public function setPasswordAttribute($value) {
        $this->attributes['password'] = Hash::make($value);
    }

    public function getCreatedAtAttribute(string $value) : string 
    {
        return Carbon::make($value)->format('d.m.Y H:i:s');
    }

    public function getUpdatedAtAttribute(string $value) : string 
    {
        return Carbon::make($value)->format('d.m.Y H:i:s');
    }

    
    public function scopeFilter($query, array $filters)   {        

        if(!empty($filters['is_admin'])) {           
            $query->where('is_admin', $filters['is_admin']);
        }

        if(!empty($filters['search'])) {
            $query->where('name', 'LIKE', '%'.$filters['search'].'%');
        }        

    }

    public function projects() {
        return $this->belongsToMany(Project::class)->withTimestamps();
    }

    public function tasks() {
        return $this->hasMany(Task::class);
    }
    
}
