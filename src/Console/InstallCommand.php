<?php

namespace HoangPhamDev\SimpleAdminGenerator\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
class InstallCommand extends Command
{

    protected $signature = 'sag:install';

    protected $description = 'Install the admin site';

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
        $this->info('Installing Admin');
        $this->info('Generating layout...');
        $this->createDirectory(resource_path('views/sag'));
        $this->copyDirectory(__DIR__.'/../../stubs/views', resource_path('views/sag'));
//        $this->createDirectory(public_path('sag'));
//        $this->copyDirectory(__DIR__.'/../../stubs/public', public_path('sag'));
        file_put_contents(
            './routes/web.php',
            "\nRoute::middleware(['admin'])->group(function () {\n Route::get('/admin/dashboard', [\App\Http\Controllers\SAG\HomeController::class, 'dashboard'])->name('simple_admin_generation.dashboard');\n});\n",
            FILE_APPEND
        );
        Artisan::call('migrate');

        Artisan::call('db:seed --class="HoangPham\\\SimpleAdminGeneration\\\Database\\\Seeders\\\AdminSeeder"');

        $this->info('Done');
    }
}