<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KudosToGiveTransaction extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kudosRefill()
    {
        return $this->belongsTo(KudosRefill::class, 'kudos_refill_id');
    }
}
