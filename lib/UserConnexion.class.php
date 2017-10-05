<?php
class UserConnexion
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
	public function getUserManager(){return $this->userManager;}

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

	public function setUserManager(UserManager $userManager)
	{
		$this->userManager = $userManager;
	}

	// Autres méthodes
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
			}
			else{
				return FALSE;
			}
	}

	public function isPassSecure()
	{
		if(preg_match("#^[a-zA-Z0-9éèùà@&]{7,35}$#",$this->fields['pass'])){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	public function getUser()
	{
		$isFilled = $this->isFormFilled();
		$isProperEmail = $this->isEmail();
    	$isValidPass = $this->isPassSecure();

		if($isFilled AND $isProperEmail AND $isValidPass)
		{
			$user = $this->userManager->getEmail($this->fields['email']);
			if($user == FALSE){
				//Gestion du cas où le mail n'est pas présent dans la base de données
				$this->message = "Votre adresse email n'est pas présente dans la base de données !";
				return FALSE;
			}
			else{
				return $user;
			}
		}
		else{
      		if(!$isValidPass){
				$this->message = "Votre mot de passe doit contenir entre 7 et 35 caractères <br/>
						(les caractères spéciaux autorisés : <strong> éèùà@& </strong>) !";
				return FALSE;
	        }
	        else{
					$this->message = "Votre adresse email <strong>".htmlspecialchars($this->fields['email'])."</strong> <br/>
							ne ressemble pas à une adresse email standard!";
					return FALSE;
	        }
	    }
	}

	public function check()
	{
		$user = $this->getUser();
		if($user == FALSE){
			//Gestion du cas où le mail n'est pas présent dans la base de données
			$this->message = "Votre adresse email n'est pas présente dans la base de données !";
		}
		else{
			if($this->userManager->verifPass($user,$this->fields['pass']))
			{
				$this->message = "Bonjour <strong>".htmlspecialchars($user->prenom())." ".htmlspecialchars($user->nom())."</strong> !";
				// On retourne l'ID pour les sessions
				return $user->id();
			}
			else
			{
				$this->message = "Le mot de passe que vous avez tapez <strong>".htmlspecialchars($this->fields['pass'])."</strong> <br/>
							ne correspond pas avec l'adresse email <strong>".htmlspecialchars($this->fields['email'])." </strong> ";
			}
		}
	}

}
