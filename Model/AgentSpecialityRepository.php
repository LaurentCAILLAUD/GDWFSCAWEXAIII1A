<?php
// J'appelle la classe dont je vais avoir bessoin:
require_once('AgentSpeciality.php');

class AgentSpecialityRepository
{
    // Fonction constructeur de notre objet avec PHP 8 (propriété déclarée dans les arguments de notre fonction):
    public function __construct(private PDO $db)
    {
        $this->db = $db;
    }

    // Fonction qui va me permettre d'ajouter un contact dans la base de données:
    public function addThisAgentSpeciality(AgentSpeciality $agentSpeciality): void
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('INSERT INTO agent_speciality (agent_id, speciality_id) VALUES (:agentId, :specialityId)');
        // Je récupére les données dont j'ai besoin:
        $agentId = $agentSpeciality->getAgentId();
        $specialityId = $agentSpeciality->getSpecialityId();
        // Je lie mes données:
        $stmt->bindValue(':agentId', $agentId);
        $stmt->bindValue(':specialityId', $specialityId);
        // J'exécute ma requête:
        $stmt->execute();
        // Je gère les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        }
    }
}
