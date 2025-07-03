<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    public function create(User $u1, User $u2)
    {
        $this->user1()->associate($u1);
        $this->user2()->associate($u2);

        $this->user_1_interests = $u1->meetingConfig->interests;
        $this->user_2_interests = $u2->meetingConfig->interests;

        $this->user_1_expertise = $u1->meetingConfig->expertise;
        $this->user_2_expertise = $u2->meetingConfig->expertise;

        $this->user_1_develop = $u1->meetingConfig->develop;
        $this->user_2_develop = $u2->meetingConfig->develop;
        $this->save();
    }

    public function user1()
    {
        return $this->belongsTo(User::class, 'user1_id');
    }

    public function user2()
    {
        return $this->belongsTo(User::class, 'user2_id');
    }

    public function get_other_user()
    {
        if ($this->user1->id == Auth::user()->id) {
            return $this->user2;
        }

        return $this->user1;
    }
}
