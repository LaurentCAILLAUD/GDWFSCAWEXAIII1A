<?php
// J'appelle la classe dont je vais avoir besoin:
require_once('../../Model/RoleRepositry.php');
// Pour des raisons de sécurité je souhaite vérifier si l'utilisateur qui souhaite afficher cette page est bien connecté. Pour cela je vais avoir besoin d'utiliser le systeme de session donc je commence par le démarrer:
session_start();
// Je vais maintenant vérifier que l'utilisateur souhaitant afficher cette page est bien autorisé à le faire. Si ce n'est pas le cas, je redirige ce dernier vers la page de connexion, sinon le script continue:
if (!isset($_SESSION['userEmail']) || $_SESSION['userRole'] != 'ROLE_ADMIN') {
    header('Location: loginView.php');
} else {
    // Afin de gérer les erreurs de éventuelles de mon script, je décide de mettre ce dernier dans un bloc try...catch:
    try {
        // Je vérifie que l'administrateur est bien cliqué sur l'un des boutons:
        if (isset($_GET['confirm'])) {
            // Si l'administrateur clique sur le bouton "oui":
            if ($_GET['confirm'] == 'yes') {
                // Afin de supprimer mon rôle je vais avoir besoin de me connecter à la base de données. Etant donné que je souhaite que mon application tourne en production ou en local, j'utilise cette condition:
                if (getenv('JAWSDB_URL') !== false) {
                    $dbparts = parse_url(getenv('JAWSDB_URL'));
                    $hostname = $dbparts['host'];
                    $username = $dbparts['user'];
                    $password = $dbparts['pass'];
                    $database = ltrim($dbparts['path'], '/');
                } else {
                    $username = 'root';
                    $password = 'root';
                    $database = 'GDWFSCAWEXAIII1A';
                    $hostname = 'localhost';
                }
                // Je peux créer maintenant mon objet PDO:
                $db = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
                // J'instancie un nouvel objet de ma classe RoleRepository:
                $roleRepository = new RoleRepository($db);
                // Et j'utilise la fonction deleteThisRoleWithThisId() afin de supprimer mon rôle:
                $roleRepository->deleteThisRoleWithThisId($_GET['id']);
                // Si une erreur se déroule dans la suppression du rôle une erreur est levée. Si au contraire cette suppression se passe bien je dirige l'administrateur vers la page qui liste les rôles et où il verra que la suppression s'est bien faite:
                header('Location: roleListView.php');
            } else {
                // Si l'administrateur clique sur "non" alors je le redirige vers la page qui liste les rôles:
                header('Location: roleListView.php');
            }
        }
    } catch (Exception $exception) {
        $roleDeleteViewMessage = $exception->getMessage();
    }
}
