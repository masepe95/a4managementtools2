<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tool
 *
 * @property int $id
 * @property string $name_id
 * @property string $title_id
 * @property string $cat_levels
 * @property string $cat_recipients
 * @property string $cat_usages
 * @property string $cat_selections
 * @property string $cat_scopes
 * @property string $active
 *
 * @property Collection|Customer[] $customers
 * @property Collection|Employee[] $employees
 * @property Collection|RelatedTool[] $related_tools
 * @property Collection|Tag[] $tags
 * @property Collection|ToolAttachment[] $tool_attachments
 * @property Collection|ToolLangDatum[] $tool_lang_data
 *
 * @package App\Models
 */
class Tool extends Model
{
    protected $table = 'tool';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'id' => 'int'
    ];

    protected $fillable = [
        'name_id',
        'title_id',
        'cat_levels',
        'cat_recipients',
        'cat_usages',
        'cat_selections',
        'cat_scopes',
        'active'
    ];

    public function customers()
    {
        return $this->belongsToMany(Customer::class)
                    ->withPivot('enabled');
    }

    public function employees()
    {
        return $this->belongsToMany(User::class, 'employee_personal_tool')
                    ->withPivot('enabled');
    }

    public function related_tools()
    {
        return $this->hasMany(RelatedTool::class, 'source_tool');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)
                    ->withPivot('weight');
    }

    public function tool_attachments()
    {
        return $this->hasMany(ToolAttachment::class, 'id_tool');
    }

    public function tool_lang_data()
    {
        return $this->hasMany(ToolLangDatum::class, 'id');
    }
}
