<script type="text/javascript">
     function guardarDatosLog() {
        alert('Los datos se guardaron');
        document.editarUsuario.action = 'guardarLog';
        document.editarUsuario.submit();

    }

    function regresar() {
        document.editarUsuario.action = 'mostrarLog';
        document.editarUsuario.submit();
    }
</script>

<?php 
//comentarios?>


<?php $tipo = $this->session->userdata('perfil'); ?>

<article class="contentAdmin">
  <section class="formulario dt"><center>
<h1>Editar datos del Dispositivo</h1></center>
            <form name="editarUsuario" action="" method="post" accept-charset="utf-8" enctype="multipart/form-data">



<table border="0" width="100%">
    <tr>
        <td>
        <center>
            <?php 
                if ($result['imgTCircula']!='') //si tiene datos de la url los imprime reportedesde
                {
                    //echo "logo";
                    echo '<img src="/data/tarLog/'.$result['imgTCircula'].'" width="350" height="250">

                    <label><input type="checkbox" name="imgEliminar" value="'.$result['imgTCircula'].'">Eliminar</label>';//Enviamos por post el nombre de la imagen para proceder a eliminar.
                }
                else//si no tiene logo de imagen pone tabla para subir imagen y pone una imagen basica
                {
                    echo "<table border='0'><tr><td colspan='2'>";
                    echo '<center><img src="http://localizacion.monitoreovisual.com/data/tarLog/idficial.png" width="250" height="250"></center>';
                    echo "</td></tr><tr><td><h10>Max 300Kb</h10></td></tr>
                    <tr>
                        <td>";
                        echo '<input type="file" class="input" name="userfile" />';
                       echo "</td>
                    </tr>
                    </table>";
                }
             ?>
            
        </center>
        </td>
        <td>
        	<h10> * campos requeridos</h10>
			
			<label for="tipoEquipo">Tipo de Equipo</label>
			<input type="text" name="tipoEquipo" placeholder="" value="<?php echo $result['tipoEquipo']; ?>" disabled>

			<label for="SIMtelefono">N&uacute;mero telefonico de la tarjeta SIM</label>
			<input type="text" name="SIMtelefono" value="<?php echo $result['SIMtelefono']; ?>" disabled>
			

<table border="0">
	<tr>
		<td>
			<label for="esActiva">Est&aacute; activo</label>
            <select name="esActiva" readonly="true">
                        <?php 
							if($result['esActiva']==1)
							{
                        		echo "<option value='1'>Si</option>";
                            	echo "<option value='0'>No</option>";
                        	}
							if($result['esActiva']==0)
							{
                            	echo "<option value='0'>No</option>";
                            	echo "<option value='1' >Si</option>";
                        	}
                         ?>
            </select>
		</td>
		</tr>
    <tr><td>
     
    </td></tr>
		<tr>
		<td>
			<label for="Seguro">Seguro activo</label>
            <select name="Seguro" readonly="true">
                        <?php 
							if($result['esActiva']==1)
							{
                        		echo "<option value='1'>Si</option>";
                            	echo "<option value='0'>No</option>";
                        	}
							if($result['esActiva']==0)
							{
                            	echo "<option value='0'>No</option>";
                            	echo "<option value='1' >Si</option>";
                        	}
                         ?>
            </select>
		</td>
	</tr>
</table>

				
              




              <?php 
    if ($result['tipoEquipo']!="Persona") 
      {
        echo "<label for='Placa'>Placa</label>";
        echo "<input type='text' name='Placa' placeholder='' value='".$result['Placa']."' >";// "echo "   
      } 
    ?>
    
		</td>
</tr>




<tr>
	<td>

<li>
  <label for="vehiculoID">Identificador de Dispositivo</label>
  <input type="text" name="vehiculoID" placeholder="" value="<?php echo $result['vehiculoID']; ?>" >
</li>
	<li>
    <label for="unicoID">Identificador &Uacute;nico </label>
    <input type="text" name="unicoID"  value="<?php echo $result['unicoID']; ?>"  required>
  </li>
