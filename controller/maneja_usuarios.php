<?php

class Maneja_usuarios extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('modelos_mv/modelo_mv_usuarios');
    $this->load->model('modelos_mv/modelo_mv_dispositivos');
    $this->load->model('modelos_mv/modelo_mv_mapa');
		$this->load->library('table');
	}

		


	public function muestra_usuarios(){
		$tipo = $this->session->userdata('perfil');
		if(($tipo != '0' and $tipo != '1') || $this->session->userdata('perfil') === FALSE){
           		redirect(base_url().'sesion');
        	}
		$data['title'] = 'Monitoreo Vehicular';
         $cuentaId=$this->session->userdata('cuenta');

	 $datos_cuentas = $this->modelo_mv_usuarios->datos_usuarios($cuentaId);
        if($datos_cuentas==0){
			$this->load->view('templates/cabecera');
			$this->load->view('templates/menu');
			$this->load->view('vista_mv/adminUsuario');
			$this->load->view('templates/pie');	
		}else{
           // $data['datosCuentas']=$datos_cuentas;
           foreach($datos_cuentas as $index => $row) { //set your rows here
           
           $array = array_values($row);
           $selecUsuarioId = $array[0];
           $IDFULL = $array[1];

            if(strlen($array[1])==15)//Si cumple con el num de ID 
                    {
                        $array[1] = substr($array[1], -4);//quita los primeros 5 caracteres de ID
                    }
///
if ($array[9]=='') 
{
$array[9]='data/usr/perfil.jpg';
}

                if($index ==0)
                    {
                        if ($selecUsuarioId=='admin') 
                        {
                            $selec = '<label><IMG SRC="'.$array[9].'" width="48" height="48"><br><input type="radio" name="selecUsuarioId" value='. $selecUsuarioId .' checked>'.$array[1].'</label>';
                        }
                         if ($selecUsuarioId!='admin') 
                        {
                            $selec = '<label><IMG SRC="'.$array[9].'" width="48" height="48"><br><input type="radio" name="selecUsuarioId" value='. $selecUsuarioId .' checked>'.$array[1].'</label>';
                            //agregar boton borrar
                        }
                    }
                if($index !=0)
                    {
                        $selec = '<label><IMG SRC="'.$array[9].'" width="48" height="48"><br><input type="radio" name="selecUsuarioId" value='. $selecUsuarioId .'>'.$array[1].'</label>';
                        //agregar boton borrar directamente
                    }

                  if(($array[4]==1))
                    {
                      if ($array[8]==1) 
                      {$celVerde='mobileverde.png';}
                      if ($array[8]==0) 
                      {$celVerde='mobilered.png';}

                        $UsuarioActivo = '<IMG SRC="images/MotorVerde.png" width="25" height="25" ALT="Encendido"><IMG SRC="images/'.$celVerde.'" width="25" height="25" ALT="Encendido">';
                    }
                  if(($array[4]==0))
                    {
                      if ($array[8]==1) 
                      {$celVerde='mobileverde.png';}
                      if ($array[8]==0) 
                      {$celVerde='mobilered.png';}
                        $UsuarioActivo = '<IMG SRC="images/MotorRojo.png" width="25" height="25" ALT="Apagado"><IMG SRC="images/'.$celVerde.'" width="25" height="25" ALT="Encendido">';
                    }
           
			//$fechaFormat= date("d-m-Y (H)", $array[6]);
			$date = date_create($array[6]); 
			$fechaFormat=date_format($date, 'Y-m-d');
$tablaFechas='<table border="0"><tr><td>Creaci&oacute;n</td><td>'.$fechaFormat.'</td></tr><tr><td>Actualizaci&oacute;n</td><td>'.$array[5].'</td></tr><tr><td>&Uacute;ltimo acceso</td><td>'.$array[7].'</td></tr></table>';
//
//
$ADMOPER='';
if ($array[12]=='0' || $array[12]=='1') 
{
  $ADMOPER='<IMG SRC="images/usuarioADM.png" width="25" height="25" ALT="Administrador"><br><center>1</center>';
}
if ($array[12]=='2' || $array[12]=='3') 
{
  $ADMOPER='<IMG SRC="images/usuarioOPE.png" width="25" height="25" ALT="Operador"><br><center>2</center>';
}

$tablaUsr='<table><tr><td></td><td><table border="0"><tr><td>'.$array[0].'</td></tr><tr><td>'.$array[11].'</td></tr></table></td></tr></table>';

/////////Traemos ultimo dato de dispositivos ODOMETRO PRIMERO
$datos_dispo = $this->modelo_mv_usuarios->datosUsrDispo($cuentaId,$IDFULL);
if($datos_dispo==0)//No hay dato en Dispositivos puede que no exista? tomar accion
{
$odome='No existen datos de Localizacion para tu Usuario<p>';
}
if($datos_dispo!=0)//Si hay dato en Dispositivos
{
  foreach($datos_dispo as $dDispon)
      {//$ufecha = impode (",", $datos['fechaEjecucion']) 
        if ($dDispon['UltimoOdometroKm']!='') 
        {
          $odome='Odometro: <b>'.round($dDispon['UltimoOdometroKm']).' Km</b>';
        }
        if ($dDispon['UltimoOdometroKm']=='') 
        {
          $odome='Dispositivo Android Sin Recorrido';
        }
      }//
}
//////////
$DatabUsr='<table border="0"><tr><td>'.$array[2].'</td></tr><tr><td>Correo: '.$array[3].'</td></tr><tr><td>Telefono: '.$array[10].'</td></tr><tr><td>'.$odome.'</td></tr></table>';


           //anchor('maneja_cuentas/cuentas_editar','Ver/Editar');
           $this->table->add_row($selec, $ADMOPER, $tablaUsr,$DatabUsr,$UsuarioActivo,$tablaFechas);
            }
            //Crear cabezera perzonalizada
            $header = array('seleccione','Nivel','Usuario','Nombre de usuario','Activo | Localizable','Fechas');
            //Establece los títulos 
            $this->table->set_heading($header);
            //formato de tabla 
            $tmpl = array (
                    'table_open'          => '<table border="1" cellpadding="1" cellspacing="0" width="100%">',

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

                    'table_close'         => '</table>'
              );

            $this->table->set_template($tmpl);
            //Cargar los resultados 
             $this->load->helper('form');
        $this->load->library('form_validation');


  if ($this->session->userdata('Visual')=='Monitoreo3') 
{
      $this->load->view('templates/cabecera');
      $this->load->view('templates/menu');
      $this->load->view('vista_mv/adminUsuario');
      $this->load->view('templates/pie');
} 
if ($this->session->userdata('Visual')=='Monitoreo2') 
{
  $cuentaId= $this->session->userdata('cuenta');
    $listaGps = $this->modelo_mv_mapa->lista_gps($cuentaId);
    $data['gps'] = $listaGps;
    //Lista de variables que se usaran para las consultas
    $nombreGps='';//Nombre del gps
    $cuentaId_dispositivo=""; //La cuenta de a quien pertenece el gps
        date_default_timezone_set("Mexico/General");
      $fecha_ini = date('d/m/Y') . ' 00:00';//25200 son lo segundos que tienen 7 horas ya que mexico esta en -7
    //$fecha_fin = date('d/m/Y H:i');
    $fecha_fin = date('d/m/Y') . ' 23:59';
    
      //entro aqui por que viene de select o del boton actualizar
    if($this->input->post('nombreGpsOpcion')!=0){
      $bandera_post = $this->input->post('nombreGpsOpcion');
      if($bandera_post){
        //Si entro aqui es que hay datos que se enviaron con post
        $cuenta_nombre = $this->input->post('nombreGpsOpcion'); // Nombre y cuenta del dispositivo
        list( $nombre_g, $cuenta_g) = explode('*', $cuenta_nombre);
        $nombreGps = $nombre_g;
        $cuentaId_dispositivo = $cuenta_g;
        $data_m = array(
          'nombreGps' => $nombreGps,
                    'cuentaId_dispositivo' => $cuentaId_dispositivo ,
                    'fecha_ini' => $fecha_ini,
          'fecha_fin' => $fecha_fin
                    );        
          //Guardamos los datos en la sesion para recuperarlo en caso necesario
                    $this->session->set_userdata($data_m);
      }else{
        //NO se han enviado datos en el post aunque si viene del select o el boton actualizar
        $nombreGps = $this->session->userdata('nombreGps');
        $cuentaId_dispositivo = $this->session->userdata('cuentaId_dispositivo'); 
        $fecha_ini = $this->session->userdata('fecha_ini');
        $fecha_fin = $this->session->userdata('fecha_fin');
      }   
    }else{
      //Solo entrara aqui la primera vez que se carga la pagina y solo esa vez
      if($listaGps!=0){
        // Si existe por lo menos un dispositivo se obtiene el primero de la lista para iniciar todo      
        $primero = $listaGps[0];
        $nombreGps = $primero['dispositivoID'];
        $cuentaId_dispositivo = $primero['cuentaID'];
      }
    }

    $data['nomGps'] = $nombreGps;
    $data['fechaInicial'] = $fecha_ini;
    $data['fechaFinal'] = $fecha_fin;
    //Vamos a empezar a traer los datos
    
    $fecha_formato_ini = $this->mv_utilerias->fecha_datatime($fecha_ini, '00');
    $fecha_formato_fin = $this->mv_utilerias->fecha_datatime($fecha_fin, '59');
    $datosGps = $this->modelo_mv_mapa->datosEvento($cuentaId_dispositivo,$nombreGps, $fecha_formato_ini, $fecha_formato_fin);   
    $data['datosGps']=$datosGps;
    
    $actualiza = $this->input->post('controlAuto');
    $data['controlAuto']=$actualiza;
    //$data['controlAuto']='1';
      $this->load->view('templates/cabecera2');
      $this->load->view('templates/menu2', $data);
      $this->load->view('vista_mv/adminUsuario');
      $this->load->view('templates/pie2');
  //echo "2";
  
}
if ($this->session->userdata('Visual')=='Monitoreo1') 
{
      $this->load->view('templates/cabecera');
      $this->load->view('templates/menu');
      $this->load->view('vista_mv/adminUsuario');
      $this->load->view('templates/pie');
}
if ($this->session->userdata('Visual')=='') 

{
      $this->load->view('templates/cabecera');
      $this->load->view('templates/menu');
      $this->load->view('vista_mv/adminUsuario');
      $this->load->view('templates/pie');
}







	










		}
	}

    public function usuario_ver(){
       
        $tipo = $this->session->userdata('perfil');
		if(($tipo != '0' and $tipo != '1') || $this->session->userdata('perfil') === FALSE){
           		redirect(base_url().'sesion');
        	}

         $cuentaId=$this->session->userdata('cuenta');

        $datos['result'] = $this->modelo_mv_usuarios->datos_cuentaSelec($cuentaId,$this->input->post('selecUsuarioId'));

        //$data['result']=$datos

	//cargamos la librería	
		$this->load->library('ciqrcode');   ///QR

        $this->load->view('templates/cabecera');
		$this->load->view('templates/menu');
		$this->load->view('vista_mv/adminUsuariosVer',$datos);
		$this->load->view('templates/pie');	
    }
    
    public function usuario_editar(){
       
        $tipo = $this->session->userdata('perfil');
		if(($tipo != '0' and $tipo != '1') || $this->session->userdata('perfil') === FALSE){
           		redirect(base_url().'sesion');
        	}

         $cuentaId=$this->session->userdata('cuenta');

  $datos['result'] = $this->modelo_mv_usuarios->datos_cuentaSelec($cuentaId,$this->input->post('selecUsuarioId'));


  $datos['resultd'] = $this->modelo_mv_usuarios->datos_dispositivoSelec($cuentaId,$datos['result']['usuarioIDMV']);
        //$data['result']=$datos

        $this->load->view('templates/cabecera');
		$this->load->view('templates/menu');
		$this->load->view('vista_mv/adminUsuarioEditar',$datos);
		$this->load->view('templates/pie');	
    }

     public function usuario_guardar()
      {//aqui entra si editamos un usuario en adminUsuarioEditar.php
            $tipo = $this->session->userdata('perfil');
    		if(($tipo != '0' and $tipo != '1') || $this->session->userdata('perfil') === FALSE){
               		redirect(base_url().'sesion');
            	}

           $cuentaId=$this->session->userdata('cuenta');
    /////////////////////////////////////////////////////////////////////////////////////////Actualizar Usuario
            $fields = array();//enlaza directo a la bd usuarios
            $fields['esActivo'] = $this->input->post('esActiva');
            $fields['localizable'] = $this->input->post('localizable');

            //ESte if es por seguridad
            if ($this->input->post('tipoCuenta')=='1') 
            {
             $fields['tipoCuenta'] ='1';
            }
            if ($this->input->post('tipoCuenta')!='1') //Automaticamente asigna el estado 2
            {
             $fields['tipoCuenta'] ='2';
            }
            

            $fields['descripcion'] = $this->input->post('descripcion');
            $fields['contrasena'] = $this->input->post('contrasena');
            $fields['nombreContacto'] = $this->input->post('nameContacto');
            $fields['telefonoContacto'] = $this->input->post('telcontacto');
            $fields['correoContacto'] = $this->input->post('emailContacto');
            $fields['notificarCorreo'] = $this->input->post('emailNotificaiones');
            $fields['rfc'] = $this->input->post('rfc');
            $fields['curp'] = $this->input->post('curp');
            $fields['tipoMapa'] = $this->input->post('tipoMapa');
            $fields['calendario'] = $this->input->post('calendario');

$fields['sexo'] = $this->input->post('sexo');
$fields['calle'] = $this->input->post('calle');
$fields['direccion'] = $this->input->post('direccion');


//Datos Medicos
//

$fields['tsangre'] = $this->input->post('tsangre');
$fields['factorh'] = $this->input->post('factorh');
$fields['estatura'] = $this->input->post('estatura');
$fields['peso'] = $this->input->post('peso');
$fields['descripcionee'] = $this->input->post('descripcionee');
$fields['descripcioneea'] = $this->input->post('descripcioneea');
$fields['aseguradora'] = $this->input->post('aseguradora');
$fields['npoliza'] = $this->input->post('npoliza');
$fields['afiliacion'] = $this->input->post('afiliacion');
$fields['nombremCuest'] = $this->input->post('nombremCuest');
$fields['apellidomPCuest'] = $this->input->post('apellidomPCuest');
$fields['apellidomMCuest'] = $this->input->post('apellidomMCuest');

        ///Datos medicos fin
///Cemergencia 
$fields['relacion1'] = $this->input->post('relacion1');
$fields['relacion2'] = $this->input->post('relacion2');
$fields['cemergencia1'] = $this->input->post('cemergencia1');
$fields['cemergencia2'] = $this->input->post('cemergencia2');
$fields['temergencia1'] = $this->input->post('temergencia1');
$fields['temergencia2'] = $this->input->post('temergencia2');
$fields['corremergencia1'] = $this->input->post('corremergencia1');
$fields['corremergencia2'] = $this->input->post('corremergencia2');
///Cemergencia

///////Media Filiación
$fields['complex'] = $this->input->post('complex');
$fields['cabeza'] = $this->input->post('cabeza');
$fields['frente'] = $this->input->post('frente');
$fields['eeestatura'] = $this->input->post('eeestatura');
$fields['ccabello'] = $this->input->post('ccabello');
$fields['tcabello'] = $this->input->post('tcabello');
$fields['ojos'] = $this->input->post('ojos');
$fields['cejas'] = $this->input->post('cejas');
$fields['fcara'] = $this->input->post('fcara');
$fields['orejas'] = $this->input->post('orejas');
$fields['nariz'] = $this->input->post('nariz');
$fields['boca'] = $this->input->post('boca');
$fields['labios'] = $this->input->post('labios');
$fields['dientes'] = $this->input->post('dientes');
$fields['menton'] = $this->input->post('menton');
$fields['bigote'] = $this->input->post('bigote');
$fields['cicatrices'] = $this->input->post('cicatrices');
$fields['omarcas'] = $this->input->post('omarcas');
///Media Filiación  



            $fields['ipv4']=$_SERVER['REMOTE_ADDR'];//maneja el guardado de la ip
            $fields['LigaUltima']=$_SERVER['HTTP_REFERER'];//direccion completa de este archivo.
            $time=time();
            $fields['ultimaFechaActualizacion']=date("Y-m-d (H:i:s)",$time);
    ////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////Actualizar dispositivo Usuario
            $fieldisp = array();//enlaza directo a la bd dispositivos
            $fieldisp['esActiva'] = $this->input->post('localizable');
            $fieldisp['mostrarNombre'] = $this->input->post('nameContacto');
            $fieldisp['notificacionRec'] = $this->input->post('Reporte1').','.$this->input->post('Reporte2');
            if ($this->input->post('rep1')==1)
             {
             $fieldisp['notifiCorreo'] = $this->input->post('rep1');
            }
            if ($this->input->post('Reporte1')!=0) 
            {
             $fieldisp['notifiCorreo'] = $this->input->post('rep1');
            }
            if ($this->input->post('Reporte1')==0) 
            {
             $fieldisp['notifiCorreo'] = 0;
            }
            
    ///////////////////////////////////////////////////////////////////////////////////////////

////////////////////Subir imagen de perfil//////////////////////////////////////////////////////////////////
                         $config['upload_path']   = 'data/usr/'; 
                         $config['allowed_types'] = 'gif|jpg|png'; 
                         $config['max_size']      = 300;//KB 
                         //$config['max_width']     = 1024; 
                         //$config['max_height']    = 768;  
                         $config['encrypt_name'] = TRUE; 
                         $this->load->library('upload', $config);

                        if (!$this->upload->do_upload('userfile'))
                         {
                            $error = array('error' => $this->upload->display_errors()); 
                         }
                                        
                         else //no hay  problemas con la imagen y procede a subirla, ejecuta una imagen miniatura
                         { 
                            $data = array('upload_data' => $this->upload->data());
                            $upload_data = $this->upload->data();
                            $fullPath = base_url() .'data/usr/'. $upload_data['file_name'];
                            $nomSAVE = $upload_data['file_name'];//Guardamos los nombres que regresa al subir
                            //$fields['ImgPerfil']= $nomSAVE;//direccion corta de la imagen
                            $fields['logoPerfil']= $fullPath;//direccion completa de la imagen
                            //echo $fullPath;
                         } 
        
////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////Elimina img /////////////////////////////////////////////////////
if ($this->input->post('imgEliminar')!='') 
{
  //$fields['ImgPerfil']= '';//
  $fields['logoPerfil']= '';//Le dice a bd que se va a eliminar 
  /////////Procedemos a eliminar la foto tomando como referencia el nombre.///////
  $file_name=$this->input->post('imgEliminar');
  $proveniente='usr';
  $this->load->model('modelos_mv/modelo_mv_imgdelet');
  $this->modelo_mv_imgdelet->insertar_imgdelet($this->session->userdata('cuenta'),$this->session->userdata('usuario'),$file_name,$proveniente);
  //pero lo guardaremos en alguna tabla de imagenes Delete.
  ///////////////////////////////////////////////////////////////////////////////
}

            ///////////////////////////////////////////////////////////////////
            $cIDMV=$this->input->post('usuarioIDM');//si no cumple con el IDMV salta a redireccion
              if ($cIDMV!=0)//para evitar el ataque por get 
                {
                   $this->modelo_mv_usuarios->update_usuarios($cuentaId,$cIDMV,$fields);
                   $this->modelo_mv_usuarios->update_usuarios_dispo($cuentaId,$cIDMV,$fieldisp);
                }
            redirect(base_url().'mostrarUsuarios');

            $datos['result'] = $fields;

            $this->load->view('templates/cabecera');
    		$this->load->view('templates/menu');
    		$this->load->view('vista_mv/adminUsuarioEditar',$datos);
    		$this->load->view('templates/pie');	
    }
