<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Events\TeamDeleted;
use Laravel\Jetstream\Events\TeamUpdated;
use Laravel\Jetstream\Team as JetstreamTeam;

class Team extends JetstreamTeam
{
    use HasFactory;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'personal_team' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'personal_team'];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => TeamCreated::class,
        'updated' => TeamUpdated::class,
        'deleted' => TeamDeleted::class,
    ];

    public function admins()
    {
        return $this->belongsToMany(User::class)->wherePivot('role', 'admin');
    }

    public function setRandomOwner($user)
    {
        if ($this->user_id == $user->id) {
            $randomAdmin = $this->admins()->inRandomOrder()->first();

            if (! $randomAdmin) {
                if ($randomMember = $this->users()->inRandomOrder()->first()) {
                    DB::table('team_user')
                        ->where('team_id', $this->id)
                        ->where('user_id', $randomMember->id)
                        ->update(['role' => 'admin']);

                    $randomAdmin = $randomMember->fresh();
                } else {
                    $this->delete();

                    return;
                }
            }

            $this->forceFill([
                'user_id' => data_get($randomAdmin, 'id'),
            ])->save();
        }
    }
}
