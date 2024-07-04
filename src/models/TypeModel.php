<?php

namespace Macbook\Models;

use Macbook\Core\Model;

class TypeModel extends Model
{
    public function __construct()
    {
        $this->getConnexion();
        $this->table = "type";
    }

    public function findOne($value): array|false
    {
        return $this->executeSelect("SELECT * FROM $this->table WHERE `type`.`idType` = $value", true);
    }

    public function findByNameType(string $name): array|false
    {
        return $this->executeSelect("SELECT * from $this->table where nomType like '$name'", true);
    }

    public function save(array $data): void
    {
        extract($data);
        $this->executeUpdate("INSERT INTO $this->table (`nomType`) VALUES ('$nomType');");
    }

    public function update(array $data): void
    {
        extract($data);
        $this->executeUpdate("UPDATE $this->table t SET `nomType` = '$nomType' WHERE t.idType = $idType");
    }

    public function delete($value): void
    {
        $this->executeUpdate("DELETE FROM $this->table WHERE `type`.`idType` = $value");
    }
}
