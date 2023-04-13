<?php //considerar que fue copiado de maneja vehiculos y que aun no se cambian todas las variables

class Maneja_logistica_archivo extends CI_Controller 
{
	public function __construct()
    {
	   parent::__construct();
        $this->load->database(); // bd
        $this->load->model('modelos_mv/modelo_mv_logistica_crear'); //carga el modelo para bd
   }
	 public function nuevo($primer=FALSE)
{//solucion al error de cuando no llega info falta el true abajo, checar rutas
    $tipo = $this->session->userdata('perfil');
    if(($tipo != '0' and $tipo != '1' and $tipo != '2' and $tipo != '3' and $tipo != '4') || $this->session->userdata('perfil') === FALSE){
           redirect(base_url().'sesion');
        }
  
    $cuentaId= $this->session->userdata('cuenta');
    //$tipoEquipo='Movil-web';
    $listaGps = $this->modelo_mv_logistica_crear->lista_gps($cuentaId);
    $data['gps'] = $listaGps;


    //$listaGrupos = $this->modelo_mv_grupos->gruposSelec($cuentaId);
    //$data['grupo'] = $listaGrupos;


    //Lista de variables que se usaran para las consultas
    $nombreGps='';//Nombre del gps
    $cuentaId_dispositivo=""; //La cuenta de a quien pertenece el gps
        date_default_timezone_set("Mexico/General");
      $fecha_ini = date('d/m/Y') . ' 00:00';//25200 son lo segundos que tienen 7 horas ya que mexico esta en -7
    $fecha_fin = date('d/m/Y H:i');
    //$fecha_fin = date('d/m/Y') . ' 23:59';
    
    if($primer){
      //entro aqui por que viene de select o del boton actualizar
      $bandera_post = $this->input->post('nombreGpsOpcion');
      if($bandera_post){
        //Si entro aqui es que hay datos que se enviaron con post
        $cuenta_nombre = $this->input->post('nombreGpsOpcion'); // Nombre y cuenta del dispositivo
        list( $nombre_g, $cuenta_g) = explode('*', $cuenta_nombre);
        $nombreGps = $nombre_g;
        $cuentaId_dispositivo = $cuenta_g; 
        $fecha_ini = $this->input->post('fechaDeH');
        $fecha_fin = $this->input->post('fechaHastaH');
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
      if($listaGps!=0){//tambien se pueden filtrar los grupos
        // Si existe por lo menos un dispositivo se obtiene el primero de la lista para iniciar todo  
        //filtrar aqui tambien que el primero para importar debe ser un disp Android si no no importar  
        $primero = $listaGps[0];//es un Array


            sort($listaGps);
            $contauno=1;//el primer dato antes de cargar
            foreach ($listaGps as $nombreEnListaGps)// despues de este for comparar lo que se dijo antes en el comentario.
              {//se filtra en ambos lados ... aqui tambien se filtra la segunda vez despues de pasar por el controlador
                  
                if ($nombreEnListaGps['tipoEquipo']=='Movil-web' && $contauno==1) 
                {
                  $nombreGps = $nombreEnListaGps['dispositivoID'];
                  $cuentaId_dispositivo = $nombreEnListaGps["cuentaID"];
                $contauno=2;
                }//fin if muestra solo movil-web

              }//fin del forech 
        
      }//fin compara si existe algun dato en esa cuenta
    }

    $data['nomGps'] = $nombreGps;//esta bien, el filtro es arriba
    $data['fechaInicial'] = $fecha_ini;
    $data['fechaFinal'] = $fecha_fin;
    
    //Vamos a empezar a traer los datos
    
    $fecha_formato_ini = $this->mv_utilerias->fecha_datatime($fecha_ini, '00');
    $fecha_formato_fin = $this->mv_utilerias->fecha_datatime($fecha_fin, '59');
    $datosGps = $this->modelo_mv_logistica_crear->datosLog($cuentaId_dispositivo,$nombreGps, $fecha_formato_ini, $fecha_formato_fin);    
    $data['datosGps']=$datosGps;
    
    $actualiza = $this->input->post('controlAuto');
    $data['controlAuto']=$actualiza;
    
    $this->load->view('templates/cabecera');
    if($tipo != '4'){
      $this->load->view('templates/menu');
    }
    //$this->load->view('templates/calendario', $data_f);
    $this->load->view('vista_mv/adminLogisticaArchivo', $data);
    $this->load->view('templates/pie');
  }

}
// $this->load->view('vista_mv/adminLogisticaArchivo', $data);