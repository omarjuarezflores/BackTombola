<?php

include_once 'ConfigDB.php';

class BaseDeDatos
{

    private $mysqli;
    private $errores;

    function __construct()
    {
        try{
            $configDB = ConfigDB::getConfig();
            $this->mysqli = new mysqli(
                $configDB['hostname'],
                $configDB['usuario'],
                $configDB['password'],
                $configDB['bd'],
                $configDB['puerto']
            );
            if($this->mysqli->connect_errno){
                $this->errores = $this->mysqli->error_list;
                echo 'hubo un error en la conexion a la BD';die;
            }else{
                $this->errores = array();
            }
        }catch (Exception $ex){
            $this->errores[] = $ex->getMessage();
            echo 'Hubo un error en el servidor';die;
        }
    }

    

    public function obtenerRegistros($tabla){
        try{
            $query = $this->mysqli->query("select * from $tabla");
            $registros_retorno = array();
            while($registro = $query->fetch_assoc()){
                $registros_retorno[] = $registro;
            }
            
            return $registros_retorno;
        }catch (Exception $ex){
            $this->errores[] = $ex->getMessage();
        }
    }
     public function obtenerPremios($tabla){
        try{
        $contador=1;
        


        $resultados = array();
            $usuarios = array();
            $premio = array();
            $tabla2="articulo";
            $tUsuarios= $this->obtenerTotal($tabla);
            $total1=$tUsuarios[0]['total'];
            for ($i = 1; $i <=$total1; $i++) {
                $contador=$contador+1;
                if($contador==4){
                $usuarios= $this->obtenerRegistro($tabla);
                $resultados[$i]['usuario']=$usuarios[0]['nombre'];
                $premio= $this->obtenerRegalo($tabla2);
                 $resultados[$i]['regalo']=$premio[0]['nombre'];
                 $contador=1;
                }else{
                $usuarios= $this->obtenerRegistro($tabla);
                $resultados[$i]['usuario']=$usuarios[0]['nombre'];
                $resultados[$i]['regalo']='Sigue participando';
                }
                    }
           
         
             return $resultados;
           }catch (Exception $ex){
            $this->errores[] = $ex->getMessage();
        }
    }
    public function obtenerRegistro($tabla){
        try{
                
                
                $query = $this->mysqli->query("select * from $tabla order by rand() limit 1");
                $registros_retorno = array();
                while($registro = $query->fetch_assoc()){
                $registros_retorno[] = $registro;
               
                }
            //$condicionales=$registros_retorno[0]['idusuario'];
            //$consultaDeleteSQL = "DELETE FROM $tabla where idusuario= $condicionales";
            //$query = $this->mysqli->query($consultaDeleteSQL);
            return $registros_retorno;
            
        }catch (Exception $ex){
            $this->errores[] = $ex->getMessage();
        }
    }
     public function obtenerTotal($tabla){
         try{
            
            $query = $this->mysqli->query("SELECT COUNT(*) total FROM $tabla");
            $registros_retorno = array();
             while($registro = $query->fetch_assoc()){
                $registros_retorno[] = $registro;
            }
        
            return $registros_retorno;
        }catch (Exception $ex){
            $this->errores[] = $ex->getMessage();
        }
         
        }
    
     public function obtenerRegalo($tabla){
        try{
            
            $query = $this->mysqli->query("select * from $tabla order by probabilidad desc limit 1");
            $registros_retorno = array();
             while($registro = $query->fetch_assoc()){
                $registros_retorno[] = $registro;
            }
             $id=$registros_retorno[0]['idarticulo'];
             $can=$registros_retorno[0]['cantidad'];
             $cantidad=$can-1;
               if($cantidad==0){
                  $consultaDeleteSQL = "DELETE FROM $tabla where idarticulo= $id";
                  $query = $this->mysqli->query($consultaDeleteSQL);
                }else{
               $consulta = "update $tabla set cantidad=$cantidad where idarticulo= $id";
                $query = $this->mysqli->query($consulta);}
            return $registros_retorno;
        }catch (Exception $ex){
            $this->errores[] = $ex->getMessage();
        }
    }
     public function obtenerResultados($tabla,$parametrosForm){
        try{
            $nom=($parametrosForm['nombre']);
            $pat=($parametrosForm['paterno']);
            $query = $this->mysqli->query("select * from $tabla where paterno like '$pat' or nombre like '$nom'" );
            
            $registros_retorno = array();
            while($registro = $query->fetch_assoc()){
                $registros_retorno[] = $registro;
            }
            return $registros_retorno;
        }catch (Exception $ex){
            $this->errores[] = $ex->getMessage();
        }
    }
   

