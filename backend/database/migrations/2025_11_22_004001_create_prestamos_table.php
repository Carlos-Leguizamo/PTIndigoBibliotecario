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
       Schema::create('prestamos', function (Blueprint $table) {
         $table->uuid('id')->primary();
         $table->string('isbn');
         $table->string('identificacionUsuario', 10);
         $table->unsignedTinyInteger('tipoUsuario');
         $table->date('fechaMaximaDevolucion');
         $table->timestamps();
       });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};
