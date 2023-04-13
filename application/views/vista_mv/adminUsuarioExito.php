<script type="text/javascript">
function regresar() 
{
        document.editarUsuario.action = 'mostrarUsuarios';
        document.editarUsuario.submit();
}
</script>

<article class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
	
  	<section class="formulario dt">
        <h1> Datos de Usuario Guardados </h1>

<form name="editarUsuario" action="" method="POST" accept-charset="utf-8">
  				<li>
					<input type="submit"  onclick="regresar()" value ="Regresar">
				</li>
	</form>



	</section>  
  <!-- InstanceEndEditable --><!-- end .content -->
</article>
