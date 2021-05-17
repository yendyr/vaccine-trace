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
        ],
        'transaction-icon' => [
            0 => 'circle',
            1 => 'play',
            2 => 'forward',
            3 => 'pause',
            4 => 'stop',
            41 => 'pencil-square-o',
            5 => 'gear',
            51 => 'gears',
            6 => 'fighter-jet'
        ],
        'transaction-status-color' => [
            1 => 'plain',
            11 => 'plain',
            12 => 'success',
            2 => 'information',
            3 => 'warning',
            31 => 'warning',
            4 => 'primary',
            41 => 'danger'
        ],
    ]
];
