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
        $table->string('computer_name')->nullable(); // Add the computer_name column
    });
}

public function down()
{
    Schema::table('login_activities', function (Blueprint $table) {
        $table->dropColumn('computer_name');
    });
}

};
