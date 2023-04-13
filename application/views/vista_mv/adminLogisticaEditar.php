<?php 
//este script jquery es necesario para cargar el mapa pero lo comento por que ya lo carga automaticamente la cabeza
//<script type="text/javascript" src="http://monitoreovisual.com/jquery-1.8.3.min.js"></script>?>

          <?php 
$googlekey=$this->session->userdata('googlekey');
  echo ' <script async defer src="https://maps.googleapis.com/maps/api/js?key='.$googlekey.'&callback=initMap"
  type="text/javascript"></script>'; ?>

  
<script src=http://maps.googleapis.com/maps/api/js?libraries=geometry&sensor=true></script>
<script type="text/javascript">
var map;
function load_map() {
    var myLatlng = new google.maps.LatLng(20.68009, -101.35403);
    var myOptions = {
        zoom: 4,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map($("#map_canvas").get(0), myOptions);
    // Obtenemos la dirección y la asignamos a una variable
    var address = document.getElementById("address").value;
    if (address!='') 
        {
        // Creamos el Objeto Geocoder
        var geocoder = new google.maps.Geocoder();
        // Hacemos la petición indicando la dirección e invocamos la función     AIzaSyBCxOZ_5Y2VrjbqcfDvJ999aM8f3mmKy6k
        // geocodeResult enviando todo el resultado obtenido
        geocoder.geocode({ 'address': address}, geocodeResult);
        }
}
function geocodeResult(results, status) {
    if (status == 'OK') {
        var mapOptions = {center: results[0].geometry.location,mapTypeId: google.maps.MapTypeId.ROADMAP};
        map = new google.maps.Map($("#map_canvas").get(0), mapOptions);
        document.forms[0].lat.value=results[0].geometry.location.lat();
        document.forms[0].lon.value=results[0].geometry.location.lng();
        //$('#latitude').text(results[0].geometry.location.lat());
        //$('#longitude').text(results[0].geometry.location.lng());
        map.fitBounds(results[0].geometry.viewport);
        var markerOptions = { position: results[0].geometry.location }
        var marker = new google.maps.Marker(markerOptions);
        marker.setMap(map);
    } else {
        alert("Introducir una Direccion de Cliente Valida para activar la Logistica: ");
    }
}
</script>

<script type="text/javascript">

    function guardarDatosLogistica() {
        alert('Los datos se guardaron');
        document.editarLogistica.action = 'guardarLogistica';
        document.editarLogistica.submit();

    }
    function regresar() {
        document.editarLogistica.action = 'mostrarLogistica';
        document.editarLogistica.submit();
    }
</script>

<article class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
   <br /><br /><h1>Editar Formulario</h1>
  <section class="formulario dt">

            

<form name="editarLogistica" action="" method="post" accept-charset="utf-8" enctype="multipart/form-data">
<table border="0" width="100%">
    <tr>
        <td>
        <center>
            <?php 
                if ($result['imagenvisita']!='') //si tiene datos de la url los imprime
                {
                    //echo "logo";
                    echo '<img src="'.$result['imagenvisita'].'" width="250" height="250">
                      <label><input type="checkbox" name="imgEliminar" value="'.$result['imagenvisita'].'">Eliminar</label>';//Enviamos por post el nombre de la imagen para proceder a eliminar.
                }
                else//si no tiene logo de imagen pone tabla para subir imagen y pone una imagen basica
                {
                    echo "<table border='0'><tr><td colspan='2'>";
                    echo '<center><img src="http://localizacion.monitoreovisual.com/data/logistica/idlogistica.png" width="250" height="250"></center>';
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
<input type="submit" onclick="guardarDatosLogistica()" value="Guardar">
<input type="submit"  onclick="regresar()" value ="Cancelar">

        
                    <label for="newUsuarioID">Folio</label>
         <input type="text" name="usuarioIDM" placeholder="Empresa" value="<?php echo $result['logisticaID']; ?>" readonly><br>
         <label for="folioEmpresaID">Folio de Empresa</label>
         <input type="text" name="folioEmpresaID" placeholder=" 10L0001203456" value="<?php echo $result['folioEmpresaID']; ?>">
         <label for="folioCorporativoID">Folio Corporativo</label>
         <input type="text" name="folioCorporativoID" placeholder=" 10L0001203456" value="<?php echo $result['folioCorporativoID']; ?>">




                    <label for="Usuario"><strong>Nombre de Cuestionario</strong></label>
                    <input type="text" name="newUsuarioID" placeholder="Empresa" value="<?php echo $result['nombreMostrar']; ?>" readonly>


                    <label for="nameContacto">Nombre del Cliente</label>
                    <input type="text" name="nameContacto" placeholder=" Empresa de ... " value="<?php echo $result['nombreContactoCliente']; ?>" required>
                    <br>
                    <label for="nameContactoS">Cliente Guardado</label>
                   
                    <select name="nameContactoS">
<?php 
    echo "<option value=''></option>";
    //sort($dispos);
    //echo $dis['dispositivoID'];
    foreach($client as $client)
        {
            //echo $client['id'];
            if ($client['id']==$result['idContactoCliente']) //compara la lista de geozona y comprueba con el resultado ya guardadodispositivoID, mostrarNombre
                {
                    echo "<option value='".$result['idContactoCliente']."' selected>".$client['nombreCuest']."</option>";
                }
            else
                {
                    echo "<option value='".$client['id']."'>".$client['nombreCuest']."</option>"; //Esteticamente Visible BD
                }
        }
?>
                    </select>   


<label for="password">Contraseña de Rastreo Actual</label><?echo $result['contrasenaRastreo'];?>

<label for="fechafin">Fecha Liquida</label>
<?
$date = new DateTime($result['FechaLiquida']);
$hora=$date->format('H:i:s');
$fecha=$date->format('Y-m-d');
?>
<input type="date" name="fechaliqui" value="<?php echo $fecha;?>" step="1">
<label for="horafin">Hora Liquida</label>
<input type="time" name="horaliqui" value="<?php echo $hora;?>"step="1">


            
            
        </td>
    </tr>
    <tr>
        <td>
        <table border="0">
            <tr>
                <td><label for="visita">Tipo de Visita</label></td>
            </tr>
            <tr>
                <td><select name="visita">
    <?php 
                            if($result['tipoVisita']=='Venta')
                            {
                                echo "<option value=''></option>";
                                echo "<option value='Venta' selected>Venta</option>";
                                echo "<option value='Compra'>Compra</option>";
                                echo "<option value='Otro'>Otro</option>";
                            }
                            if($result['tipoVisita']=='Compra')
                            {
                                echo "<option value=''></option>";
                                echo "<option value='Venta'>Venta</option>";
                                echo "<option value='Compra' selected>Compra</option>";
                                echo "<option value='Otro'>Otro</option>";
                            } 
                            if($result['tipoVisita']=='Otro')
                            {
                                echo "<option value=''></option>";
                                echo "<option value='Venta'>Venta</option>";
                                echo "<option value='Compra'>Compra</option>";
                                echo "<option value='Otro' selected>Otro</option>";
                            }

                            else//Esto es una groseria pero es para rapido
                            {
                                echo "<option value='' selected> </option>";
                                echo "<option value='Venta'>Venta</option>";
                                echo "<option value='Compra'>Compra</option>";
                                echo "<option value='Otro'>Otro</option>";
                            }
        ?>
                    </select></td></tr>
                    <tr><td><label for="nvisita">Numero de Visita</label><input type="number" name="numeroVisita" value="<?php echo $result['numeroVisita'];?>"step="1"></td></tr>
               
        </table>
                
                    






                    <label for="personalID">Personal Asignado</label>
                    <select name="personalID">
<?php 
    echo "<option value=''></option>";
    //sort($dispos);
    //echo $dis['dispositivoID'];
    foreach($dis as $dis)
        {
            echo $dis['dispositivoID'];
            if ($dis['dispositivoID']==$result['personalID']) //compara la lista de geozona y comprueba con el resultado ya guardadodispositivoID, mostrarNombre
                {
                    echo "<option value='".$result['personalID']."' selected>".$dis['mostrarNombre']."</option>";
                }
            else
                {
                    echo "<option value='".$dis['dispositivoID']."'>".$dis['mostrarNombre']."</option>"; //Esteticamente Visible BD
                }
        }
?>
                    </select>         

                     

                    <label for="esActiva">Está activo</label>
                    <select name="esActiva">
                        <?php if($result['esActivo']==1){
                        echo "<option value='1'>Si</option>";
                            echo "<option value='0'>No</option>";
                        }else{
                            echo "<option value='0'>No</option>";
                            echo "<option value='1' >Si</option>";
                        }
                         ?>
                    </select>
                    
                    <label for="localizable">Rastreo GPS del Paquete</label>
                    <select name="localizable">
                        <?php if($result['localizable']==1){//activa o desactiva en dispositivos
                        echo "<option value='1'>Si</option>";
                            echo "<option value='0'>No</option>";
                        }else{
                            echo "<option value='0'>No</option>";
                            echo "<option value='1' >Si</option>";
                        }
                         ?>
                    </select>
        </td>
        <td>

            <label for="telcontacto">Teléfono del Cliente</label>
                    <input type="text" name="telcontacto" placeholder=" (LADA)12345678" value="<?php echo $result['telefonoCliente']; ?>">
                    <li>
                    <label for="emailContacto">Email del contacto</label>
                    <input type="text" name="emailContacto" placeholder=" correo.electronico@servidor.com" value="<?php echo $result['correoCliente']; ?>">
          
       
           
        </td>
    </tr>
    <tr>
    <td >
    <center>
         <label for="notas">Notas</label>
<textarea name="notas" rows="10" placeholder=" Notas de ... " cols="40"><?php echo $result['notas']; ?></textarea>
        </center>
    </td>
    <td>
    <center>
         <label for="descripcion">Descripción</label>
<textarea name="descripcion" rows="10" placeholder=" Usuario de ... " cols="40"><?php echo $result['descripcion']; ?></textarea>
        </center>
    </td>
       
    </tr>
</table>

<body onload="load_map()">
<table border="0" align="center" style="width:100%;">
        
        <tr>
            <td>
                <input type="text" maxlength="100" name="direccionCliente" id="address" placeholder="Dirección del Cliente" value="<?php echo $result['direccionCliente']; ?>"/> 
            </td>
            <td>
                <input type="button" id="search" value="Buscar" onclick="load_map()"/>
            </td>
        </tr>
        <tr><td colspan="2"><div id='map_canvas' style="width:100%; height:400px;"></div></td></tr>
        <tr>
            <td><label>Latitud:<input type="text" name="lat" readonly="true" placeholder="Error!"/></label></td>
            <td><label>Longitud:<input type="text" name="lon" readonly="true" placeholder="Error!"/></label></td>
        </tr>
</table>
</body>


<table border="0" align="center">
<tr>
<td>
    <label for="generadorID">Generador de Cuestionario</label>
                    <select name="generadorID">
<?php 
    echo "<option value=''></option>";
    //sort($dispos);
    //echo $dis['dispositivoID'];
    foreach($gen as $dis)
        {
            //echo $dis['id'];
            if ($dis['id']==$result['generador']) //compara la lista de geozona y comprueba con el resultado ya guardadodispositivoID, mostrarNombre
                {
                    echo "<option value='".$result['generador']."' selected>".$dis['nombreCuest']."</option>";
                }
            else
                {
                    echo "<option value='".$dis['id']."'>".$dis['nombreCuest']."</option>"; //Esteticamente Visible BD
                }
        }
?>
                    </select>
</td>
    <td></td>
</tr>
    <tr>
        <td>
            <label for="p1">Cuestionario</label>
            <input type="text" name="p1" placeholder=" Pregunta 1" value="<?php echo $result['p1']; ?>"><?php echo $result['p1nota']; ?>
            <input type="text" name="p2" placeholder=" Pregunta 2" value="<?php echo $result['p2']; ?>"><?php echo $result['p2nota']; ?>
            <input type="text" name="p3" placeholder=" Pregunta 3" value="<?php echo $result['p3']; ?>"><?php echo $result['p3nota']; ?>
            <input type="text" name="p4" placeholder=" Pregunta 4" value="<?php echo $result['p4']; ?>"><?php echo $result['p4nota']; ?>
            <input type="text" name="p5" placeholder=" Pregunta 5" value="<?php echo $result['p5']; ?>"><?php echo $result['p5nota']; ?>
            <input type="text" name="p6" placeholder=" Pregunta 6" value="<?php echo $result['p6']; ?>"><?php echo $result['p6nota']; ?>
            <input type="text" name="p7" placeholder=" Pregunta 7" value="<?php echo $result['p7']; ?>"><?php echo $result['p7nota']; ?>
            <input type="text" name="p8" placeholder=" Pregunta 8" value="<?php echo $result['p8']; ?>"><?php echo $result['p8nota']; ?>
            <input type="text" name="p9" placeholder=" Pregunta 9" value="<?php echo $result['p9']; ?>"><?php echo $result['p9nota']; ?>
            <input type="text" name="p10" placeholder=" Pregunta 10" value="<?php echo $result['p10']; ?>"><?php echo $result['p10nota']; ?>
        </td>



<td>
<label for="p1b">Confirmacion</label>

<input type="CHECKBOX" name="p1b"  <?php if ($result['p1b']=='1') {echo "checked";} ?>>
<input type="CHECKBOX" name="p2b"  <?php if ($result['p2b']=='1') {echo "checked";} ?>>
<input type="CHECKBOX" name="p3b"  <?php if ($result['p3b']=='1') {echo "checked";} ?>>
<input type="CHECKBOX" name="p4b"  <?php if ($result['p4b']=='1') {echo "checked";} ?>>
<input type="CHECKBOX" name="p5b"  <?php if ($result['p5b']=='1') {echo "checked";} ?>>
<input type="CHECKBOX" name="p6b"  <?php if ($result['p6b']=='1') {echo "checked";} ?>>
<input type="CHECKBOX" name="p7b"  <?php if ($result['p7b']=='1') {echo "checked";} ?>>
<input type="CHECKBOX" name="p8b"  <?php if ($result['p8b']=='1') {echo "checked";} ?>>
<input type="CHECKBOX" name="p9b"  <?php if ($result['p9b']=='1') {echo "checked";} ?>>
<input type="CHECKBOX" name="p10b"  <?php if ($result['p10b']=='1') {echo "checked";} ?>>
            
            
        </td>
        <td>
            <label for="p1c">Status</label>



            <?php
if ($result['p1c']=='0') {
   echo '<font color="#228B22">Abierto</font>';
}
if ($result['p1c']=='1') {
   echo '<font color="#FFD700">Pendiente</font>';
}
if ($result['p1c']=='2') {
   echo '<font color="#FFA500">Procesado</font>';
}
if ($result['p1c']=='3') {
   echo '<font color="red">Cerrado</font>';
}
echo "<br>";
if ($result['p2c']=='0') {
   echo '<font color="#228B22">Abierto</font>';
}
if ($result['p2c']=='1') {
   echo '<font color="#FFD700">Pendiente</font>';
}
if ($result['p2c']=='2') {
   echo '<font color="#FFA500">Procesado</font>';
}
if ($result['p2c']=='3') {
   echo '<font color="red">Cerrado</font>';
}
echo "<br>";
if ($result['p3c']=='0') {
   echo '<font color="#228B22">Abierto</font>';
}
if ($result['p3c']=='1') {
   echo '<font color="#FFD700">Pendiente</font>';
}
if ($result['p3c']=='2') {
   echo '<font color="#FFA500">Procesado</font>';
}
if ($result['p3c']=='3') {
   echo '<font color="red">Cerrado</font>';
}
echo "<br>";
if ($result['p4c']=='0') {
   echo '<font color="#228B22">Abierto</font>';
}
if ($result['p4c']=='1') {
   echo '<font color="#FFD700">Pendiente</font>';
}
if ($result['p4c']=='2') {
   echo '<font color="#FFA500">Procesado</font>';
}
if ($result['p4c']=='3') {
   echo '<font color="red">Cerrado</font>';
}
echo "<br>";
if ($result['p5c']=='0') {
   echo '<font color="#228B22">Abierto</font>';
}
if ($result['p5c']=='1') {
   echo '<font color="#FFD700">Pendiente</font>';
}
if ($result['p5c']=='2') {
   echo '<font color="#FFA500">Procesado</font>';
}
if ($result['p5c']=='3') {
   echo '<font color="red">Cerrado</font>';
}
echo "<br>";
if ($result['p6c']=='0') {
   echo '<font color="#228B22">Abierto</font>';
}
if ($result['p6c']=='1') {
   echo '<font color="#FFD700">Pendiente</font>';
}
if ($result['p6c']=='2') {
   echo '<font color="#FFA500">Procesado</font>';
}
if ($result['p6c']=='3') {
   echo '<font color="red">Cerrado</font>';
}
echo "<br>";
if ($result['p7c']=='0') {
   echo '<font color="#228B22">Abierto</font>';
}
if ($result['p7c']=='1') {
   echo '<font color="#FFD700">Pendiente</font>';
}
if ($result['p7c']=='2') {
   echo '<font color="#FFA500">Procesado</font>';
}
if ($result['p7c']=='3') {
   echo '<font color="red">Cerrado</font>';
}
echo "<br>";
if ($result['p8c']=='0') {
   echo '<font color="#228B22">Abierto</font>';
}
if ($result['p8c']=='1') {
   echo '<font color="#FFD700">Pendiente</font>';
}
if ($result['p8c']=='2') {
   echo '<font color="#FFA500">Procesado</font>';
}
if ($result['p8c']=='3') {
   echo '<font color="red">Cerrado</font>';
}
echo "<br>";
if ($result['p9c']=='0') {
   echo '<font color="#228B22">Abierto</font>';
}
if ($result['p9c']=='1') {
   echo '<font color="#FFD700">Pendiente</font>';
}
if ($result['p9c']=='2') {
   echo '<font color="#FFA500">Procesado</font>';
}
if ($result['p9c']=='3') {
   echo '<font color="red">Cerrado</font>';
}
echo "<br>";
if ($result['p10c']=='0') {
   echo '<font color="#228B22">Abierto</font>';
}
if ($result['p10c']=='1') {
   echo '<font color="#FFD700">Pendiente</font>';
}
if ($result['p10c']=='2') {
   echo '<font color="#FFA500">Procesado</font>';
}
if ($result['p10c']=='3') {
   echo '<font color="red">Cerrado</font>';
}
              ?>



        </td>
    </tr>
</table>







                    <input type="submit" onclick="guardarDatosLogistica()" value="Guardar">
				
					<input type="submit"  onclick="regresar()" value ="Cancelar">
			
		</form>
      
	</section>
 
  <!-- InstanceEndEditable --><!-- end .content --></article>