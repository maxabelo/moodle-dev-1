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
        Schema::create('followers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // como no existe 1 Tabla para Follower, necesitamos especificar el constarain a users, para q Laravel relaciones este follower_id con el id del user
              // eto xq no existe la tabla, sino seria como con user, solo especificas el user_id y laravel detecta la migracion y demas, y ya sabe q debe apuntar al id de la tabla users
            $table->foreignId('follower_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('followers');
    }
};
