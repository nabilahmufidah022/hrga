<?php namespace Ppl\Hrga\Updates;

// use Seeder;
use Winter\Storm\Database\Updates\Seeder;
use Ppl\Hrga\Models\Status;

class Dml001SeederStatus extends Seeder
{   

    public function run()
    {
        $cek = Status::find(6);
        if($cek){
            \Log::info('do migration:' . __FILE__);
            \Log::info('migration log:' . __FILE__, ["Record Status 6 exists"]);
            return false;
        }
        $status = Status::insert([
            [
            'id'                   => 1,
            'nama'                 => 'Dipesan'
            ],
            [
            'id'                   => 2,
            'nama'                 => 'Selesai Dengan Catatan'
            ],
            [
            'id'                   => 3,
            'nama'                 => 'Sedang Dipakai'
            ],
            [
            'id'                   => 4,
            'nama'                 => 'Selesai'
            ],
            [
            'id'                   => 6,
            'nama'                 => 'Batal'
            ],
        ]);
    }

}