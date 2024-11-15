<?php

class AbmProducto {
    //Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
    
    public function abm($datos){
        $resp = false;
        if($datos['accion'] == 'editarImagen'){
            if(isset($datos['idproducto'])){
                $carpetaDestino = "../img/productos/";
                $nombreArchivo = $datos['idproducto'].".jpg";  // El nombre del archivo será el ID del producto
                $rutaTemporal = $_FILES['proimg']['tmp_name'];
                $rutaImagen = $carpetaDestino . basename($nombreArchivo);
                
                // Verifica si el archivo ya existe, si es así, lo elimina antes de subir el nuevo archivo
                if(file_exists($rutaImagen)) {
                    unlink($rutaImagen);  // Elimina la imagen anterior
                }
        
                // Mueve la nueva imagen al directorio de destino
                if(move_uploaded_file($rutaTemporal, $rutaImagen)){
                    $resp = true;
                } else {
                    $resp = false;  // Si hay un error al mover el archivo
                }
            }
        }
        

        if($datos['accion']=='editar'){
            $this->modificacion($datos);
                $resp = true;
        }
        if($datos['accion']=='borrar'){
            if($this->baja($datos)){
                $resp =true;
            }
        }
        if($datos['accion']=='nuevo'){
            if($this->alta($datos)){
            $nuevo=convert_array($this->buscar(null));
            $ultimoID=end($nuevo);
            $idProducto=($ultimoID['idproducto']);
            // Manejo de la carga de la imagen
            if (isset($datos['proimg']) && $datos['proimg']['error'] == 0) {
                 // Establece la carpeta donde se guardarán las imágenes
                 $carpetaDestino = "../img/productos/";
                 $nombreArchivo = $idProducto.".jpg"; // El nombre del archivo será el ID del producto
                 $rutaTemporal = $_FILES['proimg']['tmp_name'];
                 $rutaImagen = $carpetaDestino . basename($nombreArchivo);
                  move_uploaded_file($rutaTemporal, $rutaImagen);
                }       
                $resp =true;}}

        if ($datos['accion'] == 'habilitar') {
            $this->habilitar($datos) ;
            $resp = true;
        }
        return $resp;
    } 
    

        /**
     * permite habilitar un objeto 
     * @param array $param
     * @return boolean
     */
    public function habilitar($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $elObjtTabla = $this->cargarObjetoConClave($param);
            if ($elObjtTabla!=null and $elObjtTabla->habilitar()){
                $resp = true;
            }
        }
        return $resp;
    }

    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return object
     */
    
    public function cargarObjeto($param){
        $obj = null;
        if(array_key_exists('pronombre',$param) && array_key_exists('prodetalle',$param) && array_key_exists('procantstock',$param) && array_key_exists('proimporte', $param)){
            $obj = new Producto();
            $param["idproducto"] = array_key_exists('idproducto', $param) ? $param['idproducto'] : NULL;
            $obj->setear($param['idproducto'],$param['pronombre'], $param['prodetalle'], $param['procantstock'], $param['proimporte'], NULL);
        }
        return $obj;
    }
    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return object
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        if( isset($param['idproducto']) ){
            $obj = new Producto();
            $obj->setear($param['idproducto'],null, null, null, null, null);
            
        }
        return $obj;
    }
    
    
    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */
    
    private function seteadosCamposClaves($param){
        $resp = false;
        if (isset($param['idproducto'])) {
            $resp = true;
        }
            return $resp;
    }
    
    /**
     *
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        $elObjtProducto = $this->cargarObjeto($param);
        if ($elObjtProducto!=null and $elObjtProducto->insertar()){
            $resp = true;
        }
        return $resp;
    }
    
    /**
     * permite eliminar un objeto
     * @param array $param
     * @return boolean
     */
    
    public function baja($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $elObjtProducto = $this->cargarObjetoConClave($param);
            if ($elObjtProducto !=null and $elObjtProducto->eliminar()){
                $resp = true;
            }
        }
        return $resp;
    }
    
    /**
     * permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificacion($param){
        $resp = false;
            if ($this->seteadosCamposClaves($param)){
            $elObjtProducto = $this->cargarObjeto($param);
            if($elObjtProducto !=null and $elObjtProducto->modificar()){
            }
        }
        return $resp;
    }
    
    /**
     * permite buscar un objeto
     * @param array $param
     * @return boolean
     */
    
    public function buscar($param){
        $where = " true ";
        if ($param<>NULL){
            if  (isset($param['idproducto']))
            $where.=" and idproducto='".$param['idproducto']."'";
            if  (isset($param['pronombre']))
            $where.=" and pronombre ='".$param['pronombre']."'";
            if  (isset($param['prodetalle']))
            $where.=" and prodetalle ='".$param['prodetalle']."'";
            if  (isset($param['procantstock']))
            $where.=" and procantstock ='".$param['procantstock']."'";
            if  (isset($param['proimporte']))
            $where.=" and proimporte ='".$param['proimporte']."'";
            if  (isset($param['prodeshabilitado']))
            $where.=" and prodeshabilitado ='".$param['prodeshabilitado']."'";
        }
        
        $arreglo = Producto::listar($where);
        
        return $arreglo;
    }
    
}
?>