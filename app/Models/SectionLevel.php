<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SectionLevel
 *
 * @property int $id
 * @property int $customer_id
 * @property int $level
 *
 * @property Customer $customer
 * @property Collection|Section[] $sections
 * @property Collection|SectionLevelLang[] $section_level_langs
 *
 * @package App\Models
 */
class SectionLevel extends Model
{
    protected $table = 'section_level';
    public $timestamps = false;

    protected $casts = [
        'customer_id' => 'int',
        'level' => 'int'
    ];

    protected $fillable = [
        'customer_id',
        'level'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class, 'customer_id', 'customer_id');
    }

    public function section_level_langs()
    {
        return $this->hasMany(SectionLevelLang::class, 'customer_id', 'customer_id');
    }
}
