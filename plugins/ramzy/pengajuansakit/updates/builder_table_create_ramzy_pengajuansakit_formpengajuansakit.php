<?php namespace Ramzy\Pengajuansakit\Updates;

use Winter\Storm\Database\Schema\Blueprint;
use Winter\Storm\Database\Updates\Migration;
use Winter\Storm\Support\Facades\Schema;

return new class extends Migration
{
        public function up()
    {   
        Schema::create('ramzy_pengajuansakit_formpengajuansakit', function(Blueprint $table)
        {
            $table->increments('form_pengajuan_sakit_id');
            $table->integer('user_id')->nullable();
            $table->integer('divisi_id')->nullable();
            $table->integer('list_pengajuan_sakit_id')->nullable();
            $table->string('nama');
            $table->string('no_wa');
            $table->date('tanggal_awal');
            $table->date('tanggal_akhir');
            $table->integer('jumlah_hari');
            $table->text('keterangan_sakit');
            $table->string('surat_dokter_path',255)->nullable();
            $table->timestamps();
        });
    }

public function down()
{
    Schema::dropIfExists('ramzy_pengajuansakit_formpengajuansakit');
}
};