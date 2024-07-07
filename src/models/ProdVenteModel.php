<?php

namespace Macbook\Models;

use Macbook\Core\Model;
use Macbook\Core\Session;



class ProdVenteModel extends Model
{
    public function __construct()
    {
        $this->getConnexion();
        $this->table = "productionVente";
    }

    public function findAll(): array
    {
        return $this->executeSelect("SELECT * FROM `$this->table` t, `article` a WHERE t.articleId = a.idArticle AND t.qteProd!=0;");
    }

    public function findAllWithPag(int $page = 0, int $offset = OFFSET): array
    {
        $page *= $offset;
        $result = $this->executeSelect("SELECT COUNT(*) as nbr FROM `$this->table` t, `article` a WHERE t.articleId = a.idArticle AND t.qteProd!=0;", true);
        $data = $this->executeSelect("SELECT * FROM `$this->table` t, `article` a WHERE t.articleId = a.idArticle AND t.qteProd!=0 Limit $page,$offset;");
        return [
            "totalElements" => $result["nbr"],
            "data" => $data,
            "pages" => ceil($result["nbr"] / $offset)
        ];
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

    public function findOne(int $value)
    {
        return $this->executeSelect("SELECT * FROM `productionVente` p, article a WHERE p.articleId=a.idArticle AND p.idProd=$value;", true);
    }

    public function findProdById(int $value)
    {
        return $this->executeSelect("SELECT * FROM `productionVente` p, article a, articleVente v WHERE a.idArticle=$value AND v.articleId=$value;", true);
    }
}
