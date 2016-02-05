<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'root',
            'email' => 'josezara1@gmail.com',
            'password' => bcrypt('secret'),
            'is_root' => true;
            'is_admin' => true;
        ]);
    }
}
