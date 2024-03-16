<?php
// J'appelle le controller qui gère la soumission de mon formulaire:
require_once('../../controller/admin/missionStatusUpdateFormController.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administration - Modifiez un statut de mission</title>
    <link rel="stylesheet" href="../../css/missionStatusFormViewStyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../../js/missionStatusScript.js" defer></script>
</head>

<body>
    <!-- mainWrapper block start -->
    <div id="mainWrapper">
        <!-- navContent block start -->
        <div id="navContent">
            <a href="homeView.php"><img src="../../assets/pictures//home.png" alt="icône accueil application"></a>
        </div>
        <!-- navContent block end -->
        <!-- mainContainer block start -->
        <div id="mainContainer">
            <p>A l'aide du formulaire ci-dessous modifiez un statut de mission dans votre base de données.</p>
            <div id="mainContent">
                <div id="formMessage">
                    <?php if (isset($missionStatusUpdateFormMessage)) : ?>
                        <p><?php echo $missionStatusUpdateFormMessage; ?></p>
                    <?php endif; ?>
                </div>
                <!-- Si une erreur dans la récupération du statut de la mission est arrivée nous aurons l'affichage de celle-ci dans l'endroit prévu. Cette erreur fera alors que notre variable contenant notre statut de mission ($missionStatusRetrieved) sera vide. Il est alors inutile d'afficher le formulaire de modification. Je décide donc pour cela de vérifier si cette variable est vide ou pas. -->
                <?php if (!empty($missionStatusRetrieved)) : ?>
                    <h2>Modifiez un statut de mission</h2>
                    <form action="" id="missionStatusForm" method="post">
                        <input type="text" name="missionStatusWritten" value="<?php echo $missionStatusRetrieved; ?>" placeholder="Entrez ici le statut de mission que vous souhaitez ajouter.">
                        <input type="submit" value="Ajoutez" name="missionStatusUpdateFormSubmit">
                    </form>
                <?php endif; ?>
            </div>
        </div>
        <!-- mainContainer block end -->
    </div>
    <!-- mainWrapper block end -->
</body>

</html>