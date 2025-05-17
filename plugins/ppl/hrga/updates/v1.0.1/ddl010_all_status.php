<?php namespace Ppl\Hrga\Updates;

use Winter\Storm\Database\Updates\Migration;
use Winter\Storm\Support\Facades\Schema;

class Ddl010AllStatus extends Migration
{
    public function up()
    {
        if(Schema::hasTable('status')){
            \Log::info('do migration:' . __FILE__);
            \Log::info('migration log:' . __FILE__, ["table status exists"]);
            return false;
        }
        $log = Schema::create('status', function ($table) {
            $table->increments('id');
            $table->string('nama_status')->index()->nullable(); 
            $table->timestamps();
        });
        \Log::info('do migration:' . __FILE__);
        \Log::info('migration log:' . __FILE__, [$log]);
    }
};
