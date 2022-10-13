<?php

include_once "BaseDeDatos.php";

class ModeloBase extends BaseDeDatos{

    private $tabla;

    function __construct($nombreTabla){
        parent::__construct();
        $this->tabla = $nombreTabla;
    }

    public function obtenerListado(){
        return $this->obtenerRegistros($this->tabla);
    }
     public function obtenerSorteo(){
        return $this->obtenerPremios($this->tabla);
    }
    public function obtenerUsuario(){
        return $this->obtenerRegistro($this->tabla);
    }
     public function obtenerConteo(){
        return $this->obtenerTotal($this->tabla);
    }
    public function obtenerArticulo(){
        return $this->obtenerRegalo($this->tabla);
    }
    public function obtenerBusqueda($parametrosForm){
        return $this->obtenerResultados($this->tabla,$parametrosForm);
    }

    public function insertar($campos){
        return $this->insertarRegistro($this->tabla,$campos);
    }

    public function actualizar($valores_update,$condicionales){
                 // $condicionales=$valores_update.id_empleado;
                 return $this->actualizarRegistro($this->tabla, $valores_update, $condicionales);
    }
    
    public function obtenerEmpleadoActualizar($id){
        return $this->obtenerRegistros($this->tabla);
    }

  public function eliminar($condiciones){
        return $this->eliminarRegistro($this->tabla,$condiciones);
    }

}