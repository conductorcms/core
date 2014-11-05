<?php namespace Conductor\Core\Seeders;

use Illuminate\Database\Seeder;
use Cartalyst\Sentinel\Sentinel;

class ConductorSeeder extends Seeder {

    private $sentinel;

    function __construct(Sentinel $sentinel)
    {
        $this->sentinel = $sentinel;
    }

    public function run()
    {
        $role = $this->sentinel->getRoleRepository()->createModel()->create([
            'name' => 'Super Administrators',
            'slug' => 'super-administrators'
        ]);

        $role->permissions = [
            '*' => true
        ];

        $role->save();

        $role = $this->sentinel->getRoleRepository()->createModel()->create([
            'name' => 'Administrators',
            'slug' => 'administrators'
        ]);

        $role->permissions = [
            'admin' => true,
            'admin.*' => true,
        ];

        $role->save();

        $role = $this->sentinel->getRoleRepository()->createModel()->create([
            'name' => 'Users',
            'slug' => 'users'
        ]);

        $role->permissions = [
            'users' => true
        ];

        $role->save();
    }


}