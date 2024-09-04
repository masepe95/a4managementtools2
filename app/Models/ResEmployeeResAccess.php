<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ResEmployeeResAccess
 *
 * @property int $employee_id
 * @property string $resource_access_name
 *
 * @property Employee $employee
 * @property ResourceAccess $resource_access
 * @property Collection|ResEmployeeResPermission[] $res_employee_res_permissions
 *
 * @package App\Models
 */
class ResEmployeeResAccess extends Model
{
    protected $table = 'res_employee_res_access';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'employee_id' => 'int'
    ];

    public function employee()
    {
        return $this->belongsTo(User::class);
    }

    public function resource_access()
    {
        return $this->belongsTo(ResourceAccess::class, 'resource_access_name');
    }

    public function res_employee_res_permissions()
    {
        return $this->hasMany(ResEmployeeResPermission::class, 'employee_id');
    }
}
