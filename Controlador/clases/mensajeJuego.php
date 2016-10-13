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
        $men="¡ FELICITACIONES ERES EL GRAN GANADOR !";
        $tipoAlert ="success";
        break;
      case '2':
        $men="No Tienes mas intentos";
        $tipoAlert ="warning";
        break;
        case '3':
          $men="Menos una vida";
          $tipoAlert ="warning";
          break;
          case '4':
            $men="Haga clic en jugar";
            $tipoAlert ="warning";
            break;
            case '5':
              $men="Ya tenemos un ganador";
              $tipoAlert ="info";
              break;

    }
    if (!empty($men)) {
      echo '<div style="font-size: 18px; text-align:center;" class="alert alert-'.$tipoAlert.' alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      '.$men.'
      </div>';
    }
  }
}


 ?>
