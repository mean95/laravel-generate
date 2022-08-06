<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Core\app\Models\ModuleFieldType;

class CreateModuleFieldTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_field_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->timestamps();
        });
        // Note: Do not edit below lines
        ModuleFieldType::create(["name" => "Address"]);
        ModuleFieldType::create(["name" => "Checkbox"]);
        ModuleFieldType::create(["name" => "Boolean"]);
        ModuleFieldType::create(["name" => "Currency"]);
        ModuleFieldType::create(["name" => "Date"]);
        ModuleFieldType::create(["name" => "DateTime"]);
        ModuleFieldType::create(["name" => "Decimal"]);
        ModuleFieldType::create(["name" => "Dropdown"]);
        ModuleFieldType::create(["name" => "Email"]);
        ModuleFieldType::create(["name" => "File"]);
        ModuleFieldType::create(["name" => "Float"]);
        ModuleFieldType::create(["name" => "Editor"]);
        ModuleFieldType::create(["name" => "Integer"]);
        ModuleFieldType::create(["name" => "Mobile"]);
        ModuleFieldType::create(["name" => "MultiSelect"]);
        ModuleFieldType::create(["name" => "Password"]);
        ModuleFieldType::create(["name" => "Radio"]);
        ModuleFieldType::create(["name" => "String"]);
        ModuleFieldType::create(["name" => "TagInput"]);
        ModuleFieldType::create(["name" => "Textarea"]);
        ModuleFieldType::create(["name" => "URL"]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('module_field_types');
    }
}
