<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    public function scopeNotSent($query)
    {
        return $query->whereNull('sent_at');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function card_elements()
    {
        return $this->hasMany(CardElement::class, 'card_id');
    }

    public function get_users()
    {
        return $this->team->users;
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot(
            'active',
            'has_published',
            'notified'
        );
    }

    public function active_users()
    {
        return $this->users()->wherePivot('active', true);
    }
}
