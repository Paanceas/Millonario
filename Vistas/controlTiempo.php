<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <script type="text/javascript">

    </script>
    <title></title>
  </head>
  <body>
    <?php
    date_default_timezone_set('UTC');

    $es = gmdate('d m Y h', time());

    $time = time();
  echo "<br/>";

  echo "<br/>";
  echo date("d-m-Y (H:i:s)", -3600);
  echo "<br/>";
  echo date("d-m-Y (H:i:s)", 0);
  echo "<br/>";
  echo date("d-m-Y (H:i:s)", 3600);
  echo "<br/>";
  echo date("Y-m-d (H:i:s)", $time);
  echo "<br/>";
  echo date("Y-m-d ", $time);
  echo "<br/>";
  echo ("Según el servidor la hora actual es: ". date("H:i:s", $time));


echo "------------------------------------------";
setlocale(LC_ALL, 'nld_nld');

/* Muestra: vrijdag 22 december 1978 */
echo strftime("%A %d %B %Y", mktime(0, 0, 0, 12, 22, 1978));

/* Probar diferentes nombres posibles de localismos para el alemán a partir de PHP 4.3.0 */
// $loc_de = setlocale(LC_ALL, 'de_DE@euro', 'de_DE', 'deu_deu');
 $loc_de=setlocale (LC_TIME, 'es_ES', 'es_ES');

echo "El localismo preferido para el alemán en este sistema es '$loc_de'";

     ?>
  </body>
</html>
