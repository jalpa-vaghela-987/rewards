<?php

namespace Database\Factories;

use App\Models\Point;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class PointFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Point::class;
    protected $testing = '
    <span class="ql-emojiblot" data-name="sunglasses">﻿<span contenteditable="false"><span class="ap ap-sunglasses">😎</span></span>
    ﻿</span><span class="ql-emojiblot" data-name="ok_hand">﻿<span contenteditable="false"><span class="ap ap-ok_hand">👌</span></span>
    ﻿</span><span class="ql-emojiblot" data-name="thumbsup">﻿<span contenteditable="false"><span class="ap ap-thumbsup">👍</span></span>
    ﻿</span><span class="ql-emojiblot" data-name="raised_hands">﻿<span contenteditable="false"><span class="ap ap-raised_hands">🙌</span></span>
    ﻿</span><span class="ql-emojiblot" data-name="point_up_2">﻿<span contenteditable="false"><span class="ap ap-point_up_2">👆</span></span>
    ﻿</span><span class="ql-emojiblot" data-name="clap">﻿<span contenteditable="false"><span class="ap ap-clap">👏</span></span>
    ﻿</span><span class="ql-emojiblot" data-name="fist">﻿<span contenteditable="false"><span class="ap ap-fist">✊</span></span>
    ﻿</span><span class="ql-emojiblot" data-name="tada">﻿<span contenteditable="false"><span class="ap ap-tada">🎉</span></span>
    ﻿</span><span class="ql-emojiblot" data-name="100">﻿<span contenteditable="false"><span class="ap ap-100">💯</span></span>
    ﻿</span><span class="ql-emojiblot" data-name="balloon">﻿<span contenteditable="false"><span class="ap ap-balloon">🎈</span></span>
    ﻿</span><span class="ql-emojiblot" data-name="confetti_ball">﻿<span contenteditable="false"><span class="ap ap-confetti_ball">🎊</span></span>
        ﻿</span><span class="ql-emojiblot" data-name="grinning">﻿<span contenteditable="false"><span class="ap ap-grinning">😀</span></span>
        ﻿</span><span class="ql-emojiblot" data-name="beers">﻿<span contenteditable="false"><span class="ap ap-beers">🍻</span></span>
        ﻿</span><span class="ql-emojiblot" data-name="mortar_board">﻿<span contenteditable="false"><span class="ap ap-mortar_board">🎓</span></span>
        ﻿</span><span class="ql-emojiblot" data-name="weight_lifter">﻿<span contenteditable="false"><span class="ap ap-weight_lifter">🏋</span></span>
        ﻿</span><span class="ql-emojiblot" data-name="rocket">﻿<span contenteditable="false"><span class="ap ap-rocket">🚀</span></span>
        <span class="ql-emojiblot" data-name="star2">﻿<span contenteditable="false"><span class="ap ap-star2">🌟</span></span>
        ﻿</span><span class="ql-emojiblot" data-name="sparkles">﻿<span contenteditable="false"><span class="ap ap-sparkles">✨</span></span>
        ﻿</span><span class="ql-emojiblot" data-name="fire">﻿<span contenteditable="false"><span class="ap ap-fire">🔥</span></span>
        ﻿</span><span class="ql-emojiblot" data-name="top">﻿<span contenteditable="false"><span class="ap ap-top">🔝</span></span>﻿</span>
        <span class="ql-emojiblot" data-name="cool">﻿<span contenteditable="false"><span class="ap ap-cool">🆒</span></span>﻿</span>
        <span class="ql-emojiblot" data-name="pencil2">﻿<span contenteditable="false"><span class="ap ap-pencil2">✏</span></span>﻿</span>
        <span class="ql-emojiblot" data-name="exclamation">﻿<span contenteditable="false"><span class="ap ap-exclamation">❗</span></span>﻿</span></p>';

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $k = array_rand($this->kudos_examples);
        $v = $this->kudos_examples[$k];

        $u1 = User::all()->where('company_id', 2)->random();
        $u2 = User::all()->where('company_id', 2)->random();
        while ($u1 == $u2) {
            $u2 = User::all()->where('company_id', 2)->random();
        }
        $isSuper = false;
        if (rand(1, 10) > 8) {
            $isSuper = true;
        }

        // $u1 = User::factory(['company_id' => 2]);
        // $u2 = User::factory(['company_id' => 2]);

        return [
            'amount' => $isSuper ? 1000 : 500,
            'message' => $v,
            'company_id' => 2,
            'from_id' => $u1,
            'user_id' => $u2,
            'type' => $isSuper ? Point::TYPE_SUPER : Point::TYPE_STANDARD,
            'created_at' => Carbon::parse($this->rand_date(now()->subMonths(6), now())),

        ];
    }

    public function sendPoints(User $from, User $user)
    {
        return $this->create([
        'from_id' => $from->id,
        'user_id' => $user->id,
        'company_id' => $user->company->id,
       ]);
    }

    public function rand_date($min_date, $max_date)
    {
        /* Gets 2 dates as string, earlier and later date.
           Returns date in between them.
        */

        $min_epoch = strtotime($min_date);
        $max_epoch = strtotime($max_date);

        $rand_epoch = rand($min_epoch, $max_epoch);
        $date = date('Y-m-d H:i:s', $rand_epoch);
        $date = Carbon::parse($date);
        if ($date->day == 14) {
            return $this->rand_date($min_date, $max_date);
        }

        return $date;
    }

    protected $kudos_examples = [

        'Wow! Only two months in and already an expert! Great work and keep it up <span contenteditable="false"><span class="ap ap-rocket">🚀</span></span><span contenteditable="false"><span class="ap ap-rocket">🚀</span></span><span contenteditable="false"><span class="ap ap-thumbsup">👍</span></span>',
        'Welcome to the team! We are excited to have you <span contenteditable="false"><span class="ap ap-grinning">😀</span></span><span contenteditable="false"><span class="ap ap-grinning">😀</span></span>',
        'Kudos to you on pulling that late night and getting it done before the deadline. Can always rely on you <span contenteditable="false"><span class="ap ap-thumbsup">👍</span></span>',
        '<span contenteditable="false"><span class="ap ap-thumbsup">👍</span></span><span contenteditable="false"><span class="ap ap-thumbsup">👍</span></span><span contenteditable="false"><span class="ap ap-thumbsup">👍</span></span>',
        'For finally closing the deal! ﻿<span contenteditable="false"><span class="ap ap-confetti_ball">🎊</span></span>﻿<span contenteditable="false"><span class="ap ap-confetti_ball">🎊</span></span>﻿<span contenteditable="false"><span class="ap ap-confetti_ball">🎊</span></span>',
        'Kudos to you for taking initiative! <span class="ql-emojiblot" data-name="point_up_2">﻿<span contenteditable="false"><span class="ap ap-point_up_2">👆</span></span>',
        'Thanks for taking over while I was off! Everything seemed to go smoothly<span contenteditable="false"><span class="ap ap-sunglasses">😎</span></span>',
        'For putting the team on your back! ﻿</span><span class="ql-emojiblot" data-name="weight_lifter">﻿<span contenteditable="false"><span class="ap ap-weight_lifter">🏋</span></span>﻿</span><span class="ql-emojiblot" data-name="weight_lifter">﻿<span contenteditable="false"><span class="ap ap-weight_lifter">🏋</span></span>',
        'Cheers to you for a new beginning at the company!    ﻿</span><span class="ql-emojiblot" data-name="beers">﻿<span contenteditable="false"><span class="ap ap-beers">🍻</span></span>',
        'Glad I got the chance to work with you!',
        'Graduating WHILE killing it every day is no easy feat! ConGRADulations!!
        ﻿</span><span class="ql-emojiblot" data-name="mortar_board">﻿<span contenteditable="false"><span class="ap ap-mortar_board">🎓</span></span>
    ﻿</span><span class="ql-emojiblot" data-name="tada">﻿<span contenteditable="false"><span class="ap ap-tada">🎉</span></span>',
    'Thank you for bailing me out yet again  ﻿</span><span class="ql-emojiblot" data-name="raised_hands">﻿<span contenteditable="false"><span class="ap ap-raised_hands">🙌</span></span>',
    'Youre impact does not go unoticed! ﻿</span><span class="ql-emojiblot" data-name="fist">﻿<span contenteditable="false"><span class="ap ap-fist">✊</span></span>',
    '﻿</span><span class="ql-emojiblot" data-name="ok_hand">﻿<span contenteditable="false"><span class="ap ap-ok_hand">👌</span></span>﻿</span><span class="ql-emojiblot" data-name="ok_hand">﻿<span contenteditable="false"><span class="ap ap-ok_hand">👌</span></span>﻿</span><span class="ql-emojiblot" data-name="ok_hand">﻿<span contenteditable="false"><span class="ap ap-ok_hand">👌</span></span>',
    'Pleasure working with you! <span class="ql-emojiblot" data-name="sunglasses">﻿<span contenteditable="false"><span class="ap ap-sunglasses">😎</span></span>',
    '﻿</span><span class="ql-emojiblot" data-name="100">﻿<span contenteditable="false"><span class="ap ap-100">💯</span></span>﻿</span><span class="ql-emojiblot" data-name="100">﻿<span contenteditable="false"><span class="ap ap-100">💯</span></span>﻿</span><span class="ql-emojiblot" data-name="100">﻿<span contenteditable="false"><span class="ap ap-100">💯</span></span>',
    'Thanks for coordinating today! ﻿</span><span class="ql-emojiblot" data-name="clap">﻿<span contenteditable="false"><span class="ap ap-clap">👏</span></span>',
    'Your postive attitude is contagious! ﻿</span><span class="ql-emojiblot" data-name="grinning">﻿<span contenteditable="false"><span class="ap ap-grinning">😀</span></span>',
    'Thanks for making the timeline! ﻿</span><span class="ql-emojiblot" data-name="thumbsup">﻿<span contenteditable="false"><span class="ap ap-thumbsup">👍</span></span>',
    'For being a superstar! <span class="ql-emojiblot" data-name="star2">﻿<span contenteditable="false"><span class="ap ap-star2">🌟</span></span><span class="ql-emojiblot" data-name="star2">﻿<span contenteditable="false"><span class="ap ap-star2">🌟</span></span>',
    '<span class="ql-emojiblot" data-name="star2">﻿<span contenteditable="false"><span class="ap ap-star2">🌟</span></span><span class="ql-emojiblot" data-name="star2">﻿<span contenteditable="false"><span class="ap ap-star2">🌟</span></span><span class="ql-emojiblot" data-name="star2">﻿<span contenteditable="false"><span class="ap ap-star2">🌟</span></span>',
    'attention to detail!
        <span class="ql-emojiblot" data-name="pencil2">﻿<span contenteditable="false"><span class="ap ap-pencil2">✏</span></span>﻿</span>',
    'Thinking outside the box!',
    'Driving the charge<span class="ql-emojiblot" data-name="exclamation">﻿<span contenteditable="false"><span class="ap ap-exclamation">❗</span></span>﻿</span>',
    'Congratulations!! ﻿</span><span class="ql-emojiblot" data-name="confetti_ball">﻿<span contenteditable="false"><span class="ap ap-confetti_ball">🎊</span></span> ﻿</span><span class="ql-emojiblot" data-name="confetti_ball">﻿<span contenteditable="false"><span class="ap ap-confetti_ball">🎊</span></span>',
    'Congrats!  ﻿</span><span class="ql-emojiblot" data-name="confetti_ball">﻿<span contenteditable="false"><span class="ap ap-confetti_ball">🎊</span></span>﻿</span><span class="ql-emojiblot" data-name="clap">﻿<span contenteditable="false"><span class="ap ap-clap">👏</span></span>',
    'For starting of so strong!﻿</span><span class="ql-emojiblot" data-name="fire">﻿<span contenteditable="false"><span class="ap ap-fire">🔥</span></span>',
    'Welcome to the team!!',
    'Congrats on the promotion!﻿</span><span class="ql-emojiblot" data-name="mortar_board">﻿<span contenteditable="false"><span class="ap ap-mortar_board">🎓</span></span>',
    'Wow! Promoted again, congrats!!﻿</span><span class="ql-emojiblot" data-name="mortar_board">﻿<span contenteditable="false"><span class="ap ap-mortar_board">🎓</span></span>',
    'For being a team player this week!﻿</span><span class="ql-emojiblot" data-name="ok_hand">﻿<span contenteditable="false"><span class="ap ap-ok_hand">👌</span></span>',

    ];
}
