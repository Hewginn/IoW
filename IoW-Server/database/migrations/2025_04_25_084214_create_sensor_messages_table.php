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
        Schema::create('sensor_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sensor_id')->constrained('sensors');
            $table->float('value');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->string('error_message')->nullable();
            $table->string('value_type');
            $table->string('unit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensor_messages');
    }
};
