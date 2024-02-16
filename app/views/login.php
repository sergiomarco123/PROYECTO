<form method="post">
<table>
 <tr><td>Usuario:</td> 
 <td><input type="text" name="login" autofocus></td></tr>
 </tr>
 <tr><td>Contraseña:</td> 
 <td><input type="password" name="contraseña"></td></tr>
 </table><br>
 <input type="submit"	 name="Login" 	value="Iniciar Sesion" <?php if ($_SESSION['numError']>=3): ?>disabled <?php endif; ?>>
 <input type="submit"	 name="Login" 	value="Salir">
 
</form> 