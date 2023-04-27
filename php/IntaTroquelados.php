<?php

header("Content-Type: text/html;charset=utf-8");
$salida = "";
if(!($conexion = mysqli_connect("localhost", "root", "" )))
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

//BUSCAR
  $query = "SELECT componente, CR,calibre FROM estructura ORDER BY componente ASC";
  if (isset($_POST['consulta'])) {
    $q = $conexion -> real_escape_string($_POST['consulta']);
    $query = "SELECT	 componente, CR,calibre FROM estructura WHERE componente LIKE '%".$q."%' OR CR LIKE '%".$q."%'";
  }


  $result = $conexion -> query($query);




  echo $salida;

  $conexion ->close();

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <style type="text/css">
      img.zoom {

         -webkit-transition: all .2s ease-in-out;
         -moz-transition: all .2s ease-in-out;
         -o-transition: all .2s ease-in-out;
         -ms-transition: all .2s ease-in-out;
       }

       .transition {
         -webkit-transform: scale(1.8);
         -moz-transform: scale(1.8);
         -o-transform: scale(1.8);
         transform: scale(1.8);
       }
      </style>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
      <script>
         $(document).ready(function(){
             $('.zoom').hover(function() {
                 $(this).addClass('transition');
             }, function() {
                 $(this).removeClass('transition');
             });
         });
       </script>

       <script type="text/javascript">
           $(".btn_add").on("click", function() {
           var componente= $(this).closest('tr').children()[0].textContent;

           $("#componente").val(componente);

           });
       </script>

    <title>I. P. P. T</title>
    <link rel="shortcut icon" href="/produccion/img/icono.png">
  </head>
  <body>
    <form id='frm' action="" method="post">
        <?php  if($result -> num_rows > 0) {?>
                <thead><table border='1' overflow='scroll' height='100%' width='100%' bordercolor='black' id='troqueles'>
                <tr>
                  <th bgcolor='#85C1E9'>COMPONENTE</th>
                  <th bgcolor='#85C1E9'>C/R</th>
                  <th bgcolor='#85C1E9'>CALIBRE</th>
                  <th bgcolor='#85C1E9'>GENERAR</th>
                </tr>
                </thead>
                <tbody>

        <?php   while ($fila = $result  -> fetch_assoc()){?>
                    <tr>
                      <th bgcolor='#85C1E9'><?php echo $fila['componente']?></th>
                      <td bgcolor='#B0E0E6' align='center'><?php echo $fila['CR']?></td>
                      <td bgcolor='#B0E0E6' align='center'><?php echo $fila['calibre']?></td>
                      <td bgcolor='#B0E0E6' align='center'>
                        <button type='submit' style='background-color:#AED6F1; border-color:#AED6F1;  border: 0;' class='btn btn-info btn_add'   onclick="this.form.action='php/EditarInstTroquelados.php';this.form.submit();" > <img src='img/editProd.png' width='40' height='40' class='zoom'/></button>
                      </td>
                    </tr>
        <?php  } ?>
                  </tbody></table>

      <?php   }?>

          <input type='text' name='componente' id='componente'  readonly style="background-color:transparent; color:transparent; border-color:transparent; border-style:solid" >

    </form>
  </body>


</html>
