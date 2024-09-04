<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Section
 *
 * @property int $id
 * @property int $customer_id
 * @property int|null $parent_section_id
 * @property int $level
 *
 * @property Section|null $section
 * @property SectionLevel $section_level
 * @property Collection|Section[] $sections
 * @property Collection|Employee[] $employees
 * @property Collection|SectionLang[] $section_langs
 *
 * @package App\Models
 */
class Section extends Model
{
    protected $table = 'section';
    public $timestamps = false;

    protected $casts = [
        'customer_id' => 'int',
        'parent_section_id' => 'int',
        'level' => 'int'
    ];

    protected $fillable = [
        'customer_id',
        'parent_section_id',
        'level'
    ];

    public function section()
    {
        return $this->belongsTo(Section::class, 'parent_section_id');
    }

    public function section_level()
    {
        return $this->belongsTo(SectionLevel::class, 'customer_id', 'customer_id')
                    ->where('section_level.customer_id', '=', 'section.customer_id')
                    ->where('section_level.level', '=', 'section.level');
    }

    public function sections()
    {
        return $this->hasMany(Section::class, 'parent_section_id');
    }

    public function employees()
    {
        return $this->belongsToMany(User::class, 'section_employee')
                    ->withPivot('customer_id');
    }

    public function section_langs()
    {
        return $this->hasMany(SectionLang::class);
    }
}
