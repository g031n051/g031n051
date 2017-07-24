<?php

function db_connect(){
	$dsn = 'mysql:host=localhost;dbname=WebApp;charset=utf8';
	$user = 'root';
	$password = ',Ia+iBips3';

	try{
		$dbh = new PDO($dsn, $user, $password);
		return $dbh;
	}catch (PDOException $e){
	    	print('Error:'.$e->getMessage());
	    	die();
	}
}
