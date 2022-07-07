<?php

namespace Porygon\Base\Middleware;

use Closure;
use Illuminate\Http\Request;
use Porygon\Base\Models\RequestLog;

class LogRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        return $response;
    }

    /**
     * 在响应发送到浏览器后处理任务。
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return void
     */
    public function terminate($request, $response)
    {
        $logClass = config("p-base.model.request_logs");
        /** @var RequestLog */
        $log = $logClass::fromRequest($request);

        $log->fillResponse($response)->save();
    }
}
