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
            21 => 'partially progress',
            3 => 'pending',
            4 => 'closed',
            41 => 'partially closed',
            5 => 'exception',
            6 => 'released',
            61 => 'partially released'
        ],
        'transaction-icon' => [
            0 => 'circle',
            1 => 'play',
            2 => 'forward',
            21 => 'forward',
            3 => 'pause',
            4 => 'stop',
            41 => 'stop',
            5 => 'fighter-jet',
            6 => 'fighter-jet',
            61 => 'fighter-jet'
        ],
        'transaction-status-color' => [
            0 => 'plain',
            1 => 'plain',
            2 => 'info',
            21 => 'info',
            3 => 'warning',
            4 => 'success',
            41 => 'success',
            5 => 'danger',
            6 => 'success',
            61 => 'success'
        ],
    ]
];
