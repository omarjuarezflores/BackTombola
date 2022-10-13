<?php

include_once "controlador/UsuarioControlador.php";
include_once "controlador/ArticuloControlador.php";

/**
 * el archivo de rutas es el que va a controlar las peticiones que llegan al back
 * el permitir el acceso va a ser desde los parametros GET de la ruta y que existan los campos: peticion y funcion
 * y este va a responder en un JSON (status: t/f, [msg], opcionalmente: data) y el codigo: 200,201, 404, 500
 * control paramentros GET, datos de formulario: paramentros POST
 */

$respuesta_back = array(
    'status' => false,
    'msg' => array()
);

$parametrosGet = $_GET;
$parametrosPost = $_POST;
//var_dump($parametrosGet,$parametrosPost);exit;

$rutas = new Rutas();
//var_dump($parametrosGet);exit;

$pasa_url = true;
if(!isset($parametrosGet['peticion']) || $parametrosGet['peticion'] == ''){
    $pasa_url = false;
    $respuesta_back['msg'][] = 'Error, el campo GET - peticion es requerido';
}if(!isset($parametrosGet['funcion']) || $parametrosGet['funcion'] == ''){
    $pasa_url = false;
    $respuesta_back['msg'][] = 'Error, el campo GET - funcion es requerido';
}

if($pasa_url){
    //se recibio el parametro peticion y podemos avanzar
    switch ($parametrosGet['peticion']){ //es el que controla el grupo de peticiones
         case 'usuario':
            //se crea instancia de la clase para poder usar sus funciones y atributos
            $usuarioControlador = new UsuarioControlador();
            //var_dump($catControlador->codigoRespuesta);exit;
            switch ($parametrosGet['funcion']){ //el que controla las funciones
                case 'listado':
                    $respuestaCtrl = $usuarioControlador->obtenerUsuarios();
                    $rutas->peticion($usuarioControlador->getCodigoRespuesta(),$respuestaCtrl);
                    break;
                case 'sacarusuario':
                    $respuestaEmpCtrl = $usuarioControlador->sacarUsuario();
                    $rutas->peticion($usuarioControlador->getCodigoRespuesta(),$respuestaEmpCtrl);
                    break;
                case 'sorteo':
                    $respuestaCtrl = $usuarioControlador->hacerSorteo();
                    $rutas->peticion($usuarioControlador->getCodigoRespuesta(),$respuestaCtrl);
                    break;
                  case 'nuevo':
                    $respuestaEmpCtrl = $usuarioControlador->insertarNuevo($parametrosPost);
                    $rutas->peticion($usuarioControlador->getCodigoRespuesta(),$respuestaEmpCtrl);
                    break;
                 case 'correo':
                    $respuestaEmpCtrl = $usuarioControlador->mandarCorreo($parametrosPost);
                    $rutas->peticion($usuarioControlador->getCodigoRespuesta(),$respuestaEmpCtrl);
                    break;
                 case 'conteo':
                    $respuestaEmpCtrl = $usuarioControlador->contarUsuarios();
                    $rutas->peticion($usuarioControlador->getCodigoRespuesta(),$respuestaEmpCtrl);
                    break;
                default:
                    $respuesta_back['status'] = false;
                    $respuesta_back['msg'] = array(
                        'No se encontro la funcion del catalogo solicitado'
                    );
                    $rutas->peticion(404,$respuesta_back);
                    break;
            }
            break;
        case 'articulo':
            $articuloControlador = new ArticuloControlador();
            /**
             * preparar todas las funciones posibles del API rest: consultar registro, agregar registro, modificar y eliminar
             */
            switch ($parametrosGet['funcion']){
                case 'listado':
                    $respuestaEmpCtrl = $articuloControlador->obtenerArticulos();
                    $rutas->peticion($articuloControlador->getCodigoRespuesta(),$respuestaEmpCtrl);
                    break;
                
                case 'nuevo':
                    $respuestaEmpCtrl = $articuloControlador->insertarNuevo($parametrosPost);
                    $rutas->peticion($articuloControlador->getCodigoRespuesta(),$respuestaEmpCtrl);
                    break;
                 case 'sacararticulo':
                    $respuestaEmpCtrl = $articuloControlador->sacarArticulo();
                    $rutas->peticion($articuloControlador->getCodigoRespuesta(),$respuestaEmpCtrl);
                    break;
                
                default:
                    $respuesta_back['status'] = false;
                    $respuesta_back['msg'] = array(
                        'No se encontro la funcion del contacto solicitado'
                    );
                    $rutas->peticion(404,$respuesta_back);
                    break;
            }
            break;
           break;
        default:
            $respuesta_back['status'] = false;
            $respuesta_back['msg'] = array(
                'No se encontro la peticion o la funcion solicitada en el GET'
            );
            $rutas->peticion(404,$respuesta_back);
            break;
    }

}else{
    $rutas->peticion(400,$respuesta_back);
}

class Rutas{

    public function peticion($codigoRespuesta,$respuesta){
        http_response_code($codigoRespuesta);
        echo json_encode($respuesta);
    }

}