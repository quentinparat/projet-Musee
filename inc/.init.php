<?php

if($_SERVER['REMOTE_ADDR'] == "127.0.0.1"){
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_DATA', 'accueil');
	define('PREFIX_DB', '');

	define('PREFIX_PORTAL', 'musee');
	define('URL_PORTAL', 'http://boussads.student.codeur.online/'.PREFIX_PORTAL.'/');

	define('FOLD_EMAIL', 'template/email/');
	define('FOLD_TEMPLATE', 'template');

	define('EXT_MU_TPL', '.html');
}
else{
    define('DB_HOST', 'localhost');
    define('DB_USER', 'quentinp');
    define('DB_PASS', 'syUArx6xop');
    define('DB_DATA', 'quentinp');
	define('PREFIX_DB', 'MUSEE_');

	define('PREFIX_PORTAL', 'projet_DATA');
	define('URL_PORTAL', 'http://www.kevinn.student.codeur.online/'.PREFIX_PORTAL.'/');

	define('FOLD_EMAIL', 'template/email/');
	define('FOLD_TEMPLATE', 'template');

	define('EXT_MU_TPL', '.html');
}
