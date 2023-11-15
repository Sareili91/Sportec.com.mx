<?php
/*Archivo:  ctrlLogout.php
Objetivo: control para terminar sesión
Autor:    BAOZ
*/
session_start(); //Le avisa al servidor que va a utilizar sesiones
	session_destroy();
	header("Location: ../index.php");
?>