    /**
     * funcion especializada para realizar en insertar datos a la BD
     * @param string nombre_tabla, array parametros (columna_tabla => valor)
     * ej paramentros
     * array(
        'id' => 0,
     *  'nombre' => 'algun dato'
     * )
     */
    public function insertarRegistro($tabla,$valores_insert){
        try{
            $string_llave_valor = $this->obtenerCadenaInsert($valores_insert);
            //var_dump($string_llave_valor);
            $sqlInsert = "insert into $tabla(".$string_llave_valor['columnas'].") values(".$string_llave_valor['values'].")";
            try{
                $query = $this->mysqli->query($sqlInsert);
                if($query !== true){
                    return false;
                }
                return true;
            }catch (Exception $ex){
                return false;
            }
            //culminar el insertado de este SQL a la BD
        }catch (Exception $ex){
            $this->errores[] = $ex->getMessage();
        }
    }
    

     public function actualizarRegistro($tabla,$valoresUpdate,$condicionales){
        try{
            $sqlCamposUpdate = $this->obtenerColumnaValorUpdate($valoresUpdate);
            $condicionesSQL = $this->obtenerCondicionalesWhereAnd($condicionales);
            $consultaUpdateSQL = "UPDATE $tabla SET $sqlCamposUpdate $condicionesSQL";
            $query = $this->mysqli->query($consultaUpdateSQL);
            if($query !== true){
                $this->errores = $this->mysqli->error_list;
                return false;
            }return true;
        }catch (Exception $ex){
            return false;
        }
    }
     
    

    private function obtenerCadenaInsert($valores_insert){
        $retorno = array(
            'columnas' => '',
            'values' => ''
        );
        $contador_index = 1;
        $tam_array_valores = sizeof($valores_insert);
        foreach ($valores_insert as $indice => $valor){
            if($contador_index < $tam_array_valores){
                $retorno['columnas'] .= $indice. ', ';
                $retorno['values'] .= "'$valor'". ', ';
            }else{
                $retorno['columnas'] .= $indice;
                $retorno['values'] .= "'$valor'";
            }
            $contador_index++;
        }
        return $retorno;
    }
     
    
      
    
    
   
      private function obtenerCondicionalesAnd($condicionales)
    {
        $condiciones = ' where 1=1';
        $index = 1;
        $max = sizeof($condicionales);
        foreach ($condicionales as $columna => $valor) {
            if ($index <= $max) {
                if (strpos($valor, '%') !== false) {
                    $condiciones .= " AND $columna LIKE '$valor'";
                } else {
                    $condiciones .= " AND $columna = '$valor'";
                }
            }
            $index++;
        }
        return $condiciones;
    }
    
    
    
   
    
     public function obtenerCondicionalesWhereAnd($condicionales){
        $condiciones = " WHERE 1=1";
        foreach ($condicionales as $columna => $valor){
            $condiciones .= " AND $columna = '$valor'";
        }
        return $condiciones;
    }
    /*public function getErrores(){
        return $this->errores;
    }*/
    public function getErrores(){
        $msgError = array();
        foreach ($this->errores as $e){
            $msgError[] = "Codigo error: ".$e['errno']." Detalle/Explicacion: ".$e['error'];
        }
        return $msgError;
    }

}