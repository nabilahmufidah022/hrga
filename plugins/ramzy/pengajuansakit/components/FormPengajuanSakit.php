<?php namespace ramzy\pengajuansakit\Components;

use Cms\Classes\ComponentBase;
use ramzy\pengajuansakit\Models\SakitForm;
use ramzy\pengajuansakit\Models\Listform;
use System\Models\File;
use Input;
use Log;

class FormPengajuanSakit extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Form Pengajuan Sakit',
            'description' => 'Menampilkan daftar pengajuan sakit.'
        ];
    }

    public function onSubmitSakitForm()
{
    Log::info('FormPengajuanSakit::onSubmitSakitForm triggered'); // 👈 Log to debug
    $data = post();
    $file = Input::file('surat_dokter');

    $model = new SakitForm();

    $model->nama = $data['nama'];
    $model->no_wa = $data['nomor_whatsapp'];
    $model->divisi_id = $data['unit_kerja'];
    $model->tanggal_awal = $data['tanggal_awal'];
    $model->tanggal_akhir = $data['tanggal_akhir'];
    $model->jumlah_hari = $data['jumlah_hari'];
    $model->keterangan_sakit = $data['keterangan_sakit'];

    if ($file && $file->isValid()) {
        // Save to system_files
        $uploadedFile = new File();
        $uploadedFile->data = $file;
        $uploadedFile->save();

        // Attach to model
        $model->surat_dokter = $uploadedFile;

        // Store the public path manually
        $model->surat_dokter_path = $uploadedFile->getPath();
    }

    $model->save();
    
        // $image = var_dump($data['surat_dokter']);
        // $file = Input::file($data['surat_dokter']);
        
        // if (Input::hasFile($file)) {
    //     $pesan = '<p class="text-green-600 font-semibold">Image berhasil disimpan!</p>';
    // }else{
        //     $pesan = '<p class="text-green-600 font-semibold">Image gagal disimpan!</p>';
        // }
        

    Listform::create([
        'status_id' => '0',
        'tanggal_awal' => $data['tanggal_awal'],
        'tanggal_akhir' => $data['tanggal_akhir'],
        'jumlah_hari' => $data['jumlah_hari'],
        'nama' => $data['nama']
        ]);
        
        Log::info('POST data: ', $data); // 👈 log post data
    // handle uploaded file
    // if (Input::hasFile('surat_dokter')) {
    //     SakitForm::create([
    //         'surat_dokter' => Input::file('surat_dokter')
    //     ])
    // };


    return ['#form-sukses' => '<p class="text-green-600 font-semibold">Form berhasil disimpan!</p>'];
}

    public function onRun()
    {
        $this->page['datas'] = \ramzy\pengajuansakit\Models\Listform::orderBy('nama', 'asc')->get();
    }

}
