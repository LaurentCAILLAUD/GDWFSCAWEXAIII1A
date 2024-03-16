<?php
// J'appelle le controller qui gère l'affichage des nationalitées:
require_once('../../controller/admin/nationalityListViewController.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administration - Liste des nationalités</title>
    <link rel="stylesheet" href="../../css/nationalityListViewStyle.css">
</head>

<body>
    <!-- mainWrapper block start -->
    <div id="mainWrapper">
        <!-- navContent block start -->
        <div id="navContent">
            <a href="homeView.php"><img src="../../assets/pictures/home.png" alt="icône accueil application"></a>
        </div>
        <!-- navContent block end -->
        <!-- mainContainer block start -->
        <div id="mainContainer">
            <h2>Liste des nationalités</h2>
            <div id="messageContent">
                <?php if (isset($nationalityListViewMessage)) : ?>
                    <p><?php echo $nationalityListViewMessage; ?></p>
                <?php endif; ?>
            </div>
            <div id="mainContent">
                <?php if (empty($allNationalities)) : ?>
                    <div id="emptyNationalityListContainer">
                        <p>Vous n'avez aucune nationalités d'enregistrées.</p>
                    </div>
                <?php else : ?>
                    <div id="nationalityListContainer">
                        <?php foreach ($allNationalities as $nationalityId => $nationalityName) : ?>
                            <div class="nationalityItemContainer">
                                <p><?php echo $nationalityName; ?></p>
                                <p><a href=<?php echo "nationalityUpdateFormView.php?id=" . $nationalityId ?>>Modifiez</a></p>
                                <p><a href="">Supprimez</a></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <!-- mainContainer block end -->
    </div>
    <!-- mainWrapper block end -->
</body>

</html>