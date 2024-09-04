<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TagTool
 *
 * @property int $tag_id
 * @property int $tool_id
 * @property float $weight
 *
 * @property Tag $tag
 * @property Tool $tool
 *
 * @package App\Models
 */
class TagTool extends Model
{
    protected $table = 'tag_tool';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'tag_id' => 'int',
        'tool_id' => 'int',
        'weight' => 'float'
    ];

    protected $fillable = [
        'weight'
    ];

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }
}
