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
        $table->string('tab_title')->nullable()->after('tab_id');
    });
}

public function down()
{
    Schema::table('login_activities', function (Blueprint $table) {
        $table->dropColumn('tab_title');
    });
}

};
