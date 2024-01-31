<script>
    function validarTel(evento){
	valor = document.getElementsByName("telefono")[0].value;
	if( !(/^\d{9}$/.test(valor)) &&valor!="") {
		alert('Formato numero de telefono incorrecto')
        document.getElementsByName("telefono")[0].value="";
        document.getElementsByName("telefono")[0].focus();
	    }
    }
    function validarIP(evento){
        valor = document.getElementsByName("ip_address")[0].value;
        if(!(/^(\d{1,3}\.){3}\d{1,3}$/.test(valor))&&valor!=""){
            alert('Formato numero de ip incorrecto')
            document.getElementsByName("ip_address")[0].value=""; 
            document.getElementsByName("ip_address")[0].focus(); 
        }
    }

    function asignarEventos(evento) {
        telefono = document.getElementsByName("telefono")[0];
        ip = document.getElementsByName("ip_address")[0];
		if (document.readyState == 'complete') {
			telefono.addEventListener('focusout', validarTel);
			ip.addEventListener('focusout', validarIP);
		}
	}
    document.addEventListener('readystatechange', asignarEventos, false);
</script>
<hr>
<form   method="POST" action="http://localhost/ejerciciosPHP/EjeMockaroo-CRUD/app/models/guardar.php" enctype="multipart/form-data">
<table>
 <tr><td>id:</td> 
 <td><input type="number" name="id" value="<?=$cli->id ?>"  readonly  ></td></tr>
 </tr>
 <tr><td>first_name:</td> 
 <td><input type="text" name="first_name" value="<?=$cli->first_name ?>" autofocus  ></td></tr>
 </tr>
 <tr><td>last_name:</td> 
 <td><input type="text" name="last_name" value="<?=$cli->last_name ?>"  ></td></tr>
 </tr>
 <tr><td>email:</td> 
 <td><input type="email" name="email" value="<?=$cli->email ?>"  ></td></tr>
 </tr>
 <tr><td>gender</td> 
 <td><input type="text" name="gender" value="<?=$cli->gender ?>"  ></td></tr>
 </tr>
 <tr><td>ip_address:</td> 
 <td><input type="text" name="ip_address" value="<?=$cli->ip_address ?>"  ></td></tr>
 </tr>
 <tr><td>telefono:</td> 
 <td><input type="tel" name="telefono" value="<?=$cli->telefono ?>"  ></td></tr>
 </tr>
 <tr><td>Sube una imagen:</td>
    <td><input type="file" name="subirfoto" /></td></tr>
 </table>
 <input type="submit"	 name="orden" 	value="<?=$orden?>">
 <input type="submit"	 name="orden" 	value="Volver">
</form> 

