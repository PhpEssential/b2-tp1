<?php
namespace App\Controller;

use App\Controller\BaseController;
use App\Model\UserModel;
use App\Util\DatabaseUtil;

class LoginController extends BaseController {
    private $userModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = new UserModel(DatabaseUtil::databaseConnection());
    }

    public function generatePassword() {
        $this->loadView("GeneratePasswordView");
    }

    public function home() {
        $this->isLoggedIn();
        $this->loadView("HomeView");
    }

    public function login() {
        if(isset($_SESSION['user_id'])) {
            header("Location: home");
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->userModel->getUserByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $this->redirect("home");
            } else {
                $error = "Adresse email ou mot de passe invalide";
            }
        }
        $this->loadView("LoginView");
    }

    public function logout() {
        session_destroy();
        $this->loadView("LoginView");
    }
}
?>