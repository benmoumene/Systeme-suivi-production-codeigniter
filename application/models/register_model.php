<?php

class Register_model extends CI_Model {
    //put your code here


    public function getLines(){
        $sql="SELECT t1.*, t2.floor_name 
              FROM `tb_line` as t1
              INNER JOIN
              `tb_floor` as t2
              ON t1.floor=t2.id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function isEmpAlreadyavailable($emp_id){
        $sql="SELECT * FROM `tb_user` WHERE user_name LIKE '%$emp_id%'";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function insertingData($tbl, $data)
    {
        $this->db->INSERT($tbl, $data);
        //return $this->db->insert_id();
    }
}

?>