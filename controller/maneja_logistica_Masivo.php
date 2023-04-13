<?php

class Maneja_logistica_Masivo extends CI_Controller {

  public function __construct(){
    parent::__construct();
    $this->load->model('modelos_mv/modelo_mv_logistica');//
    $this->load->model('modelos_mv/modelo_mv_logistica_crear');//modelo_mv_logistica_crear
    $this->load->model('modelos_mv/modelo_mv_dispositivos');
    $this->load->library('table');
  }

    


  public function muestra_logistica(){
    $tipo = $this->session->userdata('perfil');
    if(($tipo != '0' and $tipo != '1') || $this->session->userdata('perfil') === FALSE){
              redirect(base_url().'sesion');
          }
          $data['title'] = 'Monitoreo Vehicular';
         $cuentaId=$this->session->userdata('cuenta');
/////////////////////////////////////////////////////////////////////////////////////////Crea nuevo form
if ($this->input->post('crearid')!='') //la finta por que este id se genera aqui.pero .... tambien ver la posibilidad de quitar el id del formulario inicial o de la vista ,,, ya que se ve poco practico.... pero primero importar el ID igual que el de registro .... traer el codigo muy parecido a registro.... evitar el ciclado para descartar ......... de este codigo para abajo.
{
  $datosDispositivos = $this->modelo_mv_logistica->listaidlog($cuentaId);
            //$data['datosDispositivos']=$datos_Dispositivos;//datosDispositivos
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

  if ($datosDispositivos!='') 
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
                {//Trae el ultimo dato de ID en logistica y le suma 1 para crear el nuevo ID.
                 $rs = mysql_query("SELECT MAX(contador) AS id FROM logistica");
                        if ($row = mysql_fetch_row($rs)) 
                        {
                        $id = trim($row[0]);
                        $id=$id+1;
                        $imprimePos=generaCeros($id);
                        //echo $id;
                        }            //$this->load->view('templates/menu');
                      
                //$imprimePos=generaCeros($conta);
                }//Fin compara si tiene dispositivos, ocea diferente de cero.
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
                                  $genid="1L".generaCuenta($ncuenta).$imprimePos;
                                  if ($this->input->post('crearid')==$genid) 
                                  {
                                    $vowels = array(" ", "-", "_", ".", "<", ">", "(", ")", "?", "!", "'", "¿");
                                    $nombreUs = str_replace($vowels, "", $this->input->post('nomcuest')); //Nombre del Formulario
                                    $foli = str_replace($vowels, "", $this->input->post('folio'));//Folio Empresa     
                                     $nivel=2;
                                  $this->modelo_mv_logistica_crear->insertar_usuario($cuentaId,$genid,$nombreUs,$nivel,$foli);
                                  redirect(base_url().'mostrarLogistica');
                                  }
                                  else
                                  {
                                    redirect(base_url().'mostrarLogistica');
                                  }
                 
}


//////////////////////////////////////////////////////////fin crea formulario
    

   $datos_cuentas = $this->modelo_mv_logistica->datos_usuarios($cuentaId);
        if($datos_cuentas==0){
      $this->load->view('templates/cabecera');
      $this->load->view('templates/menu');
      $this->load->view('vista_mv/adminLogistica');
      $this->load->view('templates/pie'); 
    }else{// $data['datosCuentas']=$datos_cuentas;
           
$estado='Error Estado';
foreach($datos_cuentas as $index => $row) 
{ //set your rows here
  $array = array_values($row);
  if ($array[20]=='0') {//Archivo 
    # code...
  
  $selecUsuarioId = $array[0];
  $idlog=$array[1];
            if(strlen($array[1])==15)//Si cumple con el num de ID 
                    {
                        $IDlog=$array[1];
                        $array[1] = substr($array[1], -4);//quita los primeros 5 caracteres de ID
                    }


                
                       $selec = '<label><input type="radio" name="selecUsuarioId" value='. $selecUsuarioId .' checked>'.$array[1].'</label>';
                            //agregar boton borrar
            

                  if(($array[4]==1))//activo
                    {
                      if ($array[7]==1) //si hay rastreo ..depende el mapa
                        {
                          $celVerde='rastreo.png';//Globito localiza activado
                          if ($array[12]=='0' || $array[13]=='0' || $array[12]=='' || $array[13]=='') 
                            {//Comprueba que las coordenadas sean validas si no lo son no muestra el mapa
                              $transcurso='';
                            }
                            else
                            {//muestra el mapa para ubica
                              //

                              $transcurso='<a href="https://www.google.com.mx/maps/search/'.$array[12].'%20'.$array[13].'" target="_blank"><img src="images/sistema/mapa32.png" width="26" height="26" alt="Mapa"></a>';
                            }
                        }
                      if ($array[7]==0) 
                        {
                          $celVerde='rastreoRed.png';
                          $transcurso='';//para no mostrar el mapa si no hay rastreo
                        }
                      if ($array[8]=='0') 
                      {$estado='abierto.png';}
                      if ($array[8]=='1') 
                      {$estado='pendiente.png';}
                  	  if ($array[8]=='2') 
                      {$estado='pendiente.png';}
                      if ($array[8]=='3') 
                      {$estado='cerrado.png';}

                      $archivar='';
                      if ($array[8]=='3') 
                      {//idlog 10L00012012  ... deberia mandarse tambien el nombre por si se quiere preguntar de confirmar el archivo

                        $liga="'archivar?id=".$idlog."'";

                        $archivar='<input style="border: #98141b 2px solid; color: #fff; background-color: #cd1920" type="button" value="Archivar" onclick="location.href='.$liga.'"/>';//
                      }

                        $UsuarioActivo = $archivar.'<IMG SRC="images/'.$estado.'" width="25" height="25" ALT="Encendido"><IMG SRC="images/MotorVerde.png" width="25" height="25" ALT="Encendido"><IMG SRC="images/'.$celVerde.'" width="25" height="25" ALT="Encendido">'.$transcurso.'';
                    }
                  if(($array[4]==0))//No activo
                    {
                      if ($array[7]==1) 
                      {$celVerde='rastreo.png';}
                      if ($array[7]==0) 
                      {$celVerde='rastreoRed.png';}
                      if ($array[8]=='0') 
                      {$estado='abierto.png';}
                      if ($array[8]=='1') 
                      {$estado='pendiente.png';}
                      if ($array[8]=='3') 
                      {$estado='cerrado.png';}

                        $UsuarioActivo = '<IMG SRC="images/'.$estado.'" width="25" height="25" ALT="Encendido"><IMG SRC="images/MotorRojo.png" width="25" height="25" ALT="Apagado"><IMG SRC="images/'.$celVerde.'" width="25" height="25" ALT="Encendido">';
                    }      
                          //$fechaFormat= date("d-m-Y (H)", $array[6]);
                          //$date = date_create($array[6]); 
                          //$fechaFormat=date_format($date, 'Y-m-d');
                    $tablaFechas='<table border="0"><tr><td>Creaci&oacute;n</td><td>'.$array[6].'</td></tr><tr><td>Actualizaci&oacute;n</td><td>'.$array[5].'</td></tr><tr><td>Liquidaci&oacute;n</td><td>'.$array[15].'</td></tr></table>';
                    
                    //
                    $tablaDireccion='<table border="0">
                            <tr><td>'.$array[9].'</td></tr>
                            <tr><td>'.$array[10].' '.$array[11].'</td></tr></table>';
                    if ($array[18]=='') //Folio empresa sin asignar ;empresa Cliente
                    {
                      $tablaFolio='<table border="0">
                            <tr><td>'.$IDlog.'</td></tr> 
                            </table>';
                    }
                    else
                    {
                      $tablaFolio='<table border="0">
                            <tr><td>Recomendado<br>'.$IDlog.'</td></tr> 
                            <tr><td>Empresa<br>'.$array[18].'</td></tr>
                            <tr><td>Corporativo<br>'.$array[21].'</td></tr>
                            </table>';
                    }

//////////////////////////////////////////////////////////
$cuentaId=$this->session->userdata('cuenta');
$act='1';//El dispositivo se encuentra acivo
$da=$this->modelo_mv_logistica->nom_cuest($cuentaId,$act,$array[23]);//23 es el id del generador CCcuestionario
$NombreGen=$da['nombreCuest'];//
////////////////////////////////////////////////////////////
$cuentaId=$this->session->userdata('cuenta');
$activia='1';//El dispositivo se encuentra acivo
$NomP=$this->modelo_mv_logistica->nom_Personal($cuentaId,$activia,$array[22]);//23 es el id del generador 
$NombrePersonal=$NomP['mostrarNombre'];//
////////////
$NomPC=$this->modelo_mv_logistica->nom_PCersonal($cuentaId,$activia,$array[24]);//23 es el id del generador 
$NombreCliente=$NomPC['nombreCuest'];//
                  
//////////////////////////////////////////////////////////
                    $tablaCliente='<table border="0"><tr><td><!--Rastreo Activado--></td><td>'.$NombreCliente.'</td></tr><tr><td>Nombre</td><td>'.$array[2].'</td></tr><tr><td>Correo</td><td>'.$array[3].'</td></tr><tr><td>Visita</td><td>'.$array[17].' '.$array[16].'</td></tr></table>';
                    //
                      $tablaCuestionario='<table border="0">
                            <tr><td>Nombre</td><td>'.$array[0].'</td></tr>
                            <tr><td>Rastreo</td><td><a href="rastreo?id='.$IDlog.'&pass='.$array[19].'&" target="_blank">'.$array[19].'</a></td></tr>
                            <tr><td>Personal</td><td>'.$NombrePersonal.'</td></tr>
                            <tr>
                              <td>Generador '.$NombreGen.'</td><td>
                            
                              </td>
                            </tr>

                            </table>';
                    //<input style="border: #98141b 2px solid; color: #fff; background-color: #cd1920" type="button" value="Archivar" onclick="location.href='.$liga.'"/>

           //anchor('maneja_cuentas/cuentas_editar','Ver/Editar');
           $this->table->add_row($selec, $tablaFolio,$tablaCuestionario,$tablaCliente,$tablaDireccion,$UsuarioActivo,$tablaFechas,$array[14]);//8
}//fin archivo
}//fin del for
            //Crear cabezera perzonalizada
            $header = array('seleccione','Folios','Datos de Cuestionario','Datos del Cliente','Direccion del Cliente','Estado | Activo | GPS','Fechas y Horas','Descripcion');
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

            $datos_Dispositivos = $this->modelo_mv_logistica->listaidlog($cuentaId);
            if ($datos_Dispositivos=='') 
            {
              $data['datosDispositivos']=[0];//datosDispositivos esta parte es para arreglar el primer dispo
            }
            if ($datos_Dispositivos!='') 
            {
             $data['datosDispositivos']=$datos_Dispositivos;//datosDispositivos
            }
            
            //Cargar los resultados 
      $this->load->helper('form');
      $this->load->library('form_validation');
      $this->load->view('templates/cabecera');
      $this->load->view('templates/menu');
      $this->load->view('vista_mv/adminLogistica', $data);
      $this->load->view('templates/pie'); 
    }
  }

