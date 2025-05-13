<?php namespace Ppl\Hrga\Updates;

use Winter\Storm\Database\Updates\Migration;
use Winter\Storm\Support\Facades\Schema;

class Ddl011DeviceForm extends Migration
{
    public function up()
    {
        if(Schema::hasTable('device_form')){
            \Log::info('do migration:' . __FILE__);
            \Log::info('migration log:' . __FILE__, ["table device_form exists"]);
            return false; 
        }

        $log = Schema::create('device_form', function ($table) {
            $table->increments('id');
            $table->integer('backend_user_id')->index()->nullable();
            $table->integer('device_id')->index()->nullable(); 
            $table->integer('divisi_id')->index()->nullable(); 
            $table->string('no_wa')->index()->nullable(); 
            $table->dateTime('tanggal_awal')->index()->nullable(); 
            $table->dateTime('tanggal_akhir')->index()->nullable();
            $table->integer('jumlah_perangkat')->index()->nullable();
            $table->string('keperluan')->index()->nullable();
            $table->integer('flag_status')->index()->nullable();
            $table->integer('flag_attendance')->index()->nullable();
            $table->string('alasan_tolak')->index()->nullable();
            $table->string('file_tanda_terima')->index()->nullable();
            $table->timestamps();
        });

        \Log::info('do migration:' . __FILE__);
        \Log::info('migration log:' . __FILE__, [$log]);
    }

};
