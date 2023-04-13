<?php

class maneja_estado_logistica_demo extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('modelos_mv/modelo_mv_logistica_status');
		$this->load->library('table');
	}
		
	public function e_d($primer=FALSE){
		$tipo = $this->session->userdata('perfil');
		if(($tipo != '0' and $tipo != '1' and $tipo != '2' and $tipo != '3' and $tipo != '4') || $this->session->userdata('perfil') === FALSE){redirect(base_url().'sesion');}
	
            $header = array('<IMG SRC='."images/sistema/cargando.gif".'><br>Cargando Informacion');
            //Establece los títulos 
            $this->table->set_heading($header);
            //formato de tabla 
            $tmpl = array (
                    'table_open'          => '<table border="0" cellpadding="1" align="center" cellspacing="0" width="100%">',

                    'table_close'         => '</table>'
              );

            $this->table->set_template($tmpl);

		$this->load->view('templates/cabecera');
		$this->load->view('templates/menu');
		$this->load->view('vista_mv/EstadoLogDemo');
		$this->load->view('templates/pie');
	}

public function e_dreturn($primer=FALSE){
		$tipo = $this->session->userdata('perfil');
		if(($tipo != '0' and $tipo != '1' and $tipo != '2' and $tipo != '3' and $tipo != '4') || $this->session->userdata('perfil') === FALSE){redirect(base_url().'sesion');}
	
        $cuentaId= $this->session->userdata('cuenta');
		$listaGps = $this->modelo_mv_logistica_status->lista_logistica($cuentaId);
		
		//Lista de variables que se usaran para las consultas
		$nombreGps='';//Nombre del gps
		$cont=1;
		$direccion='';
		$cuentaId_dispositivo=""; //La cuenta de a quien pertenece el gps
		$ufecha="<font color='red'><b>Sin Datos</b></font>";
				//Vamos a empezar a traer los datos de la tabla datos eventos .... aqui es donde hay que ciclar para cambiar de disp id	
		$fecha_ini = date('d/m/Y') . ' 00:00';//25200 son lo segundos que tienen 7 horas ya que mexico esta en -7
		$fecha_fin = date('d/m/Y') . ' 23:59';
		$fecha_formato_ini = $this->mv_utilerias->fecha_datatime($fecha_ini, ':00');
		$fecha_formato_fin = $this->mv_utilerias->fecha_datatime($fecha_fin, ':59');
			if($listaGps!=0)
{
		   sort($listaGps);
foreach($listaGps as $nombreEnListaGps => $row) 
           { //sinicia for
           		$array = array_values($row);
       			$datosGps = $this->modelo_mv_logistica_status->datosEvento($array[2],$array[0], $fecha_formato_ini, $fecha_formato_fin);
		//segunto compara Personal asignado en datosEventos
		if($datosGps == 0)//Comparamos personal asignado .... posteriormente este personal comparar con el vehiculo asignado
			{
				$datosGps = $this->modelo_mv_logistica_status->datosEvento($array[2],$array[1], $fecha_formato_ini, $fecha_formato_fin);
				if($datosGps == 0)//Comparamos personal asignado .... posteriormente este personal comparar con el vehiculo asignado
				{//$array[1] personal o conductor ID
					//asignar vehiculo dependiendo del ID del personal
					//tabla dispositivos pedir array 1  y debe regresar un ID de vehiculo , si no regresa nada no hace nada. pero si si asigna el nuevo array
				//$datosGps = $this->modelo_mv_logistica_status->datosEvento($array[2],$array[1], $fecha_formato_ini, $fecha_formato_fin);
					$ufecha="<font color='red'><b>Sin Datos</b></font>";
						$map='';
						$direccion='<font color="red"><b>Sin Datos</b></font>';	
				}
			}
		if($datosGps != 0)//ya tiene datos para mostrar
					{			
								foreach($datosGps as $datos)
								{
										//$ufecha = impode (",", $datos['fechaEjecucion']) 
										$ufecha="<font color='green'><b>".$datos['fechaEjecucion']."</b></font>";//la dejo asi por que en teoria imprime la ultima registrada
										
										$map='<a href="https://www.google.com.mx/maps/search/'.$datos['latitud'].'%20'.$datos['longitud'].'" target="_blank"><img src="images/sistema/mapa32.png" width="16" height="16" alt="Link Google"></a>';
										$direccion='<table>
												
												<tr><td>Personal Asignado</td></tr>		
												<tr><td>'.$datos['direccion'].'</td></tr>

												</table>';//<tr><td>Paquete</td></tr>
										
								}
					}




				
					
if ($array[15]==1) 
{$imagenONOFF1='<input type="CHECKBOX" name="activado1" value="" checked>';}
if ($array[15]==0) 
{$imagenONOFF1='<input type="CHECKBOX" name="desactivado1" value="">';}
if ($array[16]==1) 
{$imagenONOFF2='<input type="CHECKBOX" name="activado2" value="" checked>';}
if ($array[16]==0) 
{$imagenONOFF2='<input type="CHECKBOX" name="desactivado2" value="">';}
if ($array[17]==1) 
{$imagenONOFF3='<input type="CHECKBOX" name="activado" value="" checked>';}
if ($array[17]==0) 
{$imagenONOFF3='<input type="CHECKBOX" name="desactivado" value="">';}
if ($array[18]==1) 
{$imagenONOFF4='<input type="CHECKBOX" name="activado" value="" checked>';}
if ($array[18]==0) 
{$imagenONOFF4='<input type="CHECKBOX" name="desactivado" value="">';}
if ($array[19]==1) 
{$imagenONOFF5='<input type="CHECKBOX" name="activado" value="" checked>';}
if ($array[19]==0) 
{$imagenONOFF5='<input type="CHECKBOX" name="desactivado" value="">';}
if ($array[20]==1) 
{$imagenONOFF6='<input type="CHECKBOX" name="activado1" value="" checked>';}
if ($array[20]==0) 
{$imagenONOFF6='<input type="CHECKBOX" name="desactivado1" value="">';}
if ($array[21]==1) 
{$imagenONOFF7='<input type="CHECKBOX" name="activado2" value="" checked>';}
if ($array[21]==0) 
{$imagenONOFF7='<input type="CHECKBOX" name="desactivado2" value="">';}
if ($array[22]==1) 
{$imagenONOFF8='<input type="CHECKBOX" name="activado" value="" checked>';}
if ($array[22]==0) 
{$imagenONOFF8='<input type="CHECKBOX" name="desactivado" value="">';}
if ($array[23]==1) 
{$imagenONOFF9='<input type="CHECKBOX" name="activado" value="" checked>';}
if ($array[23]==0) 
{$imagenONOFF9='<input type="CHECKBOX" name="desactivado" value="">';}
if ($array[24]==1) 
{$imagenONOFF10='<input type="CHECKBOX" name="activado" value="" checked>';}
if ($array[24]==0) 
{$imagenONOFF10='<input type="CHECKBOX" name="desactivado" value="">';}

///////////////////////////////////////////////////////////////
if ($array[25]==0) 
{$estado1='<font color="#228B22"><b>Abierto</b></font>';}
if ($array[25]==1) 
{$estado1='<font color="#FFD700"><b>Pendiente</b></font>';}
if ($array[25]==2) 
{$estado1='<font color="#FFA500"><b>En Camino</b></font>';}
if ($array[25]==3) 
{$estado1='<font color="red"><b>Cerrado</b></font>';}
/////////////////Estado 2
if ($array[26]==0) 
{$estado2='<font color="#228B22"><b>Abierto</b></font>';}
if ($array[26]==1) 
{$estado2='<font color="#FFD700"><b>Pendiente</b></font>';}
if ($array[26]==2) 
{$estado2='<font color="#FFA500"><b>En Camino</b></font>';}
if ($array[26]==3) 
{$estado2='<font color="red"><b>Cerrado</b></font>';}
//Estado 3
if ($array[27]==0) 
{$estado3='<font color="#228B22"><b>Abierto</b></font>';}
if ($array[27]==1) 
{$estado3='<font color="#FFD700"><b>Pendiente</b></font>';}
if ($array[27]==2) 
{$estado3='<font color="#FFA500"><b>En Camino</b></font>';}
if ($array[27]==3) 
{$estado3='<font color="red"><b>Cerrado</b></font>';}
//Estado 4
if ($array[28]==0) 
{$estado4='<font color="#228B22"><b>Abierto</b></font>';}
if ($array[28]==1) 
{$estado4='<font color="#FFD700"><b>Pendiente</b></font>';}
if ($array[28]==2) 
{$estado4='<font color="#FFA500"><b>En Camino</b></font>';}
if ($array[28]==3) 
{$estado4='<font color="red"><b>Cerrado</b></font>';}
//Estado5
if ($array[29]==0) 
{$estado5='<font color="#228B22"><b>Abierto</b></font>';}
if ($array[29]==1) 
{$estado5='<font color="#FFD700"><b>Pendiente</b></font>';}
if ($array[29]==2) 
{$estado5='<font color="#FFA500"><b>En Camino</b></font>';}
if ($array[29]==3) 
{$estado5='<font color="red"><b>Cerrado</b></font>';}
//Estado6
if ($array[30]==0) 
{$estado6='<font color="#228B22"><b>Abierto</b></font>';}
if ($array[30]==1) 
{$estado6='<font color="#FFD700"><b>Pendiente</b></font>';}
if ($array[30]==2) 
{$estado6='<font color="#FFA500"><b>En Camino</b></font>';}
if ($array[30]==3) 
{$estado6='<font color="red"><b>Cerrado</b></font>';}
//Estado7
if ($array[31]==0) 
{$estado7='<font color="#228B22"><b>Abierto</b></font>';}
if ($array[31]==1) 
{$estado7='<font color="#FFD700"><b>Pendiente</b></font>';}
if ($array[31]==2) 
{$estado7='<font color="#FFA500"><b>En Camino</b></font>';}
if ($array[31]==3) 
{$estado7='<font color="red"><b>Cerrado</b></font>';}
//Estado8
if ($array[32]==0) 
{$estado8='<font color="#228B22"><b>Abierto</b></font>';}
if ($array[32]==1) 
{$estado8='<font color="#FFD700"><b>Pendiente</b></font>';}
if ($array[32]==2) 
{$estado8='<font color="#FFA500"><b>En Camino</b></font>';}
if ($array[32]==3) 
{$estado8='<font color="red"><b>Cerrado</b></font>';}
//Estado9
if ($array[33]==0) 
{$estado9='<font color="#228B22"><b>Abierto</b></font>';}
if ($array[33]==1) 
{$estado9='<font color="#FFD700"><b>Pendiente</b></font>';}
if ($array[33]==2) 
{$estado9='<font color="#FFA500"><b>En Camino</b></font>';}
if ($array[33]==3) 
{$estado9='<font color="red"><b>Cerrado</b></font>';}
//Estado10//////////////////////////////////////////////////////////////////////////////Ultimo34
if ($array[34]==0) 
{$estado10='<font color="#228B22"><b>Abierto</b></font>';}
if ($array[34]==1) 
{$estado10='<font color="#FFD700"><b>Pendiente</b></font>';}
if ($array[34]==2) 
{$estado10='<font color="#FFA500"><b>En Camino</b></font>';}
if ($array[34]==3) 
{$estado10='<font color="red"><b>Cerrado</b></font>';}
//Inicia en $array[5] por la estructura de importar en el arreglo del modelo
$tformulario='<table border="0">
				<tr>
					<td>'.$array[5].'</td>
					<td>'.$imagenONOFF1.'</td>
					<td>'.$estado1.'</td>
				</tr>
				<tr>
					<td>'.$array[6].'</td>
					<td>'.$imagenONOFF2.'</td>
					<td>'.$estado2.'</td>
				</tr>
				<tr>
					<td>'.$array[7].'</td>
					<td>'.$imagenONOFF3.'</td>
					<td>'.$estado3.'</td>
				</tr>
				<tr>
					<td>'.$array[8].'</td>
					<td>'.$imagenONOFF4.'</td>
					<td>'.$estado4.'</td>
				</tr>
				<tr>
					<td>'.$array[9].'</td>
					<td>'.$imagenONOFF5.'</td>
					<td>'.$estado5.'</td>
				</tr>

								<tr>
					<td>'.$array[10].'</td>
					<td>'.$imagenONOFF6.'</td>
					<td>'.$estado6.'</td>
				</tr>
				<tr>
					<td>'.$array[11].'</td>
					<td>'.$imagenONOFF7.'</td>
					<td>'.$estado7.'</td>
				</tr>
				<tr>
					<td>'.$array[12].'</td>
					<td>'.$imagenONOFF8.'</td>
					<td>'.$estado8.'</td>
				</tr>
				<tr>
					<td>'.$array[13].'</td>
					<td>'.$imagenONOFF9.'</td>
					<td>'.$estado9.'</td>
				</tr>
				<tr>
					<td>'.$array[14].'</td>
					<td>'.$imagenONOFF10.'</td>
					<td>'.$estado10.'</td>
				</tr>


			  </table><hr>';

$Status='';
if ($array[4]==0) {
	//$liga="'archivar?id='";
	$Status='<input style="border: #000 2px solid; color: #fff; background-color: #228B22" type="button" value="Abierto" />';
}
if ($array[4]==1) {
	//$liga="'archivar?id='";
	$Status='<input style="border: #000 2px solid; color: #000; background-color: #FFD700" type="button" value="Pendiente" />';
}
if ($array[4]==2) {
	//$liga="'archivar?id='";
	$Status='<input style="border: #000 2px solid; color: #fff; background-color: #FFA500" type="button" value="Procesado" />';
}
if ($array[4]==3) {
	$liga="'archivar?id=".$array[1]."'";
	$Status='<input style="border: #98141b 2px solid; color: #fff; background-color: #cd1920" type="button" value="Cerrado"/><br>';
}
$nCuestionario='<table border="0" align="center">
				<tr>
					<td align=center>'.$array[3].'</td>
				</tr>
				<tr>
					<td align=center>'.$Status.'</td>
				</tr>
			  </table>';	
$cuentaId= $this->session->userdata('cuenta');
        $datt= array();
        $datt=$this->modelo_mv_logistica_status->pasign($cuentaId,$array[1]);
        $printPasign=$datt['mostrarNombre'];

if ($this->session->userdata('usuarioIDMV')==$array[1]) 
{
	# code...
	$this->table->add_row($cont,$nCuestionario,$printPasign,$tformulario,$ufecha,$map,$direccion);
					            $cont=$cont+1;
}

					
            }//fin del for de listar dispositivos
}//fin del if compara si existe dispositivo

            //Crear cabezera perzonalizada
            $header = array('#','Nombre de Cuestionario','Personal Asignado','Cuestionario','Ultima Fecha de Envio', 'Mapa','Direcciones');
            //Establece los títulos 
            $this->table->set_heading($header);
            //formato de tabla 
            $tmpl = array (
                    'table_open'          => '<article><section class="reportedesde"><p><br><table border="0" cellpadding="1" align="center" cellspacing="0" width="100%">',

                    'heading_row_start'   => '<tr>',
                    'heading_row_end'     => '</tr>',
                    'heading_cell_start'  => '<th>',
                    'heading_cell_end'    => '</th>',

                    'row_start'           => '<tr>',
                    'row_end'             => '</tr>',
                    'cell_start'          => '<td align="center">',
                    'cell_end'            => '</td>',

                    'row_alt_start'       => '<tr>',
                    'row_alt_end'         => '</tr>',
                    'cell_alt_start'      => '<td align="center">',
                    'cell_alt_end'        => '</td>',

                    'table_close'         => '</table><p><br></section></article>'
              );

            $this->table->set_template($tmpl);
		$this->load->view('vista_mv/EstadoLogDemo');
		echo "<br><p><table align='center'><tr><td>Estado del Formulario ";
		$hora=date('h',time());//date('d/m/Y')
		echo "<FONT FACE='arial' SIZE=1 COLOR=white>".$hora."</font></td></tr></table>";
	}
	
	
}
	