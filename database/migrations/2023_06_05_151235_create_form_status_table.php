<?php

use App\Models\FormStatus;
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
        Schema::create('form_status', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        
        $formStatus = [
            ['name' => 'Aberto'],
            ['name' => 'Em Andamento'],
            ['name' => 'Resolvido'],
            ['name' => 'Finalizado'],
        ];

        foreach ($formStatus as $status) {
            FormStatus::create($status);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_status');
    }
};