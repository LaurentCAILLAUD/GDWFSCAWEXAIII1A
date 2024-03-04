<?php
// J'appelle la classe Role dont je vais avoir besoin:
require_once('Role.php');

class RoleRepository
{
    // Fonction constructeur de notre objet avec PHP 8 (propriété déclarée dans les arguments de notre fonction):
    public function __construct(private PDO $db)
    {
        $this->db = $db;
    }

    // Fonction qui va nous permettre de récupérer le rôle d'un utilisateur à partir de son id:
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

    // Fonction qui va nous permettre d'ajouter un rôle dans la base de données:
    public function addThisRole(Role $role): void
    {
        $stmt = $this->db->prepare('INSERT INTO role (id, name) VALUES (:id, :name)');
        $stmt->bindValue(':id', $role->getId());
        $stmt->bindValue(':name', $role->getName());
        $stmt->execute();
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        }
    }

    // FOnction qui va me permettre de récupérer tous les rôles de la base de données:
    public function getAllRoles(): array
    {
        // Je créé un tableau vide qui contiendra en fonction du résultat de ma requête des données ou pas:
        $roles = [];
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT id, name FROM role');
        // J'exécute ma requête:
        $stmt->execute();
        // Je gère les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Si des données sont retournées par ma requête, je mets à jour le tableau:
                $roles[$row['id']] = $row['name'];
            }
            // Je retourne mon tableau avec des données dedans ou vide si pas de données retournées par ma requête:
            return $roles;
        }
    }
}
