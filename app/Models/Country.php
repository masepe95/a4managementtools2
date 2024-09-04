<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Country
 *
 * @property string $code3
 * @property string $code2
 * @property int $iso_cc
 * @property string $country_name
 * @property string $ar
 * @property string $bg
 * @property string $cs
 * @property string $da
 * @property string $de
 * @property string $el
 * @property string $en
 * @property string $es
 * @property string $et
 * @property string $eu
 * @property string $fi
 * @property string $fr
 * @property string $hu
 * @property string $it
 * @property string $ja
 * @property string $ko
 * @property string $lt
 * @property string $nl
 * @property string $no
 * @property string $pl
 * @property string $pt
 * @property string $ro
 * @property string $ru
 * @property string $sk
 * @property string $sv
 * @property string $th
 * @property string $uk
 * @property string $zh
 * @property string $zh-tw
 *
 * @property Collection|CountryState[] $country_states
 *
 * @package App\Models
 */
class Country extends Model
{
    protected $table = 'country';
    protected $primaryKey = 'code3';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'iso_cc' => 'int'
    ];

    protected $fillable = [
        'code2',
        'iso_cc',
        'country_name',
        'ar',
        'bg',
        'cs',
        'da',
        'de',
        'el',
        'en',
        'es',
        'et',
        'eu',
        'fi',
        'fr',
        'hu',
        'it',
        'ja',
        'ko',
        'lt',
        'nl',
        'no',
        'pl',
        'pt',
        'ro',
        'ru',
        'sk',
        'sv',
        'th',
        'uk',
        'zh',
        'zh-tw'
    ];

    public function country_states()
    {
        return $this->hasMany(CountryState::class, 'code3');
    }
}
