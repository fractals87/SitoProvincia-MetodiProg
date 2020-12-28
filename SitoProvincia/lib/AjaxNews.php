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
$news = new news();
$news->setConnection($db);
$news->load($_REQUEST["id"]);

echo json_encode(array('id' => $news->id, 'title' => $news->title, 'text'=>$news->text));
?>