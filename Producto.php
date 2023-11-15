<?php
error_reporting(E_ALL);
include_once("AccesoDatos.php");

abstract class Producto {
protected int $nClave=0;
protected string $sNombre="";
protected string $sDescripcion="";
protected string $sTalla = "";
protected string $sMaterial = "";
protected float $nPrecio = 0;
protected string $sImagen = "";
protected bool $bActivo=false;

	abstract public function buscar(): bool;

	abstract public function buscarTodos():array;

	abstract public function buscarTodosFiltro():array;

	abstract public function insertar():int;

	abstract public function modificar():int;

	abstract public function eliminar():int;
    
    public function getClave():int{
       return $this->nClave;
    }
	public function setClave(int $valor){
       $this->nClave = $valor;
    }
	
    public function getNombre():string{
       return $this->sNombre;
    }
	public function setNombre(string $valor){
       $this->sNombre = $valor;
    }

    public function getDescripcion():string{
        return $this->sDescripcion;
    }
    public function setDescripcion(string $valor){
        $this->sDescripcion = $valor;
    }
    
    public function getTalla():string{
        return $this->sTalla;
    }
    public function setTalla(string $valor){
        $this->sTalla = $valor;
    }

    public function getMaterial():string{
        return $this->sMaterial;
    }
    public function setMaterial(string $valor){
        $this->sMaterial = $valor;
    }
    
    public function getPrecio():float{
       return $this->nPrecio;
    }
	public function setPrecio(float $valor){
       $this->nPrecio = $valor;
    }
    
    public function getImagen():string{
       return $this->sImagen;
    }
	public function setImagen(string $valor){
       $this->sImagen = $valor;
    }
    
    public function getActivo():bool{
       return $this->bActivo;
    }
	public function setActivo(bool $valor){
       $this->bActivo = $valor;
    }
}
?>