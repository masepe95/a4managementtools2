<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CountryState
 *
 * @property int $id
 * @property string $code3
 * @property string $code2
 * @property string $subdiv
 * @property string|null $subdiv_name
 * @property string|null $level_name
 *
 * @property Country $country
 * @property Collection|Customer[] $customers
 *
 * @package App\Models
 */
class CountryState extends Model
{
    protected $table = 'country_state';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'id' => 'int'
    ];

    protected $fillable = [
        'code3',
        'code2',
        'subdiv',
        'subdiv_name',
        'level_name'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'code3');
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
