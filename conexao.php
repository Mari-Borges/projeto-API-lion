<?php 

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With'); 
header('Content-Type: application/json; charset=utf-8');  

/*
//dados do banco no servidor local
$banco = 'sysmedical';
$host = 'localhost';
$usuario = 'root';
$senha = '';
*/

$banco = 'ionic';
$host = 'localhost';
$usuario = 'root';
$senha = '';


/*
$banco = 'lion';
$host = 'mysql742.umbler.com';
$usuario = 'mari_borges';
$senha = 'vemvl0312';
*/
try {

	$pdo = new PDO("mysql:dbname=$banco;host=$host", "$usuario", "$senha");
	
} catch (Exception $e) {
	echo 'Erro ao conectar com o banco!! '. $e;
}

 ?>