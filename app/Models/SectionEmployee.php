<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SectionEmployee
 *
 * @property int $section_id
 * @property int $employee_id
 * @property int $customer_id
 *
 * @property Employee $employee
 * @property Section $section
 *
 * @package App\Models
 */
class SectionEmployee extends Model
{
    protected $table = 'section_employee';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'section_id' => 'int',
        'employee_id' => 'int',
        'customer_id' => 'int'
    ];

    protected $fillable = [
        'customer_id'
    ];

    public function employee()
    {
        return $this->belongsTo(User::class)
                    ->where('employee.id', '=', 'section_employee.employee_id')
                    ->where('employee.customer_id', '=', 'section_employee.customer_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class)
                    ->where('section.id', '=', 'section_employee.section_id')
                    ->where('section.customer_id', '=', 'section_employee.customer_id');
    }
}
