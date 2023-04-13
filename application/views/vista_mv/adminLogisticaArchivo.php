<script type="text/javascript">
  function colocarFechaSeleccion(){
    var fechaDeH = document.getElementById('fechaDe');
    var fechaHastaH = document.getElementById('fechaHasta');
    document.getElementById("fechaDeH").value = fechaDeH.value;
    document.getElementById("fechaHastaH").value = fechaHastaH.value;
  }
  
  function mostrarLogistica()
  {
    window.location="mostrarLogistica";
  }  
  function actualizarMapa(){
    colocarFechaSeleccion();
    document.nombresGpsFor.submit();
  }
  
  function autoActualizaMapa(){
    var varAuto = document.getElementById("controlAuto").value;
      if(varAuto=="0"){ 
        intervalo = setInterval('actualizarMapa()',20000);
        document.getElementById("controlAuto").value = "1"; //1 : significa que esta activa la actualizacion automatica
        document.getElementById("actAuto").value="Detener Automatico";
      }else{
        document.getElementById("controlAuto").value = "0";
        document.getElementById("actAuto").value="Iniciar Automatico";
        //setInterval('actualizarMapa()',0);  
        clearInterval(intervalo);
      }
  }
  
  
</script>
<center>
  <article class="contentAdmin">
  <p><br>
  <center>Logistica Archivo</center>
