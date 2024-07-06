<?php

namespace Macbook\Models;

use Macbook\Core\Model;
use Macbook\Core\Session;
use Macbook\Models\PanierModel;



class ApproModel extends Model
{
    public function __construct()
    {
        $this->getConnexion();
        $this->table = "approvisionnement";
    }

    public function findAll(): array
    {
        return $this->executeSelect("SELECT * FROM `approvisionnement` a, `utilisateur` u WHERE a.fournisseurId = u.idUser;");
    }

    public function save(PanierModel $data): void
    {
        $d = new \DateTime();
        $date = $d->format("Y-m-d");
        $userId = Session::get('userConnect')['idUser'];
        $lastId = $this->executeUpdate("INSERT INTO `approvisionnement` (`date`, `qteAppro`, `montantAppro`, `observations`, `fournisseurId`, `userId`) VALUES ('$date', '$data->qte', '$data->total', '$data->observations', '$data->fournisseur', '$userId');");
        foreach ($data->articles as $value) {
            $prixAchat = $value['prixAchat'];
            $qteAchat = $value['qteAchat'];
            $qteAppro = $value['qteAppro'];
            $qteStock = $value['qteStock'] + $qteAppro;
            $montantStock = $qteStock * $prixAchat;
            $montant = $value["montantArticle"];
            $idArticle = $value['idArticle'];
            $this->executeUpdate("INSERT INTO `detail` (`qteAppro`, `montant`, `approId`, `articleId`) VALUES ('$qteAppro', '$montant', '$lastId', '$idArticle');");
            $this->executeUpdate("UPDATE `articleConfection` SET `prixAchat` = '$prixAchat', `qteAchat` = '$qteAchat', `qteStock` = '$qteStock', `montantStock` = '$montantStock', `articleId`='$idArticle' WHERE `articleConfection`.`articleId` = '$idArticle';");
        }
    }

    public function findArticleByAppro($value): array|false
    {
        return $this->executeSelect("SELECT * FROM `detail` d, `articleConfection` a WHERE d.`approId` = $value AND d.articleId = a.articleId;");
    }

    public function update(array $data): void
    {
        extract($data);
        $this->executeUpdate("UPDATE `categorie` t SET `nomCategorie` = '$nomCategorie', `typeId` = '$typeId' WHERE t.idCategorie = $idCategorie");
    }

    public function delete($value): void
    {
        $this->executeUpdate("DELETE FROM categorie WHERE `categorie`.`idCategorie` = $value");
    }

    public function archived($data): void
    {
        extract($data);
        $isActif == 1 ? $isActif = 0 : $isActif = 1;
        $this->executeUpdate("UPDATE `categorie` t SET `isActif` = '$isActif' WHERE t.idCategorie = $idCategorie");
    }
}