    public function logistica_ver(){
       
        $tipo = $this->session->userdata('perfil');
    if(($tipo != '0' and $tipo != '1') || $this->session->userdata('perfil') === FALSE){
              redirect(base_url().'sesion');
          }

         $cuentaId=$this->session->userdata('cuenta');

        $datos['result'] = $this->modelo_mv_logistica->datos_cuentaSelec($cuentaId,$this->input->post('selecUsuarioId'));

        //$data['result']=$datos

  //cargamos la librería  
    $this->load->library('ciqrcode');   ///QR

        $this->load->view('templates/cabecera');
    $this->load->view('templates/menu');
    $this->load->view('vista_mv/adminLogisticaVer',$datos);
    $this->load->view('templates/pie'); 
    }
    

    public function archivar()
    {//apagar Relevador Encender Vehiculo
      $tipo = $this->session->userdata('perfil');
      if(($tipo != '0' and $tipo != '1') || $this->session->userdata('perfil') === FALSE)
      {redirect(base_url().'sesion');}
      $cuentaId=$this->session->userdata('cuenta');
      $idFormulario = $this->input->get('id');
//Para archivar es necesario ponerlo como no activo en la tabla de logistica, pero tambien es eliminarlo de la parte de dispositivos, o ponerlo como no disponible.
      $orden= array();
      $orden['archivo'] = '1';//
      $orden['esActivo']= '0';
      $this->modelo_mv_logistica->update_archivo($cuentaId,$idFormulario,$orden); 
//echo $nombreFormulario;
// dormir durante 10 segundos
//en el caso de querer mostrar un mensaje de ARchivado en una nueva plantilla para despues redireccionar
//sleep(10);
//mandar el comando de archivar 
      
      redirect(base_url().'mostrarLogistica');
    }





