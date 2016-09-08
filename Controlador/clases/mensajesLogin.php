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

        }

        if (!empty($men)) {
          echo '<div class="alert alert-dismissible alert-danger">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>Ooops<br></strong>' . $men . '
          </div>';
        }


    }
}
?>
