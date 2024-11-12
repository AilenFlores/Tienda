<?php 
class AbmUsuarioLogin {

    public function abm($datos){
        $resp = false;
        if ($datos['accion'] == 'editar') {
            $objUsuario = convert_array($this->buscar(['idusuario' => $datos['idUsuario']]));
            $datos["usPass"] = $objUsuario[0]["usPass"]; // Asigna la contraseña actual
            $this->modificacion($datos);
            $resp = true;
             if (isset($datos['usRol'])) { // Verifica si se enviaron roles
            $resp = $this->actualizarRoles($datos); // Actualizar roles del usuario
            } 
        }
        
        if ($datos['accion'] == 'editarActual') {
            $objUsuario = convert_array($this->buscar(['idusuario' => $datos['idUsuario']]));
            $datos["usPass"] = $objUsuario[0]["usPass"]; // Asigna la contraseña actual
            $this->modificacion($datos);
            $resp = true;
            session_start();
            $_SESSION['usnombre'] = $datos['usNombre']; // Actualizar nombre de usuario en la sesión
        }

        if($datos['accion']=='editarPass'){
            $objUsuario = convert_array($this->buscar(['idusuario' => $datos['idUsuarioPass']]));
            $objUsuario[0]["usPass"] = $datos["passNew"]; // Encripta la nueva contraseña
            $this->modificacion($objUsuario[0]);
            $resp = true;
        }
        

       // Accion nuevo
        if ($datos['accion'] == 'nuevo') {
            $objUsuario = convert_array($this->buscar(['usnombre' => $datos['usNombre']]));
            if (!$objUsuario){ // Verifica si el usuario no existe, si existe no se registra
                    $this->alta($datos);
                    $objUsuario = convert_array($this->buscar(['usnombre' => $datos['usNombre']]));
                    if (isset($objUsuario[0])) {
                        $resp=$this->agregarRoles($datos,$objUsuario); // Agregar roles al usuario
                    }
            }
        }
        // Accion Deshabilitar 
        if($datos['accion']=='borrar'){
            if($this->baja($datos)){
                $resp =true;
            }
        }
        //Accion Habilitar
        if ($datos['accion'] == 'habilitar') {
            $this->habilitar($datos) ;
            $resp = true;
        }
        
        return $resp;
    }

    public function agregarRoles($datos,$objUsuario){
        $usuarioRol = new AbmUsuarioRol(); 
        $roles = $datos["usRol"] ?? []; 
        $resp = false;
        // Si no hay roles, asignar el rol de cliente
        if (empty($roles)) {
            $roles[] = 1; }
        // Iterar sobre los roles y crear la relación
        foreach ($roles as $rol) {
            $param = [ 'idrol' => $rol, // Asignar el rol para usuarios 
                        'idusuario' => $objUsuario[0]["idUsuario"]];
            $usuarioRol->alta($param);
            $resp = true; // Establecer a true si se añade el rol
            }
            return $resp;
        }

        public function actualizarRoles($datos){
            $resp = false;
            $usuarioRol = new AbmUsuarioRol();
            $roles = $datos["usRol"] ?? []; 
            $rolActual =convert_array( $usuarioRol->buscar(['idusuario' => $datos['idUsuario']]));
            // Eliminar roles que ya no están seleccionados en `$roles`
            foreach ($rolActual as $rolActualId) {
                if (!in_array($rolActualId, $roles)) {
                    $param = [
                        'idrol' => (int)$rolActualId, 
                        'idusuario' => (int)$datos['idUsuario']];
                        $usuarioRol->baja($param);
                    }
                }
                // Agregar roles nuevos que no estén en `$rolActual`
                foreach ($roles as $rol) {
                    if (!in_array($rol, $rolActual)) { 
                        $param = [
                            'idrol' => (int)$rol,
                            'idusuario' => (int)$datos['idUsuario']];
                            $usuarioRol->alta($param);
                            $resp=true;
                        }
                    }
                    return $resp;
                }
    
        



     

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Usuario
     */
    private function cargarObjeto($param) {
        $obj = null;
        // Verifica si las claves necesarias están presentes
        if (array_key_exists('usNombre', $param) &&
            array_key_exists('usPass', $param) &&
            array_key_exists('usMail', $param)) {
            $obj = new Usuario();
            // Si 'idusuario' está presente, lo usa; de lo contrario, se establece como NULL
            $idusuario = array_key_exists('idUsuario', $param) ? $param['idUsuario'] : NULL;
            $obj->setear($idusuario, $param['usNombre'], $param['usPass'], $param['usMail'], NULL);
        }
        return $obj;
    }
    

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return Usuario
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        if( isset($param['idUsuario']) ){
            $obj = new Usuario();
            $obj->setear($param['idUsuario'], null, null, null, null);
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
        if (isset($param['idUsuario']))
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
     * permite habilitar un objeto 
     * @param array $param
     * @return boolean
     */
    public function habilitar($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $elObjtTabla = $this->cargarObjetoConClave($param);
            if ($elObjtTabla!=null and $elObjtTabla->habilitar()){
                $resp = true;
            }
        }
        
        return $resp;
    }
    /**
     * permite modificar un objeto
     * @param array $param
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
            if  (isset($param['idusuario']))
                $where.=" and idusuario =".$param['idusuario'];
            if  (isset($param['usnombre']))
                 $where.=" and usnombre ='".$param['usnombre']."'";
            if  (isset($param['uspass']))
                 $where.=" and uspass ='".$param['uspass']."'";
            if  (isset($param['usmail']))
                 $where.=" and usmail ='".$param['usmail']."'";
            if  (isset($param['usdeshabilitado']))
                 $where.=" and usdeshabilitado ='".$param['usdeshabilitado']."'";
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