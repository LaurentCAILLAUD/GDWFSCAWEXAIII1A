<?php
// J'appelle la classe dont je vais avoir bessoin:
require_once('Contact.php');

class ContactRepository
{
    // Fonction constructeur de notre objet avec PHP 8 (propriété déclarée dans les arguments de notre fonction):
    public function __construct(private PDO $db)
    {
        $this->db = $db;
    }

    // Fonction qui va me permettre d'ajouter un contact dans la base de données:
    public function addThisContact(Contact $contact): void
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('INSERT INTO contact (id, firstname, lastname, date_of_birth, identity_code, nationality_id, mission_id) VALUES (:id, :firstname, :lastname, :dateOfBirth, :identityCode, :nationalityId, :missionId)');
        // Je récupére les données dont j'ai besoin:
        $id = $contact->getId();
        $firstname = $contact->getFirstname();
        $lastname = $contact->getLastname();
        // mysql a besoin de recevoir une string pour le champ que j'ai paramétré en DATE. J'utilise donc la fonction "format" de la classe Datetime afin de parser mon objet Datetime en string:
        $dateOfBirth = $contact->getDateOfBirth()->format('Y-m-d');
        $identityCode = $contact->getIdentityCode();
        $nationalityId = $contact->getNationalityCodeId();
        $missionId = $contact->getMissionId();
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

    // Fonction qui va nous permettre de récupérer l'identité (nom et prénom) des tous les contacts:
    public function getAllContactIdentities(): array
    {
        // Je créé un tableau vide qui contiendra ou pas des contacts:
        $allContactIdentities = [];
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT id, firstname, lastname FROM contact');
        // J'exécute ma requête:
        $stmt->execute();
        // Je gère les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Je met à jour les données de mon tableau:
                $allContactIdentities[$row['id']] = $row['firstname'] . ' ' . $row['lastname'];
            }
            // Je retourne le tableau qu'il soit vide ou non:
            return $allContactIdentities;
        }
    }

    // Fonction qui va nous permettre de récupérer les données d'un contact grâce à son id:
    public function getAllContactDatasWithThisId(string $id): array
    {
        // Je crée un tableau vide qui contiendra ou pas les données d'un contact:
        $allContactDatas = [];
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT firstname, lastname, date_of_birth, identity_code, nationality.name AS nationality, mission.title AS missionTitle FROM contact INNER JOIN nationality ON contact.nationality_id = nationality.id INNER JOIN mission ON contact.mission_id = mission.id WHERE contact.id = :id');
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
                $allContactDatas['firstname'] = $row['firstname'];
                $allContactDatas['lastname'] = $row['lastname'];
                $allContactDatas['dateOfBirth'] = $row['date_of_birth'];
                $allContactDatas['identityCode'] = $row['identity_code'];
                $allContactDatas['nationality'] = $row['nationality'];
                $allContactDatas['missionTitle'] = $row['missionTitle'];
            }
            return $allContactDatas;
        }
    }

    // Fonction qui va nous permettre de mettre à jour les données d'un contact:
    public function updateThisContact(Contact $contact): void
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('UPDATE contact SET firstname = :firstname, lastname = :lastname, date_of_birth = :dateOfBirth, nationality_id = :nationalityId, mission_id = :missionId WHERE id = :id');
        // Je récupère les données dont j'ai besoin:
        $id = $contact->getId();
        $firstname = $contact->getFirstname();
        $lastname = $contact->getLastname();
        $dateOfBirth = $contact->getDateOfBirth()->format('Y-m-d');
        $nationalityId = $contact->getNationalityCodeId();
        $missionId = $contact->getMissionId();
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
