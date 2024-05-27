<?php
// J'appelle les classes dont je vais avoir besoin:
require_once('../Model/MissionRepository.php');
// Afin de gérer les eventuelles erreurs de mon script je décide de placer ce dernier dans un bloc try..catch:
try {
    // La premieère chose à faire est de me connecter à la base de donnée. Je souhaite que mon application puisse tourner en production mais aussi en local, j'utilise donc la condition suivante pour faire cela:
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
    // Je peux créer mintenant mon objet PDO:
    $db = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    // Je vais maintenant avoir besoin de récupérer l'ensemble des données de toutes les missions. Pour cela je vais créer un nouvel objet de ma classe MissionRepository:
    $missionRepository = new MissionRepository($db);
    // J'utilse ensuite la fonction getAllMissionsDatas de cette classe pour lister l'ensemble des données de toutes les missions. Si ce tableau esr vide, je décide de gérer cet état dans ma view avec un message (voir missionFrontListView.php):
    $allMissionsDatas = $missionRepository->getAllMissionsDatas();
} catch (Exception $exception) {
    $missionListViewMessage = $exception->getMessage();
}
