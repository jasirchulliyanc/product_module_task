<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * List of permission for this model
     */
    public const PERMISSION_LIST = 'List users';
    public const PERMISSION_VIEW = 'View user';
    public const PERMISSION_CREATE = 'Create user';
    public const PERMISSION_UPDATE = 'Update user';
    public const PERMISSION_DELETE = 'Delete user';
    public const PERMISSION_ASSIGN_ROLE = 'Assign roles';

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
    public function scopeProductSellers(Builder $query)
    {
        return $query->whereHas("roles", function ($q) {
            $q->where("name", Role::ROLE_SELLER);
        });
    }

    public function products()
    {
        return $this->hasMany(Product::class,'created_by','id');
    }
}
