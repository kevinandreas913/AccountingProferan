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
        Schema::create('master_akun', function (Blueprint $table) {
            $table->uuid('id')->primary()->nullable(false);
            $table->uuid('user_id')->nullable(false);
            $table->string('nama');
            $table->integer('nomor_akun');
            $table->enum('saldo_normal', array('debit', 'kredit'));
            $table->string('jenis_akun_id')->nullable(false);
            $table->integer('nominal');
            $table->string('periode_bulan');
            $table->string('periode_tahun');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('jenis_akun_id')->references('id')->on('master_jenis_akun');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_akun');
    }
};
