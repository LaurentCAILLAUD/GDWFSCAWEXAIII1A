<?php

class RoleRepository
{
    public function __construct(private PDO $db)
    {
        $this->db = $db;
    }

    public function getUserRoleWithThisRoleId(string $roleId): string
    {
        $stmt = $this->db->prepare('SELECT name FROM role WHERE id = :roleId');
        $stmt->bindValue(':roleId', $roleId);
        $stmt->execute();
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['name'];
        }
    }
}
