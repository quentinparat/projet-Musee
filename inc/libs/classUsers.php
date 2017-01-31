<?php

class user extends SQLpdo{
	
	function __construct(){
		$this->table = "MUSEE_USER";
		parent::__construct();
	}
	
	function userConnected(){
		(isset($_COOKIE['keySession'])) ? $id = $_COOKIE['keySession'] : $id = false;
		if($id){
			if($res = $this->fetch("SELECT id, nom, status FROM ".$this->table." WHERE session = :keySession", array(":keySession" => $id))){
				$_SESSION['id'] = $res['id'];
				return $res;
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}

	//on connecte l'utilisateur
	function userConnexion(){
		$email = test_input($_REQUEST['connexionEmail']);
		$mdp = test_input($_REQUEST['connexionMDP']);
		
		if($email && $mdp){
			$mdp = sha1($mdp);
			 
			if($res = $this->fetch("SELECT id, nom, status FROM ".$this->table." WHERE email = :email AND password = :pass",
					array(":email" => $email, ":pass" => $mdp))){
				if($res['status'] == 1){
					
					$session = sha1($res['nom'] + time());
					setcookie('keySession', $session, (time()+3600 * 24 * 365), "/"); 
					
					$con = $this->update("UPDATE ".$this->table." SET session = :keySession WHERE id = :id", 
						array(":id" => $res['id'], ":keySession" => $session));
			
					
					$_SESSION['idUser'] = $res['id'];
					
					return array('status' => true, 'content' => $res);
				}
				else{
					return array('status' => -3, 'content' => 'Le compte est inactif'); // compte inactif
				}
			}
			else{
				return array('status' => -1, 'content' => 'Le compte n\'existe pas'); //compte 
			}
		}		
		else{
			return array('status' => -2, 'content' => 'Remplissez tous les champs');
		}
	}
	
	//on inscrit l'utilsiateur
	function userRegister(){
		$email = test_input($_REQUEST['insc_email']);
		$mdp = test_input($_REQUEST['insc_password']);
		$nom = test_input($_REQUEST['insc_nom']);
		
		if($email && $mdp && $nom){
			if($res = $this->fetch("SELECT id FROM ".$this->table." WHERE email = :email", array(":email" => $email))){
				$res = array('status' => -1, 'content' => "L'email existe déjà"); //email existe d�j�
			}
			else{
				$activation = sha1($email.time());
				$insc = $this->insert("INSERT INTO ".$this->table." (nom, email, password, sessionActivation) VALUES(:nom, :email, :password, :activation)",
						array(":nom" => $nom, ":email" => $email, ":password" => sha1($mdp), ':activation' => $activation));
				
				function_mail($email, "Activation de votre compte", "activationcompte.html", array("PSEUDO" => $nom, "URLACTIVATION" => URL_PORTAL."activation".$activation."/"));
					
				$res = array('status' => true, 'content' => "L'inscription est effectué.<br/>Vous avez reçu un e-mail de confirmation<br/>"); //ok, l'inscription est OK
			}
		}
		else{
			$res = array('status' => -2, 'content' => "Remplissez tous les champs"); //champ vide
		}
		
		return $res;
	}
	
	function userActivation(){
		$activation = _request('activation');
		if($activation){
			
			$req = $this->prepare("SELECT id FROM ".$this->table." WHERE status = 0 AND sessionActivation = :key");
			$req->execute(array(":key" => $activation));
			if($req->fetch()){
				
					$req = $this->prepare("UPDATE ".$this->table." SET status = 1 WHERE status = 0 AND sessionActivation = :key");
					$req->execute(array(":key" => $activation));
				return true;
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}
	
	function userDeconnexion(){
		setcookie('keySession', "", time(), "/"); 
	}
}