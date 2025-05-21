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
    Schema::table('activities', function (Blueprint $table) {
        $table->unsignedBigInteger('user_id'); // Add user_id as a foreign key
        $table->foreign('user_id')->references('id')->on('users'); // Add foreign key constraint
    });
}

public function down()
{
    Schema::table('activities', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
        $table->dropColumn('user_id');
    });
}

};
