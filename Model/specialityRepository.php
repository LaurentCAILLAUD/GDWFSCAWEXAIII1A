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
        $stmt = $this->db->prepare('INSERT INTO speciality (id, name) VALUES (:id, :name)');
        $stmt->bindValue(':id', $speciality->getId());
        $stmt->bindValue(':name', $speciality->getName());
        $stmt->execute();
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        }
    }
}
