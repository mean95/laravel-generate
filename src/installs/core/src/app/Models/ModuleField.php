<?php

namespace Core\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleField extends Model
{
    protected $table = 'module_fields';
    protected $fillable = [
        'column_name', 'label', 'module_id', 'module_field_type_id', 'unique',
        'default_value', 'minlength', 'maxlength', 'required', 'popup_val', 'sort'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
