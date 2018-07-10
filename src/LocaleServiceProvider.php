<?php
namespace Shuramita\Locale;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class LocaleServiceProvider extends ServiceProvider
{
    public $namespace = 'Locale';


    /**
     * Bootstrap the application services.
     *
     * @return void
     */

    public function boot(Router $router)
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', $this->namespace);
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadTranslationsFrom(__DIR__.'/translations', $this->namespace);
        $this->loadJSONTranslationsFrom(__DIR__.'/translations');
        AliasLoader::getInstance()->alias('LocaleHelper', 'Shuramita\Locale\Helpers\Helper');
        $router->aliasMiddleware('locale', 'Shuramita\Locale\Middleware\Locale');
        $this->publishes([
            __DIR__.'/config/locale.php' => config_path('locale.php'),
        ]);
        Option::loadConfiguration();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/locale.php', 'locale');

    }

}