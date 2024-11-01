<?php 
class Rol {

    private $idRol;
    private $roDescripcion;
    private $mensajeoperacion;

    public function __construct(){
        $this->idRol="";
        $this->roDescripcion="";
        $this->mensajeoperacion ="";
    }

    public function setear($idRol, $roDescripcion)    {
        $this->setIdRol($idRol);
        $this->setRoDescripcion($roDescripcion);
    }

    public function getIdRol(){
        return $this->idRol;
    }

    public function setIdRol($valor){
        $this->idRol = $valor;
    }

    public function getRoDescripcion(){
        return $this->roDescripcion;
    }

    public function setRoDescripcion($valor){
        $this->roDescripcion = $valor;
    }

    public function getmensajeoperacion(){
        return $this->mensajeoperacion;
    }

    public function setmensajeoperacion($valor){
        $this->mensajeoperacion = $valor;
    }

    public function cargar(){
        $resp = false;
        $base=new bdcarritocompras();
        $sql="SELECT * FROM rol WHERE idRol = ".$this->getIdRol();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                if ($row2 = $base->Registro()) {
                    $this->setear($row2['idrol'], $row2['rodescripcion']);
                    $resp = true;
                }
            } else {
                $this->setmensajeoperacion("Rol->cargar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Rol->cargar: ".$base->getError());
        }
        return $resp;
    }

    public function insertar(){
        $resp = false;
        $base=new bdcarritocompras();
        $sql="INSERT INTO rol(roDescripcion)  VALUES('".$this->getRoDescripcion()."');";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setIdRol($elid);
                $resp = true;
            } else {
                $this->setmensajeoperacion("Rol->insertar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Rol->insertar: ".$base->getError());
        }
        return $resp;
    }

    public function modificar(){
        $resp = false;
        $base=new bdcarritocompras();
        $sql="UPDATE rol SET roDescripcion='".$this->getRoDescripcion()."' WHERE idRol=".$this->getIdRol();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("Rol->modificar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Rol->modificar: ".$base->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $base=new bdcarritocompras();
        $sql="DELETE FROM rol WHERE idRol=".$this->getIdRol();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("Rol->eliminar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Rol->eliminar: ".$base->getError());
        }
        return $resp;
    }

    public static function listar($parametro=""){
        $arreglo = array();
        $base=new bdcarritocompras();
        $sql="SELECT * FROM rol ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res>-1) {
            if ($res>0) {
                while ($row2 = $base->Registro()){
                    $obj = new Rol();
                    $obj->setear($row2['idrol'], $row2['rodescripcion']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setmensajeoperacion("Rol->listar: ".$base->getError());
        }
        return $arreglo;
    }

    public function __toString(){
        return "IdRol: ".$this->getIdRol(). " RoDescripcion: ".$this->getRoDescripcion();
    }

}
?>