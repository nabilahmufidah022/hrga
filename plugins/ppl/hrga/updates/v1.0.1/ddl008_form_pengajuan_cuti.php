<?php namespace Ppl\Hrga\Updates;

use Winter\Storm\Database\Updates\Migration;
use Winter\Storm\Support\Facades\Schema;

class Ddl008FormPengajuanCuti extends Migration
{
    public function up()
    {
        if(Schema::hasTable('form_pengajuan_cuti')){
            \Log::info('do migration:' . __FILE__);
            \Log::info('migration log:' . __FILE__, ["table merapat_roomorder_form exists"]);
            return false; 
        }

        $log = Schema::create('form_pengajuan_cuti', function ($table) {
            $table->increments('id');
            $table->integer('user_id')->index()->nullable();
            $table->integer('divisi_id')->index()->nullable(); 
            $table->string('nama')->index()->nullable(); 
            $table->integer('no_wa')->index()->nullable(); 
            $table->dateTime('tanggal_awal')->index()->nullable(); 
            $table->dateTime('tanggal_akhir')->index()->nullable();
            $table->integer('jumlah_rencana_cuti')->index()->nullable();
            $table->string('jenis_cuti')->index()->nullable();
            $table->timestamps();
        });

        \Log::info('do migration:' . __FILE__);
        \Log::info('migration log:' . __FILE__, [$log]);
    }

};

