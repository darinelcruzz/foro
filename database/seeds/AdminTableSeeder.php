<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class)->create([
            'first_name' => 'Darinel',
            'last_name' => 'Cruz',
            'username' => 'darinelcruzz',
            'email' => 'darinelcruzz@gmail.com',
            'role' => 'admin',
        ]);
    }
}
