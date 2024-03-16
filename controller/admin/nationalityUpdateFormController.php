<?php
// J'appelle la classe dont je vais avoir besoin:
require_once('../../Model/NationalityRepository.php');
// Pour des raisons de sécurité je souhaite vérifier si l'utilisateur qui souhaite afficher cette page est bien connecté. Pour cela je vais avoir besoin d'utiliser le système de session donc je commence par le démarrer:
session_start();
// Je vais maintenant vérifier que l'utilisateur souhaitant afficher cette page est bien autorisé à le faire. Si ce n'est pas le cas, je redirige ce dernier vers la page de connexion, sinon le script continue:
if (!isset($_SESSION['userEmail']) || $_SESSION['userRole'] != 'ROLE_ADMIN') {
    header('Location: loginView.php');
} else {
    // Afin de gérer les erreurs de éventuelles de mon script, je décide de mettre ce dernier dans un bloc try...catch:
    try {
        // Afin d'afficher la nationalité que l'administrateur souhaite modifier dans le champ du formulaire, il faut que j'aille la récupérer grâce à son id (id présent dans l'url de la requête). Pour cela je vais devoir me connecter à la base de données et donc commencer par créer mon DSN:
        $dsn = 'mysql:host=localhost;dbname=GDWFSCAWEXAIII1A';
        // Ceci fait je peux me conecter à la bese de données:
        $db = new PDO($dsn, 'root', 'root');
        // Je suis maintenant connecté à la base de données. Je passe maintenant à la récupération de me donnée. Pour cela je vais instancier ma classe NationalityRepository et plus particulièrement sa fonction getThisNationalityWithThisId() avec en paramètre de ma fonction l'id que je récupére dans l'url de ma requête. Cette fonction retournera la nationalité que nous pourrons utiliser dans la vue du contrôleur:
        $nationalityRepository = new NationalityRepository($db);
        $nationalityRetrieved = $nationalityRepository->getThisNationalityWithThisId($_GET['id']);
        // A la validation du formulaire:
        if (isset($_POST['nationalityUpdateFormSubmit'])) {
            // Etant donné que le champ de saisie à l'affichage de notre page sera pré-rempli par la valeur récupérée, normalement il y a peu de risque qu'à la validation ce dernier soit vide. Cependant l'administrateur peut par erreur supprimer la donnée du champ. Je décide donc dans un premier temps de vérifier que ce champ ne soit pas vide. Si c'est le cas une exception est levée:
            if (!empty($_POST['nationalityWritten'])) {
                // Afin que des utilisateurs malveillants n'introduisent pas du code dans le champ de saisie, je "transforme" la saisie de mon utilisateur en un code "sécurisé":
                $nationalityWritten = htmlspecialchars($_POST['nationalityWritten']);
                // Afin d'être sûr d'avoir toujours notre nationalité écrite avec le même format (Lettre capitale en début et le reste des caractères en minuscules), je décide de formater la saisie de mon utilisateur:
                $nationalityWrittenFormated = ucfirst(strtolower($nationalityWritten));
                // A la création de notre base de données nous avons indiqué que le champ "name" de la table "nationality" était une chaine de caractères de maximum 50 caractères. Il faut donc que je vérifie que la nationalité saisie par l'utilisateur ne fasse pas plus de 50 caractères. Si c'est le cas le script continue, sinon une exception est levée:
                if (strlen($nationalityWrittenFormated) <= 50) {
                    // La saisie de notre utilisateur est maintenant sécurisée et dans le bon format. Je vais pouvoir maintenant enregistrer celle-ci dans la base de données. Pour ce faire je vais dans un premier temps créer un nouvel objet de ma classe Nationality:
                    $nationality = new Nationality($_GET['id'], $nationalityWrittenFormated);
                    // Et enfin grâce à la fonction updateThisNationality() de ma classe NationalityRepository je met à jour la nationalité:
                    $nationalityRepository->updateThisNationality($nationality);
                    // Si une erreur se déroule dans la mise à jour de la nationalité une erreur est levée. Si au contraire cette mise à jour se passe bien je dirige l'administrateur vers la page qui liste les nationalités et où il verra que la modification s'est bien faite:
                    header('Location: nationalityListView.php');
                } else {
                    throw new Exception('La nationalité saisie ne doit pas dépasser 50 caractères.');
                }
            } else {
                throw new Exception('Veuillez remplir le champ.');
            }
        }
    } catch (Exception $exception) {
        $nationalityUpdateFormMessage = $exception->getMessage();
    }
}
