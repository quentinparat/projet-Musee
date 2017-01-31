<?php

if(isset($index)){
	$user = 1;

	$musee = new musee();
	$musee->dislike($id, $user);

	$data = $musee->myRandom();
	echo json_encode(callTemplateReturn('museelike', $data));

}
