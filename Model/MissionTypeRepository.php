<?php
// J'appelle la classe Speciality dont je vais avoir besoin:
require_once('MissionType.php');

class MissionTypeRepository
{
    // Fonction constructeur de notre objet avec PHP 8 (propriété déclarée dans les arguments de notre fonction):
    public function __construct(private PDO $db)
    {
        $this->db = $db;
    }

    // Fonction qui va nous permettre d'ajouter un type de mission dans la base de données:
    public function addThisMissionType(MissionType $missionType): void
    {
        $stmt = $this->db->prepare('INSERT INTO mission_type (id, name) VALUES (:id, :name)');
        $stmt->bindValue(':id', $missionType->getId());
        $stmt->bindValue(':name', $missionType->getName());
        $stmt->execute();
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        }
    }
}
