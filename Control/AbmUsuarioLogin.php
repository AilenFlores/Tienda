<?php 
class AbmUsuarioLogin {

    public function existe($data){
        $resp = true;  
        // Buscamos si ya existe un usuario con el mismo nombre
        $objUsuarioExiste = convert_array($this->buscar(['usnombre' => $data['usNombre']]));
        if (!empty($objUsuarioExiste) && $objUsuarioExiste[0]['idUsuario'] != $data['idUsuario']) {
            // Si encontramos un usuario con el mismo nombre y un ID diferente, devolvemos false
            $resp = false;
        }
    
        return $resp;
    }
    

    /**
     * Método principal para manejar las acciones relacionadas con usuarios.
     * @param array $datos Arreglo de datos con la acción y parámetros necesarios.
     * @return bool Indica si la acción se realizó correctamente.
     */
    public function abm($datos){
        $resp = false;
        /* Edita el usuario desde el ABM de administrador */
        if ($datos['accion'] == 'editar') {
            $objUsuario = convert_array($this->buscar(['idusuario' => $datos['idUsuario']]));
            $datos["usPass"] = $objUsuario[0]["usPass"]; // Asigna la contraseña actual
            $this->modificacion($datos);
            $resp = true;
            if (isset($datos['usRol'])) { // Verifica si se enviaron roles
                $resp = $this->actualizarRoles($datos); // Actualizar roles del usuario
            } 
        }
        
        /* Edita el usuario desde el perfil del usuario */
        if ($datos['accion'] == 'editarActual') {
        $objUsuario = convert_array($this->buscar(['idusuario' => $datos['idUsuario']]));
        $datos["usPass"] = $objUsuario[0]["usPass"]; // Asigna la contraseña actual
        $this->modificacion($datos);  // Realiza la modificación
        $resp = true;
         return $resp; }
        
        /* Edita el contraseña ya sea desde el usuario o desde el abm de administrador */
        if($datos['accion']=='editarPass'){
         $idUsuario=$datos["idUsuarioPass"];
         $objUsuario = convert_array($this->buscar(['idusuario' => $idUsuario]));
         $objUsuario[0]["usPass"] = $datos["passNew"]; // Asigna la nueva contraseña
         $this->modificacion($objUsuario[0]);
         $resp = true;
        }

        /* Registra un nuevo usuario verificando que no existe un usuario con el mismo nombre */
        if ($datos['accion'] == 'nuevo') {
            $objUsuario = convert_array($this->buscar(['usnombre' => $datos['usNombre']]));
            if (!$objUsuario) { // Verifica si el usuario no existe, si existe no se registra
                $this->alta($datos);
                $objUsuario = convert_array($this->buscar(['usnombre' => $datos['usNombre']]));
                if (isset($objUsuario[0])) {
                    $resp = $this->agregarRoles($datos, $objUsuario); // Agregar roles al usuario
                }
            }
        }
        /* Cambia el estado de habilitado a deshabilitado */    
        if($datos['accion']=='borrar'){
            if($this->baja($datos)){
                $resp = true;
            }
        }

        /* Cambia el estado de deshabilitado a habilitado */
        if ($datos['accion'] == 'habilitar') {
            $this->habilitar($datos);
            $resp = true;
        }
        
        return $resp;
    }

    /**
     * Agrega roles a un usuario nuevo o existente.
     * @param array $datos Datos del usuario y roles.
     * @param array $objUsuario Objeto de usuario recién creado o buscado.
     * @return bool Indica si los roles se agregaron correctamente.
     */
    public function agregarRoles($datos, $objUsuario){
        $usuarioRol = new AbmUsuarioRol(); 
        $roles = $datos["usRol"] ?? []; 
        $resp = false;
        
        if (empty($roles)) {
            $roles[] = 1; // Asignar rol de cliente si no se especifican roles
        }

        foreach ($roles as $rol) {
            $param = [
                'idrol' => $rol,
                'idusuario' => $objUsuario[0]["idUsuario"]
            ];
            $usuarioRol->alta($param);
            $resp = true;
        }
        return $resp;
    }

