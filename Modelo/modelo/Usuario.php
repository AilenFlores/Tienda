<?php

    class Usuario {

        private $idusuario;
        private $usnombre;
        private $uspass;
        private $usmail;
        private $usdeshabilitado;
        private $mensajeoperacion;

        public function __construct() {
            $this -> idusuario = null;
            $this -> usnombre = "";
            $this -> uspass = null;
            $this -> usmail = "";
            $this -> usdeshabilitado = null;
            $this -> mensajeoperacion = "";
        }

        public function setear($idusuarioS, $usnombreS, $uspassS, $usmailS, $usdeshabilitadoS) {
            $this -> setIdusuario($idusuarioS);
            $this -> setUsnombre($usnombreS);
            $this -> setUspass($uspassS);
            $this -> setUsmail($usmailS);
            $this -> setUsdeshabilitado($usdeshabilitadoS);
        }

        public function getIdusuario() {
            return $this -> idusuario;
        }
        public function setIdusuario($nuevoIdusuario) {
            $this -> idusuario = $nuevoIdusuario;
        }

        public function getUsnombre() {
            return $this -> usnombre;
        }
        public function setUsnombre($nuevoUsnombre) {
            $this -> usnombre = $nuevoUsnombre;
        }

        public function getUspass() {
            return $this -> uspass;
        }
        public function setUspass($nuevoUspass) {
            $this -> uspass = $nuevoUspass;
        }

        public function getUsmail() {
            return $this -> usmail;
        }
        public function setUsmail($nuevoUsmail) {
            $this -> usmail = $nuevoUsmail;
        }

        public function getUsdeshabilitado() {
            return $this -> usdeshabilitado;
        }
        public function setUsdeshabilitado($nuevoUsdeshabilitado) {
            $this -> usdeshabilitado = $nuevoUsdeshabilitado;
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
            $sql = "SELECT * FROM usuario WHERE idusuario = " . $this->getIdusuario();
            if ($base -> Iniciar()) {
                $res = $base -> Ejecutar($sql);
                if ($res > -1) {
                    if ($res > 0) {
                        $row = $base -> Registro();
                        $this -> setear($row["idusuario"], $row["usnombre"], $row["uspass"], $row["usmail"], $row["usdeshabilitado"]);
                        $respuesta = true;
                    }
                }
            } else {
                $this -> setmensajeoperacion("usuario->listar: " . $base -> getError());
            }
            return $respuesta;
        }

        public function insertar() {
            $respuesta = false;
            $base = new BaseDatos();
            if ($this -> getUsdeshabilitado() == null) {
                $usDeshabilitado = "', NULL)";
            } else {
                $usDeshabilitado = "','" . $this -> getUsdeshabilitado() . "')";
            }
            $sql = "INSERT INTO usuario (usnombre, uspass, usmail, usdeshabilitado) 
            VALUES ('" . $this -> getUsnombre() .
                "','" . $this -> getUspass() . 
                "','" . $this -> getUsmail() .
                $usDeshabilitado; 
            if ($base->Iniciar()){
                if ($elid = $base -> Ejecutar($sql)){
                    $this -> setIdusuario($elid);
                    $respuesta = true;
                } else {
                    $this -> setmensajeoperacion("usuario->insertar: " . $base -> getError());
                }
            } else {
                $this -> setmensajeoperacion("usuario->insertar: " . $base -> getError());
            }
            return $respuesta;
        }

        public function modificar() {
            $respuesta = false;
            $base = new BaseDatos();
            if ($this -> getUsdeshabilitado() == null) {
                $usDeshabilitado = "', usdeshabilitado = NULL";
            } else {
                $usDeshabilitado = "', usdeshabilitado = '" . $this -> getUsdeshabilitado() . "'";
            }
            $sql = "UPDATE usuario 
            SET usnombre = '" . $this -> getUsnombre() . 
            "', uspass = '" . $this -> getUspass() . 
            "', usmail = '" . $this -> getUsmail() .
            $usDeshabilitado . 
            " WHERE idusuario = " . $this -> getIdusuario();
            if ($base -> Iniciar()){
                if ($base -> Ejecutar($sql)){
                    $respuesta = true;
                } else {
                    $this -> setmensajeoperacion("usuario->modificar: " . $base -> getError());
                }
            } else {
                $this -> setmensajeoperacion("usuario->modificar: " . $base -> getError());
            }
            return $respuesta;
        }

        public function cambiarEstado() {
            $respuesta = false;
            $this -> cargar();
            date_default_timezone_set('America/Argentina/Cordoba');
            if ($this->getUsdeshabilitado() == null){
                $fechaBaja = date('Y-m-d H:i:s');
                $this -> setUsdeshabilitado($fechaBaja);
            } else {
                $this->setUsdeshabilitado(null);
            }
            if ($this -> modificar()) {
                $respuesta = true;
            }
            return $respuesta;
        }

        public function listar($parametro = "") {
            $arreglo = array();
            $base = new BaseDatos();
            $sql = "SELECT * FROM usuario ";
            if ($parametro != ""){
                $sql .= "WHERE " . $parametro;
            }
            $respuesta = $base -> Ejecutar($sql);
            if ($respuesta > -1){
                if ($respuesta > 0){
                    while ($row = $base -> Registro()){
                        $obj = new Usuario();
                        $obj -> setear($row["idusuario"], $row["usnombre"], $row["uspass"], $row["usmail"], $row["usdeshabilitado"]);
                        array_push($arreglo, $obj);
                    }
                }
            } else {
                $this->setmensajeoperacion("usuario->listar: " . $base -> getError());
            }
            return $arreglo;
        }

    }

?>