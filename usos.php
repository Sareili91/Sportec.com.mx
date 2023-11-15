<?php
/*
Archivo:  usos.php
Objetivo: página para gestionar usos de CFDI si es administrador 
Autor:    BAOZ
*/
include_once("modelo/Empleado.php");
include_once("modelo/Cliente.php");
include_once("utils/ErroresAplic.php");
session_start();
$nErr = -1;
	if (isset($_SESSION["sTipoFirmado"])){
		if ($_SESSION["sTipoFirmado"]==Empleado::ADMINISTRADOR){
			include_once("cabecera.html");
			include_once("menu.php");
		}else{
			$nErr = ErroresAplic::SIN_PERMISOS;
		}
	}else{
		$nErr = ErroresAplic::NO_FIRMADO;
	}
	if ($nErr > -1){
		header("Location: error.php?nError=".$nErr);
		exit();
	}
?>
			<main id="main-content">
				<section>
					<header>
						<h3>Gestionar Usos de CFDI</h3>
					</header>
					EN CONSTRUCCI&Oacute;N, disculpe las molestias
				</section>
			</main>
<?php
include_once("lateral1.html");
include_once("lateral2.html");
include_once("pie.html");
?>