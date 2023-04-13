<?php
class Modelo_mv_logistica_status extends CI_Model{

	public function __construct()
	{
		$this->load->database();
	}



    public function pasign($cuentaId, $dispositivoID){
		$this->db->select('mostrarNombre');
		$this->db->from('dispositivos');
        $this->db->where('cuentaID', $cuentaId);
        $this->db->where('dispositivoID', $dispositivoID);
		$pregunta = $this->db->get();
		
		if($pregunta->num_rows()==1){
			return $pregunta->row_array();
		}else{
            return 0;
        }
	}




	public function compara_personal($cuentaId){//Relacion Personal Vehiculo
		$perfil = $this->session->userdata('perfil');
		
		$this->db->select('logisticaID, personalID, cuentaID, nombreMostrar');	//mostrarNombre, grupoID va directo a mapas
		$this->db->from('logistica');
		$this->db->where('cuentaID', $cuentaId);
		$this->db->where('esActivo', 1);
		$pregunta = $this->db->get();
		if($pregunta->num_rows() > 0){
			return $pregunta->result_array();
		}else{
		 	return 0;
		}
	}


	
	public function lista_logistica($cuentaId){//Lista de los id de logistica
		$perfil = $this->session->userdata('perfil');//estado 4//p10b=23//{34}-p10c Ultimo
		//									//		//useragent 35
											// p1-36 hasta p10-45
		$this->db->select('logisticaID, personalID, cuentaID, nombreMostrar,Estado, p1nota, p2nota, p3nota, p4nota, p5nota, p6nota, p7nota, p8nota, p9nota, p10nota, p1b, p2b, p3b, p4b, p5b, p6b, p7b, p8b, p9b, p10b, p1c, p2c, p3c, p4c, p5c, p6c, p7c, p8c, p9c, p10c, useragent, p1, p2, p3, p4, p5, p6, p7, p8, p9, p10');	//mostrarNombre, grupoID va directo a mapas
		$this->db->from('logistica');
		if($perfil === '1'){
			$this->db->where('cuentaID', $cuentaId);
		}
		if($perfil==='2'){
			//Restringido quizas por el conductorID y no cuentaID
			$this->db->where('cuentaID', $cuentaId);
		}
		$this->db->where('esActivo', 1);
		$pregunta = $this->db->get();
		if($pregunta->num_rows() > 0){
			return $pregunta->result_array();
		}else{
		 	return 0;
		}
	}
	
	public function datosEvento($cuentaId, $dispositivoId, $fecha_ini, $fecha_fin){
		$this->db->select('latitud, longitud, velocidadKPH, CodigoDeEstado, direccion, fechaEjecucion, bateria, odometroKM');
		$this->db->from('datosEventos');
		$this->db->where('cuentaID', $cuentaId);
		$this->db->where('dispositivoID', $dispositivoId);
		$rango_fechas = array('fechaCreacion >=' => $fecha_ini, 'fechaCreacion <=' => $fecha_fin);
		$this->db->where($rango_fechas);
		$this->db->order_by("fechaCreacion","asc");
		//$this->db->limit(50);
		$pregunta = $this->db->get();
	 	if($pregunta->num_rows() > 0){
			return $pregunta->result_array();
		}else{
		 	return 0;
		}
	}
	
}