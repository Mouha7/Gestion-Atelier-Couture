<?php

namespace Macbook\Core;


use Macbook\Controllers\RpController;
use Macbook\Controllers\RsController;
use Macbook\Controllers\TypeController;
use Macbook\Controllers\UserController;
use Macbook\Controllers\VenteController;
use Macbook\Controllers\ClientController;
use Macbook\Controllers\ArticleController;
use Macbook\Controllers\VendeurController;
use Macbook\Controllers\SecurityController;
use Macbook\Controllers\CategorieController;
use Macbook\Controllers\ConfectionController;
use Macbook\Controllers\FournisseurController;
use Macbook\Api\TypeController as ApiTypeController;

class Router
{
    public static function run()
    {
        $controller = null;
        if (isset($_REQUEST["controller"])) {
            if ($_REQUEST["controller"] == "article") {
                $controller = new ArticleController();
            } elseif ($_REQUEST["controller"] == "categorie") {
                $controller = new CategorieController();
            } elseif ($_REQUEST["controller"] == "fournisseur") {
                $controller = new FournisseurController();
            } elseif ($_REQUEST["controller"] == "client") {
                $controller = new ClientController();
            } elseif ($_REQUEST["controller"] == "rs") {
                $controller = new RsController();
            } elseif ($_REQUEST["controller"] == "rp") {
                $controller = new RpController();
            } elseif ($_REQUEST["controller"] == "vendeur") {
                $controller = new VendeurController();
            } elseif ($_REQUEST["controller"] == "confection") {
                $controller = new ConfectionController();
            } elseif ($_REQUEST["controller"] == "vente") {
                $controller = new VenteController();
            } elseif ($_REQUEST["controller"] == "user") {
                $controller = new UserController();
            } elseif ($_REQUEST["controller"] == "type") {
                $controller = new TypeController();
            } elseif ($_REQUEST["controller"] == "api-type") {
                $controller = new ApiTypeController();
            } elseif ($_REQUEST["controller"] == "security") {
                $controller = new SecurityController();
            }
        } else {
            $controller = new SecurityController();
        }
    }
}
