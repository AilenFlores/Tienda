<?php
class Menu {
    private $idmenu;
    private $menombre;
    private $medescripcion;
    private $objmenu; //menu padre
    private $medeshabilitado;
    private $mensajeoperacion;
    

    /**
     * @return mixed
     */
    public function getIdmenu()
    {
        return $this->idmenu;
    }

    /**
     * @param mixed $idmenu
     */
    public function setIdmenu($idmenu)
    {
        $this->idmenu = $idmenu;
    }

    /**
     * @return mixed
     */
    public function getMenombre()
    {
        return $this->menombre;
    }

    /**
     * @param mixed $menombre
     */
    public function setMenombre($menombre)
    {
        $this->menombre = $menombre;
    }

    /**
     * @return mixed
     */
    public function getMedescripcion()
    {
        return $this->medescripcion;
    }

    /**
     * @param mixed $medescripcion
     */
    public function setMedescripcion($medescripcion)
    {
        $this->medescripcion = $medescripcion;
    }

    /**
     * @return mixed
     */
    public function getObjmenu()
    {
        return $this->objmenu;
    }

    /**
     * @param mixed $ObjMenu
     */
    public function setObjmenu($ObjMenu)
    {
        $this->objmenu = $ObjMenu;
    }

    /**
     * @return mixed
     */
    public function getMedeshabilitado()
    {
        return $this->medeshabilitado;
    }

    /**
     * @param mixed $medeshabilitado
     */
    public function setMedeshabilitado($medeshabilitado)
    {
        $this->medeshabilitado = $medeshabilitado;
    }

    /**
     * @return string
     */
    public function getMensajeoperacion()
    {
        return $this->mensajeoperacion;
    }

    /**
     * @param string $mensajeoperacion
     */
    public function setMensajeoperacion($mensajeoperacion)
    {
        $this->mensajeoperacion = $mensajeoperacion;
    }

    public function __construct(){
         $this->idmenu="";
         $this->menombre="" ;
         $this->medescripcion="";
         $this->objmenu= null;
         $this->medeshabilitado = null;
         $this->mensajeoperacion ="";
        
     }

     public function setear($idmenu, $menombre,$medescripcion,$ObjMenu,$medeshabilitado)    {
        $this->setIdmenu($idmenu);
        $this->setMenombre($menombre);
        $this->setMedescripcion($medescripcion);
        $this->setObjmenu($ObjMenu);
        $this->setMedeshabilitado($medeshabilitado);
    }
    
    
    public function cargar(){
        $resp = false;
        $base=new bdcarritocompras();
        $sql="SELECT * FROM menu WHERE idmenu = ".$this->getIdmenu();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                if ($row2 = $base->Registro()) {
                    $this->setear($row2['idmenu'], $row2['menombre'], $row2['medescripcion'], $row2['idpadre'], $row2['medeshabilitado']);
                    $resp = true;
                }
            } else {
                $this->setmensajeoperacion("menu->cargar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("menu->cargar: ".$base->getError());
        }
        return $resp;
    }
    
    public function insertar(){
        $resp = false;
        $base = new bdcarritocompras();
        $sql = "INSERT INTO menu (menombre, medescripcion, idpadre, medeshabilitado) VALUES ('" . $this->getMenombre() . "','" . $this->getMedescripcion() . "','" . $this->getObjmenu() . "','" . $this->getMedeshabilitado() . "')";
        echo $sql;
        exit;
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setIdmenu($elid);
                $resp = true;
            } else {
                $this->setmensajeoperacion("menu->insertar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("menu->insertar: " . $base->getError());
        }
        return $resp;
    }
    
    
    public function modificar(){
        $resp = false;
        $base = new bdcarritocompras();
        $sql = " UPDATE menu SET 
        menombre = '" . $this->getMenombre() . "', 
        medescripcion = '" .  $this->getMedescripcion() . "', 
        idpadre = '" . $this->getObjmenu() . "' 
        WHERE 
        idmenu = " . $this->getIdmenu();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("menu->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("menu->modificar: " . $base->getError());
        }
    
        return $resp;
    }

    
    public function eliminar(){
        $resp = false;
        $base=new bdcarritocompras();
        $sql="DELETE FROM menu WHERE idmenu =".$this->getIdmenu();
        //echo $sql;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("Menu->eliminar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Menu->eliminar: ".$base->getError());
        }
        return $resp;
    }


    public static function listar($parametro=""){
        $arreglo = array();
        $base=new bdcarritocompras();
        $sql="SELECT * FROM menu ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row2 = $base->Registro()) {
                    $obj = new Menu();
                    $obj->setear($row2['idmenu'], $row2['menombre'], $row2['medescripcion'], $row2['idpadre'], $row2['medeshabilitado']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setmensajeoperacion("menu->listar: ".$base->getError());
        }
        return $arreglo;
    }
    
    }
?>