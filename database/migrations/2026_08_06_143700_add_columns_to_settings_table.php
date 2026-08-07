<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('settings')) {
            Schema::table('settings', function (Blueprint $table) {
                if (!Schema::hasColumn('settings', 'key')) {
                    $table->string('key')->unique()->nullable();
                }
                if (!Schema::hasColumn('settings', 'value')) {
                    $table->text('value')->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('settings')) {
            Schema::table('settings', function (Blueprint $table) {
                if (Schema::hasColumn('settings', 'key')) {
                    $table->dropColumn('key');
                }
                if (Schema::hasColumn('settings', 'value')) {
                    $table->dropColumn('value');
                }
            });
        }
    }
};
