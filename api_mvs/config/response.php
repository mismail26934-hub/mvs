<?php

function jsonResponse(array $data, $code = 200)
{
    http_response_code($code);
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');

    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

function jsonSuccess($data = null, $message = 'OK', $code = 200)
{
    jsonResponse([
        'success' => true,
        'message' => $message,
        'data' => $data,
    ], $code);
}

function jsonError($message, $code = 400, $errors = null)
{
    jsonResponse([
        'success' => false,
        'message' => $message,
        'errors' => $errors,
    ], $code);
}

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}
