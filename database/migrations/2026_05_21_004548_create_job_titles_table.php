<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_titles', function (Blueprint $table) {
            $table->id();
            $table->string('title', 120);
            $table->unsignedBigInteger('department_id');
            $table->tinyInteger('level')->default(1);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->index('department_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_titles');
    }
};