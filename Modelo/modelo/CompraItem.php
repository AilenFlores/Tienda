<?php

    class CompraItem {

        private $idcompraitem;
        private $objProducto;
        private $objCompra;
        private $cicantidad;
        private $mensajeoperacion;

        public function __construct() {
            $this -> idcompraitem = null;
            $this -> objProducto = new Producto();
            $this -> objCompra = new Compra();
            $this -> cicantidad = null;
            $this -> mensajeoperacion = "";
        }

        public function setear($idcompraitemS, $objProductoS, $objCompraS, $cicantidadS) {
            $this -> setIdcompraitem($idcompraitemS);
            $this -> setObjProducto($objProductoS);
            $this -> setObjCompra($objCompraS);
            $this -> setCicantidad($cicantidadS);
        }

        public function getIdcompraitem() {
            return $this -> idcompraitem;
        }
        public function setIdcompraitem($nuevoIdcompraitem) {
            $this -> idcompraitem = $nuevoIdcompraitem;
        }

        public function getObjProducto() {
            return $this -> objProducto;
        }
        public function setObjProducto($nuevoObjProducto) {
            $this -> objProducto = $nuevoObjProducto;
        }

        public function getObjCompra() {
            return $this -> objCompra;
        }
        public function setObjCompra($nuevoObjCompra) {
            $this -> objCompra = $nuevoObjCompra;
        }

        public function getCicantidad() {
            return $this -> cicantidad;
        }
        public function setCicantidad($nuevoCicantidad) {
            $this -> cicantidad = $nuevoCicantidad;
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
            $sql = "SELECT * FROM compraitem WHERE idcompraitem = " . $this->getIdcompraitem();
            if ($base -> Iniciar()) {
                $res = $base -> Ejecutar($sql);
                if ($res > -1) {
                    if ($res > 0) {
                        $row = $base -> Registro();
                        $objProducto = new Producto();
                        $objProducto->setIdproducto($row["idproducto"]);
                        $objProducto->cargar();
                        $objCompra = new Compra();
                        $objCompra->setIdcompra($row["idcompra"]);
                        $objCompra->cargar();
                        $this -> setear($row["idcompraitem"], $objProducto, $objCompra, $row["cicantidad"]);
                        $respuesta = true;
                    }
                }
            } else {
                $this -> setmensajeoperacion("CompraItem->listar: " . $base -> getError());
            }
            return $respuesta;
        }

        public function insertar() {
            $respuesta = false;
            $base = new BaseDatos();
            $sql = "INSERT INTO compraitem (idproducto, idcompra, cicantidad) 
            VALUES (" . $this->getObjProducto()->getIdproducto() . " , " .
                $this -> getObjCompra()->getIdcompra() . " , " .
                $this->getCicantidad() . ")";
            if ($base->Iniciar()){
                if ($elid = $base -> Ejecutar($sql)){
                    $this -> setIdcompraitem($elid);
                    $respuesta = true;
                } else {
                    $this -> setmensajeoperacion("CompraItem->insertar: " . $base -> getError());
                }
            } else {
                $this -> setmensajeoperacion("CompraItem->insertar: " . $base -> getError());
            }
            return $respuesta;
        }

        public function modificar() {
            $respuesta = false;
            $base = new BaseDatos();
            $sql = "UPDATE compraitem 
            SET idproducto = " . $this->getObjProducto()->getIdproducto() . 
            ", idcompra = " . $this -> getObjCompra()->getIdcompra() . 
            ", cicantidad = " . $this->getCicantidad() .
            " WHERE idcompraitem = " . $this -> getIdcompraitem();
            if ($base -> Iniciar()){
                if ($base -> Ejecutar($sql)){
                    $respuesta = true;
                } else {
                    $this -> setmensajeoperacion("CompraItem->modificar: " . $base -> getError());
                }
            } else {
                $this -> setmensajeoperacion("CompraItem->modificar: " . $base -> getError());
            }
            return $respuesta;
        }

        public function eliminar() {
            $respuesta = false;
            $base = new BaseDatos();
            $sql = "DELETE FROM compraitem WHERE idcompraitem = " . $this -> getIdcompraitem();
            if ($base -> Iniciar()){
                if ($base -> Ejecutar($sql)){
                    $respuesta = true;
                } else {
                    $this->setmensajeoperacion("CompraItem->eliminar: " . $base -> getError());
                }
            } else {
                $this->setmensajeoperacion("CompraItem->eliminar: " . $base -> getError());
            }
            return $respuesta;
        }

        public function listar($parametro = "") {
            $arreglo = array();
            $base = new BaseDatos();
            $sql = "SELECT * FROM compraitem ";
            if ($parametro != ""){
                $sql .= "WHERE " . $parametro;
            }
            $respuesta = $base -> Ejecutar($sql);
            if ($respuesta > -1){
                if ($respuesta > 0){
                    while ($row = $base -> Registro()){
                        $obj = new CompraItem();
                        $objProducto = new Producto();
                        $objProducto->setIdproducto($row["idproducto"]);
                        $objProducto->cargar();
                        $objCompra = new Compra();
                        $objCompra->setIdcompra($row["idcompra"]);
                        $objCompra->cargar();
                        $obj -> setear($row["idcompraitem"], $objProducto, $objCompra, $row["cicantidad"]);
                        array_push($arreglo, $obj);
                    }
                }
            } else {
                $this->setmensajeoperacion("CompraItem->listar: " . $base -> getError());
            }
            return $arreglo;
        }

    }

?>