<?php

namespace Macbook\Models;

use Macbook\Core\Model;
use Macbook\Core\Session;



class VenteModel extends Model
{
    public function __construct()
    {
        $this->getConnexion();
        $this->table = "vente";
    }

    public function findAll(): array
    {
        return $this->executeSelect("SELECT * FROM `$this->table` t, utilisateur u WHERE t.clientId = u.idUser;");
    }

    public function findAllWithPag(int $page = 0, int $offset = OFFSET): array
    {
        $page *= $offset;
        $result = $this->executeSelect("SELECT COUNT(*) as nbr FROM `$this->table` t, utilisateur u WHERE t.clientId = u.idUser;", true);
        $data = $this->executeSelect("SELECT * FROM `$this->table` t, utilisateur u WHERE t.clientId = u.idUser Limit $page,$offset;");
        return [
            "totalElements" => $result["nbr"],
            "data" => $data,
            "pages" => ceil($result["nbr"] / $offset)
        ];
    }

    public function save(PanierVenteModel $data): void
    {
        $d = new \DateTime();
        $date = $d->format("Y-m-d");
        $userId = Session::get('userConnect')['idUser'];
        $lastId = $this->executeUpdate("INSERT INTO `$this->table` (`dateVente`, `qteVente`, `montantVente`, `observations`, `clientId`, `userId`) VALUES ('$date', '$data->qte', '$data->total', '$data->observations', '$data->client', '$userId');");
        foreach ($data->data as $value) {
            $montantVente = $value['montantVente'];
            $idProd = $value['idProd'];
            $qteAppro = $value['qteAppro'];
            $qteProd = $value['qteProd'] - $qteAppro;
            $this->executeUpdate("INSERT INTO `detailVente` (`qteVente`, `montantVente`, `prodId`, `venteId`) VALUES ('$qteProd', '$montantVente', '$idProd', '$lastId');");
            $this->executeUpdate("UPDATE `productionVente` SET `qteProd` = '$qteProd' WHERE `productionVente`.`idProd` = '$idProd';");
        }
    }
}
