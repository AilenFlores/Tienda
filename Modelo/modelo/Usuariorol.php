<?php

    class UsuarioRol {

        private $objUsuario;
        private $objRol;
        private $mensajeoperacion;

        public function __construct() {
            $this -> objUsuario = new Usuario();
            $this -> objRol = new Rol();
            $this -> mensajeoperacion = "";
        }

        public function setear($objUsuarioS, $objRolS) {
            $this -> setObjUsuario($objUsuarioS);
            $this -> setObjRol($objRolS);
        }

        public function getObjUsuario() {
            return $this -> objUsuario;
        }
        public function setObjUsuario($nuevoObjUsuario) {
            $this -> objUsuario = $nuevoObjUsuario;
        }

        public function getObjRol() {
            return $this -> objRol;
        }
        public function setObjRol($nuevoObjRol) {
            $this -> objRol = $nuevoObjRol;
        }

        public function getmensajeoperacion() {
            return $this -> mensajeoperacion;
        }
        public function setmensajeoperacion($nuevomensajeoperacion) {
            $this -> mensajeoperacion = $nuevomensajeoperacion;
        }

        public function cargar() {
            $respuesta = false;
            $base = new BaseDatos();
            $sql = "SELECT * FROM usuariorol WHERE idusuario = " . $this->getObjUsuario()->getIdusuario() . " AND idrol = " . $this->getObjRol()->getIdrol();
            if ($base -> Iniciar()) {
                $res = $base -> Ejecutar($sql);
                if ($res > -1) {
                    if ($res > 0) {
                        $row = $base -> Registro();
                        $objUsuarioS = new Usuario();
                        $objUsuarioS->setIdusuario($row["idusuario"]);
                        $objUsuarioS->cargar();
                        $objRolS = new Rol();
                        $objRolS->setIdrol($row["idrol"]);
                        $objRolS->cargar();
                        $this -> setear($objUsuarioS, $objRolS);
                        $respuesta = true;
                    }
                }
            } else {
                $this -> setmensajeoperacion("UsuarioRol->listar: " . $base -> getError());
            }
            return $respuesta;
        }

        public function insertar() {
            $resp = false;
            $base = new BaseDatos();
            $sql = "INSERT INTO usuariorol (idusuario, idrol)
                VALUES (" . $this -> getObjUsuario()->getIdusuario() .
                "," . $this -> getObjRol()->getIdrol() . ")";
            if ($base->Iniciar()) {
                if ($base->Ejecutar($sql)) {
                    $resp = true;
                } else {
                    $this->setmensajeoperacion("UsuarioRol->insertar: " . $base->getError());
                }
            } else {
                $this->setmensajeoperacion("UsuarioRol->insertar: " . $base->getError());
            }
            return $resp;
        }

        public function modificar() {
            $respuesta = false;
            $base = new BaseDatos();
            $sql = "UPDATE usuariorol 
            SET idrol = " . $this -> getObjRol() -> getIdrol() . 
            " WHERE idusuario = " . $this -> getObjUsuario() -> getIdusuario();
            if ($base -> Iniciar()){
                if ($base -> Ejecutar($sql)){
                    $respuesta = true;
                } else {
                    $this -> setmensajeoperacion("usuariorol->modificar: " . $base -> getError());
                }
            } else {
                $this -> setmensajeoperacion("usuariorol->modificar: " . $base -> getError());
            }
            return $respuesta;
        }

        public function eliminar() {
            $respuesta = false;
            $base = new BaseDatos();
            $sql = "DELETE FROM usuariorol WHERE idusuario = " . $this->getObjUsuario()->getIdusuario() . " AND idrol = " . $this->getObjRol()->getIdrol();
            if ($base -> Iniciar()){
                if ($base -> Ejecutar($sql)){
                    $respuesta = true;
                } else {
                    $this->setmensajeoperacion("UsuarioRol->eliminar: " . $base -> getError());
                }
            } else {
                $this->setmensajeoperacion("UsuarioRol->eliminar: " . $base -> getError());
            }
            return $respuesta;
        }

        public function listar($parametro = "") { 
            $arreglo = array();
            $base = new BaseDatos();
            $sql = "SELECT * FROM usuariorol ";
            if ($parametro != "") {
                $sql .= 'WHERE ' . $parametro;
            }
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    while ($row = $base->Registro()) {
                        $obj = new UsuarioRol();
                        $objUsuarioS = new Usuario();
                        $objUsuarioS->setIdusuario($row["idusuario"]);
                        $objUsuarioS->cargar();
                        $objRolS = new Rol();
                        $objRolS->setIdrol($row["idrol"]);
                        $objRolS->cargar();
                        $obj->setear($objUsuarioS, $objRolS);
                        array_push($arreglo, $obj);
                    }
                }
            } else {
                $this->setmensajeoperacion("UsuarioRol->listar: " . $base->getError());
            }
            return $arreglo;
        }


    }

?>