<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Income;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IncomeListing extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id'];

    public function incomes(): HasMany
    {
        return $this->hasMany(Income::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
