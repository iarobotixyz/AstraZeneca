<script src="js/jquery-1.11.2.min.js"></script>
<script>
	$('document').ready(function(){
		function hora(){
			$.ajax({
				type:'POST',
				url:'EstadoLogisticaReturn',
				success: function($hora){
					$('#hora').html($hora);
				}
			});
		}
		setTimeout(hora(),90000);
	});
</script>
<?php
$nivel = $this->session->userdata('perfil');
	  if ($nivel==0 || $nivel==1) //si es administrador o superadministrador genera tabla (solo por seguridad)
	    {	
		echo '<div id="hora"></div>';
		echo $this->table->generate();
		}
?>