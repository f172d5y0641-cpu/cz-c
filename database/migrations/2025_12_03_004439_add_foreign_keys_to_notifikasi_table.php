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
        Schema::table('notifikasi', function (Blueprint $table) {
            $table->foreign(['id_ba'])->references(['id_ba'])->on('dokumen_ba')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['id_users'])->references(['id'])->on('users')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifikasi', function (Blueprint $table) {
            $table->dropForeign('notifikasi_id_ba_foreign');
            $table->dropForeign('notifikasi_id_users_foreign');
        });
    }
};
