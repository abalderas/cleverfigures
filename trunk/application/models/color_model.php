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


class Color_model extends CI_Model{


  function Color_model() {
    parent::__construct();
    $this->load->database();
    $ci =& get_instance();
    $ci->load->model('connection_model');
  }

  //Generates average value of array content
  private function array_avg($array) {
    return array_sum($array) / count($array);
  }

  //Generates standar deviation of array content
  private function standard_deviation($aValues, $bSample = false) {
    $fMean = array_sum($aValues) / count($aValues);
    $fVariance = 0.0;
    foreach ($aValues as $i) {
      $fVariance += pow($i - $fMean, 2);
    }
    $fVariance /= ( $bSample ? count($aValues) - 1 : count($aValues) );
    return (float) sqrt($fVariance);
  }

  private function wconnection($colorname) {
    //Checks connection
    $query = $this->db->query("select color_connection from color where color_name = '$colorname'");

    //Returns the id
    if(!$query->result()) {
      return "wconnection(): ERR_NONEXISTENT";
    }
    else {
      foreach($query->result() as $row) {
        return $row->color_connection;
      }
    }
  }

  function new_color($colorname, $db_server, $db_name, $db_user, $db_password, $related_wiki) {
    //If color exists, returns error
    $check = $this->db->query("select * from color where color_name = '$colorname'");
    if($check->result()) {
      return false;
    }

    //Creates a new connection
    $my_con = $this->connection_model->new_connection($db_server, $db_name, $db_user, $db_password);

    if(!$my_con) {
      die ('new_color: bad connection');
    }
    else {
      //Creates and inserts color info
      $sql = array('color_id' => "",
        'color_name' => "$colorname",
        'color_connection' => "$my_con",
        'color_wiki' => "$related_wiki"
      );

      $this->db->insert('color', $sql);

      //Returns false if error
      if($this->db->affected_rows() != 1) {
        return false;
      }
    }
  }

