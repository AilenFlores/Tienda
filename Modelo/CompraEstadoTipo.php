<?php

    class CompraEstadoTipo {

        private $idcompraestadotipo;
        private $cetdescripcion;
        private $cetdetalle;
        private $mensajeoperacion;

        public function __construct() {
            $this -> idcompraestadotipo = null;
            $this -> cetdescripcion = "";
            $this -> cetdetalle = "";
            $this -> mensajeoperacion = "";
        }

        public function setear($idcompraestadotipoS, $cetdescripcionS, $cetdetalleS) {
            $this -> setIdcompraestadotipo($idcompraestadotipoS);
            $this -> setCetdescripcion($cetdescripcionS);
            $this -> setCetdetalle($cetdetalleS);
        }

        public function getIdcompraestadotipo() {
            return $this -> idcompraestadotipo;
        }
        public function setIdcompraestadotipo($nuevoIdcompraestadotipo) {
            $this -> idcompraestadotipo = $nuevoIdcompraestadotipo;
        }

        public function getCetdescripcion() {
            return $this -> cetdescripcion;
        }
        public function setCetdescripcion($nuevoCetdescripcion) {
            $this -> cetdescripcion = $nuevoCetdescripcion;
        }

        public function getCetdetalle() {
            return $this -> cetdetalle;
        }
        public function setCetdetalle($nuevoCetdetalle) {
            $this -> cetdetalle = $nuevoCetdetalle;
        }

        public function getmensajeoperacion() {
            return $this -> mensajeoperacion;
        }
        public function setmensajeoperacion($nuevomensajeoperacion) {
            $this -> mensajeoperacion = $nuevomensajeoperacion;
        }

        public function cargar() {
            $respuesta = false;
            $base = new bdcarritocompras();
            $sql = "SELECT * FROM compraestadotipo WHERE idcompraestadotipo = " . $this->getIdcompraestadotipo();
            if ($base -> Iniciar()) {
                $res = $base -> Ejecutar($sql);
                if ($res > -1) {
                    if ($res > 0) {
                        $row = $base -> Registro();
                        $this -> setear($row["idcompraestadotipo"], $row["cetdescripcion"], $row["cetdetalle"]);
                        $respuesta = true;
                    }
                }
            } else {
                $this -> setmensajeoperacion("CompraEstadoTipo->listar: " . $base -> getError());
            }
            return $respuesta;
        }

        public function insertar() {
            $respuesta = false;
            $base = new bdcarritocompras();
            $sql = "INSERT INTO compraestadotipo (idcompraestadotipo, cetdescripcion, cetdetalle) 
            VALUES (" . $this -> getIdcompraestadotipo() .
                ",'" . $this -> getCetdescripcion() . 
                "','" . $this -> getCetdetalle() . "')";
            if ($base->Iniciar()){
                if ($elid = $base -> Ejecutar($sql)){
                    //$this -> setIdcompraestadotipo($elid);
                    $respuesta = true;
                } else {
                    $this -> setmensajeoperacion("CompraEstadoTipo->insertar: " . $base -> getError());
                }
            } else {
                $this -> setmensajeoperacion("CompraEstadoTipo->insertar: " . $base -> getError());
            }
            return $respuesta;
        }

        public function modificar() {
            $respuesta = false;
            $base = new bdcarritocompras();
            $sql = "UPDATE compraestadotipo 
            SET cetdescripcion = '" . $this -> getCetdescripcion() . 
            "', cetdetalle = '" . $this -> getCetdetalle() .
            "' WHERE idcompraestadotipo = " . $this -> getIdcompraestadotipo();
            if ($base -> Iniciar()){
                if ($base -> Ejecutar($sql)){
                    $respuesta = true;
                } else {
                    $this -> setmensajeoperacion("CompraEstadoTipo->modificar: " . $base -> getError());
                }
            } else {
                $this -> setmensajeoperacion("CompraEstadoTipo->modificar: " . $base -> getError());
            }
            return $respuesta;
        }

        public function eliminar() {
            $respuesta = false;
            $base = new bdcarritocompras();
            $sql = "DELETE FROM compraestadotipo WHERE idcompraestadotipo = " . $this -> getIdcompraestadotipo();
            if ($base -> Iniciar()){
                if ($base -> Ejecutar($sql)){
                    $respuesta = true;
                } else {
                    $this->setmensajeoperacion("CompraEstadoTipo->eliminar: " . $base -> getError());
                }
            } else {
                $this->setmensajeoperacion("CompraEstadoTipo->eliminar: " . $base -> getError());
            }
            return $respuesta;
        }

        public function listar($parametro = "") {
            $arreglo = array();
            $base = new bdcarritocompras();
            $sql = "SELECT * FROM compraestadotipo ";
            if ($parametro != ""){
                $sql .= "WHERE " . $parametro;
            }
            $respuesta = $base -> Ejecutar($sql);
            if ($respuesta > -1){
                if ($respuesta > 0){
                    while ($row = $base -> Registro()){
                        $obj = new CompraEstadoTipo();
                        $obj -> setear($row["idcompraestadotipo"], $row["cetdescripcion"], $row["cetdetalle"]);
                        array_push($arreglo, $obj);
                    }
                }
            } else {
                $this->setmensajeoperacion("CompraEstadoTipo->listar: " . $base -> getError());
            }
            return $arreglo;
        }

    }

?>