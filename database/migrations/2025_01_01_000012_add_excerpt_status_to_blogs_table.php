<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            if (!Schema::hasColumn('blogs', 'excerpt')) {
                $table->text('excerpt')->nullable()->after('thumbnail');
            }
            if (!Schema::hasColumn('blogs', 'status')) {
                $table->string('status')->default('Draft')->after('content');
            }
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn(['excerpt', 'status']);
        });
    }
};