  function fetch($colorname, $analisis){

    echo ">> Assess analisis started.</br>";
    echo "Connecting to assess database...</br>";

    ob_flush(); flush();

    //Connecting to the wiki database
    $link = $this->connection_model->connect($this->wconnection($colorname));

    echo "Querying database for assess information...";

    ob_flush(); flush();

    //Creating query string
    $qstr = "select eva_user, eva_revisor, eva_revision, ent_entregable, ee_nota, ee_comentario from entregables, evaluaciones, evaluaciones_entregables where evaluaciones_entregables.eva_id = evaluaciones.eva_id and evaluaciones_entregables.ent_id = entregables.ent_id order by eva_revision asc";

    //Querying database
    $query = $link->query($qstr);

    //If no results then return false
    if(!$query->result()) {
      return false;
    }

    echo "done.</br>";

    echo "Storing assess information...";

    ob_flush(); flush();

    //Storing classified information in arrays 
    foreach($query->result() as $row){

      //USER INFORMATION

      $usermark	[$row->eva_user][$row->eva_revision] = $row->ee_nota;
      $useraverage	[$row->eva_user][$row->eva_revision] = $this->array_avg($usermark[$row->eva_user]);
      $userminvalue	[$row->eva_user][$row->eva_revision] = min($usermark[$row->eva_user]);
      $usermaxvalue	[$row->eva_user][$row->eva_revision] = max($usermark[$row->eva_user]);
      $usersd		[$row->eva_user][$row->eva_revision] = $this->standard_deviation($usermark[$row->eva_user]);
      $usercriteria	[$row->eva_user][$row->eva_revision] = $row->ent_entregable;
      $userrevisor	[$row->eva_user][$row->eva_revision] = $row->eva_revisor;
      $usercomment	[$row->eva_user][$row->eva_revision] = $row->ee_comentario;


      //CRITERIA INFORMATION

      $criteriamark	 [$row->ent_entregable][$row->eva_revision] = $row->ee_nota;
      $criteriaaverage [$row->ent_entregable][$row->eva_revision] = $this->array_avg($criteriamark[$row->ent_entregable]);
      $criteriamaxvalue[$row->ent_entregable][$row->eva_revision] = max($criteriamark[$row->ent_entregable]);
      $criteriaminvalue[$row->ent_entregable][$row->eva_revision] = min($criteriamark[$row->ent_entregable]);
      $criteriarevisor [$row->ent_entregable][$row->eva_revision] = $row->eva_revisor;
      $criteriacomment [$row->ent_entregable][$row->eva_revision] = $row->ee_comentario;
      $criteriauser	 [$row->ent_entregable][$row->eva_revision] = $row->eva_user;


      //REVISOR INFORMATION

      $revisormark	[$row->eva_revisor][$row->eva_revision] = $row->ee_nota;
      $revisoraverage [$row->eva_revisor][$row->eva_revision] = $this->array_avg($revisormark[$row->eva_revisor]);
      $revisormaxvalue[$row->eva_revisor][$row->eva_revision] = max($revisormark[$row->eva_revisor]);
      $revisorminvalue[$row->eva_revisor][$row->eva_revision] = min($revisormark[$row->eva_revisor]);
      $revisorcomment [$row->eva_revisor][$row->eva_revision] = $row->ee_comentario;
      $revisorcriteria[$row->eva_revisor][$row->eva_revision] = $row->ent_entregable;
      $revisoruser	[$row->eva_revisor][$row->eva_revision] = $row->eva_user;


      //TOTAL INFORMATION

      $totalmark	[$row->eva_revision] = $row->ee_nota;
      $totalaverage	[$row->eva_revision] = $this->array_avg($totalmark);
      $totalmaxvalue	[$row->eva_revision] = max($totalmark);
      $totalminvalue	[$row->eva_revision] = min($totalmark);
      $totaluser	[$row->eva_revision] = $row->eva_user;
      $totalcriteria	[$row->eva_revision] = $row->ent_entregable;
      $totalrevisor	[$row->eva_revision] = $row->eva_revisor;
    }

    echo "done.</br>";
    echo ">> Assess analisis accomplished.</br>";

    ob_flush(); flush();

    $analisis_data = array(	'usermark' => $usermark
      , 'useraverage' => $useraverage
      , 'usersd' => $usersd
      , 'usermaxvalue' => $usermaxvalue
      , 'userminvalue' => $userminvalue
      , 'usercriteria' => $usercriteria
      , 'userrevisor' => $userrevisor
      , 'usercomment' => $usercomment
      , 'criteriamark' => $criteriamark
      , 'criteriaaverage' => $criteriaaverage
      , 'criteriamaxvalue' => $criteriamaxvalue
      , 'criteriaminvalue' => $criteriaminvalue
      , 'criteriarevisor' => $criteriarevisor
      , 'criteriacomment' => $criteriacomment
      , 'criteriauser' => $criteriauser
      , 'revisormark' => $revisormark
      , 'revisoraverage' => $revisoraverage
      , 'revisormaxvalue' => $revisormaxvalue
      , 'revisorminvalue' => $revisorminvalue
      , 'revisorcomment' => $revisorcomment
      , 'revisorcriteria' => $revisorcriteria
      , 'revisoruser' => $revisoruser
      , 'totalmark' => $totalmark
      , 'totalaverage' => $totalaverage
      , 'totalmaxvalue' => $totalmaxvalue
      , 'totalminvalue' => $totalminvalue
      , 'totaluser' => $totaluser
      , 'totalcriteria' => $totalcriteria
      , 'totalrevisor' => $totalrevisor
    );

    return $analisis_data;
  }

  function delete_color($colorname){

    //Check if color exists
    $check = $this->db->query("select * from color where color_name = '$colorname'");

    //If not, error
    if(!$check->result()) {
      return false;
    }

    //Unrelate wiki
    $this->user_model->unrelate_color($colorname);

    //Checking if another user is using the wiki
    $check = $this->db->query("select * from `user-color` where color_name = '$colorname' and user_username != '".$this->session->userdata('username')."'");

    //If nobody uses the wiki
    if(!$check->result()){

      //Get connection
      $con = $this->wconnection($colorname);

      //Check if another wiki uses the connection
      $check = $this->db->query("select * from color where color_name != '$colorname' and color_connection = '$con'");
      if(!$check->result()) {

        //delete connection
        $this->connection_model->delete_connection($con);
      }

      //Delete wiki
      $this->db->delete('color', array('color_name' => $colorname));
    }

    return true;
  }
}
