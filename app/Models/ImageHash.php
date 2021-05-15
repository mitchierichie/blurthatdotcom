<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImageHash extends Model
{
    use HasFactory;

    const IMAGE_HASH_UUID_NAMESPACE = 'd5b2ac76-9c11-465d-9ec8-735d4fc66fd0';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
