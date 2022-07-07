<?php

namespace Porygon\Base\Exceptions;

use Exception as BaseException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Exception extends HttpException
{
    public $errors = null;
    public function __construct(int $code = 0, string $message = '', int $statusCode = Response::HTTP_BAD_REQUEST, ?\Throwable $previous = null, array $headers = [])
    {
        $statusCode || $statusCode = $code;
        if ($previous != null && method_exists($previous, 'errors')) {
            $this->errors = $previous->errors();
            $message = collect($this->errors)->first()[0];
        }

        parent::__construct($statusCode, $message, $previous, $headers, $code);
    }

    public function render(Request $request)
    {
        return $request->wantsJson()
            ? fail($this->getMessage(), $this->getCode(), $this->getStatusCode(), $this->errors)
            : view("errors.404", ["exception" => $this]);
    }
}
