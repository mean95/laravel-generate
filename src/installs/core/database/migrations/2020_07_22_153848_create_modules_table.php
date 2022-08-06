<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('label', 100);
            $table->string('name_db', 50);
            $table->string('view_col', 50);
            $table->string('model', 50);
            $table->string('controller', 100);
            $table->string('icon', 50)->default("uil-500px");
            $table->boolean('is_gen');
            $table->timestamps();
        });
        
        DB::table('modules')->insert([
            [
                'name' => 'AdminUsers',
                'label' => 'Admin Users',
                'name_db' => 'admin_users',
                'view_col' => 'email',
                'model' => 'AdminUser',
                'controller' => 'AdminUserController',
                'icon' => 'uil-users-alt',
                'is_gen' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modules');
    }
}
