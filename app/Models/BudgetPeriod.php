<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BudgetPeriod extends Model
{
    protected $fillable = [
        'fiscal_year', 'title', 'status', 'total_income',
        'total_expense', 'total_financing', 'document_path',
    ];

    protected $casts = [
        'total_income' => 'decimal:2',
        'total_expense' => 'decimal:2',
        'total_financing' => 'decimal:2',
    ];

    public function budgetItems(): HasMany
    {
        return $this->hasMany(BudgetItem::class)->orderBy('sort_order');
    }

    public function developments(): HasMany
    {
        return $this->hasMany(Development::class);
    }

    public function incomeItems(): HasMany
    {
        return $this->hasMany(BudgetItem::class)->where('type', 'income');
    }

    public function expenseItems(): HasMany
    {
        return $this->hasMany(BudgetItem::class)->where('type', 'expense');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
