<?php

// Stub HTTP server for testing JobRunner — run with: php -S localhost:9999 tests/stubs/server.php
// Log incoming request to STDERR (shows in terminal if needed)
file_put_contents('php://stderr', json_encode([
        'method' => $_SERVER['REQUEST_METHOD'],
        'headers' => getallheaders(),
        'body' => file_get_contents('php://input'),
        'time' => date('c'),
    ]) . PHP_EOL);

// Set response
http_response_code(200);
header('Content-Type: application/json');

echo json_encode([
    'status' => 'ok',
    'message' => 'This is a stub server response',
]);
