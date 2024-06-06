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
          $table->string('title');
          $table->text('description')->nullable();
          $table->timestamp('due_date')->nullable();
          $table->string('status')->default("TODO");
          $table->unsignedBigInteger('parent_id')->nullable();
          $table->unsignedBigInteger('created_by');
          $table->unsignedBigInteger('assigned_to')->nullable();
          $table->foreign('assigned_to')->references('id')->on('users');
          $table->foreign('parent_id')->references('id')->on('tasks');
          $table->foreign('created_by')->references('id')->on('users');
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
