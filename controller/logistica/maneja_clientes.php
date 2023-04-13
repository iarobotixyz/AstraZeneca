<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class maneja_clientes extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('logistica/genclient_model','person');
	}

	public function index()
	{
		$tipo = $this->session->userdata('perfil');
		if(($tipo != '0' and $tipo != '1') || $this->session->userdata('perfil') === FALSE)
		{redirect(base_url().'sesion');}
		//$data['title'] = 'Monitoreo Vehicular';
        $cuentaId=$this->session->userdata('cuenta');
		$this->load->view('templates/cabecera');
		$this->load->view('templates/menu');
		//$this->load->helper('url');
		$this->load->view('logistica/genera_clientes');
		$this->load->view('templates/pie');
	}

	public function ajax_list()//lista principal
	{
		$list = $this->person->get_datatables();
		$data = array();
		$no = $_POST['start'];



		foreach ($list as $person) 
		{
			if ($person->cuentaID==$this->session->userdata('cuenta')) 
				{
					$no++;
					$row = array();
					if ($person->logoPerfil=='') 
					{
						# code...
						$row[] = '<img src="http://localizacion.monitoreovisual.com/data/usr/perfil.jpg" width="48" height="48">';
					}
					if ($person->logoPerfil!='') 
					{
						# code...
						$row[] = '<img src="'.$person->logoPerfil.'" width="48" height="48">';
					}
					
					$row[] = $no.'.- '.$person->nombreCuest.' '.$person->apaterno.' '.$person->amaterno.'<br> Activo='.$person->activo.'<br> ID='.$person->id;
					$row[] = '1: '.$person->tsangre.'Sexo'.$person->sexo;
					//
					$row[] = $person->descripcion;
					$row[] = $person->dob;
					//add html for action
					$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$person->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Editar</a>
						  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$person->id."'".')"><i class="glyphicon glyphicon-trash"></i> Eliminar</a>';
					$data[] = $row;
				}
		}


		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->person->count_all(),
						"recordsFiltered" => $this->person->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->person->get_by_id($id);
		$data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
		echo json_encode($data);
	}

	public function ajax_add()//
	{
		$this->_validate();
		$data = array(
				'cuentaID' => $this->session->userdata('cuenta'),
				'usuarioMV' => $this->session->userdata('usuario'),
				'nombreCuest' => $this->input->post('nombreCuest'),
				'apaterno' => $this->input->post('apellidoPCuest'),
				'amaterno' => $this->input->post('apellidoMCuest'),
				'nombremCuest' => $this->input->post('nombremCuest'),
				'ampaterno' => $this->input->post('apellidomPCuest'),
				'ammaterno' => $this->input->post('apellidomMCuest'),
				
				'aseguradora' => $this->input->post('aseguradora'),
				'rh' => $this->input->post('factorh'),

				'afiliacion' => $this->input->post('afiliacion'),
				'npoliza' => $this->input->post('npoliza'),


				'cemergencia1' => $this->input->post('cemergencia1'),
				'cemergencia2' => $this->input->post('cemergencia2'),

				'temergencia1' => $this->input->post('temergencia1'),
				'temergencia2' => $this->input->post('temergencia2'),
				

				'corremergencia1' => $this->input->post('corremergencia1'),
				'corremergencia2' => $this->input->post('corremergencia2'),
				'relacion1' => $this->input->post('relacion1'),
				'relacion2' => $this->input->post('relacion2'),

				'te1' => $this->input->post('te1'),
				'te2' => $this->input->post('te2'),
				'teoficina1' => $this->input->post('teoficina1'),
				'teoficina2' => $this->input->post('teoficina2'),
				


				'cabeza' => $this->input->post('cabeza'),
				'complex' => $this->input->post('complex'),

				'frente' => $this->input->post('frente'),
				'eeestatura' => $this->input->post('eeestatura'),

				'tcabello' => $this->input->post('tcabello'),
				'ccabello' => $this->input->post('ccabello'),
				'cejas' => $this->input->post('cejas'),
				'ojos' => $this->input->post('ojos'),
				'fcara' => $this->input->post('fcara'),
				'orejas' => $this->input->post('orejas'),
				'nariz' => $this->input->post('nariz'),
				'boca' => $this->input->post('boca'),
				'labios' => $this->input->post('labios'),
				'dientes' => $this->input->post('dientes'),
				'menton' => $this->input->post('menton'),
				'bigote' => $this->input->post('bigote'),
				'cicatrices' => $this->input->post('cicatrices'),
				'omarcas' => $this->input->post('omarcas'),
				
				'estatura' => $this->input->post('estatura'),
				'peso' => $this->input->post('peso'),
				
				'tsangre' => $this->input->post('tsangre'),
				'sexo' => $this->input->post('sexo'),

				'activo' => $this->input->post('activo'),
				'descripcion' => $this->input->post('descripcion'),
				'descripcionee' => $this->input->post('descripcionee'),
				'descripcioneea' => $this->input->post('descripcioneea'),
				
				'dob' => $this->input->post('dob'),
			);
		$insert = $this->person->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'nombreCuest' => $this->input->post('nombreCuest'),
				'apaterno' => $this->input->post('apellidoPCuest'),
				'amaterno' => $this->input->post('apellidoMCuest'),
				'nombremCuest' => $this->input->post('nombremCuest'),
				'ampaterno' => $this->input->post('apellidomPCuest'),
				'ammaterno' => $this->input->post('apellidomMCuest'),
				
				'aseguradora' => $this->input->post('aseguradora'),
				'rh' => $this->input->post('factorh'),

				'afiliacion' => $this->input->post('afiliacion'),
				'npoliza' => $this->input->post('npoliza'),

				'cemergencia1' => $this->input->post('cemergencia1'),
				'cemergencia2' => $this->input->post('cemergencia2'),
				'temergencia1' => $this->input->post('temergencia1'),
				'temergencia2' => $this->input->post('temergencia2'),

				'corremergencia1' => $this->input->post('corremergencia1'),
				'corremergencia2' => $this->input->post('corremergencia2'),
				'relacion1' => $this->input->post('relacion1'),
				'relacion2' => $this->input->post('relacion2'),

				'te1' => $this->input->post('te1'),
				'te2' => $this->input->post('te2'),
				'teoficina1' => $this->input->post('teoficina1'),
				'teoficina2' => $this->input->post('teoficina2'),
				
				'frente' => $this->input->post('frente'),
				'eeestatura' => $this->input->post('eeestatura'),

				'tcabello' => $this->input->post('tcabello'),
				'ccabello' => $this->input->post('ccabello'),
				'cejas' => $this->input->post('cejas'),
				'ojos' => $this->input->post('ojos'),
				'fcara' => $this->input->post('fcara'),
				'orejas' => $this->input->post('orejas'),
				'nariz' => $this->input->post('nariz'),
				'boca' => $this->input->post('boca'),
				'labios' => $this->input->post('labios'),
				'dientes' => $this->input->post('dientes'),
				'menton' => $this->input->post('menton'),
				'bigote' => $this->input->post('bigote'),
				'cicatrices' => $this->input->post('cicatrices'),
				'omarcas' => $this->input->post('omarcas'),

				
				'estatura' => $this->input->post('estatura'),
				'peso' => $this->input->post('peso'),

				'cabeza' => $this->input->post('cabeza'),
				'complex' => $this->input->post('complex'),
				
				'tsangre' => $this->input->post('tsangre'),
				'sexo' => $this->input->post('sexo'),

				'activo' => $this->input->post('activo'),
				'descripcion' => $this->input->post('descripcion'),
				'descripcionee' => $this->input->post('descripcionee'),
				'descripcioneea' => $this->input->post('descripcioneea'),
				
				'dob' => $this->input->post('dob'),
			);
		$this->person->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->person->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}


	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('nombreCuest') == '')
		{
			$data['inputerror'][] = 'nombreCuest';
			$data['error_string'][] = 'Nombre de Cuestionario Requerido';
			$data['status'] = FALSE;
		}

		if($this->input->post('dob') == '')
		{
			$data['inputerror'][] = 'dob';
			$data['error_string'][] = 'Date of Birth is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('activo') == '')
		{
			$data['inputerror'][] = 'activo';
			$data['error_string'][] = 'Seleccione Activado';
			$data['status'] = FALSE;
		}

		if($this->input->post('descripcion') == '')
		{
			$data['inputerror'][] = 'descripcion';
			$data['error_string'][] = 'Agregar Descripcion';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

}
