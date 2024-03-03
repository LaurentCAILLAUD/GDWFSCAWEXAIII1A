<?php
// J'appelle la classe dont je vais avoir bessoin:
require_once('Agent.php');

class AgentRepository
{
    // Fonction constructeur de notre objet avec PHP 8 (propriété déclarée dans les arguments de notre fonction):
    public function __construct(private PDO $db)
    {
        $this->db = $db;
    }

    // Fonction qui va me permettre d'ajouter un contact dans la base de données:
    public function addThisAgent(Agent $agent): void
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('INSERT INTO agent (id, firstname, lastname, date_of_birth, identity_code, nationality_id, mission_id) VALUES (:id, :firstname, :lastname, :dateOfBirth, :identityCode, :nationalityId, :missionId)');
        // Je récupére les données dont j'ai besoin:
        $id = $agent->getId();
        $firstname = $agent->getFirstname();
        $lastname = $agent->getLastname();
        // mysql a besoin de recevoir une string pour le champ que j'ai paramétré en DATE. J'utilise donc la fonction "format" de la classe Datetime afin de parser mon objet Datetime en string:
        $dateOfBirth = $agent->getDateOfBirth()->format('Y-m-d');
        $identityCode = $agent->getIdentityCode();
        $nationalityId = $agent->getNationalityCodeId();
        $missionId = $agent->getMissionId();
        // Je lie mes données:
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':firstname', $firstname);
        $stmt->bindValue(':lastname', $lastname);
        $stmt->bindValue(':identityCode', $identityCode);
        $stmt->bindValue(':dateOfBirth', $dateOfBirth);
        $stmt->bindValue(':nationalityId', $nationalityId);
        $stmt->bindValue(':missionId', $missionId);
        // J'exécute ma requête:
        $stmt->execute();
        // Je gère les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        }
    }
}
