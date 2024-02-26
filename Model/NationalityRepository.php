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
}
