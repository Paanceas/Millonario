<?php
/**
 *
 */
class mensajesRecuperarPass
{

  public static function recuperarPass($tipo)

  {
    switch ($tipo) {
      case '1':
          $men = "Llene el campo clave";
          $tipoAlert="warning";
          break;
      case '1.1':
          $men = "Clave incorrecta, debe tener mínimo 6 caracteres";
          break;
        case '2':
          $men= "Las claves no coinciden";
          $tipoAlert="warning";
          break;
        case '3':
          $men= "No se pudo actualizar la clave";
            $tipoAlert="warning";
            break;


          if (!empty($men)) {
            echo '<div style="font-size: 18px; font-family: sans-serif" class="alert alert-dismissible alert-'.$tipoAlert.'" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Ooops<br></strong>' . $men . '
            </div>';
          }
    }
  }
}


 ?>
