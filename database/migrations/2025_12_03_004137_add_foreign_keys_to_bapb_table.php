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
        Schema::table('bapb', function (Blueprint $table) {
            $table->foreign(['id_ba'])->references(['id_ba'])->on('dokumen_ba')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bapb', function (Blueprint $table) {
            $table->dropForeign('bapb_id_ba_foreign');
        });
    }
};