<li>
  <label for="mostrarNombre">Nombre corto (alias)</label>
  <input type="text" name="mostrarNombre" placeholder="" value="<?php echo $result['mostrarNombre']; ?>"  >
</li>

	</td>
	<td>

            

			<label for="grupo">Grupo:</label>
            <select name="grupoID" readonly="true">
              <?php 					
					echo "<option value=''></option>";
if ($datosGrup!='') 
{

          sort($datosGrup);
            foreach($datosGrup as $datos)
              {
                      //echo $datos['cuentaID']."<br>"; //activo solo para sysadmin
                     //echo $datos['grupoID']."<br>"; //activo solo para sysadmin
                if ($datos['grupoID']==$result['grupoID']) //si ya tiene un grupo asignado selecciona el grupo. el result llega del modelo vehiculos
                  {
                    echo "<option value='".$datos['grupoID']."' selected>".$datos['nombreMostrar']."</option>";
                  }
                  else
                    {
                      echo "<option value='".$datos['grupoID']."'>".$datos['nombreMostrar']."</option>"; //Esteticamente Visible BD
                    }
                  }

}//fin if
                ?>
            </select>	




            <label for="geozona">Geozona:</label>
            <select name="geozonaID" readonly="true">
              <?php 					
					echo "<option value=''></option>";
if ($datosGeo!='') 
{

          sort($datosGeo);
            foreach($datosGeo as $datos)
              {
                if ($datos['geozonaID']==$result['geozonaID']) //compara la lista de geozona y comprueba con el resultado ya guardado
                  {
                    echo "<option value='".$datos['geozonaID']."' selected>".$datos['nombreMostrar']."</option>";
                  }
                  else
                    {
                      echo "<option value='".$datos['geozonaID']."'>".$datos['nombreMostrar']."</option>"; //Esteticamente Visible BD
                    }
                  }

}//fin if
                ?>
            </select>

      <label for="conductorID">Nombre del <?php echo $this->session->userdata('conductor');?></label>
            <select name="conductorID" readonly="true">
              <?php           
          echo "<option value=''></option>";
          sort($datosCon);
            foreach($datosCon as $datos)
              {
                if ($datos['conductorID']==$result['conductorID']) //compara la lista de geozona y comprueba con el resultado ya guardado
                  {
                    echo "<option value='".$datos['conductorID']."' selected>".$datos['nombreContacto']."</option>";
                  }
                  else
                    {
                      echo "<option value='".$datos['conductorID']."'>".$datos['nombreContacto']."</option>"; //Esteticamente Visible BD
                    }
                  }
                ?>
            </select>
	</td>
</tr>
</table>




<?php //echo $result['cuentaID'];//la ocupamos para filtrar los grupos de esta cuenta ?>
<?php //echo $result['grupoID'];//la ocupamos para leer el grupo guardado en la tabla ?>

<?php //echo $grupo['grupoID'];//

//EDITAR VEHICULO --- POST=0
///////// OCULTAR TABLAS SI NO LLEGA NADA POR POST ..... POR QUE LOS VALORES A USAR SON ENVIADOS POR OTRA PLANTILLA.
//agregar o quitar un nuevo reporte  .... temporalmente se va a quedar en solo 2 reportes diarios.
//tambien  relacionar esto como para que el admin pueda hacer esto en el caso de liberar a mas usuarios.
//para que le entiendas http://php.net/manual/es/function.explode.php
//echo $result['notificacionRec']; 
//separamos los reportes que  hay en el dia ... quitando las comas
$reportes=$result['notificacionRec'];
$reporte = explode(",", $reportes);
// meter dentro de un ciclo para que lo haga automatico en el caso de que despues se quieran agregar mas reportes.
//echo $reporte[0]; 
//echo $reporte[1]; 
// para q sepas como se guarda en la bd implode para un solo arreglo.http://php.net/manual/es/function.implode.php
//se mantiene comentado siempre---- solo es para ver como se guarda el array en la base.(agregar echo para ver)
//$repArray = array($reporte[0], $reporte[1]);
//echo $separado_por_comas = implode(",", $repArray);

