<?php

class MensajesJuego
{
    public static function mensajesRegistroPersona($tipo)
    {
        switch ($tipo) {
            case '1':
                $men = "Llene todos los campos";
                break;
            case '2':
                $men = "Llene el campo nombres";
                break;
            case '2.1':
                $men = "Nombre incorrecto";
                break;

            case '3':
                $men = "Llene el campo documento";
                break;
            case '3.1':
                $men = "Documento incorrecto";
                break;
            case '4':
                $men = "Llene el campo correo";
                break;
            case '4.1':
                $men = "Correo incorrecto debe ser dominio sena o misena";
                break;
            case '5':
                $men = "Llene el campo clave";
                break;
            case '5.1':
                $men = "Clave incorrecta, debe tener mínimo 6 caracteres";
                break;
            case '6':
                $men = "Las claves no coinciden";
                break;
            case '7':
                $men = "El correo ya se encuentra registrado";
                break;
            case '8':
                $men = "El docuemento ya se encuentra registrado";
                break;
                case 'error':
                  $men="No se pudo registrar aprendiz";
                  break;
                  case '9':
                      $men = "TI incorrecto";
                      break;
                  case '9.1':
                      $men = "Seleccione TI";
                      break;
                      case '10':
                          $men = "Programa incorrecto";
                          break;
                      case '10.1':
                          $men = "Seleccione Programa";
                          break;

        }

        if (!empty($men)) {
          echo '<div style="font-size: 20px; font-family: sans-serif" class="alert alert-dismissible alert-danger">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>Ooops<br></strong>' . $men . '
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
