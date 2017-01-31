<?php

if(isset($index)){
	$user = 1;

	$musee = new musee();

	//si l'utilisateur n'a pas encore like
	if(!$musee->userFavExist($id, $user)){
		$musee->like($id, $user);
	}

	$data = $musee->myRandom();
	echo json_encode(callTemplateReturn('museelike', $data));
}
