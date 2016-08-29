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
                $men = "Correo incorrecto";
                break;
            case '5':
                $men = "Llene el campo clave";
                break;
            case '5.1':
                $men = "Clave incorrecta";
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
                case 'okno':
                  $men="No se pudo registrar aprendiz";
                  break;
        }

        if (!empty($men)) {
          echo '<div class="alert alert-dismissible alert-danger">
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
