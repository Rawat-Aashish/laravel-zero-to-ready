<?php

namespace Kakarot\LaravelInitialSetup;

use Illuminate\Support\ServiceProvider;
use Kakarot\LaravelInitialSetup\Console\SetupCommand;
use Illuminate\Foundation\Configuration\Exceptions;
use Kakarot\LaravelInitialSetup\Traits\ExceptionHandler;

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


        if ($this->app->runningInConsole()) {
            $this->commands([
                SetupCommand::class // Registering the command
            ]);
        }


        // Modify app.php to include RouteHandler for API versioning
        // $this->modifyAppFile();
    }

    // private function modifyAppFile()
    // {
    //     $appFile = base_path('bootstrap/app.php');

    //     if (file_exists($appFile)) {
    //         $content = file_get_contents($appFile);

    //         // Ensure RouteHandler and ExceptionHandler imports exist
    //         if (!str_contains($content, "use Kakarot\\LaravelInitialSetup\\Traits\\RouteHandler;")) {
    //             $content = str_replace(
    //                 "<?php",
    //                 "<?php\n\nuse Kakarot\\LaravelInitialSetup\\Traits\\RouteHandler;",
    //                 $content
    //             );
    //         }

    //         if (!str_contains($content, "use Kakarot\\LaravelInitialSetup\\Traits\\ExceptionHandler;")) {
    //             $content = str_replace(
    //                 "<?php",
    //                 "<?php\n\nuse Kakarot\\LaravelInitialSetup\\Traits\\ExceptionHandler;",
    //                 $content
    //             );
    //         }

    //         // Add RouteHandler::configureApiVersioning() inside Application::configure(...)
    //         if (!str_contains($content, "RouteHandler::configureApiVersioning()")) {
    //             $content = str_replace(
    //                 "->withRouting(",
    //                 "->withRouting(\n        then: RouteHandler::configureApiVersioning(),",
    //                 $content
    //             );
    //         }

    //         // Add ExceptionHandler::handleApiException() inside withExceptions(...)
    //         if (!str_contains($content, "ExceptionHandler::handleApiException(")) {
    //             $content = str_replace(
    //                 "->withExceptions(",
    //                 "->withExceptions(\n        then: ExceptionHandler::handleApiException(\$exceptions),",
    //                 $content
    //             );
    //         }



    //         if (file_exists($appFile)) {
    //             $content = file_get_contents($appFile);

    //             // Ensure HandleLocalization middleware import exists
    //             if (!str_contains($content, "use Kakarot\\LaravelInitialSetup\\Middleware\\HandleLocalization;")) {
    //                 $content = str_replace(
    //                     "<?php",
    //                     "<?php\n\nuse Kakarot\\LaravelInitialSetup\\Middleware\\HandleLocalization;",
    //                     $content
    //                 );
    //             }

    //             // Register the middleware inside withMiddleware()
    //             if (!str_contains($content, "HandleLocalization::class")) {
    //                 $content = str_replace(
    //                     "->withMiddleware(function (Middleware \$middleware) {",
    //                     "->withMiddleware(function (Middleware \$middleware) {\n        \$middleware->append(HandleLocalization::class);",
    //                     $content
    //                 );
    //             }
    //         }

    //         file_put_contents($appFile, $content);
    //     }
    // }

    // private function modifyAppFile()
    // {
    //     $appFile = base_path('bootstrap/app.php');

    //     if (file_exists($appFile)) {
    //         $content = file_get_contents($appFile);

    //         // Ensure RouteHandler and ExceptionHandler imports exist
    //         $imports = [
    //             "use Kakarot\\LaravelInitialSetup\\Traits\\RouteHandler;",
    //             "use Kakarot\\LaravelInitialSetup\\Traits\\ExceptionHandler;",
    //             "use Kakarot\\LaravelInitialSetup\\Middleware\\HandleLocalization;",
    //         ];

    //         foreach ($imports as $import) {
    //             if (!str_contains($content, $import)) {
    //                 $content = preg_replace('/<\?php\s*/', "<?php\n\n$import\n", $content, 1);
    //             }
    //         }

    //         // Ensure RouteHandler is added inside withRouting()
    //         if (!str_contains($content, "RouteHandler::configureApiVersioning()")) {
    //             $content = preg_replace(
    //                 '/->withRouting\((.*?)\)/s',
    //                 "->withRouting($1,\n        then: RouteHandler::configureApiVersioning())",
    //                 $content
    //             );
    //         }

    //         // Ensure ExceptionHandler is added inside withExceptions()
    //         if (!str_contains($content, "ExceptionHandler::handleApiException(")) {
    //             $content = preg_replace(
    //                 '/->withExceptions\((.*?)\)/s',
    //                 "->withExceptions($1,\n        ExceptionHandler::handleApiException(\$exceptions))",
    //                 $content
    //             );
    //         }

    //         // Ensure HandleLocalization middleware is registered
    //         if (!str_contains($content, "HandleLocalization::class")) {
    //             $content = preg_replace(
    //                 '/->withMiddleware\(function \(Middleware \$middleware\) \{/',
    //                 "->withMiddleware(function (Middleware \$middleware) {\n        \$middleware->append(HandleLocalization::class);",
    //                 $content
    //             );
    //         }

    //         file_put_contents($appFile, $content);
    //     }
    // }

    // private function modifyAppFile()
    // {
    //     $appFile = base_path('bootstrap/app.php');

    //     if (file_exists($appFile)) {
    //         $content = file_get_contents($appFile);

    //         // Ensure necessary imports exist
    //         $imports = [
    //             "use Kakarot\\LaravelInitialSetup\\Traits\\RouteHandler;",
    //             "use Kakarot\\LaravelInitialSetup\\Traits\\ExceptionHandler;",
    //             "use Kakarot\\LaravelInitialSetup\\Middleware\\HandleLocalization;"
    //         ];

    //         foreach ($imports as $import) {
    //             if (!str_contains($content, $import)) {
    //                 $content = str_replace("<?php", "<?php\n\n$import", $content);
    //             }
    //         }

    //         // Fix `withRouting` to correctly insert `then: RouteHandler::configureApiVersioning()`
    //         if (!str_contains($content, "RouteHandler::configureApiVersioning()")) {
    //             $content = preg_replace(
    //                 '/->withRouting\(\s*(.*?)\s*\)/s',
    //                 "->withRouting(\n$1,\nthen: RouteHandler::configureApiVersioning()\n)",
    //                 $content
    //             );
    //         }

    //         // Fix `withExceptions` to properly add ExceptionHandler inside the function
    //         if (!str_contains($content, "ExceptionHandler::handleApiException(\$exceptions)")) {
    //             $content = preg_replace(
    //                 '/->withExceptions\(function\s*\(Exceptions\s*\$exceptions\)\s*{/',
    //                 "->withExceptions(function (Exceptions \$exceptions) {\n        ExceptionHandler::handleApiException(\$exceptions);",
    //                 $content
    //             );
    //         }

    //         // Register the middleware inside `withMiddleware`
    //         if (!str_contains($content, "HandleLocalization::class")) {
    //             $content = preg_replace(
    //                 '/->withMiddleware\(function\s*\(Middleware\s*\$middleware\)\s*{/',
    //                 "->withMiddleware(function (Middleware \$middleware) {\n        \$middleware->append(HandleLocalization::class);",
    //                 $content
    //             );
    //         }

    //         file_put_contents($appFile, $content);
    //     }
    // }
}
