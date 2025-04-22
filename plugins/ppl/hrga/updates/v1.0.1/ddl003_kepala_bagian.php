<?php namespace Ppl\Hrga\Updates;

use Winter\Storm\Database\Updates\Migration;
use Winter\Storm\Support\Facades\Schema;

class Ddl003KepalaBagian extends Migration
{
    public function up()
    {
        if(Schema::hasTable('merapat_kepala_bagian')){
            \Log::info('do migration:' . __FILE__);
            \Log::info('migration log:' . __FILE__, ["table merapat_kepala_bagian exists"]);
            return false;
        }
        $log = Schema::create('merapat_kepala_bagian', function ($table) {
            $table->increments('id');
            $table->string('nama_kabag')->index()->nullable(); 
            $table->timestamps();
        });

        \Log::info('do migration:' . __FILE__);
        \Log::info('migration log:' . __FILE__, [$log]);
    }
};
