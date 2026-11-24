<?php

$envPath = realpath(dirname(__DIR__) . '/.env');

if (!$envPath || !file_exists($envPath)) {
    die(".env not found at: " . dirname(__DIR__) . '/.env');
}

$lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach ($lines as $line) {
    if (trim($line) === '' || $line[0] === '#') continue;

    list($key, $value) = array_map('trim', explode('=', $line, 2));

    $value = trim($value, "\"'");   // remove quotes if any

    putenv("$key=$value");
    $_ENV[$key] = $value;
}