<?php

use App\Models\FormSystem;
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
        Schema::create('form_system', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        $formSystem = [
            ['name' => 'Atlas'],
            ['name' => 'Sinet'],
            ['name' => 'Profaixa'],
            ['name' => 'SGPRO'],
            ['name' => 'Ecossistema'],
            ['name' => 'TR Nacional'],
            ['name' => 'DPP'],
        ];

        foreach ($formSystem as $system) {
            FormSystem::create($system);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_system');
    }
};