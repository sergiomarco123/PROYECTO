<script src="https://kit.fontawesome.com/60a88d0bd1.js" crossorigin="anonymous"></script>
<?php
session_start();
define ('FPAG',10); // Número de filas por página


require_once 'app/helpers/util.php';
require_once 'app/config/configDB.php';
require_once 'app/models/Cliente.php';
require_once 'app/models/Usuario.php';
require_once 'app/models/AccesoDatosPDO.php';
require_once 'app/controllers/crudclientes.php';
require('fpdf/fpdf.php');

//---- PAGINACIÓN ----
$midb = AccesoDatos::getModelo();
$totalfilas = $midb->numClientes();
if ( $totalfilas % FPAG == 0){
    $posfin = $totalfilas - FPAG;
} else {
    $posfin = $totalfilas - $totalfilas % FPAG;
}

if ( !isset($_SESSION['posini']) ){
  $_SESSION['posini'] = 0;
}
$posAux = $_SESSION['posini'];
//------------

// Borro cualquier mensaje "
$_SESSION['msg']=" ";

ob_start(); // La salida se guarda en el bufer

if (  isset($_POST['Login'])){
    switch($_POST['Login']) {
        case "Iniciar Sesion" :
            LogIn($_POST['login'],$_POST['contraseña']); break;     
    }
}

if(!isset($_SESSION['checkLogin']) || $_SESSION['checkLogin']==4){
    //creo sesion checkLogin para que el usuario no pueda acceder sin iniciar sesion
    //$_SESSION['vista']="login";
    $_SESSION['fallo']="";
    $_SESSION['numError']=0;
    require_once "app/views/login.php"; 


}else if($_SESSION['checkLogin']==2){
    echo $_SESSION['fallo'];
    $_SESSION['numError']=$_SESSION['numError']+1;
    if($_SESSION['numError']>=3)echo "<script>alert('BLOQUEADO. Debe reiniciar el navegador para intentarlo de nuevo')</script>";
    require_once "app/views/login.php";
    
}
else if($_SESSION['checkLogin']==1){

    if ($_SERVER['REQUEST_METHOD'] == "GET" ){
        
        // Proceso las ordenes de navegación
        if ( isset($_GET['nav'])) {
            switch ( $_GET['nav']) {
                case "Primero"  : $posAux = 0; break;
                case "Siguiente": $posAux +=FPAG; if ($posAux > $posfin) $posAux=$posfin; break;
                case "Anterior" : $posAux -=FPAG; if ($posAux < 0) $posAux =0; break;
                case "Ultimo"   : $posAux = $posfin;break;
                case "CSesion": $_SESSION['checkLogin']=4;header("Location: index.php");
            }
            $_SESSION['posini'] = $posAux;
        }

            // Proceso las ordenes para ordenar. CLICK EN LA TABLA TH
            if ( isset($_GET['ord'])) {
                switch ( $_GET['ord']) {
                    case "id"  : 
                        header("Location: index.php");
                        $_SESSION['ordenacion']="id"; 
                        break;
                    case "nombre":
                        header("Location: index.php");
                        $_SESSION['ordenacion']="first_name";                        
                        break;
                    case "email":
                        header("Location: index.php");
                        $_SESSION['ordenacion']="email"; 
                        break;
                    case "gen":
                        header("Location: index.php");
                        $_SESSION['ordenacion']="gender"; ;
                        break;
                    case "ip":
                        header("Location: index.php");
                        $_SESSION['ordenacion']="ip_address"; 
                        break;
                    case "tel":
                        header("Location: index.php");
                        $_SESSION['ordenacion']="telefono";   
                }
                $_SESSION['posini'] = $posAux;
            }


        // Proceso las ordenes de navegación en detalles
        if ( isset($_GET['nav-detalles']) && isset($_GET['id']) ) {
        switch ( $_GET['nav-detalles']) {
            case "Siguiente": crudDetallesSiguiente($_GET['id']); break;
            case "Anterior" : crudDetallesAnterior($_GET['id']); break;
            case "Imprimir": GenerarPDF();
        }
        }

        // Proceso de ordenes de CRUD clientes
        if ( isset($_GET['orden'])){
            switch ($_GET['orden']) {
                case "Nuevo"    : crudAlta(); break;
                case "Borrar"   : crudBorrar   ($_GET['id']); break;
                case "Modificar": crudModificar($_GET['id']); break;
                case "Detalles" : crudDetalles ($_GET['id']);break;
                case "Terminar" : crudTerminar(); break;
            }
        }
    } 
    // POST Formulario de alta o de modificación
    else {
        if (  isset($_POST['orden'])){
            switch($_POST['orden']) {
                case "Nuevo"    : crudPostAlta(); break;
                case "Modificar": crudPostModificar(); break;
                case "SiguienteMod": crudModificarSiguiente($_POST['id']); break;
                case "AnteriorMod" : crudModificarAnterior($_POST['id']); break;
                case "Detalles":; // No hago nada
            }
        }
    }
    // Si no hay nada en la buffer 
    // Cargo genero la vista con la lista por defecto
    if ( ob_get_length() == 0){
        $db = AccesoDatos::getModelo();
        $posini = $_SESSION['posini'];
        $tvalores = $db->getClientes($_SESSION['ordenacion'],$posini,FPAG);



        require_once "app/views/list.php";    
    }
}
$contenido = ob_get_clean();
$msg = $_SESSION['msg'];
// Muestro la página principal con el contenido generado
require_once "app/views/principal.php";

