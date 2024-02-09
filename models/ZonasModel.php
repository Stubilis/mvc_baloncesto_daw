<?php 
class ZonasModel{
    protected $db;

    private $COD_ZONA;
    private $NOMBRE_ZONA;

     // Constructor que utiliza el patrón Singleton para tener una única instancia de la conexión a BD
     public function __construct()
     {
         //Traemos la única instancia de PDO
         $this->db = SPDO::singleton();
     }

    //getters y setters
    public function getCOD_ZONA(){
        return $this->COD_ZONA;
    }

    public function getNOMBRE_ZONA(){
        return $this->NOMBRE_ZONA;
    }
    public function setNOMBRE_ZONA($nombre_zona){
        $this->NOMBRE_ZONA = $nombre_zona;
    }
    
    public function getAll()
    {
        //realizamos la consulta de todos los items
        $consulta = $this->db->prepare('SELECT * FROM ZONAS;');
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_CLASS, "ZonasModel");

        //devolvemos la colección para que la vista la presente.
        return $resultado;
    }


    // Método que devuelve (si existe en BD) un objeto ZonasModel con un código determinado
    public function getById($cod_zona)
    {
        $gsent = $this->db->prepare('SELECT * FROM ZONAS  WHERE COD_ZONA = ? ');
        $gsent->bindParam(1, $cod_zona);
        $gsent->execute();

        $gsent->setFetchMode(PDO::FETCH_CLASS, "ZonasModel");
        $resultado = $gsent->fetch();

        return $resultado;
    }

    // Método que crea una nueva zona en la BD
    public function create()
    {
     
        //Preparamos la consulta
        $consulta = $this->db->prepare('SELECT COUNT(*) AS NUMERO FROM ZONAS;');
        $consulta->execute();
        $resultado = $consulta->fetch();
        $cod_zona = $resultado['NUMERO'] + 1;
        
        //Comprobamos que no exista ya una zona con ese codigo
        do{
            $consulta = $this->db->prepare('SELECT * FROM ZONAS WHERE COD_ZONA=?');
            $consulta->bindParam(1, $cod_zona);
            $consulta->execute();
            $resultado = $consulta->fetch();
            //Si existe el codigo lo incrementamos en 1
            if ($resultado != null) {
                $cod_zona = $cod_zona + 1;
            }
        }while($resultado != null);
        //Preparamos la inserción
        $consulta = $this->db->prepare('INSERT INTO ZONAS(COD_ZONA,NOMBRE_ZONA) VALUES (?,?)');
        $consulta->bindParam(1, $cod_zona);
        $consulta->bindParam(2, $this->NOMBRE_ZONA);
        $consulta->execute();
        
    }
    // Método que actualiza una zona en la BD
    public function update(){
        $consulta = $this->db->prepare('UPDATE ZONAS SET NOMBRE_ZONA=? WHERE COD_ZONA=?');
        $consulta->bindParam(1, $this->NOMBRE_ZONA);
        $consulta->bindParam(2, $this->COD_ZONA);
        $consulta->execute();
    }

    // Método que elimina una zona de la BD
    public function delete()
    {
        $consulta = $this->db->prepare('DELETE FROM ZONAS WHERE COD_ZONA=?');
        $consulta->bindParam(1, $this->COD_ZONA);
        $consulta->execute();
        
    }
}

?>