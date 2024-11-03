<?php
class AbmMenuRol {
    //Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
    
    public function abm($datos) {
        $resp = false;
        if ($datos['accion'] == 'editar') {
            if ($this->modificacion($datos)) {
                $resp = true;
                } else {$resp = false;}

        }
        if ($datos['accion'] == 'borrar') {
            if ($this->baja($datos)) {
                $resp = true;
            }
        }
        if ($datos['accion'] == 'nuevo') {
            if ($this->alta($datos)) {
                $resp=true;
            }
        }
        return $resp;
    }
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return object
     */
    
     private function cargarObjeto($param){
        $obj = null;
        if( array_key_exists('idmenu',$param) and array_key_exists('idrol',$param)){
            $obj = new menuRol();
            $obj->setear($param['idmenu'], $param['idrol']);
        }
        return $obj;
    }
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return object
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        if( isset($param['idmenu']) and isset($param['idrol']) ){
            $obj = new menuRol();
            $obj->setear($param['idmenu'], $param['idrol']);
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
        if (isset($param['idmenu']) && isset($param['idrol']));
        $resp = true;
        return $resp;
    }
    
    /**
     *
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        $objMenuRol = $this->cargarObjeto($param);  
        if ($objMenuRol!=null and $objMenuRol->insertar()){
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
            $objMenuRol = $this->cargarObjeto($param);
            if ($objMenuRol !=null and $objMenuRol->eliminar()){
                $resp = true;
            }
        }
        return $resp;
    }
    
    /**
     * permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificacion($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $objMenuRol = $this->cargarObjeto($param);
            if($objMenuRol !=null and $objMenuRol->modificar($param)){
                $resp = true;
            }
        }
        return $resp;
    }
    
    
    /**
     * permite buscar un objeto
     * @param array $param
     * @return boolean
     */
    
    public function buscar($param){
       // verEstructura($param);
        $where = " true ";
        if ($param<>NULL){
            if  (isset($param['idmenu']))
                $where.=" and menu.idmenu='".$param['idmenu']."'";
                if  (isset($param['idrol']))
                    $where.=" and menurol.idrol ='".$param['idrol']."'";
                    if  (isset($param['idpadre']))
                        $where.=" and idpadre ='".$param['idpadre']."'";
        }
        $arreglo = MenuRol::listar($where);
        return $arreglo;
        
    }
    
    
    public function menuesByIdRol($objRol) {
        $menues = []; // Lista de menús final a devolver
        foreach ($objRol as $rol) {
            $param['idrol'] = $rol;
            // Buscar menús asociados al rol
            $objMenuObjRol = convert_array($this->buscar(['idrol' => $param['idrol']]));
            // Verifica si los resultados no son nulos y recorre el resultado
            if (!empty($objMenuObjRol)) {
                foreach ($objMenuObjRol as $objMenuRol) {
                    $objMenu = new AbmMenu();
                    $menu = convert_array($objMenu->buscar(['idmenu' => $objMenuRol['objmenu']]));
                    // Asegúrate de que $menu no esté vacío antes de recorrer
                    if (!empty($menu)) {
                        foreach ($menu as $itemMenu) {
                            // Verificar si se encontró el menú y si su nombre no está ya en el array de menús
                            if (!in_array($itemMenu["menombre"], array_column($menues, 'menombre'))) {
                                $menues[] = $itemMenu; // Agregar solo el menú que no está incluido
                            }
                        }
                    }
                }
            }
        }
        return $menues; // Retorna array con todos menús asociados al rol
    }
    
    

}
?>