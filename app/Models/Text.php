<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @property int $id
 * @property ?int $comment_id
 * @property string $text
 *
 * @mixin \Eloquent
 */
    class Text extends Model
    {
        protected $fillable =
            [
                'id',
                'comment_id',
                'text',
            ];

        public $timestamps = false;
    }
