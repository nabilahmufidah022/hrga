<?php namespace Ppl\Hrga\Updates;

use Winter\Storm\Database\Updates\Migration;
use Winter\Storm\Support\Facades\Schema;

class Ddl006MerapatIzinorderForm extends Migration
{
    public function up()
    {
        if(Schema::hasTable('merapat_izinorder_form')){
            \Log::info('do migration:' . __FILE__);
            \Log::info('migration log:' . __FILE__, ["table merapat_izinorder_form exists"]);
            return false; 
        }

        $log = Schema::create('merapat_izinorder_form', function ($table) {
            $table->increments('id');
            $table->integer('backend_user_id')->index()->nullable();
            $table->integer('izinlist_id')->index()->nullable(); 
            $table->string('no_wa')->index()->nullable(); 
            $table->string('divisi_id')->index()->nullable(); 
            $table->dateTime('tanggal_awal')->index()->nullable(); 
            $table->dateTime('tanggal_akhir')->index()->nullable();
            $table->integer('jumlah_rencana_izin')->index()->nullable();
            $table->string('keterangan_izin')->index()->nullable();
            $table->string('jenis_izin')->index()->nullable();
            $table->string('file_pendukung')->index()->nullable();
            $table->integer('flag_status')->index()->nullable();
            $table->string('alasan_tolak')->index()->nullable();
            $table->timestamps();
        });

        \Log::info('do migration:' . __FILE__);
        \Log::info('migration log:' . __FILE__, [$log]);
    }

};
