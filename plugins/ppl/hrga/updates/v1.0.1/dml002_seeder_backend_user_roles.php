<?php namespace Ppl\Hrga\Updates;

use Winter\Storm\Database\Updates\Seeder;
use Backend\Models\UserRole;

class DMl002SeederBackendUserRoles extends Seeder
{
    public function run()
    {
        $cek = UserRole::find(2);
        if($cek){
            \Log::info('do migration:' . __FILE__);
            \Log::info('migration log:' . __FILE__, ["Record UserRole 2 exists"]);
            return false;
        }

        $userrole = UserRole::insert([
            [
            'id'                   => 3,
            'name'                 =>'User',
            'code'                 =>'user',
            'description'          =>'Kewewenangan sebagai User.',
            'permissions'          =>'{"jamsyar.merapat.peminjaman.home":"1","jamsyar.merapat.peminjaman.peminjamanruangan":"1","jamsyar.merapat.peminjaman.ruangrapat":"1"}'
            ],

            [
            'id'                   => 4,
            'name'                 =>'Admin',
            'code'                 =>'admin',
            'description'          =>'Kewewenangan sebagai Admin.',
            'permissions'          =>'{"jamsyar.merapat.peminjaman.beranda":"1","jamsyar.merapat.peminjaman.halamanpeminjaman":"1","jamsyar.merapat.peminjaman.listruangrapat":"1","jamsyar.merapat.peminjaman.divisi":"1","jamsyar.merapat.peminjaman.laporan":"1"}'
            ],
            
        ]);
    }
}