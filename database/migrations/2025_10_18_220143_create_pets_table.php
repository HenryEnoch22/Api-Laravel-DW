<?php

use App\Models\User;
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
        Schema::create('pets', function (Blueprint $table) {
            $table->id();

            // Dueño/cliente (usuario del sistema)
            $table->foreignIdFor(User::class, 'owner_id')
                ->constrained(table: 'users')
                ->cascadeOnDelete();

            // Identificación básica
            $table->string('name', 80);
            $table->enum('species', ['dog','cat','rabbit','bird','reptile','rodent','other'])->index();
            $table->string('breed', 120)->nullable();
            $table->enum('sex', ['male','female','unknown'])->default('unknown');
            $table->enum('size', ['toy','small','medium','large','giant'])->nullable(); // útil para jaulas, paseos, etc.
            $table->string('color', 80)->nullable();
            $table->date('birth_date')->nullable();
            $table->decimal('weight_kg', 5, 2)->nullable(); // 999.99 máx
            $table->boolean('sterilized')->default(false);


            // Documentos/medios
            $table->string('photo_path')->nullable();      // storage path a imagen principal

            // Operación de guardería
            $table->enum('status', ['active','inactive','banned'])->default('active')->index();
            $table->date('admission_date')->nullable();    // cuándo se registró por 1a vez
            $table->timestamp('last_visit_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
