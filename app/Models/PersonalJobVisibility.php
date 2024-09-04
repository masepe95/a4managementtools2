<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PersonalJobVisibility
 *
 * @property int $personal_job_id
 * @property int $employee_id
 * @property string $enabled
 *
 * @property Employee $employee
 * @property PersonalJob $personal_job
 *
 * @package App\Models
 */
class PersonalJobVisibility extends Model
{
    protected $table = 'personal_job_visibility';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'personal_job_id' => 'int',
        'employee_id' => 'int'
    ];

    protected $fillable = [
        'enabled'
    ];

    public function employee()
    {
        return $this->belongsTo(User::class);
    }

    public function personal_job()
    {
        return $this->belongsTo(PersonalJob::class)
                    ->where('personal_job.id', '=', 'personal_job_visibility.personal_job_id')
                    ->where('personal_job.employee_id', '=', 'personal_job_visibility.employee_id');
    }
}
