<?php

require_once __DIR__ . '/../models/WebServiceModel.php';

class WebServiceController {
    private $model;

    public function __construct() {
        $this->model = new WebServiceModel();
    }

    public function getContacts() {
        try {
            $data = $this->model->fetchContacts();
            header('Content-Type: application/json');
            echo json_encode($data);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
