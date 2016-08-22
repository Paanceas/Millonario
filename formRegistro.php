<?php session_start(); ?>
<html>
	<head>
		<title>Formulario de Registro</title>

    <?php
      @include('modalinstrucc.php');//Diseño
      @include('config.php');//Conexion
      @include('registro.php');

    ?>
	</head>
	<body>
    <header></header>
      <figure><center><img src="img/banner.png" alt="banner juego autoevaluación" width="500"></center></figuer>
        <article class="loginData">
          <form action="registro.php" method="post">
            <div class="form">

              <section>
                <h1>DATOS DE INGRESO</h1>

                <input type="text" placeholder="Nombre Completo" class="inp02" name="nombres" id="nombres">
                <br>
                <select id ="tIdentificacion" class="inp02" required="">
                  <option value="null">Seleccione</option>
                  <?php lol(); ?>
                </select>

                <input type="text" placeholder="Número Documento" name="documento" class="inp02" size="40">
                <select id ="programa" class="inp02" required="">
                  <option value="null">Seleccione</option>
                  <?php echo $programaFormacion; ?>
                </select>

                <input type="email" placeholder="Correo Sena" name="correo" value="" class="inp02" id="correo">
                <input type="password" placeholder="Contraseña" name="clave" value="" class="inp02" id="clave">

                <input type="password" placeholder="Confirme Contraseña" name="confirm" value="" class="inp02" id="clave2">

                <button type="submit" class="btn btn-primary2">Registrate</button>

            <br>
          </section>
        </div>
      </form>

    </article>

	</body>
</html>
