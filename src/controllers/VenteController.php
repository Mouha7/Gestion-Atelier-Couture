<?php

namespace Macbook\Controllers;

define("LISTE", "controller=vente&action=liste");

use Macbook\Core\Session;
use Macbook\Core\Validator;
use Macbook\Core\Controller;
use Macbook\Core\Autorisation;
use Macbook\Models\ArticleModel;

class VenteController extends Controller
{
    private ArticleModel $articleModel;
    public function __construct()
    {
        parent::__construct();
        if (!Autorisation::isConnect()) {
            $this->redirectToRouter("controller=security&action=show-form");
        }
        $this->articleModel = new ArticleModel();
        $this->load();
    }

    public function load()
    {
        if (isset($_REQUEST["action"])) {
            if ($_REQUEST["action"] == "liste") {
                $this->list();
            } elseif ($_REQUEST["action"] == "save-vente") {
                unset($_REQUEST["action"]);
                unset($_REQUEST["controller"]);
                $this->store($_REQUEST, $_FILES);
                $this->redirectToRouter(LISTE);
            } elseif ($_REQUEST["action"] == "archive-vente") {
                $this->archiver($_REQUEST);
                $this->redirectToRouter(LISTE);
            } elseif ($_REQUEST["action"] == "delete-vente") {
                $this->supprimer($_REQUEST["idArticle"]);
                $this->redirectToRouter(LISTE);
            } elseif ($_REQUEST["action"] == "detail-vente") {
                $this->details($_REQUEST["idArticle"]);
            } elseif ($_REQUEST["action"] == "update-vente") {
                unset($_REQUEST["action"]);
                unset($_REQUEST["controller"]);
                $this->modify($_REQUEST, $_FILES);
                $this->redirectToRouter(LISTE);
            }
        }
    }

    private function list()
    {
        $this->renderView("../views/vente/liste", ["array" => $this->articleModel->findAllVente()]);
    }

    private function store(array $data, array $files)
    {
        Validator::isEmpty($data["libelle"], "libelle");
        if (Validator::isValid()) {
            $value1 = $this->articleModel->findByName("libelle", $data["libelle"]);
            if ($value1) {
                Validator::add("libelle", "La valeur existe déjà!");
                Session::add("errors", Validator::$errors);
            } else {
                $this->articleModel->saveVente($data, $files);
            }
        } else {
            Session::add("errors", Validator::$errors);
        }
    }

    private function details($value)
    {
        $this->renderView("../views/vente/update", ["vente" => $this->articleModel->findOne($value)]);
    }

    private function modify(array $data, array $files)
    {
        $this->articleModel->updateVente($data, $files);
    }

    private function supprimer($value)
    {
        $this->articleModel->delete($value);
    }

    private function archiver($data)
    {
        $this->articleModel->archived($data);
    }
}
