<?php namespace Ppl\Hrga\Updates;

use Winter\Storm\Database\Updates\Seeder;
use Backend\Models\UserRole;

class Dml002SeederBackendUserRoles extends Seeder
{
    public function run()
    {
        $cek = UserRole::find(5);
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
            'permissions'          =>'{"ppl.hrga.absensi.formabsensi":"1","ppl.hrga.absensi.biodatadiri":"1","ppl.hrga.pengajuan.izin":"1","ppl.hrga.pengajuan.cuti":"1","ppl.hrga.pengajuan.sakit":"1","ppl.hrga.pengajuan.perangkat":"1","ppl.hrga.peminjaman.home":"1","ppl.hrga.peminjaman.peminjamanruangan":"1","ppl.hrga.peminjaman.ruangrapat":"1"}'
            ],
            [
            'id'                   => 4,
            'name'                 =>'Admin HRGA',
            'code'                 =>'admin-hrga',
            'description'          =>'Kewewenangan sebagai Admin.',
            'permissions'          =>'{"ppl.hrga.absensi.formabsensi":"1","ppl.hrga.absensi.biodatadiri":"1","ppl.hrga.pengajuan.izin":"1","ppl.hrga.pengajuan.cuti":"1","ppl.hrga.pengajuan.sakit":"1","ppl.hrga.pengajuan.perangkat":"1","ppl.hrga.peminjaman.beranda":"1","ppl.hrga.peminjaman.home":"1","ppl.hrga.peminjaman.halamanpeminjaman":"1","ppl.hrga.peminjaman.listruangrapat":"1","ppl.hrga.peminjaman.divisi":"1","ppl.hrga.peminjaman.peminjamanruangan":"1","ppl.hrga.peminjaman.ruangrapat":"1","ppl.hrga.peminjaman.laporanruangan":"1","ppl.hrga.peminjaman.laporanabsensi":"1","ppl.hrga.peminjaman.laporandatadiri":"1","ppl.hrga.peminjaman.laporanizin":"1","ppl.hrga.peminjaman.laporancuti":"1","ppl.hrga.peminjaman.laporansakit":"1","ppl.hrga.peminjaman.laporanperangkat":"1"}'
            ],
            [
            'id'                   => 5,
            'name'                 =>'Atasan',
            'code'                 =>'Manager',
            'description'          =>'Kewewenangan sebagai Atasan.',
            'permissions'          =>'{"ppl.hrga.absensi.formabsensi":"1","ppl.hrga.absensi.biodatadiri":"1","ppl.hrga.pengajuan.izin":"1","ppl.hrga.pengajuan.cuti":"1","ppl.hrga.pengajuan.sakit":"1","ppl.hrga.pengajuan.perangkat":"1","ppl.hrga.peminjaman.beranda":"1","ppl.hrga.peminjaman.home":"1","ppl.hrga.peminjaman.halamanpeminjaman":"1","ppl.hrga.peminjaman.listruangrapat":"1","ppl.hrga.peminjaman.divisi":"1","ppl.hrga.peminjaman.peminjamanruangan":"1","ppl.hrga.peminjaman.ruangrapat":"1"}'
            ],
            
        ]);
    }
}