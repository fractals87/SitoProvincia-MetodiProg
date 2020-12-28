<?php
header('Content-Type: text/html; charset=utf-8');

define("ROOT", 	str_replace(array('\\', 'lib'),array('/', ''),getcwd()).'/' );

function __autoload($class) {
    $class = str_replace("_","/",$class);
	include ROOT.'lib/' . $class . '.php';
}

ini_set('display_errors','on'); 
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
//error_reporting(E_ALL);
//error_reporting(E_ERROR | E_WARNING | E_PARSE);

/*INIZIALIZZO CONNESSIONE*/
$conf = new configuration(ROOT.'lib/application.setting.ini');
    
$db = new db($conf); 
$db->connect();   


/* VARIABILI COMUNI DI ERRORI O MESSAGGI */
if(isset($_REQUEST['mess'])):$mess=$_REQUEST['mess'];else:$mess="";endif;
if(isset($_REQUEST['err'])):$err=$_REQUEST['err'];else:$err="";endif;
if(isset($_REQUEST['war'])):$war=$_REQUEST['war'];else:$war="";endif;

?>
