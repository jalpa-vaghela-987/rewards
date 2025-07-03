<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Point extends Model
{
    use HasFactory, Notifiable;

    public const TYPE_STANDARD = 'standard';
    public const TYPE_SUPER = 'super';
    public const TYPE_BIRTHDAY = 'birthday';
    public const TYPE_ANNIVERSARY = 'anniversary';
    public const TYPE_WELCOME = 'welcome';

    public $special_types = [self::TYPE_BIRTHDAY, self::TYPE_ANNIVERSARY];

    public function giver()
    {
        return $this->belongsTo(User::class, 'from_id');
    }

    public function reciever()
    {
        return $this->belongsTo(User::class, 'user_id');
        // testing
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'user_id');
        // testing
    }

    public function recieverTeam()
    {
        return $this->belongsTo(User::class, 'team_id');
    }

    public function scopeVisible($query)
    {
        return $query->where('hidden', 0);
    }

    public function scopePrivate($query)
    {
        return $query
                ->where('hidden', 1)
                ->whereIn('type', $this->privateTypes())
                ->where(function ($q) {
                    $q->where('from_id', auth()->id())->orWhere(
                        'user_id',
                        auth()->id()
                    );
                }) /*->where('hidden_by', auth()->id())*/;
    }

    public function privateTypes(): array
    {
        return [
            self::TYPE_STANDARD,
            self::TYPE_SUPER,
            self::TYPE_ANNIVERSARY,
            self::TYPE_BIRTHDAY,
        ];
    }

    public function isSpecial()
    {
        return in_array($this->type, $this->special_types);
    }

    public function getIsSuperAttribute()
    {
        return $this->type === self::TYPE_SUPER;
    }

    public function points()
    {
        return $this->belongsTo(
            KudosToGiveTransaction::class,
            'kudos_to_give_transaction_id'
        );
        // testing
    }

    public function getHiddenByDeveloperAttribute()
    {
        if ($this->hidden && $this->hidden_by) {
            return User::where('developer', 1)
                ->where('id', $this->hidden_by)
                ->exists();
        }

        return false;
    }
}
