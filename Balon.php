<?php
error_reporting(E_ALL);
include_once("Producto.php");

class Balon extends Producto {
private int $nDisciplina = 0;

//Constantes para facilitar la lectura de Disciplina
public CONST BASQUETBOL = 1;
public CONST FUTBOL = 2;
public CONST VOLEIBOL = 3;
//No existe en el modelo, pero facilita el manejo de las restricciones
private static $arrDisciplinas=array(
	self::BASQUETBOL=>"Básquetbol",
	self::FUTBOL=>"Fútbol",
	self::VOLEIBOL=>"Voleibol"
);
    
	public function buscarTodos():array{
	$oAccesoDatos=new AccesoDatos();
	$sQuery="";
	$arrRS=null;
	$arrLinea = null;
	$oProducto=null;
	$arrRet=array();
    //TOMAR LOS DATOS DE LA BD 
		if ($oAccesoDatos->conectar()){
			$sQuery = "SELECT t1.nClave, t1.sNombre, t1.sDescripcion,
                              t1.sTalla, t1.sMaterial, t1.nDisciplina, 
							  t1.nPrecio, t1.sImagen 
						FROM producto t1
						WHERE t1.nTipo = 3
						ORDER BY t1.sNombre;
					";
			$arrParams = array();
			$arrRS = $oAccesoDatos->ejecutarConsulta($sQuery, $arrParams);
			$oAccesoDatos->desconectar();
			if ($arrRS){
				$arrRet = array();
				foreach($arrRS as $arrLinea){
					$oProducto = new Balon();
					$oProducto->setClave($arrLinea[0]);
					$oProducto->setNombre($arrLinea[1]);
                    $oProducto->setDescripcion($arrLinea[2]);
					$oProducto->setTalla($arrLinea[3]);
					$oProducto->setMaterial($arrLinea[4]);
					$oProducto->setDisciplina($arrLinea[5]);
					$oProducto->setPrecio($arrLinea[6]);
					$oProducto->setImagen($arrLinea[7]);
					$arrRet[] = $oProducto; //más rápido que array_push($arrRet, $oProducto)
				}
			}
		} 
		return $arrRet;
	}

	public function buscar():bool {
		throw new Exception("Balon->buscar: no implementada");
	}

	public function buscarTodosFiltro():array {
	$oAccesoDatos=new AccesoDatos();
	$sQuery="";
	$arrRS=null;
	$arrLinea = null;
	$oProducto=null;
	$arrRet=array();
		//En este ejemplo, el filtro es por disciplina
		if ($this->nDisciplina<=0)
			throw new Exception("Balon->buscarTodosFiltro: faltan datos");
		else{
			if ($oAccesoDatos->conectar()){
				$sQuery = "SELECT t1.nClave, t1.sNombre, t1.sDescripcion,
								t1.sTalla, t1.sMaterial, t1.nDisciplina, 
								t1.nPrecio, t1.sImagen 
                           FROM producto t1
                           WHERE t1.nTipo = 3
						   AND t1.nDisciplina = :dis
                           ORDER BY t1.sNombre;
      					";
				$arrParams = array(":dis"=>$this->nDisciplina);
				$arrRS = $oAccesoDatos->ejecutarConsulta($sQuery, $arrParams);
				$oAccesoDatos->desconectar();
				if ($arrRS){
					$arrRet = array();
					foreach($arrRS as $arrLinea){
						$oProducto = new Balon();
						$oProducto->setClave($arrLinea[0]);
                        $oProducto->setNombre($arrLinea[1]);
                        $oProducto->setDescripcion($arrLinea[2]);
                        $oProducto->setTalla($arrLinea[3]);
                        $oProducto->setMaterial($arrLinea[4]);
						$oProducto->setDisciplina($arrLinea[5]);
                        $oProducto->setPrecio($arrLinea[6]);
                        $oProducto->setImagen($arrLinea[7]);
						$arrRet[] = $oProducto; 
					}
				}
			}
		}
		return $arrRet;
	}

	public function insertar():int {
		throw new Exception("Balon->insertar: no implementada");
	}

	public function modificar():int {
		throw new Exception("Balon->modificar: no implementada");
	}

	public function eliminar():int {
		throw new Exception("Balon->eliminar: no implementada");
	}

	public function getDisciplina():int{
		return $this->nDisciplina;
	 }
	 public function setDisciplina(int $valor){
		$this->nDisciplina = $valor;
	 }
	 
	 //No existe en el modelo, es para simplificar la lectura del código
	 public function getDescripDisciplina():string{
	 $sRet="";
		 if ($this->nDisciplina >0 &&
			 array_key_exists($this->nDisciplina."", self::$arrDisciplinas))
			 $sRet = self::$arrDisciplinas[$this->nDisciplina.""];
		 return $sRet;
	 }
	 
	 //No existe set porque la información es fija
	 public function getDisciplinas():array{
		 return self::$arrDisciplinas;
	 }

	}
?>