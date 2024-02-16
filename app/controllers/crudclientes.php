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
    $_SESSION['idCliente']=$cli->id;
    if($cli->img_name==null){
        $ultimoNumero = substr($cli->id, -2);
        $_SESSION['img']='0000000' .$ultimoNumero.'.jpg';
    }
    include_once "app/views/detalles.php";
}

function crudDetallesSiguiente($id){//IMPLEMENTAR
    $db = AccesoDatos::getModelo();
    $cli = $db->getClienteSiguiente($id);
    $_SESSION['idCliente']=$cli->id;
    if($cli==false){
        $cli = $db->getClienteSiguiente($id-1);
        include_once "app/views/detalles.php";
    }
    else{
       /* if($cli->img_name==null){
            $ultimoNumero = substr($cli->id, -2);
            $_SESSION['img']='0000000' .$ultimoNumero.'.jpg';
        }*/
      include_once "app/views/detalles.php";  
    }
}

function crudDetallesAnterior($id){//IMPLEMENTAR
    $db = AccesoDatos::getModelo();
    $cli = $db->getClienteAnterior($id);
    $_SESSION['idCliente']=$cli->id;
    if($cli==false){
        $cli = $db->getClienteAnterior($id+1);
        include_once "app/views/detalles.php";
    }
    else{
        if($cli->img_name==null){
            $ultimoNumero = substr($cli->id, -2);
            $_SESSION['img']='0000000' .$ultimoNumero.'.jpg';
        }  
      include_once "app/views/detalles.php";  
    }    
}

function crudModificarSiguiente($id){//IMPLEMENTAR
    $db = AccesoDatos::getModelo();
    $cli = $db->getClienteSiguiente($id);
    if($cli==false){
        $cli = $db->getClienteSiguiente($id-1);
        $orden="Modificar";
        include_once "app/views/formulario.php";
    }
    else{
        $orden="Modificar";
        include_once "app/views/formulario.php";  
    }
}

function crudModificarAnterior($id){//IMPLEMENTAR
    $db = AccesoDatos::getModelo();
    $cli = $db->getClienteAnterior($id);
    if($cli==false){
        $cli = $db->getClienteAnterior($id+1);
        $orden="Modificar";
        include_once "app/views/formulario.php";
    }
    else{
        $orden="Modificar";
        include_once "app/views/formulario.php";  
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

function GenerarPDF(){
    $db = AccesoDatos::getModelo();
    $cli = $db->getCliente($_SESSION['idCliente']);

    $pdf = new FPDF();
    //$pdf->Header();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',20);
    $pdf->Cell(10,10,"CRUD version 1.1",0,1);
    $pdf->Cell(10,10,"",0,1);

    $pdf->SetFont('Arial','I',16);
    $pdf->Cell(10,10,"Cliente: $cli->id",0,1);
    $pdf->Image("https://robohash.org/".$_SESSION['img'].".jpg", 140, 30, 40, 0);
    
    $pdf->SetFont('Arial','I',12);
    $pdf->Cell(40,10,"Nombre: $cli->first_name",0,1);
    $pdf->Cell(40,10,"Apellido: $cli->last_name",0,1);
    $pdf->Cell(40,10,"Email: $cli->email",0,1);
    $pdf->Cell(40,10,"Genero: $cli->gender",0,1);
    $pdf->Cell(40,10,"IP: $cli->ip_address",0,1);
    $pdf->Cell(40,10,"Numero de telefono: $cli->telefono",0,1);
    $pdf->Output();
}

function LogIn($usuario, $contraseña){
    $db = AccesoDatos::getModelo();
    $cli = $db->checkLogIn($usuario);
    //los botones modificar y borrar aparecen o desaparecen desde list.php
    if($cli==false){
        $_SESSION['vista']="login";
        $_SESSION['checkLogin']=2;
        $_SESSION['fallo']= "<script>alert('No Existe el usuario')</script>";
    }
    else{
        if(password_verify($contraseña, $cli->password)==1){
            $_SESSION['rol']=$cli->rol;
            $_SESSION['NombreUser']=$cli->login;
            $_SESSION['checkLogin']=1;  
            $_SESSION['ordenacion']="id";
        }else{
            $_SESSION['checkLogin']=2;
            $_SESSION['fallo']=  "<script>alert('Contraseña incorrecta')</script>";
            $_SESSION['vista']="login";
        }
    }
   
    
}



