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
        Schema::create('visions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('image_id')->unique()->constrained('images')->onDelete('cascade');
            $table->string('result');
            $table->float('healthy');
            $table->float('black_rot');
            $table->float('esca');
            $table->float('downy_mildew');
            $table->float('powdery_mildew');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visions');
    }
};
