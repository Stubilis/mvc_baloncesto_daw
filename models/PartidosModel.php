<?php 
class PartidosModel
{
    // Conexión a la BD
    protected $db;
    private $COD_PARTIDO;
    private $FECHA;
    private $COD_EQUIPO1;
    private $COD_EQUIPO2;
    private $PUNTOS_EQUIPO1;
    private $PUNTOS_EQUIPO2;
    //Creamos las variables extra para almacenar el nombre de los equipos
    private $NOMBRE_EQUIPO1;
    private $NOMBRE_EQUIPO2;

    // Constructor que utiliza el patrón Singleton para tener una única instancia de la conexión a BD
    public function __construct()
    {
        //Traemos la única instancia de PDO
        $this->db = SPDO::singleton();
    }

    // Getters y Setters
    //No se puede modificar el código del partido por lo que no hay setCod_partido()
    //Tampoco hay setNombre_equipo() ya que no se puede modificar el nombre del equipo desde partidos.
    public function getCOD_PARTIDO()
    {
        return $this->COD_PARTIDO;
    }
    public function getFECHA()
    {
        return $this->FECHA;
    }
    public function setFECHA($fecha)
    {
        $this->FECHA = $fecha;
    }
    public function getCOD_EQUIPO1()
    {
        return $this->COD_EQUIPO1;
    }
    public function setCOD_EQUIPO1($cod_equipo1)
    {
        $this->COD_EQUIPO1 = $cod_equipo1;
    }
    public function getCOD_EQUIPO2()
    {
        return $this->COD_EQUIPO2;
    }
    public function setCOD_EQUIPO2($cod_equipo2)
    {
        $this->COD_EQUIPO2 = $cod_equipo2;
    }
    public function getPUNTOS_EQUIPO1()
    {
        return $this->PUNTOS_EQUIPO1;
    }
    public function setPUNTOS_EQUIPO1($puntos_equipo1)
    {
        $this->PUNTOS_EQUIPO1 = $puntos_equipo1;
    }
    public function getPUNTOS_EQUIPO2()
    {
        return $this->PUNTOS_EQUIPO2;
    }
    public function setPUNTOS_EQUIPO2($puntos_equipo2)
    {
        $this->PUNTOS_EQUIPO2 = $puntos_equipo2;
    }
    public function getNOMBRE_EQUIPO1()
    {
        return $this->NOMBRE_EQUIPO1;
    }
    public function getNOMBRE_EQUIPO2()
    {
        return $this->NOMBRE_EQUIPO2;
    }

    //Metodo que devuelve todos los partidos
    public function getAll()
    {
        //realizamos la consulta de todos los partidos
        $consulta = $this->db->prepare('SELECT * , e1.NOMBRE_EQUIPO AS NOMBRE_EQUIPO1, e2.NOMBRE_EQUIPO AS NOMBRE_EQUIPO2 FROM PARTIDOS 
        INNER JOIN EQUIPOS AS e1, EQUIPOS AS e2 WHERE PARTIDOS.COD_EQUIPO1=e1.COD_EQUIPO AND PARTIDOS.COD_EQUIPO2=e2.COD_EQUIPO
        ORDER BY PARTIDOS.COD_PARTIDO DESC;');
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_CLASS, "PartidosModel");

        //devolvemos la colección para que la vista la presente.
        return $resultado;
    }

