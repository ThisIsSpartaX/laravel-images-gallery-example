<?php

namespace App\Models\Picture;

use App\Services\PictureService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Picture
 *
 * @property-read $id;
 * @property string $filename;
 * @property string $hash;
 * @property boolean $is_completed;
 * @property Carbon $created_at;
 * @property Carbon $updated_at;
 * @property Carbon $deleted_at;
 *
 * @package app\models\Picture
 */
class Picture extends Model
{
    protected $table = 'pictures';

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $appends = [
        'original_url',
        'thumbnail_url',
        'lossy_url'
    ];

    public function getOriginalUrlAttribute()
    {
        return PictureService::getFileUrl($this->filename, 'original');
    }

    public function getThumbnailUrlAttribute()
    {
        return PictureService::getFileUrl($this->filename, 'thumbnail');
    }

    public function getLossyUrlAttribute()
    {
        return PictureService::getFileUrl($this->filename, 'lossy');
    }
}