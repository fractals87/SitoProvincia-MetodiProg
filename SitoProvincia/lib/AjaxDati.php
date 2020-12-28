<?php
header('Content-type: application/json');
include('../lib/startup.php'); 
$user = new users();
$user->setConnection($db);
if(!$user->CheckAutetication()){
	http_response_code(300);
	echo json_encode(array('message' => "Non autenticato"));
	exit();
}
$dati = new dati();
$dati->setConnection($db);
$dati->load($_REQUEST["id"]);

echo json_encode(array('id' => $dati->id, 'aggregatore' => $dati->aggregatore, 'dato'=>$dati->dato, 'valore'=>$dati->valore));
?>