<?php

namespace Core\app\Models;

use Illuminate\Database\Eloquent\Model;
use Core\app\Traits\ModuleTrait;

class Module extends Model
{
    use ModuleTrait;

    protected $table = 'modules';
    protected $fillable = [
        'name', 'label', 'name_db', 'view_col', 'model', 'controller', 'icon', 'is_gen'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function moduleFields()
    {
        return $this->hasMany(ModuleField::class);
    }
}
