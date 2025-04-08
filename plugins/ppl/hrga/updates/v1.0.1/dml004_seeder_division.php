<?php namespace Ppl\Hrga\Updates;

use Ppl\Hrga\Models\Division;
use Winter\Storm\Database\Updates\Seeder;

class Dml004SeederDivision extends Seeder
{   
    public function run()
    {
        $cek = Division::find(12);
        if($cek){
            \Log::info('do migration:' . __FILE__);
            \Log::info('migration log:' . __FILE__, ["Record Division 2 exists"]);
            return false;
        }

        $division = Division::insert([
            [
                'id'               => 1,
                'nama_divisi'      => 'SEVP Bisnis',
                'kode_divisi'      => 'SBI'
            ],
            [
                'id'               => 2,
                'nama_divisi'      => 'Pemasaran',
                'kode_divisi'      => 'DPE'
                
            ],
            [
                'id'               => 3,
                'nama_divisi'      => 'Klaim & Subrogasi',
                'kode_divisi'      => 'DKL'
            ],
            [
                'id'               => 4,
                'nama_divisi'      => 'Satuan Pengawas Internal',
                'kode_divisi'      => 'SPI'
            ],
            [
                'id'               => 5,
                'nama_divisi'      => 'Sekretaris Perusahaan',
                'kode_divisi'      => 'SPE'
            ],
            [
                'id'               => 6,
                'nama_divisi'      => 'Coorporate Transformation, Renstra & Kepatuhan',
                'kode_divisi'      => 'DCT'
            ],
            [
                'id'               => 7,
                'nama_divisi'      => 'Teknik Penjaminan',
                'kode_divisi'      => 'DTP'
            ],
            [
                'id'               => 8,
                'nama_divisi'      => 'Penunjang Bisnis',
                'kode_divisi'      => 'DPB'
            ],
            [
                'id'               => 9,
                'nama_divisi'      => 'Koordinator TI',
                'kode_divisi'      => 'KTI'
            ],
            [
                'id'               => 10,
                'nama_divisi'      => 'Keuangan & Akuntansi',
                'kode_divisi'      => 'DKA'
            ],
            [
                'id'               => 11,
                'nama_divisi'      => 'Divisi SDM & Umum',
                'kode_divisi'      => 'DSU'
            ],
            [
                'id'               => 12,
                'nama_divisi'      => 'Manajemen Risiko',
                'kode_divisi'      => 'MRI'
            ],     
        ]);
    }

}