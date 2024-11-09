<?php

    class AbmCompraEstadoTipo {

        /**
         * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto.
         * @param array $param
         * @return CompraEstadoTipo
         */
        private function cargarObjeto($param) {
            $obj = null;
            if (array_key_exists('idcompraestadotipo',$param) and array_key_exists('cetdescripcion',$param) and array_key_exists('cetdetalle',$param)) {
                $obj = new CompraEstadoTipo();
                $obj -> setear($param['idcompraestadotipo'], $param['cetdescripcion'], $param["cetdetalle"]);
            }
            return $obj;
        }

        /**
         * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves.
         * @param array $param
         * @return CompraEstadoTipo
         */
        private function cargarObjetoConClave($param) {
            $obj = null;
            if ( isset($param['idcompraestadotipo']) ) {
                $obj = new CompraEstadoTipo();
                $obj -> setear($param['idcompraestadotipo'], null, null);
            }
            return $obj;
        }

        /**
         * Corrobora que dentro del arreglo asociativo están seteados los campos claves.
         * @param array $param
         * @return boolean
         */
        private function seteadosCamposClaves($param) {
            $resp = false;
            if (isset($param['idcompraestadotipo'])) {
                $resp = true;
            }
            return $resp;
        }

        /**
         * Permite crear un objeto.
         * @param array $param
         */
        public function alta($param){
            $resp = false;
            $param['idcompraestadotipo'] = null;
            $objCompraEstadoTipo = $this->cargarObjeto($param);
            if ($objCompraEstadoTipo != null and $objCompraEstadoTipo->insertar()) {
                $resp = true;
            }
            return $resp;
        }

        /**
         * Permite eliminar un objeto.
         * @param array $param
         * @return boolean
         */
        public function baja($param) {
            $resp = false;
            if ($this -> seteadosCamposClaves($param)) {
                $objCompraEstadoTipo = $this -> cargarObjetoConClave($param);
                if ($objCompraEstadoTipo != null and $objCompraEstadoTipo -> eliminar()) {
                    $resp = true;
                }
            }
            return $resp;
        }

        /**
         * Permite modificar un objeto.
         * @param array $param
         * @return boolean
         */
        public function modificacion($param){
            $resp = false;
            if ($this -> seteadosCamposClaves($param)) {
                $objCompraEstadoTipo = $this -> cargarObjeto($param);
                if ($objCompraEstadoTipo != null and $objCompraEstadoTipo -> modificar()) {
                    $resp = true;
                }
            }
            return $resp;
        }

        /**
         * Permite buscar un objeto.
         * @param array $param
         * @return boolean
         */
        public function buscar($param) {
            $where = " true ";
            if ($param <> null) {
                if (isset($param['idcompraestadotipo'])) {
                    $where .= " and idcompraestadotipo =" . $param['idcompraestadotipo'];
                }
                if (isset($param['cetdescripcion'])) {
                    $where .= " and cetdescripcion ='" . $param['cetdescripcion'] . "'";
                }
                if (isset($param['cetdetalle'])) {
                    $where .= " and cetdetalle ='" . $param['cetdetalle'] . "'";
                }
            }
            $objCompraEstadoTipo = new CompraEstadoTipo();
            $arreglo = $objCompraEstadoTipo -> listar($where);
            return $arreglo;
        }
    }

?>