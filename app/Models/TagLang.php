<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TagLang
 *
 * @property int $id
 * @property int $tag_id
 * @property string $lang_code
 * @property string $tag_name
 *
 * @property Language $language
 * @property Tag $tag
 *
 * @package App\Models
 */
class TagLang extends Model
{
    protected $table = 'tag_lang';
    public $timestamps = false;

    protected $casts = [
        'tag_id' => 'int'
    ];

    protected $fillable = [
        'tag_id',
        'lang_code',
        'tag_name'
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'lang_code');
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}
