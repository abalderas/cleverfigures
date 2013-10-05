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

class Student_model extends CI_Model{

  function Student_model(){
    parent::__construct();
    $this->load->database();
    $ci =& get_instance();
    $ci->load->model('connection_model');
    $cl =& get_instance();
    $cl->load->model('wiki_model');
  }

  function wikihash($user, $wiki, $pw) {
    $link = $this->connection_model->connect($this->wiki_model->wconnection($wiki));
    if(!$link) {
      die("student_login::Invalid database connection.");
    }

    $query = $this->db->query("select user_password from user where user_username = '$user'");

    if($query->result()) {
      $hash = $row->user_password;
    }
    else {
      return false;
    }

    $m = false;
    $type = substr( $hash, 0, 3 );
    $access = false;

    // Si estamos en modo de desarrollo, cualquier contraseña vale
    if ( $type == ':A:' )
    {
      # Unsalted
      if (md5( $pw ) === substr( $hash, 3 )) {
        $access = true;
      }
    }
    elseif ( $type == ':B:' )
    {
      # Salted
      list( $salt, $realHash ) = explode( ':', substr( $hash, 3 ), 2 );
      if (md5( $salt.'-'.md5( $pw ) ) == $realHash) {
        $access = true;
      }
    }
    else
    {
      # Old-style
      if (md5($pw) === $hash)
        $access = true;
    }

    return $access;
  }

  function login($uname, $pass) {
    $wikis = $this->db->query("select wiki_name from wiki")->result();

    $studentwikis = array();

    if($wikis) {
      foreach($wikis as $row) {
        if($this->wikihash($uname, $row->wiki_name, $pass)) {
          $sess_array = array('username' => $uname,
            'language' => $this->config->item('language'),
            'is_student' => true
          );
          $this->session->set_userdata($sess_array);

          return true;
        }
      }
    }
    else {
      return false;
    }
  }

  function get_analysis_list($studentname) {
    $result = $this->db->query("select * from `student-analysis` where student_name = '$studentname' order by analysis_date desc")->result();

    if($result) {
      foreach($result as $row) {
        $alist[] = $row->analysis_date;
      }

      return $alist;
    }
    else {
      return array();
    }
  }
}
