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
        Schema::table('departments', function (Blueprint $table) {
            // Add missing fields if they don't already exist
            if (!Schema::hasColumn('departments', 'code')) {
                $table->string('code')->nullable()->after('name');
            }
            if (!Schema::hasColumn('departments', 'description')) {
                $table->text('description')->nullable()->after('code');
            }
            if (!Schema::hasColumn('departments', 'status')) {
                $table->string('status')->default('active')->after('description');
            }
            if (!Schema::hasColumn('departments', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropColumn(['code', 'description', 'status']);
            $table->dropSoftDeletes();
        });
    }
};
