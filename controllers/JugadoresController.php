<?php
// Controlador para el modelo JugadorModel (puede haber más controladores en la aplicación)
// Un controlador no tiene porque estar asociado a un objeto del modelo
class JugadoresController {
    // Atributo con el motor de plantillas del microframework
    protected $view;

    // Constructor. Únicamente instancia un objeto View y lo asigna al atributo
    function __construct() {
        //Creamos una instancia de nuestro mini motor de plantillas
        $this->view = new View();
        $this->view->show("menuNav.php");
        
    }

    // Método del controlador para listar los jugadores almacenados
    public function listar() {
        //Incluye el modelo que corresponde
        require 'models/JugadoresModel.php';

        //Creamos una instancia de nuestro "modelo"
        $jugadores = new JugadoresModel();

        //Le pedimos al modelo todos los jugadores
        $listado = $jugadores->getAll();

        //Pasamos a la vista toda la información que se desea representar
        $data['jugadores'] = $listado;

        // Finalmente presentamos nuestra plantilla 
        // Llamamos al método "show" de la clase View, que es el motor de plantillas
        // Genera la vista de respuesta a partir de la plantilla y de los datos
        $this->view->show("jugadoresListarView.php", $data);
    }

    // Método del controlador para crear un nuevo jugador
    public function nuevo() {
        require 'models/JugadoresModel.php';
        //Incluimos el modelo equiposModel para poder hacer el desplegable de equipos
        require 'models/EquiposModel.php';  

        $jugador = new JugadoresModel();
        $equipos = new EquiposModel();
         //Recuperamos todos los equipos para poder hacer el desplegable
        $equipos = $equipos->getAll();

        $errores = array();

            // Si se ha pulsado el botón de submit
        if (isset($_REQUEST['submit'])) {

            // Comprobamos si se ha recibido el nombre
            if (!isset($_REQUEST['nombre_jugador']) || empty($_REQUEST['nombre_jugador']))
                $errores['nombre_jugador'] = "* Nombre: debes indicar un nombre.";

            // Comprobamos si se ha recibido la fecha de nacimiento
            if (!isset($_REQUEST['fecha_nacimiento']) || empty($_REQUEST['fecha_nacimiento']))
                $errores['fecha_nacimiento'] = "* Fecha nacimiento: debes indicar un año de nacimiento.";
            // Comprobamos si se ha recibido la estatura
            if (!isset($_REQUEST['estatura']) || empty($_REQUEST['estatura']))
                $errores['estatura'] = "* Estatura: debes indicar una estatura.";
            // Comprobamos si se ha recibido la posicion
            if (!isset($_REQUEST['posicion']) || empty($_REQUEST['posicion']))
                $errores['posicion'] = "* Posicion: debes indicar una posicion.";
            // Comprobamos si se ha recibido el equipo
            if (!isset($_REQUEST['equipo']) || empty($_REQUEST['equipo']))
                $errores['equipo'] = "* Equipo: debes indicar un equipo.";

            // Si no hay errores actualizamos en la BD
            if (empty($errores)) {
               // Cambia el valor del jugador y lo guarda en BD
               $jugador->setNOMBRE_JUGADOR($_REQUEST['nombre_jugador']);
               $jugador->setFECHA_NACIMIENTO($_REQUEST['fecha_nacimiento']);
               $jugador->setESTATURA($_REQUEST['estatura']);
               $jugador->setPOSICION($_REQUEST['posicion']);
               $jugador->setEQUIPO($_REQUEST['equipo']);
               $jugador->create();


                // Finalmente llama al método listar para que devuelva vista con listado
                header("Location: index.php?controlador=Jugadores&accion=listar");
            }
        }

        $this->view->show("jugadoresNuevoView.php", array('errores' => $errores,'equipos' => $equipos));

    }

    

    // Método que procesa la petición para editar un jugador
    public function editar() {

        require 'models/JugadoresModel.php';
        //Incluimos el modelo equiposModel para poder hacer el desplegable de equipos
        require 'models/EquiposModel.php';

        $jugadores = new JugadoresModel();
        $equipos = new EquiposModel();

        // Recuperar el jugador con el código recibido
        $jugador = $jugadores->getById($_REQUEST['cod_jugador']);
        //Recuperamos todos los equipos para poder hacer el desplegable
        $equipos = $equipos->getAll();

        if ($jugador == null) {
            $this->view->show("errorView.php", array('error' => 'No existe codigo'));
        }

        $errores = array();

        // Si se ha pulsado el botón de actualizar
        if (isset($_REQUEST['submit'])) {

            // Comprobamos si se ha recibido el nombre
            if (!isset($_REQUEST['nombre_jugador']) || empty($_REQUEST['nombre_jugador']))
                $errores['nombre_jugador'] = "* Nombre: debes indicar un nombre.";

            // Comprobamos si se ha recibido la fecha de nacimiento
            if (!isset($_REQUEST['fecha_nacimiento']) || empty($_REQUEST['fecha_nacimiento']))
                $errores['fecha_nacimiento'] = "* Fecha nacimiento: debes indicar un año de nacimiento.";
            // Comprobamos si se ha recibido la estatura
            if (!isset($_REQUEST['estatura']) || empty($_REQUEST['estatura']))
                $errores['estatura'] = "* Estatura: debes indicar una estatura.";
            // Comprobamos si se ha recibido la posicion
            if (!isset($_REQUEST['posicion']) || empty($_REQUEST['posicion']))
                $errores['posicion'] = "* Posicion: debes indicar una posicion.";
            // Comprobamos si se ha recibido el equipo
            if (!isset($_REQUEST['equipo']) || empty($_REQUEST['equipo']))
                $errores['equipo'] = "* Equipo: debes indicar un equipo.";

            // Si no hay errores actualizamos en la BD
            if (empty($errores)) {
                // Cambia el valor del jugador y lo guarda en BD
                $jugador->setNOMBRE_JUGADOR($_REQUEST['nombre_jugador']);
                $jugador->setFECHA_NACIMIENTO($_REQUEST['fecha_nacimiento']);
                $jugador->setESTATURA($_REQUEST['estatura']);
                $jugador->setPOSICION($_REQUEST['posicion']);
                $jugador->setEQUIPO($_REQUEST['equipo']);
                $jugador->update();

                // Reenvía a la aplicación a la lista de jugadores
                header("Location: index.php?controlador=Jugadores&accion=listar");
            }
        }

        // Si no se ha pulsado el botón de actualizar se carga la vista para editar el jugador
        $this->view->show("jugadoresEditarView.php", array('jugador' => $jugador, 'errores' => $errores, 'equipos' => $equipos));

    }

    // Método para borrar un jugador 
    public function borrar() {
        //Incluye el modelo que corresponde
        require_once 'models/JugadoresModel.php';
        //Creamos una instancia de nuestro "modelo"
        $jugadores = new JugadoresModel();
        // Recupera el jugador con el código recibido por GET o por POST
        $jugador = $jugadores->getById($_REQUEST['cod_jugador']);

        if ($jugador == null) {
            $this->view->show("errorView.php", array('error' => 'No existe codigo'));
        } 
        // Si se ha pulsado el botón de borrar
        if (isset($_REQUEST['submit'])) {   
            $jugador->delete();
            header("Location: index.php?controlador=Jugadores&accion=listar");
            }
             // Si no se ha pulsado el botón de actualizar se carga la vista para editar el jugador
        $this->view->show("jugadoresBorrarView.php", array('jugador' => $jugador));
           
        }
    }


?>