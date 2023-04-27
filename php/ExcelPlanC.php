<?php
header("Content-Type: text/html;charset=utf-8");

$salida = "";
if (!($conexion = mysqli_connect("localhost", "root", "" )))
{
  echo "Error conectando a la base de datos.";
  exit();
}

if (!($db = mysqli_select_db($conexion, "jc_mysql")))
{
  echo "Error seleccionando la base de datos.";
  exit();
}
mysqli_set_charset($conexion,"UTF8");
//Mostrar datos de la tabla
 $componente =$_POST['componente'];

 $consulta = "SELECT * FROM iniciopc WHERE componente	='".$componente."'";
 $result = $conexion -> query($consulta);

 $row = $result->fetch_assoc();

 $consultaC = "SELECT * FROM cambiopc WHERE componente	='".$componente."'";
 $resultC = $conexion -> query($consultaC);

 $consultaD1 = "SELECT descripcion1pc.componente,descripcion1pc.noPartesP,descripcion1pc.nombreProceso,dispositivo FROM descripcion1pc,descripcion2pc WHERE descripcion1pc.componente='$componente' AND descripcion1pc.noPartesP=descripcion2pc.noPartesP AND descripcion1pc.componente=descripcion2pc.componente ORDER BY noPartesP ASC";
 $resultD1 = $conexion -> query($consultaD1);

 $consultaD2 = "SELECT * FROM descripcion2pc WHERE componente='$componente' ORDER BY noPartesP ASC, no ASC";
 $resultD2 = $conexion -> query($consultaD2);

 $consultaD3 = "SELECT * FROM descripcion3pc WHERE componente='$componente' ORDER BY noPartesP ASC, no ASC";
 $resultD3 = $conexion -> query($consultaD3);


header("Pragma: public");
header("Expires: 0");

$filename = "PLAN DE CONTROL $componente.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

