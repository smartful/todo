<?php

class Tache{
  /******************************************************************
  *					             ATTRIBUTS
  *******************************************************************/
  protected $idUser;
  protected $tache;

  /******************************************************************
  *					             METHODES
  *******************************************************************/
  public function __construct(array $donnees)
	{
		$this->hydrate($donnees);
	}

	public function hydrate(array $donnees)
	{
		foreach($donnees as $key => $value)
		{
			$method = "set".ucfirst($key);
			if(method_exists($this,$method))
			{
				$this->$method($value);
			}
		}
	}

  //Getter
  public function getId(){ return $this->id;}
  public function getIdUser(){ return $this->idUser;}
  public function getTache(){ return $this->tache;}

  //Setter
  public function setId($id)
  {
	$id = (int) $id;
	$this->id = $id;
  }

  public function setIdUser($idUser)
  {
  	$idUser = (int) $idUser;
  	$this->idUser = $idUser;
  }

  public function setTache($tache){ $this->tache = $tache;}

}
