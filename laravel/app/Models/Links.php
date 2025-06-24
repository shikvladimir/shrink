<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Links
 *
 * @property int $id
 * @property int $user_id
 * @property string $alias
 * @property string|null $name
 * @property string $link
 * @property int $clicks
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property \App\Models\User $user
 *
 * @mixin \Eloquent
 */
class Links extends Model
{
    const TABLE = 'links';

    const FIELD_ID      = 'id';
    const FIELD_USER_ID = 'user_id';
    const FIELD_ALIAS   = 'alias';
    const FIELD_NAME   = 'name';
    const FIELD_LINK    = 'link';
    const FIELD_CLICKS  = 'clicks';

    protected $fillable = [
        self::FIELD_ID,
        self::FIELD_USER_ID,
        self::FIELD_ALIAS,
        self::FIELD_NAME,
        self::FIELD_LINK,
        self::FIELD_CLICKS,
    ];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class)->selectRaw('id,name');
    }
}
