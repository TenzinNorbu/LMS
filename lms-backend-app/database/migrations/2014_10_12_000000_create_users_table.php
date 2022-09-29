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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('cid_no');
            $table->string('name');
            $table->string('gender');
            $table->string('emp_id');
            $table->string('contact_no');
            $table->integer('branch_id')
            ->references('id')
            ->on('branchs');
            $table->integer('department_id')
            ->references('id')
            ->on('departments');
            $table->string('profile_url')->default('../profile/logo.png');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
