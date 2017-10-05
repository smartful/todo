<?php

class ManagerTache{
  /******************************************************************
  *					             ATTRIBUTS
  *******************************************************************/
  protected $bdd;

  /******************************************************************
  *					             METHODES
  *******************************************************************/
  public function __construct($bdd)
  {
    $this->bdd = $bdd;
  }

  public function add(Tache $tache)
  {
    $req = $this->bdd->prepare("INSERT INTO TACHES(id_user,tache) VALUES (:idUser,:tache)");
    $req->execute(array(
        'idUser'    => $tache->getIdUser(),
        'tache'     => $tache->getTache()
    ));
    $req->closeCursor();
  }

  public function update(Tache $tache)
	{
		$req = $this->bdd->prepare("UPDATE TACHES SET tache = :tache WHERE id = :id");
		$req->execute(array(
								'tache'     => $tache->getTache(),
								'id'        => $tache->getId(),
								));
		$req->closeCursor();
	}

	public function delete(Tache $tache)
	{
		$req = $this->bdd->prepare("DELETE FROM TACHES WHERE id = :id");
		$req->execute(array('id' => $tache->getId()));
		$req->closeCursor();
	}

	public function count($id_user)
	{
		$req = $this->bdd->prepare("SELECT COUNT(*) FROM TACHES WHERE id_user = :idUser");
        $req->execute(array('idUser' => $id_user));
		return $req->fetchColumn();
	}

	public function exist($id)
	{
		$req = $this->bdd->prepare("SELECT COUNT(*) FROM TACHES WHERE id = :id");
		$req->execute(array('id' => (int) $id));
		return (bool) $req->fetchColumn();
	}

	public function get($id)
	{
		$req = $this->bdd->prepare("SELECT id, id_user, tache
									FROM TACHES WHERE id = :id");
		$req->execute(array('id' => (int) $id));
		$donnees = $req->fetch();
		$req->closeCursor();
		return new Tache($donnees);
	}

	public function getList($id_user)
	{
		$taches = array();
		$req = $this->bdd->prepare("SELECT id, id_user, tache
									FROM TACHES
                                    WHERE id_user = :idUser
                                    ORDER BY id DESC");
        $req->execute(array('idUser' => $id_user));
		while($donnees = $req->fetch())
		{
			$taches[] = new Tache($donnees);
		}
		$req->closeCursor();
		return $taches;
	}

}
