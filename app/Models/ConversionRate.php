<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ConversionRate extends Model
{
    use HasFactory;

    protected $fillable = ['reward_currency', 'base_currency', 'base_fx'];

    public function scopeReward($query, $value)
    {
        return $query->where('reward_currency', Str::upper($value));
    }

    public function scopeBase($query, $value)
    {
        return $query->where('base_currency', Str::upper($value));
    }
}
