<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function redemptions()
    {
        return $this->hasMany(Redemption::class);
    }

    public function recent_redemption()
    {
        return $this->hasOne(Redemption::class)->latest();
    }

    public function getCurrencyAttribute($value)
    {
        if (! $this->is_custom) {
            $tangoData = json_decode($this->tango_data);

            if (isset($tangoData, $tangoData->items)) {
//                $this->currency= data_get($tangoData, 'items.0.currencyCode');
                return data_get($tangoData, 'items.0.currencyCode');
            }
        }

        return $value;
    }

    public function getRewardCountAttribute($value)
    {
        return $this->redemptions->count();
    }

    public function toggleApproval()
    {
        $this->approval_needed = ! $this->approval_needed;
        $this->save();
    }

    public function toggleDisable()
    {
        $this->disabled = ! $this->disabled;
        $this->save();
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeIsCustom($query)
    {
        return $query->where('is_custom', 1);
    }

    public function scopeIsNotCustom($query)
    {
        return $query->where('is_custom', 0);
    }

    public function scopeIsEnabled($query)
    {
        return $query->where('disabled', 0);
    }

    public function scopeIsDisabled($query)
    {
        return $query->where('disabled', 1);
    }

    public function scopeForCompany($query, $companyId = null)
    {
        return $query->where(
            'company_id',
            $companyId ?? auth()->user()->company_id
        );
    }
}
