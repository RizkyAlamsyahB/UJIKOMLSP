<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeViewStructure extends Command
{
    protected $signature = 'make:view-structure {name}';

    protected $description = 'Create a view folder structure with index, create, show, and edit views, along with migration, model, and controller';

    public function handle()
    {
        $name = $this->argument('name');
        $path = resource_path('views/admin/' . $name);

        // Create view folder structure
        File::makeDirectory($path, 0755, true, true);
        File::put($path . '/index.blade.php', '');
        File::put($path . '/create.blade.php', '');
        File::put($path . '/show.blade.php', '');
        File::put($path . '/edit.blade.php', '');

        // Create model
        $modelName = Str::studly($name);
        $this->call('make:model', ['name' => $modelName]);

        // Create migration
        $tableName = Str::plural(Str::snake($name));
        $this->call('make:migration', ['name' => "create_{$tableName}_table"]);

        // Create controller
        $controllerName = $modelName . 'Controller';
        $this->call('make:controller', ['name' => $controllerName]);

        $this->info("View structure, model, migration, and controller for {$name} created successfully.");
    }
}
