<?php namespace Ppl\Hrga\Updates;

use Ppl\Hrga\Models\Personal;
use Winter\Storm\Database\Updates\Seeder;

class Dml007SeederDatadiri extends Seeder
{   
    public function run()
    {
        $cek = Personal::find(1);
        if($cek){
            \Log::info('do migration:' . __FILE__);
            \Log::info('migration log:' . __FILE__, ["Record Datadiri exists"]);
            return false;
        }

        $division = Personal::insert([
            [
                'id'                => 1,
                'nama'              => 'Nabiilah Mufiidah',
                'divisi_id'         => '9',
                'jabatan_id'        => '1',
                'Status'            => 'Karyawan Tetap',
                'nomor_idcard'      =>  'H001',
                'tanggal_bergabung' => '2025-04-12',
                'no_wa'             => '089670018933'

            ],
        ]);
    }

}