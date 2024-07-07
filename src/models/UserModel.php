<?php

namespace Macbook\Models;

use Macbook\Core\Model;

define("PASSWORD_DEFAULT_USER", "passer@123");

class UserModel extends Model
{
    public function __construct()
    {
        parent::getConnexion();
        $this->table = "utilisateur";
    }

    public function findByLoginAndPassword(string $login, string $password)
    {
        return $this->executeSelect("SELECT * FROM $this->table u, role r, utilisateurInterne i where u.roleId = r.idRole and i.userId = u.idUser and i.login like '$login' and i.password like '$password';", true);
    }

    // Find
    public function findAllFournisseur(): array
    {
        return $this->executeSelect("SELECT * FROM `$this->table` u, fournisseur f WHERE u.idUser=f.userId AND u.isDeleted='0';");
    }

    public function findAllFournisseurWithPag(int $page = 0, int $offset = OFFSET): array
    {
        $page *= $offset;
        $result = $this->executeSelect("SELECT COUNT(*) as nbr FROM `$this->table` u, fournisseur f WHERE u.idUser=f.userId AND u.isDeleted='0';", true);
        $data = $this->executeSelect("SELECT * FROM `$this->table` u, fournisseur f WHERE u.idUser=f.userId AND u.isDeleted='0' Limit $page,$offset;");
        return [
            "totalElements" => $result["nbr"],
            "data" => $data,
            "pages" => ceil($result["nbr"] / $offset)
        ];
    }
    
    public function findAllClient(): array
    {
        return $this->executeSelect("SELECT * FROM `$this->table` u, client c WHERE u.idUser=c.userId AND u.isDeleted='0' AND u.roleId='5';");
    }

    public function findAllClientWithPag(int $page = 0, int $offset = OFFSET): array
    {
        $page *= $offset;
        $result = $this->executeSelect("SELECT COUNT(*) as nbr FROM `$this->table` u, client c WHERE u.idUser=c.userId AND u.isDeleted='0' AND u.roleId='5';", true);
        $data = $this->executeSelect("SELECT * FROM `$this->table` u, client c WHERE u.idUser=c.userId AND u.isDeleted='0' AND u.roleId='5' Limit $page,$offset;");
        return [
            "totalElements" => $result["nbr"],
            "data" => $data,
            "pages" => ceil($result["nbr"] / $offset)
        ];
    }

    public function findAllInterne(int $role): array
    {
        return $this->executeSelect("SELECT * FROM `$this->table` u, utilisateurInterne c WHERE u.idUser=c.userId AND u.isDeleted='0' AND u.roleId='$role';");
    }

    public function findAllInterneWithPag(int $role, int $page = 0, int $offset = OFFSET): array
    {
        $page *= $offset;
        $result = $this->executeSelect("SELECT COUNT(*) as nbr FROM `$this->table` u, utilisateurInterne c WHERE u.idUser=c.userId AND u.isDeleted='0' AND u.roleId='$role';", true);
        $data = $this->executeSelect("SELECT * FROM `$this->table` u, utilisateurInterne c WHERE u.idUser=c.userId AND u.isDeleted='0' AND u.roleId='$role' Limit $page,$offset;");
        return [
            "totalElements" => $result["nbr"],
            "data" => $data,
            "pages" => ceil($result["nbr"] / $offset)
        ];
    }
    // End Find

    // Save
    public function saveFournisseur(array $data, array $files): void
    {
        extract($data);
        $photo = $this->savePhoto($files);
        $lastId = $this->executeUpdate("INSERT INTO `$this->table` (`nom`, `prenom`, `tel`, `adresse`, `photo`, `isActif`, `roleId`) VALUES ('$nom', '$prenom', '$tel', '$adresse', '$photo', '1', '6');");
        $lastId ? $this->executeUpdate("INSERT INTO `fournisseur` (`fix`, `userId`) VALUES ('$fix', '$lastId');") : '';
    }

    public function saveClient(array $data, array $files): void
    {
        extract($data);
        $photo = $this->savePhoto($files);
        $lastId = $this->executeUpdate("INSERT INTO `$this->table` (`nom`, `prenom`, `tel`, `adresse`, `photo`, `isActif`, `roleId`) VALUES ('$nom', '$prenom', '$tel', '$adresse', '$photo', '1', '5');");
        $lastId ? $this->executeUpdate("INSERT INTO `client` (`observations`, `userId`) VALUES ('$observations', '$lastId');") : '';
    }

