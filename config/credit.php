<?php

return [
    'registration' => [
        'reward' => [
            'regular_user' => env('CREDIT_REWARD_REGULAR_USER', 20),
            'premium_user' => env('CREDIT_REWARD_PREMIUM_USER', 40),
        ]
    ],
    'monthly' => [
        'reward' => [
            'regular_user' => env('CREDIT_REWARD_REGULAR_USER', 20),
            'premium_user' => env('CREDIT_REWARD_PREMIUM_USER', 40),
        ]
    ],
    'deduction' => [
        'check_availability' => env('CREDIT_DEDUCTION_CHECK_AVAILABILITY', 5)
    ]
];
