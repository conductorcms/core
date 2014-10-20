<?php namespace Conductor\Core\Seeders;

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
            'admin' => true
        ];

        $role->save();

        $role = Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Users',
            'slug' => 'users'
        ]);

        $role->permissions = [
            'users' => true
        ];

        $role->save();
    }


}