<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'      => 'Boruto Uzumaki',
            'email'     => 'boruto@ninja.com',
            'password'  => bcrypt('ninja'),
        ]);

        User::create([
            'name'      => 'Kawaki',
            'email'     => 'kaw@ninja.com',
            'password'  => bcrypt('ninja'),
        ]);
    }
}
