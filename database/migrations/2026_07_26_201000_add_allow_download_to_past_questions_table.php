<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('past_questions', function (Blueprint $table) {
            $table->boolean('allow_download')->default(true)->after('file_type');
        });
    }

    public function down(): void
    {
        Schema::table('past_questions', function (Blueprint $table) {
            $table->dropColumn('allow_download');
        });
    }
};
