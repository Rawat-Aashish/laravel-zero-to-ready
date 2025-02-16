<?php

namespace Kakarot\LaravelInitialSetup;

use Illuminate\Support\ServiceProvider;
use Kakarot\LaravelInitialSetup\Console\SetupCommand;
use Illuminate\Foundation\Configuration\Exceptions;
use Kakarot\LaravelInitialSetup\Traits\ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class LaravelSetupServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Publish the necessary files
        $this->publishes([
            __DIR__ . '/config/laravel-setup.php' => config_path('laravel-setup.php'),
            __DIR__ . '/resources/lang/en/messages.php' => resource_path('lang/en/messages.php'),
            __DIR__ . '/resources/lang/sv/messages.php' => resource_path('lang/sv/messages.php'),
            __DIR__ . '/Traits/ExceptionHandler.php' => app_path('Traits/ExceptionHandler.php'),
            __DIR__ . '/Traits/ApiResponser.php' => app_path('Traits/ApiResponser.php'),
            __DIR__ . '/Traits/RouteHandler.php' => app_path('Traits/RouteHandler.php'),
            __DIR__ . '/Middleware/HandleLocalization.php' => app_path('Http/Middleware/HandleLocalization.php'),
            __DIR__ . '/routes/api/v1.php' => base_path('routes/api/v1.php'),
            __DIR__ . '/routes/api/v2.php' => base_path('routes/api/v2.php'),
        ], 'laravel-setup');

        // Modify app.php to include necessary configurations
        $this->modifyAppFile();
    }

    private function modifyAppFile()
    {
        $appFile = base_path('bootstrap/app.php');

        if (file_exists($appFile)) {
            $content = file_get_contents($appFile);

            // Ensure necessary imports exist
            if (!str_contains($content, "use Kakarot\\LaravelInitialSetup\\Traits\\RouteHandler;")) {
                $content = str_replace(
                    "<?php",
                    "<?php\n\nuse Kakarot\\LaravelInitialSetup\\Traits\\RouteHandler;",
                    $content
                );
            }

            if (!str_contains($content, "use Kakarot\\LaravelInitialSetup\\Traits\\ExceptionHandler;")) {
                $content = str_replace(
                    "<?php",
                    "<?php\n\nuse Kakarot\\LaravelInitialSetup\\Traits\\ExceptionHandler;",
                    $content
                );
            }

            if (!str_contains($content, "use Symfony\\Component\\HttpKernel\\Exception\\MethodNotAllowedHttpException;")) {
                $content = str_replace(
                    "<?php",
                    "<?php\n\nuse Symfony\\Component\\HttpKernel\\Exception\\MethodNotAllowedHttpException;",
                    $content
                );
            }

            // Add RouteHandler::configureApiVersioning()
            if (!str_contains($content, "RouteHandler::configureApiVersioning()")) {
                $content = str_replace(
                    "->withRouting(",
                    "->withRouting(\n        then: RouteHandler::configureApiVersioning(),",
                    $content
                );
            }

            // Add ExceptionHandler::handleApiException()
            if (!str_contains($content, "ExceptionHandler::handleApiException(")) {
                $content = str_replace(
                    "->withExceptions(",
                    "->withExceptions(function (Exceptions \$exceptions) {\n        \$exceptions->dontReport([\n            MethodNotAllowedHttpException::class,\n        ]);\n        ExceptionHandler::handleApiException(\$exceptions);",
                    $content
                );
            }

            // Ensure HandleLocalization middleware import exists
            if (!str_contains($content, "use Kakarot\\LaravelInitialSetup\\Middleware\\HandleLocalization;")) {
                $content = str_replace(
                    "<?php",
                    "<?php\n\nuse Kakarot\\LaravelInitialSetup\\Middleware\\HandleLocalization;",
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
        }
    }
}
