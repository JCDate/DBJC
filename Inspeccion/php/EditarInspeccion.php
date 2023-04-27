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

  $id = $_POST['id'];
  $orden = $_POST['orden'];
  $componente = $_POST['componente'];
  $inspector = $_POST['inspector'];

$fechaActual = date('d/m/Y');

$query = "SELECT * FROM inspeccion WHERE  id='$id'";
$result = $conexion -> query($query);
$fila = $result  -> fetch_assoc();

$query6 = "SELECT nombre FROM troqueladores WHERE puesto='INSPECTOR' ORDER BY nombre ASC";
$result6 = $conexion -> query($query6);

$query2 = "SELECT numOperaciones FROM troqueles WHERE componente='$componente' ORDER BY numOperaciones ASC";
$result2 = $conexion -> query($query2); ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
     <title>INSPECCION</title>
      <link rel="shortcut icon" href="/produccion/img/icono.png">
      <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
   </head>
   <body bgcolor="#AED6F1" >
    <style type="text/css">
      img.izquierda {
        float: left;
      }
    </style>
    <img src='/produccion/img/jcLogo.png' class="izquierda"  width='125' height='125' />
    <br>
      <center><font face="Bookman Old Style,arial,verdana" style="text-shadow: 0.1em 0.1em 0.15em; font-size: 50pt;" >REPORTE DE INSPECCIÓN</font></center>
    <form method='post'action="guardarRepInspeccion.php">
      <br><br><br><br>
      <center><font style=" font-size: 25pt;">
        <a class="boton" target="_blank"> ID: <input type="text" name="id" id="id" value="<?php echo $id ?>" style=" font-size: 25pt; width:15%; border-color: #2e518b; color: inherit; background-color: #2e518b; border-style:solid" readonly></a> &nbsp &nbsp
        <a class="boton" target="_blank"> ORDEN: <input type="text" name="orden" id="orden" value="<?php echo $orden ?>" style=" font-size: 25pt; width:15%; border-color: #2e518b; color: inherit; background-color: #2e518b; border-style:solid" readonly></a> &nbsp &nbsp
        <a class="boton" target="_blank"> COMPONENTE: <input type="text" name="componente" id="componente" value="<?php echo $componente ?>" style=" font-size: 25pt; width:17%; border-color: #2e518b; color: inherit; background-color: #2e518b; border-style:solid" readonly></a><br><br>
        <a class="boton" target="_blank"> CUÑETE: <input type="text" name="cuñete" id="cuñete" value="<?php echo $fila['cuñete'],'/',$fila['TotalCuñete']?>" style=" font-size: 25pt; width:5%; border-color: #2e518b; color: inherit; background-color: #2e518b; border-style:solid" readonly></a>
        <a class="boton" target="_blank"><label>FECHA SALIDA:</label><input type="text" name="fechaSal" id="fechaSal" value='<?php echo $fechaActual; ?>' style=" font-size: 25pt; width:17%; border-color: #2e518b; color: inherit; background-color: #2e518b; border-style:solid" readonly>&nbsp</a> <br><br>
        <a class="boton" target="_blank"> PZS. APROX.: <input type="text" name="pzs" id="pzs" value="<?php echo $fila['cantidadPzs']?>" style=" font-size: 25pt; width:10%; border-color: #2e518b; color: inherit; background-color: #2e518b; border-style:solid" readonly></a>&nbsp
        <a class="boton" target="_blank"> INSPECTOR: <input type="text" name="inspector" id="inspector" value="<?php echo $fila['inspector']?>" style=" font-size: 25pt; width:10%; border-color: #2e518b; color: inherit; background-color: #2e518b; border-style:solid" readonly></a><br><br>
        <br>

        <a class="boton2" target="_blank"><label>TIPO DE DEFECTO:</label>
          <select  class="def" name="def" id="def" style=" font-size: 25pt;  border-color: #000000; color: #000000; background-color: #C0C0C0;" onchange="javascript:mostrarCaract();">
            <option value="">----------------------------------------------------------</option>
            <option value="A. GRIETAS - ROTAS">A. GRIETAS - ROTAS</option>
            <option value="B. MARCA DE ESTRÉS">B. MARCA DE ESTRÉS</option>
            <option value="C. INCOMPLETAS">C. INCOMPLETAS</option>
            <option value="D. DOBLEZ CON DEFECTO">D. DOBLEZ CON DEFECTO</option>
            <option value="E. REBABA">E. REBABA</option>
            <option value="F. GRABADO DEFECTUOSO">F. GRABADO DEFECTUOSO</option>
            <option value="G. MARCAS DE REBABA">G. MARCAS DE REBABA</option>
            <option value="H. OVALAMIENTO">H. OVALAMIENTO</option>
            <option value="I. EMPALMADA">I. EMPALMADA</option>
            <option value="J. RAYADAS">J. RAYADAS</option>
            <option value="K. CÓNCAVA - CONVEXA">K. CÓNCAVA - CONVEXA</option>
            <option value="L. BARRENO - ROTAS">L. BARRENO - ROTAS</option>
            <option value="M. GOLPE">M. GOLPE</option>
            <option value="N. CHUECAS">N. CHUECAS</option>
            <option value="Ñ. FLANGE DEFORME">Ñ. FLANGE DEFORME</option>
            <option value="O. BARRENOS INCOMPLETOS (TAPADOS)">O. BARRENOS INCOMPLETOS (TAPADOS)</option>
            <option value="P. GRABADO INVERTIDO">P. GRABADO INVERTIDO</option>
            <option value="Q. NINGUNO">Q. NINGUNO</option>
            <option value="R. OTRO">R. OTRO (ESPECÍFICA)</option>
          </select>
          &nbsp</a>
          <br><br>
      <div id="flotanteC1" style="display:none;">
        <div id="closeC1">
          <a class="boton" target="_blank"><label>OTRO:</label> <input type="text" name="otro" id="otro"  onkeyup="javascript:this.value=this.value.toUpperCase();" style=" font-size: 25pt;  border-color: #000000; color: #000000; background-color: #C0C0C0;">&nbsp</a>
          <br><br>
        </div>
      </div>

      <a class="boton2" target="_blank"><label>CANTIDAD PZS CON DEFECTO:</label> <input type="number" name="pzsDef" id="pzsDef" style=" font-size: 25pt; width:10%; border-color: #000000; color: #000000; background-color: #C0C0C0;">&nbsp</a>
      <br><br>

      <a class="boton2" target="_blank"><label>INSPECCIÓN:</label>
      <select  class="def" name="ins" id="ins" style=" font-size: 25pt;  border-color: #000000; color: #000000; background-color: #C0C0C0;">
        <option value="">--------</option>
        <option value="100 %">100 %</option>
        <option value="200 %">200 %</option>
        <option value="300 %">300 %</option>
      </select>
      </a>
      </font>
      </center>
      <br><br>
      <style type="text/css">
      .boton {
          border: 1px solid #2e518b; /*anchura, estilo y color borde*/
          padding: 10px; /*espacio alrededor texto*/
          background-color: #2e518b; /*color botón*/
          color: #ffffff; /*color texto*/
          text-decoration: none; /*decoración texto*/
          text-transform: uppercase; /*capitalización texto*/
          font-family: 'Helvetica', sans-serif; /*tipografía texto*/
          border-radius: 50px; /*bordes redondos*/
          }

      .boton2 {
          border: 1px solid #4484D0; /*anchura, estilo y color borde*/
          padding: 10px; /*espacio alrededor texto*/
          background-color: #4484D0; /*color botón*/
          color: #ffffff; /*color texto*/
          text-decoration: none; /*decoración texto*/
          text-transform: uppercase; /*capitalización texto*/
          font-family: 'Helvetica', sans-serif; /*tipografía texto*/
          border-radius: 50px; /*bordes redondos*/
          }

        .boton_1{
          text-decoration: none;
          padding: 3px;
          padding-left: 10px;
          padding-right: 10px;
          font-family: helvetica;
          font-weight: 300;
          font-size: 40px;
          font-style: italic;
          color: #006505;
          background-color: #3498DB;
          border-radius: 20px;
          border: 5px double #006505;
        }

        .boton_1:hover{
          opacity: 0.6;
          text-decoration: none;
        }

        .boton_2{
          text-decoration: none;
          padding: 5px;
          padding-left: 10px;
          padding-right: 10px;
          font-family: helvetica;
          font-weight: 300;
          font-size: 40px;
          font-style: italic;
          color: #DA0E0B;
          background-color: #3498DB;
          border-radius: 20px;
          border: 5px double #DA0E0B;
        }

        .boton_2:hover{
          opacity: 0.6;
          text-decoration: none;
        }
      </style>
      <br>
      <div align='center'>
        <button type='submit'  class='boton_1'>INSPECCIÓN COMPLETA</button>
      </div>
      <br><br><br>
    </form>
   </body>
   <script type="text/javascript">

      function mostrarCaract() {

          const selectElement = document.querySelector('.def');
              var res  = `${event.target.value}`;

               if(res == 'R. OTRO'){
                 div = document.getElementById('flotanteC1');
                    div.style.display = '';
                  }else {
                    div = document.getElementById('flotanteC1');
                       div.style.display = 'none';
                  }
      }
   </script>
 </html>

 <?php
   $conexion ->close(); ?>
