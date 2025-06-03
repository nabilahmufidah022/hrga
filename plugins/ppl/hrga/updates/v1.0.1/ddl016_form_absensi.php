<?php namespace Ppl\Hrga\Updates;

use Winter\Storm\Database\Updates\Migration;
use Winter\Storm\Support\Facades\Schema;
use Winter\Storm\Database\Schema\Blueprint;

class Ddl016FormAbsensi extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('absensi')) {
            Schema::create('absensi', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned()->index();
                $table->string('nama')->nullable(); // Made nullable
                $table->string('unit_kerja')->nullable();
                $table->dateTime('waktu_absen')->nullable();
                $table->string('status_kehadiran')->nullable();
                $table->string('bukti_timestamp')->nullable();
                $table->string('bukti_kehadiran')->nullable();
                $table->timestamps();

                $table->foreign('user_id')
                      ->references('id')
                      ->on('backend_users')
                      ->onDelete('cascade');
            });
            
            \Log::info('Created absensi table with updated columns');
        } else {
            Schema::table('absensi', function (Blueprint $table) {
                // Remove old columns if they exist
                $columns = [
                    'buktikehadiran',
                    'image',
                    'searchable',
                    'sortable'
                ];

                foreach ($columns as $column) {
                    if (Schema::hasColumn('absensi', $column)) {
                        $table->dropColumn($column);
                    }
                }
                
                // Make nama nullable if it exists
                if (Schema::hasColumn('absensi', 'nama')) {
                    $table->string('nama')->nullable()->change();
                }
            });
            
            \Log::info('Updated absensi table columns');
        }
    }

    public function down()
    {
        Schema::dropIfExists('absensi');
    }
}