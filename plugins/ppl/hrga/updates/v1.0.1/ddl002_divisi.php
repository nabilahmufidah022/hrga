<?php namespace Ppl\Hrga\Updates;

use Winter\Storm\Database\Updates\Migration;
use Winter\Storm\Support\Facades\Schema;

class Ddl002Divisi extends Migration
{
    public function up()
    {
        if(Schema::hasTable('merapat_divisi')){
            \Log::info('do migration:' . __FILE__);
            \Log::info('migration log:' . __FILE__, ["table merapat_divisi exists"]);
            return false;
        }
        $log = Schema::create('merapat_divisi', function ($table) {
            $table->increments('id');
            $table->string('nama_divisi')->index()->nullable(); 
            $table->string('kode_divisi')->index()->nullable();
            $table->timestamps();
        });
        \Log::info('do migration:' . __FILE__);
        \Log::info('migration log:' . __FILE__, [$log]);
    }
};