<section class="reportedesde">
  
    <div style="margin: 10px auto; margin-center: 10px;">
    <?php if($gps === 0){  ?>
      <label>No hay dispositivos asociados a esta cuenta de usuario.</label>
    <?php }else{ ?>
      
<br>

<form name="nombresGpsFor" id="nombresGpsFor" action="LogArchivoSelec" method="POST">
<TABLE BORDER=0 align='center'>


<TR>
<TD>
<label>Seleccione Dispositivo:</label>

        <SELECT name="nombreGpsOpcion" id="nombreGpsOpcion" onchange="actualizarMapa()" style="width:200px">
        
        <?php
        $usuarioSesion = $this->session->userdata('usuario');//es el usuario que inicio sesion importado de sesion
        $cadena = "";
        $contadorLista=0;
        $perfil_mapa = $this->session->userdata['perfil'];
        if($perfil_mapa == '0')//si es sysadmin muestra tambien la cuenta del vehiculo
          {
            sort($gps);
            foreach ($gps as $nombreEnListaGps)// despues de este for comparar lo que se dijo antes en el comentario.
              {//se filtra en ambos lados ... aqui tambien se filtra la segunda vez despues de pasar por el controlador
                    

                if ($nombreEnListaGps['tipoEquipo']=='Movil-web') 
                {
                
                    $contadorLista++;//numera los dispositivos
                    $cadena = $contadorLista." (" . $nombreEnListaGps["cuentaID"]  . ") " . $nombreEnListaGps['mostrarNombre'];
            
                    if($nombreEnListaGps['dispositivoID']== $nomGps)
                      {       
                        echo "<OPTION VALUE='" . $nombreEnListaGps['dispositivoID'] . "*" . $nombreEnListaGps["cuentaID"] . "' selected>" . $cadena . "</OPTION>";
                        //echo "<OPTION VALUE=' ' selected></OPTION>";
                      }
                    else
                      {
                        echo "<OPTION VALUE='" . $nombreEnListaGps['dispositivoID'] . "*" . $nombreEnListaGps["cuentaID"] . "'>" . $cadena . "</OPTION>";
                      }

                        # code...
                }//fin if muestra solo movil-web



              }//fin del forech 
            
          }//fini usuario tipo 0
        if($perfil_mapa == '1')//si e
          {
            sort($gps);
            foreach ($gps as $nombreEnListaGps)// despues de este for comparar lo que se dijo antes en el comentario.
              {
                if ($nombreEnListaGps['tipoEquipo']=='Movil-web') 
                {
                    $contadorLista++;//numera los dispositivos
                    $cadena = $contadorLista." ".$nombreEnListaGps['mostrarNombre']." ".$nombreEnListaGps['grupoID'];//mostrarNombre importado directamente del modelo 
                    if($nombreEnListaGps['dispositivoID']== $nomGps)
                      {       
                        echo "<OPTION VALUE='" . $nombreEnListaGps['dispositivoID'] . "*" . $nombreEnListaGps["cuentaID"] . "' selected>" . $cadena . "</OPTION>";
                        //echo "<OPTION VALUE=' ' selected></OPTION>";
                      }
                    else
                      {
                        echo "<OPTION VALUE='" . $nombreEnListaGps['dispositivoID'] . "*" . $nombreEnListaGps["cuentaID"] . "'>" . $cadena . "</OPTION>";
                      }
                }
              }//fin del forech 
          }//fin usuario tipo 1

if($perfil_mapa == '2')//si e
  { sort($grupo);
    foreach($grupo as $datos)//si pasa por maneja pero no fue modificada su info, hay enlace directo con el modelo.
        {       //echo $datos['cuentaID']."<br>"; 
                      //echo $datos['grupoID']."<br>"; 
                //echo $datos['usuarioDefecto']."<br>";
          if ($datos['usuarioDefecto']==$usuarioSesion) //usuarioDefecto o nombre corto del Usuario es igual al de sesion
            {     //primero forech y enseguida comparar
                  //si esta variable $nombreEnListaGps['grupoID']; //
                  // es igual a esta otra, unicamente dentro del if comparativo para no filtrar informacion a otros usuarios. 
                  //echo $datos['grupoID']."<br>"; 
                //sort($nombreEnListaGps, SORT_NATURAL | SORT_FLAG_CASE);
            sort($gps);
            foreach ($gps as $nombreEnListaGps)// despues de este for comparar lo que se dijo antes en el comentario.
              {
                if ($nombreEnListaGps['tipoEquipo']=='Movil-web') 
                {

                  if ($nombreEnListaGps['grupoID']==$datos['grupoID']) 
                    {//si se cumplen las dos condiciones anteriores muestra vehiculos.
                      $contadorLista++;//numera los dispositivos
                      $cadena = $contadorLista." ".$nombreEnListaGps['mostrarNombre']." ".$nombreEnListaGps['grupoID'];//mostrarNombre importado directamente del modelo 
                      if($nombreEnListaGps['dispositivoID']== $nomGps)
                        {       
                          echo "<OPTION VALUE='" . $nombreEnListaGps['dispositivoID'] . "*" . $nombreEnListaGps["cuentaID"] . "' selected>" . $cadena . "</OPTION>";
                          //echo "<OPTION VALUE=' ' selected></OPTION>";
                        
                        }
                      else
                        {
                          echo "<OPTION VALUE='" . $nombreEnListaGps['dispositivoID'] . "*" . $nombreEnListaGps["cuentaID"] . "'>" . $cadena . "</OPTION>";
                        }
                    }//fin if compara
                }
              }//fin del forech o for ciclado despues del grupoID
            }//fin compara usuarios
            }//fin forech principal
  } //fin usuario tipo 2
              
          
            
                ?>


</SELECT>


</TD>
<TD>
<section class="reporteFecha">

<?php $this->load->view('templates/calendario'); ?> 

</section>
</TD>

<TD>
    <input type="hidden" id="fechaDeH" name="fechaDeH" value="">
    <input type="hidden" id="fechaHastaH" name="fechaHastaH" value="">
    <input type="hidden" id="controlAuto" name="controlAuto" value="0">
    <input name="Actualizar" type="button" id="Actualizar" onclick="actualizarMapa()" value="Actualizar" <?php if($gps === 0){echo 'disabled';} ?> >
    <script type="text/javascript">
         var varAuto = "<?php echo $controlAuto; ?>";
   var intervalo;
   if(varAuto=="1"){
      document.getElementById("controlAuto").value = varAuto;
      intervalo = setInterval('actualizarMapa()',20000);
      document.getElementById("actAuto").value="Detener Automatico";
      }
    </script> 
    <input name="Regresar" type="button" id="Regresar" onclick="mostrarLogistica()" value="Regresar" >
</TD>
</TR>
</TABLE>
</form>



<table border="1" cellpadding="1" cellspacing="0" width="100%">
  <tr>
<td align="center"><b>#</b></td>
<td><b>Folios</b></td>
<td><b>Personal Asignado</b></td>
<td><b>Orden</b></td>
<td><b>Datos del Cliente</b></td>

<td><b>Detalles</b></td>

<td><b>Fechas</b></td>
<td><b>Imagenes</b></td>
  </tr>


<?php } //fin de la condicion de mostrar para cuando si hay id... si no hay carros no muestra nada dentro de aqui
    //relacionado con la cuenta y el usuario en el inicio de sesion.?>
    


    <?php 
    if($datosGps != 0)
    {
      $contador = 0;
      $bateria =0;
      $odometroKM=0;
      $latitudAux="";
      $longitudAux="";
      $line='0';

      $imprime=1;
      $codigoE='Encendido';//1 Encendido 0 Apagado
      foreach($datosGps as $datos)
      {
      
  $csv[$contador] = "\r\n".$contador.", ".$datos['fechadeCreacion'].", ".$datos['nombreMostrar'].", ".$datos['direccionCliente'].", ".round($datos['descripcion'])." Km, ".$datos['useragent']." %";
$contador=$contador+1;
echo "<tr>";
                   
                       
                    
                        echo '<td align="center">';
                        echo "<label>".$contador."</label>";//sin seleccion 
                        echo "</td>";
                        //$boton=1;//por si las dudas 
                      
                      
                      //echo "<td>".$datos['IDMV']."</td>";
                    echo "<td>
            <table>
              <tr><td>Recomendado</td></tr>
              <tr><td>".$datos['logisticaID']."</td></tr>
              <tr><td>Empresa</td></tr>
              <tr><td>".$datos['folioEmpresaID']."</td></tr>
              <tr><td>Corporativo</td></tr>
              <tr><td>".$datos['folioCorporativoID']."</td></tr>
            </table>
                        </td>";

                    echo "<td>
            <table>
             
              <tr><td>".$datos['personalID']."</td></tr>
              <tr><td><b>Dispositivo</b></td></tr>
              <tr><td>".$datos['useragent']."</td></tr>
            </table>
                        </td>";



                                          echo "<td>
            <table>
              
              <tr><td><b>".$datos['nombreMostrar']."</b></td></tr>
              <tr><td>Tipo de Visita</td><td>".$datos['tipoVisita']."</td></tr>
              <tr><td>Numero de Visita</td><td><b>".$datos['numeroVisita']."</b></td></tr>
              <tr><td></td><td><b>Cuestionario</b></td><td></td></tr>
              <tr><td>".$datos['p1b']."</td><td>".$datos['p1']."<br>Nota:".$datos['p1nota']."</td></tr>
              <tr><td>".$datos['p2b']."</td><td>".$datos['p2']."<br>Nota:".$datos['p2nota']."</td></tr>
              <tr><td>".$datos['p3b']."</td><td>".$datos['p3']."<br>Nota:".$datos['p3nota']."</td></tr>
              <tr><td>".$datos['p4b']."</td><td>".$datos['p4']."<br>Nota:".$datos['p4nota']."</td></tr>
              <tr><td>".$datos['p5b']."</td><td>".$datos['p5']."<br>Nota:".$datos['p5nota']."</td></tr>

              <tr><td>".$datos['p6b']."</td><td>".$datos['p6']."<br>Nota:".$datos['p6nota']."</td></tr>
              <tr><td>".$datos['p7b']."</td><td>".$datos['p7']."<br>Nota:".$datos['p7nota']."</td></tr>
              <tr><td>".$datos['p8b']."</td><td>".$datos['p8']."<br>Nota:".$datos['p8nota']."</td></tr>
              <tr><td>".$datos['p9b']."</td><td>".$datos['p9']."<br>Nota:".$datos['p9nota']."</td></tr>
              <tr><td>".$datos['p10b']."</td><td>".$datos['p10']."<br>Nota:".$datos['p10nota']."</td></tr>
            </table>
                        </td>";


                    echo "<td>
            <table>
              <tr><td><b>Nombre</b></td></tr>
              <tr><td>".$datos['nombreContactoCliente']."</td></tr>
              <tr><td><b>Telefono</b></td></tr>
              <tr><td>".$datos['telefonoCliente']."</td></tr>
              <tr><td><b>Correo</b></td></tr>
              <tr><td>".$datos['correoCliente']."</td></tr>
            </table>
                        </td>";  

                  echo "<td>
            <table>
              <tr><td><b>Direccion</b></td></tr>
              <tr><td>".$datos['direccionCliente']."</td></tr>
              <tr><td><b>Descripcion</b></td></tr>
              <tr><td>".$datos['descripcion']."</td></tr>
              <tr><td><b>Notas</b></td></tr>
              <tr><td>".$datos['notas']."</td></tr>
            </table>
                        </td>";                    




                      

                    echo "<td>
            <table>
              <tr><td>Liquida</td></tr>
              <tr><td>".$datos['FechaLiquida']."</td></tr>
              <tr><td>Atendio</td></tr>
              <tr><td>".$datos['ultimaFechaActualizacion']."</td></tr>
              <tr><td>Creacion</td></tr>
              <tr><td>".$datos['fechadeCreacion']."</td></tr>
            </table>
                        </td>";

                  echo "<td>
            <table>
<tr><td><img src='".$datos['imgContrato']."' width='60' height='60'></td><td><img src='".$datos['imagenvisita']."' width='60' height='60'></td><td><img src='".$datos['imgFirma']."' width='60' height='60'></td></tr>
              <tr><td>Contrato</td><td>Visita</td><td>Firma</td></tr>
            </table>
                        </td>";

                      
                    
                echo "</tr>";            
          
      }//Fin Forech



$time = time();//Se ocupa para asignarle parte del nombre a los archivos
//echo date("d-m-Y (H:i:s)", $time);
//se crea el archivo con el nombre de cuenta y el tiempo o fecha de creacion, conforme crezca una cuenta agregar opcion de usuario tambien. para evitar hack

$fp = fopen('cache/CSV/'.$this->session->userdata('cuenta').$time.'.csv', 'w');//dataCSV
//# Fecha Estado  Latitud Longitud  Link  Velocidad Dirección Odómetro
$head[0] = '#'; 
$head[1] = 'Fecha y Hora';
$head[2] = 'Estado'; 
$head[3] = 'Latitud'; 
$head[4] = 'Longitud'; 

$head[5] = 'Calle';
$head[6] = 'Colonia'; 
$head[7] = 'Ciudad';
$head[8] = 'Estado';
$head[9] = 'Pais';
$head[10] = 'Odómetro';
$head[11] = 'Bateria';
$tit[0] = 'Monitoreo Visual';
$tit[1] = 'Archivo';
foreach ($gps as $imprime)// Asigna nombre al ID ya seleccionado para exportar al txt
{
  if($imprime['dispositivoID']== $nomGps)
    { 
      $ipersonal[0]=$imprime['mostrarNombre'];
      $ipersonal[1]=$nomGps;
    }
}
fputcsv($fp, $tit);//fgetcsv para importar
//fgetcsv($handle, 0, ",");
fputcsv($fp, $ipersonal);//fgetcsv para importar
fputcsv($fp, $head);//fgetcsv para importar

fputcsv($fp, $csv);//fgetcsv para importar
fclose($fp);
//////////////////////////////////////////////////Termina de crear CSV inicia crear txt
$fp = fopen('cache/TXT/'.$this->session->userdata('cuenta').$time.'.txt', 'w');//dataCSV
//# Fecha Estado  Latitud Longitud  Link  Velocidad Dirección Odómetro
$hea[0] = '#';  
$hea[1] = 'Fecha y Hora';
$hea[2] = 'Estado'; 
$hea[3] = 'Latitud'; 
$hea[4] = 'Longitud'; 
$hea[5] = 'Calle';
$hea[6] = 'Colonia'; 
$hea[7] = 'Ciudad';
$hea[8] = 'Estado';
$hea[9] = 'Pais';
$hea[10] = 'Odometro';
$hea[11] = 'Bateria';

//$csv = str_replace(",","p",$csv );  
$titulo[0] = 'Monitoreo Visual';
$titulo[1] = 'Archivo';
foreach ($gps as $imprime)// Asigna nombre al ID ya seleccionado para exportar al txt
{
  if($imprime['dispositivoID']== $nomGps)
    { 
      $ipersonal[0]=$imprime['mostrarNombre'];
      $ipersonal[1]=$nomGps;
    }
}

//fputcsv($fp, $gps);//fgetcsv para importar
fputcsv($fp, $titulo);//fgetcsv para importar
fputcsv($fp, $ipersonal);//fgetcsv para importar
fputcsv($fp, $hea);//fgetcsv para importar
fputcsv($fp, $csv);//fgetcsv para importar
fclose($fp);




echo "<table border=0>

    <tr>
      <td>
        <a HREF='cache/CSV/".$this->session->userdata('cuenta').$time.".csv' TARGET='_blank'>   Exportar CSV</a>
      </td>
      <td>
        <a HREF='cache/TXT/".$this->session->userdata('cuenta').$time.".txt' TARGET='_blank'>   Exportar TXT</a>
      </td>
    </tr>

  </table>";


    }//fin if compara si tiene datos


echo "</table><p>";
    
    ?>

    




    </section>
</article>
