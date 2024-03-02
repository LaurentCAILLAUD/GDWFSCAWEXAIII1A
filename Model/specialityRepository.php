<?php
// J'appelle la classe Speciality dont je vais avoir besoin:
require_once('Speciality.php');

class SpecialityRepository
{
    // Fonction constructeur de notre objet avec PHP 8 (propriété déclarée dans les arguments de notre fonction):
    public function __construct(private PDO $db)
    {
        $this->db = $db;
    }

    // Fonction qui va nous permettre d'ajouter une spécialité dans la base de données:
    public function addThisSpeciality(Speciality $speciality): void
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('INSERT INTO speciality (id, name) VALUES (:id, :name)');
        // Je lie mes données:
        $stmt->bindValue(':id', $speciality->getId());
        $stmt->bindValue(':name', $speciality->getName());
        // J'exécute ma requête:
        $stmt->execute();
        // Je gère les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        }
    }

    // Fonction qui va nous permettre de récupérer toutes les spécialités de la base de données:
    public function getAllSpecialities(): array
    {
        // Je créé une variable $specialities qui est un tableau vide:
        $specialities = [];
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT id, name FROM speciality');
        // J'exécute ma requête:
        $stmt->execute();
        // Je gère les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            // Si pas d'erreur mes données sont retournées sous forme de tableau associatif:
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Si des données sont retournées alors mon tableau $specialities est mis à jour:
                $specialities[$row['id']] = $row['name'];
            }
            // Je retourne mon tableau. Si des données ont été retournées elles seront dans mon tableau sinon la fonction retrourne un tableau vide:
            return $specialities;
        }
    }
}
