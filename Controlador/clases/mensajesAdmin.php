<?php

class MensajesAdmin
{
    public static function subirPreguntas()
    {
        echo 'swal({
          title: "Espera Un Momento",
          text: "Se están cargando las preguntas",
          type: "info",
          showCancelButton: false,
          showConfirmButton:false,
          closeOnConfirm: false,
          timer:900,
          showLoaderOnConfirm: true
        }, function () {
          setTimeout(function () {
            swal("Preguntas guardadas", "¡ Excelente !");
          }, 1500);
        });';
    }
    public static function subirProgramas()
    {
        echo 'swal({
          title: "Espera Un Momento",
          text: "Se están cargando los programas",
          type: "info",
          showCancelButton: false,
          showConfirmButton:false,
          closeOnConfirm: false,
          timer:900,
          showLoaderOnConfirm: true
        }, function () {
          setTimeout(function () {
            swal("Programas guardados", "¡ Bien hecho !");
          }, 1500);
        });';
    }
    public static function archivoInval()
    {
        echo 'swal({
          title: "El archivo no es válido",
          text: "Debe ser tipo CSV",
          type: "error",
          showCancelButton: false,
          showConfirmButton:false,
          closeOnConfirm: false,
          timer:900,
          showLoaderOnConfirm: true
        }, function () {
          setTimeout(function () {
            swal("Vuelve a intentarlo", "¡Guarda el excel .csv (Delimitado por comas)!");
          }, 1500);
        });';
    }
  }

?>
