<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PersonalEmployeeGroup
 *
 * @property int $group_id
 * @property int $employee_owner_id
 * @property int $customer_id
 * @property int $group_employee_id
 *
 * @property Employee $employee
 * @property PersonalGroup $personal_group
 *
 * @package App\Models
 */
class PersonalEmployeeGroup extends Model
{
    protected $table = 'personal_employee_group';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'group_id' => 'int',
        'employee_owner_id' => 'int',
        'customer_id' => 'int',
        'group_employee_id' => 'int'
    ];

    protected $fillable = [
        'employee_owner_id',
        'customer_id'
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'group_employee_id')
                    ->where('employee.id', '=', 'personal_employee_group.group_employee_id')
                    ->where('employee.customer_id', '=', 'personal_employee_group.customer_id');
    }

    public function personal_group()
    {
        return $this->belongsTo(PersonalGroup::class, 'group_id')
                    ->where('personal_group.id', '=', 'personal_employee_group.group_id')
                    ->where('personal_group.employee_id', '=', 'personal_employee_group.employee_owner_id')
                    ->where('personal_group.customer_id', '=', 'personal_employee_group.customer_id');
    }
}
