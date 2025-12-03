<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bapb', function (Blueprint $table) {
            $table->bigIncrements('id_bapb');
            $table->unsignedBigInteger('id_ba')->index('bapb_id_ba_foreign');
            $table->string('nama_barang');
            $table->string('merk_type')->nullable();
            $table->integer('jumlah')->default(1);
            $table->string('kondisi')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bapb');
    }
};
