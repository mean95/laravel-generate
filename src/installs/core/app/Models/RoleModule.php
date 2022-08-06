<?php


namespace Core\app\Models;

use Illuminate\Database\Eloquent\Model;

class RoleModule extends Model
{
	
	protected $table = 'role_module';

	protected $fillable = [
        'role_id',
        'module_id',
        'view',
        'create',
        'edit',
        'delete',
	];

	/**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
	public function role()
	{
		return $this->belongsTo(Role::class);
	}
}
