<?php
class Producto {
    
    private $idproducto;
    private $pronombre;
    private $prodetalle;
    private $procantstock;
    private $proimporte;
    private $prodeshabilitado;
    private $proimg;
    private $mensajeoperacion;
    
    public function __construct(){
        
        $this->idproducto="";
        $this->pronombre="";
        $this->prodetalle="";
        $this->procantstock="";
        $this->proimporte="";
        $this->prodeshabilitado= NULL;
        $this->proimg="";
        $this->mensajeoperacion="";
        
    }
    
    public function setear($idproducto, $pronombre, $prodetalle, $procantstock, $proimporte, $proimg,$prodeshabilitado){
        $this->setIdproducto($idproducto);
        $this->setPronombre($pronombre);
        $this->setProdetalle($prodetalle);
        $this->setProcantstock($procantstock);
        $this->setProimporte($proimporte);
        $this->setProimg($proimg);
        $this->setProdeshabilitado($prodeshabilitado);
        
    }
    
    // METODOS DE ACCESO GET
    
    public function getIdproducto(){
        return $this->idproducto;
    }
    
    public function getPronombre(){
        return $this->pronombre;
    }
    
    public function getProdetalle(){
        return $this->prodetalle;
    }
    
    public function getProcantstock(){
        return $this->procantstock;
    }
    
    
    public function getProimporte(){
        return $this->proimporte;
    }
    
    public function getProimg(){
        return $this->proimg;
    }

    public function getmensajeoperacion(){
        return $this->mensajeoperacion;
    }

    public function getProdeshabilitado(){
        return $this->prodeshabilitado;
    }
    
    
    // METODOS DE ACCESO SET
    
    public function setIdproducto($valor){
        $this->idproducto = $valor;
    }
    
    public function setPronombre($valor){
        $this->pronombre = $valor;
    }
    
    public function setProdetalle($valor){
        $this->prodetalle = $valor;
    }
    
    public function setProcantstock($valor){
        $this->procantstock = $valor;
    }
    
    
    public function setProimporte($valor){
        $this->proimporte= $valor;
    }

    public function setProimg($valor){
        $this->proimg = $valor;
    }

    public function setProdeshabilitado($valor){
        $this->prodeshabilitado=$valor;
    }
    
    public function setmensajeoperacion($valor){
        $this->mensajeoperacion = $valor;
    }

    public function habilitar(){
        $resp = false;
        $base=new bdcarritocompras();
        $param="";
        $this->setProdeshabilitado($param);
        $sql = "UPDATE producto SET prodeshabilitado = NULL"; // Asegúrate de usar NULL sin comillas
        $sql.= " WHERE idproducto='".$this->getIdproducto()."'";
        //echo $sql;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("usuario->eliminar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("usuario->eliminar: ".$base->getError());
        }
        return $resp;
    }
    
    
    public function cargar(){
        $resp = false;
        $base=new bdcarritocompras();
        $sql="SELECT * FROM producto WHERE idproducto= ". $this->getIdproducto();
        //echo $sql;
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $this->setear($row['idproducto'], $row['pronombre'], $row['prodetalle'], $row['procantstock'],$row['proimporte'],$row["proimg"] ,$row["prodeshabilitado"]);     
                }
            }
        } else {
            $this->setmensajeoperacion("producto->listar: ".$base->getError());
        }
        return $resp;
    }
    
    public function insertar() {
        $resp = false;
        $base = new bdcarritocompras();
        $sql = "INSERT INTO producto (pronombre, prodetalle, procantstock, proimporte, proimg ,prodeshabilitado)  
                VALUES (
                    '" . $this->getPronombre() . "', 
                    '" . $this->getProdetalle() . "', 
                    '" . $this->getProcantstock() . "', 
                    '" . $this->getProimporte() . "', 
                    '" . $this->getProimg() . "',
                    NULL
                );";

        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setIdProducto($elid);
                $resp = true;
            } else {
                $this->setmensajeoperacion("producto->insertar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("producto->insertar: " . $base->getError());
        }
        return $resp;
    }
    
    
    public function modificar(){
        $resp = false;
        $base = new bdcarritocompras();
       $sql = "UPDATE producto SET 
       pronombre = '" . $this->getPronombre() . "',
       prodetalle = '" . $this->getProdetalle() . "',
       procantstock = '" . $this->getProcantstock() . "',
       proimporte = '" . $this->getProimporte() . "',  -- Agregar coma aquí
       proimg = '" . $this->getProimg() . "' 
       WHERE idproducto = " . $this->getIdproducto();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("producto->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("producto->modificar: " . $base->getError());
        }
    
        return $resp;
    }
    
    


    public function eliminar(){
        $resp = false;
        $base=new bdcarritocompras();
        $param=date("Y-m-d H:i:s");
        $this->setProdeshabilitado($param);
        $sql="UPDATE producto SET prodeshabilitado ='". $this->getProdeshabilitado()."'";
        $sql.= " WHERE idproducto='".$this->getIdproducto()."'";
        //echo $sql;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("producto->eliminar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("producto->eliminar: ".$base->getError());
        }
        return $resp;
    }
    
    public static function listar($parametro=""){
        $arreglo = array();
        $base=new bdcarritocompras();
        $sql="SELECT * FROM producto ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                while ($row = $base->Registro()){
                    
                    $obj = new Producto();
                    $obj->setear($row['idproducto'], $row['pronombre'], $row['prodetalle'], $row['procantstock'], $row['proimporte'], $row["proimg"], $row["prodeshabilitado"]);
                    array_push($arreglo, $obj);
                }
            }
        } else {
                $this->setmensajeoperacion("persona->listar: ".$base->getError());
        }
        return $arreglo;
    }
    
}