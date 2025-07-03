<?php

namespace App\Http\Controllers;

use App\Models\Point;
use App\Models\Transaction;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PointController extends Controller
{
    public function give(Request $request)
    {
        $user = User::find(2);

        return Auth::user()->givePoints($user, 10, 'test');
    }

    public function show(User $user)
    {
        if ($user->id === Auth::user()->id) {
            return 'Invalid. You cannot give '.getReplacedWordOfKudos().' to yourself.';
        }

        return view('points.show', ['user' => $user]);
    }

    public function store(Request $request)
    {
        $rules = [
            'kudos_type'        => ['required', Rule::in(['standard', 'super', 'birthday', 'anniversary'])],
            'message'           => ['nullable', 'string', 'min:1', 'max:10000'],
            'user_id'           => ['required', Rule::exists('users', 'id'), 'different:'.Auth::user()->id],
        ];
        $customMessages = [
            'kudos_type.required' => 'The '.getReplacedWordOfKudos().' type  field is required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $kudos_type = $request->kudos_type;

        $isSuperKudos = false;

        switch ($kudos_type) {
            case 'standard':
                $amount = Auth::user()->company->standard_value;
                break;
            case 'super':
                $amount = Auth::user()->company->super_value;
                $isSuperKudos = true;
                break;
        }

        $user = User::find($request->user_id);
        if ($user->id == auth()->user()->id) {
            return 'Invalid. You cannot give Kudos to yourself.';
        }
        $message = htmlentities(htmlspecialchars($request->message));
//        $amount = $request->amount;

        $point = auth()->user()->givePoints($user, $amount, $message, $isSuperKudos);

        if ($point instanceof Point) {
            $t = new Transaction;
            $t->user()->associate($user);
            $t->point()->associate($point);
            if ($isSuperKudos) {
                $t->note = auth()->user()->name.' sent you super '.getReplacedWordOfKudos();
            } else {
                $t->note = auth()->user()->name.' sent you '.getReplacedWordOfKudos();
            }
            $t->link = '/received/'.$point->id;
            $t->amount = $amount;
            $t->type = 1;
            $t->data = json_encode($point);
            $t->save();

            session()->flash('flash.banner', getReplacedWordOfKudos().' sent!');

            return redirect()->route('kudos.store2', ['point' => $point]);
        }

        return redirect()->back()->withErrors(['message' => $point]);
    }

    public function storeForAdmin(Request $request)
    {
        return $this->storeForDeveloper($request);
    }

    public function storeForDeveloper(Request $request)
    {
        $request->merge(['user_id' => json_decode($request->user_id)]);

        $rules = [
            'company'           => ['required', Rule::exists('companies', 'name')],
            'kudos_type'        => ['required', Rule::in(['standard', 'super', 'birthday', 'anniversary'])],
            'message'           => ['nullable', 'string', 'min:1', 'max:10000'],
            'kudos_amount'      => ['required', 'min:0', 'max:100000', 'numeric'],
        ];

        if ($request->user_id && is_array($request->user_id)) {
            $rules = array_merge($rules, [
                'user_id' => ['required', Rule::exists('users', 'id')->where('company_id', auth()->user()->company_id)],
            ]);
        } else {
            $rules = array_merge($rules, [
                'user_id' => ['required', Rule::exists('users', 'id'), 'different:'.auth()->user()->id],
            ]);
        }

        $customMessages = [
            'kudos_amount.required'      => 'The '.getReplacedWordOfKudos().' amount field is required.',
            'kudos_type.required' => 'The '.getReplacedWordOfKudos().' type  field is required.',
        ];

        $this->validate($request, $rules, $customMessages);

        $kudos_type = $request->kudos_type;
        $isSuperKudos = $kudos_type === 'super';
        $amount = $request->get('kudos_amount');
        $message = htmlentities(htmlspecialchars($request->message));

        $userIds = $request->user_id;
        if (! is_array($userIds)) {
            $userIds = [$userIds];
        }

        $users = User::whereIn('id', $userIds)->get();

        $point = null;

        foreach ($users as $user) {
            $point = auth()->user()->givePointsFromDeveloper($user, $amount, $message, $isSuperKudos);

            if ($point instanceof Point) {
                $t = new Transaction;
                $t->user()->associate($user);
                $t->point()->associate($point);
                if ($isSuperKudos) {
                    $t->note = auth()->user()->name.' sent you super '.getReplacedWordOfKudos();
                } else {
                    $t->note = auth()->user()->name.' sent you '.getReplacedWordOfKudos();
                }
                $t->link = '/received/'.$point->id;
                $t->amount = $amount;
                $t->type = 1;
                $t->data = json_encode($point);
                $t->save();
            }
        }

        session()->flash('flash.banner', getReplacedWordOfKudos().' sent!');

        if (count($users) > 1) {
            return redirect()->route('kudos.feed');
        }

        return redirect()->route('kudos.store2', ['point' => $point]);
    }

    public function store2(Point $point)
    {
        if ($point->giver->id !== Auth::user()->id) {
            return 'invalid request';
        }

        return view('points.store', ['point' => $point]);
    }

    public function received(Point $point)
    {
        //check if the user matches
        if ($point->reciever->id !== Auth::user()->id) {
            return 'invalid request';
        }

        $n = Auth::user()->unreadNotifications->where('type', \App\Notifications\PointReceived::class);

        foreach ($n as $i) {
            if (intval($i->data['obj_id']) == $point->id) {
                $i->markAsRead();

                return redirect()->route('kudos.received', ['point' => $point->id]);
            }
        }

        return view('points.received', ['point' => $point]);
    }

    public function kudosGifting()
    {
        return view('points.admin-gifting');
    }
}
