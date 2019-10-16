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
                'name' => 'NI MADE ROSITA FEBRIANTI',
                'username'=>'rosita',
                'password'=>bcrypt('123456'),
                'phone' => '0',
                'status'=>'Activated',
                'agency_id'=>'1'
            ],
            [   
                'name' => 'AYU PUTU RIFA KORPRIANTINI, S.PD',
                'username'=>'ayurifa',
                'password'=>bcrypt('123456'),
                'phone' => '0',
                'status'=>'Activated',
                'agency_id'=>'1'
            ],
            [   
                'name' => 'IDA AYU PUTRI SARISARASWATI, SE., M.A.P',
                'username'=>'dayuputri',
                'password'=>bcrypt('123456'),
                'phone' => '0',
                'status'=>'Activated',
                'agency_id'=>'1'
            ],
            [   
                'name' => 'NI LUH WARTINI, SH',
                'username'=>'luhwartini',
                'password'=>bcrypt('123456'),
                'phone' => '0',
                'status'=>'Activated',
                'agency_id'=>'1'
            ],
            [   
                'name' => 'NI LUH WARTINI, SH',
                'username'=>'luhwartini',
                'password'=>bcrypt('123456'),
                'phone' => '0',
                'status'=>'Activated',
                'agency_id'=>'1'
            ],
            [
                'name' => 'I NYOMAN AGUS TRISNA, S.Si',
                'username'=>'agustrisna',
                'password'=>bcrypt('123456'),
                'phone' => '0',
                'status'=>'Activated',
                'agency_id'=>'1'
            ],
            [   
                'name' => 'DEWA GEDE ADI PARAMARTHA, S.STP',
                'username'=>'dewaadi',
                'password'=>bcrypt('123456'),
                'phone' => '0',
                'status'=>'Activated',
                'agency_id'=>'1'
            ],
            [   
                'name' => 'IDA BAGUS ARI ARIAWAN, S.S',
                'username'=>'ariariawan',
                'password'=>bcrypt('123456'),
                'phone' => '0',
                'status'=>'Activated',
                'agency_id'=>'1'
            ],
            [   
                'name' => 'NI LUH PUTU DYAN PUSPITASARI',
                'username'=>'putudyan',
                'password'=>bcrypt('123456'),
                'phone' => '0',
                'status'=>'Activated',
                'agency_id'=>'1'
            ],
            [   
                'name' => 'HELPDESK',
                'username'=>'helpdesk',
                'password'=>bcrypt('123456'),
                'phone' => '0',
                'status'=>'Activated',
                'agency_id'=>'1'
            ],
            [   
                'name' => 'PENGADUAN',
                'username'=>'pengaduan',
                'password'=>bcrypt('123456'),
                'phone' => '0',
                'status'=>'Activated',
                'agency_id'=>'1'
            ],
            [   
                'name' => 'Lounge',
                'username'=>'lounge',
                'password'=>bcrypt('123456'),
                'phone' => '0',
                'status'=>'Activated',
                'agency_id'=>'1'
            ],
            [   
                'name' => 'NI LUH PUTU DYAN PUSPITASARI',
                'username'=>'putudyan',
                'password'=>bcrypt('123456'),
                'phone' => '0',
                'status'=>'Activated',
                'agency_id'=>'1'
            ]
        ]);      
    }
}
