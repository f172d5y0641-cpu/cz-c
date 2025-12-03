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
        Schema::create('dokumen_ba', function (Blueprint $table) {
            $table->bigIncrements('id_ba');
            $table->unsignedBigInteger('id_users')->index('dokumen_ba_id_users_foreign');
            $table->string('nama_vendor')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('perusahaan')->nullable();
            $table->text('alamat')->nullable();
            $table->string('nomor_kontrak')->nullable();
            $table->enum('jenis_dokumen', ['BAPB', 'BAPP']);
            $table->text('deskripsi_pekerjaan');
            $table->decimal('nilai_pekerjaan', 15);
            $table->enum('status', ['pending', 'submitted', 'accepted', 'rejected'])->default('pending');
            $table->string('file_dokumen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_ba');
    }
};
