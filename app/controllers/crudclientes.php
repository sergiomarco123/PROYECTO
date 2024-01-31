<?php

function crudBorrar ($id){    
    $db = AccesoDatos::getModelo();
    $resu = $db->borrarCliente($id);
    if ( $resu){
         $_SESSION['msg'] = " El usuario ".$id. " ha sido eliminado.";
    } else {
         $_SESSION['msg'] = " Error al eliminar el usuario ".$id.".";
    }

}

function crudTerminar(){
    AccesoDatos::closeModelo();
    session_destroy();
}
 
function crudAlta(){
    $cli = new Cliente();
    $orden= "Nuevo";
    include_once "app/views/formulario.php";
}

function crudDetalles($id){
    $db = AccesoDatos::getModelo();
    $cli = $db->getCliente($id);
    include_once "app/views/detalles.php";
}

function crudDetallesSiguiente($id){//IMPLEMENTAR
    $db = AccesoDatos::getModelo();
    $cli = $db->getClienteSiguiente($id);
    if($cli==false){
        $cli = $db->getClienteSiguiente($id-1);
        include_once "app/views/detalles.php";
    }
    else{
      include_once "app/views/detalles.php";  
    }
}

function crudDetallesAnterior($id){//IMPLEMENTAR
    $db = AccesoDatos::getModelo();
    $cli = $db->getClienteAnterior($id);
    if($cli==false){
        $cli = $db->getClienteAnterior($id+1);
        include_once "app/views/detalles.php";
    }
    else{
      include_once "app/views/detalles.php";  
    }    
}


function crudModificar($id){
    $db = AccesoDatos::getModelo();
    $cli = $db->getCliente($id);
    $orden="Modificar";
    include_once "app/views/formulario.php";
}


function crudPostAlta(){
    limpiarArrayEntrada($_POST); 
    $db = AccesoDatos::getModelo();
    $clic = $db->checkEmail($_POST['email']);
    if($clic==false){
        $cli = new Cliente();
        $cli->id            =$_POST['id'];
        $cli->first_name    =$_POST['first_name'];
        $cli->last_name     =$_POST['last_name'];
        $cli->email         =$_POST['email'];	
        $cli->gender        =$_POST['gender'];
        $cli->ip_address    =$_POST['ip_address'];
        $cli->telefono      =$_POST['telefono'];
        
        if ( $db->addCliente($cli) ) {
               $_SESSION['msg'] = " El usuario ".$cli->first_name." se ha dado de alta ";
            } else {
                $_SESSION['msg'] = " Error al dar de alta al usuario ".$cli->first_name."."; 
            }
    }
    else{
       echo "<script>alert('El email ya esta en uso, pruebe con otro')</script>";
       crudAlta();
    }

}



function crudPostModificar(){
    limpiarArrayEntrada($_POST); //Evito la posible inyección de código
    $cli = new Cliente();

    $cli->id            =$_POST['id'];
    $cli->first_name    =$_POST['first_name'];
    $cli->last_name     =$_POST['last_name'];
    $cli->email         =$_POST['email'];	
    $cli->gender        =$_POST['gender'];
    $cli->ip_address    =$_POST['ip_address'];
    $cli->telefono      =$_POST['telefono'];
    $db = AccesoDatos::getModelo();
    if ( $db->modCliente($cli) ){
        $_SESSION['msg'] = " El usuario ha sido modificado";
    } else {
        $_SESSION['msg'] = " Error al modificar el usuario ";
    }
    
}
