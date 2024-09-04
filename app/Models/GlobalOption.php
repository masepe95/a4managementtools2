<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class GlobalOption
 *
 * @property int $id
 * @property string $default_lang_code
 * @property int $signup_pending_timeout
 * @property int $minimum_password_length
 * @property int $max_password_failures
 * @property int $recovering_access_delay
 * @property string $support_admin_email
 * @property string $under_maintenance
 * @property string $redirect_url
 * @property string $maintenance_banner
 * @property string $maintenance_period
 *
 * @property Language $language
 *
 * @package App\Models
 */
class GlobalOption extends Model
{
    protected $table = 'global_option';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'id' => 'int',
        'signup_pending_timeout' => 'int',
        'minimum_password_length' => 'int',
        'max_password_failures' => 'int',
        'recovering_access_delay' => 'int'
    ];

    protected $fillable = [
        'default_lang_code',
        'signup_pending_timeout',
        'minimum_password_length',
        'max_password_failures',
        'recovering_access_delay',
        'support_admin_email',
        'under_maintenance',
        'redirect_url',
        'maintenance_banner',
        'maintenance_period'
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'default_lang_code');
    }
}
