<?php
namespace App\Controller;

class BaseController {
    public function __construct() {
        session_start();
    }

    protected function isLoggedIn() {
        if (empty($_SESSION["user_id"])) {
            $this->redirect("LoginView");
        }
    }

    protected function badRequest($message="") {
        http_response_code(400);
        echo $message;
        exit;
    }

    protected function unauthorized($message="") {
        http_response_code(401);
        echo $message;
        exit;
    }

    protected function internalError($message="") {
        http_response_code(500);
        echo $message;
        exit;
    }

    protected function sendJson($response) {
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    protected function redirect($location) {
        header("Location: $location");
        exit;
    }

    protected function loadView($view, $data=[]) {
        include __DIR__ . '/../View/' . $view . ".php";
        exit;
    }
}