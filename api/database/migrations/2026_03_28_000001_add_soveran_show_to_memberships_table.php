<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('memberships', function (Blueprint $table) {
            if (!Schema::hasColumn('memberships', 'soveran_show')) {
                if (Schema::hasColumn('memberships', 'price')) {
                    $table->string('soveran_show')->nullable()->after('price');
                } else {
                    $table->string('soveran_show')->nullable();
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('memberships', function (Blueprint $table) {
            if (Schema::hasColumn('memberships', 'soveran_show')) {
                $table->dropColumn('soveran_show');
            }
        });
    }
};