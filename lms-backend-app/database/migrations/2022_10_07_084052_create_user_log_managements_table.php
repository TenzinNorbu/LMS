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
            // $table->id();
            // $table->integer('user_id')
            // ->references('id')
            // ->on('users');
            $table->string('register_date');
            $table->string('password_change_date');
            $table->string('login_date');
            $table->string('logout_date');
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
