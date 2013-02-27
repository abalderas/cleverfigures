<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Alumnos extends CI_Controller 
{	
	public function index()
	{
		// Comprobamos que el usuario haya hecho login
		if (!$this->session->userdata('logged_in'))
			redirect('acceso/index');

		// LOAD LIBRARIES
        $this->load->library(array('encrypt', 'form_validation'));
		
		// LOAD MODEL
		$this->load->model('acceso_model', 'acceso');

		// Leemos el ID del usuario que ha hecho login
		$usuario_id = $this->session->userdata('userid');
		
		// Si el usuario no es administrador, lo sacamos de aquí
		if (!$this->acceso->es_admin($usuario_id))
			redirect('evaluar');

		// Leemos los datos de los alumnos
		$data['alumnos'] = $this->acceso->usuarios();
		
		// Cargamos las vistas
		$this->load->view('template/header');
		$this->load->view('template/menu');
		$this->load->view('alumnos', $data);
		$this->load->view('template/footer');
	}
}
