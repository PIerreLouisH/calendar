<?php
class laBDD

	{
	var $hote;
	var $user;
	var $pass;
	var $uneBase;
	var $laConnexion;
	var $resultat;
	var $laLigne;
	function laBDD($leHote, $leUser, $lePass, $laBase)
		{
		$this->hote = $leHote;
		$this->user = $leUser;
		$this->pass = $lePass;
		$this->uneBase = $laBase;
		}

	function connexion()
		{
		$laChaineConnexion = 'mysql:host=' . $this->hote . ';dbname=' . $this->uneBase;
		$this->laConnexion = new PDO($laChaineConnexion, $this->user, $this->pass, array(
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
		));
		if (!$this->laConnexion)
			{
			die('Impossible de se connecter à la base de donnéees : ' . mysqli_error());
			}

		return $this->laConnexion;
		}

	function requete($laReq)
		{
		$this->resultat = $this->laConnexion->prepare($laReq, array(
			PDO::ATTR_CURSOR,
			PDO::CURSOR_SCROLL
		));
		$this->resultat->execute();
		if (!$this->resultat)
			{
			die('Requete invalide : ' . mysqli_error());
			}

		return $this->resultat->fetchAll();
		}

	function nbLigne()
		{
		return $this->resultat->rowCount();
		}

	function setLigne($uneLigne)
		{
		$this->laLigne = $uneLigne;
		}

	function getLigne()
		{
		return $this->laLigne;
		}

	function derniereLigneInsert()
		{
		return $this->laConnexion->lastInsertId();
		}

	function __call($name, array $arguments)
		{
		if (method_exists($this->_laBDD, $name))
			{
			try
				{
				return call_user_func_array(array(&$this->_laBDD,
					$name
				) , $arguments);
				}

			catch(Exception $e)
				{
				throw new Exception('Database Error: "' . $name . '" does not exists');
				}
			}
		}
	}

?>