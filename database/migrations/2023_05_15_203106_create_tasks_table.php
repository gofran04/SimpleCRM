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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->foreignId('assigned_user')->references('id')->on('users');
            $table->foreignId('assigned_project')->references('id')->on('projects');
            $table->dateTime('started_at')->nullable();
            $table->dateTime('closed_at')->nullable();
            $table->set('status', ['new', 'process', 'closed', 'approved'])->default('new');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
