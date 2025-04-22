<?php

use Winter\Storm\Database\Schema\Blueprint;
use Winter\Storm\Database\Updates\Migration;
use Winter\Storm\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ramzy_pengajuansakit_listpengajuansakit', function(Blueprint $table)
        {
            $table->increments('list_pengajuan_sakit_id');
            $table->integer('form_pengajuan_sakit_id')->nullable();
            $table->enum('status_id',['0','1','2'])->default('0');
            $table->date('tanggal_awal');
            $table->date('tanggal_akhir');
            $table->integer('jumlah_hari');
            $table->string('nama');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ramzy_pengajuansakit_listpengajuansakit');
    }
};
