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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id()->primary()->autoIncrement();
            $table->integer('tempoTotal')->nullable();
            $table->string('status', 25);
            $table->string('idCliente');
            $table->decimal('precoTotal', 8, 2); // Considerando 8 dígitos no total e 2 dígitos após a vírgula
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
