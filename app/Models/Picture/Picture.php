<?php

namespace App\Models\Picture;

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
        'url'
    ];

    public function getUrlAttribute()
    {
        return '/uploads/pictures/' . $this->filename;
    }
}