<script type="text/javascript">

    function regresar() {
        document.editarLogistica.action = 'mostrarLogistica';
        document.editarLogistica.submit();
    }
</script>


<article class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
   <br /><br /><h1>Ver datos del Formulario</h1>
  <section class="formulario dt">

            <form name="editarLogistica" action="" method="POST" accept-charset="utf-8">
		<ul>
                <li>
					<label for="usuarioID">Folio</label>
					<input type="text" name="usuarioID" placeholder="Empresa" value="<?php echo $result['nombreMostrar']; ?>"  disabled>
				</li>
            <li>
					<label for="esActiva">Formulario activo</label>
                    <select name="esActiva" disabled>
                        <?php if($result['esActiva']==1){
                        echo "<option value='1'>Si</option>";
                            echo "<option value='0'>No</option>";
                        }else{
                            echo "<option value='0'>No</option>";
                            echo "<option value='1' >Si</option>";
                        }
                         ?>
                    </select>
					</li>
            <li>
					<label for="descripcion">Descripción</label>
					<input type="text" name="descripcion" placeholder=" Empresa de ... " value="<?php echo $result['descripcion']; ?>"  disabled></li>
            <li>
					<label for="password">Contraseña de Rastreo</label>
					<input type="text" name="password" placeholder="*****" value="<?php echo $result['contrasenaRastreo']; ?>"  disabled></li>

            <li>
					<label for="nameContacto">Nombre del Cliente</label>
					<input type="text" name="nameContacto" placeholder=" Empresa de ... " value="<?php echo $result['nombreContactoCliente']; ?>"  disabled></li>
            <li>
					<label for="telcontacto">Teléfono del Cliente</label>
					<input type="text" name="telcontacto" placeholder=" (LADA)12345678" value="<?php echo $result['telefonoCliente']; ?>"  disabled></li>
                    <li>
					<label for="emailContacto">Email del Cliente</label>
					<input type="text" name="emailContacto" placeholder=" correo.electronico@servidor.com" value="<?php echo $result['correoCliente']; ?>"  disabled></li>
   
                <li>
					<input type="submit"  onclick="regresar()" value ="Regresar">
				</li>
			

        <?php  
//hacemos configuraciones QR
    $cuentaID = $this->session->userdata('cuenta');
  //$params['data'] = $result['conductorDefecto'];
    $params['data'] =$cuentaID.' - '.$result['nombreMostrar'].' - '.$result['nombreContactoCliente'].' - '.$result['correoCliente'].' - '.$result['telefonoCliente'].' - '.$result['logisticaID'];//usuarioIDMV
    $params['level'] = 'L';
    $params['size'] = 5;
    //decimos el directorio a guardar el codigo qr, en este 
    //caso una carpeta en la raíz llamada qr_code
    $params['savename'] = FCPATH."cache/QR/MV".md5($cuentaID.'|'.$result['nombreContactoCliente']).'.png';
    //generamos el código qr
    $this->ciqrcode->generate($params); 
    //echo '<img src="'.base_url().'QR/qrcode.png" />';

    echo "<img src='".base_url()."cache/QR/MV".md5($cuentaID.'|'.$result['nombreContactoCliente']).".png' />";

?>
		</ul></form>
      
	</section>
 
  <!-- InstanceEndEditable --><!-- end .content --></article>