<?php

include_once "ModeloBase.php";

class ArticuloModelo extends ModeloBase{

    function __construct()
    {
        parent::__construct('articulo');
    }

//    public function obtenerListado(){
//        $db = new BaseDeDatos();
//        return $db->obtenerRegistros('empleado');
//    }

}