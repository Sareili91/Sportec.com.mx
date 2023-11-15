<?php
/*Archivo:  ctrlGestionarPlantaOrnato.php
Objetivo: control para buscar gestionar (insertar, modificar, eliminar) una planta
		  de ornato. La eliminación es lógica, no física
Autor:    BAOZ
*/
include_once("../modelo/Planta.php");
include_once("../modelo/Semilla.php");
include_once("../modelo/Empleado.php");
include_once("../utils/ErroresAplic.php");
session_start();//Requiere datos de sesión, sólo el administrador puede editar
$nErr=-1;
$nNum=0;
$sOpe="";
$oPlantaOrnato=null;
$arrTiposValidos = ["image/jpg", "image/jpeg", "image/png"];
$sTipo="";
$arrPartes;
$sExtension="";
$sNomArchFinal="";
$nAfectados = -1;
	/*Verifica que esté firmado y sea administrador*/
	if (isset($_SESSION["sTipoFirmado"]) && 
		$_SESSION["sTipoFirmado"]==Empleado::ADMINISTRADOR){
		/*Verifica que hayan llegado los datos mínimos (tipo, clave, operación)*/
		if (isset($_REQUEST["cmbTipo"]) && !empty($_REQUEST["cmbTipo"]) &&
			isset($_REQUEST["txtCve"]) && !empty($_REQUEST["txtCve"])&&
			isset($_REQUEST["txtOpe"]) && !empty($_REQUEST["txtOpe"])){
			try{
				//Convierte el tipo indicado a número
				$nNum = intval(($_REQUEST["cmbTipo"]),10);
				if ($nNum == 1 || $nNum == 2){
					//Instancía según el tipo
					if ($nNum==1)
						$oPlantaOrnato = new Planta();
					else
						$oPlantaOrnato = new Semilla();
					//Verifica la operación recibida
					$sOpe = $_REQUEST["txtOpe"];
					if ($sOpe == 'a' || $sOpe == 'b' || $sOpe == 'm'){
						$oPlantaOrnato->setClave((int)$_REQUEST["txtCve"]);
						//Paso de datos a menos que sea baja
						if ($sOpe != 'b'){
							if (isset($_REQUEST["txtNom"]) && !empty($_REQUEST["txtNom"]) &&
								isset($_REQUEST["cbSombra"]) && !empty($_REQUEST["cbSombra"]) &&
								isset($_REQUEST["cbFlores"]) && !empty($_REQUEST["cbFlores"]) &&
								isset($_REQUEST["txtCuida"]) && !empty($_REQUEST["txtCuida"]) &&
								isset($_REQUEST["txtPrecio"]) && !empty($_REQUEST["txtPrecio"]) &&
								isset($_REQUEST["cmbOtros"]) && !empty($_REQUEST["cmbOtros"]) &&
								is_uploaded_file($_FILES["txtImg"]["tmp_name"])){
								$oPlantaOrnato->setNombreComun($_REQUEST["txtNom"]);
								$oPlantaOrnato->setEsDeSombra($_REQUEST["cbSombra"]);
								$oPlantaOrnato->setTieneFlores($_REQUEST["cbFlores"]);
								$oPlantaOrnato->setCuidadosGenerales($_REQUEST["txtCuida"]);
								$oPlantaOrnato->setPrecio($_REQUEST["txtPrecio"]);
								//El último dato depende del tipo de planta de ornato
								if ($nNum==1)
									$oPlantaOrnato->setTamanio($_REQUEST["cmbOtros"]);
								else
									$oPlantaOrnato->setPresentacion((int)$_REQUEST["cmbOtros"]);	
								//Verificar tipo de archivo
								$sTipo = mime_content_type($_FILES["txtImg"]["tmp_name"]);
								if (in_array($sTipo, $arrTiposValidos, true)){
									//Verificar tamaño del archivo
									if ($_FILES["txtImg"]["size"]<200000){
										/*El archivo es correcto, copiarlo al directorio 
										de la aplicación con nuevo nombre */
										$arrPartes=explode(".",$_FILES["txtImg"]["name"]);
										$sExtension = end($arrPartes);
										//Generar nuevo nombre
										$sNomArchFinal = $nNum."_".time().".".$sExtension;
										//Pasar archivo
										if (move_uploaded_file($_FILES["txtImg"]["tmp_name"], 
											"../imgs/".$sNomArchFinal))
											$oPlantaOrnato->setImagen($sNomArchFinal);
										else
											$nErr = ErroresAplic::ARCH_PROBL;
									}else{
										$nErr = ErroresAplic::ARCH_MAYOR;
									}
								}else{
									$nErr = ErroresAplic::ARCH_TIPO_MAL;
								}								
							}else
								$nErr = ErroresAplic::FALTAN_DATOS;
						}
						if ($nErr == -1){
							//Llama al método dependiendo de la operación
							switch($sOpe){
								case 'a': $nAfectados = $oPlantaOrnato->insertar();
											break;
								case 'b': $nAfectados = $oPlantaOrnato->eliminar();
											break;
								case 'm': $nAfectados = $oPlantaOrnato->modificar();
											break;
							}
							//Si no afectó al menos un registro, se trata de un error
							if ($nAfectados <1)
								$nErr = ErroresAplic::OPE_NO_REALIZADA;
						}
					}else{
						$nErr = ErroresAplic::OPE_DESCONOCIDA;
					}
				}else
					$nErr = ErroresAplic::TIPO_PROD_INEXISTENTE;
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
		$sCadJson = '{
			"success": true,
			"status": "ok",
			"data":{}
		}';
	}else{
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