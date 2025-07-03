<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class UserInvitation extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'role', 'level'];

    public function ghost_user()
    {
        return $this->belongsTo(User::class, 'email', 'email')->active();
    }

    public function set_up($company = null)
    {
        $sender = $company ? null : auth()->user();
        $company = $company ?? auth()->user()->company;

        $this->generate_hash();

        $this->link = '/register/'.$company->alias.'/'.$this->hash;

        if ($sender) {
            $this->sender()->associate($sender);
        }

        $this->company()->associate($company);
    }

    private function generate_hash()
    {
        $this->hash = sha1(time());
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function send_invite()
    {
        Mail::to($this->email)->send(new \App\Mail\UserInvitation($this));
    }
}
