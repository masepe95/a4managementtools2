<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SectionLang
 *
 * @property int $id
 * @property int $section_id
 * @property int $customer_id
 * @property string $lang_code
 * @property string $name
 *
 * @property Language $language
 * @property Section $section
 *
 * @package App\Models
 */
class SectionLang extends Model
{
    protected $table = 'section_lang';
    public $timestamps = false;

    protected $casts = [
        'section_id' => 'int',
        'customer_id' => 'int'
    ];

    protected $fillable = [
        'section_id',
        'customer_id',
        'lang_code',
        'name'
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'lang_code');
    }

    public function section()
    {
        return $this->belongsTo(Section::class)
                    ->where('section.id', '=', 'section_lang.section_id')
                    ->where('section.customer_id', '=', 'section_lang.customer_id');
    }
}
