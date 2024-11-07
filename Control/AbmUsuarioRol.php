<?php
class AbmUsuarioRol{
    //Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto

    public function abm($datos){
        $resp = false;
        if($datos['accion']=='editar'){
            if($this->modificacion($datos)){
                $resp = true;
            }
        }
        if($datos['accion']=='borrar'){
            if($this->baja($datos)){
                $resp =true;
            }
        }
        if($datos['accion']=='nuevo'){
            if($this->alta($datos)){
                $resp =true;
            }
        }
        return $resp;
    }

    
    public function buscarRol($roles) {
        $abmRol = new abmRol();  
        foreach ($roles as $rol) {
            $objRolArray[] = convert_array($abmRol->buscar(['idRol' => $rol]));
        }
        return $objRolArray;
    }
    
    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return usuarioRol
     */
    private function cargarObjeto($param){
        $obj = null;
        
        if( array_key_exists('idusuario',$param) and array_key_exists('idrol',$param)){
            $obj = new usuarioRol();
            $obj->setear($param['idusuario'], $param['idrol']);
        }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return usuarioRol
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        if( isset($param['idusuario']) and isset($param['idrol']) ){
            $obj = new usuarioRol();
            $obj->setear($param['idusuario'], $param['idrol']);
        }
        return $obj;
    }

    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */

    private function seteadosCamposClaves($param){
        $resp = false;
        if (isset($param['idusuario']) and isset($param['idrol']))
            $resp = true;
        return $resp;
    }

    /**
     * 
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        $elObjtTabla = $this->cargarObjeto($param);
        if ($elObjtTabla!=null and $elObjtTabla->insertar()){
            $resp = true;
        }
        return $resp;
    }

    /**
     * permite eliminar un objeto 
     * @param array $param
     * @return boolean
     */

    public function baja($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $elObjtTabla = $this->cargarObjetoConClave($param);
            if ($elObjtTabla!=null and $elObjtTabla->eliminar()){
                $resp = true;
            }
        }
        
        return $resp;
    }

    /**
     * permite cambiar los datos de un objeto
     * @param array $param
     * @return boolean
     */

    public function modificacion($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $elObjtTabla = $this->cargarObjeto($param);
            if ($elObjtTabla!=null and $elObjtTabla->modificar()){
                $resp = true;
            }
        }
        
        return $resp;
    }

    /**
     * permite buscar un objeto
     * @param array $param
     * @return array
     */

    public function buscar($param){
        $where = " true ";
        if ($param<>NULL){
            if  (isset($param['idusuario']))
                $where.=" and idUsuario=".$param['idusuario'];
            if  (isset($param['idRol']))
                $where.=" and idRol=".$param['idRol'];
        }
        $arreglo = usuarioRol::listar($where);
        return $arreglo;
    }

} 
?>