<?php

include_once "modelo/UsuarioModelo.php";
include_once "helper/ValidacionFormulario.php";

class UsuarioControlador{

    private $codigoRespuesta;
    private $usuarioModelo;

    function __construct(){
        $this->codigoRespuesta = 400;
        $this->usuarioModelo = new UsuarioModelo();
    }

    public function obtenerUsuarios(){
        try{
            $respuesta['status'] = true;
            $respuesta['msg'] = array(
                'se obtuvo los registros de usuarios exitosamente'
            );
            $respuesta['data']['usuario'] = $this->usuarioModelo->obtenerListado();
            $this->codigoRespuesta = 200;
        }catch (Exception $ex){
            $respuesta['status'] = false;
            $respuesta['msg'] = array('Ocurrio un error en el servidor, favor de intentar mas tarde');
            $respuesta['msg'][] = $ex->getMessage();
            $this->codigoRespuesta = 500;
        }
        return $respuesta;
    }
     public function hacerSorteo(){
        try{
            $respuesta['status'] = true;
            $respuesta['msg'] = array(
                'se obtuvo los resultados exitosamente'
            );
            $respuesta['data']['usuario'] = $this->usuarioModelo->obtenerSorteo();
            $this->codigoRespuesta = 200;
        }catch (Exception $ex){
            $respuesta['status'] = false;
            $respuesta['msg'] = array('Ocurrio un error en el servidor, favor de intentar mas tarde');
            $respuesta['msg'][] = $ex->getMessage();
            $this->codigoRespuesta = 500;
        }
        return $respuesta;
    }
    
    public function sacarUsuario(){
        try{
            $respuesta['status'] = true;
            $respuesta['msg'] = array(
                'se obtuvo los registro exitosamente'
            );
            $respuesta['data']['usuario'] = $this->usuarioModelo->obtenerUsuario();
          
            $this->codigoRespuesta = 200;
        }catch (Exception $ex){
            $respuesta['status'] = false;
            $respuesta['msg'] = array('Ocurrio un error en el servidor, favor de intentar mas tarde');
            $respuesta['msg'][] = $ex->getMessage();
            $this->codigoRespuesta = 500;
        }
        return $respuesta;
    }
       public function contarUsuarios(){
        try{
            $respuesta['status'] = true;
            $respuesta['msg'] = array(
                'se obtuvo la cantidad'
            );
            $respuesta['data']['usuario'] = $this->usuarioModelo->obtenerConteo();
          
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
           // $validacion = ValidacionFormulario::usuarioNuevo($parametrosForm);
            $validacion['status'] = true;
            if($validacion['status']) {
            
                $guardar = $this->usuarioModelo->insertar($parametrosForm);
                if($guardar){
                      $nombre="Softura Solutions";
                      $usuario=$nom=($parametrosForm['nombre']);
                     $asunto="Registro a tombola bitoo exitoso";
                     $mensaje="Felicitaciones  " .$usuario . "  tu registro a la tombola bitoo fue exitoso!!!!";
            
                     $destinatario=$nom=($parametrosForm['correo']);
                     
                     $header="Registro exitoso!";
                   $mensajecompleto= $mensaje . "\n Atentamente: " . $nombre;
                   mail($destinatario, $asunto, $mensajecompleto, $header);
                    $respuesta['status'] = true;
                    $respuesta['msg'] = array('Se guardo con exito el usuario');
                    $this->codigoRespuesta = 201;
                }else{
                    $respuesta['status'] = false;
                    $respuesta['msg'] = array('No fue posible guardar el usuario','Ocurrio un error en el sistema');
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
   
       public function insertarNuevocfcgfchfhcchhcg($parametrosForm){
        try{
            //validaciones de campos para poder guardar un empleado
           // $validacion = ValidacionFormulario::usuarioNuevo($parametrosForm);
            $validacion['status'] = true;
            if($validacion['status']) {
            
                $guardar = $this->usuarioModelo->insertar($parametrosForm);
                if($guardar){
                     $nombre="Softura Solutions";
                      $usuario=$nom=($parametrosForm['nombre']);
                     $asunto="Registro a tombola bitoo exitoso";
                     $mensaje="Felicitaciones  " .$usuario . "  tu registro a la tombola bitoo fue exitoso!!!!";
            
                     $destinatario=$nom=($parametrosForm['correo']);
                     
                     $header="Registro exitoso!";
                   $mensajecompleto= $mensaje . "\n Atentamente: " . $nombre;
                   mail($destinatario, $asunto, $mensajecompleto, $header);
                    $respuesta['status'] = true;
                    $respuesta['msg'] = array('Se guardo con exito el usuario');
                    $this->codigoRespuesta = 201;
                }else{
                    $respuesta['status'] = false;
                    $respuesta['msg'] = array('No fue posible guardar el usuario','Ocurrio un error en el sistema');
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
    
    

   
  

    

     public function eliminar($datosFormulario){
        $respuesta = array(
            'success' => false,
            'msg' => array('No fue posible eliminar el usuario'),
        );
        $validacion = ValidacionFormulario::validarFormEmpleadoEliminar($datosFormulario);
        if($validacion['status']){
            $empleadoEliminar = $this->empleadoModelo->eliminar($datosFormulario);
            if($empleadoEliminar){
                $respuesta = array(
                    'success' => true,
                    'msg' => array('Se eliminó el empleado correctamente'),
                );
                $this->codigoRespuesta=200;
            }else{
                $respuesta['success'] = false;
                $respuesta['msg'] = $this->empleadoModelo->getErrores();
            }
        }else{
            $respuesta['success'] = false;
            $respuesta['msg'] = $validacion['msg'];
        }
        return $respuesta;
    }

    
    
  public function buscarEmpleados($parametrosForm){
        try{
            $respuesta['status'] = true;
            $respuesta['msg'] = array(
                'se obtuvo el listado de empleados correctamente'
            );
            $respuesta['data']['empleado'] = $this->empleadoModelo->obtenerBusqueda($parametrosForm);
            $this->codigoRespuesta = 200;
        }catch (Exception $ex){
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