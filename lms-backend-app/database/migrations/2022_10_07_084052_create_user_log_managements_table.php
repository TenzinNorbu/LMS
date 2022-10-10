<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_log_managements', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')
            ->references('user_id')
            ->on('users')->nullable();
            $table->string('register_date')->nullable();
            $table->string('password_change_date')->nullable();
            $table->string('login_date')->nullable();
            $table->string('logout_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_log_managements');
    }
};
