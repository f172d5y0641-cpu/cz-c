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
        Schema::create('bapp', function (Blueprint $table) {
            $table->bigIncrements('id_bapp');
            $table->unsignedBigInteger('id_ba')->index('bapp_id_ba_foreign');
            $table->text('uraian_pekerjaan');
            $table->string('spesifikasi_volume')->nullable();
            $table->string('status_pekerjaan')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bapp');
    }
};
