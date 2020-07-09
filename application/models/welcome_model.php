<?php

class Welcome_model extends CI_Model {
    //put your code here
    
    public function login_check($data)
    {
//	$emp_master_db = $this->load->database('emp_master', TRUE);
//
//        $emp_master_db->select('*');
//        $emp_master_db->from('tb_employee_master');
//        $emp_master_db->where('employee_code', $data['username']);
//        $emp_master_db->where('password', $data['password']);
//        $query_result=$emp_master_db->get();
//        $result=$query_result->row();
//
//        return $result;
				
		
        $this->db->select('*');
        $this->db->from('tb_user');
        $this->db->where('user_name', $data['username']);
        $this->db->where('user_password', $data['password']);
        $this->db->where('status', 1);
        $query_result=$this->db->get();
        $result=$query_result->row();

        return $result;
		
    }

    public function login_check_new($data)
    {
//	$emp_master_db = $this->load->database('emp_master', TRUE);
//
//        $emp_master_db->select('*');
//        $emp_master_db->from('tb_employee_master');
//        $emp_master_db->where('employee_code', $data['username']);
//        $emp_master_db->where('password', $data['password']);
//        $query_result=$emp_master_db->get();
//        $result=$query_result->row();
//
//        return $result;


        $this->db->select('*');
        $this->db->from('tb_user');
        $this->db->where('user_name', $data['username']);
        $this->db->where('status', 1);
        $query_result=$this->db->get();
        $result=$query_result->row();

        return $result;

    }

    public function lineInputReportChart(){
        $data['title'] = 'Line Report';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['access_points'] = $this->session->userdata('access_points');

        $datex = new DateTime(date('H:i:s'));
        $datex->modify('+18000 seconds');
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');
//        $date='2017-12-24';

        $data['date'] = $date;

        $where = '';

        $data['line_report'] = $this->access_model->getLineInputReport($date);
//        echo '<pre>';
//        print_r($data['line_report']);
//        echo '</pre>';
//        die();
        $this->load->view('line_report', $data);
    }
    
}

?>