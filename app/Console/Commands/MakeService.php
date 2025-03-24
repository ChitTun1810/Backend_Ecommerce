<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeService extends Command
{
    protected $signature = 'make:service {folder_name}';
    protected $description = 'Create a service file with a specific namespace';

    public function handle()
    {
        $folderName = $this->argument('folder_name');

        // Check if subfolder is provided
        if (strpos($folderName, '/') !== false) {
            $folders = explode('/', $folderName);
            $serviceNamespace = 'App\\Services\\' . implode('\\', array_slice($folders, 0, -1));
            $fileName = end($folders) . '.php';
        } else {
            $serviceNamespace = 'App\\Services';
            $fileName = $folderName . '.php';
        }

        $path = app_path('Services/' . $folderName . '.php');

        // Create the PHP file
        File::makeDirectory(dirname($path), 0777, true, true);
        File::put($path, "<?php\n\nnamespace $serviceNamespace;\n\nclass " . basename($fileName, '.php') . " {\n}\n");

        // Output success message
        $this->info("Service file '$fileName' with namespace '$serviceNamespace' created successfully.");
    }
}
