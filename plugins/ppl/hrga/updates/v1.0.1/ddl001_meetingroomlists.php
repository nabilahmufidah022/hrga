<?php namespace Ppl\Hgra\Updates;

use Winter\Storm\Database\Updates\Migration;
use Winter\Storm\Support\Facades\Schema;


class Ddl001MeetingRoomList extends Migration
{
    public function up()
    {
        if(Schema::hasTable('merapat_meetingroomlists')){
            \Log::info('do migration:' . __FILE__);
            \Log::info('migration log:' . __FILE__, ["table merapat_meetingroomlists exists"]);
            return false;
        }
        $log = Schema::create('merapat_meetingroomlists', function ($table) {
            $table->increments('id');
            $table->string('room_name')->index()->nullable(); 
            $table->integer('room_capacity')->index()->nullable();
            $table->text('room_facility')->nullable();
            $table->timestamps();
        });

        \Log::info('do migration:' . __FILE__);
        \Log::info('migration log:' . __FILE__, [$log]);
    }

}
