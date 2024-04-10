<?php
require_once '../vendor/autoload.php';

use App\Controller\LoginController;
use App\Controller\UserController;



// Routing
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'login': (new LoginController())->login(); break;
    case 'logout': (new LoginController())->logout(); break;
    case 'generate-password': (new LoginController())->generatePassword(); break;
    case 'home': (new LoginController())->home(); break;

    case 'user-list': (new UserController())->showListView(); break;
    case 'user-list-data': (new UserController())->list(); break;
    case 'user-edit': (new UserController())->showEditView(); break;
    case 'user-edit-action': (new UserController())->edit(); break;
    case 'user-add': (new UserController())->showCreateView(); break;
    case 'user-add-action': (new UserController())->create(); break;
    case 'user-delete': (new UserController())->delete(); break;
    default: (new LoginController())->login(); break;
}
?>