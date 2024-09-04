<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ToolLangDatum
 *
 * @property int $id
 * @property string $lang
 * @property string $alphabetical_index
 * @property string $sub_title
 * @property string $introduction
 * @property string $presentation
 * @property string $potential
 * @property string $solved_problem
 * @property string $instructions
 * @property string $advanced_techniques
 * @property string $risks_and_remedies
 * @property string $mistakes
 * @property string $insight_1
 * @property string $insight_2
 * @property string $insight_3
 * @property string $insight_4
 * @property string $insight_5
 * @property string $provocation_1
 * @property string $provocation_2
 * @property string $opportunities
 * @property string $key_results
 *
 * @property Language $language
 * @property Tool $tool
 *
 * @package App\Models
 */
class ToolLangDatum extends Model
{
    protected $table = 'tool_lang_data';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'id' => 'int'
    ];

    protected $fillable = [
        'alphabetical_index',
        'sub_title',
        'introduction',
        'presentation',
        'potential',
        'solved_problem',
        'instructions',
        'advanced_techniques',
        'risks_and_remedies',
        'mistakes',
        'insight_1',
        'insight_2',
        'insight_3',
        'insight_4',
        'insight_5',
        'provocation_1',
        'provocation_2',
        'opportunities',
        'key_results'
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'lang');
    }

    public function tool()
    {
        return $this->belongsTo(Tool::class, 'id');
    }
}
