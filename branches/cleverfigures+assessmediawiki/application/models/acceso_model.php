	<?php
class Acceso_model extends CI_Model {

    private $user;
	private $id;
	private $pass;
	private $link;

	private $usuarios = array();

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
		$this->link = $this->conectar_wiki();
		$this->listado();
    }
	
	/// Realiza la conexión a la BD de MediaWiki y devuelve el enlace MySQL
	function conectar_wiki()
	{		
		$link =  mysql_connect('localhost', $this->config->item('username_mw'), $this->config->item('password_mw'));

		if (!$link) {
			die('No pudo conectarse: ' . mysql_error());
		}
		if (!mysql_select_db($this->config->item('database_mw'), $link)) {
			echo 'No pudo seleccionar la base de datos';
			exit;
		}
		
		return $link;
	}
	
	/// Devuelve el ID del usuario con el nombre indicado
	function userid ($user)
	{		
		$this->user = $user;
		
		$sql    = 'SELECT user_id '
			. 'FROM user '
			. 'WHERE user_name like \''. $user . '\'';
			
		$result = mysql_query($sql, $this->link);

		// Si no existe ningún usuario con ese ID, devolvemos falso
		if (mysql_num_rows($result) == 0)
			return FALSE;

		while ($row = mysql_fetch_array($result)) {
			$this->id= $row[0];
		}
		return $this->id;
		
	}
	
	/// Devuelve el nombre del usuario con el ID indicado
	function username($userid)
	{		
		$this->userid = $userid;
		
		$sql    = 'SELECT user_name '
			. 'FROM user '
			. 'WHERE user_id = '. $userid;
			
		$result = mysql_query($sql, $this->link);

		while ($row = mysql_fetch_array($result)) {
			$this->user= $row[0];
		}
		return $this->user;
		
	}
	
	/// Devuelve el hash del usuario con el nombre indicado
	function userpass ($user)
	{		
		$this->user = $user;
		
		$sql    = 'SELECT user_password '
			. 'FROM user '
			. 'WHERE user_name like \''. $user . '\'';
			
		$result = mysql_query($sql, $this->link);

		while ($row = mysql_fetch_array($result)) {
			$this->pass= $row[0];
		}
		return $this->pass;
		
	}
    
    /// Lee la lista de usuarios de la BD de mediawiki
    private function listado()
	{
		
		// Construimos la sentencia SQL para leer todos los usuarios
		$sql = 'SELECT user_id, user_name FROM user';

		// Lanzamos la sentencia
		$result = mysql_query($sql, $this->link);

		// Guardamos todos los usuarios leidos en el array $this->usuarios
		while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
			$this->usuarios[$row[0]] = $row[1];
		}		
	}

	/// Devuelev la lista de usuarios
	function usuarios()
	{
		return $this->usuarios;
	}

	function es_admin($userid)
	{
		// Los usuarios que son ADMIN se definen en el fichero
		// application/config/amw.php

		return in_array($userid, $this->config->item("usuarios_admin"));
	}

}
?>
