<?php
// J'appelle la classe MissionStatus dont je vais avoir besoin:
require_once('MissionStatus.php');

class MissionStatusRepository
{
    // Fonction constructeur de notre objet avec PHP 8 (propriété déclarée dans les arguments de notre fonction):
    public function __construct(private PDO $db)
    {
        $this->db = $db;
    }

    // Fonction qui va nous permettre d'ajouter un statut de mission dans la base de données:
    public function addThisMissionStatus(MissionStatus $missionStatus): void
    {
        $stmt = $this->db->prepare('INSERT INTO mission_status (id, name) VALUES (:id, :name)');
        $stmt->bindValue(':id', $missionStatus->getId());
        $stmt->bindValue(':name', $missionStatus->getName());
        $stmt->execute();
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        }
    }
}
