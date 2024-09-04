<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CustHierarchyLang
 *
 * @property int $id
 * @property int $customer_hierarchy_id
 * @property int $level
 * @property string $lang_code
 * @property string $name
 *
 * @property CustHierarchy $cust_hierarchy
 * @property Language $language
 *
 * @package App\Models
 */
class CustHierarchyLang extends Model
{
    protected $table = 'cust_hierarchy_lang';
    public $timestamps = false;

    protected $casts = [
        'customer_hierarchy_id' => 'int',
        'level' => 'int'
    ];

    protected $fillable = [
        'customer_hierarchy_id',
        'level',
        'lang_code',
        'name'
    ];

    public function cust_hierarchy()
    {
        return $this->belongsTo(CustHierarchy::class, 'customer_hierarchy_id', 'customer_hierarchy_id')
                    ->where('cust_hierarchy.customer_hierarchy_id', '=', 'cust_hierarchy_lang.customer_hierarchy_id')
                    ->where('cust_hierarchy.level', '=', 'cust_hierarchy_lang.level');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'lang_code');
    }
}
