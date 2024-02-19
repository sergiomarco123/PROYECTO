LA BASE DE DATOS ESTA ACTUALIZADA

CONTRASEÑA PARA AMBOS USUARIOS SIN CIFRAR: 123

1.	Mostrar en detalles y en modificar la opción de siguiente y anterior 
SOLUCIÓN: también lo muestra en detalles

2.	Mostrar la lista de clientes con distintos modos de ordenación: nombre, apellido, correo electrónico, género o IP y poder navegar por ella. 
(EVENTO CREADO DESDE JS, ordena de menor a mayor haciendo clic sobre la primera fila de la tabla)
SOLUCIÓN: al cambiar de página mantiene el orden.

3.	Mejorar las operaciones de Nuevo y Modificar para que chequee que los datos son correctos:  correo electrónico (no repetido), IP y  teléfono con formato 999-999-9999.
(EVENTOS CREADOS, verifica el email desde AccesoDatosPDO y el formato de IP y teléfono desde js con métodos regulares)

4.	Mostrar una imagen asociada al cliente almacenada previamente en uploads o una imagen por defecto aleatoria generada por https://robohasp.org.  sin no existe. En nombre de las fotos tiene el formato 00000XXX.jpg para el cliente con id XXX.
   Coge la imagen de los robots.

7.	Generar un PDF con los todos detalles de un cliente ( Incluir un botón que indique imprimir).
   Botón implementado en detalles.

8.	Crear una nueva tabla en la BD de usuarios de la aplicación (User)  con tres campos: login, password( encriptada )  y rol (0/1), definir varios usuarios y controlar el acceso a la aplicación sólo si se introduce el login y el password correctos. Si se realizan más de tres intentos erróneos se solicitará que se reinicie el navegador.
Comprueba la contraseña encriptada con password verify.

Creo la sesión CheckLogin para que el usuario no pueda moverse con las url sin iniciar sesión.

CheckLogin:1 permite iniciar sesión
CheckLogin:2 Muestra fallo Login
CheckLogin Rol: 4 Cerrar Sesión;

Sesión numError creada para gestionar el numero de intentos.

9.	Controlar el acceso a la aplicación en función del rol, si es 0 solo puede acceder a visualizar los datos: lista y detalles. Si el rol es 1 podrá además modificar, borrar y eliminar usuarios.
Creado función Login en CrudClientes, desde list.php muestra los botones
