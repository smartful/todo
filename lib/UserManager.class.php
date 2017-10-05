<?php
class UserManager
{
	/******************************************************************
	*					ATTRIBUTS
	*******************************************************************/
	protected $bdd;
	/******************************************************************
	*					METHODES
	*******************************************************************/
	public function __construct($bdd)
	{
		$this->bdd = $bdd;
	}

	public function add(User $user)
	{
		$req = $this->bdd->prepare("INSERT INTO USERS(email,pass,prenom,nom,age,sexe,date_inscription)
										VALUES(:email,:pass,:prenom,:nom,:age,:sexe,NOW())") ;
		$req->execute(array(
								'email' => $user->email(),
								'pass' => password_hash($user->pass(), PASSWORD_DEFAULT),
								'prenom' => $user->prenom(),
								'nom' => $user->nom(),
								'age' => $user->age(),
								'sexe' => $user->sexe()
								));
		$req->closeCursor();
	}

	public function supprimer(User $user)
	{
		$req = $this->bdd->prepare("DELETE FROM USERS WHERE id = :id");
		$req->execute(array('id' => $user->id()));
		$req->closeCursor();
	}

	public function exist($id)
	{
		$req = $this->bdd->prepare("SELECT COUNT(*) FROM USERS WHERE id = :id");
		$req->execute(array('id' => (int) $id));
		return (bool) $req->fetchColumn();
	}

	public function count()
	{
		$req = $this->bdd->query("SELECT COUNT(*) FROM USERS");
		return $req->fetchColumn();
	}

	public function get($id)
	{
		$req = $this->bdd->prepare("SELECT id,email,pass,prenom,nom,age,sexe,
											DATE_FORMAT(date_inscription,'le %d/%m/%Y à %Hh%i') AS date_inscription
									FROM USERS WHERE id = :id");
		$req->execute(array('id' => (int) $id));
		$donnees = $req->fetch();
		$req->closeCursor();
		return new User($donnees);
	}

	public function getEmail($email)
	{
		$req = $this->bdd->prepare("SELECT id,email,pass,prenom,nom,age,sexe,
											DATE_FORMAT(date_inscription,'le %d/%m/%Y à %Hh%i') AS date_inscription
									FROM USERS WHERE email = :email");
		$req->execute(array('email' => $email));
		$donnees = $req->fetch();
		//gestion d'un email n'étant pas présent dans la base de données
		if($donnees == FALSE)
		{
			return FALSE;
		}
		$req->closeCursor();
		return new User($donnees);
	}

	public function verifPass(User $user, $pass)
	{
		//Vérifie que le mot de passe entrer par l'utilisateur, correspond bien à l'adresse email
		if(password_verify($pass,$user->pass()))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function update(User $user)
	{
		$req = $this->bdd->prepare("UPDATE USERS SET pass = :pass, prenom = :prenom, nom = :nom, age = :age, sexe = :sexe
										WHERE id = :id");
		$req->execute(array(
								'pass' => password_hash($user->pass(), PASSWORD_DEFAULT),
								'prenom' => $user->prenom(),
								'nom' => $user->nom(),
								'age' => $user->age(),
								'sexe' => $user->sexe(),
								'id' => $user->id()
								));
		$req->closeCursor();
	}

	public function getList()
	{
		$users = array();
		$req = $this->bdd->query("SELECT id,email,pass,prenom,nom,age,sexe,
											DATE_FORMAT(date_inscription,'le %d/%m/%Y à %Hh%i') AS date_inscription
									FROM USERS");
		while($donnees = $req->fetch())
		{
			$users[] = new User($donnees);
		}
		$req->closeCursor();
		return $users;
	}

}
