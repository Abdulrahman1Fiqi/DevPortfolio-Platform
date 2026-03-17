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
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();

            $table->foreignId('portfolio_id')
              ->constrained()
              ->cascadeOnDelete();

            $table->string('submitter_name');
            $table->string('submitter_role')->nullable();
            $table->string('company')->nullable();
            $table->text('message');

            $table->tinyInteger('rating')->nullable();

            $table->boolean('is_approved')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
