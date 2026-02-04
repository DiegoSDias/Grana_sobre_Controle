<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categories extends Model
{
    protected $fillable = [
        'user_id',
        'group_id',
        'name',
        'type'
    ];

    public function expenses(): HasMany {
        return $this->hasMany(Expenses::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function group(): BelongsTo {
        return $this->belongsTo(Groups::class);
    }
}