    /**
     * Actualiza los roles del usuario existente, eliminando y agregando según se necesite.
     * @param array $datos Datos del usuario con roles actuales.
     * @return bool Indica si la actualización fue exitosa.
     */
    public function actualizarRoles($datos){
        $resp = false;
        $usuarioRol = new AbmUsuarioRol();
        $roles = $datos["usRol"] ?? []; 
        $rolActual = convert_array($usuarioRol->buscar(['idusuario' => $datos['idUsuario']]));

        foreach ($rolActual as $rolActualId) {
            if (!in_array($rolActualId, $roles)) {
                $param = [
                    'idrol' => (int)$rolActualId,
                    'idusuario' => (int)$datos['idUsuario']
                ];
                $usuarioRol->baja($param);
            }
        }

        foreach ($roles as $rol) {
            if (!in_array($rol, $rolActual)) { 
                $param = [
                    'idrol' => (int)$rol,
                    'idusuario' => (int)$datos['idUsuario']
                ];
                $usuarioRol->alta($param);
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * Crea un objeto Usuario utilizando los datos proporcionados.
     * @param array $param Datos de usuario.
     * @return Usuario|null Objeto de usuario o null si faltan datos requeridos.
     */
    private function cargarObjeto($param) {
        $obj = null;
        if (array_key_exists('usNombre', $param) &&
            array_key_exists('usPass', $param) &&
            array_key_exists('usMail', $param)) {
            $obj = new Usuario();
            $idusuario = array_key_exists('idUsuario', $param) ? $param['idUsuario'] : NULL;
            $obj->setear($idusuario, $param['usNombre'], $param['usPass'], $param['usMail'], NULL);
        }
        return $obj;
    }

    /**
     * Crea un objeto Usuario con clave primaria.
     * @param array $param Datos de clave primaria del usuario.
     * @return Usuario|null Objeto de usuario o null si falta la clave.
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        if (isset($param['idUsuario'])) {
            $obj = new Usuario();
            $obj->setear($param['idUsuario'], null, null, null, null);
        }
        return $obj;
    }

    /**
     * Verifica si los campos clave están establecidos en el arreglo.
     * @param array $param Arreglo de parámetros.
     * @return bool Verdadero si las claves están establecidas, falso de lo contrario.
     */
    private function seteadosCamposClaves($param){
        return isset($param['idUsuario']);
    }

    /**
     * Inserta un nuevo usuario en la base de datos.
     * @param array $param Datos del usuario.
     * @return bool Indica si la operación fue exitosa.
     */
    public function alta($param){
        $resp = false;
        $elObjtTabla = $this->cargarObjeto($param);
        if ($elObjtTabla != null && $elObjtTabla->insertar()) {
            $resp = true;
        }
        return $resp;
    }

    /**
     * Elimina (baja lógica) un usuario de la base de datos.
     * @param array $param Datos de clave primaria del usuario.
     * @return bool Indica si la operación fue exitosa.
     */
    public function baja($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $elObjtTabla = $this->cargarObjetoConClave($param);
            if ($elObjtTabla != null && $elObjtTabla->eliminar()){
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * Habilita un usuario en la base de datos.
     * @param array $param Datos de clave primaria del usuario.
     * @return bool Indica si la operación fue exitosa.
     */
    public function habilitar($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $elObjtTabla = $this->cargarObjetoConClave($param);
            if ($elObjtTabla != null && $elObjtTabla->habilitar()){
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * Modifica los datos de un usuario en la base de datos.
     * @param array $param Datos del usuario a modificar.
     * @return bool Indica si la operación fue exitosa.
     */
    public function modificacion($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $elObjtTabla = $this->cargarObjeto($param);
            if ($elObjtTabla != null && $elObjtTabla->modificar()){
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * Busca y lista usuarios según los parámetros especificados.
     * @param array $param Criterios de búsqueda.
     * @return array Arreglo de usuarios encontrados.
     */
    public function buscar($param){
        $where = " true ";
        if ($param != NULL){
            if  (isset($param['idusuario']))
                $where .= " and idusuario = " . $param['idusuario'];
            if  (isset($param['usnombre']))
                $where .= " and usnombre = '" . $param['usnombre'] . "'";
            if  (isset($param['uspass']))
                $where .= " and uspass = '" . $param['uspass'] . "'";
            if  (isset($param['usmail']))
                $where .= " and usmail = '" . $param['usmail'] . "'";
            if  (isset($param['usdeshabilitado']))
                $where .= " and usdeshabilitado = '" . $param['usdeshabilitado'] . "'";
        }
        $arreglo = Usuario::listar($where);  
        return $arreglo;
    }

    //Me lista las compras del usuario.
    public function listarCompraEstadoCliente() {
        $sesionActual = new Session();
        $usuario = $this->buscar(['usnombre' => $sesionActual -> getUsuario() -> getUsnombre(), 'uspass' => $sesionActual -> getUsuario() -> getUspass()]);
        $idUsuario = $usuario[0]->getIdusuario();
        $objAbmCompraEstado = new AbmCompraEstado();
        $listaCompraEstado = $objAbmCompraEstado->buscar(null);
        $arreglo = array();
        $arregloSalida = array();
        foreach ($listaCompraEstado as $elemento) {
            if ($elemento->getObjCompra()->getObjUsuario()->getIdusuario() == $idUsuario){
                $nuevoElemento['idcompraestado'] = $elemento->getIdcompraestado();
                $nuevoElemento['idcompra'] = $elemento->getObjCompra()->getIdcompra();
                $nuevoElemento['idcompraestadotipo'] = $elemento->getObjCompraEstadoTipo()->getIdcompraestadotipo();
                $nuevoElemento['cetdescripcion'] = $elemento->getObjCompraEstadoTipo()->getCetdescripcion();
                $nuevoElemento['cefechaini'] = $elemento->getCefechaini();
                $nuevoElemento['cefechafin'] = $elemento->getCefechafin();
                $nuevoElemento['usnombre'] = $elemento->getObjCompra()->getObjUsuario()->getUsnombre();
                array_push($arregloSalida, $nuevoElemento);
            }
        }
        return $arregloSalida;
    }


}
?>