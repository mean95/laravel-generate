<?php

namespace Core\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table = 'configs';

    protected $hidden = [

    ];

    protected $fillable = [
        'key',
        'value',
        'section',
    ];
}
