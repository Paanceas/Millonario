<?php

class MensajesJuego
{
  public static function mensajesRegistroPersona($tipo) {
    switch ($tipo) {
      case '1':
        $men = "Error en las Claves";
        break;
        case '2':
          $men = "Documento ya existe";
          break;
    }

    if (!empty($men)) {
      echo '<div class="alert alert-dismissible alert-danger">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Ooops<br></strong>'.$men.'
    </div>';
  }
  if ($tipo == 'ok') {
    echo '<div class="alert alert-dismissible alert-success">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Genial!!<br></strong> Se registro el Aprediz exitosamente
</div>';
  }
  }
}







?>
