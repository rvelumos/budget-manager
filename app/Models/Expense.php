<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = ['amount', 'category_id', 'date', 'description', 'user_id', 'expense_listing_id'];

    public function expenseList(): BelongsTo
    {
        return $this->belongsTo(ExpenseListing::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