///////////////////////////////////////////////////////////////////////////////////////////////////////*
		     public function usuario_crear()
		     {
				$tipo = $this->session->userdata('perfil');
				if(($tipo != '0' and $tipo != '1') || $this->session->userdata('perfil') === FALSE){
		           		redirect(base_url().'sesion');
		        	}

		          $this->load->helper('form');
		          $this->load->helper('url');

		        $this->load->library('form_validation');
		        $cuentaId=$this->session->userdata('cuenta');

		        $nombreLLegada=$this->input->post('newUsuarioID');
		 $vowels = array(" ", "-", "_", ".", "<", ">", "(", ")", "?", "!", "'", "¿");
		        $usuarioCorta = str_replace($vowels, "", $nombreLLegada);
		     $newUsuarioID=$usuarioCorta;
		  //      $idCuenta=$this->modelo_mv_usuarios->id_cuenta($cuentaId);
		        //aqui debe llegar por post el numero de cliente y la cantidad posible.  
		     //echo $this->session->userdata('IDMV');//IDMV id MV del cliente
		       $cliente=$this->session->userdata('IDMV');//IDMV id MV del cliente
		       $client = str_pad($cliente, 5, '0', STR_PAD_LEFT);
			 $datos_cuentas = $this->modelo_mv_usuarios->datos_usuarios($cuentaId);
		       foreach($datos_cuentas as $index => $row) 
		       {
		       	$array = array_values($row);
		       	$ultimo=$array[2];//le faltaria agregar
		       }
		//importar cientes para descartar y asignar uno no asgnado
		        $usuarioIDMV='90w000'.$client.$ultimo;//falta el usuario, a ultimo le faltan los ceros como al client
		       // $usuarioIDMV=$idCuenta;
		        $datos = $this->modelo_mv_usuarios->datos_cuentaSelec($cuentaId,$newUsuarioID);
		        if($datos == 0)
		        {
		            $this->modelo_mv_usuarios->insertar_usuario($cuentaId,$newUsuarioID,$usuarioIDMV);
		            //insertar tambien en dispositivos.
		            $this->modelo_mv_dispositivos->insertar_dispoWEB($cuentaId,$newUsuarioID);
		            
		             redirect(base_url().'mostrarUsuarios','refresh');
		        }else{
		            $error['errorCrear'] = 'Error ya existe un usuario con ese identificador';
		            redirect(base_url().'mostrarUsuarios','location');
		        }
				
			}
////////////////////////////////////////////////////////// Falta que tambien borre en dispositivos por lo que hay que cambiar en lugar del nombre(usuarioID) use IDMV
    public function borra_usuario(){
		$tipo = $this->session->userdata('perfil');
		if(($tipo != '0' and $tipo != '1') || $this->session->userdata('perfil') === FALSE){
           		redirect(base_url().'sesion');
        	}

        $cuentaId=$this->session->userdata('cuenta');
		$usuarioId = $this->input->post('selecUsuarioId');
          if ($usuarioId=='admin') 
                        {
                          redirect(base_url().'mostrarUsuarios');
                        }
          if ($usuarioId!='admin') 
                        {
                          $this->modelo_mv_usuarios->borrar_usuarios($cuentaId,$usuarioId);
                          $this->modelo_mv_dispositivos->borrar_dispoWEB($cuentaId,$usuarioId);

                          redirect(base_url().'mostrarUsuarios');
                        }
		
		
	}
}