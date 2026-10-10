<?php

/**
 * Entry point untuk Vercel (runtime vercel-php). Semua request diarahkan ke sini
 * lewat `routes` di vercel.json, lalu diteruskan ke public/index.php milik Laravel.
 *
 * Filesystem Vercel hanya bisa ditulis di /tmp, jadi:
 * - compiled view, cache bootstrap, dan log diarahkan ke /tmp atau stderr;
 * - database demo (database/demo.sqlite) disalin ke /tmp agar bisa ditulis
 *   selama instance berjalan (keranjang via cookie, checkout/kontak tetap jalan).
 * Nilai di sini hanya default; environment variable di Vercel menimpanya.
 */
$defaults = [
    'APP_ENV' => 'production',
    'APP_DEBUG' => 'false',
    'LOG_CHANNEL' => 'stderr',
    'SESSION_DRIVER' => 'cookie',
    'CACHE_STORE' => 'array',
    'QUEUE_CONNECTION' => 'sync',
    'VIEW_COMPILED_PATH' => '/tmp/views',
    'APP_CONFIG_CACHE' => '/tmp/cache/config.php',
    'APP_EVENTS_CACHE' => '/tmp/cache/events.php',
    'APP_PACKAGES_CACHE' => '/tmp/cache/packages.php',
    'APP_ROUTES_CACHE' => '/tmp/cache/routes.php',
    'APP_SERVICES_CACHE' => '/tmp/cache/services.php',
    'DB_CONNECTION' => 'sqlite',
    'DB_DATABASE' => '/tmp/harnid.sqlite',
];

foreach ($defaults as $key => $value) {
    if (getenv($key) === false && ! isset($_ENV[$key]) && ! isset($_SERVER[$key])) {
        putenv("{$key}={$value}");
        $_ENV[$key] = $_SERVER[$key] = $value;
    }
}

@mkdir('/tmp/views', 0777, true);
@mkdir('/tmp/cache', 0777, true);

$demoDb = __DIR__.'/../database/demo.sqlite';
$runtimeDb = getenv('DB_DATABASE');

if (getenv('DB_CONNECTION') === 'sqlite' && $runtimeDb && ! file_exists($runtimeDb) && file_exists($demoDb)) {
    @copy($demoDb, $runtimeDb);
}

require __DIR__.'/../public/index.php';
