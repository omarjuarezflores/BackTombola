<?php

class ValidacionFormulario{
    
   

    
     public static function usuarioNuevo($datosFormulario){
        $validacion['status'] = true;
        $validacion['msg'] = array();
        if(!isset($datosFormulario['nombre']) || $datosFormulario['nombre'] == ''){
            $validacion['status'] = false;
            $validacion['msg'][] = 'El campo nombre es requerido';
        }if(!isset($datosFormulario['correo']) || $datosFormulario['correo'] == ''){
            $validacion['status'] = false;
            $validacion['msg'][] = 'El campo correo es requerido';
        }if(!isset($datosFormulario['telefono']) || $datosFormulario['telefono'] == ''){
            $validacion['status'] = false;
            $validacion['msg'][] = 'El campo telefono es requerido';
        }if(!isset($datosFormulario['cargo']) || $datosFormulario['cargo'] == ''){
            $validacion['status'] = false;
            $validacion['msg'][] = 'El campo cargo es requerido';
        }
        return $validacion;
    }
     public static function articuloNuevo($datosFormulario){
        $validacion['status'] = true;
        $validacion['msg'] = array();
        if(!isset($datosFormulario['nombre']) || $datosFormulario['nombre'] == ''){
            $validacion['status'] = false;
            $validacion['msg'][] = 'El campo nombre es requerido';
        }if(!isset($datosFormulario['cantidad']) || $datosFormulario['cantidad'] == ''){
            $validacion['status'] = false;
            $validacion['msg'][] = 'El campo cantidad es requerido';
        }if(!isset($datosFormulario['probabilidad']) || $datosFormulario['probabilidad'] == ''){
            $validacion['status'] = false;
            $validacion['msg'][] = 'El campo probabilidad es requerido';
        }
        return $validacion;
    }
    

    
    
    public static function validarFormEmpleadoActualizar($datosFormulario){
        $validacion = self::empleadoNuevo($datosFormulario);
        if(!isset($datosFormulario['id_empleado']) || $datosFormulario['id_empleado'] == ''){
            $validacion['status'] = false;
            $validacion['msg'][] = 'El campo identificador del empleado es requerido';
        }
        return $validacion;
    }

    public static function validarFormEmpleadoEliminar($datosFormulario){
        $validacion['status'] = true;
        $validacion['msg'] = array();
        if(!isset($datosFormulario['id_empleado']) || $datosFormulario['id_empleado'] == ''){
            $validacion['status'] = false;
            $validacion['msg'][] = 'El campo identificador del empleado es requerido';
        }
        return $validacion;
    }

}