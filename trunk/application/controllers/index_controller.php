<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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


//GROUP CREATE ARRAY
class Index_controller extends CI_Controller {

  function Index_controller(){
    parent::__construct();
  }

  function index(){
    //IF USER LOGGED IN
    if($this->session->userdata('username')){
      if(!$this->session->userdata('is_student'))
        redirect('teacher');
      else
        redirect('student');
    }
    else{
      $this->lang->load('voc', 'english');
      redirect('login/loadlogin/');
    }
  }
}
