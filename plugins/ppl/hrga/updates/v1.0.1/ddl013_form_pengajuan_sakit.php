<?php namespace Ppl\Hrga\Updates;

use Winter\Storm\Database\Schema\Blueprint;
use Winter\Storm\Database\Updates\Migration;
use Winter\Storm\Support\Facades\Schema;

class Ddl013FormPengajuanSakit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('ppl_hrga_sicks')){
            \Log::info('do migration:' . __FILE__);
            \Log::info('migration log:' . __FILE__, ["table ppl_hrga_sicks exists"]);
            return false;
        }
        $log = Schema::create('ppl_hrga_sicks', function ($table) {
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
        \Log::info('do migration:' . __FILE__);
        \Log::info('migration log:' . __FILE__, [$log]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
