<?php

//chargement des éléments nécessaires à la création de l'utilisateur
require_once("includes/initUser.php");

/* Vérification inscription
------------------------------------------------------------------------------*/
if(isset($_GET['inscrip'])){
  $data = array(
              'email'       => htmlspecialchars($_POST['email']),
              'pass'        => htmlspecialchars($_POST['pass']),
              'passVerif'   => htmlspecialchars($_POST['passVerif']),
              'prenom'      => htmlspecialchars($_POST['prenom']),
              'nom'         => htmlspecialchars($_POST['nom']),
              'age'         => htmlspecialchars($_POST['age']),
              'sexe'        => htmlspecialchars($_POST['sexe'])
              );

  //Vérification du formulaire d'incription
  $user_verif = new UserRegister($data, $user_manager);
  $_SESSION['id'] = $user_verif->addUser();
  //On récupère le message d'information
  $message = $user_verif->getMessage();
}

/* Vérification connexion
------------------------------------------------------------------------------*/
if(isset($_GET['connex'])){
  $data = array(
              'email'       => htmlspecialchars($_POST['email']),
              'pass'        => htmlspecialchars($_POST['pass'])
            );

  //Vérification du formulaire de connexion
  $user_connex = new UserConnexion($data, $user_manager);
  $_SESSION['id'] = $user_connex->check();
  //On récupère le message d'information
  $message = $user_connex->getMessage();
}

/* Redirection sur la page de profil
------------------------------------------------------------------------------*/
if(isset($_SESSION['id'])){
  header('Location: todo.php');
}

/* Deconnecter l'utilisateur
------------------------------------------------------------------------------*/
if(isset($_GET['deconnexion']))
{
	session_destroy();
	echo "Votre êtes bien déconnecté !";
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width" />
        <link rel="stylesheet" href="css/style.css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
        <title>Connexion</title>
    </head>

    <body>
	    <div class="container">
            <!-- formulaire de connexion dans la barre de navigation-->
            <nav class="navbar navbar-inverse">
                <form method="post" action="index.php?connex" class="navbar-form navbar-right">
                    <fieldset id="connexion_form">
            			<div class="form-group">
            				<label for="email" style="color:white;">Email </label>
            				<input type="text" name="email" id="email" class="form-control"/>
            			</div>

            			<div class="form-group">
            				<label for="pass" style="color:white;">Password </label>
            				<input type="password" name="pass" id="pass" class="form-control"/>
                        </div>

                        <div class="radio">
                          <input type="submit" value="Go" class="btn btn-primary"/>
                          <input type="reset" value="Effacer" class="btn btn-danger"/>
                        </div>
                    </fieldset>
                </form>
            </nav>

      		<header class="page-header">
      			<h1>Todo List</h1>
      		</header>

            <h3>
                <?php if(isset($message)){echo $message;}?>
            </h3>

            <div class="row">
                <section class="col-md-6" style="font-size: 1.8em;">
                    <p>
                        Todo List vous permet de mettre un peu d'ordre dans votre vie !
                    </p>

                    <p style="text-align: center;">
                        <span class="glyphicon glyphicon-check"><span><br/>
                    </p>

                    <p>
                        Aujourd'hui vous avez l'impression d'être un gros loser ! Et vous avez raison !!!
                    </p>

                    <p style="text-align: center;">
                        <span class="glyphicon glyphicon-thumbs-down"><span><br/>
                    </p>

                    <p>
                        Heureusement Todo List est là pour vous aidez ! Pour seulement 5 € par mois.
                    </p>

                    <p style="text-align: center;">
                        <span class="glyphicon glyphicon-euro"><span><br/>
                    </p>
                    
                    <p style="font-weight: bold;">
                        Même mieux, pour le lancement c'est gratuit !
                    </p>
                </section>

                <!-- formulaire d'inscription -->
              	<section class="col-md-6" id="formIncript">
                    <form method="post" action="index.php?inscrip" class="well">
                        <fieldset id="inscription_form">
                			<legend>Inscription</legend>

                			<div class="form-group">
                				<label for="email">Email </label>
                				<input type="text" name="email" id="email" class="form-control"/>
                			</div>

                			<div class="form-group">
                				<label for="pass">Password </label>
                				<input type="password" name="pass" id="pass" class="form-control"/>
                            </div>

                			<div class="form-group">
                				<label for="passVerif">Password Vérification </label>
                				<input type="password" name="passVerif" id="passVerif" class="form-control"/>
                			</div>

                			<div class="form-group">
                				<label for="prenom">Prenom </label>
                				<input type="text" name="prenom" id="prenom" class="form-control"/>
                			</div>

                			<div class="form-group">
                				<label for="nom">Nom </label>
                				<input type="text" name="nom" id="nom" class="form-control"/>
                			</div>

                			<div class="form-group">
                				<label for="age">Age </label>
                				<input type="number" name="age" id="age" class="form-control"/>
                			</div>

                			<h4>Sexe </h4>
                				<div class="radio">
                					<label for="homme" class="radio">
                					<input type="radio" name="sexe" value="m" id="homme"/> Homme
                					</label>
                				</div>

                				<div class="radio">
                					<label for="femme" class="radio">
                					<input type="radio" name="sexe" value="f" id="femme" /> Femme
                					</label>
                				</div>

                				<div class="radio">
                					<input type="submit" value="Go" class="btn btn-primary"/>
                					<input type="reset" value="Effacer" class="btn btn-danger"/>
                				</div>
                        	</fieldset>
                        </form>
                </section>
            </div>



        </div>

        <script>
            formIncript = document.getElementById("formIncript");

        </script>
    </body>
</html>
