<?php namespace Ppl\Hrga\Updates;

use Winter\Storm\Database\Updates\Migration;
use Winter\Storm\Support\Facades\Schema;

class Ddl016FormAbsensi extends Migration
{
    public function up()
    {
        if(Schema::hasTable('absensi')){
            \Log::info('do migration:' . __FILE__);
            \Log::info('migration log:' . __FILE__, ["table absensi exists"]);
            return false;
        }

        $log = Schema::create('absensi', function ($table) {
            $table->increments('id');
            $table->integer('user_id')->index()->nullable();
            $table->string('unit_kerja')->index()->nullable();
            $table->dateTime('waktu_absen')->nullable();
            $table->string('status_kehadiran')->nullable();
            $table->string('bukti_timestamp')->nullable();
            $table->timestamps();
        });

        \Log::info('do migration:' . __FILE__);
        \Log::info('migration log:' . __FILE__, [$log]);
    }

    public function down()
    {
        Schema::dropIfExists('absensi');
    }
};
