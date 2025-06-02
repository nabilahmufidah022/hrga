<?php namespace Ppl\Hrga\Updates;

use Ppl\Hrga\Models\Position;
use Winter\Storm\Database\Updates\Seeder;


class Dml008SeederPosition extends Seeder
{   
    public function run()
    {
        $cek = Position::find(3);
        if($cek){
            \Log::info('do migration:' . __FILE__);
            \Log::info('migration log:' . __FILE__, ["Record Position exists"]);
            return false;
        }

        $division = Position::insert([
            [
                'id'               => 1,
                'nama_jabatan'      => 'Manager',
            ],
            [
                'id'               => 2,
                'nama_jabatan'      => 'Staff',
                
            ],
            [
                'id'               => 3,
                'nama_jabatan'      => 'Magang',
            ],    
        ]);
    }

}