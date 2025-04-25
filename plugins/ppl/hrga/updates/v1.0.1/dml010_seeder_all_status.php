<?php namespace Ppl\Hrga\Updates;

use Ppl\Hrga\Models\Allstatus;
use Winter\Storm\Database\Updates\Seeder;
// use Seeder;

class Dml010SeederAllStatus extends Seeder
{   
    public function run()
    {
        $cek = Allstatus::find(5);
        if($cek){
            \Log::info('do migration:' . __FILE__);
            \Log::info('migration log:' . __FILE__, ["record Meetingroomlist 5 exists"]);
            return false; 
        }

        $status = Allstatus::insert([
            [
            'id'                   => 1,
            'nama_status'          => 'Disetujui'
            ],
            [
            'id'                   => 2,
            'nama_status'          => 'Selesai Dipinjam'
            ],
            [
            'id'                   => 3,
            'nama_status'          => 'Batal'
            ],
            [
            'id'                   => 4,
            'nama_status'          => 'Menunggu Persetujuan'
            ],
            [
            'id'                   => 5,
            'nama_status'          => 'Ditolak'
            ],
        ]);
    }

}