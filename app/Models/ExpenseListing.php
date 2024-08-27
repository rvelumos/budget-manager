<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseListing extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id'];

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
