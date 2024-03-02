<?php
// J'appelle la classe MissionType dont je vais avoir besoin:
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

    // Fonction qui va nous permettre de récupérer tous les types de mission de la base de données:
    public function getAllMissionType(): array
    {
        // Je créé un tableau qui n'a aucune données pour le moment.
        $missionType = [];
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT id, name FROM mission_type');
        // J'exécute ma requête:
        $stmt->execute();
        // Je gére les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            // Si il n'y a pas d'erreur mes données sont retournées et je met à jour mon tableau:
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $missionType[$row['id']] = $row['name'];
            }
            // Je retourne mon tableau. Si des données sont trouvées elles seront dans ce tableau sinon mon tableau sera vide:
            return $missionType;
        }
    }
}
