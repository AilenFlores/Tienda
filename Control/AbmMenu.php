<?php
class AbmMenu{
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

    public function actualizarRoles($datos, $roles) {
        $resp = false;
        $menuRol = new AbmMenuRol();
        $rolActual = convert_array($menuRol->buscar(['idmenu' => $datos['idmenu']]));
        // Eliminar roles que ya no están seleccionados en `$roles`
        foreach ($rolActual as $rolActualId) {
            $idRolActual = $rolActualId["objrol"]->getIdRol(); // Obtener ID del rol actual
            if (!in_array($idRolActual, $roles)) {
                $param = [
                    'idrol' => (int)$idRolActual, 
                    'idmenu' => (int)$datos['idmenu']
                ];
                $menuRol->baja($param); // Eliminar el rol
            }
        }
    
        // Agregar roles nuevos que no estén en `$rolActual`
        foreach ($roles as $rol) {
            // Comprobar si ya existe el rol en el menú
            $existeRolMenu = $menuRol->buscar(['idrol' => $rol, 'idmenu' => $datos['idmenu']]);
            if (empty($existeRolMenu)) { // Solo añadir si no existe
                $param = [
                    'idrol' => (int)$rol, // Asegúrate de que aquí sea solo el ID del rol
                    'idmenu' => (int)$datos['idmenu']
                ];
                $menuRol->alta($param); // Agregar el nuevo rol
                $resp = true; // Marcamos que se ha hecho al menos una alta
            }
        }
    
        return $resp; // Devolvemos el estado final
    }
    
    


    public function agregarRoles($datos, $objMenu) {
        $menuRol = new AbmMenuRol();
        $roles = $datos["menurol"] ?? [];
        $resp = false; 
        // Iterar sobre los roles y crear la relación
        foreach ($roles as $rol) {
            $param = [
                'idrol' => $rol, // Asignar el rol para usuarios 
                'idmenu' => $objMenu[0]["idmenu"]
            ];
            if ($menuRol->alta($param)) {
                $resp = true; // Establecer a true si se añade el rol
            }
        }
        
        return $resp; // Retornar el estado de la operación
    }
    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return object
     */
    private function cargarObjeto($param) {
        $obj = null;
    
        // Verificar que todas las claves necesarias están presentes en el array $param
        if (array_key_exists('menombre', $param) &&
            array_key_exists('medescripcion', $param) &&
            array_key_exists('objmenu', $param)) {
            // Crear el objeto principal Menu
            $obj = new Menu();
            $idmenu = array_key_exists('idmenu', $param) ? $param['idmenu'] : NULL;
            if ($param["objmenu"] == NULL) {
                // Llamar a setear con los parámetros adecuados sin menú padre
                $obj->setear($idmenu, $param['menombre'], $param['medescripcion'], NULL, NULL);
            } else {
                // Crear el objeto para el menú padre y cargarlo
                $objMenuPadre = new Menu();
                $objMenuPadre->setIdmenu($param["objmenu"]);
                $objMenuPadre->cargar();
                // Llamar a setear con los parámetros adecuados con menú padre
                $obj->setear($idmenu, $param['menombre'], $param['medescripcion'], $objMenuPadre, NULL);
            }
        }
        // Retornar el objeto creado o null si no se cumplió la condición
        return $obj;
    }
    
    
    
    
    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return object
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        if( isset($param['idmenu']) ){
            $obj = new Menu();
            $obj->setIdmenu($param['idmenu'], null, null, null, null);
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
            if  (isset($param['menombre']))
                 $where.=" and menombre='".$param['menombre']."'";
                 if  (isset($param['medescripcion']))
                     $where.=" and medescripcion =".$param['medescripcion'];
                     if  (isset($param['idpadre']))
                         $where.=" and idpadre =".$param['idpadre'];
                         if (isset($param['padrenull']))
                             $where.=" and idpadre IS " . $param['padrenull'];
                         if  (isset($param['medeshabilitado']))
                             $where.=" and medeshabilitado=".$param['medeshabilitado'];
        }
        $arreglo = Menu::listar($where); 
        return $arreglo;
    }
}
?>