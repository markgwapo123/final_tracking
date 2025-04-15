<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('login_activities', function (Blueprint $table) {
            // Only add missing columns
            if (!Schema::hasColumn('login_activities', 'closed_at')) {
                $table->timestamp('closed_at')->nullable()->after('logged_in_at');
            }
            if (!Schema::hasColumn('login_activities', 'last_active')) {
                $table->timestamp('last_active')->nullable()->after('closed_at');
            }
        });
    }
    
    public function down()
    {
        Schema::table('login_activities', function (Blueprint $table) {
            $table->dropColumn(['closed_at', 'last_active']);
        });
    }
};
