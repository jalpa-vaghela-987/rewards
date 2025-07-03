<?php

namespace App\Http\Controllers;

use App\Jobs\NotifyAddedToGroupCard;
use App\Models\Card;
use App\Models\CardElement;
use Auth;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class CardController extends Controller
{
    //

    public function create()
    {
        return view('cards.create');
    }

    public function build(Card $card)
    { //edit the card once it is made
        //prob should redirect if user is not on the team, not a major issue
        return view('cards.build', ['card' => $card]);
    }

    public function cards()
    { //edit the card once it is made
        return view('cards.cards');
    }

    public function people(Card $card)
    { //edit the card once it is made
        return view('cards.people', ['card' => $card]);
    }

    public function notify(Card $card)
    {
        if (Auth::user()->id != $card->creator->id) {
            return 'invalid user';
        }

        foreach ($card->users as $user) {
            if ($user->id !== Auth::user()->id) {// first makes sure its not sending a notification to yourself
                if ($card->users()->wherePivot('notified', '=', 0)->get()->contains($user)) {
                    // checks if they got it already (for future edits)

//                    $job = (new NotifyAddedToGroupCard($user, $card));
//                    $job = $job->delay(now()->addSeconds(2));
//                    dispatch($job);

//                    NotifyAddedToGroupCard::dispatch($user, $card)->delay(now()->addSeconds(2));

                    dispatch(new NotifyAddedToGroupCard($user, $card))->delay(now()->addSeconds(2));

                    if (env('MAIL_HOST', false) === 'smtp.mailtrap.io') {
                        sleep(2);
                    }

                    //$user->notify(new InvitedToGroupCard($card));
                    //$user->cards()->updateExistingPivot($card->id, ['notified' => 1]);
                }
            }
        }

        return redirect()->route('card.build', $card->id);
    }

    public function edit(Card $card)
    {
        return view('cards.edit', ['card' => $card]);
    }

    public function preview(Card $card)
    {
        return view('cards.preview', ['card' => $card]);
    }

    public function view(Card $card)
    {
        if (request('sent')) {
            session()->flash('flash.banner', 'Card Sent!');

            return redirect()->to(url('/card/view/'.$card->token));
        }

        return view('cards.view', ['card' => $card]);
    }

//    public function download(Card $card)
//    {
//        $fileName = 'card-'.$card->token.'.pdf';
//
//        return PDF::loadView('cards.content', ['card' => $card])->download($fileName);
//    }

    public function delete(Card $card)
    {
        $card->active = 0;
        $card->save();

        session()->flash('flash.banner', 'Group card successfully deleted');

        return redirect()->back();
    }

    public function createPDF($card)
    {
        $data = Card::all();
        $pdf = PDF::loadView('cards.card_pdf', compact('data', 'card'));

        return $pdf->download('Group_card_details.pdf');
    }

    // used for chunk upload - compatible with resumable.js (not in use)
    public function chunkFileUpload(Request $request, CardElement $cardElement = null)
    {
        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

        $fileReceived = $receiver->receive();

        if ($fileReceived->isFinished()) {
            $driver = 'public';
            $storageDisk = \Storage::disk($driver);
            $file = $fileReceived->getFile();
            $extension = $file->getClientOriginalExtension();
            $name = Str::random().'_'.md5(time()).'.'.$extension;

            $mime = $file->getMimeType();
            $path = $storageDisk->putFileAs('card-media', $file, $name);
            $storageDisk->setVisibility($path, 'public');

            unlink($file->getPathname());

            if ($cardElement) {
                if ($driver === 's3') {
                    $cardElement->media_path = 'https://perksweet-uploads.s3.amazonaws.com/'.$path;
                } else {
                    $cardElement->media_path = url($path);
                }

                $cardElement->media_type = explode('/', $mime)[0];
                $cardElement->save();
            }

            return [
                'path'     => $path,
                'filename' => $name,
            ];
        }

        $handler = $fileReceived->handler();

        return [
            'done'   => $handler->getPercentageDone(),
            'status' => true,
        ];
    }
}
