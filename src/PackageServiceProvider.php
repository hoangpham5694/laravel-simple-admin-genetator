<?php
namespace HoangPham\SimpleAdminGeneration;

use HoangPham\SimpleAdminGeneration\Console\GenerateControllerCommand;
use HoangPham\SimpleAdminGeneration\Console\GenerateCrudCommand;
use HoangPham\SimpleAdminGeneration\Console\InstallCommand;
use HoangPham\SimpleAdminGeneration\Http\Middleware\AuthAdmin;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Config;

class PackageServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'sag');
    }

    public function boot()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
        $this->loadViewsFrom(__DIR__.'/resources/views', 'simple_admin_generation');
        if ($this->app->runningInConsole()) {
            // Publish assets
            $this->publishes([
                __DIR__.'/resources/assets' => public_path('sag'),
            ], 'assets');
        }
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('admin', AuthAdmin::class);

        Config::set('auth.guards.admin', [
            'driver' => 'session',
            'provider' => 'admin',
        ]);
        Config::set('auth.providers.admin', [
            'driver' => 'eloquent',
            'model' => \HoangPham\SimpleAdminGeneration\Models\Admin::class,
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                GenerateControllerCommand::class,
                GenerateCrudCommand::class
            ]);
        }
    }

    protected function routeConfiguration()
    {
        return [
            'prefix' => 'admin',
            'middleware' => 'web',
        ];
    }
}