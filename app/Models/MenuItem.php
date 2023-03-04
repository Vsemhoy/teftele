<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class MenuItem
{
    use HasApiTokens, HasFactory, Notifiable;

    public int $id;
    public string $name;
    /**
     * 0 - simple
     * 1 - component
     * 2 - else
     */
    public int $type;
    public int $part_id;
// 0 - turned off, 1 - active
    public int $status;
    public string $route;
    public string $icon;
    public int $role;
    public string $class;
    public int $orderer;
    public int $level;
    public int $parent;

    public $created_at;
    public $updated_at;
    public int $creator;
    public int $updator;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
}