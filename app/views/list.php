
<script>
		function eventoID(evento) {
			document.location.href="?ord=id";
		}
        function eventoNombre(evento) {
			document.location.href="?ord=nombre";
		}
        function eventoEmail(evento) {
			document.location.href="?ord=email";
		}
        function eventoGen(evento) {
			document.location.href="?ord=gen";
		}
        function eventoIp(evento) {
			document.location.href="?ord=ip";
		}
        function eventoTel(evento) {
			document.location.href="?ord=tel";
		}
    	function asignarEventos(evento) {
		var i;
		if (document.readyState == 'complete') {
		    document.getElementById('id').addEventListener('click', eventoID, true);
            document.getElementById('nombre').addEventListener('click', eventoNombre, true);
            document.getElementById('email').addEventListener('click', eventoEmail, true);
            document.getElementById('genero').addEventListener('click', eventoGen, true);
            document.getElementById('ip').addEventListener('click', eventoIp, true);
            document.getElementById('tel').addEventListener('click', eventoTel, true);
		}
			}
    document.addEventListener('readystatechange', asignarEventos, false);
</script>
<form>
<button type="submit" name="orden" value="Nuevo"> Cliente Nuevo </button><br>
</form>
<br>
<p>Para ordenar de menor a mayor haga click sobre el titulo de la tabla</p>

<table>
<tr><th id="id">id</th><th id="nombre">first_name</th><th id="email">email</th>
<th id="genero">gender</th><th id="ip">ip_address</th><th id="tel">teléfono</th></tr>
<?php foreach ($tvalores as $valor): ?>
<tr>
<td><?= $valor->id ?> </td>
<td><?= $valor->first_name ?> </td>
<td><?= $valor->email ?> </td>
<td><?= $valor->gender ?> </td>
<td><?= $valor->ip_address ?> </td>
<td><?= $valor->telefono ?> </td>
<td><a href="#" onclick="confirmarBorrar('<?=$valor->first_name?>',<?=$valor->id?>);" >Borrar</a></td>
<td><a href="?orden=Modificar&id=<?=$valor->id?>">Modificar</a></td>
<td><a href="?orden=Detalles&id=<?=$valor->id?>" >Detalles</a></td>

<tr>
<?php endforeach ?>
</table>

<form>
<br>
<button type="submit" name="nav" value="Primero"> << </button>
<button type="submit" name="nav" value="Anterior"> < </button>
<button type="submit" name="nav" value="Siguiente"> > </button>
<button type="submit" name="nav" value="Ultimo"> >> </button>
</form>
