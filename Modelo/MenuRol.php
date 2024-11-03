<?php
class MenuRol{
    private $objmenu;
    private $objrol;
    private $mensajeoperacion;
    
    public function __construct(){
        $this->objmenu="";
        $this->objrol="";
        $this->mensajeoperacion="";
        
    }
    
    public function setear($objmenu, $objRol){
        $this->setObjmenu($objmenu);
        $this->setObjrol($objRol);
    }
    
    // METODOS DE ACCESO GET
    
    public function getObjmenu(){
        return $this->objmenu;
    }
    
    public function getObjrol(){
        return $this->objrol;
    }
    
    public function getMensajeoperacion(){
        return $this->mensajeoperacion;
    }
    
    // METODOS DE ACCESO SET
    
    public function setObjmenu($valor){
        $this->objmenu = $valor;
    }
    
    public function setObjrol($valor){
        $this->objrol = $valor;
    }
    
    
    public function setMensajeoperacion($valor){
        $this->mensajeoperacion = $valor;
    }

    public function cargar(){
        $resp = false;
        $base=new bdcarritocompras();
        $sql="SELECT * FROM menu WHERE idmenu = ".$this->getObjmenu(). "AND idrol=". $this->getObjrol();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                if ($row2 = $base->Registro()) {
                    $this->setear($row2['idmenu'], $row2['idrol']);
                    $resp = true;
                }
            } else {
                $this->setmensajeoperacion("Usuario->cargar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Usuario->cargar: ".$base->getError());
        }
        return $resp;
    }
    
    
    public function insertar(){
        $resp = false;
        $base=new bdcarritocompras();
        $sql="INSERT INTO menurol (idmenu, idrol) VALUES ('".$this->getObjmenu()."','".$this->getObjrol()."');";
        //echo $sql;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeoperacion("menurol->insertar: ".$base->getError());
            }
        } else {
            $this->setMensajeoperacion("menurol->insertar: ".$base->getError());
        }
        return $resp;
    }
    
    public function modificar($param){
        $resp = false;
        $base=new bdcarritocompras();
        $sql=" UPDATE menurol SET ";
        $sql.=" idrol = ".$param['idrol'];
        $sql.=" WHERE idmenu =".$this->getObjmenu()." AND idrol =".$this->getObjrol();
        echo $sql;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
                
            } else {
                $this->setMensajeoperacion("menurol->modificar: ".$base->getError());
            }
        } else {
            $this->setMensajeoperacion("menurol->modificar: ".$base->getError());
        }
        return $resp;
    }
    
    
    public function eliminar(){
        $resp = false;
        $base=new bdcarritocompras();
        $sql="DELETE FROM menurol WHERE idmenu='". $this->getObjmenu()."' AND idrol='".$this->getObjrol()."'";
        //echo $sql;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeoperacion("menurol->eliminar: ".$base->getError());
            }
        } else {
            $this->setMensajeoperacion("menurol->eliminar: ".$base->getError());
        }
        return $resp;
    }
    
    public static function listar($parametro=""){
        $arreglo = array();
        $base=new bdcarritocompras();
        $sql="SELECT * FROM menurol INNER JOIN rol ON rol.idrol=menurol.idrol INNER JOIN menu ON menu.idmenu=menurol.idmenu  ";
        //echo $sql;
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                while ($row = $base->Registro()){
                    $obj= new MenuRol();
                    $obj->setear($row['idmenu'], $row['idrol']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
                 $this->setMensajeoperacion("menurol->listar: ".$base->getError());
        }
        return $arreglo;
    }
}