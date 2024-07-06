<?php

namespace Macbook\Models;

use Macbook\Core\Model;



class ArticleModel extends Model
{
    public function __construct()
    {
        $this->getConnexion();
        $this->table = "article";
    }

    // Find
    public function findAll(): array
    {
        return $this->executeSelect("SELECT * FROM `$this->table` a, categorie c, type t WHERE a.typeId = t.idType and a.categorieId = c.idCategorie;");
    }

    public function findAllConfection(): array
    {
        return $this->executeSelect("SELECT * FROM `$this->table` a, articleConfection c WHERE a.idArticle=c.articleId AND a.isDeleted='0';");
    }

    public function findAllVente(): array
    {
        return $this->executeSelect("SELECT * FROM `$this->table` a, articleVente v WHERE a.idArticle=v.articleId AND a.isDeleted='0';");
    }

    public function findById(int $value): array|false
    {
        return $this->executeSelect("SELECT * FROM `article` a, articleConfection c WHERE a.idArticle=$value AND c.articleId=$value;", true);
    }
    // End Find

    // Save
    public function saveConfection(array $data, array $files): void
    {
        extract($data);
        $photo = $this->savePhoto($files);
        $montantStock = $qteAchat * $prixAchat;
        $lastId = $this->executeUpdate("INSERT INTO `$this->table` (`libelle`, `photo`, `typeId`) VALUES ('$libelle', '$photo', '1');");
        $lastId ? $this->executeUpdate("INSERT INTO `articleConfection` (`prixAchat`, `qteAchat`, `qteStock`, `montantStock`, `articleId`) VALUES ('$prixAchat', '$qteAchat', '$qteAchat', '$montantStock', '$lastId');") : '';
    }

    public function saveVente(array $data, array $files): void
    {
        extract($data);
        $photo = $this->savePhoto($files);
        $montantVente = $qteStock * $prixVente;
        $lastId = $this->executeUpdate("INSERT INTO `$this->table` (`libelle`, `photo`, `typeId`) VALUES ('$libelle', '$photo', '2');");
        $lastId ? $this->executeUpdate("INSERT INTO `articleVente` (`prixVente`, `qteStock`, `montantVente`, `articleId`) VALUES ('$prixVente', '$qteStock', '$montantVente', '$lastId');") : '';
    }
    // End Save

    // Update
    public function updateConfection(array $data, array $files): void
    {
        extract($data);
        if (!empty($files['photo']['name'])) {
            $photo = $this->savePhoto($files);
        } else {
            $photo = $this->getExistingPhoto($idArticle);
        }
        $montantStock = $qteAchat * $prixAchat;
        $this->executeUpdate("UPDATE `$this->table` SET `libelle` = '$libelle', `photo`='$photo' WHERE `$this->table`.`idArticle` = '$idArticle';");
        $this->executeUpdate("UPDATE `articleConfection` SET `prixAchat` = '$prixAchat', `qteAchat` = '$qteAchat', `qteStock` = '$qteAchat', `montantStock` = '$montantStock', `articleId`='$idArticle' WHERE `articleConfection`.`articleId` = '$idArticle';");
    }

    public function updateVente(array $data, array $files): void
    {
        extract($data);
        if (!empty($files['photo']['name'])) {
            $photo = $this->savePhoto($files);
        } else {
            $photo = $this->getExistingPhoto($idArticle);
        }
        $montantVente = $qteStock * $prixVente;
        $this->executeUpdate("UPDATE `$this->table` SET `libelle` = '$libelle', `photo`='$photo' WHERE `$this->table`.`idArticle` = '$idArticle';");
        $this->executeUpdate("UPDATE `articleVente` SET `prixVente` = '$prixVente', `qteStock` = '$qteStock', `montantVente` = '$montantVente', `articleId`='$idArticle' WHERE `articleVente`.`articleId` = '$idArticle';");
    }
    // End Update

    public function save(array $data): void
    {
        extract($data);
        $this->executeUpdate("INSERT INTO `article` (`libelle`, `prixAppro`, `qteStock`, `typeId`, `categorieId`) VALUES ('$libelle', '$prixAppro', '$qteStock', '$typeId', '$categorieId')");
    }

    public function findOne($value): array|false
    {
        return $this->executeSelect("SELECT * FROM `article` WHERE `article`.`idArticle` = $value", true);
    }

    public function update(array $data): void
    {
        extract($data);
        $this->executeUpdate("UPDATE `article` t SET `libelle` = '$libelle', `prixAppro`= $prixAppro, `qteStock`= $qteStock, `typeId`= $typeId, `categorieId`= $categorieId WHERE t.idArticle = $idArticle");
    }

    // Delete
    public function delete($value): void
    {
        $this->executeUpdate("UPDATE `$this->table` SET `isDeleted` = '1' WHERE `$this->table`.`idArticle` = '$value'");
    }
    // End Delete

    // Archive
    public function archived($data): void
    {
        extract($data);
        $isActif == 1 ? $isActif = 0 : $isActif = 1;
        $this->executeUpdate("UPDATE `$this->table` t SET `isActif` = '$isActif' WHERE t.`idArticle` = $idArticle");
    }
    // End Archive

    public function getExistingPhoto(int $value): string
    {
        $result = $this->executeSelect("SELECT `photo` FROM `$this->table` WHERE `idArticle` = '$value'", true);
        if (!empty($result)) {
            return $result['photo'];
        }
        return 'default.png';
    }
}
