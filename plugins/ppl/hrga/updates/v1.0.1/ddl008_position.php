<?php namespace Ppl\Hrga\Updates;

use Winter\Storm\Database\Updates\Migration;
use Winter\Storm\Support\Facades\Schema;

class Ddl008Position extends Migration
{
    public function up()
    {
        if(Schema::hasTable('jabatan')){
            \Log::info('do migration:' . __FILE__);
            \Log::info('migration log:' . __FILE__, ["table jabatan exists"]);
            return false;
        }
        $log = Schema::create('jabatan', function ($table) {
            $table->increments('id');
            $table->string('nama_jabatan')->index()->nullable(); 
            $table->timestamps();
        });
        \Log::info('do migration:' . __FILE__);
        \Log::info('migration log:' . __FILE__, [$log]);
    }
};
