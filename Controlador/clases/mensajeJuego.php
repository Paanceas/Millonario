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
          case '4':
            $men="De clic en jugar";
            $tipoAlert ="warning";
            break;
            case '5':
              $men="Ya tenemos un ganador";
              $tipoAlert ="info";
              break;
              case '6':
                $men="por loca";
                $tipoAlert ="info";
                break;
    }
    if (!empty($men)) {
      echo '<div style="font-size: 18px;" class="alert alert-'.$tipoAlert.' alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      '.$men.'
      </div>';
    }
  }
}


 ?>
