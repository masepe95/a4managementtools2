<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PersonalJobHierarchyLang
 *
 * @property int $id
 * @property int $personal_job_id
 * @property int $level
 * @property string $lang_code
 * @property string $name
 *
 * @property Language $language
 * @property PersonalJob $personal_job
 *
 * @package App\Models
 */
class PersonalJobHierarchyLang extends Model
{
    protected $table = 'personal_job_hierarchy_lang';
    public $timestamps = false;

    protected $casts = [
        'personal_job_id' => 'int',
        'level' => 'int'
    ];

    protected $fillable = [
        'personal_job_id',
        'level',
        'lang_code',
        'name'
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'lang_code');
    }

    public function personal_job()
    {
        return $this->belongsTo(PersonalJob::class);
    }
}
