<?php

namespace Porygon\Base\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class RequestLog extends Model
{
    public function getTable()
    {
        return config("p-base.database.prefix") . config("p-base.database.tables.request_logs");
    }
    protected $casts = [
        "request_headers"  => "json",
        "body"             => "json",
        "response_headers" => "json",
        "response"         => "json",
    ];
    protected static function booting()
    {
        static::creating(function (self $log) {
            if (!$log->uuid) {
                $log->uuid = Str::uuid();
            }
        });
    }

    public static function fromRequest(Request $request)
    {
        $log = new self;
        $log->fill([
            "url"            => $request->url(),
            "user"           => $request->user(),
            "ip"             => $request->ip(),
            "method"         => $request->method(),
            "query_string"   => json_encode($request->query),
            "request_headers" => $request->headers,
            "body"           => $request->all(),
            "created_at"     => now(),
        ]);

        return $log;
    }
    public function fillResponse(Response $response)
    {
        $this->fill([
            "response_headers" => $response->headers,
            "response"         => $response->content(),
            "response_at"      => now(),
        ]);
        return $this;
    }
}
