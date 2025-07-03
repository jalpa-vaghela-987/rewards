<?php

use App\Models\Point;

return [
    'special-message' => 'Happy :special_day from :name!',

    'special-day' => [
        Point::TYPE_BIRTHDAY    => [
            'message-body' => 'We hope you have an amazing day! 🎂🎁🥳',
        ],
        Point::TYPE_ANNIVERSARY => [
            'message-body' => 'We hope you have a great day! 🎉🎊',
        ],
        Point::TYPE_WELCOME     => [
            'message-body' => 'Welcome to '.appName().'! 🎉🎊🎁🎊🎉',
        ],
    ],

    Point::TYPE_BIRTHDAY    => 'Birthday',
    Point::TYPE_ANNIVERSARY => 'Work Anniversary',
    Point::TYPE_WELCOME     => 'Welcome',
];
