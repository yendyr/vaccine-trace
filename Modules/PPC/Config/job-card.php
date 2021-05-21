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
            5 => 'exception'
        ],
        'transaction-icon' => [
            0 => 'circle',
            1 => 'play',
            2 => 'forward',
            3 => 'pause',
            4 => 'stop',
            5 => 'fighter-jet'
        ],
        'transaction-status-color' => [
            0 => 'plain',
            1 => 'plain',
            2 => 'info',
            3 => 'warning',
            4 => 'success',
            5 => 'danger',
        ],
    ]
];