    public function saveInterne(array $data, array $files, string $email, int $role): void
    {
        extract($data);
        $photo = $this->savePhoto($files);
        $login = strtolower($this->removeAccents($nom)) . '_' . strtolower($this->removeAccents($prenom)) . $email;
        $password = PASSWORD_DEFAULT_USER;
        $lastId = $this->executeUpdate("INSERT INTO `$this->table` (`nom`, `prenom`, `tel`, `adresse`, `photo`, `isActif`, `roleId`) VALUES ('$nom', '$prenom', '$tel', '$adresse', '$photo', '1', '$role');");
        $lastId ? $this->executeUpdate("INSERT INTO `utilisateurInterne` (`login`, `password`, `salaire`, `userId`) VALUES ('$login', '$password', '$salaire', '$lastId');") : '';
    }
    // End Save

    // Update
    public function updateFournisseur(array $data, array $files): void
    {
        extract($data);
        if (!empty($files['photo']['name'])) {
            $photo = $this->savePhoto($files);
        } else {
            $photo = $this->getExistingPhoto($idUser);
        }
        $this->executeUpdate("UPDATE `$this->table` SET `nom` = '$nom', `prenom`='$prenom', `tel`= '$tel', `adresse`='$adresse', `photo`='$photo' WHERE `$this->table`.`idUser` = '$idUser'");
        $this->executeUpdate("UPDATE `fournisseur` SET `fix` = '$fix', `userId`='$idUser' WHERE `fournisseur`.`userId` = '$idUser'");
    }

    public function updateClient(array $data, array $files): void
    {
        extract($data);
        if (!empty($files['photo']['name'])) {
            $photo = $this->savePhoto($files);
        } else {
            $photo = $this->getExistingPhoto($idUser);
        }
        $this->executeUpdate("UPDATE `$this->table` SET `nom` = '$nom', `prenom`='$prenom', `tel`= '$tel', `adresse`='$adresse', `photo`='$photo' WHERE `$this->table`.`idUser` = '$idUser'");
        $this->executeUpdate("UPDATE `client` SET `observations` = '$observations', `userId`='$idUser' WHERE `client`.`userId` = '$idUser'");
    }

    public function updateInterne(array $data, array $files): void
    {
        extract($data);
        if (!empty($files['photo']['name'])) {
            $photo = $this->savePhoto($files);
        } else {
            $photo = $this->getExistingPhoto($idUser);
        }
        $result = $this->getExisting($idUser);
        $login = $result['login'];
        $password = $result['password'];
        $this->executeUpdate("UPDATE `$this->table` SET `nom` = '$nom', `prenom`='$prenom', `tel`= '$tel', `adresse`='$adresse', `photo`='$photo' WHERE `$this->table`.`idUser` = '$idUser'");
        $this->executeUpdate("UPDATE `utilisateurInterne` SET `login` = '$login', `password`='$password', `salaire`='$salaire', `userId`='$idUser' WHERE `utilisateurInterne`.`userId` = '$idUser'");
    }

    public function updatePassword(array $data)
    {
        extract($data);
        $this->executeUpdate("UPDATE `utilisateurInterne` SET `login` = '$login', `password`='$password', `userId`='$idUser' WHERE `utilisateurInterne`.`userId` = '$idUser'");
    }

    public function updateInfo(array $data, array $files)
    {
        extract($data);
        if (!empty($files['photo']['name'])) {
            $photo = $this->savePhoto($files);
        } else {
            $photo = $this->getExistingPhoto($idUser);
        }
        $this->executeUpdate("UPDATE `$this->table` SET `nom` = '$nom', `prenom`='$prenom', `tel`= '$tel', `adresse`='$adresse', `photo`='$photo' WHERE `$this->table`.`idUser` = '$idUser'");
    }
    // End Update

    public function getExistingPhoto(int $idUser): string
    {
        $result = $this->executeSelect("SELECT `photo` FROM `$this->table` WHERE `idUser` = '$idUser'", true);
        if (!empty($result)) {
            return $result['photo'];
        }
        return 'default.png';
    }

    public function getExisting(int $idUser)
    {
        return $this->executeSelect("SELECT * FROM `utilisateurInterne` WHERE `userId` = '$idUser'", true);
    }

    // Delete
    public function delete($value): void
    {
        $this->executeUpdate("UPDATE `$this->table` SET `isDeleted` = '1' WHERE `$this->table`.`idUser` = '$value'");
    }
    // End Delete

    // Archive
    public function archived($data): void
    {
        extract($data);
        $isActif == 1 ? $isActif = 0 : $isActif = 1;
        $this->executeUpdate("UPDATE `$this->table` t SET `isActif` = '$isActif' WHERE t.`idUser` = $idUser");
    }
    // End Archive

    public function findOne($value): array|false
    {
        return $this->executeSelect("SELECT * FROM `$this->table` u WHERE u.idUser=$value AND u.isDeleted='0';", true);
    }
}
