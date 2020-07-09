<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Api extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

    }

    public function lineWiseReport(){

        $this->load->view('api/line_wise_report');

    }

    public function allLinePerformanceDashboard(){

        $date = $this->input->post('date');

        $line_report = $this->dashboard_model->getAllLinePerformanceSummaryReport($date);

        echo json_encode($line_report);

    }

    public function LineWisePerformanceDashboard(){
        $date = '2020-01-26';

        $line_report = $this->dashboard_model->getLineWisePerformanceDashboard($date);

        echo json_encode($line_report);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */