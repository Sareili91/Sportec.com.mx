<?php
error_reporting(E_ALL);
include_once("Usuario.php");
class Cliente extends Usuario {
private string $sNombreCompleto="";
private string $sFechaNacimiento="";
private string $sCorreo="";
private string $sNumTel="";
private string $sDireccion="";
private array $arrCompras=array();

	public function buscarCvePwd():bool {
	$oAccesoDatos=new AccesoDatos();
	$sQuery="";
	$arrRS=null;
	$bRet = false;
	$arrParams=array();
		if (empty($this->sCuenta) || empty($this->sContrasenia))
			throw new Exception("Cliente->buscarCvePwd: faltan datos");
		else{
			if ($oAccesoDatos->conectar()){
				$sQuery = " SELECT t1.scuenta, t2.snombrecompleto, t2.sfechanacimiento, 
								   t2.scorreo, t2.snumtel, t2.sdireccion
								   		FROM usuario t1
							JOIN Cliente t2 ON t2.scuenta = t1.scuenta
							WHERE t1.scuenta = :pCuenta
							AND t1.scontrasenia = :pPwd
							AND t1.bActivo = true";
				$arrParams = array(":pCuenta"=>$this->sCuenta,
								   ":pPwd"=>$this->sContrasenia);
				$arrRS = $oAccesoDatos->ejecutarConsulta($sQuery, $arrParams);
				$oAccesoDatos->desconectar();
				if ($arrRS){
					$this->sCuenta = $arrRS[0][0];
					$this->sNombreCompleto = $arrRS[0][1];
					$this->sFechaNacimiento = $arrRS[0][2];
					$this->sCorreo = $arrRS[0][3];
					$this->sNumTel = $arrRS[0][4];
					$this->sDireccion = $arrRS[0][5];
					$this->bActivo = true;
					$bRet = true;
				}
			}
		}
		return $bRet;
	}

	public function buscar():bool {
		throw new Exception("Cliente->buscar: no implementada");
	}

	public function buscarTodos():array {
		throw new Exception("Cliente->buscarTodos: no implementada");
	}

	public function insertar():int {
		throw new Exception("Cliente->insertar: no implementada");
	}

	public function modificar():int {
		throw new Exception("Cliente->modificar: no implementada");
	}

	public function eliminar():int {
		throw new Exception("Cliente->eliminar: no implementada");
	}
	
	public function getNombreCompleto():string{
       return $this->sNombreCompleto;
    }
	public function setNombreCompleto0(string $valor){
       $this->sNombreCompleto = $valor;
    }
	
	public function getFechaNacimiento():string{
       return $this->sFechaNacimiento;
    }
	public function setFechaNacimiento(string $valor){
       $this->sFechaNacimiento = $valor;
    }
	
	public function getCorreo():string{
       return $this->sCorreo;
    }
	public function setCorreo(string $valor){
       $this->sCorreo = $valor;
    }
	
	public function getNumTel():string{
       return $this->sNumTel;
    }
	public function setNumTel(string $valor){
       $this->sNumTel = $valor;
    }
	
	public function getDireccion():string{
		return $this->sDireccion;
	 }
	 public function setDireccion(string $valor){
		$this->sDireccion = $valor;
	 }
	
	public function getCompras():string{
       return $this->arrCompras;
    }
	public function setCompras(string $valor){
       $this->arrCompras = $valor;
    }
}
?>