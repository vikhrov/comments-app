<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property ?int $comment_id
 * @property string $text
 *
 * @mixin Eloquent
 */
class Text extends Model
{
    protected $fillable = [
        'id',
        'comment_id',
        'text',
    ];

    public $timestamps = false;
}
