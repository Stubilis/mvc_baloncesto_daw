<?php

// Clase del modelo para trabajar con objetos que se almacenan en BD en la tabla Jugadores
class JugadoresModel
{
    // Conexión a la BD
    protected $db;

    // Atributos del objeto item que coinciden con los campos de la tabla ITEMS
    private $COD_JUGADOR;
    private $NOMBRE_JUGADOR;
    private $FECHA_NACIMIENTO;
    private $ESTATURA;
    private $POSICION;
    private $EQUIPO;
    //Variable extra para almacenar el nombre del equipo
    private $NOMBRE_EQUIPO;
    // Constructor que utiliza el patrón Singleton para tener una única instancia de la conexión a BD
    public function __construct()
    {
        //Traemos la única instancia de PDO
        $this->db = SPDO::singleton();
    }

    // Getters y Setters
    //No se puede modificar el código del jugador por lo que no hay setCod_jugador
    
    public function getCOD_JUGADOR()
    {
        return $this->COD_JUGADOR;
    }       
    
    public function getNOMBRE_JUGADOR()
    {
        return $this->NOMBRE_JUGADOR;
    }
    public function setNOMBRE_JUGADOR($nombre_jugador)
    {
        $this->NOMBRE_JUGADOR = $nombre_jugador;
    }
    public function getFECHA_NACIMIENTO()
    {
        return $this->FECHA_NACIMIENTO;
    }
    public function setFECHA_NACIMIENTO($fecha_nacimiento)
    {
        $this->FECHA_NACIMIENTO = $fecha_nacimiento;
    }
    public function getESTATURA()
    {
        return $this->ESTATURA;
    }
    public function setESTATURA($estatura)
    {
        $this->ESTATURA = $estatura;
    }
    public function getPOSICION()
    {
        return $this->POSICION;
    }
    public function setPOSICION($posicion)
    {
        $this->POSICION = $posicion;
    }
    public function getEQUIPO()
    {
        return $this->EQUIPO;
    }
    public function setEQUIPO($equipo)
    {
        $this->EQUIPO = $equipo;
    }
    public function getNOMBRE_EQUIPO()
    {
        return $this->NOMBRE_EQUIPO;
    }

    // Método para obtener todos los registros de la tabla jugadores
    // Devuelve un array de objetos de la clase jugadoresModel
    public function getAll()
    {
        //realizamos la consulta de todos los items
        $consulta = $this->db->prepare('SELECT * FROM JUGADORES inner join EQUIPOS where JUGADORES.EQUIPO=EQUIPOS.COD_EQUIPO;');
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_CLASS, "JugadoresModel");

        //devolvemos la colección para que la vista la presente.
        return $resultado;
    }


    // Método que devuelve (si existe en BD) un objeto jugadorModer con un código determinado
    public function getById($cod_jugador)
    {
        $gsent = $this->db->prepare('SELECT * FROM JUGADORES inner join EQUIPOS WHERE COD_JUGADOR = ? and JUGADORES.EQUIPO=EQUIPOS.COD_EQUIPO');
        $gsent->bindParam(1, $cod_jugador);
        $gsent->execute();

        $gsent->setFetchMode(PDO::FETCH_CLASS, "JugadoresModel");
        $resultado = $gsent->fetch();

        return $resultado;
    }

    // Método que devuelve los jugadores de un equipo
    public function getByEquipo($equipo)
    {
        $gsent = $this->db->prepare('SELECT * FROM JUGADORES inner join EQUIPOS WHERE EQUIPO = ? AND JUGADORES.EQUIPO=EQUIPOS.COD_EQUIPO');
        $gsent->bindParam(1, $equipo);
        $gsent->execute();

        $gsent->setFetchMode(PDO::FETCH_CLASS, "JugadoresModel");
        $resultado = $gsent->fetchAll();

        return $resultado;
    }

    // Método que crea un nuevo jugador en la BD
    public function create()
    {
        //El codigo jugador se forma con el codigo del equipo y el numero de jugadores que tiene 
        //Preparamos la consulta
        $consulta = $this->db->prepare('SELECT COUNT(*) AS NUMERO FROM JUGADORES WHERE EQUIPO=?');
        $consulta->bindParam(1,$this->EQUIPO);
        $consulta->execute();
        $resultado = $consulta->fetch();
        if ($resultado['NUMERO'] < 10) {
            $cod_jugador = $this->EQUIPO . '0' . ($resultado['NUMERO'] + 1);
        } else {
            $cod_jugador = $this->EQUIPO . ($resultado['NUMERO'] + 1);
        }
        //Comprobamos que no exista ya un jugador con ese codigo
        do{
            $consulta = $this->db->prepare('SELECT * FROM JUGADORES WHERE COD_JUGADOR=?');
            $consulta->bindParam(1, $cod_jugador);
            $consulta->execute();
            $resultado = $consulta->fetch();
            //Si existe el codigo lo incrementamos en 1
            if ($resultado != null) {
                $cod_jugador = $cod_jugador + 1;
            }
        }while($resultado != null);
        //Preparamos la inserción
        $consulta = $this->db->prepare('INSERT INTO JUGADORES(COD_JUGADOR,NOMBRE_JUGADOR,FECHA_NACIMIENTO,ESTATURA,POSICION,EQUIPO) VALUES (?,?,?,?,?,?)');
        $consulta->bindParam(1, $cod_jugador);
        $consulta->bindParam(2, $this->NOMBRE_JUGADOR);
        $consulta->bindParam(3, $this->FECHA_NACIMIENTO);
        $consulta->bindParam(4, $this->ESTATURA);
        $consulta->bindParam(5, $this->POSICION);
        $consulta->bindParam(6, $this->EQUIPO);
        $consulta->execute();
        
    }
    // Método que actualiza un jugador en la BD
    public function update(){

        $consulta = $this->db->prepare('UPDATE JUGADORES SET NOMBRE_JUGADOR=?, FECHA_NACIMIENTO=?, ESTATURA=?, POSICION=?, EQUIPO=? WHERE COD_JUGADOR=?');
        $consulta->bindParam(1, $this->NOMBRE_JUGADOR);
        $consulta->bindParam(2, $this->FECHA_NACIMIENTO);
        $consulta->bindParam(3, $this->ESTATURA);
        $consulta->bindParam(4, $this->POSICION);
        $consulta->bindParam(5, $this->EQUIPO);
        $consulta->bindParam(6, $this->COD_JUGADOR);
        $consulta->execute();
    }

    // Método que elimina el jugador de la BD
    public function delete()
    {
        $consulta = $this->db->prepare('DELETE FROM JUGADORES WHERE COD_JUGADOR=?');
        $consulta->bindParam(1, $this->COD_JUGADOR);
        $consulta->execute();
    }
    //Metodo que borra todos los jugadores de un equipo
    public function deleteByEquipo($equipo){
        $consulta = $this->db->prepare('DELETE FROM JUGADORES WHERE EQUIPO=?');
        $consulta->bindParam(1, $equipo);
        $consulta->execute();
    }
}
?>