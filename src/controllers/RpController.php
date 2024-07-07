<?php

namespace Macbook\Controllers;

define("LISTE", "controller=rp&action=liste");

use Macbook\Core\Session;
use Macbook\Core\Validator;
use Macbook\Core\Controller;
use Macbook\Core\Autorisation;
use Macbook\Models\ArticleModel;
use Macbook\Models\UserModel;
use Macbook\Models\ProdVenteModel;

class RpController extends Controller
{
    private ArticleModel $articleModel;
    private ProdVenteModel $prodVenteModel;
    private UserModel $userModel;
    public function __construct()
    {
        parent::__construct();
        if (!Autorisation::isConnect()) {
            $this->redirectToRouter("controller=security&action=show-form");
        }
        $this->userModel = new UserModel();
        $this->articleModel = new ArticleModel();
        $this->prodVenteModel = new ProdVenteModel();
        $this->load();
    }

    public function load()
    {
        if (isset($_REQUEST["action"])) {
            if ($_REQUEST["action"] == "liste") {
                if(isset($_REQUEST["page"])) {
                    $this->list($_REQUEST["page"]);
                }
                $this->list();
            } elseif ($_REQUEST["action"] == "save-rp") {
                unset($_REQUEST["action"]);
                unset($_REQUEST["controller"]);
                $this->store($_REQUEST, $_FILES);
                $this->redirectToRouter(LISTE);
            } elseif ($_REQUEST["action"] == "archive-rp") {
                $this->archiver($_REQUEST);
                $this->redirectToRouter(LISTE);
            } elseif ($_REQUEST["action"] == "delete-rp") {
                $this->supprimer($_REQUEST["idUser"]);
                $this->redirectToRouter(LISTE);
            } elseif ($_REQUEST["action"] == "detail-rp") {
                $this->details($_REQUEST["idUser"]);
            } elseif ($_REQUEST["action"] == "update-rp") {
                unset($_REQUEST["action"]);
                unset($_REQUEST["controller"]);
                $this->modify($_REQUEST, $_FILES);
                $this->redirectToRouter(LISTE);
            } elseif ($_REQUEST["action"] == "liste-vente") {
                if (isset($_REQUEST["page"])) {
                    $this->listVente($_REQUEST["page"]);
                }
                $this->listVente();
            } elseif ($_REQUEST["action"] == "save-vente") {
                $this->saveVente($_REQUEST);
                $this->redirectToRouter("controller=rp&action=liste-vente");
            } elseif ($_REQUEST["action"] == "details-vente") {
                $this->details($_REQUEST["idProd"]);
            }
        }
    }

    private function list(int $page=0)
    {
        $this->renderView("../views/rp/liste", ["array" => $this->userModel->findAllInterneWithPag(3, $page, OFFSET), "currentPage" => $page]);
    }

    private function listVente(int $page=0)
    {
        $this->renderView("../views/rp/liste.vente", ["array" => $this->prodVenteModel->findAllWithPag($page, OFFSET), "currentPage" => $page, "articles" => $this->articleModel->findAllVente()]);
    }

    private function saveVente(array $data)
    {
        $article = $this->prodVenteModel->findArticleVente($data["idArticle"]);

        if ($article["qteStock"] < $data["qteProd"]) {
            Validator::isEmpty($data["idArticle"], "article");
            if (Validator::isValid()) {
                Validator::add("article", "Erreur, la quantité saisit est supérieur à la quantité restant.");
                Session::add("errors", Validator::$errors);
            }
        } else {
            $this->prodVenteModel->save($data, $article);
        }
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
                $this->userModel->saveInterne($data, $files, '@rp.sn', 3);
            }
        } else {
            Session::add("errors", Validator::$errors);
        }
    }

    private function details(int $value)
    {
        $this->renderView("../views/rp/details", ["value" => $this->prodVenteModel->findOne($value)]);
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
