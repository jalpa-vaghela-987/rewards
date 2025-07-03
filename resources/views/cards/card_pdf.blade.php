<!DOCTYPE html>
<html>
<head>
    <title>Group cards</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .centered {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>
<body>
<div class="container">
    <div class="heading text-center mb-5">
        <h3 style="color: #0A246A;">Group card</h3>
    </div>
    @if($card == 'active')
        <div>
            <div class="col-xl-12 text-center">
                <h5>Active Group Cards</h5>
            </div>
            @if(Auth::user()->cards->where('active',1)->where('sent_to_recipient',0)->sortbyDesc('created_at')->count())
                @foreach(Auth::user()->cards->where('active',1)->where('sent_to_recipient',0)->sortbyDesc('created_at') as $c)
                    <div class="bg-white m-3 border-2 border-gray-300 border-dashed ">
                        @include('components.card-photo',['card' => $c, 'href'=> route('card.build', $c->id)])
                        <div class="border border-gray-400"></div>
                        <div class="flex m-2 italic text-xs justify-between">
                        <span>Created by {{ data_get($c->creator, 'name')}}
                            on {{\Carbon\Carbon::parse($c->created_at)->format('F jS, Y')}} to be
                            sent
                            to {{ data_get($c->receiver, 'name')}}
                        </span>
                        </d iv>
                    </div>
                @endforeach
            @else
                <div class="text-center mt-3 mb-4">
                    <span>No active group cards.</span>
                </div>
            @endif
        </div>
    @elseif($card == 'sent')
        <div>
            <div class="col-xl-12 text-center">
                <h5>Sent Card</h5>
            </div>
            @if(Auth::user()->cards->where('active',1)->where('sent_to_recipient',1)->sortbyDesc('sent_at')->count())
                @foreach(Auth::user()->cards->where('active',1)->where('sent_to_recipient',1)->sortbyDesc('sent_at') as $c)
                    <div class="bg-white m-3 border-2 border-gray-300 border-dashed ">
                        @include('components.card-photo',['card' => $c, 'href' => url('/card/view/'. $c->token)])
                        <div class="border border-gray-400"></div>
                        <div class="flex m-2 italic text-xs justify-between">
                        <span>
                            Sent to {{ data_get($c->receiver, 'name')}} on {{\Carbon\Carbon::parse($c->sent_at)->format('F jS, Y')}}
                        </span>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center mt-3 mb-4">
                    <span>No sent cards.</span>
                </div>
            @endif
        </div>
    @elseif($card =='receive')
        <div>
            <div class="text-center mb-2">
                <h5>Received Cards</h5>
            </div>
            <div>
                @if(\App\Models\Card::where('active',1)->where('receiver_id',auth()->id())->orderByDesc('sent_at')->count())
                    @foreach(\App\Models\Card::where('active',1)->where('receiver_id',auth()->id())->orderByDesc('sent_at')->get() as $c)
                        <div class="mt-5 text-center">
                            <img src="{{public_path($c->background_photo_path)}}" style="height: 300px;width:300px" class="rounded" >
                            <div class="ml-5 mr-5 text-black  p-3 rounded font-weight-bold" style="background:white">
                                {{$c->headline}}
                            </div>
                            <span class="font-italic">
                            Sent by {{ data_get($c->creator, 'name') }}
                                @if($count = $c->users()->wherePivot('active', 1)->count())
                                    @if($count > 1)
                                        & {{ $count - 1 }} others
                                    @endif
                                @endif
                            on {{\Carbon\Carbon::parse($c->sent_at)->format('F dS, Y')}}
                        </span>
                            <br>
                        </div>
                    @endforeach
                @else
                    <div class="text-center mt-3 mb-4">
                        <span>No received cards.</span>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
</body>
</html>
