<?php

namespace Porygon\Base\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckSign implements Rule
{
    protected $keys;
    protected $data;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($data, array $keys = [])
    {
        $this->keys = $keys;
        $this->data = $data;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $sign = $this->generateSign($this->data, $this->keys, $attribute);
        return $sign === $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '签名校验失败';
    }
    /**
     * 生成签名
     */
    public function generateSign($data, $keys = [], $except = null)
    {
        $keys =  $keys ?? array_keys($data);
        if ($except) {
            if (is_string($except)) {
                $except = [$except];
            }
            $keys = collect($keys)->except($except);
        }
        $data = collect($data)->only($keys)->sortKeys();
        $as   = json_encode($data);
        $bs   = base64_encode($as);
        $ubs  = Str::upper($bs);
        $sign = Str::substr($ubs, 0, 32);
        return $sign;
    }
    public static function make(...$arg)
    {
        return new static(...$arg);
    }
}
