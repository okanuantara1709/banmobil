<?php

use Illuminate\Database\Seeder;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('services')->insert([
            [   
                'name' => 'Pengecekan Berkas',
                'agency_id'=>'1'
            ],
            [   
                'name' => 'Pengambilan Berkas',
                'agency_id'=>'1'
            ],
            [   
                'name' => 'Cek Berkas',
                'agency_id'=>'1'
            ],
            [   
                'name'=>'Informasi Tagihan',
                'agency_id'=>'2'
            ],
            [   
                'name'=>'Informasi Sambungan Baru',
                'agency_id'=>'2'
            ],
            [   
                'name'=>'Pelayanan Izin Lingkungan',
                'agency_id'=>'3'
            ],
            [   
                'name'=>'Pelayanan SPPL',
                'agency_id'=>'3'
            ],
            [   
                'name'=>'Pelayanan UKL-UPL',
                'agency_id'=>'3'
            ],
            [   
                'name'=>'Pelayanan Amdal',
                'agency_id'=>'3'
            ],
            [   
                'name'=>'Pelayanan Pendaftaran NPWPD',
                'agency_id'=>'4'
            ],
            [   
                'name'=>'Pelayanan Informasi PBB/P2',
                'agency_id'=>'4'
            ],
            [   
                'name'=>'Pelayanan Informasi Pajak Daerah',
                'agency_id'=>'4'
            ],
            [   
                'name'=>'Pelayanan Perizinan Tenaga Kesehatan',
                'agency_id'=>'6'
            ],
            [   
                'name'=>'Pelayanan Perizinan Tenaga Kesehatan',
                'agency_id'=>'6'
            ],
            [   
                'name'=>'Pelayanan',
                'agency_id'=>'6'
            ],
            [   
                'name'=>'Pelayanan ',
                'agency_id'=>'7'
            ],
            [   
                'name'=>'Pelayanan Informasi Imigrasi',
                'agency_id'=>'8'
            ],
            [   
                'name'=>'Pelayanan Paspor',
                'agency_id'=>'8'
            ],
            [   
                'name'=>'Pelayanan Haki',
                'agency_id'=>'8'
            ],
            [   
                'name'=>'Pelayanan SKCK',
                'agency_id'=>'9'
            ],
            [   
                'name'=>'Pelayanan STLK',
                'agency_id'=>'9'
            ],
            [   
                'name'=>'Pelayanan SKCK',
                'agency_id'=>'9'
            ]
        ]);     
    }
}
