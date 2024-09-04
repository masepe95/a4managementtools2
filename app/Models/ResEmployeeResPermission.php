<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ResEmployeeResPermission
 *
 * @property int $employee_id
 * @property string $resource_access_name
 * @property string $resource_permission_name
 *
 * @property ResEmployeeResAccess $res_employee_res_access
 * @property ResourcePermission $resource_permission
 *
 * @package App\Models
 */
class ResEmployeeResPermission extends Model
{
    protected $table = 'res_employee_res_permission';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'employee_id' => 'int'
    ];

    public function res_employee_res_access()
    {
        return $this->belongsTo(ResEmployeeResAccess::class, 'employee_id')
                    ->where('res_employee_res_access.employee_id', '=', 'res_employee_res_permission.employee_id')
                    ->where('res_employee_res_access.resource_access_name', '=', 'res_employee_res_permission.resource_access_name');
    }

    public function resource_permission()
    {
        return $this->belongsTo(ResourcePermission::class, 'resource_access_name', 'resource_name')
                    ->where('resource_permission.resource_name', '=', 'res_employee_res_permission.resource_access_name')
                    ->where('resource_permission.name', '=', 'res_employee_res_permission.resource_permission_name');
    }
}
