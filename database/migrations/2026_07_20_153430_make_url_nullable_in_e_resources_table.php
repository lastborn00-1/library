<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('e_resources', function (Blueprint $table) {
            // Make url nullable so file uploads (without a URL) are allowed
            $table->string('url')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('e_resources', function (Blueprint $table) {
            $table->string('url')->nullable(false)->change();
        });
    }
};
