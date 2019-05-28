<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'satker_id' => null,
            'nama_user' => 'oka',
            'email' => 'admin@gmail.com',
            'password' => bcrypt(123456),
            'role' => 'Admin'
        ]);
    }
}
