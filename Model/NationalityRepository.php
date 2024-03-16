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

    // Fonction qui va nous permettre de récupérer une nationalité avec son id:
    public function getThisNationalityWithThisId(string $id): string
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT name FROM nationality WHERE id = :id');
        // Je lie mes données:
        $stmt->bindValue(':id', $id);
        // J'exécute ma requête:
        $stmt->execute();
        // Je gère les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // Si ma variable $row est vide, cela signifie que la nationalité n'a pas été retournée, je lance donc une exception. Sinon je retourne la nationalité:
            if (empty($row['name'])) {
                throw new Exception('Aucune nationalité retournée.');
            } else {
                return $row['name'];
            }
        }
    }

    // Fonction qui va nous permettre de mettre à jour une nationalité:
    public function updateThisNationality(Nationality $nationality): void
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('UPDATE nationality SET name = :name WHERE id = :id');
        // Je récupère les données dont je vais avoir besoin:
        $id = $nationality->getId();
        $name = $nationality->getName();
        // Je lie mes données:
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':name', $name);
        // J'excécute ma requête:
        $stmt->execute();
        // Je gère les erreurs éventuelles:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        }
    }
}
