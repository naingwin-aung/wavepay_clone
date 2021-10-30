<?php

return [
    'phone' => [
        'numeric' => 'Invalid phone number.',
        'regex' => 'Invalid phone number.',
    ],
    'to_phone' => [
        'required' => 'Receiver phone number is required.',
        'numeric' => 'Invalid phone number.',
        'regex' => 'Invalid phone number.',
    ],
    'amount' => [
        'required' => 'Amount is required.',
        'integer' => 'Amount must be integer.',
        'min' => 'Amount must be greater than 50 kyat.',
        'max' => 'Amount must be less than 100000000 kyat.',
    ],
    'bill_phone' => [
        'required' => 'Topup phone number is required.',
    ],
    'another_topup_amount' => [
        'integer' => 'Topup amount must integer.',
        'min' => 'Topup amount must be at least 1000 kyat.',
    ]
];