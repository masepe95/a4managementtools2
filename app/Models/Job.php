<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Job
 *
 * @property int $id
 * @property int $customer_id
 * @property int $tool_id
 * @property int $editor_id
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
 * @property CustomerTool $customer_tool
 * @property Employee $employee
 * @property Language $language
 * @property Collection|JobAttachment[] $job_attachments
 * @property Collection|JobHierarchyLang[] $job_hierarchy_langs
 * @property Collection|JobVisibility[] $job_visibilities
 *
 * @package App\Models
 */
class Job extends Model
{
    protected $table = 'job';
    public $timestamps = false;

    protected $casts = [
        'customer_id' => 'int',
        'tool_id' => 'int',
        'editor_id' => 'int',
        'level_count' => 'int',
        'job_data' => 'json',
        'job_inserted' => 'datetime',
        'job_updated' => 'datetime',
        'job_deleted' => 'datetime'
    ];

    protected $fillable = [
        'customer_id',
        'tool_id',
        'editor_id',
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

    public function customer_tool()
    {
        return $this->belongsTo(CustomerTool::class, 'customer_id')
                    ->where('customer_tool.customer_id', '=', 'job.customer_id')
                    ->where('customer_tool.tool_id', '=', 'job.tool_id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'editor_id')
                    ->where('employee.id', '=', 'job.editor_id')
                    ->where('employee.customer_id', '=', 'job.customer_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'lang_code');
    }

    public function job_attachments()
    {
        return $this->hasMany(JobAttachment::class);
    }

    public function job_hierarchy_langs()
    {
        return $this->hasMany(JobHierarchyLang::class);
    }

    public function job_visibilities()
    {
        return $this->hasMany(JobVisibility::class);
    }
}
