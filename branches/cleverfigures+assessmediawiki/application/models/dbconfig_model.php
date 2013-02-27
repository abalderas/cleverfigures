<?php

// <<Copyright 2013 Alvaro Almagro Doello>>
// 
// This file is part of CleverFigures.
// 
// CleverFigures is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
// 
// CleverFigures is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with CleverFigures.  If not, see <http://www.gnu.org/licenses/>.


class Dbconfig_model extends CI_Model{

	//METHODS
	//constructor
   	function Dbconfig_model(){
   	   	parent::__construct();
   	   	$this->load->helper('file');
   	}
   	
   	function config_database($dbname, $dbserver, $dbuser, $dbpassword){
		$str = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The \$active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The \$active_record variables lets you determine whether or not to load
| the active record class
*/

\$active_group = 'main_db';
\$active_record = TRUE;

\$db['main_db']['hostname'] = '$dbserver';
\$db['main_db']['username'] = '$dbuser';
\$db['main_db']['password'] = '$dbpassword';
\$db['main_db']['database'] = '$dbname';
\$db['main_db']['dbdriver'] = 'mysql';
\$db['main_db']['dbprefix'] = '';
\$db['main_db']['pconnect'] = FALSE;
\$db['main_db']['db_debug'] = TRUE;
\$db['main_db']['cache_on'] = FALSE;
\$db['main_db']['cachedir'] = '';
\$db['main_db']['char_set'] = 'utf8';
\$db['main_db']['dbcollat'] = 'utf8_general_ci';
\$db['main_db']['swap_pre'] = '';
\$db['main_db']['autoinit'] = TRUE;
\$db['main_db']['stricton'] = FALSE;


/* End of file database.php */
/* Location: ./application/config/database.php */";

		write_file('application/config/database.php', $str);
   	}
}