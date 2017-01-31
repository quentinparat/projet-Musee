<?php

if(isset($index)){
	
	$user = new user();
	
	if($user->userConnected()){
		$user->userDeconnexion();
		$res = array('SHOW' => true, 'content' => 'Vous êtes dénnecté');
	}
	else{
		$res = array('SHOW' => false, 'content' => 'Vous n\'êtes pas connecté');
	}

	callTemplate("users/deconnexion", $res);
}
