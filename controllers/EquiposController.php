<?php
// Controlador para el modelo EquiposModel 
class EquiposController {
    // Atributo con el motor de plantillas del microframework
    protected $view;

    // Constructor. Únicamente instancia un objeto View y lo asigna al atributo
    function __construct() {
        //Creamos una instancia de nuestro mini motor de plantillas
        $this->view = new View();
        //Incluimos el archivo de cabecera
        $this->view->show("menuNav.php");
    }

    // Método del controlador para listar los equipos almacenados
    public function listar() {
        //Incluye el modelo que corresponde
        require 'models/EquiposModel.php';

        //Creamos una instancia de nuestro "modelo"
        $equipos = new EquiposModel();

        //Le pedimos al modelo todos los equipos
        $listado = $equipos->getAll();

        //Pasamos a la vista toda la información que se desea representar
        $data['equipos'] = $listado;

        // Finalmente presentamos nuestra plantilla 
        // Llamamos al método "show" de la clase View, que es el motor de plantillas
        // Genera la vista de respuesta a partir de la plantilla y de los datos
        $this->view->show("equiposListarView.php", $data);
    }

    // Método del controlador para crear un nuevo equipo
    public function nuevo() {
        require 'models/EquiposModel.php';
        //Incluimos el modelo zonasModel para poder hacer el desplegable de zonas
        require 'models/ZonasModel.php';  

        $equipo = new EquiposModel();
        $zonas = new ZonasModel();
         //Recuperamos todas las zonas para poder hacer el desplegable
        $zonas = $zonas->getAll();

        $errores = array();

            // Si se ha pulsado el botón de submit
        if (isset($_REQUEST['submit'])) {

            // Comprobamos si se ha recibido el nombre
            if (!isset($_REQUEST['nombre_equipo']) || empty($_REQUEST['nombre_equipo']))
                $errores['nombre_equipo'] = "* Nombre: debes indicar un nombre.";
            // Comprobamos si se ha recibido la fecha de fundacion
            if (!isset($_REQUEST['fecha_fundacion']) || empty($_REQUEST['fecha_fundacion']))
                $errores['fecha_fundacion'] = "* Fecha: debes indicar un año de fundación.";
            // Comprobamos si se ha recibido el presupuesto
            if (!isset($_REQUEST['presupuesto']) || empty($_REQUEST['presupuesto']))
                $errores['presupuesto'] = "* Presupuesto: debes indicar un presupuesto.";
            // Comprobamos si se ha recibido los titulos
            if (!isset($_REQUEST['titulos']) || empty($_REQUEST['titulos']))
                $errores['titulos'] = "* Títulos: debes indicar el número de títulos.";
            // Comprobamos si se ha recibido la zona
            if (!isset($_REQUEST['zona']) || empty($_REQUEST['zona']))
                $errores['zona'] = "* Zona: debes indicar una zona.";

            // Si no hay errores actualizamos en la BD
            if (empty($errores)) {
               // Cambia el valor del equipo y lo guarda en BD
               $equipo->setNOMBRE_EQUIPO($_REQUEST['nombre_equipo']);
               $equipo->setFECHA_FUNDACION($_REQUEST['fecha_fundacion']);
               $equipo->setPRESUPUESTO($_REQUEST['presupuesto']);
               $equipo->setTITULOS($_REQUEST['titulos']);
               $equipo->setZONA($_REQUEST['zona']);
               $equipo->create();


                // Finalmente llama al método listar para que devuelva vista con listado
                header("Location: index.php?controlador=Equipos&accion=listar");
            }
        }

        // Si no recibe el equipo para añadir, devuelve la vista para añadir un nuevo equipo
      
        $this->view->show("equiposNuevoView.php", array('errores' => $errores,'zonas' => $zonas));

    }

    

