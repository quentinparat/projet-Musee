<?php


	require_once ".init.php";
	require_once "libs/AltoRouter/AltoRouter.php";
	require_once "libs/pdo/pdo.class.php";

	require_once("libs/Mustache/Autoloader.php");
	require_once("libs/classMusee.php");
	require_once("libs/classUsers.php");

	Mustache_Autoloader::register();
	$router = new AltoRouter();

	$router->setBasePath(PREFIX_PORTAL);

	require_once("function.php");
