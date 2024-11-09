<?php

    class Menu {

        private $idmenu;
        private $menombre;
        private $medescripcion;
        private $objMenu;
        private $medeshabilitado;
        private $mensajeoperacion;

        public function __construct() {
            $this -> idmenu = null;
            $this -> menombre = "";
            $this -> medescripcion = "";
            $this -> objMenu = null;
            $this -> medeshabilitado = null;
            $this -> mensajeoperacion = "";
        }

        public function setear($idmenuS, $menombreS, $medescripcionS, $objMenuS, $medeshabilitadoS) {
            $this -> setIdmenu($idmenuS);
            $this -> setMenombre($menombreS);
            $this -> setMedescripcion($medescripcionS);
            $this -> setObjMenu($objMenuS);
            $this -> setMedeshabilitado($medeshabilitadoS);
        }

        public function getIdmenu() {
            return $this -> idmenu;
        }
        public function setIdmenu($nuevoIdmenu) {
            $this -> idmenu = $nuevoIdmenu;
        }

        public function getMenombre() {
            return $this -> menombre;
        }
        public function setMenombre($nuevoMenombre) {
            $this -> menombre = $nuevoMenombre;
        }

        public function getMedescripcion() {
            return $this -> medescripcion;
        }
        public function setMedescripcion($nuevoMedescripcion) {
            $this -> medescripcion = $nuevoMedescripcion;
        }

        public function getObjMenu() {
            return $this -> objMenu;
        }
        public function setObjMenu($nuevoObjMenu) {
            $this -> objMenu = $nuevoObjMenu;
        }

        public function getMedeshabilitado() {
            return $this -> medeshabilitado;
        }
        public function setMedeshabilitado($nuevoMedeshabilitado) {
            $this -> medeshabilitado = $nuevoMedeshabilitado;
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
            $sql = "SELECT * FROM menu WHERE idmenu = " . $this->getIdmenu();
            if ($base -> Iniciar()) {
                $res = $base -> Ejecutar($sql);
                if ($res > -1) {
                    if ($res > 0) {
                        $row = $base -> Registro();
                        if ($row["idpadre"] != null){
                            $objMenuPadre = new Menu();
                            $objMenuPadre->setIdmenu($row["idpadre"]);
                            $objMenuPadre->cargar();
                        } else {
                            $objMenuPadre = null;
                        }
                        $this -> setear($row["idmenu"], $row["menombre"], $row["medescripcion"], $objMenuPadre, $row["medeshabilitado"]);
                        $respuesta = true;
                    }
                }
            } else {
                $this -> setmensajeoperacion("Menu->listar: " . $base -> getError());
            }
            return $respuesta;
        }

        public function insertar() {
            $respuesta = false;
            $base = new BaseDatos();
            if ($this->getObjMenu() != null){
                $idPadre = $this->getObjMenu()->getIdmenu();
            } else {
                $idPadre = "null";
            }
            if ($this -> getMedeshabilitado() == null) {
                $meDeshabilitado = ", NULL)";
            } else {
                $meDeshabilitado = ", '" . $this -> getMedeshabilitado() . "')";
            }
            $sql = "INSERT INTO menu (menombre, medescripcion, idpadre, medeshabilitado) 
            VALUES ('" . $this -> getMenombre() .
                "','" . $this -> getMedescripcion() . 
                "'," . $idPadre .
                $meDeshabilitado;
            if ($base->Iniciar()){
                if ($elid = $base -> Ejecutar($sql)){
                    $this -> setIdmenu($elid);
                    $respuesta = true;
                } else {
                    $this -> setmensajeoperacion("Menu->insertar: " . $base -> getError());
                }
            } else {
                $this -> setmensajeoperacion("Menu->insertar: " . $base -> getError());
            }
            return $respuesta;
        }

        public function modificar() {
            $respuesta = false;
            $base = new BaseDatos();
            if ($this -> getMedeshabilitado() == null) {
                $meDeshabilitado = ", medeshabilitado = NULL";
            } else {
                $meDeshabilitado = ", medeshabilitado = '" . $this -> getMedeshabilitado() . "'";
            }
            if ($this->getObjMenu() != null){
                $idPadre = $this->getObjMenu()->getIdmenu();
            } else {
                $idPadre = "null";
            }
            $sql = "UPDATE menu 
            SET menombre = '" . $this -> getMenombre() . 
            "', medescripcion = '" . $this -> getMedescripcion() . 
            "', idpadre = " . $idPadre .
            $meDeshabilitado . 
            " WHERE idmenu = " . $this -> getIdmenu();
            if ($base -> Iniciar()){
                if ($base -> Ejecutar($sql)){
                    $respuesta = true;
                } else {
                    $this -> setmensajeoperacion("Menu->modificar: " . $base -> getError());
                }
            } else {
                $this -> setmensajeoperacion("Menu->modificar: " . $base -> getError());
            }
            return $respuesta;
        }

        public function cambiarEstado() {
            $respuesta = false;
            $this -> cargar();
            //date_default_timezone_set('America/Argentina/Cordoba');
            if ($this->getMedeshabilitado() == null){
                $fechaBaja = date('Y-m-d H:i:s');
                $this -> setMedeshabilitado($fechaBaja);
            } else {
                $this->setMedeshabilitado(null);
            }
            if ($this -> modificar()) {
                $respuesta = true;
            }
            return $respuesta;
        }

        public function listar($parametro = "") {
            $arreglo = array();
            $base = new BaseDatos();
            $sql = "SELECT * FROM menu ";
            if ($parametro != ""){
                $sql .= "WHERE " . $parametro;
            }
            $respuesta = $base -> Ejecutar($sql);
            if ($respuesta > -1){
                if ($respuesta > 0){
                    while ($row = $base -> Registro()){
                        $obj = new Menu();
                        if ($row["idpadre"] != null){
                            $objMenuPadre = new Menu();
                            $objMenuPadre->setIdmenu($row["idpadre"]);
                            $objMenuPadre->cargar();
                        } else {
                            $objMenuPadre = null;
                        }
                        $obj -> setear($row["idmenu"], $row["menombre"], $row["medescripcion"], $objMenuPadre, $row["medeshabilitado"]);
                        array_push($arreglo, $obj);
                    }
                }
            } else {
                $this->setmensajeoperacion("Menu->listar: " . $base -> getError());
            }
            return $arreglo;
        }

    }

?>