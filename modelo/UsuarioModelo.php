<?php

include_once "ModeloBase.php";

class UsuarioModelo extends ModeloBase
{

    function __construct()
    {
        parent::__construct('usuario');
    }

    /*public function obtenerListado(){
        $bd = new BaseDeDatos();
        return $bd->obtenerRegistros('cat_contacto');
    }*/

}