<?php
class AbmMenuRol {
    // Este método principal ejecuta una acción de alta, baja o modificación dependiendo del valor de 'accion' en $datos.
    
    public function abm($datos) {
        $resp = false;
        if ($datos['accion'] == 'editar') {
            // Llama a la función de modificación si la acción es 'editar'.
            if ($this->modificacion($datos)) {
                $resp = true;
            } else {
                $resp = false;
            }
        }
        if ($datos['accion'] == 'borrar') {
            // Llama a la función de baja si la acción es 'borrar'.
            if ($this->baja($datos)) {
                $resp = true;
            }
        }
        if ($datos['accion'] == 'nuevo') {
            // Llama a la función de alta si la acción es 'nuevo'.
            if ($this->alta($datos)) {
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * Crea un objeto menuRol y lo carga con los valores de $param si contiene las claves necesarias.
     * @param array $param Arreglo asociativo con los datos para crear el objeto.
     * @return object|null Devuelve el objeto menuRol o null si no se carga correctamente.
     */
    private function cargarObjeto($param){
        $obj = null;
        if (array_key_exists('idmenu', $param) && array_key_exists('idrol', $param)) {
            $obj = new menuRol();
            $obj->setear($param['idmenu'], $param['idrol']);
        }
        return $obj;
    }

    /**
     * Crea un objeto menuRol utilizando las claves primarias en $param.
     * @param array $param Arreglo con las claves necesarias para el objeto menuRol.
     * @return object|null Devuelve el objeto menuRol o null si no se carga correctamente.
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        if (isset($param['idmenu']) && isset($param['idrol'])) {
            $obj = new menuRol();
            $obj->setear($param['idmenu'], $param['idrol']);
        }
        return $obj;
    }
    
    /**
     * Verifica que los campos clave ('idmenu' y 'idrol') están presentes en $param.
     * @param array $param Arreglo a verificar.
     * @return boolean Devuelve true si los campos clave están presentes, false en caso contrario.
     */
    private function seteadosCamposClaves($param){
        $resp = false;
        if (isset($param['idmenu']) && isset($param['idrol'])) {
            $resp = true;
        }
        return $resp;
    }

    /**
     * Inserta un nuevo registro de menuRol en la base de datos.
     * @param array $param Datos necesarios para crear el registro.
     * @return boolean Devuelve true si la inserción fue exitosa, false en caso contrario.
     */
    public function alta($param){
        $resp = false;
        $objMenuRol = $this->cargarObjeto($param);
        if ($objMenuRol != null && $objMenuRol->insertar()) {
            $resp = true;
        }
        return $resp;
    }

    /**
     * Elimina un registro de menuRol en la base de datos.
     * @param array $param Datos necesarios para identificar el registro a eliminar.
     * @return boolean Devuelve true si la eliminación fue exitosa, false en caso contrario.
     */
    public function baja($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objMenuRol = $this->cargarObjeto($param);
            if ($objMenuRol != null && $objMenuRol->eliminar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * Modifica un registro de menuRol en la base de datos.
     * @param array $param Datos necesarios para identificar y modificar el registro.
     * @return boolean Devuelve true si la modificación fue exitosa, false en caso contrario.
     */
    public function modificacion($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objMenuRol = $this->cargarObjeto($param);
            if ($objMenuRol != null && $objMenuRol->modificar($param)) {
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * Busca y devuelve registros de menuRol que cumplan con las condiciones en $param.
     * @param array $param Arreglo de condiciones para la búsqueda.
     * @return array Arreglo de resultados de menuRol.
     */
    public function buscar($param){
        $where = " true ";
        if ($param != NULL) {
            if (isset($param['idmenu'])) {
                $where .= " and menu.idmenu='" . $param['idmenu'] . "'";
            }
            if (isset($param['idrol'])) {
                $where .= " and menurol.idrol ='" . $param['idrol'] . "'";
            }
            if (isset($param['idpadre'])) {
                $where .= " and idpadre ='" . $param['idpadre'] . "'";
            }
        }
        $arreglo = MenuRol::listar($where);
        return $arreglo;
    }

    /**
     * Obtiene una lista de menús asociados a un rol específico.
     * @param int $rol ID del rol para el que se buscan los menús.
     * @return array Lista de menús asociados al rol.
     */
    public function menuesByIdRol($rol) {
        $menues = []; // Lista de menús final a devolver
        $respuesta = [];
    
        $param['idrol'] = $rol;
    
        // Buscar menús asociados al rol
        $objMenuObjRol = convert_array($this->buscar(['idrol' => $param['idrol']]));
    
        // Verifica si los resultados no son nulos y recorre el resultado
        if (!empty($objMenuObjRol)) {
            foreach ($objMenuObjRol as $objMenuRol) {
                $objMenu = new AbmMenu();
                $menu = convert_array($objMenu->buscar(['idmenu' => $objMenuRol['objmenu']]));
    
                if (!empty($menu)) {
                    foreach ($menu as $itemMenu) {
                        // Verificar si el menú no está ya en el array de menús por su ID
                        if (!in_array($itemMenu["idmenu"], array_column($menues, 'idmenu'))) {
                            $menues[] = $itemMenu; // Agregar solo el menú que no está incluido
                        }
                    }
                }
            }
    
            // Filtrar menús habilitados
            foreach ($menues as $objMenu) {
                if ($objMenu["medeshabilitado"] == NULL) {
                    $respuesta[] = [
                        "url" => BASE_URL . "/vista/" . $objMenu["medescripcion"],
                        "nombre" => $objMenu["menombre"]
                    ];
                }
            }
        }
    
        return $respuesta; 
    }
    
    public function tienePermiso($rol){
        $rol=$rol[0];
        $tienePermiso=false;
        $menus=$this->menuesByIdRol($rol);
        $url= "http://localhost";
        $url.=$_SERVER['REQUEST_URI']; // Obtiene la URL actual
        foreach($menus as $menu){
            $menu["url"]=trim($menu["url"]);
            if($menu['url']==$url){
                $tienePermiso=true;
            }
        }
        return $tienePermiso;

    }
}
?>
