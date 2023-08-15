<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->id();
            $table->string("username", 20)->unique();
            $table->string("first_name", 80);
            $table->string("last_name", 80);
            $table->string("email", 255)->unique();
            $table->string("password", 255);
            $table->timestamp("email_verified_at");
            $table->string("avatar", 255)->nullable();
            $table->string("status")->default("0");
            $table->rememberToken();
            $table->text("about")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_users');
    }
}
