<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExpenseListing extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id'];

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class, 'expense_listing_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
