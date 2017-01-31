<?php

header('Content-Type: text/html; charset=utf-8');

if(isset($index)){

	$musee = new musee();

	$data = $musee->myRandom();

	
	//$data = array_push($data, array('URL' => URL_PORTAL));

	callTemplate("home", $data);

}
