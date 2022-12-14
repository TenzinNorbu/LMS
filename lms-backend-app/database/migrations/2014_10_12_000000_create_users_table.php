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
            $table->string('employee_full_name');
            $table->string('employment_id');
            $table->string('branch_id')
            ->references('id')
            ->on('branches');
            $table->string('department_id')
            ->references('id')
            ->on('departments');
            $table->string('email')->unique();
            $table->string('designation');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone_no');
            $table->string('profile_url')->default('../profile/logo.png');
            $table->string('user_name');
            $table->string('password');
            $table->string('user_status')->default('inActive');
            $table->string('password_status')->default('isChanged');
            $table->string('password_created_date');
            $table->string('password_reset_date');
            // $table->string('encrypted')->default('1');
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
