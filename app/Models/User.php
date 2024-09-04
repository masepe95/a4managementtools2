<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

/**
 * Class User (table 'employee')
 *
 * @property int $id
 * @property int $customer_id
 * @property string|null $acronym
 * @property string|null $employee_id
 * @property string $firstname
 * @property string $lastname
 * @property string $role
 * @property string|null $job_title
 * @property string|null $phone
 * @property string|null $mobile_phone
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property string $language_code
 * @property string|null $photo_file
 * @property int $failed_passwords
 * @property Carbon|null $password_failure_time
 * @property string $employee_status
 *
 * @property Customer $customer
 * @property Language $language
 * @property Collection|ActionLog[] $action_logs
 * @property Collection|EmployeeHierarchy[] $employee_hierarchies
 * @property Collection|Tool[] $tools
 * @property Collection|EmployeeTool[] $employee_tools
 * @property Collection|Job[] $jobs
 * @property Collection|JobVisibility[] $job_visibilities
 * @property Collection|PersonalEmployeeGroup[] $personal_employee_groups
 * @property Collection|PersonalGroup[] $personal_groups
 * @property Collection|PersonalJobVisibility[] $personal_job_visibilities
 * @property Collection|ResEmployeeResAccess[] $res_employee_res_accesses
 * @property Collection|Section[] $sections
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'employee';
    public $timestamps = false;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'customer_id' => 'int',
        'email_verified_at' => 'datetime',
        'failed_passwords' => 'int',
        'password_failure_time' => 'datetime'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'acronym',
        'employee_id',
        'firstname',
        'lastname',
        'role',
        'job_title',
        'phone',
        'mobile_phone',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'language_code',
        'photo_file',
        'failed_passwords',
        'password_failure_time',
        'employee_status'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_code');
    }

    public function action_logs()
    {
        return $this->hasMany(ActionLog::class);
    }

    public function employee_hierarchies()
    {
        return $this->hasMany(EmployeeHierarchy::class);
    }

    public function tools()
    {
        return $this->belongsToMany(Tool::class, 'employee_personal_tool')
                    ->withPivot('enabled');
    }

    public function employee_tools()
    {
        return $this->hasMany(EmployeeTool::class, 'customer_id', 'customer_id');
    }

    public function jobs()
    {
        return $this->hasMany(Job::class, 'editor_id');
    }

    public function job_visibilities()
    {
        return $this->hasMany(JobVisibility::class);
    }

    public function personal_employee_groups()
    {
        return $this->hasMany(PersonalEmployeeGroup::class, 'group_employee_id');
    }

    public function personal_groups()
    {
        return $this->hasMany(PersonalGroup::class);
    }

    public function personal_job_visibilities()
    {
        return $this->hasMany(PersonalJobVisibility::class);
    }

    public function res_employee_res_accesses()
    {
        return $this->hasMany(ResEmployeeResAccess::class);
    }

    public function sections()
    {
        return $this->belongsToMany(Section::class, 'section_employee')
                    ->withPivot('customer_id');
    }
}
