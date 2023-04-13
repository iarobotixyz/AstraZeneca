<script type="text/javascript">

    function regresar() {
        document.editarUsuario.action = 'mostrarUsuarios';
        document.editarUsuario.submit();
    }
</script>


<article class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
   <br /><br /><h1>Ver datos de usuario</h1>
  <section class="formulario dt">
  <h10> * campos requeridos</h10>

            <form name="editarUsuario" action="" method="POST" accept-charset="utf-8">
		<ul>
                <li>
					<label for="usuarioID">Identificador de Usuario</label>
					<input type="text" name="usuarioID" placeholder="Empresa" value="<?php echo $result['usuarioDefecto']; ?>"  disabled>
				</li>
            <li>
					<label for="esActiva">Está activo</label>
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
					<label for="password">Contraseña</label>
					<input type="password" name="password" placeholder="*****" value="<?php echo $result['contrasena']; ?>"  disabled></li>

            <li>
					<label for="nameContacto">Nombre Contacto</label>
					<input type="text" name="nameContacto" placeholder=" Empresa de ... " value="<?php echo $result['nombreContacto']; ?>"  disabled></li>
            <li>
					<label for="telcontacto">Teléfono del contacto</label>
					<input type="text" name="telcontacto" placeholder=" (LADA)12345678" value="<?php echo $result['telefonoContacto']; ?>"  disabled></li>
                    <li>
					<label for="emailContacto">Email del contacto</label>
					<input type="text" name="emailContacto" placeholder=" correo.electronico@servidor.com" value="<?php echo $result['correoContacto']; ?>"  disabled></li>
             <li>
					<label for="emailNotificaiones">Email para notificaciones</label>
					<input type="text" name="emailNotificaiones" placeholder=" Juan perez" value="<?php echo $result['notificarCorreo']; ?>"  disabled></li>
            			
                <li>
					<input type="submit"  onclick="regresar()" value ="Regresar">
				</li>
			

        <?php  
//hacemos configuraciones QR
    $cuentaID = $this->session->userdata('cuenta');
    $serv='201.99.111.11';
  //$params['data'] = $result['usuarioDefecto'];
    $params['data'] =$cuentaID.' - '.$result['usuarioDefecto'].' - '.$result['nombreContacto'].' - '.$result['correoContacto'].' - '.$result['telefonoContacto'].' - '.$result['usuarioIDMV'].' - '.$serv.' - '.$result['muestreoAPP'].' - '.$result['autoarranqueAPP'];//usuarioIDMV// 
    $params['level'] = 'L';
    $params['size'] = 5;
    //decimos el directorio a guardar el codigo qr, en este 
    //caso una carpeta en la raíz llamada qr_code
    $params['savename'] = FCPATH."cache/QR/MV".md5($cuentaID.'|'.$result['nombreContacto']).'.png';
    //generamos el código qr
    $this->ciqrcode->generate($params); 
    //echo '<img src="'.base_url().'QR/qrcode.png" />';

    echo "<img src='".base_url()."cache/QR/MV".md5($cuentaID.'|'.$result['nombreContacto']).".png' />";

?>
		</ul></form>
      
	</section>
 
  <!-- InstanceEndEditable --><!-- end .content --></article>