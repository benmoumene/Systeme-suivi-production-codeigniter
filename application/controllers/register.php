<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
session_start();

class Register extends CI_Controller {

    public function index() {
        $data['title'] = 'Register';

        $data['lines']=$this->register_model->getLines();

        $this->load->view('registration', $data);
    }

    public function isEmpAlreadyavailable(){
        $emp_id = $this->input->post('emp_id');
        $res_data=$this->register_model->isEmpAlreadyavailable($emp_id);

        $array_length = sizeof($res_data);

        if($array_length == 0){
            echo 'proceed';
        }
        if($array_length != 0){
            echo 'duplicate';
        }
    }

    public function registerEmployee(){
        $emp_id = $this->input->post('emp_id');
        $access_point = $this->input->post('access_point');
        $line = $this->input->post('line');
        $status = $this->input->post('status');

        $data = array(
            'user_name' => $emp_id,
            'user_password' => '123456',
            'access_points' => $access_point,
            'line_id' => $line,
            'status' => $status
        );

        $this->register_model->insertingData('tb_user', $data);

        $data['message']='Successfully Registered!';
        $this->session->set_userdata($data);

        redirect('register', 'refresh');
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */