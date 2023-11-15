<?php
/*************************************************************/
/* Archivo:  error.php
 * Objetivo: manejo de errores
 * Autor:    BAOZ
 *************************************************************/
include_once("utils/ErroresAplic.php");
include_once("modelo/Empleado.php");
include_once("modelo/Cliente.php");
session_start();
$nErr=-1;
$oErr = new ErroresAplic();
	if (isset($_REQUEST["nError"]) && !empty($_REQUEST["nError"]))
		$nErr = (int)$_REQUEST["nError"];
	$oErr->setError($nErr);
include_once("cabecera.html");
include_once("menu.php");
?>
		<main id="main-content">
			<section>
				<header>
					<h3>Error</h3>
				</header>
				<h4>
					<?php echo htmlentities($oErr->getTextoError(), 
											ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");?>
				</h4>
			</section>
		</main>
<?php
include_once("lateral1.html");
include_once("lateral2.html");
include_once("pie.html");
?>