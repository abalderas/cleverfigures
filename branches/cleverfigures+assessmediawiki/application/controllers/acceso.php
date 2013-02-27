<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Acceso extends CI_Controller {

	public function index()
	{
		// Cargamos las bibliotecas de encriptado y validación de formularios
		$this->load->library(array('encrypt', 'form_validation'));

        // Cargamos los helpers para los campos de formulario y rutas de la aplicación
		$this->load->helper(array('form', 'url'));

		// Indicamos los campos del formulario y las reglas de validación sobre el mismo
		$this->form_validation->set_rules('user_name', 'username', 'required');
		$this->form_validation->set_rules('user_pass', 'password', 'required');
		$this->form_validation->set_error_delimiters('<span class="inline-help">','</span>');

		// Carga del modelo de acceso
		$this->load->model('acceso_model', 'acceso');

		// Si junto a la petición se reciben datos del formulario
		if($this->input->post('login'))
		{
			log_message('error','Hay datos de formulario');

			// Si el formulario pasa la validación (ambos campos rellenos)
			if($this->form_validation->run())
			{
				log_message('error','La validación es correcta');
				try {				
					
			    	// Leemos usuario y contraseña
					$user_name = $this->input->post('user_name');		
					$user_name = ucfirst($user_name);
					$user_pass = $this->input->post('user_pass');

	    			// Buscamos el ID asociado al nombre de usuario indicado
					$user_id = $this->acceso->userid($user_name);

					// Si no existe un usuario con ese ID, damos fallo
					if ($user_id == FALSE) 
					{
						throw new Exception("Usuario inexistente");					
					}

					// Fragmento de código sacado del fuente de MediaWiki para generar
					// el HASH de la contraseña del usuario

					// Leemos la contraseña encriptada del usuario asociado
					$hash = $this->acceso->userpass($user_name);
					$m = false;
					$type = substr( $hash, 0, 3 );					
					$acceso = 0;

					// Si estamos en modo de desarrollo, cualquier contraseña vale
					if ($this->config->item('modo_desarrollo') == TRUE) 
					{
						$acceso = 1;
					} 
					elseif ( $type == ':A:' ) 
					{
						# Unsalted
						if (md5( $user_pass ) === substr( $hash, 3 ))
							$acceso = 1;
					} 
					elseif ( $type == ':B:' ) 
					{
						# Salted
						list( $salt, $realHash ) = explode( ':', substr( $hash, 3 ), 2 );
						if (md5( $salt.'-'.md5( $user_pass ) ) == $realHash)						
							$acceso = 1;
					} 
					else 
					{
						# Old-style
						if (md5($user_pass) === $hash)
							$acceso = 1;
					}
						
					// Si la contraseña indicada coincide
					if ($acceso == 1)
					{

	            		// Generamos los datos de la sesión con la información de login
						$newdata = array(
							'username'  => $user_name,
							'userid'  => $user_id,   
							'logged_in' => TRUE,
							'is_admin' => $this->acceso->es_admin($user_id)
							);

						// Guardamos los datos en la cookie de sesión
						$this->session->set_userdata($newdata);

						// Redirigimos al índice de evaluación
						redirect('evaluar/index');
					}
					else
					{
						throw new Exception("Contraseña incorrecta");			
					}
				} catch (Exception $e) {
					$this->session->set_flashdata('message', $e->getMessage());
					redirect('acceso/index/');
				}				
			}
			else
			{
				log_message('error','La validación del formulario no fue bien');
			}
		}

		$this->load->view('template/header');
		$this->load->view('acceso_formulario');
		$this->load->view('template/footer');
	}

	public function salir()
	{
		$this->session->unset_userdata('logged_in');
		redirect('acceso/index/');
	}
}

/* End of file acceso.php */
/* Location: ./application/controllers/acceso.php */
