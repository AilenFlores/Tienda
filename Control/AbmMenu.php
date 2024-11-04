<?php
class AbmMenu{
    //Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto

    public function abm($datos) {
        $resp = false;
        if ($datos['accion'] == 'editar') {
            $this->modificacion($datos);
                if (isset($datos['meRol'])) { // Verifica si se enviaron roles
                    $resp= $this->actualizarRoles($datos);
                    } else {
                        $resp = false;
                    }
                }
            
        if ($datos['accion'] == 'borrar') {
            if ($this->baja($datos)) {
                $resp = true;
            }
        }
        if ($datos['accion'] == 'nuevo') {
            $ultimoId= $this->alta($datos);
            $objMenu = convert_array($this->buscar(['idmenu' => $ultimoId])); // Obtener el objeto recién creado
                if (isset($objMenu)) { 
                    $resp = $this->agregarRoles($datos, $objMenu); // Agregar roles
                }
        
        }
        return $resp;
    }

    public function agregarRoles($datos,$objUsuario){
        $usuarioRol = new AbmMenuRol(); 
        $roles = $datos["meRol"] ?? []; 
        $resp = false;
        // Iterar sobre los roles y crear la relación
        foreach ($roles as $rol) {
            $param = [ 'idrol' => $rol, // Asignar el rol para usuarios 
                        'idmenu' => $objUsuario[0]["idmenu"]];
            if ($usuarioRol->alta($param)) {
                $resp = true; // Establecer a true si se añade el rol
                }
            }
            return $resp;
        }
    

        public function actualizarRoles($datos) {
            $resp = false;
            $menuRol = new AbmMenuRol();
            $roles = $datos["meRol"] ?? [];
            $rolActual = convert_array($menuRol->buscar(['idmenu' => $datos['idmenu']]));
            // Extraer solo los IDs de los roles actuales
            $rolActualIds = array_column($rolActual, 'objrol'); // Cambia 'objrol' si es necesario
            // Eliminar roles que ya no están seleccionados en `$roles`
            foreach ($rolActualIds as $rolActualId) {
                if (!in_array($rolActualId, $roles)) {
                    $param = [
                        'idrol' => (int)$rolActualId, 
                        'idmenu' => (int)$datos['idmenu']
                    ];
                    $menuRol->baja($param);
                    $resp = true; 
                }
            }
            // Agregar roles nuevo
            foreach ($roles as $rol) {
                if (!in_array($rol, $rolActualIds)) { 
                    $param = [
                        'idrol' => (int)$rol,
                        'idmenu' => (int)$datos['idmenu']
                    ];
                    $menuRol->alta($param);
                    $resp = true;
                }
            }
        
            return $resp; 
        }
        
    
    


    
    
  /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Tabla
     */
    private function cargarObjeto($param){
        $obj = null;
        if( array_key_exists('idmenu',$param) and array_key_exists('menombre',$param)){
            $obj = new Menu();
            $objmenu = null;
            if (isset($param['idpadre'])){
                $objmenu = new Menu();
                $objmenu->setIdmenu($param['idpadre']);
                $objmenu->cargar();
                
            }
            $obj->setear($param['idmenu'], $param['menombre'],$param['medescripcion'],$objmenu, NULL); 
        }
        return $obj;
    }
    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return Tabla
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        
        if( isset($param['idmenu']) ){
            $obj = new Menu();
            $obj->setIdmenu($param['idmenu']);
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
        if (isset($param['idmenu']))
            $resp = true;
        return $resp;
    }
    
    /**
     * 
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        $param['idmenu'] =null;
        $param['medeshabilitado'] = null;
        $elObjtTabla = $this->cargarObjeto($param);
//        verEstructura($elObjtTabla);
        if ($elObjtTabla!=null ){
            $resp = $elObjtTabla->insertar();
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
     * permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificacion($param){
       
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $elObjtMenu = $this->cargarObjeto($param);
            if($elObjtMenu!=null and $elObjtMenu->modificar()){
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
        $where = " true ";
        if ($param<>NULL){
            if  (isset($param['idmenu']))
                $where.=" and idmenu =".$param['idmenu'];
            if  (isset($param['descrip']))
                 $where.=" and medescripcion ='".$param['medescripcion']."'";
        }
        $arreglo = Menu::listar($where);  
        return $arreglo;
            
            
      
        
    }
   
}
?>