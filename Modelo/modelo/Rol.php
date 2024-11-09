<?php

    class Rol {

        private $idrol;
        private $rodescripcion;
        private $mensajeoperacion;

        public function __construct() {
            $this -> idrol = null;
            $this -> rodescripcion = "";
            $this -> mensajeoperacion = "";
        }

        public function setear($idrolS, $rodescripcionS) {
            $this -> setIdrol($idrolS);
            $this -> setRodescripcion($rodescripcionS);
        }

        public function getIdrol() {
            return $this -> idrol;
        }
        public function setIdrol($nuevoIdrol) {
            $this -> idrol = $nuevoIdrol;
        }

        public function getRodescripcion() {
            return $this -> rodescripcion;
        }
        public function setRodescripcion($nuevaRodescripcion) {
            $this -> rodescripcion = $nuevaRodescripcion;
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
            $sql = "SELECT * FROM rol WHERE idrol = " . $this->getIdrol();
            if ($base -> Iniciar()) {
                $res = $base -> Ejecutar($sql);
                if ($res > -1) {
                    if ($res > 0) {
                        $row = $base -> Registro();
                        $this -> setear($row["idrol"], $row["rodescripcion"]);
                        $respuesta = true;
                    }
                }
            } else {
                $this -> setmensajeoperacion("Rol->listar: " . $base -> getError());
            }
            return $respuesta;
        }

        public function insertar() {
            $respuesta = false;
            $base = new BaseDatos();
            $sql = "INSERT INTO rol (rodescripcion) 
            VALUES ('" . $this -> getRodescripcion() . "')";
            if ($base->Iniciar()){
                if ($elid = $base -> Ejecutar($sql)){
                    $this -> setIdrol($elid);
                    $respuesta = true;
                } else {
                    $this -> setmensajeoperacion("Rol->insertar: " . $base -> getError());
                }
            } else {
                $this -> setmensajeoperacion("Rol->insertar: " . $base -> getError());
            }
            return $respuesta;
        }

        public function modificar() {
            $respuesta = false;
            $base = new BaseDatos();
            $sql = "UPDATE rol 
            SET rodescripcion = '" . $this -> getRodescripcion() .
            "' WHERE idrol = " . $this -> getIdrol();
            if ($base -> Iniciar()){
                if ($base -> Ejecutar($sql)){
                    $respuesta = true;
                } else {
                    $this -> setmensajeoperacion("Rol->modificar: " . $base -> getError());
                }
            } else {
                $this -> setmensajeoperacion("Rol->modificar: " . $base -> getError());
            }
            return $respuesta;
        }

        public function eliminar() {
            $respuesta = false;
            $base = new BaseDatos();
            $sql = "DELETE FROM rol WHERE idrol = " . $this -> getIdrol();
            if ($base -> Iniciar()){
                if ($base -> Ejecutar($sql)){
                    $respuesta = true;
                } else {
                    $this->setmensajeoperacion("Rol->eliminar: " . $base -> getError());
                }
            } else {
                $this->setmensajeoperacion("Rol->eliminar: " . $base -> getError());
            }
            return $respuesta;
        }

        public function listar($parametro = "") {
            $arreglo = array();
            $base = new BaseDatos();
            $sql = "SELECT * FROM rol ";
            if ($parametro != ""){
                $sql .= "WHERE " . $parametro;
            }
            $respuesta = $base -> Ejecutar($sql);
            if ($respuesta > -1){
                if ($respuesta > 0){
                    while ($row = $base -> Registro()){
                        $obj = new Rol();
                        $obj -> setear($row["idrol"], $row["rodescripcion"]);
                        array_push($arreglo, $obj);
                    }
                }
            } else {
                $this->setmensajeoperacion("Rol->listar: " . $base -> getError());
            }
            return $arreglo;
        }

    }

?>