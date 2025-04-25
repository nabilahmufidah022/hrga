<?php namespace Ppl\Hrga\Updates;

use Winter\Storm\Database\Schema\Blueprint;
use Winter\Storm\Database\Updates\Migration;
use Winter\Storm\Support\Facades\Schema;

class Ddl006PengajuanSakitList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('ppl_hrga_list_sicks')){
            \Log::info('do migration:' . __FILE__);
            \Log::info('migration log:' . __FILE__, ["table ppl_hrga_list_sicks exists"]);
            return false;
        }
        $log = Schema::create('ppl_hrga_list_sicks', function ($table) {
            $table->increments('list_pengajuan_sakit_id');
            $table->integer('form_pengajuan_sakit_id')->nullable();
            $table->enum('status_id',['0','1','2'])->default('0');
            $table->date('tanggal_awal');
            $table->date('tanggal_akhir');
            $table->integer('jumlah_hari');
            $table->string('nama');
            $table->timestamps();
        });
        \Log::info('do migration:' . __FILE__);
        \Log::info('migration log:' . __FILE__, [$log]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
