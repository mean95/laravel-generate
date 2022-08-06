<?php

use Core\app\Models\AdminMenu;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_menus', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('url', 256);
            $table->string('icon', 50)->default("uil uil-cube");
            $table->string('type', 20)->default("module");
            $table->bigInteger('admin_menu_id')->unsigned()->default(0);
            $table->bigInteger('sort')->unsigned()->default(0);
            $table->timestamps();
        });

        AdminMenu::insert([
            [
                'name' => 'Admin users',
                'url' => 'admin_users',
                'icon' => 'uil uil-users-alt',
                'type' => 'module',
                'admin_menu_id' => 0,
                'sort' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Roles & Permissions',
                'url' => 'roles',
                'icon' => 'uil uil-user-plus',
                'type' => 'custom',
                'admin_menu_id' => 0,
                'sort' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Media',
                'url' => 'media',
                'icon' => 'uil uil-camera',
                'type' => 'custom',
                'admin_menu_id' => 0,
                'sort' => 0,
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
        Schema::dropIfExists('admin_menus');
    }
}
