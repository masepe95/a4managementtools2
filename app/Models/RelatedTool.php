<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RelatedTool
 *
 * @property int $source_tool
 * @property int $related_tool
 *
 * @property Tool $tool
 *
 * @package App\Models
 */
class RelatedTool extends Model
{
    protected $table = 'related_tools';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'source_tool' => 'int',
        'related_tool' => 'int'
    ];

    public function tool()
    {
        return $this->belongsTo(Tool::class, 'source_tool');
    }
}
