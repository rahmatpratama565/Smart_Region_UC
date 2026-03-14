<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

Schema::create('data_wilayah', function (Blueprint $table) {

$table->id();

$table->foreignId('user_id')
      ->constrained('users')
      ->onDelete('cascade');

$table->string('nama_wilayah');

$table->string('jenis_data');

$table->integer('target');

$table->integer('nilai_data');

$table->integer('progress')->default(0);

$table->text('kendala')->nullable();

$table->date('tanggal_input');

$table->json('foto_dokumentasi')->nullable();

$table->enum('status_validasi',['pending','valid','ditolak'])
      ->default('pending');

$table->foreignId('validated_by')
      ->nullable()
      ->constrained('users')
      ->onDelete('set null');

$table->timestamps();

});

    }

    public function down(): void
    {
        Schema::dropIfExists('data_wilayah');
    }
};