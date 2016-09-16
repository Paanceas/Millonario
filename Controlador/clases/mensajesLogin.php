<?php

class MensajesLogin
{
    public static function mensajesIngreso($tipo)
    {
        switch ($tipo) {
            case '1':
                $men = "Verifica tus credenciales";
                break;
                case '2':
                    $men = "Por favor Inicia sesión";
                    break;
                    case '3':
                        $men = "Hay una sesión iniciado con este usuario";
                        break;

        }

        if (!empty($men)) {
          echo '<div class="alert alert-dismissible alert-danger" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Ooops<br></strong>' . $men . '
          </div>';
        }


    }
}
?>
