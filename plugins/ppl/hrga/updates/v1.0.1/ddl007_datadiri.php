<?php namespace Ppl\Hrga\Updates;

use Winter\Storm\Database\Updates\Migration;
use Winter\Storm\Support\Facades\Schema;

class Ddl007Datadiri extends Migration
{
    public function up()
    {
        if(Schema::hasTable('datadiri')){
            \Log::info('do migration:' . __FILE__);
            \Log::info('migration log:' . __FILE__, ["table datadiri exists"]);
            return false;
        }
        $log = Schema::create('datadiri', function ($table) {
            $table->increments('id');
            $table->string('nama')->index()->nullable(); 
            $table->integer('divisi_id')->index()->nullable(); 
            $table->string('jabatan_id')->index()->nullable(); 
            $table->string('status_karyawan')->index()->nullable();
            $table->string('nomor_idcard')->index()->nullable();
            $table->dateTime('tanggal_bergabung')->index()->nullable();
            $table->string('no_wa')->index()->nullable(); 
            $table->timestamps();
        });
        \Log::info('do migration:' . __FILE__);
        \Log::info('migration log:' . __FILE__, [$log]);
    }
};
