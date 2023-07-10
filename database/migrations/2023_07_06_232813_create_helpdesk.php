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
        Schema::create('helpdesk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_user_id')->nullable()->constrained('form_user')->onUpdate('SET NULL');
            $table->foreignId('form_system_id')->nullable()->constrained('form_system')->onUpdate('SET NULL');
            $table->foreignId('form_service_id')->nullable()->constrained('form_service')->onUpdate('SET NULL');
            $table->foreignId('form_status_id')->nullable()->constrained('form_status')->onUpdate('SET NULL');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('helpdesk');
    }
};