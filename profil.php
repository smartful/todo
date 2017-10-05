<?php

//chargement des éléments nécessaires à la création de l'utilisateur
require_once("includes/initUser.php");

//chargement de l'utilisateur
if(isset($_SESSION['id'])){
	$id_user = $_SESSION['id'];
	$user = $user_manager->get($id_user);
} else{
	$message = "Il y a eu un problème avec votre identification ! <br/>";
}

/* Vérification du formulaire de modification du profil */
if(isset($_POST['passProfil']) AND isset($_POST['passVerifProfil'])){
	if(preg_match("#^[a-zA-Z0-9éèùà@&]{7,15}$#",$_POST['passProfil']) AND $_POST['passProfil'] == $_POST['passVerifProfil']){
		$pass =  htmlspecialchars($_POST['passProfil']);
		$user->setPass($pass);
		$user_manager->update($user);
		$message_modif = "<p>Votre modification de mot de passe est un succès ! </p>";
	} else{
		$message_modif = "<p>Votre mot de passe doit contenir entre 7 et 15 caractères <br/>
					(les caractères spéciaux autorisés : <strong> éèùà@& </strong>) </p>";
	}
}

if(isset($_POST['ageProfil'])){
	if($_POST['ageProfil'] != ""){
		$age = (int) htmlspecialchars($_POST['ageProfil']);
		$user->setAge($age);
		$user_manager->update($user);
		$message_modif = "<p>La modification de votre âge est un succès ! </p>";
	} else{
		$message_modif = "<p>Vous n'avez pas rempli le champ du formulaire. </p>";
	}
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
		<meta name="viewport" content="width=device-width" />
		<link rel="stylesheet" href="style.css"/>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
    <title>Profil</title>
  </head>

  <body>
		<div class="container">
  		<header class="page-header">
  			<h1><a href="main.php">Painstacking</a></h1>
  		</header>

		<?php if(isset($message)) echo "<p>".$message."</p>"; ?>

		<h2>Profil </h2>
		<p>
		<?php echo "Bonjour <strong>".htmlspecialchars($user->prenom())." ".htmlspecialchars($user->nom())."</strong> !"; ?>
		</p>

		<?php
		if(isset($message_modif)){
				echo $message_modif;
		}
		?>

		<table class="table table-bordered table-striped table-condensed">
			<thead>
				<tr>
			      <th>Champ </th>
			      <th>Valeur </th>
			      <th>Action </th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td>Prénom</td>
			    	<td><?php echo htmlspecialchars($user->prenom()); ?></td>
					<td> - </td>
				</tr>

				<tr>
					<td>Nom</td>
			    	<td><?php echo htmlspecialchars($user->nom()); ?> </td>
					<td> - </td>
				</tr>

				<tr>
					<td>Sexe</td>
			    	<td><?php $user->sexe() == "m" ? $res = "homme" : $res = "femme" ; echo $res; ?> </td>
					<td> - </td>
				</tr>

				<tr>
					<td>Email</td>
					<td><?php echo htmlspecialchars($user->email());?> </td>
					<td> - </td>
				</tr>

				<tr>
					<td>Mot de passe </td>
					<td>C'est votre secret </td>
					<td><a href="?modif&amp;champ=pass">modifier</a></td>
				</tr>

				<tr>
					<td>Âge </td>
					<td><?php echo htmlspecialchars($user->age());?> </td>
					<td><a href="?modif&amp;champ=age">modifier</a></td>
				</tr>

				<tr>
					<td>Date d'inscription </td>
					<td><?php echo $user->date_inscription();?> </td>
					<td> - </td>
				</tr>

			</tbody>
		</table>

		<!-- Formulaire des modifications -->
		<?php
		if(isset($_GET['modif']) AND isset($_GET['champ'])){
			?>
				<!-- Interface de modification du profil -->
				<div class="row">
					<form method="post" action="profil.php" class="well">
						<fieldset >
							<legend>Modification</legend>
							<?php
							if($_GET['champ'] == "pass"){
							?>
								<div class="form-group">
									<label for="passProfil">Password </label>
									<input type="password" name="passProfil" id="passProfil" class="form-control"/>
								</div>

								<div class="form-group">
									<label for="passVerifProfil">Password Vérification </label>
									<input type="password" name="passVerifProfil" id="passVerifProfil" class="form-control"/>
								</div>

							<?php
							}
							if($_GET['champ'] == "age"){
							?>
								<div class="form-group">
									<label for="ageProfil">Âge </label>
									<input type="number" name="ageProfil" id="ageProfil" class="form-control"/>
								</div>

							<?php
							}
							?>

							<input type="submit" value="Valider" class="btn btn-primary"/><br/>
							<input type="reset" value="Effacer" class="btn btn-danger"/>
						</fieldset>
					</form>
				</div>
			<?php
			}
			?>

			<h2>Amis </h2>
			<button class="btn btn-primary"><a href="friends.php" style="color: white;">Liste des amis</a></button>

			<p>
				<form class="well" >
			    <div class="form-group" action="searchFriends.php" method="post">
			      <input type="search" class="input-sm form-control" placeholder="amis">
			      <button type="submit" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-search"></span></button>
			    </div>
			  </form>
			</p>

			<footer>
				<a href="?deconnexion">Déconnexion</a>
			</footer>
  </body>
</html>
