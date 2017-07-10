<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_client = Role::where('name', 'Cliente')->first();
        $role_developer = Role::where('name', 'Desarrollador')->first();
        $role_leader = Role::where('name', 'Líder')->first();
        $role_administrator = Role::where('name', 'Administrador')->first();

        $client = new User();
        $client->first_name = 'John';
        $client->last_name = 'Doe';
        $client->email = 'client@example.com';
        $client->password = bcrypt('client');
        $client->save();
        $client->roles()->attach($role_client);

        $developer = new User();
        $developer->first_name = 'Alex';
        $developer->last_name = 'Curtis';
        $developer->email = 'developer@example.com';
        $developer->password = bcrypt('developer');
        $developer->save();
        $developer->roles()->attach($role_developer);

        $leader = new User();
        $leader->first_name = 'Linus';
        $leader->last_name = 'Torvalds';
        $leader->email = 'leader@example.com';
        $leader->password = bcrypt('leader');
        $leader->save();
        $leader->roles()->attach($role_leader);

        $administrator = new User();
        $administrator->first_name = 'Jorman';
        $administrator->last_name = 'Espinoza';
        $administrator->email = 'jespinoza@3dlinkweb.com';
        $administrator->password = bcrypt('jespinoza');
        $administrator->save();
        $administrator->roles()->attach($role_administrator);
    }
}
