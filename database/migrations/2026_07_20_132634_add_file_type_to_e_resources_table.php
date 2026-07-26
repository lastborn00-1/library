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
        Schema::table('e_resources', function (Blueprint $table) {
            if (!Schema::hasColumn('e_resources', 'file_type')) {
                $table->string('file_type')->default('link')->after('url');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('e_resources', function (Blueprint $table) {
            $table->dropColumn('file_type');
        });
    }
};
