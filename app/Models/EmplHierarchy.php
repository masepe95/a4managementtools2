<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmplHierarchy
 *
 * @property int $id
 * @property int $employee_hierarchy_id
 * @property int $level
 *
 * @property EmployeeHierarchy $employee_hierarchy
 * @property Collection|EmplHierarchyLang[] $empl_hierarchy_langs
 *
 * @package App\Models
 */
class EmplHierarchy extends Model
{
    protected $table = 'empl_hierarchy';
    public $timestamps = false;

    protected $casts = [
        'employee_hierarchy_id' => 'int',
        'level' => 'int'
    ];

    protected $fillable = [
        'employee_hierarchy_id',
        'level'
    ];

    public function employee_hierarchy()
    {
        return $this->belongsTo(EmployeeHierarchy::class);
    }

    public function empl_hierarchy_langs()
    {
        return $this->hasMany(EmplHierarchyLang::class, 'employee_hierarchy_id', 'employee_hierarchy_id');
    }
}
