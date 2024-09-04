<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tag
 *
 * @property int $tag_id
 *
 * @property Collection|TagLang[] $tag_langs
 * @property Collection|Tool[] $tools
 *
 * @package App\Models
 */
class Tag extends Model
{
    protected $table = 'tag';
    protected $primaryKey = 'tag_id';
    public $timestamps = false;

    public function tag_langs()
    {
        return $this->hasMany(TagLang::class);
    }

    public function tools()
    {
        return $this->belongsToMany(Tool::class)
                    ->withPivot('weight');
    }
}
