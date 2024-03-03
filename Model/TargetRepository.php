<?php
// J'appelle la classe dont je vais avoir bessoin:
require_once('Target.php');

class TargetRepository
{
    // Fonction constructeur de notre objet avec PHP 8 (propriété déclarée dans les arguments de notre fonction):
    public function __construct(private PDO $db)
    {
        $this->db = $db;
    }

    // Fonction qui va me permettre d'ajouter un contact dans la base de données:
    public function addThisTarget(Target $target): void
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('INSERT INTO target (id, firstname, lastname, date_of_birth, identity_code, nationality_id, mission_id) VALUES (:id, :firstname, :lastname, :dateOfBirth, :identityCode, :nationalityId, :missionId)');
        // Je récupére les données dont j'ai besoin:
        $id = $target->getId();
        $firstname = $target->getFirstname();
        $lastname = $target->getLastname();
        // mysql a besoin de recevoir une string pour le champ que j'ai paramétré en DATE. J'utilise donc la fonction "format" de la classe Datetime afin de parser mon objet Datetime en string:
        $dateOfBirth = $target->getDateOfBirth()->format('Y-m-d');
        $identityCode = $target->getIdentityCode();
        $nationalityId = $target->getNationalityCodeId();
        $missionId = $target->getMissionId();
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
