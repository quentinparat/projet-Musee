<?php
if(isset($index)){

		$musee = new musee();
		$data=$musee->GetById($id);

		$pos=explode(", ", $data["coordonnees"]);
		$data['positionx']=$pos[0];
		$data['positiony']=$pos[1];
			callTemplate("musee",$data);

}
