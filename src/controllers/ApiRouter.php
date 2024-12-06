<?php

require_once 'WebServiceController.php';

$controller = new WebServiceController();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller->getContacts();
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
}
