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
        Schema::create('analytics_events', function (Blueprint $table) {
            $table->id();

            $table->foreignId('portfolio_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('event_type');

            $table->string('referrer')->nullable();
            $table->string('country_code')->nullable();

            $table->timestamp('created_at')->useCurrent();


            $table->index(['portfolio_id','created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analytics_events');
    }
};
