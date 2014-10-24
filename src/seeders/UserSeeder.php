<?php namespace Conductor\Core\Seeders;

use Illuminate\Database\Seeder;
use Cartalyst\Sentinel\Sentinel;

class UserSeeder extends Seeder {

    private $sentinel;

    function __construct(Sentinel $sentinel)
    {
        $this->sentinel = $sentinel;
    }

    public function run()
    {
        $role = $this->sentinel->getRoleRepository()->createModel()->create([
            'name' => 'Administrators',
            'slug' => 'administrators'
        ]);

        $role->permissions = [
            'admin' => true
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