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
        DB::table('users')->insert([
            [   
                'nama' => 'admin',
                'username'=>'admin',
                'password'=>bcrypt('123456'),
                'telephone' => '087767767',
                'status'=>'Aktif',
                'role' => 'Admin'
            ]
        ]);      
    }
}
