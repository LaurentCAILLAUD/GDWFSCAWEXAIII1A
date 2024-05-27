<?php
// J'appelle la classe dont je vais avoir besoin:
require_once('../../Model/UserRepository.php');
// Pour des raisons de sécurité je souhaite vérifier si l'utilisateur qui souhaite afficher cette page est bien connecté. Pour cela je vais avoir besoin d'utiliser le systeme de session donc je commence par le démarrer:
session_start();
// Je vais maintenant vérifier que l'utilisateur souhaitant afficher cette page est bien autorisé à le faire. Si ce n'est pas le cas, je redirige ce dernier vers la page de connexion, sinon le script continue:
if (!isset($_SESSION['userEmail']) || $_SESSION['userRole'] != 'ROLE_ADMIN') {
    header('Location: loginView.php');
} else {
    // Afin de gérer les erreurs de éventuelles de mon script, je décide de mettre ce dernier dans un bloc try...catch:
    try {
        // Le but de ce contrôleur est de récupérer les utilisateurs enregistrés dans la base de données. Pour cela, il va falloir que je me connecte à la base de données. Etant donné que je souhaite que mon application tourne en production ou en local, j'utilise cette condition:
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
        // Afin de récupérer les données, je vais utiliser la classe UserRepository et plus particulièrement sa fonction getAllUsers(). Un utilisateur possède de multiples "propriétés". Pour afficher la liste des utilisateurs, je décide de n'afficher que le prénom et le nom des ces derniérs:
        $userRepository = new UserRepository($db);
        // Cette fonction retourne dans tous les cas un tableau. Celui-ci peut être vide ou pas. Je décide de gérer ces deux états dans la vue de ce contrôleur.
        $allUsersIdentities = $userRepository->getAllUsers();
    } catch (Exception $exception) {
        $userListViewMessage = $exception->getMessage();
    }
}
