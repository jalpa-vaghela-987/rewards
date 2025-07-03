<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
        // testing
    }

    public function point()
    {
        return $this->belongsTo(Point::class);
        // testing
    }

    public function redemption()
    {
        return $this->belongsTo(Redemption::class);
        // testing
    }
}
