<?php session_start(); ?>
<html>
	<head>
		<title>Formulario de Registro</title>
		<link rel="stylesheet" href="../Bootstrap/css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
			<link rel="stylesheet" href="../source/css/animate.css" media="screen" title="no title" charset="utf-8">
    <?php
      @include('modalinstrucc.php');//Diseño
      @include('../Conexion/config.php');//Conexion
      @include('../Controlador/registroPersona.php');
			require('../Controlador/clases/mensajes.php');
    ?>
	</head>
	<body>

    <header></header>
      <figure><center><img src="../source/img/banner.png" alt="banner juego autoevaluación" width="500"></center></figuer>
				<div class="container animated zoomIn">
					<?php
					if(isset($_GET["MSN"])){
						MensajesJuego::mensajesRegistroPersona($_GET["MSN"]);
					}
					 ?>
				</div>
        <article class="loginData">
          <form action="../Controlador/registroPersona.php" method="post">
            <div class="form">

              <section>
                <h1>DATOS DE INGRESO</h1>
                <input type="text" placeholder="Nombre Completo" class="inp02" name="nombres" id="nombres" >
                <br>
                <select name="tipoIdentificacion" id ="tIdentificacion" class="inp02" required="">
                  <option value="null">Seleccione</option>
                  <?php echo $tipoIdentificacion; ?>
                </select>

                <input type="text" placeholder="Número Documento" name="documento" class="inp02" size="40">
                <select name="programa" id ="programa" class="inp02" required="">
                  <option value="null">Seleccione</option>
                  <?php echo $programaFormacion; ?>
                </select>

                <input type="email" placeholder="Correo Sena" name="correo" class="inp02" id="correo">
                <input type="password" placeholder="Contraseña" name="clave" class="inp02" id="clave">

                <input type="password" placeholder="Confirme Contraseña" name="confirm" value="" class="inp02" id="clave2">

                <button type="submit" name="registrarse" class="btn btn-primary2">Registrate</button>


            <br>
          </section>
        </div>

      </form>

    </article>

	</body>
</html>
