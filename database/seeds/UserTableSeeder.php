<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client = new User();
        $client->first_name = 'John';
        $client->last_name = 'Doe';
        $client->email = 'client@example.com';
        $client->role_id = 4;
        $client->password = bcrypt('client');
        $client->save();
        $profile_client = new Profile();
        $profile_client->user_id = 1;
        $profile_client->save();


        $developer = new User();
        $developer->first_name = 'Alex';
        $developer->last_name = 'Curtis';
        $developer->email = 'developer@example.com';
        $developer->role_id = 3;
        $developer->password = bcrypt('developer');
        $developer->save();
        $profile_developer = new Profile();
        $profile_developer->user_id = 2;
        $profile_developer->save();

        $leader = new User();
        $leader->first_name = 'Linus';
        $leader->last_name = 'Torvalds';
        $leader->email = 'leader@example.com';
        $leader->role_id = 2;
        $leader->password = bcrypt('leader');
        $leader->save();
        $profile_leader = new Profile();
        $profile_leader->user_id = 3;
        $profile_leader->save();

        $administrator = new User();
        $administrator->first_name = 'Jorman';
        $administrator->last_name = 'Espinoza';
        $administrator->email = 'jespinoza@3dlinkweb.com';
        $administrator->role_id = 1;
        $administrator->password = bcrypt('jespinoza');
        $administrator->save();
        $profile_administrator = new Profile();
        $profile_administrator->user_id = 4;
        $profile_administrator->save();
    }
}
