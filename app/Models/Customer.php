<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Customer
 *
 * @property int $id
 * @property string $name
 * @property string|null $company_uid
 * @property string|null $address1
 * @property string|null $address2
 * @property string|null $city
 * @property string|null $zip
 * @property int|null $country_state_id
 * @property string|null $vat
 * @property string|null $number_of_users
 * @property string $customer_type
 * @property string $customer_status
 * @property string $use_saml
 * @property string|null $logo_file
 *
 * @property CountryState|null $country_state
 * @property Collection|Contact[] $contacts
 * @property Collection|CustomerHierarchy[] $customer_hierarchies
 * @property Collection|Tool[] $tools
 * @property Collection|Employee[] $employees
 * @property Collection|SectionLevel[] $section_levels
 *
 * @package App\Models
 */
class Customer extends Model
{
    protected $table = 'customer';
    public $timestamps = false;

    protected $casts = [
        'country_state_id' => 'int'
    ];

    protected $fillable = [
        'name',
        'company_uid',
        'address1',
        'address2',
        'city',
        'zip',
        'country_state_id',
        'vat',
        'number_of_users',
        'customer_type',
        'customer_status',
        'use_saml',
        'logo_file'
    ];

    public function country_state()
    {
        return $this->belongsTo(CountryState::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function customer_hierarchies()
    {
        return $this->hasMany(CustomerHierarchy::class);
    }

    public function tools()
    {
        return $this->belongsToMany(Tool::class)
                    ->withPivot('enabled');
    }

    public function employees()
    {
        return $this->hasMany(User::class);
    }

    public function section_levels()
    {
        return $this->hasMany(SectionLevel::class);
    }
}
