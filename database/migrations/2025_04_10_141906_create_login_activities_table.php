<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('login_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('ip_address')->nullable();
            $table->string('tab_id');  // Added tab_id column
            $table->string('tab_title')->nullable();
            $table->text('device_info')->nullable();
            $table->timestamp('logged_in_at')->useCurrent();
            $table->timestamp('closed_at')->nullable();  // Added closed_at
            $table->timestamp('last_active')->nullable();  // Added last_active
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('login_activities');
    }
};