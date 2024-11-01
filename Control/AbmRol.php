<?php
class abmRol{
       //Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto

       public function abm($datos){
        $resp = false;
        if($datos['accion']=='editar'){
            if($this->modificacion($datos)){
                $resp = true;
            }
        }
        if($datos['accion']=='borrar'){ //falta ver si ese rol tiene asociados menus o usuarios, no se puede borrar
            if($this->baja($datos)){
                $resp =true;
            }
        }
        if($datos['accion']=='nuevo'){
             if($this->alta($datos)){
            $resp =true;}
        }
        return $resp;
    } 
    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Rol
     */ 
    private function cargarObjeto($param){
        $obj = null;
        if( array_key_exists('roDescripcion',$param)){
            $obj = new Rol();
            $param["idRol"] = array_key_exists('idRol', $param) ? $param['idRol'] : NULL;
            $obj->setear($param['idRol'], $param['roDescripcion']);
        }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return Rol
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        if( isset($param['idRol']) ){
            $obj = new Rol();
            $obj->setear($param['idRol'], null);
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
            if (isset($param['idRol']))
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
         * permite cambiar datos de un objeto
         * @param array $param
         * @return boolean
         */
        public function modificacion($param){
            $resp = false;
            if ($this->seteadosCamposClaves($param)){
                $elObjtTabla = $this->cargarObjeto($param);
                if($elObjtTabla!=null and $elObjtTabla->modificar()){
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
                if  (isset($param['idRol']))
                    $where.=" and idRol =".$param['idRol'];
                if  (isset($param['roDescripcion']))
                    $where.=" and roDescripcion ='".$param['roDescripcion']."'";
            }
            $arreglo = Rol::listar($where);  
            return $arreglo;
        }
}
?>