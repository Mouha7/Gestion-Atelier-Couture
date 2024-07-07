<?php

namespace Macbook\Models;

use Macbook\Core\Model;



class CategorieModel extends Model
{
    public function __construct()
    {
        $this->getConnexion();
        $this->table = "categorie";
    }

    public function findAll(): array
    {
        return $this->executeSelect("SELECT * FROM `$this->table` c, type t WHERE c.typeId = t.idType;");
    }

    public function findAllWithPag(int $page = 0, int $offset = OFFSET): array
    {
        $page *= $offset;
        $result = $this->executeSelect("SELECT COUNT(*) as nbr FROM `$this->table`;", true);
        $data =  $this->executeSelect("SELECT * FROM `$this->table` c, type t WHERE c.typeId = t.idType Limit $page,$offset;");
        return [
            "totalElements" => $result["nbr"],
            "data" => $data,
            "pages" => ceil($result["nbr"] / $offset)
        ];
    }

    public function save(array $data): void
    {
        extract($data);
        $this->executeUpdate("INSERT INTO `categorie` (`nomCategorie`, `typeId`) VALUES ('$nomCategorie', '$typeId');");
    }

    public function findOne($value): array|false
    {
        return $this->executeSelect("SELECT * FROM `categorie` WHERE `categorie`.`idCategorie` = $value", true);
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
