<script type="text/javascript">
  function colocarFechaSeleccion(){
    var fechaDeH = document.getElementById('fechaDe');
    var fechaHastaH = document.getElementById('fechaHasta');
    document.getElementById("fechaDeH").value = fechaDeH.value;
    document.getElementById("fechaHastaH").value = fechaHastaH.value;
  }

    function borrarInvent(){
    if(confirm('¿Esta seguro que quiere borrar el Objeto?')){
      document.nombresGpsFor.action = 'borrarInv';
      document.nombresGpsFor.submit();
    }
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
  <center>Inventario Archivo</center>
<section class="reportedesde">
  
    <div style="margin: 10px auto; margin-center: 10px;">
    <?php if($gps === 0){  ?>
      <label>No hay dispositivos asociados a esta cuenta de usuario.</label>
    <?php }else{ ?>
      
<br>

<form name="nombresGpsFor" id="nombresGpsFor" action="InvArchivoSelec" method="POST">
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
                //echo $datos['']."<br>";
          
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
  
</TD>
</TR>
</TABLE>




<table border="1" cellpadding="1" cellspacing="0" width="100%">
  <tr>
<td align="center"><b>#</b></td>
<td><b>Folio</b></td>
<td><b>Caracteristicas</b></td>
<td><b>Herramienta</b></td>
<td><b>Fecha de Creacion</b></td>
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
      
  $csv[$contador] = "\r\n".$contador.", ".$datos['fechadeCreacion'];
$contador=$contador+1;
echo "<tr>";
                   
                       
                    
                        echo '<td align="center">';
                        //echo "<label>".$contador."</label>";//sin seleccion 


$selec = '<label><br><input type="radio" name="idselecinv" value='.$datos['Contador'].'>'.$contador.'</label>';
echo $selec;


                        echo "</td>";
                        //$boton=1;//por si las dudas 
                      
                      
                      //echo "<td>".$datos['IDMV']."</td>";
                    echo "<td>
            <table>
              
              <tr><td>0001".$datos['Contador']."</td></tr>
            </table>
                        </td>";

                    echo "<td>
            <table>
             
              <tr><td></td></tr>
              <tr><td><b>ID</b></td></tr>
              <tr><td>".$datos['IDObjetos']."</td></tr>
            </table>
                        </td>";

$imgTel='';//
              


///////////////////////////////////////////////////////////////

      echo "<td>
            <table>
             
              <tr><td>".$imgTel." <b></b></td></tr>
              <tr><td><b>Detalle:</b> ".$datos['descripcion']." </td></tr>
            </table>
                        </td>";

                      

                    echo "<td>
            <table>
             
              <tr><td>".$datos['fechadeCreacion']."</td></tr>
            </table>
                        </td>";

                 
                      
                    
                echo "</tr>";            
          
      }//Fin Forech




    }//fin if compara si tiene datos


echo "</table><p>";
    ///////////////////////////////////////////////////////////////////////////////
if ($this->session->userdata('usuario')=='admin') 
{

echo '<input type="button" value="Editar"onclick="enviarDatosConductor()"/>
      <input type="button" value="Borrar" onclick="borrarInvent()"/>
';
}
//si es admin puede borrar y editar.
//////////////////////////////////////////////////////////////////////////////
         
$tipo = $this->session->userdata('perfil');
if(($tipo != '0' and $tipo != '1') || $this->session->userdata('perfil') === FALSE)
  {
    redirect(base_url().'sesion');
  }
?> 

</form>

<div class="reporte dt">
      <h5>Agregar Nuevo Objeto:</h5>
      <form name="crear" action="InvArchivoNew" method="post" accept-charset="utf-8">
            <label for="detaH">Detalles de Objeto</label>
            <input type="text" id="detaH" name="detaH" placeholder="" required>








            <label for="usdeta">Selecciona tipo de Objeto +</label>
            <select id="usdeta" name="usdeta">
            <option value=''></option>
            <option value='10ig'>gen</option>
            
            </select> 
<label for="tipo">Seleccione Usuario Asignado: </label>
<select id="uselec" name="uselec" placeholder="" required>
              <?php    
              //$conListaa=0;       
          
               


      
            sort($gps);
            foreach ($gps as $nombreEnListaGps)// despues de este for comparar lo que se dijo antes en el comentario.
              {
                if ($nombreEnListaGps['tipoEquipo']=='Movil-web') 
                {
                    //$conListaa++;//numera los dispositivos
                    //$cadena = $conListaa." ".$nombreEnListaGps['mostrarNombre']." ".$nombreEnListaGps['grupoID'];//mostrarNombre importado directamente del modelo 
                     $cadena = $nombreEnListaGps['mostrarNombre']." ".$nombreEnListaGps['grupoID'];//mostrarNombre 
                   
                        echo "<OPTION VALUE='" . $nombreEnListaGps['dispositivoID']."'>" . $cadena . "</OPTION>";
                      
                }
              }//fin del forech 
            echo "<OPTION VALUE='' selected></OPTION>";
//////////Fin options /////////////////////////////////////////////
               ?>

            </select> 
<div style="margin-left: 230px;">       
              <input type="submit" value="Crear">&nbsp;&nbsp;
              <input type="reset" value="Limpiar">
            </div>
      </form>
    </div>
     <p><br>
    </section>
</article>
