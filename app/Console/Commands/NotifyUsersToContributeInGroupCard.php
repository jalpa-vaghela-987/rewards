<?php

namespace App\Console\Commands;

use App\Models\Card;
use App\Models\User;
use App\Notifications\RemindToContributeInGroupCard;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class NotifyUsersToContributeInGroupCard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:users-to-contribute-in-group-card';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $cardsCusror = Card::active()
            ->notSent()
            ->with([
                'users' => function ($query) {
                    $query->where('card_user.active', 1);
                },
                'card_elements' => function ($query) {
                    $query->where('active', 1);
                },
            ])
            ->cursor();

        foreach ($cardsCusror as $card) {
            $userIds = $card->users->pluck('id')->toArray();
            $senderIds = $card->card_elements->pluck('user_id')->toArray();
            $toBeNotifiedUserIds = array_diff($userIds, $senderIds);

            $users = User::whereIn('id', $toBeNotifiedUserIds)->where('id', '!=', $card->creator_id)->get();

            Notification::send($users, new RemindToContributeInGroupCard($card));
        }

        return Command::SUCCESS;
    }
}
