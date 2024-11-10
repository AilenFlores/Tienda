<?php
class AbmUsuarioRol {
    /**
     * Este método principal ejecuta una acción de alta, baja o modificación dependiendo del valor de 'accion' en $datos
     * @param array $datos Contiene los datos y la acción a realizar ('nuevo', 'editar', 'borrar')
     * @return boolean Devuelve true si la operación se realizó con éxito, false en caso contrario
     */
    public function abm($datos) {
        $resp = false;
        if ($datos['accion'] == 'editar') {
            if ($this->modificacion($datos)) {
                $resp = true;
            }
        }
        if ($datos['accion'] == 'borrar') {
            if ($this->baja($datos)) {
                $resp = true;
            }
        }
        if ($datos['accion'] == 'nuevo') {
            if ($this->alta($datos)) {
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * Busca y devuelve un arreglo de objetos Rol asociados a los IDs en el arreglo $roles
     * @param array $roles Arreglo con los IDs de roles a buscar
     * @return array Arreglo de objetos Rol encontrados
     */
    public function buscarRol($roles) {
        $abmRol = new abmRol();  
        foreach ($roles as $rol) {
            $objRolArray[] = convert_array($abmRol->buscar(['idRol' => $rol]));
        }
        return $objRolArray;
    }
    
    /**
     * Crea un objeto usuarioRol y lo carga con los valores de $param
     * @param array $param Arreglo con los datos necesarios para crear el objeto
     * @return usuarioRol|null Devuelve el objeto usuarioRol o null si no se cargó correctamente
     */
    private function cargarObjeto($param) {
        $obj = null;
        
        if (array_key_exists('idusuario', $param) && array_key_exists('idrol', $param)) {
            $obj = new usuarioRol();
            $obj->setear($param['idusuario'], $param['idrol']);
        }
        return $obj;
    }

    /**
     * Crea un objeto usuarioRol utilizando las claves primarias en $param
     * @param array $param Arreglo que contiene los valores clave del objeto usuarioRol
     * @return usuarioRol|null Devuelve el objeto usuarioRol o null si no se cargó correctamente
     */
    private function cargarObjetoConClave($param) {
        $obj = null;
        if (isset($param['idusuario']) && isset($param['idrol'])) {
            $obj = new usuarioRol();
            $obj->setear($param['idusuario'], $param['idrol']);
        }
        return $obj;
    }

    /**
     * Verifica que los campos claves (idusuario, idrol) estén definidos en el arreglo $param
     * @param array $param Arreglo a verificar
     * @return boolean Devuelve true si los campos claves están definidos, false en caso contrario
     */
    private function seteadosCamposClaves($param) {
        $resp = false;
        if (isset($param['idusuario']) && isset($param['idrol'])) {
            $resp = true;
        }
        return $resp;
    }

    /**
     * Inserta un nuevo registro de usuarioRol en la base de datos
     * @param array $param Datos necesarios para crear el registro
     * @return boolean Devuelve true si la inserción fue exitosa, false en caso contrario
     */
    public function alta($param) {
        $resp = false;
        $elObjtTabla = $this->cargarObjeto($param);
        if ($elObjtTabla != null && $elObjtTabla->insertar()) {
            $resp = true;
        }
        return $resp;
    }

    /**
     * Elimina un registro de usuarioRol en la base de datos
     * @param array $param Datos necesarios para identificar el registro a eliminar
     * @return boolean Devuelve true si la eliminación fue exitosa, false en caso contrario
     */
    public function baja($param) {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $elObjtTabla = $this->cargarObjetoConClave($param);
            if ($elObjtTabla != null && $elObjtTabla->eliminar()) {
                $resp = true;
            }
        }
        
        return $resp;
    }

    /**
     * Modifica un registro de usuarioRol en la base de datos
     * @param array $param Datos necesarios para identificar y modificar el registro
     * @return boolean Devuelve true si la modificación fue exitosa, false en caso contrario
     */
    public function modificacion($param) {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $elObjtTabla = $this->cargarObjeto($param);
            if ($elObjtTabla != null && $elObjtTabla->modificar()) {
                $resp = true;
            }
        }
        
        return $resp;
    }

    /**
     * Busca y devuelve registros de usuarioRol que cumplan con las condiciones en $param
     * @param array $param Arreglo de condiciones para la búsqueda
     * @return array Arreglo de resultados de usuarioRol
     */
    public function buscar($param) {
        $where = " true ";
        if ($param != NULL) {
            if (isset($param['idusuario'])) {
                $where .= " and idUsuario=" . $param['idusuario'];
            }
            if (isset($param['idRol'])) {
                $where .= " and idRol=" . $param['idRol'];
            }
        }
        $arreglo = usuarioRol::listar($where);
        return $arreglo;
    }
}
?>
