<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ResourceAccess
 *
 * @property string $name
 * @property string $resource_data
 * @property string $resource_type
 * @property string $role
 *
 * @property Collection|ResEmployeeResAccess[] $res_employee_res_accesses
 * @property Collection|ResourcePermission[] $resource_permissions
 *
 * @package App\Models
 */
class ResourceAccess extends Model
{
    protected $table = 'resource_access';
    protected $primaryKey = 'name';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'resource_data',
        'resource_type',
        'role'
    ];

    public function res_employee_res_accesses()
    {
        return $this->hasMany(ResEmployeeResAccess::class, 'resource_access_name');
    }

    public function resource_permissions()
    {
        return $this->hasMany(ResourcePermission::class, 'resource_name');
    }
}
