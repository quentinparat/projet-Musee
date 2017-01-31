<?php

class musee{

	function __construct(){
		 try{
	  		$this->dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_DATA.";charset=UTF8",DB_USER,DB_PASS);
	  	}
	  	catch(PDOException $e)
	    {
	  	 echo $e->getMessage();
	    }
	}

	function myRandom(){
		$sql="SELECT * FROM MUSEE ORDER BY rand() LIMIT 1";
		$sth = $this->dbh->query($sql);

		$data= $sth->fetch(PDO::FETCH_ASSOC);

		return $data;
	}
	function GetById($id){
		 $sql = "SELECT * FROM MUSEE WHERE id=".$id;

		 $sth = $this->dbh->query($sql);// à changer
		 $data = $sth->fetch(PDO::FETCH_ASSOC);

    	 return $data;
    }


	function museeFavoris(){
		 $sql="SELECT * FROM MUSEE m LEFT JOIN MUSEE_FAV mf ON m.ID = mf.id_musee WHERE id_user=1 ORDER BY mf.id";
		 $sth = $this->dbh->query($sql);
		 $data = $sth->fetchAll(PDO::FETCH_ASSOC);

		return $data;
	}

	function userFavExist($id, $user){
		 $sql="SELECT * FROM MUSEE_FAV WHERE id_musee = ".$id." AND id_user=".$user;
		 $sth = $this->dbh->query($sql);
		 $data = $sth->fetchAll(PDO::FETCH_ASSOC);

		return $data;
	}

	function like($id, $user){
		$sql = "INSERT INTO MUSEE_FAV (id_user, id_musee) VALUES('".$user."', '".$id."')";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
	}

	function dislike($id, $user){
		$sql = "DELETE FROM MUSEE_FAV WHERE id_user = '".$user."' AND id_musee = '".$id."'";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
	}

}



?>
