<?php
// J'appelle le controller qui gère la soumission de mon formulaire:
require_once('../../controller/admin/nationalityFormController.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administration - Ajoutez une nationalité</title>
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
            <p>A l'aide du formulaire ci-dessous ajoutez une nationalité dans votre base de données.</p>
            <div id="mainContent">
                <div id="formMessage">
                    <?php if (isset($nationalityFormMessage)) : ?>
                        <p><?php echo $nationalityFormMessage; ?></p>
                    <?php endif; ?>
                </div>
                <h2>Ajoutez une nationalité</h2>
                <form action="" id="nationalityForm" method="post">
                    <input type="text" name="nationalityWritten" placeholder="Entrez ici la nationalité que vous souhaitez ajouter.">
                    <input type="submit" value="Ajoutez" id="nationalityFormSubmit" name="nationalityFormSubmit">
                </form>
            </div>
        </div>
        <!-- mainContainer block end -->
    </div>
    <!-- mainWrapper block end -->
</body>

</html>