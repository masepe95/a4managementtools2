<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ActionLog
 *
 * @property int $id
 * @property Carbon $action_time
 * @property string $action
 * @property int $employee_id
 * @property string $action_data
 *
 * @property Employee $employee
 *
 * @package App\Models
 */
class ActionLog extends Model
{
    protected $table = 'action_log';
    public $timestamps = false;

    protected $casts = [
        'action_time' => 'datetime',
        'employee_id' => 'int'
    ];

    protected $fillable = [
        'action_time',
        'action',
        'employee_id',
        'action_data'
    ];

    public function employee()
    {
        return $this->belongsTo(User::class);
    }
}
