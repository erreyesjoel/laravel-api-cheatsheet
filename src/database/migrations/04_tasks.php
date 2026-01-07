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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            // Relación con users
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            // Campos principales
            $table->string('title');
            $table->text('description')->nullable();

            // Estado y prioridad, por defecto tarea en pendiente
            $table->enum('status', ['pending', 'in_progress', 'done'])
                  ->default('pending');
            
            $table->enum('priority', ['low', 'medium', 'high'])
                  ->default('medium');
            
            // Fecha límite
            $table->date('due_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
