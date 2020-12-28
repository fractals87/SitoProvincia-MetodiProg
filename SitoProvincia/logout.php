<?php
session_start();
$_SESSION = array(); //Desetto tutte le variabili di sessione
session_destroy(); //Distruggo le sessioni
header('location:login.php?mess=Disconnessione avvenuta con successo');
?>