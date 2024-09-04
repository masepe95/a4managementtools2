<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PersonalGroup
 *
 * @property int $id
 * @property int $employee_id
 * @property int $customer_id
 * @property string $group_name
 *
 * @property Employee $employee
 * @property Collection|PersonalEmployeeGroup[] $personal_employee_groups
 *
 * @package App\Models
 */
class PersonalGroup extends Model
{
    protected $table = 'personal_group';
    public $timestamps = false;

    protected $casts = [
        'employee_id' => 'int',
        'customer_id' => 'int'
    ];

    protected $fillable = [
        'employee_id',
        'customer_id',
        'group_name'
    ];

    public function employee()
    {
        return $this->belongsTo(User::class)
                    ->where('employee.id', '=', 'personal_group.employee_id')
                    ->where('employee.customer_id', '=', 'personal_group.customer_id');
    }

    public function personal_employee_groups()
    {
        return $this->hasMany(PersonalEmployeeGroup::class, 'group_id');
    }
}
