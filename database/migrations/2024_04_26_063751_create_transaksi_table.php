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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->uuid('id')->primary()->nullable(false);
            $table->uuid('user_id')->nullable(false);
            $table->date('tgl');
            $table->integer('nomor_akun_debit');
            $table->integer('nominal_debit');
            $table->integer('nomor_akun_kredit');
            $table->integer('nominal_kredit');
            $table->text('keterangan');
            $table->string('type');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
