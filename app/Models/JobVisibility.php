<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class JobVisibility
 *
 * @property int $job_id
 * @property int $employee_id
 * @property int $customer_id
 * @property string $access
 * @property string $enabled
 *
 * @property Employee $employee
 * @property Job $job
 *
 * @package App\Models
 */
class JobVisibility extends Model
{
    protected $table = 'job_visibility';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'job_id' => 'int',
        'employee_id' => 'int',
        'customer_id' => 'int'
    ];

    protected $fillable = [
        'customer_id',
        'access',
        'enabled'
    ];

    public function employee()
    {
        return $this->belongsTo(User::class)
                    ->where('employee.id', '=', 'job_visibility.employee_id')
                    ->where('employee.customer_id', '=', 'job_visibility.customer_id');
    }

    public function job()
    {
        return $this->belongsTo(Job::class)
                    ->where('job.id', '=', 'job_visibility.job_id')
                    ->where('job.customer_id', '=', 'job_visibility.customer_id');
    }
}
