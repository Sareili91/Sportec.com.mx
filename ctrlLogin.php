<?php
/*Archivo:  ctrlLogin.php
Objetivo: control para iniciar sesión
Autor:    BAOZ
*/
include_once("../modelo/Empleado.php");
include_once("../modelo/Cliente.php");
include_once("../utils/ErroresAplic.php");
session_start(); //Le avisa al servidor que va a utilizar sesiones
$nErr=-1;
$oUsu=new Empleado();
$sNombre="";
	/*Verifica que hayan llegado los datos*/
	if (isset($_REQUEST["txtCuentaUsu"]) && !empty($_REQUEST["txtCuentaUsu"]) &&
		isset($_REQUEST["txtPwd"]) && !empty($_REQUEST["txtPwd"])){
		try{
			//Pasa los datos al objeto
			$oUsu->setCuenta($_REQUEST["txtCuentaUsu"]);
			$oUsu->setContrasenia($_REQUEST["txtPwd"]);
			//Busca en la base de datos
			if ($oUsu->buscarCvePwd()){
				$_SESSION["sNomFirmado"] = $oUsu->getNombreCompleto();
				$_SESSION["sDescFirmado"] = $oUsu->getDescripPerfil();
				$_SESSION["sTipoFirmado"] = $oUsu->getPerfil();
			}else {
				//Si no es empleado, es posible que sea cliente
				$oUsu = new Cliente();
				$oUsu->setCuenta($_REQUEST["txtCuentaUsu"]);
				$oUsu->setContrasenia($_REQUEST["txtPwd"]);
				if ($oUsu->buscarCvePwd()){
					$_SESSION["sNomFirmado"] = $oUsu->getNombreCompleto();
					$_SESSION["sDescFirmado"] = "Cliente";
					$_SESSION["sTipoFirmado"] = "e";
				}else //no es cliente ni empleado
					$nErr = ErroresAplic::USR_DESCONOCIDO;
			}
		}catch(Exception $e){
			//Enviar el error específico a la bitácora de php (dentro de php\logs\php_error_log
			error_log($e->getFile()." ".$e->getLine()." ".$e->getMessage(),0);
			$nErr = ErroresAplic::ERROR_EN_BD;
		}
	}
	else
		$nErr = ErroresAplic::FALTAN_DATOS;
	
	if ($nErr==-1){
		$sCadJson = '{
			"success": true,
			"status": "ok",
			"data":{
				"sNombreCompleto":"'.$_SESSION["sNomFirmado"].'",
				"sDescTipo":"'.$_SESSION["sDescFirmado"].'",
				"nTipo":"'.$_SESSION["sTipoFirmado"].'"
			}
		}';
	}
	else{
		$oErr = new ErroresAplic();
		$oErr->setError($nErr);
		$sCadJson = '{
			"success": false,
			"status": "'.$oErr->getTextoError().'",
			"data":{}
		}';
	}
	header('Content-type: application/json');
	echo $sCadJson;
?>