<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PersonalJobAttachment
 *
 * @property int $id
 * @property string $filename
 * @property int $personal_job_id
 * @property string $data_file
 * @property string $mime_type
 * @property int $file_size
 * @property string $attachment_type
 *
 * @property PersonalJob $personal_job
 *
 * @package App\Models
 */
class PersonalJobAttachment extends Model
{
    protected $table = 'personal_job_attachment';
    public $timestamps = false;

    protected $casts = [
        'personal_job_id' => 'int',
        'file_size' => 'int'
    ];

    protected $fillable = [
        'filename',
        'personal_job_id',
        'data_file',
        'mime_type',
        'file_size',
        'attachment_type'
    ];

    public function personal_job()
    {
        return $this->belongsTo(PersonalJob::class);
    }
}
