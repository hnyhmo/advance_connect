<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
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
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('status')->default(0);
            $table->string('created_by_id')->default(0);
            $table->string('updated_by_id')->default(0);
            $table->integer('deleted_by_id')->default(0);
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            $table->string('temp_code')->nullable();
            $table->integer('temp_code_used')->default(0);
            $table->integer('code_try')->default(0);
            $table->date('date_blocked')->nullable();
            $table->integer('blocked')->default(0);
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
}
