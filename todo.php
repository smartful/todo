<?php
//chargement des éléments nécessaires à la création de l'utilisateur
require_once("includes/initUser.php");

const HEURES_DANS_JOUR      = 24;
const SECONDES_DANS_HEURE   = 3600;

// Chargement de l'utilisateur
$id_user = $_SESSION['id'];
//On crée un cookie de 5 jours
setcookie("idUser",$_SESSION['id'],time()+5*HEURES_DANS_JOUR*SECONDES_DANS_HEURE);
$user = $user_manager->get($id_user);

//création du manager de tâches
$manager_tache = new ManagerTache($bdd);

?>

<!DOCTYPE>
<html>
  <head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
    <title>Todo</title>
  </head>

  <body>

    <div id="app" class="container">
        <!-- En-tête -->
        <header class="jumbotron">
            <h1>Todo List</h1>
            <h2>Les tâches à réaliser </h2>
        </header>

        <h3>Bienvenue <?php echo $user->prenom()." ".strtoupper($user->nom()); ?> </h3>

        <!-- Formulaire d'ajout de tâche -->
        <form action="traitement.php" method="post" class="row well">
            <label for="tache">Tâche à ajouter</label>
            <div class="input-group">
                <input type="text" id="tache" name="tache" class="form-control"/>
                <span class="input-group-btn">
                    <input type="submit" value="ajouter" class="btn btn-default" />
                </span>
            </div>
        </form>

        <!-- Gestion d'affichage des tâches de l'utilisateur courant -->
        <?php
        if(isset($_COOKIE['idUser'])){ ?>
            <!-- Affichage du nombre restant de tâches à réaliser -->
            <p class="row">
                Il y a <span class="important"><?php echo $manager_tache->count($id_user); ?></span> tâches à réaliser !
            </p>

            <!-- Affichage des tâches -->
            <div class="row tasks">
              <?php
                //On récupère la liste des tâches
                $taches = $manager_tache->getList($id_user);
                ?>
                <table>
                <?php
                foreach($taches as $tache){
                    echo "<div class='well'>";
                        echo "-  ".$tache->getTache()." ";
                        echo "<a href='delete.php?id=".$tache->getId()."' class='button'>&#x2717;</a> ";
                    echo "</div>";
                }
                ?>
                </table>
           </div>

           <div class="row logout">
               <a href="?deconnexion">Déconnexion</a>
           </div>

           <footer class="row">
               Crédit : Rémi Matthieu RODRIGUES
           </footer>
        <?php
        }
        else{ ?>
            <p>
                Vous n'êtes plus connecté : <a href="index.php" title="connexion">Veuillez vous reconnecté  </a>
            </p>
        <?php
        }
        ?>


    </div>

  </body>
</html>
