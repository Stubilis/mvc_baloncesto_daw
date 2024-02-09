<?php
// Controlador para el modelo ZonaModel (puede haber más controladores en la aplicación)
// Un controlador no tiene porque estar asociado a un objeto del modelo
class ZonasController {
    // Atributo con el motor de plantillas del microframework
    protected $view;

    // Constructor. Únicamente instancia un objeto View y lo asigna al atributo
    function __construct() {
        //Creamos una instancia de nuestro mini motor de plantillas
        $this->view = new View();
        $this->view->show("menuNav.php");
    }

    // Método del controlador para listar los zonas almacenados
    public function listar() {
        //Incluye el modelo que corresponde
        require 'models/ZonasModel.php';

        //Creamos una instancia de nuestro "modelo"
        $zonas = new ZonasModel();

        //Le pedimos al modelo todos los zonas
        $listado = $zonas->getAll();

        //Pasamos a la vista toda la información que se desea representar
        $data['zonas'] = $listado;

        // Finalmente presentamos nuestra plantilla 
        // Llamamos al método "show" de la clase View, que es el motor de plantillas
        // Genera la vista de respuesta a partir de la plantilla y de los datos
       
        $this->view->show("zonasListarView.php", $data);
    }

    // Método del controlador para crear un nuevo zona
    public function nuevo() {
        require 'models/ZonasModel.php';
        
        $zona = new ZonasModel();
       
        $errores = array();

            // Si se ha pulsado el botón de submit
        if (isset($_REQUEST['submit'])) {

            // Comprobamos si se ha recibido el nombre
            if (!isset($_REQUEST['nombre_zona']) || empty($_REQUEST['nombre_zona']))
                $errores['nombre_zona'] = "* Nombre: debes indicar un nombre.";

            // Si no hay errores actualizamos en la BD
            if (empty($errores)) {
               // Cambia el valor de la zona y lo guarda en BD
               $zona->setNOMBRE_ZONA($_REQUEST['nombre_zona']);
               $zona->create();

                // Finalmente llama al método listar para que devuelva vista con listado
                header("Location: index.php?controlador=Zonas&accion=listar");
            }
        }

        // Si no recibe la zona para añadir, devuelve la vista para añadir un nuevo zona
        $this->view->show("zonasNuevoView.php", array('errores' => $errores));

    }

    

    // Método que procesa la petición para editar una zona
    public function editar() {

        require 'models/ZonasModel.php';
       
        $zonas = new ZonasModel();

        // Recuperar la zona con el código recibido
        $zona = $zonas->getById($_REQUEST['cod_zona']);

        if ($zona == null) {
            $this->view->show("errorView.php", array('error' => 'No existe codigo'));
        }

        $errores = array();

        // Si se ha pulsado el botón de actualizar
        if (isset($_REQUEST['submit'])) {

            // Comprobamos si se ha recibido el nombre
            if (!isset($_REQUEST['nombre_zona']) || empty($_REQUEST['nombre_zona']))
                $errores['nombre_zona'] = "* Nombre: debes indicar un nombre.";

            // Si no hay errores actualizamos en la BD
            if (empty($errores)) {
                // Cambia el valor dla zona y lo guarda en BD
                $zona->setNOMBRE_ZONA($_REQUEST['nombre_zona']);
                $zona->update();

                // Reenvía a la aplicación a la lista de zonas
                header("Location: index.php?controlador=Zonas&accion=listar");
            }
        }

        // Si no se ha pulsado el botón de actualizar se carga la vista para editar la zona
        $this->view->show("zonasEditarView.php", array('zona' => $zona, 'errores' => $errores));

    }

    // Método para borrar un zona 
    public function borrar() {
        //Incluye el modelo que corresponde
        require_once 'models/ZonasModel.php';
        require_once 'models/EquiposModel.php';
        //Creamos una instancia de nuestro "modelo"
        $zonas = new ZonasModel();
        $equipos = new EquiposModel();
        // Recupera la zona con el código recibido por GET o por POST
        $zona = $zonas->getById($_REQUEST['cod_zona']);
        //Buscamos si hay equipos en esa zona   
        $equipos = $equipos->getByZona($_REQUEST['cod_zona']);
        $errores = array();

        if ($zona == null) {
            $errores['cod_zona'] = "* Código: No existe la zona con ese código.";
            
        } 
        if($equipos != null){
            $errores['borrarEquipos'] = "* Código: Existen equipos con esta zona asociada.";
        }
        if (empty($errores)) {
        // Si se ha pulsado el botón de borrar
        if (isset($_REQUEST['submit'])) {   
            $zona->delete();
            header("Location: index.php?controlador=Zonas&accion=listar");
            }
             // Si no se ha pulsado el botón de actualizar se carga la vista para editar la zona
        }
        //Si el error es que hay equipos asociados a la zona mostramos un form para borrado definitivo
        
        $this->view->show("zonasBorrarView.php", array('zona' => $zona,'errores' => $errores, 'equipos' => $equipos));
           
        
    }
}


?>