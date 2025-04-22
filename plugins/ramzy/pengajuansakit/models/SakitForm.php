<?php namespace Ramzy\Pengajuansakit\Models;

use Winter\Storm\Database\Model;

/**
 * Model
 */
class SakitForm extends Model
{
    use \Winter\Storm\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    // public $timestamps = false;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'ramzy_pengajuansakit_formpengajuansakit';
    protected $fillable = [
        'nama',
        'no_wa',
        'tanggal_awal',
        'tanggal_akhir',
        'divisi_id',
        'jumlah_hari',
        'keterangan_sakit',
        'surat_dokter'
    ];
    public $attachOne = [
        'surat_dokter' => ['System\Models\File']
    ];
    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    // public $attachOne = [
    //     'surat_dokter' => \System\Models\File::class
    // ];
    
}
