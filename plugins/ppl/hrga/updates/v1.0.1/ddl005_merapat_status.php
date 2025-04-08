<?php namespace Ppl\Hrga\Updates;

use Winter\Storm\Database\Updates\Migration;
use Winter\Storm\Support\Facades\Schema;

class Ddl005MerapatStatus extends Migration
{
    public function up()
    {
        if(Schema::hasTable('merapat_status')){
            \Log::info('do migration:' . __FILE__);
            \Log::info('migration log:' . __FILE__, ["table merapat_status exists"]);
            return false;
        }
        $log = Schema::create('merapat_status', function ($table) {
            $table->increments('id');
            $table->string('nama')->index()->nullable();    
            $table->timestamps();
        });
        \Log::info('do migration:' . __FILE__);
        \Log::info('migration log:' . __FILE__, [$log]);
    }
};
