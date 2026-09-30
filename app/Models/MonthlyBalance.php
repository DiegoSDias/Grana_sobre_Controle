<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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

    public function scopeFromUser(Builder $query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeYear(Builder $query, int $year)
    {
        return $query->where('year', $year);
    }
}
