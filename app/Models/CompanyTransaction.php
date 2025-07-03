<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyTransaction extends Model
{
    use HasFactory;

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function redemption()
    {
        return $this->belongsTo(Redemption::class);
    }

    public function fundedByDeveloper(): bool
    {
        return $this->user->developer === 1;
    }
}
