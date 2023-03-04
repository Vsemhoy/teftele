<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Component
{
    use HasApiTokens, HasFactory, Notifiable;

    public int $id;
    public string $name;
    public string $com_name;
// 0 - turned off, 1 - active
    public int $status;
    public $created_at;
    public $updated_at;
    public int $installer;
    public int $updator;
    public string $developer;
    public string $version;
    public int $public_role;
    public int $admin_role;

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