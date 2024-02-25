<?php

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
}
