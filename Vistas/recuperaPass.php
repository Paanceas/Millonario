<?php  //VENTANA MODAL EN EL LOGIN ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Recuperar clave</title>
  </head>
  <body>
    <form action="../Controlador/recuperarPass.php" method="post">
      <input type="email" name="correo" id="correo" placeholder="Correo (sena o misena)" size="26" required=""><br/>
      <button type="submit" name="recuperar" class="botonRegistro">Enviar</button>
    </form>
  </body>
</html>
