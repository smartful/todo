<?php
class UserRegister
{
	/******************************************************************
	*					ATTRIBUTS
	*******************************************************************/
	protected $fields = array();
	protected $message = " - ";
	protected $userManager;

	/******************************************************************
	*					METHODES
	*******************************************************************/

	public function __construct($fields, UserManager $userManager)
	{
		$this->fields = $fields;
		$this->userManager = $userManager;
	}

	//GETTERS
	public function getFields(){return $this->fields;}
	public function getMessage(){return $this->message;}

	//SETTERS
	public function setFields($data)
	{
		foreach ($data as $key => $value) {
			$this->fields[$key] = $value;
		}
	}

	public function setMessage($message)
	{
		$this->message = $message;
	}

	public function isFormFilled()
	{
		foreach ($this->fields as $key => $value) {
			if(empty($value)){
				return FALSE;
			}
		}
		return TRUE;
	}

	public function isEmail()
	{
			if(preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#",$this->fields['email'])){
				return TRUE;
			} else{
				return FALSE;
			}
	}

	public function isPassSecure()
	{
		if(preg_match("#^[a-zA-Z0-9éèùà@&]{7,35}$#",$this->fields['pass'])){
			return TRUE;
		} else{
			return FALSE;
		}
	}

	public function isPassEqualVerif()
	{
		if($this->fields['pass'] == $this->fields['passVerif']){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	public function check()
	{
		$isFilled = $this->isFormFilled();
		$isProperEmail = $this->isEmail();
    	$isValidPass = $this->isPassSecure();
		$isPassEqual = $this->isPassEqualVerif();

	    if($isFilled AND $isProperEmail AND $isValidPass AND $isPassEqual){
			$this->message = "Votre inscription est un succès ! <br/>";
	      	return TRUE;
	    }
	    else{
	      if(!$isValidPass){
					$this->message = "Votre mot de passe doit contenir entre 7 et 35 caractères <br/>
							(les caractères spéciaux autorisés : <strong> éèùà@& </strong>) !";
					return FALSE;
	      }
		  elseif (!$isPassEqual) {
			$this->message = "Vous avez tapez différentes entrées dans <br/>
			<strong> Password </strong> et <strong> Password Vérification </strong> !";
			return FALSE;
		  }
	      else{
			$this->message = "Votre adresse email <strong>".htmlspecialchars($this->fields['email'])."</strong> <br/>
							ne ressemble pas à une adresse email standard!";
			return FALSE;
	      }
		}
	}

	public function addUser()
	{
		if($this->check()){
	    $user = new User($this->fields);
	    $this->userManager->add($user);
	    //Création des sessions
	    return $user->id();
	  }
		else{
			$this->message("Il n'est pas possible d'ajouter l'utilisateur dans la base de données!");
			return FALSE;
		}
	}
}