    public function logistica_editar(){
       
        $tipo = $this->session->userdata('perfil');
    if(($tipo != '0' and $tipo != '1') || $this->session->userdata('perfil') === FALSE){
              redirect(base_url().'sesion');
          }

         $cuentaId=$this->session->userdata('cuenta');

        $datos['result'] = $this->modelo_mv_logistica->datos_cuentaSelec($cuentaId,$this->input->post('selecUsuarioId'));
        $tipoEquipo='Movil-web';//Carga los dispositivos usuarios y conductores
        $ok='1';//El dispositivo se encuentra acivo
        $datos['dis'] = $this->modelo_mv_logistica->disp_activoUSRcon($cuentaId,$tipoEquipo,$ok);
        $datos['client'] = $this->modelo_mv_logistica->disp_activoUSRCcon($cuentaId,$ok);
        $datos['gen'] = $this->modelo_mv_logistica->gen_USRcon($cuentaId,$ok);

        //$data['result']=$datos

        $this->load->view('templates/cabecera');
    $this->load->view('templates/menu');
    $this->load->view('vista_mv/adminLogisticaEditar',$datos);
    $this->load->view('templates/pie'); 
    }

     public function logistica_guardar()
      {//aqui entra si editamos un usuario en adminUsuarioEditar.php
            $tipo = $this->session->userdata('perfil');
        if(($tipo != '0' and $tipo != '1') || $this->session->userdata('perfil') === FALSE){
                  redirect(base_url().'sesion');
              }

           $cuentaId=$this->session->userdata('cuenta');
    /////////////////////////////////////////////////////////////////////////////////////////Actualizar Usuario
           function generaPass()
           {
            $cadena = "ABCDEFGHJKLMNPQRSTUVWXYZabcdefghkmnpqrstuxy23456789";
            $longitudCadena=strlen($cadena);
            $pass = "";
            $longitudPass=10;
            for($i=1 ; $i<=$longitudPass ; $i++){
                $pos=rand(0,$longitudCadena-1);
                $pass .= substr($cadena,$pos,1);
            }
            return $pass;
           }
 
     $antick = array(".", "<", ">", "(", ")", "?", "!", "'", "¿");


            $fields = array();//enlaza directo a la bd usuarios
            $fields['esActivo'] = $this->input->post('esActiva');
            $fields['localizable'] = $this->input->post('localizable');
            $fields['descripcion'] = str_replace($antick, "", $this->input->post('descripcion'));
            $fields['notas'] = str_replace($antick, "", $this->input->post('notas'));//visita
            $fields['tipoVisita'] = str_replace($antick, "", $this->input->post('visita'));//
            $fields['numeroVisita'] = $this->input->post('numeroVisita');//folioEmpresaID
            $fields['folioEmpresaID'] = str_replace($antick, "", $this->input->post('folioEmpresaID'));//
            $fields['folioCorporativoID'] = str_replace($antick, "", $this->input->post('folioCorporativoID'));//folioCorporativoID


            $fields['direccionCliente'] = str_replace($antick, "", $this->input->post('direccionCliente'));//
            $fields['latitud'] = $this->input->post('lat');//
            $fields['longitud'] = $this->input->post('lon');//

            if ($this->input->post('p1b')=='0') {$fields['p1b']='0';}
            if ($this->input->post('p1b')=='on'){$fields['p1b']='1';}
            if ($this->input->post('p2b')=='0') {$fields['p2b']='0';}
            if ($this->input->post('p2b')=='on'){$fields['p2b']='1';}
            if ($this->input->post('p3b')=='0') {$fields['p3b']='0';}
            if ($this->input->post('p3b')=='on'){$fields['p3b']='1';}
            if ($this->input->post('p4b')=='0') {$fields['p4b']='0';}
            if ($this->input->post('p4b')=='on'){$fields['p4b']='1';}
            if ($this->input->post('p5b')=='0') {$fields['p5b']='0';}
            if ($this->input->post('p5b')=='on'){$fields['p5b']='1';}
            if ($this->input->post('p6b')=='0') {$fields['p6b']='0';}
            if ($this->input->post('p6b')=='on'){$fields['p6b']='1';}
            if ($this->input->post('p7b')=='0') {$fields['p7b']='0';}
            if ($this->input->post('p7b')=='on'){$fields['p7b']='1';}
            if ($this->input->post('p8b')=='0') {$fields['p8b']='0';}
            if ($this->input->post('p8b')=='on'){$fields['p8b']='1';}
            if ($this->input->post('p9b')=='0') {$fields['p9b']='0';}
            if ($this->input->post('p9b')=='on'){$fields['p9b']='1';}
            if ($this->input->post('p10b')=='0') {$fields['p10b']='0';}
            if ($this->input->post('p10b')=='on'){$fields['p10b']='1';}

            //$fields['descripcion'] = $this->input->post('descripcion');
            $fecha=$this->input->post('fechaliqui');
            $hora=$this->input->post('horaliqui');
            $fields['FechaLiquida'] = date("".$fecha." (".$hora.")");
            //

            $fields['contrasenaRastreo'] = generaPass();
            $fields['generador'] = $this->input->post('generadorID');

if ($this->input->post('generadorID')=='') 
{
  ///No importa generador ... guarda las preguntas manualmente
            $fields['p1'] = str_replace($antick, "", $this->input->post('p1'));//
            $fields['p2'] = str_replace($antick, "", $this->input->post('p2'));//
            $fields['p3'] = str_replace($antick, "", $this->input->post('p3'));//
            $fields['p4'] = str_replace($antick, "", $this->input->post('p4'));//
            $fields['p5'] = str_replace($antick, "", $this->input->post('p5'));//
            $fields['p6'] = str_replace($antick, "", $this->input->post('p6'));//
            $fields['p7'] = str_replace($antick, "", $this->input->post('p7'));//
            $fields['p8'] = str_replace($antick, "", $this->input->post('p8'));//
            $fields['p9'] = str_replace($antick, "", $this->input->post('p9'));//
            $fields['p10'] = str_replace($antick, "", $this->input->post('p10'));//
}
if ($this->input->post('generadorID')!='') //Si es diferente de cero significa que se asigno algo
{# code...con el generadorID importar y asignar las preguntas p1-p10
        $cuentaId=$this->session->userdata('cuenta');
        $acivoo='1';//El dispositivo se encuentra acivo
        $dattos = $this->modelo_mv_logistica->gen_cuest($cuentaId,$acivoo,$this->input->post('generadorID'));
            $fields['p1'] = $dattos['p1'];//
            $fields['p2'] = $dattos['p2'];//
            $fields['p3'] = $dattos['p3'];//
            $fields['p4'] = $dattos['p4'];//
            $fields['p5'] = $dattos['p5'];//
            $fields['p6'] = $dattos['p6'];//
            $fields['p7'] = $dattos['p7'];//
            $fields['p8'] = $dattos['p8'];//
            $fields['p9'] = $dattos['p9'];//
            $fields['p10'] = $dattos['p10'];//
}






            $fields['nombreContactoCliente'] = $this->input->post('nameContacto');
            $fields['idContactoCliente'] = $this->input->post('nameContactoS');
            
            $fields['telefonoCliente'] = $this->input->post('telcontacto');
            $fields['correoCliente'] = $this->input->post('emailContacto');//
            $fields['personalID'] = $this->input->post('personalID');

            //$fields['notificarCorreo'] = $this->input->post('emailNotificaiones');
            //$fields['tipoMapa'] = $this->input->post('tipoMapa');
            //$fields['ipv4']=$_SERVER['REMOTE_ADDR'];//maneja el guardado de la ip
            //$fields['LigaUltima']=$_SERVER['HTTP_REFERER'];//direccion completa de este archivo.
            $time=time();
            $fields['ultimaFechaActualizacion']=date("Y-m-d (H:i:s)",$time);
    ////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////Actualizar dispositivo Usuario
            $fieldisp = array();//enlaza directo a la bd dispositivos
            $fieldisp['esActiva'] = $this->input->post('localizable');
            $fieldisp['mostrarNombre'] = $this->input->post('nameContacto');
    ///////////////////////////////////////////////////////////////////////////////////////////

////////////////////Subir imagen de perfil//////////////////////////////////////////////////////////////////
                         $config['upload_path']   = 'data/logistica/'; 
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
                            $fullPath = base_url() .'data/logistica/'. $upload_data['file_name'];
                            $nomSAVE = $upload_data['file_name'];//Guardamos los nombres que regresa al subir
                            //$fields['ImgPerfil']= $nomSAVE;//direccion corta de la imagen
                            $fields['imagenvisita']= $fullPath;//direccion completa de la imagen
                            //echo $fullPath;
                         } 
        
////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////Elimina img /////////////////////////////////////////////////////
if ($this->input->post('imgEliminar')!='') 
{
  //$fields['ImgPerfil']= '';//
  $fields['imagenvisita']= '';//Le dice a bd que se va a eliminar 
  /////////Procedemos a eliminar la foto tomando como referencia el nombre.///////
  $file_name=$this->input->post('imgEliminar');
  $proveniente='logistica';
  $this->load->model('modelos_mv/modelo_mv_imgdelet');
  $this->modelo_mv_imgdelet->insertar_imgdelet($this->session->userdata('cuenta'),$this->session->userdata('usuario'),$file_name,$proveniente);
  //pero lo guardaremos en alguna tabla de imagenes Delete.
  ///////////////////////////////////////////////////////////////////////////////
}

