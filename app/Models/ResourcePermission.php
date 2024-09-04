<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ResourcePermission
 *
 * @property string $name
 * @property string|null $permission_data
 * @property string $permission_type
 * @property string $role
 * @property string $resource_name
 *
 * @property ResourceAccess $resource_access
 * @property Collection|ResEmployeeResPermission[] $res_employee_res_permissions
 *
 * @package App\Models
 */
class ResourcePermission extends Model
{
    protected $table = 'resource_permission';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'permission_data',
        'permission_type',
        'role'
    ];

    public function resource_access()
    {
        return $this->belongsTo(ResourceAccess::class, 'resource_name');
    }

    public function res_employee_res_permissions()
    {
        return $this->hasMany(ResEmployeeResPermission::class, 'resource_access_name', 'resource_name');
    }
}
