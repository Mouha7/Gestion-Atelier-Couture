<?php

namespace Macbook\Controllers;

define("LISTE", "controller=categorie&action=liste");

use Macbook\Core\Session;
use Macbook\Core\Validator;
use Macbook\Core\Controller;
use Macbook\Core\Autorisation;
use Macbook\Models\CategorieModel;
use Macbook\Models\TypeModel;

class CategorieController extends Controller
{
    private CategorieModel $categorieModel;
    private TypeModel $typeModel;

    public function __construct()
    {
        parent::__construct();
        if (!Autorisation::isConnect()) {
            $this->redirectToRouter("controller=security&action=show-form");
        }
        $this->categorieModel = new CategorieModel();
        $this->typeModel = new TypeModel();
        $this->load();
    }

    public function load()
    {
        if (isset($_REQUEST["action"])) {
            if ($_REQUEST["action"] == "liste") {
                if(isset($_REQUEST["page"])) {
                    $this->listCategorie($_REQUEST["page"]);
                }
                $this->listCategorie();
            } elseif ($_REQUEST["action"] == "save-categorie") {
                $this->store($_REQUEST);
                $this->redirectToRouter(LISTE);
            } elseif ($_REQUEST["action"] == "archive-categorie") {
                $this->archiver($_REQUEST);
                $this->redirectToRouter(LISTE);
            } elseif ($_REQUEST["action"] == "delete-categorie") {
                $this->supprimer($_REQUEST["idCategorie"]);
                $this->redirectToRouter(LISTE);
            } elseif ($_REQUEST["action"] == "detail-categorie") {
                $this->details($_REQUEST["idCategorie"]);
            } elseif ($_REQUEST["action"] == "update-categorie") {
                $this->modify($_REQUEST);
                $this->redirectToRouter(LISTE);
            }
        }
    }

    private function listCategorie(int $page=0)
    {
        $this->renderView("../views/categories/liste", ["categorie_array" => $this->categorieModel->findAllWithPag($page, OFFSET), "currentPage" => $page, "type_array" => $this->typeModel->findAll()]);
    }

    private function store(array $data)
    {
        Validator::isEmpty($data["nomCategorie"], "nomCategorie");
        if (Validator::isValid()) {
            $categorie = $this->categorieModel->findByName("nomCategorie", $data["nomCategorie"]);
            if ($categorie) {
                Validator::add("nomCategorie", "La valeur existe déjà!");
                Session::add("errors", Validator::$errors);
            } else {
                $this->categorieModel->save($data);
            }
        } else {
            Session::add("errors", Validator::$errors);
        }
    }

    private function details($value)
    {
        $this->renderView("../views/categories/update", ["categorie" => $this->categorieModel->findOne($value)]);
    }

    private function modify(array $data)
    {
        $this->categorieModel->update($data);
    }

    private function supprimer($value)
    {
        $this->categorieModel->delete($value);
    }

    private function archiver($data)
    {
        $this->categorieModel->archived($data);
    }
}
