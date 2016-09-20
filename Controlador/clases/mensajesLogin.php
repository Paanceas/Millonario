<?php

class MensajesLogin
{
    public static function mensajesIngreso($tipo)
    {
        switch ($tipo) {
            case '1':
                $men = "Verifica tus credenciales";
                $tipoAlert="warning";

                break;
                case '2':
                    $men = "Por favor Inicia sesión";
                    $tipoAlert="warning";
                  break;
                    case '3':
                        $men = "Hay una sesión iniciado con este usuario";
                        $tipoAlert="warning";
                        break;
                        case '4':
                        $men = "Clave modificada con éxito";
                        $tipoAlert="info";
                          break;
                          case '5':
                          $men = "No se pudo modificar la clave";
                          $tipoAlert="warning";
                            break;
                            case '6':
                            $men = "El correo ingresado no existe";
                            $tipoAlert="warning";
                              break;
        }

        if (!empty($men)) {
          echo '<div style="font-size: 18px; font-family: sans-serif" class="alert alert-dismissible alert-'.$tipoAlert.'" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Ooops<br></strong>' . $men . '
          </div>';
        }


    }
}
?>
