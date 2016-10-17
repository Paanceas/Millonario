<?php

class MensajesLogin
{
    public static function exitoCorreoEnvio()
    {
        echo 'swal({
          title: "Espera Un Momento",
          text: "Estamos enviando tu nueva clave",
          type: "info",
          showCancelButton: false,
          showConfirmButton:false,
          closeOnConfirm: false,
          timer:1000,
          showLoaderOnConfirm: true
        }, function () {
          setTimeout(function () {
            swal("¡Clave enviada!", "Verifica tu cuenta");
          }, 2000);
        });';
    }
    public static function mensajesIngreso($tipo)
    {
        switch ($tipo) {
            case '1':
                $men       = "Verifica tus credenciales";
                $tipoAlert = "danger";
                break;
            case '2':
                $men       = "Por favor Inicia sesión";
                $tipoAlert = "danger";
                break;
            case '3':
                $men       = "Había una sesión iniciada con este usuario, vuelve a ingresar";
                $tipoAlert = "danger";
                break;
            case '4':
                $men       = "Clave modificada con éxito";
                $tipoAlert = "info";
                break;
            case '5':
                $men       = "No se pudo enviar el correo";
                $tipoAlert = "danger";
                break;
            case '6':
                $men       = "El correo o documento son incorrectos";
                $tipoAlert = "danger";
                break;
            case '8':
                $men       = "El correo ingresado no existe";
                $tipoAlert = "danger";
                break;
        }

        if (!empty($men)) {
          echo '<div style="font-size: 12px;" class="alert alert-dismissible alert-' . $tipoAlert . '" role="alert">
          <a type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"> &times;</span></a>
          <strong>Ooops<br></strong>' . $men . '
          </div>';
        }
    }
}
?>
