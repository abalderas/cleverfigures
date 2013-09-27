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
/*
class Api extends REST_Controller {

	function Api(){ parent::__construct(); }
   	
	function index_get(){
		$data = $this->db->query('SELECT * FROM analisis WHERE analisis_wiki_name = ' . $this->get('wiki') . ' AND analisis.analisis_date IN (SELECT `user-analisis`.analisis_date FROM `user-analisis` WHERE `user-analisis`.user_username = ' . $this->logged_user . ')')->result();
		$this->response($data);
	}
}*/
