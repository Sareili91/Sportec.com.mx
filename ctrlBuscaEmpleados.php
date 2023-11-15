<?php
/*Archivo:  ctrlBuscaEmpleados.php
Objetivo: control para buscar empleados, considera perfil
Autor:    KIMO
*/
include_once("../modelo/Empleado.php");
include_once("../utils/ErroresAplic.php");
session_start();
$nErr=-1;
$sPer="";
$oEmpleado=null;
$arrEncontrados=null;
$sJsonRet = "";
$oErr = null;
	/*Verifica que esté firmado y sea administrador*/
	if (isset($_SESSION["sTipoFirmado"]) && $_SESSION["sTipoFirmado"]==Empleado::ADMINISTRADOR){
		/*Verifica que haya llegado el tipo*/
		if (isset($_REQUEST["cmbTipo"]) && !empty($_REQUEST["cmbTipo"])){
			try{
				//Obtiene el perfil seleccionado
				$sPer = $_REQUEST["cmbTipo"];
			
				//Busca en la base de datos de acuerdo al tipo indicado
				//es Admon
				if ($sPer=="g"){
					$oEmpleado = new Empleado();
					$oEmpleado->setPerfil($_REQUEST["cmbTipo"]);
					$arrEncontrados = $oEmpleado->buscarTodos();
				//es Cajero
				}else if ($sPer=="c"){
					$oEmpleado = new Empleado();
					$oEmpleado->setPerfil($_REQUEST["cmbTipo"]);
					$arrEncontrados = $oEmpleado->buscarTodos();
				// es Almacenista
				}else if ($sPer=="a"){
					$oEmpleado = new Empleado();
					$oEmpleado->setPerfil($_REQUEST["cmbTipo"]);
					$arrEncontrados = $oEmpleado->buscarTodos();
				}else{
					$nErr = ErroresAplic::TIPO_EMPL_INEXISTENTE;
				}
			}catch(Exception $e){
				//Enviar el error específico a la bitácora de php (dentro de php\logs\php_error_log
				error_log($e->getFile()." ".$e->getLine()." ".$e->getMessage(),0);
				$nErr = ErroresAplic::ERROR_EN_BD;
			}
		}
		else
			$nErr = ErroresAplic::FALTAN_DATOS;

	}else{
		$nErr = ErroresAplic::NO_FIRMADO;
	}

	
	if ($nErr==-1){
		$sJsonRet = 
		'{
			"success":true,
			"status": "ok",
			"data":{
				"arrEmpl": [
		';
		//Recorrer arreglo para llenar objetos
		foreach($arrEncontrados as $oEmpleado){
			$sJsonRet = $sJsonRet.'{
					"correo":"'.$oEmpleado->getCorreo().'", 
					"nombre":"'.$oEmpleado->getNombreCompleto().'", 
					"tipo":"'.$oEmpleado->getPerfil().'", 
					"turno":"'.($oEmpleado->getTurno()==1?"Diurna":"Nocturna").'"
					},';
		}
		//Sobra una coma, eliminarla
		$sJsonRet = substr($sJsonRet,0, strlen($sJsonRet)-1);
		
		//Colocar cierre de arreglo y de objeto
		$sJsonRet = $sJsonRet.'
				]
			}
		}';
	}else{
		$oErr = new ErroresAplic();
		$oErr->setError($nErr);
		$sJsonRet = 
		'{
			"success":false,
			"status": "'.$oErr->getTextoError().'",
			"data":{}
		}';
	}
	//Retornar JSON a quien hizo la llamada
	header('Content-type: application/json');
	echo $sJsonRet;
?>