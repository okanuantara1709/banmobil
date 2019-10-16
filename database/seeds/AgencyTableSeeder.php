<?php

use Illuminate\Database\Seeder;

class AgencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('agency')->insert([
            [
                'name' => 'DPMPTSP',
                'phone' => '0'
            ],
            [
                'name' => 'PDAM',
                'phone' => '0'
            ],
            [
                'name' => 'DLHK',
                'phone' => '0'
            ],
            [
                'name' => 'Bapenda',
                'phone' => '0'
            ],
            [
                'name' => 'Disdukcapil',
                'phone' => '0'
            ],
            [
                'name' => 'Dinkes',
                'phone' => '0'
            ],
            [
                'name' => 'Loket 9',
                'phone' => '0'
            ],
            [
                'name' => 'Kemenkumham',
                'phone' => '0'
            ],
            [
                'name' => 'Kepolisian',
                'phone' => '0'
            ],
            [
                'name' => 'BNNK',
                'phone' => '0'
            ],
            [
                'name' => 'Kejaksaan',
                'phone' => '0'
            ],
            [
                'name' => 'ATR/BPN',
                'phone' => '0'
            ],
            [
                'name' => 'BPOM',
                'phone' => '0'
            ],
            [
                'name' => 'BPJS',
                'phone' => '0'
            ],
            [
                'name' => 'BPD',
                'phone' => '0'
            ],
            [
                'name' => 'BRI',
                'phone' => '0'
            ],
            [
                'name' => 'POS Indonesia',
                'phone' => '0'
            ],
            [
                'name' => 'Peradi',
                'phone' => '0'
            ],
            [
                'name' => 'PLN',
                'phone' => '0'
            ],
            [
                'name' => 'Taspen',
                'phone' => '0'
            ]
        ]);           
    }
}
