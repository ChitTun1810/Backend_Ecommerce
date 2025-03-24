<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeRepository extends Command
{
    protected $signature = 'make:repository {folder_name}';
    protected $description = 'Create a repository file with a specific namespace';

    public function handle()
    {
        $folderName = $this->argument('folder_name');

        // Check if subfolder is provided
        if (strpos($folderName, '/') !== false) {
            $folders = explode('/', $folderName);
            $repositoryNamespace = 'App\\Repository\\' . implode('\\', array_slice($folders, 0, -1));
            $fileName = end($folders) . '.php';
        } else {
            $repositoryNamespace = 'App\\Repository';
            $fileName = $folderName . '.php';
        }

        $path = app_path('Repository/' . $folderName . '.php');

        // Create the PHP file
        File::makeDirectory(dirname($path), 0777, true, true);
        File::put($path, "<?php\n\nnamespace $repositoryNamespace;\n\nclass " . basename($fileName, '.php') . " {\n}\n");

        // Output success message
        $this->info("Repository file '$fileName' with namespace '$repositoryNamespace' created successfully.");
    }
}
