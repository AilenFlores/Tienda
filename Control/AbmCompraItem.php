<?php
    class AbmCompraItem {


        public function mostrarDetalles($idcompra) {
            // Obtención de datos
            $idcompra = $idcompra['idcompra'];
            $arregloItems = $this->buscar(['idcompra' => $idcompra]);
            // Preparación de la salida
            if (!empty($arregloItems)) {
                $totalCompra = 0;
                echo "<table class='table table-striped'>";
                echo "<thead><tr><th>Producto</th><th>Cantidad</th><th>Precio Unitario</th><th>Subtotal</th></tr></thead><tbody>";
                foreach ($arregloItems as $compraItem) {
                    $nombre = $compraItem->getObjProducto()->getPronombre();
                    $cantidad = $compraItem->getCicantidad();
                    $precioUnitario = $compraItem->getObjProducto()->getProimporte();
                    $subtotal = $cantidad * $precioUnitario;
                    $totalCompra += $subtotal;
                    // Mostrar fila de la tabla
                    echo "<tr>
                            <td>{$nombre}</td>
                            <td>{$cantidad}</td>
                            <td>\${$precioUnitario}</td>
                            <td>\${$subtotal}</td>
                          </tr>";
                }
                // Mostrar total
                echo "<tr class='fw-bold'><td colspan='3'>Total:</td><td>\${$totalCompra}</td></tr>";
                echo "</tbody></table>";
            } else {
                // Si no hay detalles
                echo "<p class='text-center'>No hay detalles disponibles para esta compra.</p>";
            }
        }
        

        /**
         * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto.
         * @param array $param
         * @return CompraItem
         */
        private function cargarObjeto($param) {
            $obj = null;
            if (array_key_exists('idcompraitem',$param) and array_key_exists('idproducto',$param) and array_key_exists('idcompra',$param) and array_key_exists('cicantidad',$param)) {
                $obj = new CompraItem();
                $objProducto = new Producto();
                $objProducto->setIdproducto($param["idproducto"]);
                $objProducto->cargar();
                $objCompra = new Compra();
                $objCompra->setIdcompra($param["idcompra"]);
                $objCompra->cargar();
                $obj -> setear($param['idcompraitem'], $objProducto, $objCompra, $param["cicantidad"]);
            }
            return $obj;
        }

        /**
         * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves.
         * @param array $param
         * @return CompraItem
         */
        private function cargarObjetoConClave($param) {
            $obj = null;
            if ( isset($param['idcompraitem']) ) {
                $obj = new CompraItem();
                $obj -> setear($param['idcompraitem'], null, null, null);
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
            if (isset($param['idcompraitem'])) {
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
            $param['idcompraitem'] = null;
            $objCompraItem = $this->cargarObjeto($param);
            if ($objCompraItem != null and $objCompraItem->insertar()) {
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
                $objCompraItem = $this -> cargarObjetoConClave($param);
                if ($objCompraItem != null and $objCompraItem -> eliminar()) {
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
                $objCompraItem = $this -> cargarObjeto($param);
                if ($objCompraItem != null and $objCompraItem -> modificar()) {
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
                if (isset($param['idcompraitem'])) {
                    $where .= " and idcompraitem =" . $param['idcompraitem'];
                }
                if (isset($param['idproducto'])) {
                    $where .= " and idproducto =" . $param['idproducto'];
                }
                if (isset($param['idcompra'])) {
                    $where .= " and idcompra =" . $param['idcompra'];
                }
                if (isset($param['cicantidad'])) {
                    $where .= " and cicantidad =" . $param['cicantidad'];
                }
            }
            $objCompraItem = new CompraItem();
            $arreglo = $objCompraItem -> listar($where);
            return $arreglo;
        }

        //Elimina un item de la compra y si no quedan mas items en la compra, elimina la compra.
        public function eliminarItemDeCompra($param)
{
    $arregloObjCompraItem = $this->buscar(['idcompraitem' => $param['idcompraitem']]);
    $idCompraActual = $arregloObjCompraItem[0]->getObjCompra()->getIdcompra();
    $this->baja(['idcompraitem' => $param['idcompraitem']]);
    $arregloObjCompraItem = $this->buscar(['idcompra' => $idCompraActual]);
    
    if ($arregloObjCompraItem == []) {
        $objAbmCompra = new AbmCompra();
        $objAbmCompra->baja(['idcompra' => $idCompraActual]);
    }
    
    return ['success' => true, 'message' => 'Ítem eliminado exitosamente.'];
}

        //Elimina la compra.
        public function eliminarCompraItem($param) {
            $arreglo["idcompra"] = $param["idcompra"];
            $arreglo1["idcompraitem"] = $param["idcompraitem"];
            $objAbmCompraEstado = new AbmCompraEstado();
            $listaCompraEstado = $objAbmCompraEstado->buscar(null);
            $estadoMasAvanzado = 0;
            for($i=0; $i < count($listaCompraEstado); $i++){
                if ($listaCompraEstado[$i]->getObjCompraEstadoTipo()->getIdcompraestadotipo() > $estadoMasAvanzado
                && $listaCompraEstado[$i]->getObjCompra()->getIdcompra() == $param["idcompra"]){
                    $estadoMasAvanzado = $listaCompraEstado[$i]->getObjCompraEstadoTipo()->getIdcompraestadotipo();
                }
            }
            if ($estadoMasAvanzado == 1){
                $objAbmCompraItem1 = new AbmCompraItem();
                $arregloObjCompraItem = $objAbmCompraItem1 -> buscar($arreglo1);
                $cantidadDevolver = $arregloObjCompraItem[0] -> getCicantidad();
                $objAbmProducto = new AbmProducto();
                $idProductoDevolver = $arregloObjCompraItem[0] -> getObjProducto() -> getIdproducto();
                $arregloObjProducto = $objAbmProducto -> buscar(['idproducto' => $idProductoDevolver]);
                $cantidadActual = $arregloObjProducto[0] -> getProcantstock();
                $nuevaCantidad = $cantidadActual + $cantidadDevolver;

                $productoModificado['idproducto'] = $idProductoDevolver;
                $productoModificado['pronombre'] = $arregloObjProducto[0] -> getPronombre();
                $productoModificado['prodetalle'] = $arregloObjProducto[0] -> getProdetalle();
                $productoModificado['procantstock'] = $nuevaCantidad;
                $productoModificado['proprecio'] = $arregloObjProducto[0] -> getProPrecio();
                $productoModificado['prodeshabilitado'] = $arregloObjProducto[0] -> getProdeshabilitado();
                if ($this->baja($arreglo1)){
                    if ($objAbmProducto -> modificacion($productoModificado)) {
                        $respuesta["respuesta"] = "La compraItem se dio de baja correctamente y se devolvieron los articulos al stock";
                    } else {
                        $respuesta["errorMsg"] = "No se pudo dar de baja la compraItem";
                    }
                } else {
                    $respuesta["errorMsg"] = "No se pudo dar de baja la compraItem";
                }
            } else {
                $respuesta["errorMsg"] = "Solo se pueden eliminar items cuando el estado de la compra es 'iniciada'";
            }
            return $respuesta;
        }

        public function listarCompraItem() {
            $listaCompraItem = $this->buscar(null);
            $arregloSalida = array(); 
            foreach ($listaCompraItem as $elemento) {
                if ($elemento -> getObjCompra() -> getMetodo() == 'normal') {
                    $nuevoElemento['idcompraitem'] = $elemento->getIdcompraitem();
                    $nuevoElemento['idproducto'] = $elemento->getObjProducto()->getIdproducto();
                    $nuevoElemento['pronombre'] = $elemento->getObjProducto()->getPronombre();
                    $nuevoElemento['cicantidad'] = $elemento->getCicantidad();
                    $nuevoElemento['idcompra'] = $elemento->getObjCompra()->getIdcompra();
                    $nuevoElemento['usnombre'] = $elemento->getObjCompra()->getObjUsuario()->getUsnombre();
                    array_push($arregloSalida, $nuevoElemento);
                }
            }
            return $arregloSalida;
        }
    }

?>