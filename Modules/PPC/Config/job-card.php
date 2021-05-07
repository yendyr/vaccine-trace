<?php

return [
    'job-card' => [
        'type' => [
            1 => 'task-card',
            2 => 'job-card'
        ],
        'transaction-status' => [
            0 => 'draft',
            1 => 'open',
            2 => 'progress',
            3 => 'pause',
            4 => 'close',
            41 => 'waiting-for-rii',
            5 => 'released',
            51 => 'rii-released',
            6 => 'exception'
        ]
    ]
];