            ///////////////////////////////////////////////////////////////////
            $cIDMV=$this->input->post('usuarioIDM');//si no cumple con el IDMV salta a redireccion
              if ($cIDMV!=0)//para evitar el ataque por get 
                {
                   $this->modelo_mv_logistica->update_usuarios($cuentaId,$cIDMV,$fields);
                   $this->modelo_mv_logistica->update_usuarios_dispo($cuentaId,$cIDMV,$fieldisp);
                }
            redirect(base_url().'mostrarLogistica');

            $datos['result'] = $fields;

            $this->load->view('templates/cabecera');
        $this->load->view('templates/menu');
        $this->load->view('vista_mv/adminLogisticaEditar',$datos);
        $this->load->view('templates/pie'); 
    }
///////////////////////////////////////////////////////////////////////////////////////////////////////*
////////////////////////////////////////////////////////// Falta que tambien borre en dispositivos por lo que hay que cambiar en lugar del nombre(usuarioID) use IDMV
    public function borra_logistica(){
    $tipo = $this->session->userdata('perfil');
    if(($tipo != '0' and $tipo != '1') || $this->session->userdata('perfil') === FALSE){
              redirect(base_url().'sesion');
          }

        $cuentaId=$this->session->userdata('cuenta');
    $usuarioId = $this->input->post('selecUsuarioId');
          if ($usuarioId=='admin') 
                        {
                          redirect(base_url().'mostrarLogistica');
                        }
          if ($usuarioId!='admin') 
                        {
                          $this->modelo_mv_logistica->borrar_usuarios($cuentaId,$usuarioId);
                          $this->modelo_mv_dispositivos->borrar_dispoWEB($cuentaId,$usuarioId);

                          redirect(base_url().'mostrarLogistica');
                        }
    
    
  }
}