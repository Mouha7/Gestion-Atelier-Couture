<?php
namespace Macbook\Controllers;

define("LISTE", "controller=categorie&action=liste");

use Macbook\Core\Session;
use Macbook\Core\Validator;
use Macbook\Core\Controller;
use Macbook\Models\UserModel;
use Macbook\Core\Autorisation;

class UserController extends Controller
{
    private UserModel $userModel;

    public function __construct()
    {
        parent::__construct();
        if (!Autorisation::isConnect()) {
            $this->redirectToRouter("controller=security&action=show-form");
        }
        $this->userModel = new UserModel();
        $this->load();
    }

    public function load()
    {
        if (isset($_REQUEST)) {
            if ($_REQUEST['action'] == 'update-password') {
                $this->modifyPassword($_REQUEST);
                parent::redirectToRouter(LISTE);
            } elseif ($_REQUEST['action'] == 'update-info') {
                $this->modifyInfo($_REQUEST, $_FILES);
            }
        }
    }

    private function modifyPassword(array $data)
    {
        $password = $data["password"];
        $password_confirmation = $data["password_confirmation"];
        Validator::isEmpty($password, "password");
        Validator::isEmpty($password_confirmation, "password_confirmation");
        if (Validator::isValid()) {
            if ($password != $password_confirmation) {
                Validator::add("password", "Les mots de passe ne correspondent pas !");
                Session::add("errors", Validator::$errors);
                dd(Session::get(''));
            } else {
                $this->userModel->updatePassword($data);
            }
        } else {
            Session::add("errors", Validator::$errors);
        }
    }

    private function modifyInfo(array $data, array $files)
    {
        $this->userModel->updateInfo($data, $files);
    }
}
