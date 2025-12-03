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
        if (Schema::hasTable('notifikasi')) {
            return;
        }

        Schema::create('notifikasi', function (Blueprint $table) {
            $table->bigIncrements('id_notifikasi');
            $table->unsignedBigInteger('id_ba')->index('notifikasi_id_ba_foreign');
            $table->unsignedBigInteger('id_users')->index('notifikasi_id_users_foreign');
            $table->string('pesan');
            $table->boolean('status_baca')->default(false);
            $table->dateTime('waktu_kirim')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
