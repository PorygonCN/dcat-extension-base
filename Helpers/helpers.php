<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

require_once("api.php");
require_once("resource.php");

if (!function_exists("app_code")) {
    /**
     * 获取小程序码
     * @param string|array $scene 小程序码携带的参数 临时二维码传32位以内字符串 永久二维码传数组即可["id"=>1]
     * @param boolean $unlimit 是否是临时小程序码 true时返回临时二维码
     * @param array $optional 生成小程序码的额外参数
     * @return string|null 返回的是小程序码的全地址
     */
    function app_code($scene, $unlimit = false, $optional = [])
    {
        $page = 'pages/index/index';
        $app  = app("wechat.mini_program");
        if ($unlimit) {
            // 获取临时二维码
            $response = $app->app_code->getUnlimit($scene, array_merge(compact("page"), $optional));
        } else {
            // 获取永久二维码
            !is_array($scene) && $scene = [$scene];
            $query = http_build_query($scene);
            $response = $app->app_code->get("$page?$query", $optional);
        }

        // //请求成功
        // Log::info('response' . json_encode($response));

        if ($response instanceof \EasyWeChat\Kernel\Http\StreamResponse) {
            // 保存小程序码到文件
            $filename = $response->save(storage_path("app/public/minicode/"), Str::uuid());
            // Log::info('filename' . $filename);

            if ($filename) {
                $res = Storage::disk("local")->put(
                    "minicode/" . $filename,
                    storage_path("app/public/minicode/" . $filename)
                );
                $file = storage_path("app/public/minicode/" . $filename);
                $res = Storage::putFile(
                    "minicode",
                    $file
                );
                if ($res && config("filesystems.default") != "local") {
                    Storage::disk("local")->delete("public/minicode/$filename");
                }

                return Storage::url($res);
            }
        }
        return null;
    }
}
