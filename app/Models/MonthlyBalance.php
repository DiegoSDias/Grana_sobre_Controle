<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MonthlyBalance extends Model
{
    protected $fillable = [
        'user_id',
        'year',
        'month',
        'closing_balance'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
