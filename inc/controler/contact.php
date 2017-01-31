<?php

if(isset($index)){

  callTemplate("contact");

	function sendEmail($email,$destinataire,$message){


    	$headers[]  = 'MIME-Version: 1.0';
    	$headers[] = 'Content-type: text/html; charset=UTF-8';

    	// En-têtes additionnels
    	$headers[] = "To: destinataire <". $destinataire .">";
    	$headers[] ="From : <". $email .">";




    	$nbErreurs = 0;
    	$msgErreurs = "";
    	$emailValid = true;


    	$expediteur= $email;
    	$objet = "Demande d'information";

    	if (empty($email)) {
    		$nbErreurs ++;
    		$msgErreurs .="Email<br />";
    	}
    	else
    	{
    		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    		{
    			$emailValid = false;
    			print("Email Invalide");
    		}


    		if($nbErreurs!=0)
    		{
    			print("Champ(s) manquant(s) :<br />".$msgErreurs);
    		}
    		else
    		{
    			if($emailValid)
    			{
    				mail ( $destinataire,$objet,$message,implode("\r\n",$headers));
    			}
    		}
    	}

}
if(isset($_REQUEST['connexion'])){
  $email=$_REQUEST['email'];
  $destinataire="boussad.s@codeur.online";
  $message=$_REQUEST['message'];

  sendEmail($email,$destinataire,$message);
}
}
