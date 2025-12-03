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
        if (Schema::hasTable('approval')) {
            return;
        }

        Schema::create('approval', function (Blueprint $table) {
            $table->bigIncrements('id_approval');
            $table->unsignedBigInteger('id_ba')->index('approval_id_ba_foreign');
            $table->unsignedBigInteger('id_users')->index('approval_id_users_foreign');
            $table->string('status');
            $table->dateTime('tanggal_approval')->nullable();
            $table->text('catatan')->nullable();
            $table->string('tanda_tangan')->nullable();
            $table->string('file_dokumen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approval');
    }
};
