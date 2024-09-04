<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class JobAttachment
 *
 * @property int $id
 * @property string $filename
 * @property int $job_id
 * @property string $data_file
 * @property string $mime_type
 * @property int $file_size
 * @property string $attachment_type
 *
 * @property Job $job
 *
 * @package App\Models
 */
class JobAttachment extends Model
{
    protected $table = 'job_attachment';
    public $timestamps = false;

    protected $casts = [
        'job_id' => 'int',
        'file_size' => 'int'
    ];

    protected $fillable = [
        'filename',
        'job_id',
        'data_file',
        'mime_type',
        'file_size',
        'attachment_type'
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
