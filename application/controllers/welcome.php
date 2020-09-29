<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Welcome extends CI_Controller {

   public function __construct() 
        {
            parent::__construct();

            $user_id = $this->session->userdata('id');
            $user_name = $this->session->userdata('user_name');
            $access_points = $this->session->userdata('access_points');
            $line_id = $this->session->userdata('line_id');
            $floor_id = $this->session->userdata('floor_id');

            if($user_id != NULL && $user_name != NULL && $access_points != NULL && $line_id != NULL && $floor_id != NULL)
            {
                 redirect('access', 'refresh');
            }

       }

	public function index_x()
	{
		$data['title']='ECOFAB PTS';

		$this->load->view('login');
	}

    public function index()
    {
        $data['title']='ECOFAB PTS';

        $this->load->view('login_new');
    }

	public function login_x()
	{
		$data['username'] = $this->input->post('username');
		$data['password'] = $this->input->post('password');
		
		$result=$this->welcome_model->login_check($data);
		
	       if($result)
               {
                   $data1['id']=$result->id;
                   $data1['user_name']=$result->user_name;
                   $data1['user_description']=$result->user_description;
                   $data1['access_points']=$result->access_points; // 1=cutting, 2=line_begin, 3=midline_qc, 4=endline_qc
                   $data1['line_id']=$result->line_id;
                   $data1['floor_id']=$result->floor_id;

                   $this->session->set_userdata($data1);
				   
                   redirect('access','refresh');
                   
               }
               else{
                   $data['exception']='Your User Name/Password is Invalid!';
                   $this->session->set_userdata($data);

                   redirect('welcome', 'refresh');
               }

	}

    public function login_new()
    {
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        $date_time = $datex->format('Y-m-d H:i:s');
        $date = $datex->format('Y-m-d');
        $time = $datex->format('H:i:s');

        $min_max_time=$this->access_model->getMinMaxHours();
        $min_time = $min_max_time[0]['min_start_time'];

        $data['username'] = $this->input->post('username');
//        $data['password'] = $this->input->post('password');

        $result=$this->welcome_model->login_check_new($data);

        if($min_time > $time) {
            $data['exception']="Please Try Later on $min_time !";
            $this->session->set_userdata($data);

            redirect('welcome', 'refresh');
        }else{
            if($result)
            {
                $data1['id']=$result->id;
                $data1['user_name']=$result->user_name;
                $data1['user_description']=$result->user_description;
                $data1['access_points']=$result->access_points; // 1=cutting, 2=line_begin, 3=midline_qc, 4=endline_qc
                $data1['line_id']=$result->line_id;
                $data1['floor_id']=$result->floor_id;
                $data1['is_print_allowed']=$result->is_print_allowed;

                $this->session->set_userdata($data1);

                redirect('access','refresh');

            }
            else{
                $data['exception']='Your User Name/Password is Invalid!';
                $this->session->set_userdata($data);

                redirect('welcome', 'refresh');
            }
        }

    }

    public function logout() {
        session_destroy();
        $data['message'] = 'Successfully Logged out!';
        $this->session->set_userdata($data);
        $this->session->sess_destroy();
        redirect('welcome');
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */