<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Permission;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $roles = [
            [
                'name' => Role::ROLE_SUPER_ADMIN,
                'guard_name' => 'web',
                'users' => [
                    'superadmin@product.com',
                ],
                'permissions' => 'all',
            ],
            [
                'name' => Role::ROLE_SELLER,
                'guard_name' => 'web',
                'users' => [
                    'seller@product.com',
                ],
                'permissions' => 'all',
            ]

        ];

        foreach ($roles as $role_data) {
            /** @var Role $role */
            $role = Role::updateOrCreate(['name' => $role_data['name']],
                Arr::only($role_data, $role_data['guard_name']));
            //Link users to role
            foreach ($role_data['users'] as $user) {
                /** @var User $user */
                $user = User::where('email', $user)->first();
                if ($user) {
                    $user->roles()->syncWithoutDetaching($role->id);
                }
            }


        }
    
    }
}
