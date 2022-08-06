<?php
/**
 * Model generated using Admin
 */

namespace Core\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

	protected $table = 'roles';

	protected $hidden = [

    ];

	protected $fillable = [
		'name',
		'display_name',
		'description',

	];

	protected $dates = ['deleted_at'];

	/**
     * @return BelongsToMany
     */
	public function adminUsers(): BelongsToMany
    {
		return $this->belongsToMany(AdminUser::class);
	}

    /**
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class)->withPivot('role_id', 'permission_id');
    }
}
