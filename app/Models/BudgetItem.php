<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BudgetItem extends Model
{
    protected $fillable = [
        'budget_period_id', 'type', 'code', 'category', 'sub_category',
        'item_name', 'planned_amount', 'revised_amount', 'realized_amount',
        'percentage', 'source_fund', 'notes', 'sort_order',
    ];

    protected $casts = [
        'planned_amount' => 'decimal:2',
        'revised_amount' => 'decimal:2',
        'realized_amount' => 'decimal:2',
        'percentage' => 'decimal:2',
    ];

    public function budgetPeriod(): BelongsTo
    {
        return $this->belongsTo(BudgetPeriod::class);
    }

    public function scopeIncome($query)
    {
        return $query->where('type', 'income');
    }

    public function scopeExpense($query)
    {
        return $query->where('type', 'expense');
    }

    public function scopeFinancing($query)
    {
        return $query->where('type', 'financing');
    }
}
