<?php

namespace Macbook\Api;

use Macbook\Core\Session;
use Macbook\Core\Validator;
use Macbook\Core\Controller;
use Macbook\Models\TypeModel;
use Macbook\Core\Autorisation;
define("LISTE","controller=type&action=liste");




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
            if ($_REQUEST["action"] == "api-liste") {
                $this->listType();
            } elseif ($_REQUEST["action"] == "api-save-type") {
                unset($_REQUEST["action"]);
                unset($_REQUEST["controller"]);
                $this->store($_REQUEST);
                parent::redirectToRouter(LISTE);
            } elseif ($_REQUEST["action"] == "api-delete-type") {
                $this->supprimer($_REQUEST["idType"]);
                $this->redirectToRouter(LISTE);
            } elseif ($_REQUEST["action"] == "api-detail-type") {
                $this->details($_REQUEST["idType"]);
            } elseif ($_REQUEST["action"] == "api-update-type") {
                unset($_REQUEST["action"]);
                unset($_REQUEST["controller"]);
                $this->modify($_REQUEST);
                $this->redirectToRouter(LISTE);
            }
        }
    }
    private function listType()
    {
        parent::renderJson($this->typeModel->findAll());
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
