<?php namespace Ppl\Hrga\Updates;

use Winter\Storm\Database\Updates\Migration;
use Winter\Storm\Support\Facades\Schema;

class Ddl008Jabatan extends Migration
{
    public function up()
    {
        if(Schema::hasTable('merapat_jabatan')){
            \Log::info('do migration:' . __FILE__);
            \Log::info('migration log:' . __FILE__, ["table merapat_jabatan exists"]);
            return false;
        }
        $log = Schema::create('merapat_jabatan', function ($table) {
            $table->increments('id');
            $table->string('nama_jabatan')->index()->nullable(); 
            $table->timestamps();
        });
        \Log::info('do migration:' . __FILE__);
        \Log::info('migration log:' . __FILE__, [$log]);
    }
};
