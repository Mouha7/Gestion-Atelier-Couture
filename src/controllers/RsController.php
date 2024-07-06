<?php

namespace Macbook\Controllers;

use Macbook\Models\PanierModel;

define("LISTE", "controller=rs&action=liste");

use Macbook\Core\Session;
use Macbook\Core\Validator;
use Macbook\Core\Controller;
use Macbook\Core\Autorisation;
use Macbook\Models\ApproModel;
use Macbook\Models\ArticleModel;
use Macbook\Models\UserModel;

class RsController extends Controller
{
    private ApproModel $approModel;
    private UserModel $userModel;
    private ArticleModel $articleModel;
    public function __construct()
    {
        parent::__construct();
        if (!Autorisation::isConnect()) {
            $this->redirectToRouter("controller=security&action=show-form");
        }
        $this->userModel = new UserModel();
        $this->articleModel = new ArticleModel();
        $this->approModel = new ApproModel();
        $this->load();
    }

    public function load()
    {
        if (isset($_REQUEST["action"])) {
            if ($_REQUEST["action"] == "liste") {
                $this->list();
            } elseif ($_REQUEST["action"] == "save-rs") {
                unset($_REQUEST["action"]);
                unset($_REQUEST["controller"]);
                $this->store($_REQUEST, $_FILES);
                $this->redirectToRouter(LISTE);
            } elseif ($_REQUEST["action"] == "archive-rs") {
                $this->archiver($_REQUEST);
                $this->redirectToRouter(LISTE);
            } elseif ($_REQUEST["action"] == "delete-rs") {
                $this->supprimer($_REQUEST["idUser"]);
                $this->redirectToRouter(LISTE);
            } elseif ($_REQUEST["action"] == "update-rs") {
                unset($_REQUEST["action"]);
                unset($_REQUEST["controller"]);
                $this->modify($_REQUEST, $_FILES);
                $this->redirectToRouter(LISTE);
            } elseif ($_REQUEST["action"] == "liste-appro") {
                $this->listAppro();
            } elseif ($_REQUEST["action"] == "save-appro") {
                $this->saveAppro();
                $this->redirectToRouter("controller=rs&action=liste-appro");
            } elseif ($_REQUEST["action"] == "save-article") {
                $this->saveArticleInAppro($_REQUEST);
                $this->redirectToRouter("controller=rs&action=liste-appro");
            } elseif ($_REQUEST["action"] == "details-appro") {
                $this->details($_REQUEST);
            }
        }
    }

    private function list()
    {
        $this->renderView("../views/rs/liste", ["array" => $this->userModel->findAllInterne(2)]);
    }

    public function listAppro()
    {
        $this->renderView("../views/rs/liste.appro", ["array" => $this->approModel->findAll(), "fours" => $this->userModel->findAllInterne(2), "conf" => $this->articleModel->findAllConfection()]);
    }

    private function store(array $data, array $files)
    {
        Validator::isEmpty($data["nom"], "nom");
        Validator::isEmpty($data["prenom"], "prenom");
        if (Validator::isValid()) {
            $value1 = $this->userModel->findByName("nom", $data["nom"]);
            $value2 = $this->userModel->findByName("prenom", $data["prenom"]);
            if ($value1 && $value2) {
                Validator::add("nom", "La valeur existe déjà!");
                Validator::add("prenom", "La valeur existe déjà!");
                Session::add("errors", Validator::$errors);
            } else {
                $this->userModel->saveInterne($data, $files, '@rs.sn', 2);
            }
        } else {
            Session::add("errors", Validator::$errors);
        }
    }

    public function saveAppro()
    {
        $appros = Session::get('panier');
        $this->approModel->save($appros);
        $appros->clearPanier();
        Session::remove('panier');
    }

    public function saveArticleInAppro(array $data)
    {
        if (!Session::get('panier')) {
            $panier = new PanierModel;
        } else {
            $panier = Session::get('panier');
        }
        $panier->addArticle($this->articleModel->findById($data['idArticle']), $data['idUser'], $data['qteAppro'], $data['observations']);
        Session::add('panier', $panier);
    }

    private function details(array $data)
    {
        $this->renderView("../views/rs/details", ["user" => $this->userModel->findOne($data['idUser']), "details" => $this->approModel->findArticleByAppro($data['idAppro'])]);
    }

    private function modify(array $data, array $files)
    {
        $this->userModel->updateInterne($data, $files);
    }

    private function supprimer($value)
    {
        $this->userModel->delete($value);
    }

    private function archiver($data)
    {
        $this->userModel->archived($data);
    }
}
