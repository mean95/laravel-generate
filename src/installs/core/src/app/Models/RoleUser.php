<?php


namespace Core\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
	
	protected $table = 'role_user';

	protected $fillable = [
        'role_id',
        'user_id',
	];

	/**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
