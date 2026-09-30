<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Expense extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'date',
        'month',
        'year',
        'payment_mode',
        'type',
        'description',
        'amount',
        'is_installment',
        'current_installment',
        'total_installments',
        'installments_group'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }

    public function scopeFromUser(Builder $query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeIncome(Builder $query)
    {
        return $query->where('type', 'income');
    }

    public function scopeExpense(Builder $query)
    {
        return $query->where('type', 'expense');
    }

    public function scopeYear(Builder $query, int $year)
    {
        return $query->where('year', $year);
    }

    public function scopeGroupedByMonth(Builder $query): Builder
    {
        return $query
            ->selectRaw('month, SUM(amount) as total')
            ->groupBy('month');
    }
}