    // Método que devuelve (si existe en BD) un objeto PartidosModel con un código determinado
    public function getById($cod_partido)
    {
        $gsent = $this->db->prepare('SELECT * , e1.NOMBRE_EQUIPO AS NOMBRE_EQUIPO1, e2.NOMBRE_EQUIPO AS NOMBRE_EQUIPO2 
                    FROM PARTIDOS INNER JOIN EQUIPOS AS e1, EQUIPOS AS e2 
                    WHERE PARTIDOS.COD_EQUIPO1=e1.COD_EQUIPO AND PARTIDOS.COD_EQUIPO2=e2.COD_EQUIPO AND COD_PARTIDO = ? ; ');
        $gsent->bindParam(1, $cod_partido);
        $gsent->execute();

        $gsent->setFetchMode(PDO::FETCH_CLASS, "PartidosModel");
        $resultado = $gsent->fetch();

        return $resultado;
    }

    //Metodo que devuelve los partidos de un equipo
    public function getByEquipo($equipo)
    {
        $gsent = $this->db->prepare('SELECT * , e1.NOMBRE_EQUIPO AS NOMBRE_EQUIPO1, e2.NOMBRE_EQUIPO AS NOMBRE_EQUIPO2 
                                FROM PARTIDOS INNER JOIN EQUIPOS AS e1, EQUIPOS AS e2
                                WHERE (PARTIDOS.COD_EQUIPO1=e1.COD_EQUIPO AND PARTIDOS.COD_EQUIPO2=e2.COD_EQUIPO) AND (COD_EQUIPO1=? OR COD_EQUIPO2=?) ');
        $gsent->bindParam(1, $equipo);
        $gsent->bindParam(2, $equipo);
        $gsent->execute();

        $gsent->setFetchMode(PDO::FETCH_CLASS, "PartidosModel");
        $resultado = $gsent->fetchAll();

        return $resultado;
    }

    public function create(){
        //Buscamos el cod_partido más alto para asignarle el siguiente
        $consulta = $this->db->prepare('SELECT MAX(COD_PARTIDO) FROM PARTIDOS;');
        $consulta->execute();
        $resultado = $consulta->fetch();
        $cod_partido = $resultado[0]+1;
       
        //Comprobamos que no exista ya un partido con ese codigo
        do{
            $consulta = $this->db->prepare('SELECT * FROM PARTIDOS WHERE COD_PARTIDO=?');
            $consulta->bindParam(1, $cod_partido);
            $consulta->execute();
            $resultado = $consulta->fetch();
            $consulta->execute();
            $resultado = $consulta->fetch();
            //Si existe el codigo lo incrementamos en 1
            if ($resultado != null) {
                $cod_partido++;
            }
        }while($resultado != null);
        //Preparamos la inserccion
        $consulta = $this->db->prepare('INSERT INTO PARTIDOS (COD_PARTIDO,FECHA,COD_EQUIPO1,COD_EQUIPO2,PUNTOS_EQUIPO1,PUNTOS_EQUIPO2) VALUES (?,?,?,?,?,?);');
        $consulta->bindParam(1, $cod_partido);
        $consulta->bindParam(2, $this->FECHA);
        $consulta->bindParam(3, $this->COD_EQUIPO1);
        $consulta->bindParam(4, $this->COD_EQUIPO2);
        $consulta->bindParam(5, $this->PUNTOS_EQUIPO1);
        $consulta->bindParam(6, $this->PUNTOS_EQUIPO2);
        $consulta->execute();

    }
    public function update(){
        
        //Preparamos la actualizacion
        $consulta = $this->db->prepare('UPDATE PARTIDOS SET FECHA=?,COD_EQUIPO1=?,COD_EQUIPO2=?,PUNTOS_EQUIPO1=?,PUNTOS_EQUIPO2=? WHERE COD_PARTIDO=?;');
        $consulta->bindParam(1, $this->FECHA);
        $consulta->bindParam(2, $this->COD_EQUIPO1);
        $consulta->bindParam(3, $this->COD_EQUIPO2);
        $consulta->bindParam(4, $this->PUNTOS_EQUIPO1);
        $consulta->bindParam(5, $this->PUNTOS_EQUIPO2);
        $consulta->bindParam(6, $this->COD_PARTIDO);
        $consulta->execute();
    }
    public function delete(){
        //Preparamos la consulta
        $consulta = $this->db->prepare('DELETE FROM PARTIDOS WHERE COD_PARTIDO=?;');
        $consulta->bindParam(1, $this->COD_PARTIDO);
        $consulta->execute();
    }

    //Metodo que borra todos los partidos de un equipo
    public function deleteByEquipo($equipo){
        //Preparamos la consulta
        $consulta = $this->db->prepare('DELETE FROM PARTIDOS WHERE COD_EQUIPO1=? OR COD_EQUIPO2=?;');
        $consulta->bindParam(1, $equipo);
        $consulta->bindParam(2, $equipo);
        $consulta->execute();
    }


}
 ?>