    // Método que procesa la petición para editar un equipo
    public function editar() {

       
        //Incluimos el modelo equiposModel para poder hacer el desplegable de equipos
        require 'models/EquiposModel.php';
        require 'models/ZonasModel.php';  


        $equipos = new EquiposModel();
        $zonas = new ZonasModel();

        // Recuperar el equipo con el código recibido
        $equipo = $equipos->getById($_REQUEST['cod_equipo']);
        //Recuperamos todos los equipos para poder hacer el desplegable
        $zonas = $zonas->getAll();
        //Recuperamos todas las zonas para poder hacer el desplegable
        

        if ($equipo == null) {
            $this->view->show("errorView.php", array('error' => 'No existe codigo'));
        }

        $errores = array();

        // Si se ha pulsado el botón de actualizar
        if (isset($_REQUEST['submit'])) {

            // Comprobamos si se ha recibido el nombre
            if (!isset($_REQUEST['nombre_equipo']) || empty($_REQUEST['nombre_equipo']))
                $errores['nombre_equipo'] = "* Nombre: debes indicar un nombre.";
            // Comprobamos si se ha recibido la fecha de fundacion
            if (!isset($_REQUEST['fecha_fundacion']) || empty($_REQUEST['fecha_fundacion']))
                $errores['fecha_fundacion'] = "* Fecha: debes indicar un año de fundación.";
            // Comprobamos si se ha recibido el presupuesto
            if (!isset($_REQUEST['presupuesto']) || empty($_REQUEST['presupuesto']))
                $errores['presupuesto'] = "* Presupuesto: debes indicar un presupuesto.";
            // Comprobamos si se ha recibido los titulos
            if (!isset($_REQUEST['titulos']) || empty($_REQUEST['titulos']))
                $errores['titulos'] = "* Títulos: debes indicar el número de títulos.";
            // Comprobamos si se ha recibido la zona
            if (!isset($_REQUEST['zona']) || empty($_REQUEST['zona']))
                $errores['zona'] = "* Zona: debes indicar una zona.";

            // Si no hay errores actualizamos en la BD
            if (empty($errores)) {
                // Cambia el valor del equipo y lo guarda en BD
                $equipo->setNOMBRE_EQUIPO($_REQUEST['nombre_equipo']);
                $equipo->setFECHA_FUNDACION($_REQUEST['fecha_fundacion']);
                $equipo->setPRESUPUESTO($_REQUEST['presupuesto']);
                $equipo->setTITULOS($_REQUEST['titulos']);
                $equipo->setZONA($_REQUEST['zona']);
                $equipo->update();

                // Reenvía a la aplicación a la lista de equipos
                header("Location: index.php?controlador=Equipos&accion=listar");
            }
        }

        // Si no se ha pulsado el botón de actualizar se carga la vista para editar el equipo
        $this->view->show("equiposEditarView.php", array('equipo' => $equipo, 'errores' => $errores, 'zonas' => $zonas));

    }

    // Método para borrar los jugadores asociados al equipo
    public function borrarJugadores(){
        //Incluimos jugadores y partidos para poder borrarlos si el usuario quiere
        require_once 'models/JugadoresModel.php';
        require_once 'models/EquiposModel.php';

        // Añadimos un modelo de partidos para poder mostrar los partidos asociados al equipo si los hay
        require_once 'models/PartidosModel.php';

        // Recuperar el equipo con el código recibido
        $equipos = new EquiposModel();
        $equipo = $equipos->getById($_REQUEST['cod_equipo_jugador']);

        //Recuperamos todos los jugadores y partidos asociados al equipo (si los hay)
        $jugadores = new JugadoresModel();
        $jugadores = $jugadores->getByEquipo($_REQUEST['cod_equipo_jugador']);
        $partidos = new PartidosModel();
        $partidos = $partidos->getByEquipo($_REQUEST['cod_equipo_jugador']);

        //Creamos un array de errores
        $errores = array();

        // si tiene partidos asociados no se puede borrar (el equipo)
        if ($partidos != null) {
            $errores['borrarPartidos'] = "* No se puede borrar el equipo porque tiene partidos asociados.";
        }
        // Si pulsa el botón de borrar jugadores
        if(isset($_REQUEST['submitJugadores'])){
            //Borramos los jugadores asociados al equipo
            foreach ($jugadores as $jugador){
                if(isset($_REQUEST['cod_equipo_jugador']))
                $jugador->deleteByEquipo($_REQUEST['cod_equipo_jugador']);
               
            }
            // Refrescamos la página para que se actualice y le pasamos el equipo, errores y partidos
            
            $this->view->show("equiposBorrarView.php", array('equipo' => $equipo, 'errores' => $errores,  'partidos' => $partidos));
        }
      

           

    }

