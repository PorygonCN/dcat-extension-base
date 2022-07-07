<?php

use App\Models\Config;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

if (!function_exists("getPerpage")) {
    /**
     * 获取二维码(临时)
     *
     * @param  String $param  携带参数
     * @param  integer  $ttl  超时时间 默认7天
     */
    function getTicket(String $param, $ttl = 604800)
    {
        $app = app("wechat.official_account");
        $result = $app->qrcode->temporary($param, $ttl);
        $ticket = $result['ticket'];
        $url = $app->qrcode->url($ticket);
        return ["ticket" => $ticket, "url" => $url];
    }
}

if (!function_exists("getPerpage")) {
    /**
     * 获取分页每页的个数
     *
     * @return int 1 ~ 100
     */
    function getPerpage()
    {
        $request = request();
        $key = config("app.paginate.per_page_key", "per_page");
        $value = config("app.paginate.per_page", 15);
        return (int) ((isset($request[$key]) && $request->$key > 0 && $request->$key <= 100)
            ? $request->$key
            : $value);
    }
}


if (!function_exists("getCache")) {
    /**
     * 从缓存中查找数据
     * 未找到且传了 $closure 则返回 $closure的返回值
     */
    function getCache($key, $closure = null, $tags = null, $ttl = -1)
    {
        //通过key和tags 查询缓存
        if ($tags !== null) {
            is_string($tags) &&  $tags = [$tags];
            if (is_array($tags)) {
                $res = Cache::tags($tags)->get($key, null);
            } else {
                throw new Exception("缓存tags 必须是 string或者array", 500);
            }
        } else {
            $res = Cache::get($key, null);
        }
        // 未找到
        if ($res === null && $closure && is_callable($closure)) {
            //生成要缓存的结果
            $res = $closure($key);
            //通过key和tags 缓存结果
            if ($tags !== null) {
                Cache::tags(array_unique($tags))->put($key, $res, $ttl === -1 ? config("cache.ttl") : $ttl);
            } else {
                Cache::put($key, $res, $ttl === -1 ? config("cache.ttl") : $ttl);
            }
        }
        return $res;
    }
}


if (!function_exists('query')) {
    /**
     * 根据condition 查询builder
     *
     * @param mixd $builder     查询构造器
     * @param array $condition  查询条件
     *
     * @return mixd
     */
    function query(&$builder, $condition = [])
    {

        foreach ($condition as $key => $value) {
            if (is_array($value)) {
                $builder->where([$value]);
            } elseif (is_callable($value)) {
                $builder->where($value);
            } else {
                $builder->where($key, $value);
            }
        }
        return $builder;
    }
}

if (!function_exists('notfound')) {
    function notfound($model)
    {
        $e = new ModelNotFoundException();
        $e->setModel($model, $model->id);
        throw $e;
    }
}
if (!function_exists('fullUrl')) {
    function fullUrl($url)
    {
        if ($url && !(strstr($url, "http://") || strstr($url, "https://"))) {
            $url = Storage::url($url);
        }
        return $url;
    }
}
if (!function_exists('getConfig')) {
    /**
     * 获取配置(数据库 configs 表中的)
     */
    function getConfig($key, $default = null)
    {
        $result = null;
        $config = Config::where("key", $key)->first();
        if ($config) {
            $result = $config->value;
        } else {
            if (is_callable($default)) {
                $result = $default($key);
            } else {
                $result = $default;
            }
        }
        return $result;
    }
}
