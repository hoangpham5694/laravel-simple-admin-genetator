<?php

namespace HoangPhamDev\SimpleAdminGenerator\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class GenerateHomeControllerCommand extends GeneratorCommand
{
    protected $name = 'sag:generate_home_controller';

    protected $description = 'Create a home controller';

    protected $type = 'Controller';

    protected function getStub()
    {
        return __DIR__ . '/../../stubs/Generator/Controllers/DummyHomeController.php.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Http\Controllers\SAG';
    }

    public function handle()
    {

        parent::handle();
    }
}