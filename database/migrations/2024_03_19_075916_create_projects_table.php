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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date');
            $table->string('house_code')->unique();
            $table->unsignedBigInteger('house_id')->unique();
            $table->string('client');
            $table->string('email');
            $table->string('phone');
            $table->string('sales');
            $table->string('installer')->nullable();
            $table->string('address');
            $table->integer('amounts')->nullable();
            $table->integer('progress')->default(0)->nullable();
            $table->boolean('completed')->default(false)->nullable();
            $table->integer('client_satisfaction')->default(0)->nullable();
            $table->string('notes')->nullable();
            $table->integer('zs2')->nullable();
            $table->integer('ffu')->nullable();
            $table->integer('zef')->nullable();
            $table->integer('zrh')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
