<?php
// J'appelle le controller qui gère la soumission de mon formulaire:
require_once('../../controller/admin/nationalityUpdateFormController.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administration - Modifiez une nationalité</title>
    <link rel="stylesheet" href="../../css/nationalityFormViewStyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../../js/nationalityScript.js" defer></script>
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
            <p>A l'aide du formulaire ci-dessous modifiez une nationalité dans votre base de données.</p>
            <div id="mainContent">
                <div id="formMessage">
                    <?php if (isset($nationalityUpdateFormMessage)) : ?>
                        <p><?php echo $nationalityUpdateFormMessage; ?></p>
                    <?php endif; ?>
                </div>
                <!-- Si une erreur dans la récupération de la nationalité est arrivée nous aurons l'affichage de celle-ci dans l'endroit prévu. Cette erreur fera alors que notre variable contenant notre nationalité ($nationalityRetrieved) sera vide. Il est alors inutile d'afficher le formulaire de modification. Je décide donc pour cela de vérifier si cette variable est vide ou pas. -->
                <?php if (!empty($nationalityRetrieved)) : ?>
                    <h2>Modifiez une nationalité</h2>
                    <form action="" id="nationalityForm" method="post">
                        <input type="text" name="nationalityWritten" value="<?php echo $nationalityRetrieved; ?>" placeholder="Entrez ici la nationalité que vous souhaitez ajouter.">
                        <input type="submit" value="Modifiez" name="nationalityUpdateFormSubmit">
                    </form>
                <?php endif; ?>
            </div>
        </div>
        <!-- mainContainer block end -->
    </div>
    <!-- mainWrapper block end -->
</body>

</html>