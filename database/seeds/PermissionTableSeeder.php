<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /*** Run the database seeds.** @return void*/
    public function run()
    {
        $permissions = [
            'user',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'Permission-list',
            'Permission-show',
            'Permission-create',
            'Permission-edit',
            'Permission-delete',
            'category',
            'category-list',
            'category-create',
            'category-edit',
            'category-delete',
            'product-list',
            'product-create',
            'product-edit',
            'product-delete',
            'client',
            'client-list',
            'client-create',
            'client-edit',
            'client-delete',
            'orders-add',
            'order-list',
            'order-edit',
            'order-delete'
            ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

    }
}

