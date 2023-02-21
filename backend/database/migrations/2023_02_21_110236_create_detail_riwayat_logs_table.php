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
        Schema::create('detail_riwayat_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            // $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('id_log');
            // $table->foreignId('log_id')->constrained('jenis_logs')->onUpdate('cascade')->onDelete('cascade');

            $table->string('catatan');
            $table->time('jam');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_riwayat_logs');
    }
};
