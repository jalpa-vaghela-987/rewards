<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SlackController extends Controller
{
    public function __construct()
    {
        $this->app_id = config('services.slack.app_id');
        $this->client_id = config('services.slack.client_id');
        $this->client_secret = config('services.slack.client_secret');
        $this->signing_secret = config('services.slack.sign_in_secret');
        $this->verification_token = config('services.slack.verification_token');
        $this->endpoint = config('services.slack.endpoint');
    }

    public function test()
    {
        return 'here';
    }

    public function integrate(Request $r)
    {
        $code = $r->code;
        $state = $r->state;

        $response = Http::asForm()->post($this->endpoint.'oauth.v2.access', [
            'client_id'     => $this->client_id,
            'client_secret' => $this->client_secret,
            'code'          => $r->code,
        ]);
        $body = (json_decode($response->body()));
        // dump($body);
        // return;

        if ($body->ok === false) {
            return 'Error in response, please try again.';
        }
        if (! $body->incoming_webhook) {
            return 'No Webhook, please try again.';
        }
        if (! $body->incoming_webhook->url) {
            return 'No Webhook URL, please try again.';
        }

        logger($state);
        logger($body->incoming_webhook->url);

        $u = User::find($state);
        logger($u);
        if ($c = $u->company) {
            logger($c);
        }

        if (! $c) {
            $u = Auth::user();
            if ($u) {
                $c = $u->company;
            }
            logger('did not receive valid state');
        }

        if (! $c) {
            return 'Invalid request, please try again or contact support.';
        }

        $c->slack_webhook = $body->incoming_webhook->url;
        $c->enable_slack = 1;
        $c->save();

        logger('about to redirect');

        return redirect(url('/company/manage'));
    }
}
