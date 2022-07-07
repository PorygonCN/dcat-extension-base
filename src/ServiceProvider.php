<?php

namespace Porygon\Base;

use Dcat\Admin\Extend\ServiceProvider as BaseServiceProvider;
use Porygon\Base\Middleware\LogRequest;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'p-base');
        $this->app->singleton(LogRequest::class);
        $this->app->router->aliasMiddleware("log", LogRequest::class);
    }

    public function init()
    {
        parent::init();
        require __DIR__ . "/Admin/bootstrap.php";
        $this->publishes([__DIR__ . '/../config/config.php' => config_path('p-base.php')]);
    }
}
