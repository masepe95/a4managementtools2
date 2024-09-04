<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PersonalJob
 *
 * @property int $id
 * @property int $employee_id
 * @property int $tool_id
 * @property string $lang_code
 * @property int $level_count
 * @property string $level1_value
 * @property string $level2_value
 * @property string $level3_value
 * @property string $level4_value
 * @property array $job_data
 * @property Carbon $job_inserted
 * @property Carbon|null $job_updated
 * @property Carbon|null $job_deleted
 * @property string $send_email
 * @property string $status
 *
 * @property EmployeePersonalTool $employee_personal_tool
 * @property Language $language
 * @property Collection|PersonalJobAttachment[] $personal_job_attachments
 * @property Collection|PersonalJobHierarchyLang[] $personal_job_hierarchy_langs
 * @property PersonalJobVisibility $personal_job_visibility
 *
 * @package App\Models
 */
class PersonalJob extends Model
{
    protected $table = 'personal_job';
    public $timestamps = false;

    protected $casts = [
        'employee_id' => 'int',
        'tool_id' => 'int',
        'level_count' => 'int',
        'job_data' => 'json',
        'job_inserted' => 'datetime',
        'job_updated' => 'datetime',
        'job_deleted' => 'datetime'
    ];

    protected $fillable = [
        'employee_id',
        'tool_id',
        'lang_code',
        'level_count',
        'level1_value',
        'level2_value',
        'level3_value',
        'level4_value',
        'job_data',
        'job_inserted',
        'job_updated',
        'job_deleted',
        'send_email',
        'status'
    ];

    public function employee_personal_tool()
    {
        return $this->belongsTo(EmployeePersonalTool::class, 'employee_id')
                    ->where('employee_personal_tool.employee_id', '=', 'personal_job.employee_id')
                    ->where('employee_personal_tool.tool_id', '=', 'personal_job.tool_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'lang_code');
    }

    public function personal_job_attachments()
    {
        return $this->hasMany(PersonalJobAttachment::class);
    }

    public function personal_job_hierarchy_langs()
    {
        return $this->hasMany(PersonalJobHierarchyLang::class);
    }

    public function personal_job_visibility()
    {
        return $this->hasOne(PersonalJobVisibility::class);
    }
}
