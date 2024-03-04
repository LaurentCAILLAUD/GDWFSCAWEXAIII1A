<?php
// J'appelle la classe dont je vais avoir besoin:
require_once('User.php');

class UserRepository
{

    public function __construct(private PDO $db)
    {
        $this->db = $db;
    }

    // Fonction qui va nous permettre de vérifier si l'email d'un utilisateur est connu dans la base de donnée:
    public function countUserWithThisEmail(string $email): bool
    {
        $stmt = $this->db->prepare('SELECT count(id) FROM user WHERE email = :email');
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row['count(id)'] == 0) {
                return false;
            } else {
                return true;
            }
        }
    }

    // Fonction qui va me permettre de récupérer le mot de passe d'un utilisateur avec son email:
    public function getPasswordWithThisEmail(string $email): string
    {
        $stmt = $this->db->prepare('SELECT password FROM user WHERE email = :email');
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['password'];
        }
    }

    // Fonction qui va me permettre de récupérer l'id d'un utilisateur avec son email:
    public function getUserRoleIdWithThisEmail(string $email): string
    {
        $stmt = $this->db->prepare('SELECT role_id FROM user WHERE email = :email');
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['role_id'];
        }
    }

    // Fonction qui va me permettre d'ajouter un utilisateur dans la base de données:
    public function addThisUser(User $user): void
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('INSERT INTO user (id, firstname, lastname, email, password, created_at, role_id) VALUES (:id, :firstname, :lastname, :email, :password, :createdAt, :roleId)');
        // Je récupére les données dont je vais avoir besoin:
        $id = $user->getId();
        $firstname = $user->getFirstname();
        $lastname = $user->getLastname();
        $email = $user->getEmail();
        $password = $user->getPassword();
        $createdAt = $user->getCreatedAt()->format('Y-m-d');
        $roleId = $user->getRoleId();
        // Je lie mes données:
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':firstname', $firstname);
        $stmt->bindValue(':lastname', $lastname);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', $password);
        $stmt->bindValue(':createdAt', $createdAt);
        $stmt->bindValue(':roleId', $roleId);
        // J'exécute ma requête:
        $stmt->execute();
        // Je gère les éventuelles erreurs:
        $errorInRequest = $stmt->errorCode();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        }
    }
}
