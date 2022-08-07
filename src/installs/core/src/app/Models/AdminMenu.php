<?php

namespace Core\Models;

use Illuminate\Database\Eloquent\Model;

class AdminMenu extends Model
{
    protected $table = 'admin_menus';
    protected $fillable = [
        'name', 'url', 'icon', 'type', 'admin_menu_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function menuChildren()
    {
        return $this->hasMany(AdminMenu::class, 'admin_menu_id', 'id')
        ->with('menuChildren')
        ->orderBy('sort', 'asc');
    }
}
