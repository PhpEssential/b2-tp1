<?php
namespace App\Controller;

use App\Controller\BaseController;
use App\Model\UserModel;
use App\Util\DatabaseUtil;

class UserController extends BaseController{
    private $userModel;

    public function __construct() {
        parent::__construct();
        $this->isLoggedIn();
        $this->userModel = new UserModel(DatabaseUtil::databaseConnection());
    }

    public function list() {
        // Check if parameters are here
        if (!isset($_POST["length"]) || !isset($_POST["start"]) || !isset($_POST['search']['value'])) {
            $this->badRequest("Paramètre(s) manquant");
        }

        // Retrieve limit, offset, and search parameters sent via POST
        $limit = intval($_POST['length']);
        $offset = intval($_POST['start']);
        $search = $_POST['search']['value'];
    
        // Fetch users with limit, offset, and search parameters
        $result = $this->userModel->getUsersWithLimitOffsetAndSearch($limit, $offset, $search);
    
        // Prepare data in the required format for DataTables
        $data = [];
        foreach ($result['users'] as $user) {
            $data[] = [
                'name' => $user['name'],
                'email' => $user['email'],
                'action' => '<a href="user-edit?id=' . $user['id'] . '" class="btn btn-primary btn-sm">Modifier</a>
                             <a href="user-delete?id=' . $user['id'] . '" class="btn btn-danger btn-sm">Supprimer</a>'
            ];
        }
    
        // Return JSON response including total count and filtered count
        $this->sendJson([
            'draw' => intval($_POST['draw']),
            'recordsTotal' => $result['total'],
            'recordsFiltered' => $result['filtered'],
            'data' => $data
        ]);
    }

    public function create() {
        // Check if parameters are here
        if (empty($_POST["name"]) || empty($_POST["email"]) || empty($_POST["password"]) || empty($_POST["role"])) {
            $this->badRequest("Paramètre(s) manquant");
        }

        // Handle security purpose
        if($_SESSION['role'] != 1) {
            $this->unauthorized("Impossible de créer un compte !");
        }

        // Check if the email is already taken
        $existingUser = $this->userModel->getUserByEmail($_POST["email"]);
        if ($existingUser) {
            $this->loadView("UserAddView", ['status' => "error", 'message' => "L'email est déjà utilisé !"]);
        }

        // Create the user
        $userId = $this->userModel->createUser($_POST["name"], $_POST["email"], password_hash($_POST["password"], PASSWORD_BCRYPT), $_POST["role"]);
        if ($userId) {
            $this->redirect("user-list");
        } else {
            $this->loadView("UserAddView", ['status' => "error", 'message' => "Une erreur s'est produite lors de la création de l'utilisateur :/"]);
        }
    }

    public function edit() {
        // Check if parameters are here
        if (empty($_POST["userId"]) || empty($_POST["name"]) || empty($_POST["email"]) || empty($_POST["role"])) {
            $this->badRequest("Paramètre(s) manquant");
        }

        // Handle security purpose
        if($_SESSION['role'] != 1 && $_POST['userId'] != $_SESSION["user_id"]) {
            $this->unauthorized("Impossible de modifier un autre compte que le votre !");
        }

        // Retrieve user data from POST parameters
        $id = $_POST['userId'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $role = $_POST['role'];
    
        $user = $this->userModel->getUserById($id);
        if(empty($user)) {
            $this->badRequest("");
        }
        $existingUser = $this->userModel->getUserByEmail($email);
        if ($existingUser && $existingUser['id'] != $id) {
            $this->loadView("UserEditView", ["user" => $user, 'status' => "error", 'message' => "L'email est déjà utilisé !"]);
        }

        // Update user in the database using the UserModel
        $this->userModel->updateUser($id, $name, $email, $role);
        
        // Redirect to user list page upon successful update
        $this->redirect("user-list");
    }

    public function delete() {
        // Check if parameters are here
        if (empty($_GET["id"])) {
            $this->badRequest("Paramètre(s) manquant");
        }

        // Handle security purpose
        if($_SESSION['role'] != 1 && $_GET['id'] != $_SESSION["user_id"]) {
            $this->unauthorized("Impossible de supprimer un autre compte que le votre !");
        }

        // Delete the user
        $this->userModel->deleteUser($_GET["id"]);
        $this->redirect("user-list");
    }

    public function showListView() {
        // Handle security purpose
        if($_SESSION['role'] != 1) {
            $this->unauthorized("Impossible de créer un compte !");
        }
        
        // Load the create user view
        $this->loadView("UserListView");
    }

    public function showCreateView() {
        // Handle security purpose
        if($_SESSION['role'] != 1) {
            $this->unauthorized("Impossible de créer un compte !");
        }

        // Load the create user view
        $this->loadView("UserAddView");
    }
    
    public function showEditView() {
        // Check if parameters are here
        if (empty($_GET["id"])) {
            $this->badRequest("Paramètre(s) manquant");
        }

        // Handle security purpose
        if($_SESSION['role'] != 1 && $_GET['userId'] != $_SESSION["user_id"]) {
            $this->unauthorized("Impossible de modifier un autre compte que le votre !");
        }

        // Load the edit user view with the user's ID
        $user = $this->userModel->getUserById($_GET['id']);
        if(empty($user)) {
            $this->badRequest("Utilisateur introuvable");
        }
        $this->loadView("UserEditView", ["user" => $user]);
    }
}
?>