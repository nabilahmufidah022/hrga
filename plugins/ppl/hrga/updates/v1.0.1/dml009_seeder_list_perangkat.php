<?php namespace Ppl\Hrga\Updates;

use Ppl\Hrga\Models\Device;
use Winter\Storm\Database\Updates\Seeder;
// use Seeder;

class Dml009SeederListPerangkat extends Seeder
{   
    public function run()
    {
        $cek = Device::find(3);
        if($cek){
            \Log::info('do migration:' . __FILE__);
            \Log::info('migration log:' . __FILE__, ["record Meetingroomlist 7 exists"]);
            return false; 
        }

        $listperangkat = Device::insert([
            [
            'id'                   => 1,
            'nama_perangkat'       => 'Leptop Lenovo',
            ],
            [
            'id'                   => 2,
            'nama_perangkat'       => 'Proyektor',
            ],
            [
            'id'                   => 3,
            'nama_perangkat'       => 'mouse',
            ],
        ]);
    }

}