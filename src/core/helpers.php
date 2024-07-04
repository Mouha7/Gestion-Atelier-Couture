<?php
use Macbook\Core\Session;
use Macbook\Core\Autorisation;

function add_class_invalid(string $nameField) {
    echo isset(Session::get("errors")[$nameField])?"is-invalid":"";
}

function add_class_hidden(string $nameField) {
    echo !isset(Session::get("errors")[$nameField])?"hide":"";
}

function add_class_hidden_lien(string $nameField) {
    echo !Autorisation::hasRole($nameField)?"hide":"";
}

function check_state(int $isActif) {
    echo $isActif == 1 ? "Archiver" : "Désarchiver";
}

function dd(mixed $data) {
    dump($data);
    die();
}

function dump(mixed $data) {
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
}