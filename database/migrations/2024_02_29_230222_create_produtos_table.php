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
        Schema::create('produtos', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Define o campo `id` como UUID e chave primária
            $table->string('name');
            $table->string('categoria');
            $table->text('descricao');
            $table->decimal('preco', 8, 2); // Considerando 8 dígitos no total e 2 dígitos após a vírgula
            $table->integer('tempoPreparo');
            $table->timestamps(); // Cria campos created_at e updated_at automaticamente
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
