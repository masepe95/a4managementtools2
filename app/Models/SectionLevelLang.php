<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SectionLevelLang
 *
 * @property int $id
 * @property int $customer_id
 * @property int $level
 * @property string $lang_code
 * @property string $name
 *
 * @property Language $language
 * @property SectionLevel $section_level
 *
 * @package App\Models
 */
class SectionLevelLang extends Model
{
    protected $table = 'section_level_lang';
    public $timestamps = false;

    protected $casts = [
        'customer_id' => 'int',
        'level' => 'int'
    ];

    protected $fillable = [
        'customer_id',
        'level',
        'lang_code',
        'name'
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'lang_code');
    }

    public function section_level()
    {
        return $this->belongsTo(SectionLevel::class, 'customer_id', 'customer_id')
                    ->where('section_level.customer_id', '=', 'section_level_lang.customer_id')
                    ->where('section_level.level', '=', 'section_level_lang.level');
    }
}
