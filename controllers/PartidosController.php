<?php
// Controlador para el modelo ItemModel (puede haber más controladores en la aplicación)
// Un controlador no tiene porque estar asociado a un objeto del modelo
class PartidosController {
    // Atributo con el motor de plantillas del microframework
    protected $view;

    // Constructor. Únicamente instancia un objeto View y lo asigna al atributo
    function __construct() {
        //Creamos una instancia de nuestro mini motor de plantillas
        $this->view = new View();
        $this->view->show("menuNav.php");
    }

    // Método del controlador para listar los partidos almacenados
    public function listar() {
        //Incluye el modelo que corresponde
        require 'models/PartidosModel.php';

        //Creamos una instancia de nuestro "modelo"
        $partidos = new PartidosModel();

        //Le pedimos al modelo todos los partidos
        $listado = $partidos->getAll();

        //Pasamos a la vista toda la información que se desea representar
        $data['partidos'] = $listado;

        // Finalmente presentamos nuestra plantilla 
        // Llamamos al método "show" de la clase View, que es el motor de plantillas
        // Genera la vista de respuesta a partir de la plantilla y de los datos
        $this->view->show("partidosListarView.php", $data);
    }

    // Método del controlador para crear un nuevo partido
    public function nuevo() {
        require 'models/PartidosModel.php';
        //Incluimos el modelo equiposModel para poder hacer el desplegable de equipos
        require 'models/EquiposModel.php';  

        $partido = new PartidosModel();
        $equipos = new EquiposModel();
         //Recuperamos todos los equipos para poder hacer el desplegable
        $equipos = $equipos->getAll();

        $errores = array();

            // Si se ha pulsado el botón de submit
        if (isset($_REQUEST['submit'])) {
           
          
            // Comprobamos si se ha recibido la fecha de partido
            if (!isset($_REQUEST['fecha']) || empty($_REQUEST['fecha']))
                $errores['fecha'] = "* Fecha: debes indicar una fecha de partido.";
            // Comprobamos si se ha recibido el cod_equipo1
            if (!isset($_REQUEST['cod_equipo1']) || empty($_REQUEST['cod_equipo1']))
                $errores['cod_equipo1'] = "* Código Equipo 1: debes seleccionar un equipo 1";
           // Comprobamos si se ha recibido el cod_equipo2
           if (!isset($_REQUEST['cod_equipo2']) || empty($_REQUEST['cod_equipo2']))
           $errores['cod_equipo2'] = "* Código Equipo 2: debes seleccionar un cod_equipo2 1";
            // Comprobamos si se ha recibido el numero de puntos del equipo 1
            if (!isset($_REQUEST['puntos_equipo1']) || empty($_REQUEST['puntos_equipo1']))
                $errores['puntos_equipo1'] = " Puntos Equipo 1 : debes indicar un número de puntos.";
             // Comprobamos si se ha recibido el numero de puntos del equipo 2
             if (!isset($_REQUEST['puntos_equipo2']) || empty($_REQUEST['puntos_equipo2']))
             $errores['puntos_equipo2'] = " Puntos Equipo 2 : debes indicar un número de puntos.";
              //Comprobamos que el cod_equipo 1 y el cod_equipo2 no sean iguales
                if ($_REQUEST['cod_equipo1'] == $_REQUEST['cod_equipo2']){
                $errores['cod_equipo1'] = "* Código Equipo 1: no puede ser igual al equipo 2";
                $errores['cod_equipo2'] = "* Código Equipo 2: no puede ser igual al equipo 1";
            }

            // Si no hay errores actualizamos en la BD
            if (empty($errores)) {
               // Cambia el valor del partido y lo guarda en BD
               $partido->setFECHA($_REQUEST['fecha']);
               $partido->setCOD_EQUIPO1($_REQUEST['cod_equipo1']);
               $partido->setCOD_EQUIPO2($_REQUEST['cod_equipo2']);
               $partido->setPUNTOS_EQUIPO1($_REQUEST['puntos_equipo1']);
               $partido->setPUNTOS_EQUIPO2($_REQUEST['puntos_equipo2']);
               $partido->create();
                // Finalmente llama al método listar para que devuelva vista con listado
                header("Location: index.php?controlador=Partidos&accion=listar");
            }
        }

        // Si no recibe el partido para añadir, devuelve la vista para añadir un nuevo partido
        $this->view->show("partidosNuevoView.php", array('errores' => $errores,'equipos' => $equipos));

    }

    

