

<script type="text/javascript">
	
	function enviarDatosLogistica(){
		document.muestraLogistica.action = 'editarLogistica';
		document.muestraLogistica.submit();
	}
    function verDatosLogistica(){
		document.muestraLogistica.action = 'verLogistica';
		document.muestraLogistica.submit();
	}

<?php  //   function borrarLogistica(){
    //if(confirm('¿Esta seguro que quiere borrar el Formulario seleccionado?')){
      //document.muestraLogistica.action = 'sLogistica';
      //document.muestraLogistica.submit();
    //}
  //}
  ?>

     function crearLogistica(){
		document.crearLogistica.action = 'crearLogistica';
		document.crearLogistica.submit();
	}

var expanded = false;

function showCheckboxes() {
  var checkboxes = document.getElementById("checkboxes");
  if (!expanded) {
    checkboxes.style.display = "block";
    expanded = true;
  } else {
    checkboxes.style.display = "none";
    expanded = false;
  }
}
</script>


<style type="text/css"> 
.multiselect {
  width: 200px;
}

.selectBox {
  position: relative;
}

.selectBox select {
  width: 100%;
  font-weight: bold;
}

.overSelect {
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
}

#checkboxes {
  display: none;
  border: 1px #dadada solid;
}

#checkboxes label {
  display: block;
}

#checkboxes label:hover {
  background-color: #1e90ff;
}

</style> 




<p><br><p><br>
  <article class="reportedesde">

                <h1>Logistica</h1>

                 <section>
                   <p> Por favor seleccione un Formulario:
                  </section>

                <section>
                    <div >
                        <form name="muestraLogistica" action="" method="POST">
                            <?php echo $this->table->generate()?>
                            
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
      

<table border="0">
  <tr>
    <td>
      
      <h5>Agregar Formulario:</h5>

    </td>
  </tr>
  <tr>
    <td>
      

      <!--INICIO FORM -->

      <form name="crear" action="mostrarLogistica" method="post" accept-charset="utf-8">
        <ul>
          <li><?php 
              $conta=0;//para asegurarnos de que no informacion guardada.
              $comprueba=0;
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


$comprueba=$datosDispositivos;

if ($comprueba!='') 
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
                    <table border="0">
                      <tr>
                        <td><label for="folio">Folio (empresa): </label></td><td>
            <input type="text" id="folio" name="folio" placeholder="" required></td><td><input type="submit" value="Crear"></td>
                      </tr>
                      <tr>
                        <td><label for="nomcuest">Nombre de Formulario: </label></td><td>
            <input type="text" id="nomcuest" name="nomcuest" placeholder="" required></td><td><input type="reset" value="Limpiar"></td>
                      </tr>
                    </table>
            
            
          </li>
        </ul>


 <ul>
<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" type="text/css">
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#boot-multiselect-demo').multiselect({
            nonSelectedText: 'Seleccion de Personal',

    allSelectedText: "Todo Seleccionado",//Es el select dentro del input
    nSelectedText  : "Seleccionados",
    // search field
    filterPlaceholder: 'Buscar',
            selectAllText: 'Seleccionar Todos',
            deselectAllText: 'Ninguno Seleccionado',
            includeSelectAllOption: true,
            buttonWidth: 250,
            enableFiltering: true
        });
        });
    </script>
     <select multiple name="personal[]" id="boot-multiselect-demo" multiple="multiple">
        <?php
        //pasar todo el modelo a un modelo de este controlador, fue usado de rapido para asignar los cuestionarios
        //<label for="0"><input type="checkbox" id="0" />Ninguno</label>
      
        $usuarioSesion = $this->session->userdata('usuario');//es el usuario que inicio sesion importado de sesion
        $cadena = "";
        $contadorLista=0;
        $perfil_mapa = $this->session->userdata['perfil'];
        if($perfil_mapa == '0' || $perfil_mapa == '1')//si es sysadmin muestra tambien la cuenta del vehiculo
          {
            sort($gps);
            foreach ($gps as $nombreEnListaGps)// despues de este for comparar lo que se dijo antes en el comentario.
              {
                if ($nombreEnListaGps['tipoEquipo']=='Movil-web' || $nombreEnListaGps['tipoEquipo']=='WEB')  
                {
                    $contadorLista++;//numera los dispositivos
                    $cadena = " (".$contadorLista.") " . $nombreEnListaGps['mostrarNombre'];
            
            //echo '<label for="'.$contadorLista.'"><input type="checkbox" id="'. $nombreEnListaGps['dispositivoID'] .'" />'. $nombreEnListaGps['mostrarNombre'].'</label>';
                  
                        echo "<OPTION VALUE='".$nombreEnListaGps['dispositivoID']."'>" . $cadena . "</OPTION>";
                      
                }
              }//fin del forech 
            
          }//fini usuario tipo 0
                    
/////////////////////////////////////////////////////NIVEL 1///////////////////////////////////////
?>





    </select>



 </ul>



      </form>









    </td>
  </tr>
    <tr>
    <td><h5>
                            <a href="LogArchivo">Archivo</a><br>
                            <a href='EstadoLogistica'>Estado del Formulario</a><br>
                            <a href='GCuestionario'>Generador de Cuestionario</a><br>
                            <!--<a href="masivoLogistica">Agregar Formulario Masivo</a><br>-->












    </h5></td>
  </tr>
</table>

    </div>
    
  










     <p><br>
</article>