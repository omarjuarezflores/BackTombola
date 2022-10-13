<?php

include_once "modelo/ArticuloModelo.php";
include_once "helper/ValidacionFormulario.php";

class ArticuloControlador{

    private $codigoRespuesta;
    private $articuloModelo;

    function __construct(){
        $this->codigoRespuesta = 400;
        $this->articuloModelo = new ArticuloModelo();
    }

    public function obtenerArticulos(){
        try{
            $respuesta['status'] = true;
            $respuesta['msg'] = array(
                'se obtuvo el listado de articulos de la tombola correctamente'
            );
            $respuesta['data']['articulo'] = $this->articuloModelo->obtenerListado();
            $this->codigoRespuesta = 200;
        }catch (Exception $ex){
            $respuesta['status'] = false;
            $respuesta['msg'] = array('Ocurrio un error en el servidor, favor de intentar mas tarde');
            $respuesta['msg'][] = $ex->getMessage();
            $this->codigoRespuesta = 500;
        }
        return $respuesta;
    }
      public function sacarArticulo(){
        try{
            $respuesta['status'] = true;
            $respuesta['msg'] = array(
                'se obtuvo el articulo exitosamente'
            );
            $respuesta['data']['articulo'] = $this->articuloModelo->obtenerArticulo();
          
            $this->codigoRespuesta = 200;
        }catch (Exception $ex){
            $respuesta['status'] = false;
            $respuesta['msg'] = array('Ocurrio un error en el servidor, favor de intentar mas tarde');
            $respuesta['msg'][] = $ex->getMessage();
            $this->codigoRespuesta = 500;
        }
        return $respuesta;
    }

    public function insertarNuevo($parametrosForm){
        try{
            //validaciones de campos para poder guardar un empleado
            $validacion = ValidacionFormulario::articuloNuevo($parametrosForm);
            if($validacion['status']) {
                $guardar = $this->articuloModelo->insertar($parametrosForm);
                if($guardar){
                    $respuesta['status'] = true;
                    $respuesta['msg'] = array('Se guardo con exito el articulo');
                    $this->codigoRespuesta = 201;
                }else{
                    $respuesta['status'] = false;
                    $respuesta['msg'] = array('No fue posible guardar el articulo','Ocurrio un error en el sistema');
                    $this->codigoRespuesta = 500; }
            }else{
                $respuesta['status'] = false;
                $respuesta['msg'] = $validacion['msg'];
                $this->codigoRespuesta = 400;
            } }catch (Exception $ex){
            $respuesta['status'] = false;
            $respuesta['msg'] = array('Ocurrio un error en el servidor, favor de intentar mas tarde');
            $respuesta['msg'][] = $ex->getMessage();
            $this->codigoRespuesta = 500;
        }
        return $respuesta;
    }

    
    
    public function getCodigoRespuesta(){
        return $this->codigoRespuesta;
    }

}