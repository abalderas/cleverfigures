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



class Analisis_model extends CI_Model{

  //METHODS
  function Analisis_model(){
    parent::__construct();
    $this->load->database();
    $this->load->helper('file');
    $co =& get_instance();
    $co->load->model('merging_model');
    $ci =& get_instance();
    $ci->load->model('wiki_model');
    $cl =& get_instance();
    $cl->load->model('csv_model');
  }

  function register_analisis($wikiname, $colorname = "", $date){
    //Defines sql query data
    $sql = array(
      'analisis_id' => "",
      'analisis_date' => $date,
      'analisis_wiki_name' => $wikiname,
      'analisis_color_name' => $colorname
    );

    //Performs the insertion
    $this->db->insert('analisis', $sql);

    //Checking no errors happened
    if($this->db->affected_rows() != 1) {
      return "perform_analisis(): ERR_AFFECTED_ROWS (".$this->db->affected_rows().")";
    }
  }

  function delete_analisis($analisis) {
    //Checks that the analysis exists
    $check = $this->db->query("select analisis_date from analisis where analisis_date = '$analisis'");
    if(!$check->result())
      die("delete_analisis(): ERR_NONEXISTENT");

    //Deletes analysis and relations
    $this->db->query("DELETE FROM analisis WHERE analisis_date = '$analisis'");
    $this->db->query("DELETE FROM `user-analisis` WHERE analisis_date = '$analisis'");
    $this->db->query("DELETE FROM `student-analysis` WHERE analisis_date = '$analisis'");

    //Deletes analysis files
    delete_files("analisis/$analisis/");
    rmdir("analisis/$analisis/");
    unlink("analisis/$analisis.dat");

    //Deletes csv files related to the analysis
    $this->csv_model->destroy_csvs($analisis);

    return true;
  }

  function get_analisis_data($date) {
    //Gets analysis data and returns it
    $data = $this->db->query("select * from analisis where analisis_date = '$date'");
    return ($data->result()) ? unserialize(read_file("analisis/$date.dat")) : false;
  }

  function get_analisis_wiki($date) {
    //Gets wiki from analysis with that name
    $data = $this->db->get_where('analisis', array('analisis_date' => $date));
    foreach($data->result() as $row) {
      return $row->analisis_wiki_name;
    }
    return false;
  }

  function get_analisis_color($date) {
    //Gets color from analysis with that name
    $data = $this->db->get_where('analisis', array('analisis_date' => $date));
    foreach($data->result() as $row) {
      return $row->analisis_color_name;
    }
    return false;
  }

  //Coming soon...
  /*

  function share($analysis_date, $student_name){
    $this->db->insert('student-analysis', array('student_name' => $student_name, 'analysis_date' => $analysis_date));
  }

  function unshare($analysis_date, $student_name){
    $this->db->query("DELETE FROM `student-analysis` WHERE analysis_date = '$analysis_date' and student_name = '$student_name'");
  }

  function shared_with($analysis_date, $student_name){
    return $this->db->query("select * from `student-analysis` where student_name = '$student_name' and analysis_date = '$analysis_date'")->result() ? true : false;
  }

  */
}
