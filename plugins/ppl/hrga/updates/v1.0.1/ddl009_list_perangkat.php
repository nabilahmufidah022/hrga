<?php namespace Ppl\Hrga\Updates;

use Winter\Storm\Database\Updates\Migration;
use Winter\Storm\Support\Facades\Schema;

class Ddl009ListPerangkat extends Migration
{
    public function up()
    {
        if(Schema::hasTable('list_perangkat')){
            \Log::info('do migration:' . __FILE__);
            \Log::info('migration log:' . __FILE__, ["table merapat_status exists"]);
            return false;
        }
        $log = Schema::create('list_perangkat', function ($table) {
            $table->increments('id');
            $table->string('nama_perangkat')->index()->nullable(); 
            $table->timestamps();
        });
        \Log::info('do migration:' . __FILE__);
        \Log::info('migration log:' . __FILE__, [$log]);
    }
};
