<?php
class Usuario {
    private $idUsuario;
    private $usNombre;
    private $usPass;
    private $usMail;
    private $usDeshabilitado;
    private $mensajeoperacion;

    public function __construct(){
        $this->idUsuario="";
        $this->usNombre="";
        $this->usPass="";
        $this->usMail="";
        $this->usDeshabilitado="";
        $this->mensajeoperacion ="";
    }

    public function setear($idUsuario, $usNombre, $usPass, $usMail, $usDeshabilitado)    {
        $this->setIdUsuario($idUsuario);
        $this->setUsNombre($usNombre);
        $this->setUsPass($usPass);
        $this->setUsMail($usMail);
        $this->setUsDeshabilitado($usDeshabilitado);
    }

    public function getIdUsuario(){
        return $this->idUsuario;
    }

    public function setIdUsuario($valor){
        $this->idUsuario = $valor;
    }

    public function getUsNombre(){
        return $this->usNombre;
    }

    public function setUsNombre($valor){
        $this->usNombre = $valor;
    }

    public function getUsPass(){
        return $this->usPass;
    }

    public function setUsPass($valor){
        $this->usPass = $valor;
    }

    public function getUsMail(){
        return $this->usMail;
    }

    public function setUsMail($valor){
        $this->usMail = $valor;
    }

    public function getUsDeshabilitado(){
        return $this->usDeshabilitado;
    }

    public function setUsDeshabilitado($valor){
        $this->usDeshabilitado = $valor;
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
        $sql="SELECT * FROM usuario WHERE idusuario = ".$this->getIdUsuario();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                if ($row2 = $base->Registro()) {
                    $this->setear($row2['idusuario'], $row2['usnombre'], $row2['uspass'], $row2['usmail'], $row2['usdeshabilitado']);
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
        $base = new bdcarritocompras();
        $sql = "INSERT INTO usuario (usnombre, uspass, usmail) VALUES ('" . $this->getUsNombre() . "','" . md5($this->getUsPass()) . "','" . $this->getUsMail() . "');";
        //echo $sql;
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setIdUsuario($elid);
                $resp = true;
            } else {
                $this->setmensajeoperacion("usuario->insertar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("usuario->insertar: " . $base->getError());
        }
        return $resp;
    }
    

    public function modificar(){
        $resp = false;
        $base = new bdcarritocompras();
        $sql = " UPDATE usuario SET 
        usnombre = '" . $this->getUsNombre() . "', 
        uspass = '" .  md5($this->getUsPass()) . "', 
        usmail = '" . $this->getUsMail() . "' 
        WHERE 
        idusuario = " . $this->getIdUsuario();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("usuario->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("usuario->modificar: " . $base->getError());
        }
    
        return $resp;
    }

    
    public function eliminar(){
        $resp = false;
        $base=new bdcarritocompras();
        $param=date("Y-m-d H:i:s");
        $this->setUsDeshabilitado($param);
        $sql="UPDATE usuario SET usdeshabilitado='".$this->getUsDeshabilitado()."'";
        $sql.= " WHERE idusuario='".$this->getIdUsuario()."'";
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
    
    public function habilitar(){
        $resp = false;
        $base=new bdcarritocompras();
        $param="";
        $this->setUsDeshabilitado($param);
        $sql = "UPDATE usuario SET usdeshabilitado = NULL"; // Asegúrate de usar NULL sin comillas
        $sql.= " WHERE idusuario='".$this->getIdUsuario()."'";
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

    public static function listar($parametro=""){
        $arreglo = array();
        $base=new bdcarritocompras();
        $sql="SELECT * FROM usuario ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row2 = $base->Registro()) {
                    $obj = new Usuario();
                    $obj->setear($row2['idusuario'], $row2['usnombre'], $row2['uspass'], $row2['usmail'], $row2['usdeshabilitado']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setmensajeoperacion("Usuario->listar: ".$base->getError());
        }
        return $arreglo;
    }

    public function __toString(){
        return "IdUsuario: ".$this->getIdUsuario()."\nUsNombre: ".$this->getUsNombre()."\nUsPass: ".$this->getUsPass()."\nUsMail: ".$this->getUsMail()."\nUsDeshabilitado: ".$this->getUsDeshabilitado();
    }
}
?>