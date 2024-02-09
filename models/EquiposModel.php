<?php

// Clase del modelo para trabajar con objetos Item que se almacenan en BD en la tabla Equipos
class EquiposModel
{
    protected $db;
    //Atributos del objeto equipo que coinciden con los campos de la tabla EQUIPOS
    private $COD_EQUIPO;
    private $NOMBRE_EQUIPO;
    private $TITULOS;
    private $PRESUPUESTO;
    private $FECHA_FUNDACION;
    private $ZONA;
    //Variable extra para almacenar el nombre de la zona
    private $NOMBRE_ZONA;

    // Constructor que utiliza el patrón Singleton para tener una única instancia de la conexión a BD
    public function __construct()
    {
        //Traemos la única instancia de PDO
        $this->db = SPDO::singleton();
    }

    // Getters y Setters
    //No se puede modificar el código del equipo por lo que no hay setCod_equipo()
    //Tampoco hay setNombre_zona() ya que no se puede modificar el nombre de la zona desde equipos.
    
    public function getCOD_EQUIPO()
    {
        return $this->COD_EQUIPO;
    }       
    public function getNOMBRE_EQUIPO()
    {
        return $this->NOMBRE_EQUIPO;
    }
    public function setNOMBRE_EQUIPO($nombre_equipo)
    {
        $this->NOMBRE_EQUIPO = $nombre_equipo;
    }

    public function getTITULOS()
    {
        return $this->TITULOS;
    }
    public function setTITULOS($titulos)
    {
        $this->TITULOS = $titulos;
    }
    public function getPRESUPUESTO()
    {
        return $this->PRESUPUESTO;
    }
    public function setPRESUPUESTO($presupuesto)
    {
        $this->PRESUPUESTO = $presupuesto;
    }
    public function getFECHA_FUNDACION()
    {
        return $this->FECHA_FUNDACION;
    }
    public function setFECHA_FUNDACION($fecha_fundacion)
    {
        $this->FECHA_FUNDACION = $fecha_fundacion;
    }
    public function getZONA()
    {
        return $this->ZONA;
    }
    public function setZONA($zona)
    {
        $this->ZONA = $zona;
    }
    public function getNOMBRE_ZONA()
    {
        return $this->NOMBRE_ZONA;
    }



    // Método para obtener todos los registros de la tabla 
    // Devuelve un array de objetos
    public function getAll()
    {
        //realizamos la consulta de todos los items
        $consulta = $this->db->prepare('SELECT * FROM EQUIPOS inner join ZONAS where EQUIPOS.ZONA=ZONAS.COD_ZONA;');
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_CLASS, "EquiposModel");

        //devolvemos la colección para que la vista la presente.
        return $resultado;
    }


    // Método que devuelve (si existe en BD) un objeto con un código determinado
    public function getById($cod_equipo)
    {
        
        $gsent = $this->db->prepare('SELECT * FROM EQUIPOS inner join ZONAS WHERE EQUIPOS.COD_EQUIPO = ? AND EQUIPOS.ZONA=ZONAS.COD_ZONA ');
        $gsent->bindParam(1, $cod_equipo);
        $gsent->execute();

        $gsent->setFetchMode(PDO::FETCH_CLASS, "EquiposModel");
        $resultado = $gsent->fetch();

        return $resultado;
    }

    // Método que devuelve (si existe en BD) los objetos con una zona determinada
    public function getByZona($zona)
    {
        $gsent = $this->db->prepare('SELECT EQUIPOS.*, ZONAS.NOMBRE_ZONA FROM EQUIPOS inner join ZONAS WHERE EQUIPOS.ZONA = ? AND EQUIPOS.ZONA=ZONAS.COD_ZONA ');
        $gsent->bindParam(1, $zona);
        $gsent->execute();

        $gsent->setFetchMode(PDO::FETCH_CLASS, "EquiposModel");
        $resultado = $gsent->fetchAll();

        return $resultado;
    }

    // Método que crea un nuevo equipo en la BD
    public function create()
    {
        //El codigo equipo se forma con el codigo de la zona y el numero de equipos que tiene 
        //Preparamos la consulta
        $consulta = $this->db->prepare('SELECT COUNT(*) AS NUMERO FROM EQUIPOS WHERE ZONA=?');
        $consulta->bindParam(1, $this->ZONA);
        $consulta->execute();
        $resultado = $consulta->fetch();
            $cod_equipo = $this->ZONA . ($resultado['NUMERO'] + 1);
        //Comprobamos que no exista ya un equipo con ese codigo
        do{
            $consulta = $this->db->prepare('SELECT * FROM EQUIPOS WHERE COD_EQUIPO=?');
            $consulta->bindParam(1, $cod_equipo);
            $consulta->execute();
            $resultado = $consulta->fetch();
            //Si existe el codigo lo incrementamos en 1
            if ($resultado != null) {
                $cod_equipo = $cod_equipo + 1;
        }
        }while($resultado != null);
           
            
        //Preparamos la inserción
        $consulta = $this->db->prepare('INSERT INTO EQUIPOS(COD_EQUIPO,TITULOS,PRESUPUESTO,FECHA_FUNDACION,ZONA,NOMBRE_EQUIPO) VALUES (?,?,?,?,?,?)');
        $consulta->bindParam(1, $cod_equipo);
        $consulta->bindParam(2, $this->TITULOS);
        $consulta->bindParam(3, $this->PRESUPUESTO);
        $consulta->bindParam(4, $this->FECHA_FUNDACION);
        $consulta->bindParam(5, $this->ZONA);
        $consulta->bindParam(6, $this->NOMBRE_EQUIPO);
        
        $consulta->execute();
        
    }

    // Método que actualiza un Equipo en la BD
    public function update(){

        $consulta = $this->db->prepare('UPDATE EQUIPOS SET TITULOS=?, PRESUPUESTO=?, FECHA_FUNDACION=?, ZONA=?, NOMBRE_EQUIPO=? WHERE COD_EQUIPO=?');
        $consulta->bindParam(1, $this->TITULOS);
        $consulta->bindParam(2, $this->PRESUPUESTO);
        $consulta->bindParam(3, $this->FECHA_FUNDACION);
        $consulta->bindParam(4, $this->ZONA);
        $consulta->bindParam(5, $this->NOMBRE_EQUIPO);
        $consulta->bindParam(6, $this->COD_EQUIPO);
        $consulta->execute();
    }

    // Método que elimina el equipo de la BD
    public function delete()
    {
        //Borramos el equipo
        $consulta = $this->db->prepare('DELETE FROM EQUIPOS WHERE COD_EQUIPO=?');
        $consulta->bindParam(1, $this->COD_EQUIPO);
        $consulta->execute();
    }
    //Metodo que elimina equipos de una zona
    public function deleteByZona($zona){
        //Borramos el equipo
        $consulta = $this->db->prepare('DELETE FROM EQUIPOS WHERE ZONA=?');
        $consulta->bindParam(1, $zona);
        $consulta->execute();
    }
}
?>