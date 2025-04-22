<?php namespace Ppl\Hrga\Updates;

use Winter\Storm\Database\Updates\Migration;
use Winter\Storm\Support\Facades\Schema;

class Ddl004MerapatRoomorderForm extends Migration
{
    public function up()
    {
        if(Schema::hasTable('merapat_roomorder_form')){
            \Log::info('do migration:' . __FILE__);
            \Log::info('migration log:' . __FILE__, ["table merapat_roomorder_form exists"]);
            return false; 
        }

        $log = Schema::create('merapat_roomorder_form', function ($table) {
            $table->increments('id');
            $table->integer('backend_user_id')->index()->nullable();
            $table->integer('meetingroomlist_id')->index()->nullable(); 
            $table->string('nama')->index()->nullable(); 
            $table->string('no_wa')->index()->nullable(); 
            $table->integer('divisi_id')->index()->nullable(); 
            $table->dateTime('tanggal_awal')->index()->nullable(); 
            $table->dateTime('tanggal_akhir')->index()->nullable();
            $table->integer('jumlah_peserta')->index()->nullable();
            $table->string('jenis_rapat')->index()->nullable();
            $table->string('agenda_rapat')->index()->nullable();
            $table->string('upload_undangan')->index()->nullable();
            $table->string('nama_peserta_rapat')->index()->nullable();
            $table->string('nama_mitra')->index()->nullable();
            $table->string('no_wa_mitra')->index()->nullable();
            $table->integer('flaq_status')->index()->nullable();
            $table->integer('flag_attendance')->index()->nullable();
            $table->string('alasan_tolak')->index()->nullable();
            $table->string('saran')->index()->nullable();
            $table->string('file_kehadiran')->index()->nullable();
            $table->string('link_kehadiran')->index()->nullable();
            $table->integer('flag_notif1')->index()->nullable();
            $table->integer('flag_notif2')->index()->nullable();
            $table->integer('flag_notif_adm')->index()->nullable();
            $table->timestamps();
        });

        \Log::info('do migration:' . __FILE__);
        \Log::info('migration log:' . __FILE__, [$log]);
    }

};
