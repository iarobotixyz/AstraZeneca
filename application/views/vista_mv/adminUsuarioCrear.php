<script type="text/javascript">
    function Borrar(){
    if(confirm('¿Esta seguro que quiere borrar el dispositivo seleccionado?')){
      document.muestra.action = 'Borrar';
      document.muestra.submit();
    }
  }
</script>
<article>
<p><br>
<section class="reportedesde">

<h1>Crear Usuarios</h1>
<section>
    <div >
<?php $nivel = $this->session->userdata('perfil');//echo $this->session->userdata('perfil');//DOMOTICA;?>
<form name='muestraDispositivos' action='' method='POST'>
<?php


  if ($nivel==0 || $nivel==1) //si es superadministrador muestra formulario .
              {
             echo " 
               <table border='0'>
                <tr>
                <td> 
                <select name='administra' onChange='muestraDispositivos.submit()' disabled>
                "; 

                  //$pcuenta='0';
                  $posibleID='666';
                  //$microfono=$_POST['microfono'];
                  $administra=$_POST['administra'];
                  //$panico=$_POST['panico'];
                  //$motor=$_POST['motor'];
                  //$pcuenta=$_POST['cuentaID'];
                  $ncuenta=$this->session->userdata('IDMV');
                  $posibleID=$_POST['posibleID'];
    ?>
                <option value ='1w000' disabled>MV</option>
<?php  
                echo "
                </select>
                </td> ";

//////////////////////Filtro para nuevo dispositivo o sugerir uno que no exista de esa cuenta.////////////////////////////
               echo "<td>
               	
<select name='' disabled>";
                //importar el post de la cuentaID seleccionada y mostrar solo los dispositivos de esa cuenta
               $conta=0;//para asegurarnos de que no informacion guardada.
                function generaCeros($numero)
                                  {
                                    //obtengop el largo del numero
                                    $largo_numero = strlen($numero);
                                    //especifico el largo maximo de la cadena
                                    $maximo = 4;
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
                foreach($datosDispositivos as $datos)
                  {
                    if ($datos['cuentaID']==$this->session->userdata('cuenta')) 
                    {
                     //$datos['dispositivoID'] = substr($datos['dispositivoID'], -4);//quita los primeros 5 caracteres de ID
                     //echo "<option>".$datos['dispositivoID']."</option>";//imprime ya con el recorte y mostra los que estan asociados.
                    //Contador para saber cuantos dispositivos tiene la cuenta, si no tuviera ningun dispositivo se generaria por defecto 0001.
                     $conta=$conta+1; 
                    }
                  }//fin forech
                 
if ($conta==0)//significa que es nueva cuenta y no tiene aun dispositivos.
  {
    echo "<option value='0001'>0001</option>";
    $imprimePos='0001';
  }

if ($conta!=0) //ya tiene dispositivos en esta cuenta y veremos como identificar cada uno.
  {
    $conta=$conta+1; //Comparar aqui si conta ya existe en los dispositivos dentro de un for si esi asi que incremente en uno. Ronda 1
    foreach($datosDispositivos as $datos)
      {
        if ($datos['cuentaID']==$this->session->userdata('cuenta')) 
          {//si conta es igual a datos dispositivo id significa que ya existe y que debe incrementar en uno.
            $datos['usuarioIDMV'] = substr($datos['usuarioIDMV'], -4);//quita los primeros 5 caracteres de ID
                     							
            if ($conta==$datos['usuarioIDMV']) 
                {
                  $conta=$conta+1;
                }
          }
      }//fin forech
//////////ronda 1 fin ronda 2 inicio
          foreach($datosDispositivos as $datos)
      {
        if ($datos['cuentaID']==$this->session->userdata('cuenta')) 
          {//si conta es igual a datos dispositivo id significa que ya existe y que debe incrementar en uno.
            $datos['usuarioIDMV'] = substr($datos['usuarioIDMV'], -4);//quita los primeros 5 caracteres de ID
                                  
            if ($conta==$datos['usuarioIDMV']) 
                {
                  $conta=$conta+1;
                }
          }
      }//fin forech

      //////////ronda 2





      echo "<option value='".generaCeros($conta)."'>".generaCeros($conta)."</option>";
      $imprimePos=generaCeros($conta);
  }
               
               echo "</select></td>";
///////////////////////////////////////////////////////////////////////////Fin Dispositivos////////////////////////////
        function generaCuenta($numero)
                                  {
                                    //obtengop el largo del numero
                                    $largo_numero = strlen($numero);
                                    //especifico el largo maximo de la cadena
                                    $maximo = 5;
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
                 <td><label>ID MV</label>


                <input type='text' name='idMV' value='".generaCuenta($ncuenta).$imprimePos."' readonly='true'/>
                </td>
                <td>
<label>Nombre de Usuario</label>
                <input type='text' name='nombreUs' placeholder=' Juan Perez' required>
                </td>
<td>
                <select name='nivel' required>
                <option value ='Operador'>Operador</option>
                <option value ='Administrador'>Administrador</option>
                </select>
</td>


                <td><input type='submit' name='nuevo' value='Nuevo' /></td>
               
                </tr></table>";
        }//fin compara nivel 0-1
?>

</form>

<form name='listaDispositivos' action='' method='POST'>

<table border="1" cellpadding="1" cellspacing="0" width="100%">

<tr>
<td><b>#</b></td>
<td><b>Nivel de Usuario</b></td>
<td><b>ID</b></td>
<td><b>Nombre de Usuario</b></td>
</tr>
  <?php 
            $conta=1;

            if ($datosDispositivos==0) 
            {//significa que no tiene dato
              echo "<b>No se encuentra ningun Usuario Administrador</b>";
              //agregar una imagen de forma amigable indique.
            }
            else
            { 
              sort($datosDispositivos);
              $comparaUsuario=$this->session->userdata('usuario');//para mostrar solo el grupo del usuario que inicio en el caso de ser nivel 2
              $boton=0;
              foreach($datosDispositivos as $datos)
              {
                echo "<tr>";
                    if ($nivel==0 || $nivel==1) 
                    { 
                       
                      if ($boton==1) 
                      {
                        echo "<td>";
                        echo "<label><input type='radio' id='' name='dispositivoID' value='".$datos['usuarioIDMV']."'>".$conta++."</label>";//sin seleccion 
                        echo "</td>";
                        $boton=1;//por si las dudas 
                      }
                      if ($boton==0) 
                      {
                        echo "<td>";
                        echo "<label><input type='radio' id='' name='dispositivoID' value='".$datos['usuarioIDMV']."' checked>".$conta++."</label>";//seleccion 1 
                        echo "</td>";
                        $boton=1;//este es el que hace el cambio de fin de seleccion
                      }
                      //echo "<td>".$datos['IDMV']."</td>";
                      if ($datos['tipoCuenta']==0) 
                        {
                         $rangoTipo='Superadministrador';
                        }
                      if ($datos['tipoCuenta']==1) 
                        {
                         $rangoTipo='Administrador';
                        }
                      if ($datos['tipoCuenta']==2) 
                        {
                         $rangoTipo='Operador';
                        }





                      echo "<td>".$rangoTipo.'</td>
                            <td>'.$datos['usuarioIDMV']."</td>";//imprime si es nivel sysadmin
                      //echo "<td>".$datos['usuarioDefecto']."</td>";
                      echo "<td>".$datos['nombreContacto']."</td>";
                    }
                echo "</tr>";
            }//fin forech
          }//fin else principal $datosDispositivos
          ?>

</TABLE>
    <?php
          //if ($nivel==0 || $nivel==1) //si es administrador o superadministrador muestra formulario para grupo nuevo.
              //{
                //echo "boton agregar grupo nuevo";
                //echo validation_errors();
                //echo form_open('crearCuenta');
                //echo " <input type='submit' name='Borrar' value='Borrar' />";
              //}
      ?>

   </form>
          </div>
      </section>
			
<a href="mostrarUsuarios">Regresar</a>


<p><br>
      </section>
</article>

<?php 
//echo $this->session->userdata('cuenta');
//echo $this->session->userdata('perfil');//nivel
//echo $this->session->userdata('IDMV');//IDMV id MV del cliente
 ?>