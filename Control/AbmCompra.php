<?php

    class AbmCompra{

        /**
         * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto.
         * @param array $param
         * @return Compra
         */
        private function cargarObjeto($param) {
            $obj = null;
            if (array_key_exists('idcompra',$param) and array_key_exists('cofecha',$param) and array_key_exists('idusuario',$param) and array_key_exists('metodo',$param)) {
                $obj = new Compra();
                $objUsuario = new Usuario();
                $objUsuario->setIdusuario($param["idusuario"]);
                $objUsuario->cargar();
                $obj -> setear($param['idcompra'], $param["cofecha"], $objUsuario, $param["metodo"]);
            }
            return $obj;
        }

        /**
         * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves.
         * @param array $param
         * @return Compra
         */
        private function cargarObjetoConClave($param) {
            $obj = null;
            if ( isset($param['idcompra'])) {
                $obj = new Compra();
                $obj -> setear($param["idcompra"], null, null, null);
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
            if (isset($param['idcompra'])) {
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
            $param['idcompra'] = null;
            $objCompra = $this->cargarObjeto($param);
            if ($objCompra != null and $objCompra->insertar()) {
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
                $objCompra = $this -> cargarObjetoConClave($param);
                if ($objCompra != null and $objCompra -> eliminar()) {
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
                $objCompra = $this -> cargarObjeto($param);
                if ($objCompra != null and $objCompra -> modificar()) {
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
                if (isset($param['idcompra'])) {
                    $where .= " and idcompra =" . $param['idcompra'];
                }
                if (isset($param['cofecha'])) {
                    $where .= " and cofecha ='" . $param['cofecha'] . "'";
                }
                if (isset($param['idusuario'])) {
                    $where .= " and idusuario =" . $param['idusuario'];
                }
                if (isset($param['metodo'])) {
                    $where .= " and metodo ='" . $param['metodo'] . "'";
                }
            }
            $objCompra = new Compra();
            $arreglo = $objCompra -> listar($where);
            return $arreglo;
        }

        public function agregarProductoACarrito($param) {
            if (isset($param['compra'])){
                $sesionActual = new Session();
                $objUsuario = $sesionActual -> getUsuario();
                //Busco compras agregadas al carrito por el usuario activo
                $arregloObjCompra = $this -> buscar(['idusuario' => $objUsuario->getIdusuario(),'metodo' => 'carrito']);
                if (!empty($arregloObjCompra)){
                    if (count($arregloObjCompra) == 1){  //Solo puede haber 1 carrito activo
                        $objAbmCompraItem = new AbmCompraItem();
                        //Chequeo si en la compra ya se habia encargado el mismo producto
                        $arregloCompraItem = $objAbmCompraItem -> buscar(['idcompra' => $arregloObjCompra[0] -> getIdcompra()]);
                        $carritoEncontrado = false;
                        if (!empty($arregloCompraItem)){
                            foreach($arregloCompraItem as $item){
                                if ($item -> getObjProducto() -> getIdproducto() == $param['idproducto']){
                                    $carritoEncontrado = true;
                                    //Controlo stock
                                    $cantidadSuma = ($item -> getCicantidad()) + ($param['cantidad']);
                                    if ($cantidadSuma <= ($item -> getObjProducto() -> getProcantstock())){
                                        $objAbmCompraItem = new AbmCompraItem();
                                        $cantidadFinal = $objAbmCompraItem -> modificacion(['idcompraitem' => $item -> getIdcompraitem(), 'idproducto' => $param['idproducto'], 'idcompra' => $arregloObjCompra[0] -> getIdcompra(), 'cicantidad' => $cantidadSuma]);
                                        if ($cantidadFinal){
                                            $redireccion = 'Location:../../paginas/carrito.php';
                                        }else{
                                            $redireccion = "Location:../../paginas/productos.php?idproducto=" . $param['idproducto'] . "&error=1";
                                        }
                                    }else{
                                        $redireccion = "Location:../../paginas/productos.php?idproducto=" . $param['idproducto'] . "&error=2";
                                    }
                                }
                            }
                        }
                        if (!$carritoEncontrado){
                            $itemAgregado = $objAbmCompraItem -> alta(['idproducto' => $param['idproducto'], 'idcompra' => $arregloObjCompra[0] -> getIdcompra(),'cicantidad' => $param['cantidad']]);
                            if ($itemAgregado){
                                $redireccion = 'Location:../../paginas/carrito.php';
                            }else{
    
                                $redireccion = "Location:../../paginas/productos.php?idproducto=" . $param['idproducto'] . "&error=1";
                            }
                        }
                        
                    }else{
                        $redireccion = "Location:../../paginas/productos.php?idproducto=" . $param['idproducto'] . "&error=1";
                    }
                }else{  //Si no hay carritos activos inicio uno.
                    $compraAgregada = $this -> alta(['idusuario' => $objUsuario->getIdusuario(), 'cofecha' => $date = date('Y-m-d H:i:s'),  'metodo' => 'carrito']);
                    $arregloObjCompra = $this -> buscar(['idusuario' => $objUsuario->getIdusuario(), 'cofecha' => $date = date('Y-m-d H:i:s'), 'metodo' => 'carrito']);
                    if ($compraAgregada){
                        $objAbmCompraItem = new AbmCompraItem();
                        $itemAgregado = $objAbmCompraItem -> alta(['idproducto' => $param['idproducto'], 'idcompra' => $arregloObjCompra[0] -> getIdcompra(), 'cicantidad' => $param['cantidad']]);
                        if ($itemAgregado){
                            $redireccion = 'Location:../../paginas/carrito.php';
                        }else{
                            $redireccion = "Location:../../paginas/productos.php?idproducto=" . $param['idproducto'] . "&error=1";
                        }
                    }else{
                        $redireccion = "Location:../../paginas/productos.php?idproducto=" . $param['idproducto'] . "&error=1";
                    }
                }
            }
            return $redireccion;
        }

        public function finalizarCompra($param) {
            $compraCargar = $this -> buscar(['idcompra' => $param['idcompra']]);
            $objAbmCompraItem = new AbmCompraitem();
            $arregloItemsCargar = $objAbmCompraItem -> buscar(['idcompra' => $param['idcompra']]);
            $objAbmProducto = new AbmProducto();
            $sinStock = false;
            foreach($arregloItemsCargar as $item){
                $productoCarga = $item -> getObjProducto();
                $cantidadDisponible = ($productoCarga -> getProcantstock())-($item -> getCicantidad());
                if ($cantidadDisponible < 0){
                    $sinStock = true;
                    //Elimino el producto sin stock del carrito
                    $objAbmCompraItem -> baja(['idcompraitem' => $item -> getIdcompraitem()]);
                    $this -> baja(['idcompra' => $param['idcompra']]);
                }
            }
            if (!$sinStock){
                //Cambio el metodo de compra de 'carrito' a 'normal' para que no se cargue en la tabla de carrito.
                $this -> modificacion(['idcompra' => $compraCargar[0] -> getIdcompra(),'cofecha' => $compraCargar[0] -> getCofecha(),'idusuario' => $compraCargar[0] -> getObjUsuario() -> getIdusuario(), 'metodo' => 'normal']);
                //Pongo la compra en estado 'iniciada'
                $objAbmCompraEstado = new AbmCompraestado();
                $resultadoCompra = $objAbmCompraEstado -> alta(['idcompra' => $param['idcompra'], 'idcompraestadotipo' => 1,'cefechaini' => date('Y-m-d H:i:s'), 'cefechafin' => NULL]);
                if ($resultadoCompra){
                    //Resto los items comprados del stock
                    foreach($arregloItemsCargar as $item){
                        $productoCarga = $item -> getObjProducto();
                        $cantidadFinal = ($productoCarga -> getProcantstock()) - ($item -> getCicantidad());
                        $objAbmProducto -> modificacion(['idproducto' => $productoCarga -> getIdproducto(), 'pronombre' => $productoCarga -> getPronombre(), 'prodetalle' => $productoCarga -> getProdetalle(), 'proprecio' => $productoCarga -> getProprecio(), 'prodeshabilitado' => $productoCarga -> getProdeshabilitado(), 'procantstock' => $cantidadFinal]);
                    }
                    $redireccion="Location:../../paginas/tiendaFinalizar.php?transaccion=exito";
                }else{
                    $redireccion="Location:../../paginas/tiendaFinalizar.php?transaccion=fallo";
                }
            }else{
                $redireccion = "Location:../../paginas/tiendaFinalizar.php?transaccion=stock";
            }
            return $redireccion;    
        }

        public function cancelarCompra() {
            $resp = false;
            $sesionActual = new Session();
            $objUsuario = $sesionActual -> getUsuario();
            $arregloObjCompra = $this -> buscar(['idusuario' => $objUsuario -> getIdusuario(), 'metodo' => 'carrito']);
            if (count($arregloObjCompra) == 1){
                $objAbmCompraItem = new AbmCompraItem();
                $items = $objAbmCompraItem -> buscar(['idcompra' => $arregloObjCompra[0] -> getIdcompra()]);
                if (!empty($items)){
                    foreach($items as $item){
                        $objAbmCompraItem -> baja(['idcompraitem' => $item -> getIdcompraitem()]);
                    }
                    $this -> baja(['idcompra'=>$arregloObjCompra[0] -> getIdcompra()]);
                    $resp = true;
                } else {
                    $this -> baja(['idcompra'=>$arregloObjCompra[0] -> getIdcompra()]);
                    $resp = true;
                }
            }
            return $resp;
        }

    }

?>