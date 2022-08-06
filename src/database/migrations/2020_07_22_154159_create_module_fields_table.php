<?php

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
