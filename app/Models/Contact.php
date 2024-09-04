<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Contact
 *
 * @property int $id
 * @property int $customer_id
 * @property string $firstname
 * @property string $lastname
 * @property string|null $additional_name
 * @property string|null $job_title
 * @property string|null $phone
 * @property string|null $mobile_phone
 * @property string $email
 * @property string|null $notes
 *
 * @property Customer $customer
 *
 * @package App\Models
 */
class Contact extends Model
{
    protected $table = 'contact';
    public $timestamps = false;

    protected $casts = [
        'customer_id' => 'int'
    ];

    protected $fillable = [
        'customer_id',
        'firstname',
        'lastname',
        'additional_name',
        'job_title',
        'phone',
        'mobile_phone',
        'email',
        'notes'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
