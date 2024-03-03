<?php
// J'appelle la classe Nationality dont je vais avoir besoin:
require_once('Nationality.php');

class NationalityRepository
{
    // Fonction constructeur de notre objet avec PHP 8 (propriété déclarée dans les arguments de notre fonction):
    public function __construct(private PDO $db)
    {
        $this->db = $db;
    }

    // Fonction qui va nous permettre d'ajouter une nationalité dans la base de données:
    public function addThisNationality(Nationality $nationality): void
    {
        $stmt = $this->db->prepare('INSERT INTO nationality (id, name) VALUES (:id, :name)');
        $stmt->bindValue(':id', $nationality->getId());
        $stmt->bindValue(':name', $nationality->getName());
        $stmt->execute();
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        }
    }

    // Fonction qui va me permettre de récupérer toutes les nationalités:
    public function getAllNationalities(): array
    {
        // Je créé un tableau vide qui contiendra ou pas des nationalités:
        $nationalities = [];
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT id, name FROM nationality');
        // J'exécute ma requête:
        $stmt->execute();
        // Je gère les erreurs éventuelles:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            // Si il n'y a pas d'erreur le met à jour mon tableau:
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $nationalities[$row['id']] = $row['name'];
            }
            // Je retourne mon tableau vide si il n'y a pas de nationalités ou avec des données si des nationalités ont été retournées:
            return $nationalities;
        }
    }
}
