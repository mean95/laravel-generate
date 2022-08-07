<?php

namespace Core\Models;

use Illuminate\Database\Eloquent\Model;
use Core\Models\AdminUser;

class AdminUserRole extends Model
{
    protected $table = 'admin_user_role';

	protected $fillable = [
        'role_id',
        'admin_user_id',
	];

	/**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
	public function adminUser()
	{
		return $this->belongsTo(AdminUser::class);
	}
}
