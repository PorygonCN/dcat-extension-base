<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutcardTable extends Migration
{
    public function getConnection()
    {
        return config('p-base.database.connection');
    }

    public function config($key)
    {
        return config('p-base.database.' . $key);
    }
    public function table($key)
    {
        return $this->config("prefix") . $this->config("tables." . $key);
    }

    public function up()
    {
        Schema::create($this->table("request_logs"), function (Blueprint $table) {
            $table->uuid();

            $table->string("ip");

            $table->string("url")->nullable()->comment("请求url");
            $table->string("method")->nullable()->comment("请求类型");
            $table->string("query_string")->nullable()->comment("查询语句");

            $table->string("user")->nullable()->comment("请求用户");

            $table->json("request_headers")->nullable()->comment("请求头");

            $table->json("body")->nullable()->comment("请求报文");

            $table->json("response_headers")->nullable()->comment("返回响应头");

            $table->json("response")->nullable()->comment("返回报文");
            $table->timestamps();
            $table->timestamp("response_at")->nullable()->comment("返回时间");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if ($this->config("tables")) {
            foreach ($this->config("tables") as $table) {
                Schema::dropIfExists($this->config("prefix") . $table);
            }
        };
    }
}
