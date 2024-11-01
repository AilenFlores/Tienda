<?php
class usuarioRol {
    private $idUsuario;
    private $idRol;
    private $mensajeoperacion;

    public function __construct(){
        $this->idUsuario="";
        $this->idRol="";
        $this->mensajeoperacion ="";
    }

    public function setear($idUsuario, $idRol)    {
        $this->setIdUsuario($idUsuario);
        $this->setIdRol($idRol);
    }

    public function getIdUsuario(){
        return $this->idUsuario;
    }

    public function setIdUsuario($valor){
        $this->idUsuario = $valor;
    }

    public function getIdRol(){
        return $this->idRol;
    }

    public function setIdRol($valor){
        $this->idRol = $valor;
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
        $sql="SELECT * FROM usuarioRol WHERE idusuario = ".$this->getIdUsuario();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                if ($row2 = $base->Registro()) {
                    $this->setear($row2['idusuario'], $row2['idRol']);
                    $resp = true;
                }
            } else {
                $this->setmensajeoperacion("UsuarioRol->cargar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("UsuarioRol->cargar: ".$base->getError());
        }
        return $resp;
    }

    public function insertar(){
        $resp = false;
        $base=new bdcarritocompras();
        $sql="INSERT INTO usuarioRol(idusuario, idrol)  VALUES('".$this->getIdUsuario()."','".$this->getIdRol()."');";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setIdUsuario($elid);
                $resp = true;
            } else {
                $this->setmensajeoperacion("UsuarioRol->insertar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("UsuarioRol->insertar: ".$base->getError());
        }
        return $resp;
    }

    public function modificar(){
        $resp = false;
        $base=new bdcarritocompras();
        $sql="UPDATE usuarioRol SET idRol='".$this->getIdRol()."' WHERE idUsuario=".$this->getIdUsuario();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("UsuarioRol->modificar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("UsuarioRol->modificar: ".$base->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $base=new bdcarritocompras();
        $sql="DELETE FROM usuarioRol WHERE idUsuario=".$this->getIdUsuario();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("UsuarioRol->eliminar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("UsuarioRol->eliminar: ".$base->getError());
        }
        return $resp;
    }

    public static function listar($parametro=""){
        $arreglo = array();
        $base=new bdcarritocompras();
        $sql="SELECT * FROM usuarioRol ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res>-1) {
            if ($res>0) {
                while ($row2 = $base->Registro()){
                    $obj = new usuarioRol();
                    $obj->setear($row2['idusuario'], $row2['idrol']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setmensajeoperacion("UsuarioRol->listar: ".$base->getError());
        }
        return $arreglo;
    }

    
}
?>