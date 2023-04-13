<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class maneja_dispos extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('logistica/gendispo_model','person');
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
		$this->load->view('logistica/genera_dispos');
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
				if ($person->tipoEquipo=='Otro-Portable' || $person->tipoEquipo=='Persona') 
					{
					$no++;
					$row = array();
					$row[] = $no.'.- '.$person->mostrarNombre.'<br> ID='.$person->id;
					$row[] = '- '.$person->UltimaDireccionValida;
					
					$row[] = $person->descripcion;
					$row[] = $person->dob;
					//add html for action
					$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$person->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Editar</a>
						 ';
					$data[] = $row;
					}//fin filtra por dispositivo tipo de equipo
				}//se filtra para que traiga lo de la misma cuenta.
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

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'mostrarNombre' => $this->input->post('mostrarNombre'),
				
				'descripcion' => $this->input->post('descripcion'),
				'dob' => $this->input->post('dob'),
			);
		$this->person->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}


	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('mostrarNombre') == '')
		{
			$data['inputerror'][] = 'mostrarNombre';
			$data['error_string'][] = 'Nombre de Cuestionario Requerido';
			$data['status'] = FALSE;
		}

		if($this->input->post('dob') == '')
		{
			$data['inputerror'][] = 'dob';
			$data['error_string'][] = 'Date of Birth is required';
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
