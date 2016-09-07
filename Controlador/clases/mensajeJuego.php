<?php
/**
 *
 */
class mensajeJuego
{

  public static function msnJuego($tipo)
  {
    switch ($tipo) {
      case '1':
        $men="Ya completaste la prueba";
        $tipoAlert ="info";
        break;
      case '2':
        $men="No Tienes mas intentos";
        $tipoAlert ="warning";
        break;
        case '3':
          $men="Menos una vida";
          $tipoAlert ="warning";
          break;

    }
    if (!empty($men)) {
      echo '<div class="alert alert-'.$tipoAlert.' alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      '.$men.'
      </div>';
    }
  }
}


 ?>
