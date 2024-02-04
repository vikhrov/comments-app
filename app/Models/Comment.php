<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $user_name
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 * @property string $email
 * @property string $home_page
 * @property ?int $parent_id
 * @property-read Text $text
 *
 * @mixin \Eloquent
 */

class Comment extends Model
{
    protected $fillable =
        [
            'id',
            'user_name',
            'email',
            'home_page',
            'parent_id',
        ];

    public function text(): HasOne
    {
        return $this->hasOne(Text::class);
    }

}
