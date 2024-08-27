<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = ['amount', 'category_id', 'date', 'description', 'user_id', 'expense_listing_id'];

    public function expenseList()
    {
        return $this->belongsTo(ExpenseList::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
