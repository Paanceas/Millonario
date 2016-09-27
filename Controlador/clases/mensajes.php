<?php

class MensajesJuego
{
    public static function exito(){
      // if ($tipo == 'ok') {
        echo 'swal({
  title: "Espera Un Momento",
  text: "Estamos creando tu cuenta",
  type: "info",
  showCancelButton: false,
  showConfirmButton:false,
  closeOnConfirm: false,
  timer:1000,
  showLoaderOnConfirm: true
}, function () {
  setTimeout(function () {
    swal("Cuenta creada exitosamente ¡Ingresa!");
  }, 2000);
});';
      // }
    }
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
          <a type="button" class="close" data-dismiss="alert">&times;</a>
          <strong>Ooops<br></strong>' . $men . '
          </div>';
        }
    }
}
?>
