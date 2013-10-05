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

class Csv_model extends CI_Model{

  function Csv_model() {
    parent::__construct();
    $this->load->database();
    $this->load->helper('file');
  }

  private function delTree($dir) {
    $files = glob( $dir . '*', GLOB_MARK );
    foreach( $files as $file ){
      if( substr( $file, -1 ) == '/' )
        delTree( $file );
      else
        unlink( $file );
    }
    rmdir( $dir );
  }

  /**
   * Generatting CSV formatted string from an array.
   * By Sergey Gurevich.
   */

  function array_to_csv($array, $header_row = false, $col_sep = ",", $row_sep = "\n", $qut = '"') {
    $output = "";
    if (!is_array($array) or !is_array($array[0])) return false;

    //Header row.
    if ($header_row)
    {
      foreach ($array[0] as $key => $val)
      {
        //Escaping quotes.
        $key = str_replace($qut, "$qut$qut", $key);
        $output .= "$col_sep$qut$key$qut";
      }
      $output = substr($output, 1)."\n";
    }
    //Data rows.
    foreach ($array as $key => $val)
    {
      $tmp = '';
      foreach ($val as $cell_key => $cell_val)
      {
        //Escaping quotes.
        $cell_val = str_replace($qut, "$qut$qut", $cell_val);
        $tmp .= "$col_sep$qut$cell_val$qut";
      }
      $output .= substr($tmp, 1).$row_sep;
    }

    return $output;
  }

  function createcsv($arr, $analysis_name, $name) {

    $str = $this->array_to_csv($arr);

    if(!file_exists("csv/$analysis_name/")) {
      mkdir("csv/$analysis_name/");
    }

    write_file("csv/$analysis_name/$name.csv", $str);
  }

  function destroy_csvs($analysis_name) {
    $this->delTree("csv/$analysis_name/");
  }

}