//Dias inhabiles separados por coma o NULL, 
//lunes=0
//martes=1
//miercoles=2
//jueves=3
//viernes=4
//sabado=5
//domingo=6

//echo $result['diainhabil']; //Falta agregar en el controlador
?>






<?php ////////////////////////////////////////////////Mostrar ocultar simbologia?>


  <script type="text/javascript">
    function changeDisplay (id) {
      d=document.getElementById("precarga");
      e=document.getElementById(id);
      if (e.style.display == 'none' || e.style.display == "") {
        e.style.display = 'block';
        d.innerHTML = 'Ocultar Detalles';
      } else {
        e.style.display = 'none';
        d.innerHTML = 'Mostrar Detalles';
      }
    }
  </script>

  <div>
    <a id="precarga" href="javascript:changeDisplay('detalles')">
      Mostrar Detalles
    </a>
  </div>
  <div id="detalles" style="display:none">
  

  <TABLE BORDER="0" WIDTH=100%>
    <TR>
      <TD><li>
<label for="Reporte1">Reporte 1</label>
<input type="time" name="Reporte1" value="<?php echo $reporte[0]; ?>">
</li></TD> 
      <TD><li>
<label for="Reporte2">Reporte 2</label>
<input type="time" name="Reporte2" value="<?php echo $reporte[1]; ?>">
</li></TD>
    </TR>
      <!-- Inicia Seccion Personas-->
    <TR>
      
      <TD><?php 
    if ($result['tipoEquipo']!="Persona") 
      { 
        echo "<label for='CapacidadCombustible'>Capacidad de combustible</label>";
        echo "<input type='text' name='CapacidadCombustible' placeholder='' value='".$result['CapacidadCombustible']."' >";
      }
    ?></TD>
    </TR>



<tr>
  <td>

<li>
  <label for="descripcion">Descripci&oacute;n</label>
<textarea name="descripcion" placeholder="Descripción del dispositivo" rows="14" cols="50"><?php echo $result['descripcion']; ?></textarea>
<label for="fallas">Fallas</label>
<textarea name="fallas" placeholder="Fallas" rows="14" cols="50"><?php echo $result['fallas']; ?></textarea>
  
</li>    
  </td>
</tr>

<TR>
  <TD>
    <label for="dispositivoID">Identificador MV</label>
    <input type="text" name="dispositivoID" placeholder="Identificador MV" value="<?php echo $result['dispositivoID']; ?>" readonly="true">
     
      <label for="NumeroIMEI">N&uacute;mero de IMEI</label>
      <input type="text" name="NumeroIMEI" placeholder="" value="<?php echo $result['NumeroIMEI']; ?>" disabled>
     
  </TD>
    <TD>
   
      <label for="fechaCreacion">Fecha de Creaci&oacute;n </label>
      <input type="text" name="fechaCreacion"  value="<?php echo $result['fechaCreacion']; ?>"  readonly="true">
    
      <label for="NumeroSerie">N&uacute;mero de Serie</label>
      <input type="text" name="NumeroSerie" value="<?php echo $result['NumeroSerie']; ?>" disabled>
  </TD>
  
</TR>
    </TABLE>

  </div>
<?php ////////////////////////////////Fin mostrar ocultar simbologia?>








<?php 
/////////////////////////////////fin de tablas //////////////////////////////////////////////////////////
//tendencia es quitar el boton guardar datos en el caso de ser un usuario entre admin y demo?>
				<li>
                    <input type="submit" onclick="guardarDatosLog()" value="Guardar">
					
				</li>
                <li>
					<input type="submit"  onclick="regresar()" value ="Regresar">
				</li>
			</ul>
		</form>
      
	</section>
 <?php 
//comentarios?></article>
