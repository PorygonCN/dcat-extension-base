<?php

use Porygon\Base\Models\User;
use Porygon\Base\Models\RequestLog;

return [
    "database" => [
        'conniction' => config("database.default", env('DB_CONNECTION', 'mysql')),
        "prefix"     => "base_",
        "tables"     => [
            "request_logs" => "request_logs",
        ]
    ],
    "model" => [
        "request_logs" => RequestLog::class,
        "relation"     => []
    ]
];
