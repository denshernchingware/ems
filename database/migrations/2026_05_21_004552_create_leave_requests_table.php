<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
           // $table->unsignedBigInteger('employee_id');
           // $table->unsignedBigInteger('leave_type_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->tinyInteger('days_requested')->unsigned();
            $table->text('reason')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled'])->default('pending');
            //$table->unsignedBigInteger('reviewed_by')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->text('reviewer_comment')->nullable();
            $table->string('document_path', 255)->nullable();
            $table->timestamps();

            // $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreignId('employee_id')
                ->constrained('employees')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('leave_type_id')
                ->constrained('leave_types')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('reviewed_by')
                ->constrained('users')
                ->onUpdate('cascade')
                ->nullOnDelete()
                ->onDelete('cascade');
            // $table->foreign('leave_type_id')->references('id')->on('leave_types');
            // $table->foreign('reviewed_by')->references('id')->on('users')->onDelete('set null');
            $table->index(['employee_id', 'status']);
            $table->index('start_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};