<?php

use Core\app\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string("name", 100)->unique();
            $table->string("display_name", 100);
            $table->string("description", 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Role::insert([
            [
                'name' => 'SUPER_ADMIN',
                'display_name' => 'Super Admin',
                'description' => 'The highest authority of the board of directors',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'VIEWER',
                'display_name' => 'View all',
                'description' => 'This role can see all screens',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
