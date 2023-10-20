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
        Schema::create('pemohon', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('no_kk')->unique();
            $table->string('nama', 160);
            $table->bigInteger('nik')->unique();
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan'])->default('laki-laki');
            $table->text('alamat');
            $table->string('no_telp', 15);
            $table->integer('tahun_daftar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemohon');
    }
};
