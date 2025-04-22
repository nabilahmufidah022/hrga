<?php namespace Ppl\Hrga\Components;

use Cms\Classes\ComponentBase;
// use Company\SakitForm\Models\SakitForm;

class FormPengajuanSakit extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Form Pengajuan Sakit',
            'description' => 'Menampilkan daftar pengajuan sakit.'
        ];
    }

    public function onRun()
    {
        $this->page['sakitForms'] = SakitForm::all();
    }
}
