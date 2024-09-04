<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class InspireMe
 *
 * @property string $lang_code
 * @property string $entries
 *
 * @property Language $language
 *
 * @package App\Models
 */
class InspireMe extends Model
{
    protected $table = 'inspire_me';
    protected $primaryKey = 'lang_code';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'entries'
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'lang_code');
    }
}
