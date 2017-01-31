<?php

if(isset($index)){

	$musee = new musee();
	$data = $musee->museeFavoris();

	callTemplate("favoris", array('LIST' => $data));
}

