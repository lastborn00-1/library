<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add database indexes for long-term scalability.
     * Supports 100,000+ students and 20,000+ projects over 10 years.
     */
    public function up(): void
    {
        // --- Projects table ---
        Schema::table('projects', function (Blueprint $table) {
            $table->index('status');                           // filter approved/pending
            $table->index('department_name');                  // filter by department
            $table->index('academic_session');                 // filter by year
            $table->index('visibility');                       // filter public projects
            $table->index('created_at');                       // sort by newest
            $table->fullText(['title', 'abstract', 'keywords']); // fast text search
        });

        // --- Project Authors table ---
        Schema::table('project_authors', function (Blueprint $table) {
            $table->index('project_id');                       // join to projects
            $table->index('matric_number');                    // search by matric no
            $table->index('student_name');                     // search by name
        });

        // --- Transactions table ---
        Schema::table('transactions', function (Blueprint $table) {
            $table->index('student_id');                       // student borrow history
            $table->index('book_id');                          // book borrow history
            $table->index('status');                           // filter by status
            $table->index('due_date');                         // find overdue books
        });

        // --- Students table ---
        Schema::table('students', function (Blueprint $table) {
            $table->index('name');                             // search by name
            $table->index('department');                       // filter by dept
        });

        // --- Books table ---
        Schema::table('books', function (Blueprint $table) {
            $table->index('category');                         // filter by category
            $table->index('book_type');                        // physical vs digital
            $table->index('available_quantity');               // find available books
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['department_name']);
            $table->dropIndex(['academic_session']);
            $table->dropIndex(['visibility']);
            $table->dropIndex(['created_at']);
            $table->dropFullText(['title', 'abstract', 'keywords']);
        });

        Schema::table('project_authors', function (Blueprint $table) {
            $table->dropIndex(['project_id']);
            $table->dropIndex(['matric_number']);
            $table->dropIndex(['student_name']);
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropIndex(['student_id']);
            $table->dropIndex(['book_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['due_date']);
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropIndex(['name']);
            $table->dropIndex(['department']);
        });

        Schema::table('books', function (Blueprint $table) {
            $table->dropIndex(['category']);
            $table->dropIndex(['book_type']);
            $table->dropIndex(['available_quantity']);
        });
    }
};
