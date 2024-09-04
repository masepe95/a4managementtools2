<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CustHierarchy
 *
 * @property int $id
 * @property int $customer_hierarchy_id
 * @property int $level
 *
 * @property CustomerHierarchy $customer_hierarchy
 * @property Collection|CustHierarchyLang[] $cust_hierarchy_langs
 *
 * @package App\Models
 */
class CustHierarchy extends Model
{
    protected $table = 'cust_hierarchy';
    public $timestamps = false;

    protected $casts = [
        'customer_hierarchy_id' => 'int',
        'level' => 'int'
    ];

    protected $fillable = [
        'customer_hierarchy_id',
        'level'
    ];

    public function customer_hierarchy()
    {
        return $this->belongsTo(CustomerHierarchy::class);
    }

    public function cust_hierarchy_langs()
    {
        return $this->hasMany(CustHierarchyLang::class, 'customer_hierarchy_id', 'customer_hierarchy_id');
    }
}
