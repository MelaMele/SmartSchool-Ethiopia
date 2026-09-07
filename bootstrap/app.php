<?php

$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

// ለ Vercel ሰርቨር የ Storage ፎልደሩን ወደ /tmp ማዞር
if (isset($_ENV['APP_STORAGE']) || getenv('APP_STORAGE')) {
    $app->useStoragePath(getenv('APP_STORAGE') ?: $_ENV['APP_STORAGE']);
}

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

return $app;
