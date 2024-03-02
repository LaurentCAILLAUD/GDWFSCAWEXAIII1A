<?php
// J'appelle la classe dont je vais avoir besoin:
require_once('Mission.php');

class MissionRepository
{
    // Fonction constructeur de notre objet avec PHP 8 (propriété déclarée dans les arguments de notre fonction):
    public function __construct(private PDO $db)
    {
        $this->db = $db;
    }

    // Fonction qui va nous permettre d'ajouter une mission dans la base de données:
    public function addThisMission(Mission $mission): void
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('INSERT INTO mission (id, title, description, code_name, country, mission_start, mission_end, speciality_id, mission_type_id, mission_status_id) VALUES (:id, :title, :description, :codeName, :country, :missionStart, :missionEnd, :specialityId, :missionTypeId, :missionStatusId)');
        // Je récupére les informations dont je vais avoir besoin:
        $id = $mission->getId();
        $title = $mission->getTite();
        $description = $mission->getDescription();
        $codeName = $mission->getCodeName();
        $country = $mission->getCountry();
        // mysql a besoin de recevoir une string pour les deux champs que j'ai paramétré en DATETIME. J'utilise donc la fonction "format" de la classe Datetime afin de parser mon objet Datetime en string:
        $missionStart = $mission->getMissionStart()->format('Y-m-d H:i:s');
        $missionEnd = $mission->getMissionEnd()->format('Y-m-d H:i:s');
        $specialityId = $mission->getSpecialityId();
        $missionTypeId = $mission->getMissionTypeId();
        $missionStatusId = $mission->getMissionStatusId();
        // Je lie mes données:
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':codeName', $codeName);
        $stmt->bindValue(':country', $country);
        $stmt->bindValue(':missionStart', $missionStart);
        $stmt->bindValue(':missionEnd', $missionEnd);
        $stmt->bindValue(':specialityId', $specialityId);
        $stmt->bindValue(':missionTypeId', $missionTypeId);
        $stmt->bindValue(':missionStatusId', $missionStatusId);
        // J'execute ma requête:
        $stmt->execute();
        // Je gére les erreurs éventuelles:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        }
    }
}
