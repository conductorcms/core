<?php namespace Mattnmoore\Conductor\Seeders;

use Illuminate\Database\Seeder;
use Sentinel;

class UserSeeder extends Seeder {

    public function run()
    {
        $role = Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Administrators',
            'slug' => 'administrators'
        ]);

        $role->permissions = [
            'admin'
        ];

        $role->save();

        $role = Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Users',
            'slug' => 'users'
        ]);

        $role->permissions = [
            'users'
        ];

        $role->save();
    }


}