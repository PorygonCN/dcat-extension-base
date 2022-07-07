<?php

namespace Porygon\Base\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Porygon\Base\Traits\Macroable;

class Model extends EloquentModel
{
    use HasFactory, HasDateTimeFormatter, Macroable;

    protected $guarded = [];
    protected $config = "";

    public function config($key)
    {
        return  config($this->config . ".database.$key");
    }
}
