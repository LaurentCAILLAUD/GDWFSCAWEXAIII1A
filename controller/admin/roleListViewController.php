<?php
// J'appelle la classe dont je vais avoir besoin:
require_once('../../Model/RoleRepository.php');
// Pour des raisons de sécurité je souhaite vérifier si l'utilisateur qui souhaite afficher cette page est bien connecté. Pour cela je vais avoir besoin d'utiliser le systeme de session donc je commence par le démarrer:
session_start();
// Je vais maintenant vérifier que l'utilisateur souhaitant afficher cette page est bien autorisé à le faire. Si ce n'est pas le cas, je redirige ce dernier vers la page de connexion, sinon le script continue:
if (!isset($_SESSION['userEmail']) || $_SESSION['userRole'] != 'ROLE_ADMIN') {
    header('Location: loginView.php');
} else {
    // Afin de gérer les erreurs de éventuelles de mon script, je décide de mettre ce dernier dans un bloc try...catch:
    try {
        // Le but de ce contrôleur est de récupérer les rôles enregistrés dans la base de données. Pour cela, il va falloir que je me connecte à la base de données et il me faut donc dasn un premier temps créé mon Data Source Name:
        $dsn = 'mysql:host=localhost;dbname=GDWFSCAWEXAIII1A';
        // Celui-ci créé, je peux maintenant me connecter à la base de données:
        $db = new PDO($dsn, 'root', 'root');
        // Afin de récupérer les données, je vais utiliser la classe AgentRepository et plus particulièrement sa fonction getAllRoles(.)
        $roleRepository = new RoleRepository($db);
        // Cette fonction retourne dans tous les cas un tableau. Celui-ci peut être vide ou pas. Je décide de gérer ces deux états dans la vue de ce contrôleur.
        $allRoles = $roleRepository->getAllRoles();
    } catch (Exception $exception) {
        $roleListViewMessage = $exception->getMessage();
    }
}