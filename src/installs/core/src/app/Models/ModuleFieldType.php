<?php


namespace Core\Models;


use Illuminate\Database\Eloquent\Model;

class ModuleFieldType extends Model
{
    protected $table = 'module_field_types';
    protected $fillable = ['name'];
}
