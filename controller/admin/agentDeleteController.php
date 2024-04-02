<?php
// J'appelle la classe dont je vais avoir besoin:
require_once('../../Model/AgentRepository.php');
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
                // Afin de supprimer mon agent je vais avoir besoin de me connecter à la base de données:
                $dsn = 'mysql:host=localhost;dbname=GDWFSCAWEXAIII1A';
                //Je me connecte à la base de données:
                $db = new PDO($dsn, 'root', 'root');
                // J'instancie un nouvel objet de ma classe AgentRepository:
                $agentRepository = new AgentRepository($db);
                // Et j'utilise la fonction deleteThisAgentWithThisId() afin de supprimer mon agent:
                $agentRepository->deleteThisAgentWithThisId($_GET['id']);
                // Si une erreur se déroule dans la suppression de l'agent une erreur est levée. Si au contraire cette suppression se passe bien je dirige l'administrateur vers la page qui liste les agents et où il verra que la suppression s'est bien faite:
                header('Location: agentListView.php');
            } else {
                // Si l'administrateur clique sur "non" alors je le redirige vers la page qui liste les agents:
                header('Location: agentListView.php');
            }
        }
    } catch (Exception $exception) {
        $agentDeleteViewMessage = $exception->getMessage();
    }
}
