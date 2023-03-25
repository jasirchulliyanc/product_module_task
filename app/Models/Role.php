<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasFactory;

    /**
     * List of permission for this model
     */
    public const PERMISSION_LIST = 'List roles';
    public const PERMISSION_VIEW = 'View role';
    public const PERMISSION_CREATE = 'Create role';
    public const PERMISSION_UPDATE = 'Update role';
    public const PERMISSION_DELETE = 'Delete role';

    /**
     * List of roles
     */
    public const ROLE_SUPER_ADMIN = 'Super Admin';
    public const ROLE_SELLER = 'Seller';


    /** ==================== Helpers ==================== */
    public function isRole($role)
    {
        return $this->id === $role || $this->name === $role;
    }
    /** ==================== Helpers ==================== */

    /** ==================== Statics ==================== */
    public static function list()
    {
        if (auth()->check() && auth()->user()->can('isSuper', User::class)) {
            return static::get();
        }

        return static::where('id', '!=', 1)->get(); //Avoid showing super admin
    }

    /** ==================== Statics ==================== */
}
