<?php

namespace Macbook\Models;

use Macbook\Core\Model;
use Macbook\Core\Session;
use Macbook\Models\PanierModel;



class VenteModel extends Model
{
    public function __construct()
    {
        $this->getConnexion();
        $this->table = "productionVente";
    }

    public function findAll(): array
    {
        return $this->executeSelect("SELECT * FROM `$this->table` t, `article` a WHERE t.articleId = a.idArticle;");
    }

    public function save(array $data, array $article): void
    {
        extract($data);
        $d = new \DateTime();
        $date = $d->format("Y-m-d");
        $userId = Session::get('userConnect')['idUser'];
        $idProd = $article["idVente"];
        $nouvelleQteStock = $article['qteStock'] - $qteProd;
        $this->executeUpdate("INSERT INTO `$this->table` (`date`, `qteProd`, `observations`, `articleId`, `userId`) VALUES ('$date', '$qteProd', '$observations', '$idArticle', '$userId');");
        $this->executeUpdate("UPDATE articleVente SET qteStock = $nouvelleQteStock WHERE idVente = $idProd;");
    }

    public function findArticleVente($value): array|false
    {
        return $this->executeSelect("SELECT * FROM `articleVente` a WHERE a.`articleId` = $value;", true);
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
