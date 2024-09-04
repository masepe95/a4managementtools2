<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EmplHierarchyLang
 *
 * @property int $id
 * @property int $employee_hierarchy_id
 * @property int $level
 * @property string $lang_code
 * @property string $name
 *
 * @property EmplHierarchy $empl_hierarchy
 * @property Language $language
 *
 * @package App\Models
 */
class EmplHierarchyLang extends Model
{
    protected $table = 'empl_hierarchy_lang';
    public $timestamps = false;

    protected $casts = [
        'employee_hierarchy_id' => 'int',
        'level' => 'int'
    ];

    protected $fillable = [
        'employee_hierarchy_id',
        'level',
        'lang_code',
        'name'
    ];

    public function empl_hierarchy()
    {
        return $this->belongsTo(EmplHierarchy::class, 'employee_hierarchy_id', 'employee_hierarchy_id')
                    ->where('empl_hierarchy.employee_hierarchy_id', '=', 'empl_hierarchy_lang.employee_hierarchy_id')
                    ->where('empl_hierarchy.level', '=', 'empl_hierarchy_lang.level');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'lang_code');
    }
}
