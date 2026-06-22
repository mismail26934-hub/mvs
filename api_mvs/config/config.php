<?php

$envFile = __DIR__ . '/../.env';
if (!is_readable($envFile)) {
    http_response_code(500);
    exit('Configuration error');
}

$lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($lines as $line) {
    $line = trim($line);
    if ($line === '' || $line[0] === '#') {
        continue;
    }
    if (strpos($line, '=') === false) {
        continue;
    }
    list($key, $value) = explode('=', $line, 2);
    $key = trim($key);
    $value = trim($value);
    if (!array_key_exists($key, $_ENV)) {
        $_ENV[$key] = $value;
        putenv("$key=$value");
    }
}

function env(string $key): string
{
    $value = $_ENV[$key] ?? getenv($key);
    if ($value === false) {
        http_response_code(500);
        exit('Configuration error');
    }

    return $value;
}

define('DB_HOST', env('DB_HOST'));
define('DB_NAME', env('DB_NAME'));
define('DB_USER', env('DB_USER'));
define('DB_PASS', env('DB_PASS'));
define('BASE_URL', rtrim(env('BASE_URL'), '/') . '/');