/*$cadena = $_GET['texto'];
$im     = imagecreatefrompng("/produccion/img/C.png");
$naranja = imagecolorallocate($im, 220, 210, 60);
$px     = (imagesx($im) - 7.5 * strlen($cadena)) / 2;
imagestring($im, 3, $px, 9, $cadena, $naranja);
imagepng($im);
imagedestroy($im);*/

  ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
  </head>
  </style>
  <body>
    <table border='1' overflow='scroll' height='100%' width='100%' id='troqueles'>
          <thead>
            <tr>
            <th colspan='14'><h1>PLAN DE CONTROL</h1></th>
            </tr>
            <tr>
              <td colspan='14'>F - CD 04 REV 01</td>
            </tr>
           <tr>
            <td rowspan='2' colspan='5'> <center>
              <table id="tabla2"  border='1' aling='center'>
                <tr>
                  <td></td>
                  <th>PROTOTIPO</th>
                  <td></td>
                  <th>PRE-PRODUCCIÓN</th>
                  <th><label  style=" font-size: 18pt;"> X </label></th>
                  <th>PRODUCCIÓN</th>
                </tr>
              </table></center>
              NÚMERO DEL PLAN DE CONTROL:&nbsp &nbsp &nbsp <label  style=" font-size: 18pt;"><b>PC<?php echo $row['componente'];?>  </b></label>
            </td>
            <td colspan='4'>CONTACTO CLAVE/TELÉFONO:<br><br><b> GERENTE DE PRODUCCIÓN</b></td>
            <td colspan='3'>FECHA DE EMISIÓN <br><br><b><?php echo $row['fechaEm'];?></b></td>
            <td>NIVEL REV. <br><br><center><b><?php echo $row['nivelRev'];?> </b></center></label></td>
            <td>FECHA DE REVISIÓN <br><br><center><b><?php echo $row['fechaRev'];?></b></center></td>
          </tr>
          <tr>
              <td rowspan='2' colspan='4'>EQUIPO <br><br>
                <b>
                GERENTE DE PLANTA<br>
                GERENTE DE PRODUCCIÓN<br>
                ASEGURAMIENTO DE CALIDAD<br>
                PRODUCCIÓN<br>
                MANTENIMIENTO
              </b>
              </td>
              <td colspan='5' rowspan='3'>
                APROBACIÓN DE INGENIERÍA CLIENTE  (SI ES REQUERIDO) <br><br>
                  <label  style=" font-size: 25pt;"> <b> <center>INGENIERIA SKF MEXICO </center></label>
              </td>
          </tr>
          <tr>
            <td colspan='5' >NÚMERO DE PARTE DEL CLIENTE/ÚLTIMO NIVEL DE CAMBIO:<br>
            <b><?php echo $row['componente'];?>  &nbsp  &nbsp
              NIVEL: <?php echo $row['nivelParC'];?>  &nbsp  &nbsp
              (<?php echo $row['fechaParC'];?> )</b>
              <br><br>
              NÚMERO DE PARTE JC/ ÚLTIMO NIVEL DE CAMBIO: <br>
              <b><?php echo $row['componente'];?>  &nbsp  &nbsp
              NIVEL: <?php echo $row['nivelParJC'];?>  &nbsp  &nbsp
              (<?php echo $row['fechaeParJC'];?> )</b>
            </td>

          </tr>
          <tr>
            <td colspan='5'>NOMBRE DE LA PARTE/DESCRIPCIÓN <br><br>
              <b>ESTAMPA METÁLICA TROQUELADA</b>
            </td>
            <td colspan='4'>
              FECHA DE APROBACIÓN/APROBACIÓN DE PLANTA/PROVEEDOR <br><br>
              <b>N/A</b>
            </td>
          </tr>
          <tr>
            <td colspan='3'>
              <br><br><br><br>
              <b>JORGE DE JESÚS COBIÁN ORDOÑEZ</b>
            </td>
            <td colspan='2'>CÓDIGO DEL <br> PROVEEDOR <br><br> <br><br><br> </td>
            <td colspan='4'>OTRAS APROBACIONES <br><br>
              <b>N/A</b> <br><br><br><br>
            </td>
            <td colspan='5' >
              APROBACIÓN DE CALIDAD CLIENTE ( SI ES REQUERIDO) <br><br>
              <label  style=" font-size: 25pt;"> <b> <center>ASEG. DE CALIDAD SKF MEXICO</center></b></label> <br>
            </td>
          </tr>
          <tr>
            <th bgcolor="#B2BABB">NIVEL</th>
            <th colspan='12' bgcolor="#B2BABB">CAMBIO</th>
            <th bgcolor="#B2BABB">FECHA</th>

          </tr>
          <?php $sum = 1;
          while ($filaC = $resultC  -> fetch_assoc()){?>
                        <tr>
                          <th><?php echo $sum?></th>
                          <th colspan='12'><?php echo $filaC['cambio']?></th>
                          <th><?php echo $filaC['fecha']?></th>
                        </tr>
            <?php $sum ++; } ?>
          <tr>
          <tr></tr>
            <td rowspan='3'>NÚM. PARTE/ PROCESO </td>
            <td rowspan='3'>NOMBRE DEL PROCESO  / DESCRIPCIÓN DE OPERACIÓN</td>
            <td rowspan='3'>MÁQUINA O DISPOSITIVO PARA MANUFACTURA</td>
            <td colspan='3'><center>CARACTERÍSTICA</center></td>
            <td rowspan='3'>RESPONSABLE</td>
            <td rowspan='3'>CLASIFICACIÓN DE CARACTERÍSTICAS ESPECIALES</td>
            <td colspan='5'><center>MÉTODOS</center></td>
            <td rowspan='3'>PLAN DE REACCIÓN</td>

          </tr>
          <tr>
            <td rowspan='2'>NO.</td>
            <td rowspan='2'>PRODUCTO</td>
            <td rowspan='2'>PROCESO</td>
            <?php //metodos ?>
            <td rowspan='2'>ESPECIFICACIÓN PLG. / TOLERANCIA  PRODUCTO/PROCESO</td>
            <td rowspan='2'>EVALUACIÓN/MÉTODO DE MEDICIÓN</td>
            <td colspan='2'><center>MUESTRA</center></td>
            <td rowspan='2'>MÉTODO DE CONTROL</td>
          </tr>
          <tr>
            <td>TAMAÑO</td>
            <td>FRECUENCIA</td>
          </tr>
          <?php
           $auxiliar = 0;
          while ($filaD1 = $resultD1  -> fetch_assoc() AND $filaD2 = $resultD2  -> fetch_assoc() AND $filaD3 = $resultD3  -> fetch_assoc()){
          ?>
                <tr>
                  <th>
                  <?php //IF ($auxiliar != $filaD2['noPartesP']) {
                    echo $filaD1['noPartesP'];
                  //  $auxiliar= $filaD2['noPartesP']; }
                    ?>
                  </th>
                  <td><?php echo $filaD1['nombreProceso'];?></td>
                  <td><?php echo $filaD1['dispositivo'];?></td>
                  <td><center><?php echo $filaD2['no'];?></center></td>
                  <td><?php echo $filaD2['producto'];?></td>
                  <td><?php echo $filaD2['proceso'];?></td>
                  <td><?php echo $filaD2['responsable'];?></td>
                  <td><center>
            <?php if ($filaD2['clasificacion'] == 'C') { ?>
                      <img src='C:/xampp2/htdocs/produccion/img/C.png' width='80' height='80'/>
            <?php }else {
                      echo $filaD2['clasificacion'];
                  } ?></center></td>
                  <td><?php echo $filaD3['especificacion']?></td>
                  <td><?php echo $filaD3['evaluacion']?></td>
                  <td><center><?php echo $filaD3['tamanio']?></center></td>
                  <td><?php echo $filaD3['frecuencia']?></td>
                  <td><?php echo $filaD3['metodoCap']?></td>
                  <td>
                    SEGREGAR AL ÁREA DE CUARENTENA <br>
                    INVESTIGAR CAUSA <br>
                    NOTIFICAR AL SUPERVISOR <br>
                    TOMAR ACCIÓN CORRECTIVA <br>
                    APLICAR PROCED. MP-85 <br>
                    (PRODUCTO NO CONFORME) <br>
                  </td>
                  </tr>
            <?php } ?>
          </thead>
      </table>
  </body>
</html>
