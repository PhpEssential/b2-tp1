<?php
namespace App\Controller;

use App\Controller\BaseController;
use App\Model\ArticleModel;
use App\Util\DatabaseUtil;

class ArticleController extends BaseController{
    private $articleModel;

    public function __construct() {
        parent::__construct();
        $this->isLoggedIn();
        $this->articleModel = new ArticleModel(DatabaseUtil::databaseConnection());
    }

    public function list() {
    }

    public function create() {
    }

    public function edit() {
    }

    public function delete() {
    }

    public function showListView() {
    }

    public function showCreateView() {
    }
    
    public function showEditView() {
    }
}
?>