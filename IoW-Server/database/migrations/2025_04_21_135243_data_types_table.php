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
        Schema::create('data_types', function (Blueprint $table) {
            $table->id();
            $table->string('data_type')->unique();
            $table->text('image_path');
            $table->string('unit');
            $table->float('max');
            $table->enum('aggregate_by', ['avg', 'sum', 'max', 'min', 'median', 'mode', 'count'])->nullable();
            $table->unsignedSmallInteger('aggregate_interval')->nullable();
            $table->enum('diagram_type', ['line', 'bar'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_types');
    }
};
