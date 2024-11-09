<?php

    class CompraEstado {

        private $idcompraestado;
        private $objCompra;
        private $objCompraEstadoTipo;
        private $cefechaini;
        private $cefechafin;
        private $mensajeoperacion;

        public function __construct() {
            $this -> idcompraestado = null;
            $this -> objCompra = new Compra();
            $this -> objCompraEstadoTipo = new CompraEstadoTipo();
            $this -> cefechaini = null;
            $this -> cefechafin = null;
            $this -> mensajeoperacion = "";
        }

        public function setear($idcompraestadoS, $objCompraS, $objCompraEstadoTipoS, $cefechainiS, $cefechafinS) {
            $this -> setIdcompraestado($idcompraestadoS);
            $this -> setObjCompra($objCompraS);
            $this -> setObjCompraEstadoTipo($objCompraEstadoTipoS);
            $this -> setCefechaini($cefechainiS);
            $this -> setCefechafin($cefechafinS);
        }

        public function getIdcompraestado() {
            return $this -> idcompraestado;
        }
        public function setIdcompraestado($nuevoIdcompraestado) {
            $this -> idcompraestado = $nuevoIdcompraestado;
        }

        public function getObjCompra() {
            return $this -> objCompra;
        }
        public function setObjCompra($nuevoObjCompra) {
            $this -> objCompra = $nuevoObjCompra;
        }

        public function getObjCompraEstadoTipo() {
            return $this -> objCompraEstadoTipo;
        }
        public function setObjCompraEstadoTipo($nuevoObjCompraEstadoTipo) {
            $this -> objCompraEstadoTipo = $nuevoObjCompraEstadoTipo;
        }

        public function getCefechaini() {
            return $this -> cefechaini;
        }
        public function setCefechaini($nuevoCefechaini) {
            $this -> cefechaini = $nuevoCefechaini;
        }

        public function getCefechafin() {
            return $this -> cefechafin;
        }
        public function setCefechafin($nuevoCefechafin) {
            $this -> cefechafin = $nuevoCefechafin;
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
            $sql = "SELECT * FROM compraestado WHERE idcompraestado = " . $this->getIdcompraestado();
            if ($base -> Iniciar()) {
                $res = $base -> Ejecutar($sql);
                if ($res > -1) {
                    if ($res > 0) {
                        $row = $base -> Registro();
                        $objCompra = new Compra();
                        $objCompra->setIdcompra($row["idcompra"]);
                        $objCompra->cargar();
                        $objCompraEstadoTipo = new CompraEstadoTipo();
                        $objCompraEstadoTipo->setIdcompraestadotipo($row["idcompraestadotipo"]);
                        $objCompraEstadoTipo->cargar();
                        $this -> setear($row["idcompraestado"], $objCompra, $objCompraEstadoTipo, $row["cefechaini"], $row["cefechafin"]);
                        $respuesta = true;
                    }
                }
            } else {
                $this -> setmensajeoperacion("CompraEstado->listar: " . $base -> getError());
            }
            return $respuesta;
        }

        public function insertar() {
            $respuesta = false;
            $base = new BaseDatos();
            if ($this -> getCefechaini() == null) {
                $ceFechaIni = " NULL, ";
            } else {
                $ceFechaIni = " '".$this -> getCefechaini()."', ";
            }
            if ($this -> getCefechafin() == null) {
                $ceFechaFin = " NULL)";
            } else {
                $ceFechaFin = " '".$this -> getCefechafin()."')";
            }
            $sql = "INSERT INTO compraestado (idcompra, idcompraestadotipo, cefechaini, cefechafin) 
            VALUES (" . $this->getObjCompra()->getIdcompra() . " , " .
                $this -> getObjCompraEstadoTipo()->getIdcompraestadotipo() . " , " .
                $ceFechaIni . $ceFechaFin;
            if ($base->Iniciar()){
                if ($elid = $base -> Ejecutar($sql)){
                    $this -> setIdcompraestado($elid);
                    $respuesta = true;
                } else {
                    $this -> setmensajeoperacion("CompraEstado->insertar: " . $base -> getError());
                }
            } else {
                $this -> setmensajeoperacion("CompraEstado->insertar: " . $base -> getError());
            }
            return $respuesta;
        }

        public function modificar() {
            $respuesta = false;
            $base = new BaseDatos();
            if ($this -> getCefechaini() == null) {
                $ceFechaIni = " cefechaini = NULL";
            } else {
                $ceFechaIni = " cefechaini = '" . $this -> getCefechaini() . "'";
            }
            if ($this -> getCefechafin() == null) {
                $ceFechaFin = " cefechafin = NULL";
            } else {
                $ceFechaFin = " cefechafin = '" . $this -> getCefechafin() . "'";
            }
            $sql = "UPDATE compraestado 
            SET idcompra = " . $this->getObjCompra()->getIdcompra() . 
            ", idcompraestadotipo = " . $this -> getObjCompraEstadoTipo()->getIdcompraestadotipo() . 
            ", " . $ceFechaIni . " , " . $ceFechaFin .
            " WHERE idcompraestado = " . $this -> getIdcompraestado();
            if ($base -> Iniciar()){
                if ($base -> Ejecutar($sql)){
                    $respuesta = true;
                } else {
                    $this -> setmensajeoperacion("CompraEstado->modificar: " . $base -> getError());
                }
            } else {
                $this -> setmensajeoperacion("CompraEstado->modificar: " . $base -> getError());
            }
            return $respuesta;
        }

        public function eliminar() {
            $respuesta = false;
            $base = new BaseDatos();
            $sql = "DELETE FROM compraestado WHERE idcompraestado = " . $this -> getIdcompraestado();
            if ($base -> Iniciar()){
                if ($base -> Ejecutar($sql)){
                    $respuesta = true;
                } else {
                    $this->setmensajeoperacion("CompraEstado->eliminar: " . $base -> getError());
                }
            } else {
                $this->setmensajeoperacion("CompraEstado->eliminar: " . $base -> getError());
            }
            return $respuesta;
        }

        public function listar($parametro = "") {
            $arreglo = array();
            $base = new BaseDatos();
            $sql = "SELECT * FROM compraestado ";
            if ($parametro != ""){
                $sql .= "WHERE " . $parametro;
            }
            $respuesta = $base -> Ejecutar($sql);
            if ($respuesta > -1){
                if ($respuesta > 0){
                    while ($row = $base -> Registro()){
                        $obj = new CompraEstado();
                        $objCompra = new Compra();
                        $objCompra->setIdcompra($row["idcompra"]);
                        $objCompra->cargar();
                        $objCompraEstadoTipo = new CompraEstadoTipo();
                        $objCompraEstadoTipo->setIdcompraestadotipo($row["idcompraestadotipo"]);
                        $objCompraEstadoTipo->cargar();
                        $obj -> setear($row["idcompraestado"], $objCompra, $objCompraEstadoTipo, $row["cefechaini"], $row["cefechafin"]);
                        array_push($arreglo, $obj);
                    }
                }
            } else {
                $this->setmensajeoperacion("CompraEstado->listar: " . $base -> getError());
            }
            return $arreglo;
        }

    }

?>