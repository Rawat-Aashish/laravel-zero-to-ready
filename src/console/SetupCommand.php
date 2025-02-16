<?php

// namespace Kakarot\LaravelInitialSetup\Console;

// use Illuminate\Console\Command;

// class SetupCommand extends Command
// {
//     protected $signature = 'project:setup';
//     protected $description = 'Setup project with localization, exception handling, and API versioning';

//     public function handle()
//     {
//         $this->call('vendor:publish', ['--tag' => 'laravel-setup', '--force' => true]);
//         $this->info('Project setup completed!');
//     }
// }

namespace Kakarot\LaravelInitialSetup\Console;

use Illuminate\Console\Command;

class SetupCommand extends Command
{
    protected $signature = 'project:setup';
    protected $description = 'Setup project with localization, exception handling, and API versioning';

    public function handle()
    {
        // Step 1: Publish the package files
        $this->call('vendor:publish', ['--tag' => 'laravel-setup', '--force' => true]);
        $this->info('Project setup completed!');

        // Step 2: Modify the app.php file
        $this->modifyAppFile();
    }

    private function modifyAppFile()
    {
        $appFile = base_path('bootstrap/app.php');

        if (!file_exists($appFile)) {
            $this->error("app.php file not found!");
            return;
        }

        $content = file_get_contents($appFile);

        // Add RouteHandler import if not present
        if (!str_contains($content, "use Kakarot\\LaravelInitialSetup\\Traits\\RouteHandler;")) {
            $content = str_replace(
                "<?php",
                "<?php\n\nuse Kakarot\\LaravelInitialSetup\\Traits\\RouteHandler;",
                $content
            );
        }

        // Add ExceptionHandler import if not present
        if (!str_contains($content, "use Kakarot\\LaravelInitialSetup\\Traits\\ExceptionHandler;")) {
            $content = str_replace(
                "<?php",
                "<?php\n\nuse Kakarot\\LaravelInitialSetup\\Traits\\ExceptionHandler;",
                $content
            );
        }

        // Add MethodNotAllowedHttpException 
        if (!str_contains($content, "use Symfony\\Component\\HttpKernel\\Exception\\MethodNotAllowedHttpException;")) {
            $content = str_replace(
                "<?php",
                "<?php\n\nuse Symfony\\Component\\HttpKernel\\Exception\\MethodNotAllowedHttpException;",
                $content
            );
        }

        // Add HandleLocalization middleware import if not present
        if (!str_contains($content, "use Kakarot\\LaravelInitialSetup\\Middleware\\HandleLocalization;")) {
            $content = str_replace(
                "<?php",
                "<?php\n\nuse Kakarot\\LaravelInitialSetup\\Middleware\\HandleLocalization;",
                $content
            );
        }

        // Add RouteHandler::configureApiVersioning() inside withRouting()
        if (!str_contains($content, "RouteHandler::configureApiVersioning()")) {
            $content = str_replace(
                "->withRouting(",
                "->withRouting(\n        then: RouteHandler::configureApiVersioning(),",
                $content
            );
        }

        // Add ExceptionHandler::handleApiException() inside withExceptions()
        if (!str_contains($content, "ExceptionHandler::handleApiException(")) {
            $content = str_replace(
                "->withExceptions(function (Exceptions \$exceptions) {",
                // "->withExceptions(function (Exceptions \$exceptions) {\n        ExceptionHandler::handleApiException(\$exceptions);",
                "->withExceptions(function (Exceptions \$exceptions) {\n        \$exceptions->dontReport([\n            MethodNotAllowedHttpException::class,\n        ]);\n        ExceptionHandler::handleApiException(\$exceptions);",
                $content
            );
        }

        // Register the middleware inside withMiddleware()
        if (!str_contains($content, "HandleLocalization::class")) {
            $content = str_replace(
                "->withMiddleware(function (Middleware \$middleware) {",
                "->withMiddleware(function (Middleware \$middleware) {\n        \$middleware->append(HandleLocalization::class);",
                $content
            );
        }

        file_put_contents($appFile, $content);
        $this->info("app.php has been successfully updated!");
    }
}
