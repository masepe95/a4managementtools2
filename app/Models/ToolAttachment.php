<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ToolAttachment
 *
 * @property int $id
 * @property string $filename
 * @property int $id_tool
 * @property string $data_file
 * @property string $mime_type
 * @property int $file_size
 * @property string $attachment_type
 *
 * @property Tool $tool
 *
 * @package App\Models
 */
class ToolAttachment extends Model
{
    protected $table = 'tool_attachment';
    public $timestamps = false;

    protected $casts = [
        'id_tool' => 'int',
        'file_size' => 'int'
    ];

    protected $fillable = [
        'filename',
        'id_tool',
        'data_file',
        'mime_type',
        'file_size',
        'attachment_type'
    ];

    public function tool()
    {
        return $this->belongsTo(Tool::class, 'id_tool');
    }
}
