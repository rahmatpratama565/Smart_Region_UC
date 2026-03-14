<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan', function (Blueprint $table) {

            $table->id();

            $table->foreignId('data_wilayah_id')
                  ->constrained('data_wilayah')
                  ->onDelete('cascade');

            $table->date('tanggal_laporan');

            $table->text('ringkasan_laporan');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};