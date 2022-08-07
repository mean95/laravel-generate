<?php

use Core\Models\ModuleField;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_fields', function (Blueprint $table) {
            $table->id();
            $table->string('column_name', 30);
            $table->string('label', 100);
            $table->unsignedBigInteger('module_id');
            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
            $table->unsignedBigInteger('module_field_type_id');
            $table->foreign('module_field_type_id')->references('id')
                ->on('module_field_types')->onDelete('cascade');
            $table->boolean('unique')->default(0);
            $table->string('default_value');
            $table->unsignedBigInteger('minlength')->default(0);
            $table->unsignedBigInteger('maxlength')->default(0);
            $table->boolean('required')->default(0);
            $table->text('popup_val');
            $table->unsignedBigInteger('sort')->default(0);
            $table->timestamps();
        });

        ModuleField::insert([
            [ 
                'column_name' => 'username', 'label' => 'Username', 'module_id' => 1, 'module_field_type_id' => 18,
                'unique' => 1, 'default_value' => '', 'minlength' => 3, 'maxlength' => 20, 'required' => 1,
                'popup_val' => '', 'sort' => 0, 'created_at' => now(), 'updated_at' => now(),
            ],
            [ 
                'column_name' => 'first_name', 'label' => 'First Name', 'module_id' => 1, 'module_field_type_id' => 18,
                'unique' => 0, 'default_value' => '', 'minlength' => 0, 'maxlength' => 80, 'required' => 1,
                'popup_val' => '', 'sort' => 0, 'created_at' => now(), 'updated_at' => now(),
            ],
            [ 
                'column_name' => 'last_name', 'label' => 'Last Name', 'module_id' => 1, 'module_field_type_id' => 18,
                'unique' => 0, 'default_value' => '', 'minlength' => 0, 'maxlength' => 80, 'required' => 1,
                'popup_val' => '', 'sort' => 0, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'column_name' => 'email', 'label' => 'Email', 'module_id' => 1, 'module_field_type_id' => 9,
                'unique' => 1, 'default_value' => '', 'minlength' => 0, 'maxlength' => 255, 'required' => 1,
                'popup_val' => '', 'sort' => 0, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'column_name' => 'password', 'label' => 'Password', 'module_id' => 1, 'module_field_type_id' => 16,
                'unique' => 0, 'default_value' => '', 'minlength' => 0, 'maxlength' => 255, 'required' => 1,
                'popup_val' => '', 'sort' => 0, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'column_name' => 'email_verified_at', 'label' => 'Email verified at', 'module_id' => 1, 'module_field_type_id' => 6,
                'unique' => 0, 'default_value' => '', 'minlength' => 0, 'maxlength' => 0, 'required' => 0,
                'popup_val' => '', 'sort' => 0, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'column_name' => 'avatar', 'label' => 'Avatar', 'module_id' => 1, 'module_field_type_id' => 10,
                'unique' => 0, 'default_value' => 1, 'minlength' => 0, 'maxlength' => 0, 'required' => 0,
                'popup_val' => '', 'sort' => 0, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'column_name' => 'status', 'label' => 'Status', 'module_id' => 1, 'module_field_type_id' => 2,
                'unique' => 0, 'default_value' => 0, 'minlength' => 0, 'maxlength' => 0, 'required' => 0,
                'popup_val' => '', 'sort' => 0, 'created_at' => now(), 'updated_at' => now(),
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
        Schema::dropIfExists('module_fields');
    }
}
