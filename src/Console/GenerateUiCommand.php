<?php

namespace HoangPhamDev\SimpleAdminGenerator\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class GenerateUiCommand extends Command
{
    protected $signature = 'sag:generate_ui {name}';

    protected $description = 'Generate ui';

    const MENU_HTML = <<<EOF
                <li class="nav-item {{ request()->is('admin/<URL_PATH>*') ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/<URL_PATH>*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            <PAGE_NAME>
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('<ROUTE_NAME_INDEX>')}}" class="nav-link {{ request()->is('admin/<URL_PATH>') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('<ROUTE_NAME_CREATE>')}}" class="nav-link {{ request()->is('admin/<URL_PATH>/create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create</p>
                            </a>
                        </li>
                    </ul>
                </li>
        EOF;

    private function copyFile($file, $destination)
    {
        (new Filesystem)->copy($file, $destination);
    }

    private function copyDirectory($directory, $destination)
    {
        (new Filesystem)->copyDirectory($directory, $destination);
    }
    private function createDirectory($directory)
    {
        (new Filesystem)->ensureDirectoryExists($directory);
    }


    public function handle()
    {
        $this->info('Generate UI');

        $name = $this->argument('name');

        $controllerName = $name . 'Controller';
        $this->info('Generating controller');
        Artisan::call("sag:generate_controller $controllerName");
        $routeName = Str::lower($name);

        $this->info('Generating router');
        file_put_contents(
            './routes/web.php',
            "\nRoute::get('/admin/$routeName', [\App\Http\Controllers\SAG\\$controllerName::class, 'index'])->middleware('admin')->name('simple_admin_generation.$routeName.index');\nRoute::get('/admin/$routeName/create', [\App\Http\Controllers\SAG\\$controllerName::class, 'create'])->middleware('admin')->name('simple_admin_generation.$routeName.create');\nRoute::get('/admin/$routeName/edit/{\$id}', [\App\Http\Controllers\SAG\\$controllerName::class, 'edit'])->middleware('admin')->name('simple_admin_generation.$routeName.edit');\n",
            FILE_APPEND
        );

        $this->info('Generating view');
        $this->createDirectory(resource_path('views/sag/' . $routeName));
        $this->copyDirectory(__DIR__.'/../../stubs/Generator/views/ui', resource_path('views/sag/' . $routeName));

        $content = file_get_contents(resource_path('views/sag/' . $routeName . '/create.blade.php'));
        $content = Str::replace('{{ViewFolder}}', $routeName, $content);
        file_put_contents(resource_path('views/sag/' . $routeName . '/create.blade.php'), $content);

        $content = file_get_contents(resource_path('views/sag/' . $routeName . '/edit.blade.php'));
        $content = Str::replace('{{ViewFolder}}', $routeName, $content);
        file_put_contents(resource_path('views/sag/' . $routeName . '/edit.blade.php'), $content);


        $content = file_get_contents(resource_path('views/sag/layouts/sidebar.blade.php'));

        $menuHtml = Str::replace('<URL_PATH>', $routeName, self::MENU_HTML);
        $menuHtml = Str::replace('<PAGE_NAME>', $name, $menuHtml);
        $menuHtml = Str::replace('<ROUTE_NAME_INDEX>', "simple_admin_generation.$routeName.index", $menuHtml);
        $menuHtml = Str::replace('<ROUTE_NAME_CREATE>', "simple_admin_generation.$routeName.create", $menuHtml);
        $menuHtml .= PHP_EOL."<!--DO NOT REMOVE--><!--MENU_GENERATION--><!--DO NOT REMOVE-->";
        $content = Str::replace('<!--DO NOT REMOVE--><!--MENU_GENERATION--><!--DO NOT REMOVE-->', PHP_EOL.$menuHtml, $content);
        file_put_contents(resource_path('views/sag/layouts/sidebar.blade.php'), $content);

        $this->info('Done');
    }
}