<?php
// J'appelle les classes dont je vais avoir besoin:
require_once('../../model/AgentRepository.php');
require_once('../../model/SpecialityRepository.php');
require_once('../../model/AgentSpeciality.php');
require_once('../../model/AgentSpecialityRepository.php');
// Pour des raisons de sécurité je souhaite vérifier si l'utilisateur qui souhaite afficher cette page est bien connecté. Pour cela je vais avoir besoin d'utiliser le système de session donc je commence par le démarrer:
session_start();
// Je vais maintenant vérifier que l'utilisateur souhaitant afficher cette page est bien autorisé à le faire. Si ce n'est pas le cas, je redirige ce dernier vers la page de connexion, sinon le script continue:
if (!isset($_SESSION['userEmail']) || $_SESSION['userRole'] != 'ROLE_ADMIN') {
    header('Location: loginView.php');
} else {
    // Afin de gérer les erreurs éventuelles de mon script, je décide de mettre ce dernier dans un bloc try...catch:
    try {
        // Dans le formulaire affiché par la vue de ce contrôleur, j'ai deux champs qui sont des listes déroulantes. Ces listes déroulantes affichent en matière de choix respectivement les agents et les spécialités. Ces informations sont disponibles dans la base de données. Je vais donc aller chercher ces informations à l'aide des classes qui gérent chacune de ces informations. 
        // Pour cela je vais avoir besoin de me connecter à ma base de données avec PDO et donc dans un premier je dois créer mon DSN:
        $dsn = 'mysql:host=localhost;dbname=GDWFSCAWEXAIII1A';
        //Je me connecte à la base de données:
        $db = new PDO($dsn, 'root', 'root');
        // Maintenant je peux instancier ma classe AgentRepository:
        $agentRepository = new AgentRepository($db);
        // Et enfin je récupère les données à l'aide de la fonction getAllAgents. A savoir que cette fonction retourne assurément un tableau. Celui-ci peut contenir des données ou ne pas en contenir. Je décide de gérer ces deux états dans la vue de ce controller (agentSpecialityFormView.php):
        $allAgentsData = $agentRepository->getAllAgents();
        // Maintenant je peux instancier ma classe SpecialityRepository:
        $specialityRepository = new SpecialityRepository($db);
        // Et enfin je récupère les données à l'aide de la fonction getAllSpecialities. A savoir que cette fonction retourne assurément un tableau. Celui-ci peut contenir des données ou ne pas en contenir. Je décide de gérer ces deux états dans la vue de ce controller (agentSpecialityFormView.php):
        $allSpecialitiesData = $specialityRepository->getAllSpecialities();
        // J'ai maintenant toutes les données pour un affichage correct de mon formulaire. Il faut maintenant que je m'occupe de la soumission du formulaire.
        // A la validation du formulaire:
        if (isset($_POST['agentSpecialityFormSubmit'])) {
            // Première chose que je souhaite vérifier est que tous les champs de mon formulaire soient renseignés. Si ce n'est pas le cas, le script continue, sinon une exeption est lancée:
            if (!empty($_POST['agentIdSelected']) && !empty($_POST['specialityIdSelected'])) {
                // J'ai maintenant toutes les informations nécessaires pour insérer les données dans la base de données. Je vais pour cela utiliser ma classe AgentSpeciality afin d'instancier un nouvel objet:
                $agentSpeciality = new AgentSpeciality($_POST['agentIdSelected'], $_POST['specialityIdSelected']);
                // Afin d'enregistrer la spécialité d'un agent dans la base de données je vais utiliser la classe AgentSpecialityRepository que j'ai créé et plus particulièrement sa fonction addThisAgentSpeciality():
                $agentSpecialityRepository = new AgentSpecialityRepository($db);
                $agentSpecialityRepository->addThisAgentSpeciality($agentSpeciality);
                // Si l'ajout dans la base de données, ne se fait pas, une erreur est levée (voir fonction addThisAgentSpeciality). Au contraire si l'ajout se fait bien, je redirige l'utilisateur sur la page d'accueil de l'espace administration:
                header('Location: homeView.php');
            } else {
                throw new Exception('Veuillez remplir tous les champs du formulaire.');
            }
        }
    } catch (Exception $exception) {
        $agentSpecialityFormMessage = $exception->getMessage();
    }
}