    // Método que procesa la petición para editar un partido
    public function editar() {

        require 'models/PartidosModel.php';
        //Incluimos el modelo equiposModel para poder hacer el desplegable de equipos
        require 'models/EquiposModel.php';

        $partidos = new PartidosModel();
        $equipos = new EquiposModel();

        // Recuperar el partido con el código recibido
        $partido = $partidos->getById($_REQUEST['cod_partido']);
        //Recuperamos todos los equipos para poder hacer el desplegable
        $equipos = $equipos->getAll();

        if ($partido == null) {
            $this->view->show("errorView.php", array('error' => 'No existe codigo'));
        }

        $errores = array();

        // Si se ha pulsado el botón de actualizar
        if (isset($_REQUEST['submit'])) {

            // Comprobamos si se ha recibido la fecha de partido
            if (!isset($_REQUEST['fecha']) || empty($_REQUEST['fecha']))
                $errores['fecha'] = "* Fecha: debes indicar una fecha de partido.";
            // Comprobamos si se ha recibido el cod_equipo1
            if (!isset($_REQUEST['cod_equipo1']) || empty($_REQUEST['cod_equipo1']))
                $errores['cod_equipo1'] = "* Código Equipo 1: debes seleccionar un equipo 1";
           // Comprobamos si se ha recibido el cod_equipo2
           if (!isset($_REQUEST['cod_equipo2']) || empty($_REQUEST['cod_equipo2']))
           $errores['cod_equipo2'] = "* Código Equipo 2: debes seleccionar un cod_equipo2 1";
            // Comprobamos si se ha recibido el numero de puntos del equipo 1
            if (!isset($_REQUEST['puntos_equipo1']) || empty($_REQUEST['puntos_equipo1']))
                $errores['puntos_equipo1'] = " Puntos Equipo 1 : debes indicar un número de puntos.";
             // Comprobamos si se ha recibido el numero de puntos del equipo 2
             if (!isset($_REQUEST['puntos_equipo2']) || empty($_REQUEST['puntos_equipo2']))
             $errores['puntos_equipo2'] = " Puntos Equipo 2 : debes indicar un número de puntos.";
              //Comprobamos que el cod_equipo 1 y el cod_equipo2 no sean iguales
                if ($_REQUEST['cod_equipo1'] == $_REQUEST['cod_equipo2']){
                $errores['cod_equipo1'] = "* Código Equipo 1: no puede ser igual al equipo 2";
                $errores['cod_equipo2'] = "* Código Equipo 2: no puede ser igual al equipo 1";
            }
            // Si no hay errores actualizamos en la BD
            if (empty($errores)) {
                // Cambia el valor del partido y lo guarda en BD
                $partido->setFECHA($_REQUEST['fecha']);
                $partido->setCOD_EQUIPO1($_REQUEST['cod_equipo1']);
                $partido->setCOD_EQUIPO2($_REQUEST['cod_equipo2']);
                $partido->setPUNTOS_EQUIPO1($_REQUEST['puntos_equipo1']);
                $partido->setPUNTOS_EQUIPO2($_REQUEST['puntos_equipo2']);
                $partido->update();

                // Reenvía a la aplicación a la lista de partidos
                header("Location: index.php?controlador=Partidos&accion=listar");
            }
        }

        // Si no se ha pulsado el botón de actualizar se carga la vista para editar el partido
        $this->view->show("partidosEditarView.php", array('partido' => $partido, 'errores' => $errores, 'equipos' => $equipos));

    }

    // Método para borrar un partido 
    public function borrar() {
        //Incluye el modelo que corresponde
        require_once 'models/PartidosModel.php';
        //Creamos una instancia de nuestro "modelo"
        $partidos = new PartidosModel();
        // Recupera el partido con el código recibido por GET o por POST
        $partido = $partidos->getById($_REQUEST['cod_partido']);

        if ($partido == null) {
            $this->view->show("errorView.php", array('error' => 'No existe codigo'));
        } 
        // Si se ha pulsado el botón de borrar
        if (isset($_REQUEST['submit'])) {   
            $partido->delete();
            header("Location: index.php?controlador=Partidos&accion=listar");
            }
        // Si no se ha pulsado el botón de actualizar se carga la vista para editar el partido
        $this->view->show("partidosBorrarView.php", array('partido' => $partido));
           
        }
    }


?>