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
        Schema::disableForeignKeyConstraints();
        Schema::create('ordenes', function (Blueprint $table) {
            $table->id();
            $table->string('numero_orden')->unique();
            $table->foreignId('proveedor_id')->constrained('proveedores');
            $table->date('fecha_orden');
            $table->date('fecha_entrega')->nullable();
            $table->decimal('total', 10, 2)->default(0);
            $table->enum('estado', ['pendiente', 'recibida', 'cancelada'])->default('pendiente');
            $table->text('observaciones')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenes');
    }
};
