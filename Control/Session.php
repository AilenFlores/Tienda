<?php
class Session {
    private $objUsuario;
    private $listaRoles;
    private $mensajeoperacion;
    
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    
        $this->objUsuario = null;
        $this->listaRoles = [];
        $this->mensajeoperacion = "";
    }


    public function getObjUsuario() {
        return $this->objUsuario;
    }

    public function setObjUsuario($objUsuario) {
        $this->objUsuario = $objUsuario;
    }

    public function getListaRoles() {
        return $this->listaRoles;
    }

    public function setListaRoles($listaRoles) {
        $this->listaRoles = $listaRoles;
    }

    public function getMensajeoperacion() {
        return $this->mensajeoperacion;
    }

    public function setMensajeoperacion($mensajeoperacion) {
        $this->mensajeoperacion = $mensajeoperacion;
    }

    public function iniciar($usu, $pass) {
        $resp = false;
        $abmUsuario = new AbmUsuarioLogin();
        // Condición que asegura que el usuario esté habilitado
        $where = ['usnombre' => $usu, 'uspass' => $pass, 'usdeshabilitado' => null];
        $listaUsuarios = $abmUsuario->buscar($where);
        if (count($listaUsuarios) > 0) {
            $estado = $listaUsuarios[0]->getUsdeshabilitado();
            if ($estado === null) { // Comprobamos si realmente está habilitado
                $_SESSION['idusuario'] = $listaUsuarios[0]->getIdUsuario();
                $_SESSION['usnombre'] = $listaUsuarios[0]->getUsnombre();
                $_SESSION['roles'] = $this->getRol();
                $resp = true;
            }
        }
        return $resp;
    }
    

    public function validar() {
        $inicia = false;
        if (isset($_SESSION['idusuario']) && $this->activa()) {
            $inicia = true;
        }
        return $inicia;
    }

    public function activa() {
        $activa = false;
        if (session_status() === PHP_SESSION_ACTIVE) {
            $activa = true;
        }
        return $activa;
    }

    public function getUsuario() {
        $usuarioLog = null; // Inicializamos la variable
        if ($this->validar()) {
            $abmUsuario = new AbmUsuarioLogin();
            $where = ['usnombre' => $_SESSION['usnombre'], 'idusuario' => $_SESSION['idusuario']];
            $listaUsuarios = $abmUsuario->buscar($where);
            if (count($listaUsuarios) >= 1) {
                $usuarioLog = $listaUsuarios[0];
                $this->setObjUsuario($usuarioLog);
            }
        }
        return $usuarioLog;
    }

    public function getRol() {
        $roles = []; // Inicializamos el array de IDs de roles
        if ($this->validar()) {
            $abmUsuarioRol = new AbmUsuarioRol();
            $param['idusuario'] = $_SESSION['idusuario'];
            $listaRolesUsu = $abmUsuarioRol->buscar($param);
            foreach ($listaRolesUsu as $usuarioRol) {
                // Obtener el ID del rol
                $roles[] = $usuarioRol->getIdRol(); 
            }
        }
        $this->setListaRoles($roles);
        return $roles;
    }

    public function cerrar() {
        // Limpiar todas las variables de sesión
        $_SESSION = [];
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy(); // Destruir la sesión
        }
        return true;
    }
}
ob_end_flush(); // Limpiar el búfer de salida
?>