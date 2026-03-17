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
        Schema::create('connection_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('recruiter_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('developer_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->text('message')->nullable();

            $table->enum('status',['pending','accepted','declined'])
                ->default('pending');

            $table->timestamp('responded_at')->nullable();

            $table->timestamps();

            $table->unique(['recruiter_id','developer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('connection_requests');
    }
};
