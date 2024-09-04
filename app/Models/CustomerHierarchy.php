<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CustomerHierarchy
 *
 * @property int $id
 * @property int $customer_id
 * @property string $name
 *
 * @property Customer $customer
 * @property Collection|CustHierarchy[] $cust_hierarchies
 *
 * @package App\Models
 */
class CustomerHierarchy extends Model
{
    protected $table = 'customer_hierarchy';
    public $timestamps = false;

    protected $casts = [
        'customer_id' => 'int'
    ];

    protected $fillable = [
        'customer_id',
        'name'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function cust_hierarchies()
    {
        return $this->hasMany(CustHierarchy::class);
    }
}
