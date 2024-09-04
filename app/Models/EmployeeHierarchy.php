<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeHierarchy
 *
 * @property int $id
 * @property int $employee_id
 * @property string $name
 *
 * @property Employee $employee
 * @property Collection|EmplHierarchy[] $empl_hierarchies
 *
 * @package App\Models
 */
class EmployeeHierarchy extends Model
{
    protected $table = 'employee_hierarchy';
    public $timestamps = false;

    protected $casts = [
        'employee_id' => 'int'
    ];

    protected $fillable = [
        'employee_id',
        'name'
    ];

    public function employee()
    {
        return $this->belongsTo(User::class);
    }

    public function empl_hierarchies()
    {
        return $this->hasMany(EmplHierarchy::class);
    }
}
