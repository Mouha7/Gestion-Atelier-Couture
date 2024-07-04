<?php

namespace Macbook\Core;

define("ERREUR", "Erreur de connexion à la base de données : ");

class Model
{
    protected string $dsn = 'mysql:host=localhost:8889;dbname=gestion_atelier_couture';
    protected string $username = 'root';
    protected string $password = 'root';
    protected \PDO|NULL $pdo = null;
    protected string $table;

    public function getConnexion(): void
    {
        try {
            if ($this->pdo == null) {
                $this->pdo = new \PDO($this->dsn, $this->username, $this->password);
            }
        } catch (\PDOException $e) {
            die(ERREUR . $e->getMessage());
        }
    }

    public function closeConnexion(): void
    {
        if ($this->pdo == null) {
            $this->pdo = null;
        }
    }

    public function executeSelect(string $sql, bool $fetch = false): array|false
    {
        try {
            $stmt = $this->pdo->query($sql);
            return $fetch ? $stmt->fetch(\PDO::FETCH_ASSOC) : $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            die(ERREUR . $e->getMessage());
        }
    }

    public function executeUpdate(string $sql): bool|string
    {
        try {
            $this->pdo->exec($sql);
            return $this->pdo->lastInsertId();
        } catch (\PDOException $e) {
            die(ERREUR . $e->getMessage());
        }
    }

    public function findAll(): array|false
    {
        return $this->executeSelect("SELECT * FROM `$this->table`");
    }

    public function findByName(string $key, mixed $value): array|false
    {
        return $this->executeSelect("SELECT * from $this->table where $key like '$value'", true);
    }

    public function executeInsert($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $this->pdo->lastInsertId();
    }

    public function savePhoto(array $files):string {
        $photo = 'default.png';
        if (isset($files['photo']) && $files['photo']['error'] == 0) {
            $dossierTmp = $files['photo']['tmp_name'];
            $dossierSite = 'images/' . $files['photo']['name'];
            $photo  = $files['photo']['name'];
            move_uploaded_file($dossierTmp, $dossierSite);
        }
        return $photo;
    }

    public function removeAccents($string) {
        $string = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $string);
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
    }
}
