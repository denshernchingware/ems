<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('employee_code', 30)->unique();
            $table->string('first_name', 80);
            $table->string('last_name', 80);
            $table->enum('gender', ['M', 'F', 'Other']);
            $table->date('date_of_birth');
            $table->string('national_id', 30)->unique();
            $table->string('phone', 20)->nullable();
            $table->string('personal_email', 180)->nullable();
            $table->text('address')->nullable();
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('job_title_id');
            $table->unsignedBigInteger('supervisor_id')->nullable();
            $table->enum('employment_type', ['full_time', 'part_time', 'contract', 'intern']);
            $table->enum('employment_status', ['active', 'on_leave', 'terminated', 'probation'])->default('active');
            $table->date('hire_date');
            $table->date('termination_date')->nullable();
            $table->decimal('basic_salary', 12, 2)->default(0);
            $table->string('avatar', 255)->nullable();
            $table->softDeletes();
            $table->timestamps();

           // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
          //  $table->foreign('department_id')->references('id')->on('departments');
          //  $table->foreign('job_title_id')->references('id')->on('job_titles');
         //   $table->foreign('supervisor_id')->references('id')->on('employees')->onDelete('set null');
            $table->index('department_id');
            $table->index('employment_status');
            $table->index('employee_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};