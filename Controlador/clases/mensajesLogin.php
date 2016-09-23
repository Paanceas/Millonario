<?php

class MensajesLogin
{
    public static function mensajesIngreso($tipo)
    {
        switch ($tipo) {
            case '1':
                $men = "Verifica tus credenciales";
                $tipoAlert="danger";

                break;
                case '2':
                    $men = "Por favor Inicia sesión";
                    $tipoAlert="danger";
                  break;
                    case '3':
                        $men = "Hay una sesión iniciado con este usuario";
                        $tipoAlert="danger";
                        break;
                        case '4':
                        $men = "Clave modificada con éxito";
                        $tipoAlert="info";
                          break;
                          case '5':
                          $men = "No se pudo enviar el correo";
                          $tipoAlert="danger";
                            break;
                            case '6':
                            $men = "El correo ingresado no existe";
                            $tipoAlert="danger";
                              break;
                              case '7':
                              $men = "Confirma tu cuenta de correo electrónico";
                              $tipoAlert="info";
                                break;

        }

        if (!empty($men)) {
          echo '<div style="font-size: 18px; font-family: sans-serif" class="alert alert-dismissible alert-'.$tipoAlert.'" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"> &times;</span></button>
          <strong>Ooops<br></strong>' . $men . '
          </div>';
        }


    }
}
?>
