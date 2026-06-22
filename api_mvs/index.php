<?php

require_once __DIR__ . '/config/response.php';
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/helpers/CrudHandler.php';
require_once __DIR__ . '/models/CustModel.php';
require_once __DIR__ . '/models/McsModel.php';
require_once __DIR__ . '/models/SoModel.php';
require_once __DIR__ . '/models/OdModel.php';
require_once __DIR__ . '/models/WaiverModel.php';
require_once __DIR__ . '/models/PinjamMcsModel.php';
require_once __DIR__ . '/models/RcvModel.php';
require_once __DIR__ . '/models/ScanMcsModel.php';

$resources = [
    'cust' => CustModel::class,
    'mcs' => McsModel::class,
    'so' => SoModel::class,
    'od' => OdModel::class,
    'waiver' => WaiverModel::class,
    'pinjam_mcs' => PinjamMcsModel::class,
    'rcv' => RcvModel::class,
    'scan_mcs' => ScanMcsModel::class,
];

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true) ?? [];

$route = trim($_GET['route'] ?? '', '/');
$parts = $route !== '' ? explode('/', $route) : [];
$resource = $parts[0] ?? '';
$id = isset($parts[1]) ? (int) $parts[1] : (int) ($_GET['id'] ?? 0);

if ($resource === '' || $resource === 'index.php') {
    $endpoints = [];
    foreach (array_keys($resources) as $name) {
        $endpoints[$name] = BASE_URL . $name;
    }

    jsonSuccess([
        'api' => 'MVS API',
        'base_url' => BASE_URL,
        'endpoints' => $endpoints,
        'methods' => ['GET', 'POST', 'PUT', 'DELETE'],
    ]);
}

if (!isset($resources[$resource])) {
    jsonError('Endpoint tidak ditemukan', 404);
}

try {
    $model = new $resources[$resource]();
    $handler = new CrudHandler($model);
    $handler->handle($method, $id, $input);
} catch (PDOException $e) {
    jsonError('Database error: ' . $e->getMessage(), 500);
}
