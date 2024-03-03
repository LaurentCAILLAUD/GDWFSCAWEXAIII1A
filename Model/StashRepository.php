<?php
// J'appelle la classe dont je vais avoir besoin:
require_once('Stash.php');

class StashRepository
{
    // Fonction constructeur de notre objet avec PHP 8 (propriété déclarée dans les arguments de notre fonction):
    public function __construct(private PDO $db)
    {
        $this->db = $db;
    }

    // Fonction qui va me permettre d'ajouter une planque dans ma base de données:
    public function addThisStash(Stash $stash): void
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('INSERT INTO stash (code, address, country, type, mission_id) VALUES (:code, :address, :country, :type, :missionId)');
        // Je récupére les données dont j'ai besoin:
        $code = $stash->getCode();
        $address = $stash->getAddress();
        $country = $stash->getCountry();
        $type = $stash->getType();
        $missionId = $stash->getMissionId();
        // Je peux maintenant lier mes données:
        $stmt->bindValue(':code', $code);
        $stmt->bindValue(':address', $address);
        $stmt->bindValue(':country', $country);
        $stmt->bindValue(':type', $type);
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
