<?php

//chargement des éléments nécessaires à la création de l'utilisateur
require_once("includes/initUser.php");

//création du manager de tâches
$manager_tache = new ManagerTache($bdd);

//On récupère la tâche
if(isset($_GET['id'])){
    $id = (int) $_GET['id'];
    //On s'assure que l'id est bien présent en BDD
    if($manager_tache->exist($id)){
        $tache = $manager_tache->get($id);
        $manager_tache->delete($tache);
    }
}

header('Location: todo.php');
exit();
