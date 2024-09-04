<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CustomerTool
 *
 * @property int $customer_id
 * @property int $tool_id
 * @property string $enabled
 *
 * @property Customer $customer
 * @property Tool $tool
 * @property Collection|EmployeeTool[] $employee_tools
 * @property Collection|Job[] $jobs
 *
 * @package App\Models
 */
class CustomerTool extends Model
{
    protected $table = 'customer_tool';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'customer_id' => 'int',
        'tool_id' => 'int'
    ];

    protected $fillable = [
        'enabled'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }

    public function employee_tools()
    {
        return $this->hasMany(EmployeeTool::class, 'customer_id');
    }

    public function jobs()
    {
        return $this->hasMany(Job::class, 'customer_id');
    }
}
