<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\Type;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        $role = new Role();
        $role->name = 'user';
        $role->slug = 'regular user';
        $role->save();

        $role2 = new Role();
        $role2->name = 'admin';
        $role2->slug = 'admin';
        $role2->save();

        

    }
}
