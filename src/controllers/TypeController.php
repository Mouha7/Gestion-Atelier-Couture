<?php

namespace Macbook\Controllers;
define("LISTE","controller=type&action=liste");

use Macbook\Core\Session;
use Macbook\Core\Validator;
use Macbook\Core\Controller;
use Macbook\Core\Autorisation;
use Macbook\Models\TypeModel;




class TypeController extends Controller
{
    private TypeModel $typeModel;
    public function __construct()
    {
        parent::__construct();
        if (!Autorisation::isConnect()) {
            $this->redirectToRouter("controller=security&action=show-form");
        }
        $this->typeModel = new TypeModel();
        $this->load();
    }
    public function load()
    {
        if (isset($_REQUEST["action"])) {
            if ($_REQUEST["action"] == "liste") {
                $this->listType();
            } elseif ($_REQUEST["action"] == "save-type") {
                unset($_REQUEST["action"]);
                unset($_REQUEST["controller"]);
                $this->store($_REQUEST);
                parent::redirectToRouter(LISTE);
            } elseif ($_REQUEST["action"] == "delete-type") {
                $this->supprimer($_REQUEST["idType"]);
                $this->redirectToRouter(LISTE);
            } elseif ($_REQUEST["action"] == "detail-type") {
                $this->details($_REQUEST["idType"]);
            } elseif ($_REQUEST["action"] == "update-type") {
                unset($_REQUEST["action"]);
                unset($_REQUEST["controller"]);
                $this->modify($_REQUEST);
                $this->redirectToRouter(LISTE);
            }
        }
    }
    private function listType()
    {
        $this->renderView("../views/types/liste", ["type_array" => $this->typeModel->findAll()]);
    }

    private function store(array $data)
    {
        Validator::isEmpty($data["nomType"], "nomType");
        if (Validator::isValid()) {
            $type = $this->typeModel->findByName("nomType", $data["nomType"]);
            if ($type) {
                Validator::add("nomType", "La valeur existe déjà!");
                Session::add("errors", Validator::$errors);
            } else {
                $this->typeModel->save($data);
            }
        } else {
            Session::add("errors", Validator::$errors);
        }
    }

    private function details($value)
    {
        $this->renderView("../views/types/update", ["type" => $this->typeModel->findOne($value)]);
    }

    private function modify(array $data)
    {
        $this->typeModel->update($data);
    }

    private function supprimer($value)
    {
        $this->typeModel->delete($value);
    }
}
