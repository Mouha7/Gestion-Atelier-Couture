<?php

namespace Macbook\Controllers;
use Macbook\Models\ApproModel;

define("LISTE", "controller=vente&action=liste");

use Macbook\Core\Session;
use Macbook\Core\Validator;
use Macbook\Core\Controller;
use Macbook\Models\UserModel;
use Macbook\Core\Autorisation;
use Macbook\Models\VenteModel;
use Macbook\Models\ArticleModel;
use Macbook\Models\PanierVenteModel;
use Macbook\Models\ProdVenteModel;

class VenteController extends Controller
{
    private ArticleModel $articleModel;
    private ProdVenteModel $prodVenteModel;
    private VenteModel $venteModel;
    private ApproModel $approModel;
    private UserModel $userModel;
    public function __construct()
    {
        parent::__construct();
        if (!Autorisation::isConnect()) {
            $this->redirectToRouter("controller=security&action=show-form");
        }
        $this->articleModel = new ArticleModel();
        $this->prodVenteModel = new ProdVenteModel();
        $this->venteModel = new VenteModel();
        $this->approModel = new ApproModel();
        $this->userModel = new UserModel();
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
                $this->details($_REQUEST);
            } elseif ($_REQUEST["action"] == "update-vente") {
                unset($_REQUEST["action"]);
                unset($_REQUEST["controller"]);
                $this->modify($_REQUEST, $_FILES);
                $this->redirectToRouter(LISTE);
            } elseif ($_REQUEST["action"] == "liste-vente") {
                if(isset($_REQUEST["page"])) {
                    $this->listeVente($_REQUEST["page"]);
                }
                $this->listeVente();
            } elseif ($_REQUEST["action"] == "save-article") {
                $this->saveArticleInVente($_REQUEST);
                $this->redirectToRouter("controller=vente&action=liste-vente");
            } elseif ($_REQUEST["action"] == "save-article-vente") {
                $this->saveVente();
                $this->redirectToRouter("controller=vente&action=liste-vente");
            }
        }
    }

    private function list(int $page=0)
    {
        $this->renderView("../views/vente/liste", ["array" => $this->articleModel->findAllVenteWithPag($page, OFFSET), "currentPage" => $page]);
    }

    private function listeVente(int $page=0)
    {
        $this->renderView("../views/vente/liste.vente", ["array" => $this->venteModel->findAllWithPag($page, OFFSET), "currentPage" => $page, "client" => $this->userModel->findAllClient(), "articles" => $this->prodVenteModel->findAll()]);
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

    public function saveArticleInVente(array $data) {
        if (!Session::get('panier')) {
            $panier = new PanierVenteModel();
        } else {
            $panier = Session::get('panier');
        }
        $panier->addArticle($this->prodVenteModel->findProdById($data['idArticle']), $data['idUser'], $data['qteAppro'], $data['observations']);
        Session::add('panier', $panier);
    }

    public function saveVente()
    {
        $ventes = Session::get('panier');
        $this->venteModel->save($ventes);
        $ventes->clearPanier();
        Session::remove('panier');
    }

    private function details(array $data)
    {
        $this->renderView("../views/vente/details", ["user" => $this->userModel->findOne($data['idUser']), "details" => $this->approModel->findArticleByProd($data['idVendeur'])]);
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
