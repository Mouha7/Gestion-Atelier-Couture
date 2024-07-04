<?php
namespace Macbook\Core;

use Macbook\Core\Session;

class Autorisation {
    public static function isConnect():bool {
        return Session::get("userConnect") != false;
    }

    public static function hasRole(string $role):bool {
        $userConnect = Session::get("userConnect");
        if($userConnect) {
            return $userConnect["nomRole"] == $role;
        }
        return false;
    }
}