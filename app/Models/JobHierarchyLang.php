<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class JobHierarchyLang
 *
 * @property int $id
 * @property int $job_id
 * @property int $level
 * @property string $lang_code
 * @property string $name
 *
 * @property Job $job
 * @property Language $language
 *
 * @package App\Models
 */
class JobHierarchyLang extends Model
{
    protected $table = 'job_hierarchy_lang';
    public $timestamps = false;

    protected $casts = [
        'job_id' => 'int',
        'level' => 'int'
    ];

    protected $fillable = [
        'job_id',
        'level',
        'lang_code',
        'name'
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'lang_code');
    }
}
