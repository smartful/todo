<?php

//chargement des éléments nécessaires à la création de l'utilisateur
require_once("includes/initUser.php");

$id_user = $_SESSION['id'];

//création du manager de tâches
$manager_tache = new ManagerTache($bdd);

//On récupère la tâche
if(isset($_POST['tache']) && !empty($_POST['tache'])){
    $tache = new Tache(array(
        'idUser'       => $id_user,
        'tache'        => htmlspecialchars($_POST['tache'])
    ));
    $manager_tache->add($tache);
}

header('Location: todo.php');
exit();
