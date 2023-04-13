<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class maneja_cuestionario extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('logistica/gencuest_model','person');
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
		$this->load->view('logistica/genera_cuestionario');
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
					$row[] = $person->nombreCuest.'<br>'.$person->activo;
					$row[] = '1: '.$person->p1.'<br>2: '.$person->p2.'<br>3: '.$person->p3.'<br>4: '.$person->p4.'<br>5: '.$person->p5.'<br>6: '.$person->p6.'<br>7: '.$person->p7.'<br>8: '.$person->p8.'<br>9: '.$person->p9.'<br>10: '.$person->p10;
					
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
				'p1' => $this->input->post('p1'),
				'p2' => $this->input->post('p2'),
				'p3' => $this->input->post('p3'),
				'p4' => $this->input->post('p4'),
				'p5' => $this->input->post('p5'),
				'p6' => $this->input->post('p6'),
				'p7' => $this->input->post('p7'),
				'p8' => $this->input->post('p8'),
				'p9' => $this->input->post('p9'),
				'p10' => $this->input->post('p10'),

				'activo' => $this->input->post('activo'),
				'descripcion' => $this->input->post('descripcion'),
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
				'p1' => $this->input->post('p1'),
				'p2' => $this->input->post('p2'),
				'p3' => $this->input->post('p3'),
				'p4' => $this->input->post('p4'),
				'p5' => $this->input->post('p5'),
				'p6' => $this->input->post('p6'),
				'p7' => $this->input->post('p7'),
				'p8' => $this->input->post('p8'),
				'p9' => $this->input->post('p9'),
				'p10' => $this->input->post('p10'),
				'activo' => $this->input->post('activo'),
				'descripcion' => $this->input->post('descripcion'),
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

		if($this->input->post('p1') == '')
		{
			$data['inputerror'][] = 'p1';
			$data['error_string'][] = 'Completar Pregunta 1';
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
