<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
