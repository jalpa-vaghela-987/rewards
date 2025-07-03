<?php

namespace App\Jobs;

use App\Models\Company;
use App\Models\Redemption;
use App\Notifications\RequestRewardRedemption;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendRewardRedemptionRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Company
     */
    public $company;
    public $redemption;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($companyId, $redemptionId)
    {
        $this->company = Company::find($companyId);
        $this->redemption = Redemption::find($redemptionId);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->company->users()->where('role', 1)->each(function ($adminUser) {
            $adminUser->notify(new RequestRewardRedemption($this->redemption->id));
        });
    }
}
