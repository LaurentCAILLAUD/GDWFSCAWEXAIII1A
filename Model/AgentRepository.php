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

    // Fonction qui va me permettre d'ajouter un agent dans la base de données:
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

    // Fonction qui va me permettre de récupérer tous les agents:
    public function getAllAgents(): array
    {
        // Je créé un tableau vide qui recevra ou non des données:
        $agents = [];
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT id, firstname, lastname FROM agent');
        // J'exécute ma requête:
        $stmt->execute();
        // Je gère les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Je met à jour mon tableau:
                $agents[$row['id']] =  $row['firstname'] . ' ' . $row['lastname'];
            }
            // Je retourne mon tableau vide si des données n'ont pas été retournées et dans le cas contraire mon tableau mis à jour:
            return $agents;
        }
    }

    // Fonction qui va nous permettre de récupérer les données d'un agent grâce à son id:
    public function getAllAgentDatasWithThisId(string $id): array
    {
        // Je crée un tableau vide qui contiendra ou pas les données d'une cible:
        $allAgentDatas = [];
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT firstname, lastname, date_of_birth, identity_code, nationality.name AS nationality, mission.title AS missionTitle FROM agent INNER JOIN nationality ON agent.nationality_id = nationality.id INNER JOIN mission ON agent.mission_id = mission.id WHERE agent.id = :id');
        // Je lie mes données:
        $stmt->bindValue(':id', $id);
        // J'exécute ma requête:
        $stmt->execute();
        // Je gère les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $allAgentDatas['firstname'] = $row['firstname'];
                $allAgentDatas['lastname'] = $row['lastname'];
                $allAgentDatas['dateOfBirth'] = $row['date_of_birth'];
                $allAgentDatas['identityCode'] = $row['identity_code'];
                $allAgentDatas['nationality'] = $row['nationality'];
                $allAgentDatas['missionTitle'] = $row['missionTitle'];
            }
            return $allAgentDatas;
        }
    }

    // Fonction qui va nous permettre de mettre à jour les données d'un agent:
    public function updateThisAgent(Agent $agent): void
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('UPDATE agent SET firstname = :firstname, lastname = :lastname, date_of_birth = :dateOfBirth, nationality_id = :nationalityId, mission_id = :missionId WHERE id = :id');
        // Je récupère les données dont j'ai besoin:
        $id = $agent->getId();
        $firstname = $agent->getFirstname();
        $lastname = $agent->getLastname();
        $dateOfBirth = $agent->getDateOfBirth()->format('Y-m-d');
        $nationalityId = $agent->getNationalityCodeId();
        $missionId = $agent->getMissionId();
        // Je lie mes données:
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':firstname', $firstname);
        $stmt->bindValue(':lastname', $lastname);
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