    // Método para borrar los partidos asociados al equipo
    public function borrarPartidos(){
    //Incluimos  partidos para poder borrarlos si el usuario quiere
    require_once 'models/PartidosModel.php';
    require_once 'models/EquiposModel.php';
    
    //Incluimos jugadores para poder enviarlos a la vista
    require_once 'models/JugadoresModel.php';

    $partidos = new PartidosModel();
    $equipos = new EquiposModel();

    $jugadores = new JugadoresModel();

    // Recuperar el equipo con el código recibido
    $equipo = $equipos->getById($_REQUEST['cod_equipo_partido']);
    //Recuperamos todos los jugadores y partidos asociados al equipo (si los hay)
    $partidos = $partidos->getByEquipo($_REQUEST['cod_equipo_partido']);
    $jugadores = $jugadores->getByEquipo($_REQUEST['cod_equipo_partido']);

    //Creamos un array de errores
    $errores = array();

    // si tiene jugadores asociados no se puede borrar (el equipo)
    if ($jugadores != null) {
        $errores['borrarJugadores'] = "* No se puede borrar el equipo porque tiene jugadores asociados.";
    }
    // Si pulsa el botón de borrar partidos
    if(isset($_REQUEST['submitPartidos'])){
        //Borramos los partidos asociados al equipo
        foreach ($partidos as $partido){
            if(isset($_REQUEST['cod_equipo_partido']))
            $partido->deleteByEquipo(isset($_REQUEST['cod_equipo_partido']));
            
        
        }
        //Volvemos a cargar la vista para que se actualice y le pasamos el equipo, errores y jugadores
        $this->view->show("equiposBorrarView.php", array('equipo' => $equipo, 'errores' => $errores,  'jugadores' => $jugadores));
       
      
    }

}
    // Método para borrar un equipo 
    public function borrar() {
        //Incluye el modelo que corresponde
        require_once 'models/EquiposModel.php';
        //Incluimos jugadores y partidos para poder borrarlos si el usuario quiere
        require_once 'models/JugadoresModel.php';
        require_once 'models/PartidosModel.php';

        //Creamos las instancias de los modelos
        $equipos = new EquiposModel();
        $jugadores = new JugadoresModel();
        $partidos = new PartidosModel();

        // Recupera el equipo con el código recibido por GET o por POST
        $equipo = $equipos->getById(($_REQUEST['cod_equipo']));
        //Recuperamos todos los jugadores y partidos asociados al equipo (si los hay)
        $jugadores = $jugadores->getByEquipo(($_REQUEST['cod_equipo']));
        $partidos = $partidos->getByEquipo(($_REQUEST['cod_equipo']));
       
        if ($equipo == null) {
            $this->view->show("errorView.php", array('error' => 'No existe codigo'));
        } 
         //Creamos un array de errores
         $errores = array();
            //Si el equipo tiene jugadores o partidos asociados no se puede borrar
            if ($jugadores != null ) {
                $errores['borrarJugadores'] = "* No se puede borrar el equipo porque tiene jugadores asociados.";
            }
            if ($partidos != null) {
                $errores['borrarPartidos'] = "* No se puede borrar el equipo porque tiene partidos asociados.";
            }
                // Si no hay errores actualizamos en la BD
             if (empty($errores)) {
            // Si se ha pulsado el botón de borrar
                if (isset($_REQUEST['submit'])) {   
                $equipo->delete();
                header("Location: index.php?controlador=Equipos&accion=listar");
            }
           
        }
        // Si no se ha pulsado el botón de actualizar se carga la vista para editar el equipo
        $this->view->show("equiposBorrarView.php", array('equipo' => $equipo, 'errores' => $errores, 'jugadores' => $jugadores, 'partidos' => $partidos));
           
        }
    }


?>