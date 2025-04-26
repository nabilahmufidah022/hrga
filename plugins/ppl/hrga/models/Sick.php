<?php

namespace Ppl\Hrga\Models;

use Winter\Storm\Database\Model;
use Ppl\Hrga\Models\SickList;

/**
 * sick Model
 */
class Sick extends Model
{
    use \Winter\Storm\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'ppl_hrga_sicks';
    public $primaryKey = 'form_pengajuan_sakit_id';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = [];

    /**
     * @var array Attributes to be appended to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array Attributes to be removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
        'list' => [
            'Ppl\Hrga\Models\SickList',
            'key'      => 'form_pengajuan_sakit_id',   // foreign key in SickList
            'localKey' => 'form_pengajuan_sakit_id'
        ]
    ];
    public $hasOneThrough = [];
    public $hasManyThrough = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'surat_dokter_path' => 'System\Models\File'
    ];
    public $attachMany = [];

    public function getSuratDokterPathUrlAttribute()
    {
        if ($this->surat_dokter_path) {
            return $this->surat_dokter_path->getPath(); // Or use getUrl() for public URL
        }
        return null;
    }
    
    public function afterSave()
{
    // Automatically create a log entry when a product is created
    $list = new SickList;
    $list->form_pengajuan_sakit_id = $this->form_pengajuan_sakit_id;
    $list->tanggal_awal = $this->tanggal_awal;
    $list->tanggal_akhir = $this->tanggal_akhir;
    $list->jumlah_hari = $this->jumlah_hari;
    $list->nama = $this->nama;
    $list->save();
}
public function getJumlahHariListAttribute()
{
    // kalau relasinya belum di-load, load dulu biar aman
    $this->load('list');

    // ambil semua jumlah_hari di relasi SickList lalu gabungkan dengan koma
    return $this->list->pluck('jumlah_hari')->implode(', ');
}

public function getStatusListAttribute()
{
    $this->load('list');
    // If list exists, pluck the status_id from SickList relation
    if ($this->list && $this->list->isNotEmpty()) {
        return $this->list->pluck('status_id')->implode(', '); // Concatenate all status_id if there's more than one
    }
    return 'No Status'; // Default message if no status is found
}


}
