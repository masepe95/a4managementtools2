<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeePersonalTool
 *
 * @property int $employee_id
 * @property int $tool_id
 * @property string $enabled
 *
 * @property Employee $employee
 * @property Tool $tool
 * @property Collection|PersonalJob[] $personal_jobs
 *
 * @package App\Models
 */
class EmployeePersonalTool extends Model
{
    protected $table = 'employee_personal_tool';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'employee_id' => 'int',
        'tool_id' => 'int'
    ];

    protected $fillable = [
        'enabled'
    ];

    public function employee()
    {
        return $this->belongsTo(User::class);
    }

    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }

    public function personal_jobs()
    {
        return $this->hasMany(PersonalJob::class, 'employee_id');
    }
}
