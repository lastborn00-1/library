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
            $table->string('title');
            $table->text('abstract')->nullable();
            $table->string('keywords')->nullable();
            $table->string('department_name')->nullable();
            $table->string('academic_session')->nullable();
            $table->string('supervisor_name')->nullable();
            $table->string('project_type')->nullable();
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->boolean('nerd_uploaded')->default(false);
            $table->string('nerd_reference')->nullable();
            $table->date('submission_date')->nullable();
            $table->date('approval_date')->nullable();
            $table->string('visibility')->default('public'); // public, internal, private
            $table->string('cover_image')->nullable();
            $table->string('pdf_path');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
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
