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
        Schema::table('departmental_materials', function (Blueprint $table) {
            $table->boolean('allow_download')->default(true)->after('file_size');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('departmental_materials', function (Blueprint $table) {
            $table->dropColumn('allow_download');
        });
    }
};
