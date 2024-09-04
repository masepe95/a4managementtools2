<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeTool
 *
 * @property int $customer_id
 * @property int $employee_id
 * @property int $tool_id
 * @property string $access
 *
 * @property CustomerTool $customer_tool
 * @property Employee $employee
 *
 * @package App\Models
 */
class EmployeeTool extends Model
{
    protected $table = 'employee_tool';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'customer_id' => 'int',
        'employee_id' => 'int',
        'tool_id' => 'int'
    ];

    protected $fillable = [
        'access'
    ];

    public function customer_tool()
    {
        return $this->belongsTo(CustomerTool::class, 'customer_id')
                    ->where('customer_tool.customer_id', '=', 'employee_tool.customer_id')
                    ->where('customer_tool.tool_id', '=', 'employee_tool.tool_id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'customer_id', 'customer_id')
                    ->where('employee.customer_id', '=', 'employee_tool.customer_id')
                    ->where('employee.id', '=', 'employee_tool.employee_id');
    }
}
