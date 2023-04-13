<script type="text/javascript">
	
	function enviarDatosLogistica(){
		document.muestraLogistica.action = 'editarLogistica';
		document.muestraLogistica.submit();
	}
    function verDatosLogistica(){
		document.muestraLogistica.action = 'verLogistica';
		document.muestraLogistica.submit();
	}

    function borrarLogistica(){
		if(confirm('¿Esta seguro que quiere borrar el Formulario seleccionado?')){
			document.muestraLogistica.action = 'borrarLogistica';
			document.muestraLogistica.submit();
		}
	}

     function crearLogistica(){
		document.crearLogistica.action = 'crearLogistica';
		document.crearLogistica.submit();
	}

</script>

<p><br>
  <article class="reportedesde">

                <h1>Logistica</h1>

                 <section>
                   <p> Por favor seleccione un Formulario:
                  </section>

                <section>
                    <div >
                        <form name="muestraLogistica" action="" method="POST">
                            <?php echo $this->table->generate()?>
                            <input type="button" value="Ver" onclick="verDatosLogistica()"/>
                            <input type="button" value="Editar"onclick="enviarDatosLogistica()"/>
                            <input type="button" value="Borrar" onclick="borrarLogistica()"/>
                            <a href="LogArchivo">Archivo</a>
                            <a href='EstadoLogistica'>Estado del Formulario</a>
                            <a href='GCuestionario'>Generador de Cuestionario</a>
                        </form>
                	  </div>
                </section>              
                     
                             
                <?php
                        $tipo = $this->session->userdata('perfil');
                    if(($tipo != '0' and $tipo != '1') || $this->session->userdata('perfil') === FALSE)
                          {
                              redirect(base_url().'sesion');
                          }
                ?> 
     

<div class="reporte dt">
      <h5>Agregar Formulario:</h5>
      <form name="crear" action="mostrarLogistica" method="post" accept-charset="utf-8">
        <ul>
          <li><?php 
              $conta=0;//para asegurarnos de que no informacion guardada.
              
              $ncuenta=$this->session->userdata('IDMV');
              function generaCeros($numero)
                                  {
                                    //obtengop el largo del numero
                                    $largo_numero = strlen($numero);
                                    //especifico el largo maximo de la cadena
                                    $maximo = 8;
                                    //tomo la cantidad de ceros a agregar
                                    $nuevo = $maximo - $largo_numero;
                                    //agrego los ceros
                                    for($i =0; $i<$nuevo; $i++)
                                      {
                                        $numero = "0".$numero;
                                      }
                                    //retorno el valor con ceros
                                    return $numero;
                                  }

if ($datosDispositivos!=0) 
{
          foreach($datosDispositivos as $datos)
                  {
                    if ($datos['cuentaID']==$this->session->userdata('cuenta')) 
                    {
                    $conta=$conta+1; 
                    }
                  }//fin forech
}

if ($conta==0)//significa que es nueva cuenta y no tiene aun dispositivos.
                {
                $imprimePos=generaCeros(1);//Nuevo
                }
if ($conta!=0) //ya tiene dispositivos en esta cuenta y veremos como identificar cada uno.
                {
                    $rs = mysql_query("SELECT MAX(contador) AS id FROM logistica");
                        if ($row = mysql_fetch_row($rs)) 
                        {
                        $id = trim($row[0]);
                        $id=$id+1;
                        $imprimePos=generaCeros($id);
                        //echo $id;
                        }            //$this->load->view('templates/menu');
                      
                //$imprimePos=generaCeros($conta);
                }//fin conta numeros
                            function generaCuenta($numero)
                                  {
                                    //obtengop el largo del numero
                                    $largo_numero = strlen($numero);
                                    //especifico el largo maximo de la cadena
                                    $maximo = 5;//id cuenta
                                    //tomo la cantidad de ceros a agregar
                                    $nuevo = $maximo - $largo_numero;
                                    //agrego los ceros
                                    for($i =0; $i<$nuevo; $i++)
                                      {
                                        $numero = "0".$numero;
                                      }
                                    //retorno el valor con ceros
                                    return $numero;
                                  }
                 echo "
              <label for='folio'>Folio Recomendado:</label>
              <input type='text' id='crearid' name='crearid' value='1L".generaCuenta($ncuenta).$imprimePos."' readonly='true' required>
            ";
            ?>





            </li>
                  <li>
            <label for="folio">Folio (empresa):</label>
            <input type="text" id="folio" name="folio" placeholder="" required>
            <label for="nomcuest">Nombre de Formulario:</label>
            <input type="text" id="nomcuest" name="nomcuest" placeholder="" required>
          </li>
      <div style="margin-left: 230px;">       
              <input type="submit" value="Crear">&nbsp;&nbsp;
              <input type="reset" value="Limpiar">
            </div>
        </ul>
      </form>
    </div>
    
  










     <p><br>
</article>