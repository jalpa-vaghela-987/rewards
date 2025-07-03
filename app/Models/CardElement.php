<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vimeo\Vimeo;

class CardElement extends Model
{
    use HasFactory;

    public function scopePublished($query)
    {
        return $query->where('active', 1);
    }

    public function scopeNotPublished($query)
    {
        return $query->where('active', 0);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    public function getMediaProcessedAttribute()
    {
        if (is_numeric($this->media_path)) {
            $client = new Vimeo(
                env('VIMEO_CLIENT_IDENTIFIER'),
                env('VIMEO_CLIENT_SECRET'),
                env('VIMEO_ACCESS_TOKEN')
            );

            return data_get(
                $client->request(
                    "/videos/$this->media_path".'?fields=transcode.status'
                ),
                'body.transcode.status',
                'complete'
            ) === 'complete';
        }

        return true;
    }
}
