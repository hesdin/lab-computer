<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slip', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_mahasiswa');
            $table->foreignId('id_matakuliah');
            $table->string('slip');
            $table->integer('nominal');
            $table->date('tanggal_bayar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slip');
    }
}
