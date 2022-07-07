<?php
// 定义全局工具方法
use Illuminate\Http\Response;


if (!function_exists("json_response")) {
    function json_response($data, int $status_code, $headers, $options)
    {
        $response = response()->json($data, $status_code, $headers, $options);
        return $response;
    }
}
if (!function_exists("success")) {
    /**
     * 返回请求成功的Json Response
     *
     * @param  $data  接口返回的资源
     * @param  $code  跟随结果返回的接口结果code
     * @param  $status_code  返回结果时的http_status_code 默认是200
     * @param  $message  跟随结果返回的接口结果code的描述
     *
     * @return \Illuminate\Http\JsonResponse
     *
     */
    function success($data = null,  $status_code = Response::HTTP_OK, $code = 200, $message = "success", array $headers = [], int   $options = JSON_UNESCAPED_UNICODE)
    {
        $status = "success";
        $res = compact("status", "code", "message", "data");
        if (!config("app.api.restful", true)) {
            $status_code = Response::HTTP_OK;
        }
        $response = json_response($res, $status_code, $headers, $options);

        return  $response;
    }
}
if (!function_exists("fail")) {
    /**
     * 返回接口处理失败的Json Response
     *
     * @param  $code  错误码
     * @param  $message  错误码描述
     * @param  $status  接口返回的http_status_code
     * @param  $data   出错详情
     * @param  $headers
     * @param  $options
     *
     * @return \Illuminate\Http\JsonResponse
     */
    function fail($message = "fail", $code = 400,  $status_code = Response::HTTP_BAD_REQUEST, $data = null, array $headers = [], int $options = JSON_UNESCAPED_UNICODE)
    {
        $status = "fail";
        $res    = compact("status", "code", "message", "data");

        if (!config("app.api.restful", true)) {
            $status_code = Response::HTTP_OK;
        }
        $response = json_response($res, $status_code, $headers, $options);

        return $response;
    }
}

if (!function_exists("error")) {
    /**
     * 返回错误
     *
     * @param  string $message
     * @param  $code
     * @param  array $data
     * @param  int $status_code
     * @param  array $headers
     * @param  int $options
     * @return  \Illuminate\Http\JsonResponse
     */
    function error(
        $message = "error",
        $code = 500,
        $data = null,
        $status_code = Response::HTTP_INTERNAL_SERVER_ERROR,
        array $headers = [],
        int $options = JSON_UNESCAPED_UNICODE
    ) {
        $status = "error";
        $res    = compact("status", "code", "message", "data");

        if (!config("app.api.restful", true)) {
            $status_code = Response::HTTP_OK;
        }

        $response = json_response($res, $status_code, $headers, $options);

        return $response;
    }
}
