<?php

namespace HoangPhamDev\SimpleAdminGenerator\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class GenerateControllerCommand extends GeneratorCommand
{
    protected $name = 'sag:generate_controller';

    protected $description = 'Create a new controller';

    protected $type = 'Controller';

    protected function getStub()
    {
        return __DIR__ . '/../../stubs/Generator/Controllers/DummyController.php.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Http\Controllers\SAG';
    }

    public function handle()
    {

        parent::handle();

        $this->doOtherOperations();
    }

    protected function doOtherOperations()
    {
        $name = Str::replace('Controller', '', $this->argument('name'));

        // Get the fully qualified class name (FQN)
        $class = $this->qualifyClass($this->getNameInput());

        // get the destination path, based on the default namespace
        $path = $this->getPath($class);

        $content = file_get_contents($path);

        // Update the file content with additional data (regular expressions)
        $content = Str::replace('{{PageNameIndex}}', 'List ' . $name, $content);
        $content = Str::replace('{{PageNameCreate}}', 'Create ' . $name, $content);
        $content = Str::replace('{{PageNameEdit}}', 'Edit ' . $name, $content);
        $content = Str::replace('{{ViewFolder}}', Str::lower($name), $content);
        $content = Str::replace('{{RouteName}}', Str::lower($name), $content);

        file_put_contents($path, $content);
    }
}
