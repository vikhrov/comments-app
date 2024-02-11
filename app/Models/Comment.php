<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property int $id
 * @property string $user_name
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 * @property string $email
 * @property string $home_page
 * @property ?int $parent_id
 * @property-read Text $text
 * @property-read Collection <int, Media>|Media[] $media
 *
 * @mixin Eloquent
 */

class Comment extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $fillable = [
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

    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
