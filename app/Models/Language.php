<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Language
 *
 * @property string $code
 * @property int $order
 * @property string $name
 *
 * @property Collection|TagLang[] $tag_langs
 * @property Collection|CustHierarchyLang[] $cust_hierarchy_langs
 * @property Collection|EmplHierarchyLang[] $empl_hierarchy_langs
 * @property Collection|Employee[] $employees
 * @property Collection|GlobalOption[] $global_options
 * @property InspireMe $inspire_me
 * @property Collection|Job[] $jobs
 * @property Collection|JobHierarchyLang[] $job_hierarchy_langs
 * @property Collection|PersonalJob[] $personal_jobs
 * @property Collection|PersonalJobHierarchyLang[] $personal_job_hierarchy_langs
 * @property Collection|SectionLang[] $section_langs
 * @property Collection|SectionLevelLang[] $section_level_langs
 * @property Collection|ToolLangDatum[] $tool_lang_data
 *
 * @package App\Models
 */
class Language extends Model
{
    protected $table = 'language';
    protected $primaryKey = 'code';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'order' => 'int'
    ];

    protected $fillable = [
        'order',
        'name'
    ];

    public function tag_langs()
    {
        return $this->hasMany(TagLang::class, 'lang_code');
    }

    public function cust_hierarchy_langs()
    {
        return $this->hasMany(CustHierarchyLang::class, 'lang_code');
    }

    public function empl_hierarchy_langs()
    {
        return $this->hasMany(EmplHierarchyLang::class, 'lang_code');
    }

    public function employees()
    {
        return $this->hasMany(User::class, 'language_code');
    }

    public function global_options()
    {
        return $this->hasMany(GlobalOption::class, 'default_lang_code');
    }

    public function inspire_me()
    {
        return $this->hasOne(InspireMe::class, 'lang_code');
    }

    public function jobs()
    {
        return $this->hasMany(Job::class, 'lang_code');
    }

    public function job_hierarchy_langs()
    {
        return $this->hasMany(JobHierarchyLang::class, 'lang_code');
    }

    public function personal_jobs()
    {
        return $this->hasMany(PersonalJob::class, 'lang_code');
    }

    public function personal_job_hierarchy_langs()
    {
        return $this->hasMany(PersonalJobHierarchyLang::class, 'lang_code');
    }

    public function section_langs()
    {
        return $this->hasMany(SectionLang::class, 'lang_code');
    }

    public function section_level_langs()
    {
        return $this->hasMany(SectionLevelLang::class, 'lang_code');
    }

    public function tool_lang_data()
    {
        return $this->hasMany(ToolLangDatum::class, 'lang');
    }
}
