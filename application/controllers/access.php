<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
session_start();


class Access extends CI_Controller {

    public $session_out;

    public function __construct() {
        parent::__construct();

        $user_id = $this->session->userdata('id');
        $user_name = $this->session->userdata('user_name');
        $user_description = $this->session->userdata('user_description');
        $access_points = $this->session->userdata('access_points');
        $line_id = $this->session->userdata('line_id');
        $floor_id = $this->session->userdata('floor_id');

        if ($user_id == NULL && $user_name == NULL && $access_points == NULL && $access_points == NULL && $access_points == NULL && $line_id == NULL && $floor_id == NULL) {
            redirect('welcome', 'refresh');
        }
        $this->method_call = &get_instance();

        $this->session_out = 10;
    }

    public function checkSession(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $last_action_date_time = $this->session->userdata('session_last_action_date_time');

        $now_time = strtotime($date_time);
        $last_time = strtotime($last_action_date_time);

        $inactivation_time = round(abs($now_time - $last_time) / 60, 2);

        echo $inactivation_time;
    }

    public function checkAuthorization($access_level, $cur_url){
        return $this->access_model->checkUserAuthorization($access_level, $cur_url);
    }

    public function index() {
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['title'] = 'Dashboard';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $s_data['session_last_action_date_time'] = $date_time;
        $this->session->set_userdata($s_data);

        if ($data['access_points'] == 2){
            redirect('access/care_label_input_line', 'refresh');
        }
        elseif($data['access_points'] == 3){
            redirect('access/care_label_mid_line_new', 'refresh');
        }elseif ($data['access_points'] == 4){
            redirect('access/care_label_end_line_new', 'refresh');
        }elseif ($data['access_points'] == 8){
            redirect('access/bundle_collar_cuff_track', 'refresh');
        }elseif ($data['access_points'] == 1){
            redirect('access/care_label_send_to_production_individual', 'refresh');
        }elseif ($data['access_points'] == 5){
            redirect('access/care_label_finishing', 'refresh');
        }elseif ($data['access_points'] == 6){
            redirect('access/care_label_washing', 'refresh');
        }elseif ($data['access_points'] == 7){
            redirect('access/care_label_packing', 'refresh');
        }elseif ($data['access_points'] == 9){
            redirect('access/care_label_carton', 'refresh');
        }elseif ($data['access_points'] == 10){
            redirect('access/care_label_going_wash', 'refresh');
        }
        elseif ($data['access_points'] == 300){
            redirect('access/qa_warehouse_new', 'refresh');
        }

        $data['maincontent'] = $this->load->view('dashboard', $data, true);
        $this->load->view('master', $data);
    }

    public function dashboardReport(){

        $data['title']='Production Summary Report';

        $line_id = $this->session->userdata('line_id');

        $where = '';

        if($line_id != ''){
            $where .= " AND t5.line_id=$line_id order by t3.max_line_input_date_time desc";

            $data['line_info'] = $this->access_model->getLineInfo($line_id);
        }


        $data['prod_summary'] = $this->access_model->getProducitonSummaryReportByUID($where);

        $data['maincontent'] = $this->load->view('report_index', $data, true);
        $this->load->view('master_line', $data);
    }

    public function poInfoReport(){
        $data['title']='PO Info Report';

        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $data['brands'] = $this->access_model->getAllBrands();

        $data['ship_dates'] = $this->dashboard_model->getAllShipDates();

        $data['maincontent'] = $this->load->view('po_info_report', $data, true);
        $this->load->view('master', $data);
    }

    public function poSearchReport(){
        $data['title']='PO Search';

        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $data['purchase_order_nos'] = $this->access_model->getAllPurchaseOrders();

        $data['maincontent'] = $this->load->view('po_search_report', $data, true);
        $this->load->view('master', $data);
    }

    public function getPoInfoReport(){
        $purchase_order_stuff = $this->input->post('purchase_order_stuff');

        $purchase_order_stuff_array = explode('_', $purchase_order_stuff);

        $so_no = $purchase_order_stuff_array[0];
        $po_no = $purchase_order_stuff_array[1];
        $purchase_order = $purchase_order_stuff_array[2];
        $item_week = $purchase_order_stuff_array[3];
        $color = $purchase_order_stuff_array[4];

        $where = '';
        if($so_no != ''){
//            $where .= " AND A.so_no = '$so_no'";
            $where .= " AND so_no = '$so_no'";
        }
        if($po_no != ''){
            $where .= " AND po_no = '$po_no'";
        }
        if($purchase_order != ''){
            $where .= " AND purchase_order = '$purchase_order'";
        }
        if($item_week != ''){
            $where .= " AND item = '$item_week'";
        }
        if($color != ''){
            $where .= " AND color = '$color'";
        }

        $data['po_info_report'] = $this->dashboard_model->isAvailAlready($where);

        echo $maincontent = $this->load->view('reports/po_detail_info_report', $data);
    }

    public function other_purpose(){
        $data['title']='Other Purpose';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
//        $condition = '';
//        if($data['access_points'] == 300){
//            $condition .= " ORDER BY t16.max_warehouse_last_action_date_time DESC";
//            $data['prod_summary'] = $this->access_model->getProducitonSummaryReportFinish($condition);
//        }else{
//            $data['prod_summary'] = $this->access_model->getProducitonSummaryReport();
//        }

        $data['maincontent'] = $this->load->view('other_purpose', $data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function season(){
        $data['title']='Seasons';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
        $data['seasons'] = $this->access_model->getAllSeasons();

        $data['maincontent'] = $this->load->view('seasons', $data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function add_season(){
        $data['title']='Add Season';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $data['seasons'] = $this->access_model->getAllSeasons();

        $data['maincontent'] = $this->load->view('add_season', $data, true);
        $this->load->view('master', $data);
    }

    public function isSeasonExist(){
        $season = $this->input->post('season');

        $get_res = $this->access_model->isSeasonExist($season);

        echo json_encode($get_res);
    }

    public function addingSeason(){
        $data['season'] = $this->input->post('season');

        $this->access_model->insertingData('tb_season', $data);

        redirect('access/season');
    }

    public function backup_db(){
        $data['title']='Backup Database';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
        $data['databases'] = $this->access_model->getAllDatabases();

        $data['maincontent'] = $this->load->view('backup_db', $data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function backUpCareLabelTable(){
        $src_date = $this->input->post('src_date');
        $des_db = $this->input->post('des_db');

        $this->access_model->copyToBackUpCareLabelTable($src_date, $des_db);
        $this->access_model->deleteFromCareLabelTable($src_date);

        echo "Care Label Backup Done";
    }

    public function backUpCutSummaryTable(){
        $src_date = $this->input->post('src_date');
        $des_db = $this->input->post('des_db');

        $this->access_model->copyToBackUpCutSummaryTable($src_date, $des_db);
        $this->access_model->deleteFromCutSummaryTable($src_date);

        echo "Cut Summary Backup Done";
    }

    public function backUpPoDetailTable(){
        $src_date = $this->input->post('src_date');
        $des_db = $this->input->post('des_db');

        $this->access_model->copyToBackUpPoDetailTable($src_date, $des_db);
        $this->access_model->deleteFromPoDetailTable($src_date);

        echo "PO Detail Backup Done";
    }

    public function delete_cutting(){
        $data['title']='Delete Cutting';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
        $data['cut_no'] = $this->access_model->getCutNoList();

        $data['maincontent'] = $this->load->view('delete_cutting', $data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function getCuttingSummary(){
        $po_no = $this->input->post('po_no');
        $cut_no = $this->input->post('cut_no');

        $res = $this->access_model->getCuttingSummary($po_no, $cut_no);

        echo json_encode($res);
    }

    public function deletingCutting(){
        $date=date('Y-m-d');;
        $po_no = $this->input->post('po_no');
        $cut_no = $this->input->post('cut_no');
        $cut_qty = $this->input->post('cut_qty');

        $this->access_model->logForDeleteCutting($po_no,$cut_no,$cut_qty,$date);
        $this->access_model->deleteCareLabelNos($po_no, $cut_no);
        $this->access_model->deleteCutSummary($po_no, $cut_no);

        redirect('access/delete_cutting');
    }

    // Care Label Print Unlock from Admin Panel Start
    public function active_print_label()
    {
        $data['title']='Active Print Care Label';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
        $data['cut_no'] = $this->access_model->getCutNoList();

//        $data['sap_no'] = $this->access_model->getAllSoFromCutSummary();
        $data['sap_no'] = $this->access_model->getAllSOs();
        $data['maincontent'] = $this->load->view('active_print_label',$data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function activeCareLabel()
    {
        $po_no = $this->input->post('po_no');
        $cut_no = $this->input->post('cut_no');
        $purchase_no = $this->input->post('purchase_no');
        $item_no = $this->input->post('item_no');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');

        $data=$this->access_model->activeCutSummary($po_no, $cut_no, $purchase_no, $item_no, $quality, $color);
        $data=$this->access_model->activeCareLabel($po_no, $cut_no, $purchase_no, $item_no, $quality, $color);
        echo "done";
    }

    public function search_active_care_label()
    {
        $po_no=$this->input->post('po_no');
        $purchase_no=$this->input->post('purchase_no');
        $item_no=$this->input->post('item_no');
        $quality=$this->input->post('quality');
        $color=$this->input->post('color');
        $cut_no=$this->input->post('cut_no');
        $data=$this->access_model->search_active_care_label($po_no,$purchase_no,$item_no,$quality,$color,$cut_no);
        echo $data;

    }
    // Care Label Print Unlock from Admin Panel End


    public function qa_warehouse(){
        $data['title']='QA Warehouse';
        $user_id = $this->session->userdata('id');
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $condition = '';
        $condition_1 = '';

        $user_info = $this->access_model->getUserBrands($user_id);
        $user_brands = $user_info[0]['buyer_condition'];

        if($data['access_points'] == 300){
            $condition .= " ORDER BY t16.max_warehouse_last_action_date_time DESC";
            $condition_1 .= " AND brand in ($user_brands)";
            $data['prod_summary'] = $this->access_model->getProducitonSummaryReportFinish($condition, $condition_1);
        }else{
            $data['prod_summary'] = $this->access_model->getProducitonSummaryReport();
        }

        $data['maincontent'] = $this->load->view('qa_warehouse', $data, true);
        $this->load->view('master', $data);
    }

    public function qa_warehouse_new(){
        $data['title']='QA Warehouse';
        $user_id = $this->session->userdata('id');
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
        $data['wh_types'] = $this->dashboard_model->getWarehouseTypes();
        $data['seasons'] = $this->dashboard_model->getSeasons();


//        if($data['access_points'] == 300){
//            $condition .= " ORDER BY t16.max_warehouse_last_action_date_time DESC";
//            $condition_1 .= " AND brand in ($user_brands)";
//            $data['prod_summary'] = $this->access_model->getProducitonSummaryReportFinish($condition, $condition_1);
//        }else{
//            $data['prod_summary'] = $this->access_model->getProducitonSummaryReport();
//        }

        $data['maincontent'] = $this->load->view('qa_warehouse_new', $data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function qa_warehouse_data(){
        $user_id = $this->session->userdata('id');
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $condition = '';
        $condition_1 = '';

        $user_info = $this->access_model->getUserBrands($user_id);
        $user_brands = $user_info[0]['buyer_condition'];

        $data['wh_types'] = $this->dashboard_model->getWarehouseTypes();

        if($data['access_points'] == 300){
            // Previous Query Condition Start
//            $condition .= " ORDER BY t16.max_warehouse_last_action_date_time DESC";
//            $condition_1 .= " AND brand in ($user_brands)";
            // Previous Query Condition End

//            $data['prod_summary'] = $this->access_model->getProducitonSummaryReportFinish($condition, $condition_1); // Previous Query


            $condition .= " ORDER BY t6.max_warehouse_last_action_date_time DESC";
//            $condition_1 .= " AND t1.brand in ($user_brands)"; //Previous
            $condition_1 .= " AND brand in ($user_brands)";


            $data['prod_summary'] = $this->access_model->getProducitonSummaryReportFinishViewTable($condition_1, $condition);
        }else{
            $data['prod_summary'] = $this->access_model->getProducitonSummaryReport();
        }

        echo $data['maincontent'] = $this->load->view('qa_warehouse_data', $data);
    }

    public function manage_bundle_line(){
        $data['title'] = 'Bundle-Line Assign';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $data['bundle_list'] = $this->access_model->getAllBundles();
        $data['lines'] = $this->access_model->getLines();

        $data['maincontent'] = $this->load->view('manage_bundle_line', $data, true);
        $this->load->view('master', $data);
    }

    public function changeBundleLine(){
        $bundle_ticket = $this->input->post('bundle_ticket');
        $line_no = $this->input->post('line_no');


        foreach ($bundle_ticket as $k => $v){
            $this->access_model->bundleAssignToLine($v, $line_no);
        }

        $line_info = $this->access_model->getLineInfo($line_no);

        $line = $line_info[0]['line_name'];

        $data['message'] = "Successfully Assigned - $line";
        $this->session->set_userdata($data);

        redirect('access/manage_bundle_line');
    }

    public function smv_form(){
        $data['title'] = 'SMV';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');
        $data['msg'] = '';

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {

            $data['so_list'] = $this->access_model->getAllSOs();

            $data['maincontent'] = $this->load->view('smv_form', $data, true);
            $this->load->view('master', $data);
        }else{
            echo $this->load->view('404');
        }
    }

    public function save_smv(){
        $sales_order = $this->input->post('sales_order');
        $smv = $this->input->post('smv');

        $data_type = gettype($smv + 0);

        $data['so_list'] = $this->access_model->updateSmv($sales_order, $smv);

        $data['message'] = "SO: $sales_order - SMV: $smv";
        $this->session->set_userdata($data);

        redirect('access/smv_form');
    }

    public function getSoInfo(){
        $sales_order = $this->input->post('sales_order');

        $so_detail = $this->access_model->getSoInfo($sales_order);

        echo json_encode($so_detail);
    }

    public function getProductionSummaryReportByUID(){

        $line_id = $this->session->userdata('line_id');

        $where = '';

        if($line_id != ''){
            $where .= " AND t3.line_id=$line_id order by t3.max_line_input_date_time DESC";
        }
        $data['prod_summary'] = $this->access_model->getProducitonSummaryReportByUID($where);
        $data['maincontent'] = $this->load->view('care_label_line_prod_summary_report_uid', $data);
    }

    public function chk_so_no()
    {
        $po_no=$this->input->post('po_no');
        $where = '';

        if($po_no != ''){
            $where .= " AND po_no='$po_no'";
        }

        $chk_so_no=$this->access_model->chk_so_no($where);
        if($chk_so_no)
            $output='';
        {
            $output .= '<option value="">Select So No</option>';
            foreach($chk_so_no as $v_chk){

                $output .= '<option value="'.$v_chk->so_no.'">'.$v_chk->so_no.'</option>';

            }
            echo $output;
        }
    }

    public function print_sticker_test(){
        $data['title'] = 'Print Sticker Test';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');
        $data['msg'] = '';

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
        $data['maincontent'] = $this->load->view('care_label_print_sticker', $data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function rediSamePage(){
        $data['title'] = 'Print Sticker Test';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');
        $data['msg'] = '';


        $carelabel_tracking_no = $this->input->post('carelabel_tracking_no');

        $data['img_url']="";
        if($carelabel_tracking_no != '')
        {
            $this->load->library('ciqrcode');
            $qr_image=$carelabel_tracking_no.'.png';
            $params['data'] = $carelabel_tracking_no;
            $params['level'] = 'H';
            $params['size'] = 8;
            $params['savename'] =FCPATH."uploads/qr_image/".$qr_image;


            if($this->ciqrcode->generate($params))
            {
                $data['img_url']=$qr_image;
            }
        }

        echo '<script>
//            if(confirm("Print Sticker?")){ 
                window.open("'.base_url().'access/printSticker/'.$carelabel_tracking_no.'");
//            }
        </script>';

        $data['maincontent'] = $this->load->view('care_label_print_sticker', $data, true);
        $this->load->view('master', $data);
    }

    public function printCareLabels($po_no, $so_no, $cut_tracking_no){

        $limit = "";

        $get_data['po_no'] = $po_no;
        $get_data['so_no'] = $so_no;

        $get_data['cut_tracking_no'] = $cut_tracking_no;
        $get_data['care_label_list'] = $this->access_model->checkCutCareLabelAvailability($po_no, $so_no, $cut_tracking_no, $limit);

        $count_pcs = 0;

        if(!empty($get_data['care_label_list'])){

            foreach ($get_data['care_label_list'] as $k => $v_c){

                $carelabel_tracking_no = $v_c['pc_tracking_no'];

                $data['img_url']="";
                if($carelabel_tracking_no != '')
                {
                    $count_pcs++;
                    $this->load->library('ciqrcode');
                    $qr_image=$carelabel_tracking_no.'.png';
                    $params['data'] = $carelabel_tracking_no;
                    $params['level'] = 'H';
                    $params['size'] = 8;
                    $params['savename'] =FCPATH."uploads/qr_image/".$qr_image;


                    if($this->ciqrcode->generate($params))
                    {
                        $data['img_url']=$qr_image;
                    }
                }
            }
        }

        $get_data['count_pcs'] = $count_pcs;

        $data['maincontent'] = $this->load->view('care_label_print', $get_data);
    }

    public function getPrintCareLabels(){

        $po_no = $this->input->post('po_no');
        $so_no = $this->input->post('so_no');
        $cut_tracking_no = $this->input->post('cut_tracking_no');
        $print_qty = $this->input->post('print_qty');

        $limit = "";

        if($print_qty > 0){
            $limit .= " LIMIT $print_qty";
        }

        $get_data['po_no'] = $po_no;
        $get_data['so_no'] = $so_no;

        $get_data['cut_tracking_no'] = $cut_tracking_no;
        $get_data['care_label_list'] = $this->access_model->checkCutCareLabelAvailability($po_no, $so_no, $cut_tracking_no, $limit);


        if(!empty($get_data['care_label_list'])){

            foreach ($get_data['care_label_list'] as $k => $v_c){

                $carelabel_tracking_no = $v_c['pc_tracking_no'];

                $data['img_url']="";
                if($carelabel_tracking_no != '')
                {
                    $this->load->library('ciqrcode');
                    $qr_image=$carelabel_tracking_no.'.png';
                    $params['data'] = $carelabel_tracking_no;
                    $params['level'] = 'H';
                    $params['size'] = 8;
                    $params['savename'] =FCPATH."uploads/qr_image/".$qr_image;


                    if($this->ciqrcode->generate($params))
                    {
                        $data['img_url']=$qr_image;
                    }
                }
            }
        }


        $data['maincontent'] = $this->load->view('care_label_print_list', $get_data);
    }

    public function printBundleTicket($po_no, $so_no, $cut_tracking_no){

        $get_data['po_no'] = $po_no;
        $get_data['so_no'] = $so_no;
        $get_data['cut_tracking_no'] = $cut_tracking_no;
        $get_data['bundle_body_list'] = $this->access_model->getBundleSummaryInfo($po_no, $so_no, $cut_tracking_no);

        if(!empty($get_data['bundle_body_list'])){

            foreach ($get_data['bundle_body_list'] as $v_c){
                $bundle_trking_no = $v_c['bundle_tracking_no'];
                $bundle_tracking_no=$bundle_trking_no."bdy.";

                $data['img_url']="";
                if($bundle_tracking_no != '')
                {
                    $this->load->library('ciqrcode');
                    $qr_image=$bundle_tracking_no.'.png';
                    $params['data'] = $bundle_tracking_no;
                    $params['level'] = 'H';
                    $params['size'] = 8;
                    $params['savename'] =FCPATH."uploads/qr_image/".$qr_image;


                    if($this->ciqrcode->generate($params))
                    {
                        $data['img_url']=$qr_image;
                    }
                }
            }
        }

        $data['maincontent'] = $this->load->view('generated_bundle_tag_bdy', $get_data);
    }

    public function getTotalOrderQty($po_no){
        $get_data = $this->access_model->getTotalOrderQty($po_no);

        return $get_data;
    }

    public function printBundleTicketCC($po_no, $so_no, $cut_tracking_no, $flag){

        /*
        1= Collar
        2=Cuff
        */

        $get_data['cc'] = $flag;

        $get_data['po_no'] = $po_no;
        $get_data['so_no'] = $so_no;
        $get_data['cut_tracking_no'] = $cut_tracking_no;
        $get_data['bundle_cc_list'] = $this->access_model->getBundleSummaryInfo($po_no, $so_no, $cut_tracking_no);

        if(!empty($get_data['bundle_cc_list'])){

            foreach ($get_data['bundle_cc_list'] as $v_c){
                $bundle_trking_no = $v_c['bundle_tracking_no'];

                if($flag==1){
                    $bundle_tracking_no=$bundle_trking_no."clr.";
                }
                if($flag==2){
                    $bundle_tracking_no=$bundle_trking_no."cff.";
                }


                $data['img_url']="";
                if($bundle_tracking_no != '')
                {
                    $this->load->library('ciqrcode');
                    $qr_image=$bundle_tracking_no.'.png';
                    $params['data'] = $bundle_tracking_no;
                    $params['level'] = 'H';
                    $params['size'] = 8;
                    $params['savename'] =FCPATH."uploads/qr_image/".$qr_image;


                    if($this->ciqrcode->generate($params))
                    {
                        $data['img_url']=$qr_image;
                    }
                }
            }
        }

        $data['maincontent'] = $this->load->view('generated_bundle_tag_cc', $get_data);
    }

    public function printBundleTicketOthers($po_no, $so_no, $cut_tracking_no){
        $data['title'] = 'Bundle Ticket Parts';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $data['po_no'] = $po_no;
        $data['so_no'] = $so_no;
        $data['cut_tracking_no'] = $cut_tracking_no;

        $data['bundle_ticket_part']=$this->access_model->search_bundle_ticket_other_part($po_no);


        $data['maincontent'] = $this->load->view('bundle_ticket_other_parts', $data, true);
        $this->load->view('master', $data);
    }

    public function generateBundleTicketOtherParts($part_name, $po_no, $so_no, $cut_tracking_no){

//        $get_data['part_name'] = $this->input->post('part_name');
//        $cut_tracking_no = $this->input->post('cut_tracking_no');
        $get_data['part_name'] = $part_name;
        $get_data['po_no'] = $po_no;
        $get_data['so_no'] = $so_no;
        $get_data['cut_tracking_no'] = $cut_tracking_no;

        $get_data['bundle_others_list'] = $this->access_model->getBundleSummaryInfo($po_no, $so_no, $cut_tracking_no);

        if(!empty($get_data['bundle_others_list'])){

            foreach ($get_data['bundle_others_list'] as $v_c){
                $bundle_trking_no = $v_c['bundle_tracking_no'];

                if($part_name=='collar_outer'){
                    $bundle_tracking_no = $bundle_trking_no.'clr.';
                }
                if($part_name=='cuff_outer'){
                    $bundle_tracking_no = $bundle_trking_no.'cff.';
                }
                if($part_name=='back'){
                    $bundle_tracking_no = $bundle_trking_no.'bck.';
                }
                if($part_name=='yoke_upper'){
                    $bundle_tracking_no = $bundle_trking_no.'yok.';
                }
                if($part_name=='sleeve_r'){
                    $bundle_tracking_no = $bundle_trking_no.'slv.';
                }
                if($part_name=='slv_plkt_r'){
                    $bundle_tracking_no = $bundle_trking_no.'spt.';
                }
                if($part_name=='pocket'){
                    $bundle_tracking_no = $bundle_trking_no.'pkt.';
                }

                $data['img_url']="";
                if($bundle_tracking_no != '')
                {
                    $this->load->library('ciqrcode');
                    $qr_image=$bundle_tracking_no.'.png';
                    $params['data'] = $bundle_tracking_no;
                    $params['level'] = 'H';
                    $params['size'] = 8;
                    $params['savename'] =FCPATH."uploads/qr_image/".$qr_image;

                    if($this->ciqrcode->generate($params))
                    {
                        $data['img_url']=$qr_image;
                    }
                }
            }
        }

        $data['maincontent'] = $this->load->view('generated_bundle_tag_others', $get_data);
    }

    public function getBundleInfoDetail($po_no, $bundle_tracking_no){
        $get_data = $this->access_model->getBundleInfoDetail($po_no, $bundle_tracking_no);

        return $get_data;
    }

    public function printSticker($carelabel_tracking_no, $po, $item, $color, $size){

        if($carelabel_tracking_no != '')
        {
            $this->load->library('ciqrcode');
            $qr_image=$carelabel_tracking_no.'.png';
            $params['data'] = $carelabel_tracking_no;
            $params['level'] = 'H';
            $params['size'] = 8;
            $params['savename'] =FCPATH."uploads/qr_image/".$qr_image;


            if($this->ciqrcode->generate($params))
            {
                $data['img_url']=$qr_image;
            }
        }

        $data['cl_no_file'] = $carelabel_tracking_no.'.png';
        $data['cl_no'] = $carelabel_tracking_no;
        $data['po'] = $po;
        $data['item'] = $item;
        $data['color'] = $color;
        $data['size'] = $size;

        $data['maincontent'] = $this->load->view('print_sticker_cl', $data);
    }

    public function getForm(){
        $data['sap_no'] = $this->input->post('sap_no');

        $data['sizes'] = $this->access_model->getSizesBySapNo($data['sap_no']);

        $data['po_item'] = $this->access_model->getPoItemBySapNo($data['sap_no']);

        $data['po_item_size_cut_qty'] = $this->access_model->getSizeWisePoItemCutQty($data['sap_no']);

        echo $this->load->view('cutting_form', $data, true);
    }

    public function getSizeWisePoItemCutQty($sap_no, $so_no, $purchase_no, $item, $quality, $color){
        return $data['po_item_size_cut_qty'] = $this->access_model->getSizeWisePoItemCutQty($sap_no, $so_no, $purchase_no, $item, $quality, $color);
    }

    public function getSizeWisePoItemRemainCutQty($sap_no, $purchase_no, $item, $size){
        return $data['po_item_size_cut_qty'] = $this->access_model->getSizeWisePoItemRemainCutQty($sap_no, $purchase_no, $item, $size);
    }

    public function getPoItemSizeOrderQty(){
        $sap_no = $this->input->post('sap_no');
        $so_no = $this->input->post('so_no');
        $purchase_order = $this->input->post('po_no');
        $size = $this->input->post('size');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');

        $size_res_order_qty = $this->access_model->getSizeWisePoItemCutQtyBySize($sap_no, $so_no, $purchase_order, $item, $quality, $color, $size);

        echo json_encode($size_res_order_qty);
    }

    public function getSapInfo(){
        $sap_no = $this->input->post('sap_no');

        $po_item = $this->access_model->getPoItemBySapNo($sap_no);

        echo json_encode($po_item);
    }

    public function getCutInfo(){
        $sap_no = $this->input->post('sap_no');
        $cut_no = $this->input->post('cut_no');

        $cut_info = $this->access_model->getSAPCutInfoQty($sap_no, $cut_no);

        echo json_encode($cut_info);
    }

    public function care_label_end_line(){
        $data['title'] = 'End Line QC';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');
        $data['msg'] = '';

        $data['maincontent'] = $this->load->view('care_label_end_line', $data, true);
        $this->load->view('master', $data);
    }

    public function group_po_item_making(){
        $data['title'] = 'Group Making PO-Item';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');
        $data['msg'] = '';

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
        $data['so_list'] = $this->access_model->getAllSOs();
        $data['po_list'] = $this->access_model->getAllPOs();
        $data['item_list'] = $this->access_model->getAllItems();
        $data['style_list'] = $this->access_model->getAllStyles();
        $data['quality_list'] = $this->access_model->getAllQuality();
        $data['color_list'] = $this->access_model->getAllColor();

        $data['maincontent'] = $this->load->view('group_po_item_making', $data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function isValidSo(){
        $po_no = $this->input->post('po_no');

        $is_po_no_valid = $this->access_model->isValidSo($po_no);

        echo json_encode($is_po_no_valid);
    }

    public function isValidPo(){
        $sales_order = $this->input->post('sales_order');
        $purchase_order = $this->input->post('purchase_order');

        $is_purchase_order_valid = $this->access_model->isValidPo($sales_order, $purchase_order);

        echo json_encode($is_purchase_order_valid);
    }

    public function checkPcNoValidity(){
        $pc_no = $this->input->post('pc_no');
        $res = $this->access_model->getCareLabelShirtInfo($pc_no);

        if(sizeof($res) > 0){
            echo 'valid';
        }else{
            echo 'invalid';
        }
    }

    public function isValidItem(){
        $sales_order = $this->input->post('sales_order');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');

        $is_purchase_order_item_valid = $this->access_model->isValidItem($sales_order, $purchase_order, $item);

        echo json_encode($is_purchase_order_item_valid);
    }

    public function getSizeBySo()
    {
        $so_no = $this->input->post('so_no');

        $res = $this->access_model->getSizeBySo($so_no);

        $option = '';
        $option .= '<option value="">Select Cut No</option>';
        foreach ($res as $v){
            $option .= '<option value="'.$v['cut_no'].'">'.$v['cut_no'].'</option>';
        }

        echo $option;
    }

    public function makeGroupPoItem(){
        $sales_orders = $this->input->post('sales_orders');
        $purchase_orders = $this->input->post('purchase_order');
        $items = $this->input->post('items');

        $prefix = substr($sales_orders[0], 0, -2);

        foreach ($sales_orders as $k => $v){
            $postfix = substr($v, -2);

            $prefix .= $postfix;
        }

        $where = '';

        foreach ($sales_orders as $k_1 => $v_1){
            $so = $v_1;
            $purchase_order = $purchase_orders[$k_1];
            $item = $items[$k_1];

            if($so != ''){
                $where .= " AND so_no = '$so'";
            }

            if($purchase_order != ''){
                $where .= " AND purchase_order = '$purchase_order'";
            }

            if($item != ''){
                $where .= " AND item = '$item'";
            }

            $this->access_model->updateSOofPoItem($where, $prefix);
            $this->access_model->updateCutSummarySOofPoItem($where, $prefix);
            $this->access_model->updateCareLabelsSOofPoItem($where, $prefix);

            $where = '';
        }

        $data['message'] = $prefix;
        $this->session->set_userdata($data);
        redirect('access/group_po_item_making');
    }

    public function changeExfactory()
    {
        $data['title'] = 'Change Ex-Factory';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
        $data['so_nos'] = $this->access_model->getAllSOs();
        $data['maincontent'] = $this->load->view('change_ex_factory', $data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function getExfactory()
    {
        $so_no=$this->input->post('so_no');

        $res=$this->access_model->getExfactory($so_no);
        echo json_encode($res);
    }

    public function changingExfactory(){
        $so_no=$this->input->post('so_no');
        $target_exfac=$this->input->post('target_exfactory');
        $date = explode('-', $target_exfac);
        $year=$date[2];
        $month=$date[0];
        $day=$date[1];
        $target_date=$year.'-'.$month.'-'.$day;
        $this->access_model->updateExfacOnPoDetail($so_no, $target_date);
        $this->access_model->updateExfacOnCarelabel($so_no, $target_date);
        $this->access_model->updateExfacOnCutSumamry($so_no, $target_date);
        $data['message']='Ex-Factory Updated Successfully!';
        $this->session->set_userdata($data);
        redirect('access/changeExfactory');
    }

    public function poSizeUpdate()
    {
        $data['title'] = 'PO Update';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
            $data['so_nos'] = $this->access_model->getAllSOs();
            $data['maincontent'] = $this->load->view('po_size_update', $data, true);
            $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function getPoSizeQty(){
        $so_no = $this->input->post('so_no');

        $res = $this->access_model->selectTableData('id, size, quantity', 'tb_po_detail', 'so_no', $so_no);

        $tr = '';

        foreach ($res as $v){
            $tr .= '<tr><td class="center">'.$v['size'].'<input type="hidden" value="'.$v['id'].'" name="id[]" /></td><td class="center"><input type="number" class="" value="'.$v['quantity'].'" name="qty[]" /></td></tr>';
        }

        echo $tr;
    }

    public function savePONewSizeQty(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $user_id = $this->session->userdata('id');

        $so_no = $this->input->post('so_no');
        $size = $this->input->post('size');
        $quantity = $this->input->post('quantity');

        $where = "";
        if($so_no != ''){
            $where .= " AND so_no = '$so_no'";
        }

        $po_detail = $this->access_model->getPoDetail($where);

        $data = array(
            'po_no' => $po_detail[0]['po_no'],
            'so_no' => $po_detail[0]['so_no'],
            'purchase_order' => $po_detail[0]['purchase_order'],
            'brand' => $po_detail[0]['brand'],
            'item' => $po_detail[0]['item'],
            'style_no' => $po_detail[0]['style_no'],
            'style_name' => $po_detail[0]['style_name'],
            'quality' => $po_detail[0]['quality'],
            'color' => $po_detail[0]['color'],
            'smv' => $po_detail[0]['smv'],
            'quantity' => $quantity,
            'size' => $size,
            'ex_factory_date' => $po_detail[0]['ex_factory_date'],
            'crd_date' => $po_detail[0]['crd_date'],
            'created_on' => $date,
            'u_id' => $user_id,
            'is_manual_upload' => $po_detail[0]['is_manual_upload'],
            'upload_date' => $date,
            'status' => $po_detail[0]['status'],
            'po_type' => $po_detail[0]['po_type'],
            'aql_plan_date' => $po_detail[0]['aql_plan_date'],
            'aql_status' => $po_detail[0]['aql_status'],
            'aql_action_date' => $po_detail[0]['aql_action_date'],
            'aql_remarks' => $po_detail[0]['aql_remarks'],
            'aql_action_by' => $po_detail[0]['aql_action_by']
        );

        $this->access_model->insertingData('tb_po_detail', $data);

        echo 'done';
    }

    public function isPoSizeExists(){
        $so_no = $this->input->post('so_no');
        $size = $this->input->post('size');

        $where = "";
        if($so_no != '' && $size != ''){
            $where .= " AND so_no='$so_no' AND size='$size'";
        }

        $res = $this->access_model->getPoDetail($where);

        if(sizeof($res) > 0){
            echo 'yes';
        }else{
            echo 'no';
        }
    }

    public function updatingPoSizeQty(){
        $so_no = $this->input->post('so_no');
        $ids = $this->input->post('id');
        $qtys = $this->input->post('qty');

        foreach ($ids as $k => $id){
            $data = array(
                'quantity' => $qtys[$k]
            );

            $this->access_model->updateTbl('tb_po_detail', $id, $data);
        }

        $data_1['purchase_order'] = $this->input->post('purchase_order');
        $data_1['item'] = $this->input->post('item');
        $data_1['quality'] = $this->input->post('quality');
        $data_1['color'] = $this->input->post('color');
        $data_1['style_no'] = $this->input->post('style_no');
        $data_1['style_name'] = $this->input->post('style_name');
        $ex_factory_dt_1 = $this->input->post('ex_fac_date');
        $ex_factory_date_1 = explode('-', $ex_factory_dt_1);
        $ex_year_1=$ex_factory_date_1[2];
        $ex_month_1=$ex_factory_date_1[0];
        $ex_day_1=$ex_factory_date_1[1];
        $data_1['ex_factory_date']=$ex_year_1.'-'.$ex_month_1.'-'.$ex_day_1;

        $crd_dt = $this->input->post('crd_date');
        $crd_date = explode('-', $crd_dt);
        $year=$crd_date[2];
        $month=$crd_date[0];
        $day=$crd_date[1];
        $data_1['crd_date']=$year.'-'.$month.'-'.$day;
        $this->access_model->updateTblNew('tb_po_detail', 'so_no', $so_no, $data_1);


        $data_2['purchase_order'] = $this->input->post('purchase_order');
        $data_2['item'] = $this->input->post('item');
        $data_2['quality'] = $this->input->post('quality');
        $data_2['color'] = $this->input->post('color');
        $data_2['style_no'] = $this->input->post('style_no');
        $data_2['style_name'] = $this->input->post('style_name');
        $ex_factory_dt_2 = $this->input->post('ex_fac_date');
        $ex_factory_date_2 = explode('-', $ex_factory_dt_2);
        $ex_year_2=$ex_factory_date_2[2];
        $ex_month_2=$ex_factory_date_2[0];
        $ex_day_2=$ex_factory_date_2[1];
        $data_2['ex_factory_date']=$ex_year_2.'-'.$ex_month_2.'-'.$ex_day_2;
        $this->access_model->updateTblNew('tb_cut_summary', 'so_no', $so_no, $data_2);


        $data_3['purchase_order'] = $this->input->post('purchase_order');
        $data_3['item'] = $this->input->post('item');
        $data_3['quality'] = $this->input->post('quality');
        $data_3['color'] = $this->input->post('color');
        $data_3['style_no'] = $this->input->post('style_no');
        $data_3['style_name'] = $this->input->post('style_name');
        $ex_factory_dt_3 = $this->input->post('ex_fac_date');
        $ex_factory_date_3 = explode('-', $ex_factory_dt_3);
        $ex_year_3=$ex_factory_date_3[2];
        $ex_month_3=$ex_factory_date_3[0];
        $ex_day_3=$ex_factory_date_3[1];
        $data_3['ex_factory_date']=$ex_year_3.'-'.$ex_month_3.'-'.$ex_day_3;
        $this->access_model->updateTblNew('tb_care_labels', 'so_no', $so_no, $data_3);

        $data['message'] = "$so_no Successfully Updated!";
        $this->session->set_userdata($data);
        redirect('access/poSizeUpdate');
    }

    public function deletePO(){
        $so_no = $this->input->post('so_no');

        $this->access_model->deleteTableData('tb_po_detail', 'so_no', $so_no);
        $this->access_model->deleteTableData('tb_cut_summary', 'so_no', $so_no);
        $this->access_model->deleteTableData('tb_care_labels', 'so_no', $so_no);

        echo 'done';
    }

    public function care_label_end_line_new(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $previous_date = $datex->modify("-1 days")->format('Y-m-d');
//        $previous_date = '2020-07-14';

        $s_data['session_last_action_date_time'] = $date_time;
        $this->session->set_userdata($s_data);

//        echo '<pre>';
//        print_r($previous_date);
//        echo '</pre>';
//        die();

        $data['title'] = 'End Line QC';

        $line_id = $this->session->userdata('line_id');
        $data['line_id'] = $line_id;
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');
        $data['msg'] = '';
        $data['session_out'] = $this->session_out;

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {

            $where = '';

            if($line_id != ''){
                $where .= " AND line_id=$line_id";
            }

            $last_day_summary_check = $this->dashboard_model->getLineReport($previous_date, $where);

//            echo '<pre>';
//            print_r($last_day_summary_check);
//            echo '</pre>';
//            die();

            if(sizeof($last_day_summary_check) > 0){

                $res = $this->access_model->isReadyTodayLineOutputTable($line_id, $date);

                if(sizeof($res) == 0){
                    $this->access_model->deleteTodayLineOutputTable($line_id);

                    $hours = $this->access_model->getHours();

                    $h_data = array(
                        'id' => 11,
                        'hour' => 11,
                        'start_time' => "19:00:00",
                        'end_time' => "23:59:59",
                        'u_id' => 0
                    );

                    array_push($hours, $h_data);

                    foreach ($hours as $v_h){

                        $h_data = array(
                            'line_id' => $line_id,
                            'date' => $date,
                            'start_time' => $v_h['start_time'],
                            'end_time' => $v_h['end_time'],
                            'qty' => 0
                        );


                        $this->access_model->insertingData('tb_today_line_output_qty', $h_data);
                    }

                }

    //            $where = '';
    //            if($line_id != 0 && $line_id != ''){
    //                $where .= " AND t5.line_id=$line_id order by t3.max_end_line_qc_date_time DESC";
    //            }

    //          $data['prod_summary'] = $this->access_model->getProducitonSummaryReport();
    //          $data['prod_summary'] = $this->access_model->getProducitonSummaryReportFilter($where);


            }else{
                $this->getBackupLineLastDayProduction($line_id, $previous_date);

                $res = $this->access_model->isReadyTodayLineOutputTable($line_id, $date);

                if(sizeof($res) == 0){
                    $this->access_model->deleteTodayLineOutputTable($line_id);

                    $hours = $this->access_model->getHours();

                    $h_data = array(
                        'id' => 11,
                        'hour' => 11,
                        'start_time' => "19:00:00",
                        'end_time' => "23:59:59",
                        'u_id' => 0
                    );

                    array_push($hours, $h_data);

                    foreach ($hours as $v_h){

                        $h_data = array(
                            'line_id' => $line_id,
                            'date' => $date,
                            'start_time' => $v_h['start_time'],
                            'end_time' => $v_h['end_time'],
                            'qty' => 0
                        );


                        $this->access_model->insertingData('tb_today_line_output_qty', $h_data);
                    }

                }
            }

            $data['maincontent'] = $this->load->view('care_label_end_line_new', $data, true);
            $this->load->view('master', $data);
        }else{
            echo $this->load->view('404');
        }
    }

    public function getBackupLineLastDayProduction($line_id, $previous_date){

        $line_output = 0;
        $total_line_output = 0;

        $time_range = $this->dashboard_model->getWorkingTimeRange();

        $starting_time = $time_range[0]['starting_time'];
        $ending_time = $time_range[0]['ending_time'];

        $where_seg = "";
        if($starting_time != '' && $ending_time != ''){
            $where_seg .= "  ORDER BY id DESC LIMIT 1";
        }

        $segments = $this->dashboard_model->getSegments($where_seg);
        $start_time = $segments[0]['start_time'];
        $end_time = $segments[0]['end_time'];


        $where_t = '';
        if($line_id != ''){
            $where_t .= " AND line_id=$line_id";
        }

        if($previous_date != ''){
            $where_t .= " AND date='$previous_date'";
        }

        $line_target_info = $this->access_model->getLineTarget($where_t);

        $man_power_1 = ($line_target_info[0]['man_power_1'] > 0 ? $line_target_info[0]['man_power_1'] : 0);
        $man_power_2 = ($line_target_info[0]['man_power_2'] > 0 ? $line_target_info[0]['man_power_2'] : 0);
        $man_power_3 = ($line_target_info[0]['man_power_3'] > 0 ? $line_target_info[0]['man_power_3'] : 0);
        $man_power_4 = ($line_target_info[0]['man_power_4'] > 0 ? $line_target_info[0]['man_power_4'] : 0);

        $hour_ranges = $this->access_model->getHours();
        foreach ($hour_ranges as $h){
            $line_pre_info = $this->access_model->getLineOutputReport($line_id, $previous_date, $h['start_time'], $h['end_time']);

            foreach ($line_pre_info as $lpi){
                $line_output += $lpi['qty'];
            }

        }
        $line_target = $line_pre_info[0]['target'];

        $produce_minute_1 = ($line_pre_info[0]['produce_minute_1'] > 0 ? $line_pre_info[0]['produce_minute_1'] : 0);
        $produce_minute_2 = ($line_pre_info[0]['produce_minute_2'] > 0 ? $line_pre_info[0]['produce_minute_2'] : 0);
        $produce_minute_3 = ($line_pre_info[0]['produce_minute_3'] > 0 ? $line_pre_info[0]['produce_minute_3'] : 0);
        $produce_minute_4 = ($line_pre_info[0]['produce_minute_4'] > 0 ? $line_pre_info[0]['produce_minute_4'] : 0);

        $work_hour_1 = ($line_pre_info[0]['work_hour_1'] > 0 ? $line_pre_info[0]['work_hour_1'] : 0);
        $work_hour_2 = ($line_pre_info[0]['work_hour_2'] > 0 ? $line_pre_info[0]['work_hour_2'] : 0);
        $work_hour_3 = ($line_pre_info[0]['work_hour_3'] > 0 ? $line_pre_info[0]['work_hour_3'] : 0);
        $work_hour_4 = ($line_pre_info[0]['work_hour_4'] > 0 ? $line_pre_info[0]['work_hour_4'] : 0);

        $work_minute_1 = ($line_pre_info[0]['work_minute_1'] > 0 ? $line_pre_info[0]['work_minute_1'] : 0);
        $work_minute_2 = ($line_pre_info[0]['work_minute_2'] > 0 ? $line_pre_info[0]['work_minute_2'] : 0);
        $work_minute_3 = ($line_pre_info[0]['work_minute_3'] > 0 ? $line_pre_info[0]['work_minute_3'] : 0);
        $work_minute_4 = ($line_pre_info[0]['work_minute_4'] > 0 ? $line_pre_info[0]['work_minute_4'] : 0);
        $avg_of_work_hour=round(((($work_minute_1+$work_minute_2+$work_minute_3+$work_minute_4) / 60) / $man_power_1), 2);

        $line_remarks = $line_pre_info[0]['remarks'];
        $line_efficiency = $line_pre_info[0]['efficiency'];

        $extra_line_qty = $this->access_model->getLineOutputReport($line_id, $previous_date, $start_time, $end_time);
        $over_time_qty = $extra_line_qty[0]['qty'];


        $line_dhu = $this->access_model->getLineDhuSumReport($line_id, $previous_date);
        $line_sum_dhu = $line_dhu[0]['sum_dhu'];

        $average_dhu = round(($line_sum_dhu/$avg_of_work_hour), 2);
        if($line_remarks != ''){
            $remarks = $line_remarks;
        }else{
            $remarks = '';
        }

        $total_line_output = ($line_output + $over_time_qty);

        $data_l = array(

            'line_id' => $line_id,
            'target' => ($line_target != '' ? $line_target : 0),
            'normal_output' => ($line_output != 0 ? $line_output : 0),
            'eot_output' => ($over_time_qty != '' ? $over_time_qty : 0),
            'output' => ($total_line_output != '' ? $total_line_output : 0),
            'work_hour' => ($avg_of_work_hour != '' ? $avg_of_work_hour : 0),
            'efficiency' => ($line_efficiency != '' ? $line_efficiency : 0),
            'dhu' => ($average_dhu != '' ? $average_dhu : 0),
            'date' => $previous_date,
            'man_power_1' => $man_power_1,
            'produce_minute_1' => $produce_minute_1,
            'work_minute_1' => $work_minute_1,
            'work_hour_1' => $work_hour_1,
            'man_power_2' => $man_power_2,
            'produce_minute_2' => $produce_minute_2,
            'work_minute_2' => $work_minute_2,
            'work_hour_2' => $work_hour_2,
            'man_power_3' => $man_power_3,
            'produce_minute_3' => $produce_minute_3,
            'work_minute_3' => $work_minute_3,
            'work_hour_3' => $work_hour_3,
            'man_power_4' => $man_power_4,
            'produce_minute_4' => $produce_minute_4,
            'work_minute_4' => $work_minute_4,
            'work_hour_4' => $work_hour_4,
            'remarks' => $remarks

        );

        if($line_output != 0 && $line_output != ''){
            $this->dashboard_model->insertTblData('tb_daily_line_summary', $data_l);
        }

    }

    public function lineFinishingAlter(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $s_data['session_last_action_date_time'] = $date_time;
        $this->session->set_userdata($s_data);

        $data['title'] = 'Line-Finishing Alter';

        $line_id = $this->session->userdata('line_id');
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');
        $data['msg'] = '';
        $data['session_out'] = $this->session_out;

        $data['maincontent'] = $this->load->view('line_finishing_alter', $data, true);
        $this->load->view('master', $data);
    }

    public function lineFinishingAlterDone(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $s_data['session_last_action_date_time'] = $date_time;
        $this->session->set_userdata($s_data);

        $data['title'] = 'Line-Finishing Alter';

        $line_id = $this->session->userdata('line_id');

        $carelabel_tracking_no = $this->input->post('carelabel_tracking_no');

        $res = $this->access_model->checkCareLabelInfo($carelabel_tracking_no);

        $finishing_qc_status = $res[0]['finishing_qc_status'];
        $responsible_line_id = $res[0]['line_id'];

        if($responsible_line_id == $line_id){
            if($finishing_qc_status == 2){

                $this->access_model->updateLineFinishingAlter($carelabel_tracking_no, $date_time);

                echo "Successfully Updated";
            }else{
                echo "No Alter Request Found";
            }
        }else{
            echo "Line Mismatch";
        }

    }

    public function care_label_finishing(){
        $data['title'] = 'Finishing QC';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');
        $data['msg'] = '';

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
        $data['prod_summary'] = $this->access_model->getProducitonSummaryReport();

        $data['maincontent'] = $this->load->view('care_label_finishing', $data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function care_label_mid_line_new(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $s_data['session_last_action_date_time'] = $date_time;
        $this->session->set_userdata($s_data);

        $data['title'] = 'Mid Line QC';

        $line_id = $this->session->userdata('line_id');
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');
        $data['msg'] = '';
        $data['session_out'] = $this->session_out;

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
        $where = '';
        if($line_id != 0 && $line_id != ''){
            $where .= " AND t5.line_id=$line_id order by t3.max_mid_line_qc_date_time DESC";
        }

//        $data['prod_summary'] = $this->access_model->getProducitonSummaryReport();
//        $data['prod_summary'] = $this->access_model->getProducitonSummaryReportFilter($where);

        $data['maincontent'] = $this->load->view('care_label_mid_line_new', $data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function care_label_mid_line(){
        $data['title'] = 'Mid Line QC';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');
        $data['msg'] = '';

        $data['maincontent'] = $this->load->view('care_label_mid_line', $data, true);
        $this->load->view('master', $data);
    }

    public function care_label_end_line_qc(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $access_points_status = $this->input->post('access_points_status');
        $access_points = $this->session->userdata('access_points');
        $line = $this->session->userdata('line_id');

        $carelabel_tracking_no = $this->input->post('care_label_no');

        $line_check = $this->access_model->lineValidation($carelabel_tracking_no);
        $line_id = $line_check[0]['line_id'];
        $last_access_points = $line_check[0]['access_points'];
        $last_access_points_status = $line_check[0]['access_points_status'];

        if($line == $line_id){
            if(($last_access_points == 3) && ($last_access_points_status == 1)){
                $this->access_model->endLineQC($carelabel_tracking_no, $access_points, $access_points_status, $date_time);
                echo '<h4 style="color: green;">Successfully Passed!</h4>';
            }elseif (($last_access_points == $access_points) && ($last_access_points_status == 2)){
                $this->access_model->endLineQC($carelabel_tracking_no, $access_points, $access_points_status, $date_time);
                echo '<h4 style="color: green;">Successfully Passed!</h4>';
            }elseif (($last_access_points == $access_points) && ($last_access_points_status == 3)){
                $this->access_model->endLineQC($carelabel_tracking_no, $access_points, $access_points_status, $date_time);
                echo '<h4 style="color: green;">Successfully Passed!</h4>';
            }
            elseif (($last_access_points == $access_points) && ($last_access_points_status == 1)){
                echo '<h4 style="color: green;">Already Passed!</h4>';
            }
            elseif ($last_access_points > $access_points){
                echo '<h4 style="color: red;">This Process already passed!</h4>';
            }
            else{
                echo '<h4 style="color: red;">Previous process in WIP!</h4>';
            }
        }else{
            echo '<h4 style="color: red;">Line mismatch found!</h4>';
        }
    }

    public function care_label_mid_line_qc(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $access_points_status = $this->input->post('access_points_status');
        $access_points = $this->session->userdata('access_points');
        $line = $this->session->userdata('line_id');

        $carelabel_tracking_no = $this->input->post('care_label_no');

        $line_check = $this->access_model->lineValidation($carelabel_tracking_no);
        $line_id = $line_check[0]['line_id'];
        $last_access_points = $line_check[0]['access_points'];
        $last_access_points_status = $line_check[0]['access_points_status'];

        if($line == $line_id){
            if(($last_access_points == 2) && ($last_access_points_status == 1)){
                $this->access_model->midLineQC($carelabel_tracking_no, $access_points, $access_points_status, $date_time);
                echo '<h4 style="color: green;">Successfully Passed!</h4>';
            }elseif (($last_access_points == $access_points) && ($last_access_points_status == 2)){
                $this->access_model->midLineQC($carelabel_tracking_no, $access_points, $access_points_status, $date_time);
                echo '<h4 style="color: green;">Successfully Passed!</h4>';
            }elseif (($last_access_points == $access_points) && ($last_access_points_status == 3)){
                $this->access_model->midLineQC($carelabel_tracking_no, $access_points, $access_points_status, $date_time);
                echo '<h4 style="color: green;">Successfully Passed!</h4>';
            }
            elseif (($last_access_points == $access_points) && ($last_access_points_status == 1)){
                echo '<h4 style="color: green;">Already Passed!</h4>';
            }
            elseif ($last_access_points > $access_points){
                echo '<h4 style="color: red;">This Process already passed!</h4>';
            }
            else{
                echo '<h4 style="color: red;">Previous process in WIP!</h4>';
            }
        }else{
            echo '<h4 style="color: red;">Line mismatch found!</h4>';
        }
    }

    public function care_label_mid_line_qc_defect(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $access_points_status = $this->input->post('access_points_status');
        $access_points = $this->session->userdata('access_points');
        $line = $this->session->userdata('line_id');

        $carelabel_tracking_no = $this->input->post('care_label_no');

        $line_check = $this->access_model->lineValidation($carelabel_tracking_no);
        $line_id = $line_check[0]['line_id'];
        $last_access_points = $line_check[0]['access_points'];
        $last_access_points_status = $line_check[0]['access_points_status'];

        if($line == $line_id){
            if(($last_access_points == 2) && ($last_access_points_status == 1)){
                $this->access_model->midLineQC($carelabel_tracking_no, $access_points, $access_points_status, $date_time);
                echo '<h4 style="color: green;">Successful!</h4>';
            }
            elseif (($last_access_points == $access_points) && ($last_access_points_status == 2)){
                echo '<h4 style="color: green;">Already Defect Found!</h4>';
            }
            elseif (($last_access_points == $access_points) && ($last_access_points_status == 1)){
                echo '<h4 style="color: green;">Already Passed!</h4>';
            }
            elseif ($last_access_points > $access_points){
                echo '<h4 style="color: red;">This Process already passed!</h4>';
            }
            else{
                echo '<h4 style="color: red;">Previous process in WIP!</h4>';
            }
        }else{
            echo '<h4 style="color: red;">Line mismatch found!</h4>';
        }
    }

    public function care_label_end_line_qc_defect(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $access_points_status = $this->input->post('access_points_status');
        $access_points = $this->session->userdata('access_points');
        $line = $this->session->userdata('line_id');

        $carelabel_tracking_no = $this->input->post('care_label_no');

        $line_check = $this->access_model->lineValidation($carelabel_tracking_no);
        $line_id = $line_check[0]['line_id'];
        $last_access_points = $line_check[0]['access_points'];
        $last_access_points_status = $line_check[0]['access_points_status'];

        if($line == $line_id){
            if(($last_access_points == 3) && ($last_access_points_status == 1)){
                $this->access_model->endLineQC($carelabel_tracking_no, $access_points, $access_points_status, $date_time);
                echo '<h4 style="color: green;">Successful!</h4>';
            }
            elseif (($last_access_points == $access_points) && ($last_access_points_status == 2)){
                echo '<h4 style="color: green;">Already Defect Found!</h4>';
            }
            elseif (($last_access_points == $access_points) && ($last_access_points_status == 1)){
                echo '<h4 style="color: green;">Already Passed!</h4>';
            }
            elseif ($last_access_points > $access_points){
                echo '<h4 style="color: red;">This Process already passed!</h4>';
            }
            else{
                echo '<h4 style="color: red;">Previous process in WIP!</h4>';
            }
        }else{
            echo '<h4 style="color: red;">Line mismatch found!</h4>';
        }
    }

    public function care_label_mid_line_qc_reject(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $access_points_status = $this->input->post('access_points_status');
        $access_points = $this->session->userdata('access_points');
        $line = $this->session->userdata('line_id');

        $carelabel_tracking_no = $this->input->post('care_label_no');

        $line_check = $this->access_model->lineValidation($carelabel_tracking_no);
        $line_id = $line_check[0]['line_id'];
        $last_access_points = $line_check[0]['access_points'];
        $last_access_points_status = $line_check[0]['access_points_status'];

        if($line == $line_id){
            if(($last_access_points == 2) && ($last_access_points_status == 1)){
                $this->access_model->midLineQC($carelabel_tracking_no, $access_points, $access_points_status, $date_time);
                echo '<h4 style="color: green;">Successful!</h4>';
            }
            elseif (($last_access_points == $access_points) && ($last_access_points_status == 2)){
                $this->access_model->midLineQC($carelabel_tracking_no, $access_points, $access_points_status, $date_time);
                echo '<h4 style="color: green;">Successful!</h4>';
            }
            elseif (($last_access_points == $access_points) && ($last_access_points_status == 3)){
                echo '<h4 style="color: green;">Already Rejected!</h4>';
            }
            elseif (($last_access_points == $access_points) && ($last_access_points_status == 1)){
                echo '<h4 style="color: green;">Already Passed!</h4>';
            }
            elseif ($last_access_points > $access_points){
                echo '<h4 style="color: red;">This Process already passed!</h4>';
            }
            else{
                echo '<h4 style="color: red;">Previous process in WIP!</h4>';
            }
        }else{
            echo '<h4 style="color: red;">Line mismatch found!</h4>';
        }
    }

    public function care_label_end_line_qc_reject(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $access_points_status = $this->input->post('access_points_status');
        $access_points = $this->session->userdata('access_points');
        $line = $this->session->userdata('line_id');

        $carelabel_tracking_no = $this->input->post('care_label_no');

        $line_check = $this->access_model->lineValidation($carelabel_tracking_no);
        $line_id = $line_check[0]['line_id'];
        $last_access_points = $line_check[0]['access_points'];
        $last_access_points_status = $line_check[0]['access_points_status'];

        if($line == $line_id){
            if(($last_access_points == 3) && ($last_access_points_status == 1)){
                $this->access_model->endLineQC($carelabel_tracking_no, $access_points, $access_points_status, $date_time);
                echo '<h4 style="color: green;">Successful!</h4>';
            }
            elseif (($last_access_points == $access_points) && ($last_access_points_status == 2)){
                $this->access_model->endLineQC($carelabel_tracking_no, $access_points, $access_points_status, $date_time);
                echo '<h4 style="color: green;">Successful!</h4>';
            }
            elseif (($last_access_points == $access_points) && ($last_access_points_status == 3)){
                echo '<h4 style="color: green;">Already Rejected!</h4>';
            }
            elseif (($last_access_points == $access_points) && ($last_access_points_status == 1)){
                echo '<h4 style="color: green;">Already Passed!</h4>';
            }
            elseif ($last_access_points > $access_points){
                echo '<h4 style="color: red;">This Process already passed!</h4>';
            }
            else{
                echo '<h4 style="color: red;">Previous process in WIP!</h4>';
            }
        }else{
            echo '<h4 style="color: red;">Line mismatch found!</h4>';
        }
    }

    public function care_label_input_line(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $s_data['session_last_action_date_time'] = $date_time;

        $this->session->set_userdata($s_data);

        $data['title'] = 'CL Line Input';
        $data['session_out'] = $this->session_out;


        $line_id = $this->session->userdata('line_id');
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');
        $data['msg'] = '';

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
//        $where = '';
//        if($line_id != 0 && $line_id != ''){
//            $where .= " AND t5.line_id=$line_id order by t3.max_line_input_date_time desc";
//        }
//
////        $data['prod_summary'] = $this->access_model->getProducitonSummaryReport();
//        $data['prod_summary'] = $this->access_model->getProducitonSummaryReportFilter($where);

        $data['maincontent'] = $this->load->view('care_label_input_line', $data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function line_input_prod_data(){

        $line_id = $this->session->userdata('line_id');
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');
        $data['msg'] = '';

        $where = '';
        if($line_id != 0 && $line_id != ''){
//            $where .= " AND t5.line_id=$line_id order by t3.max_line_input_date_time desc"; //previous logic
            $where .= " order by t1.max_line_input_date_time desc"; //New logic
        }

//        $data['prod_summary'] = $this->access_model->getProducitonSummaryReport();
//        $data['prod_summary'] = $this->access_model->getProducitonSummaryReportFilter($where);    //previous query
//        $data['prod_summary'] = $this->access_model->getProducitonSummaryReportFilterViewTable($line_id, $where);    //New query
        $data['prod_summary'] = $this->access_model->getInputProducitonSummaryReportFilterViewTable($line_id, $where);    //New query

        echo $data['maincontent'] = $this->load->view('line_input_prod_data', $data);
    }

    public function wash(){
        $data['title'] = 'Wash Control';

        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
            $data['purchase_order_nos'] = $this->access_model->getAllPurchaseOrders();

            $data['maincontent'] = $this->load->view('wash_control', $data, true);
            $this->load->view('master', $data);
        }else{
            echo $this->load->view('404');
        }
    }

    public function sms_file_upload(){
        $data['title'] = 'SMS File Upload';

        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $data['maincontent'] = $this->load->view('sms_file_upload', $data, true);
        $this->load->view('master', $data);
    }

    public function smsFileUpload(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');


        $data['created_on'] = $date_time;

        $filename=$_FILES["file"]["tmp_name"];

        if($_FILES["file"]["size"] > 0)
        {
            $file = fopen($filename, "r");
            fgetcsv($file);

            while (!feof($file) ) {
                $line_of_text[] = fgetcsv($file);
            }

        foreach ($line_of_text as $k => $v){
                if($v[0] != '' && $v[4] != '' && $v[8] != '' && $v[3] != ''){

                    $last_4_style = substr($v[4], -4);
                    $last_4_quality = substr($v[2], -4);
                    $year_2_digit = date('y', strtotime($v[9]));

                    $data['po_no'] = $year_2_digit.$v[3].$last_4_quality.$last_4_style;  // YearLast2digit.Color.QualityLast4Digit.StyleLast4Digit
                    $data['so_no'] = $year_2_digit.$v[3].$last_4_quality.$last_4_style;  // YearLast2digit.Color.QualityLast4Digit.StyleLast4Digit
                    $data['purchase_order'] = $v[4];
                    $data['item'] = $v[3];
                    $data['brand'] = $v[0];
                    $data['style_name'] = $v[1];
                    $data['quality'] = $v[2];
                    $data['color'] = $v[3];
                    $data['style_no'] = $v[4];
                    $data['quantity'] = $v[8];
                    $data['ex_factory_date'] = $v[9];

//                    if(($data['brand'] == 'BMC') || ($data['brand'] == 'BMS')){
//                        $data['size'] = 'M';
//                    }
//
//                    if(($data['brand'] == 'BMA')){
//                        $data['size'] = 'L';
//                    }
//
//
//                    if(($data['brand'] == 'HUM')){
//                        $data['size'] = '15.5R';
//                    }

                    if(($data['brand'] == 'BMC') || ($data['brand'] == 'BMS') || ($data['brand'] == 'BMA')){
                        $data['size'] = 'M';
                    }

                    if(($data['brand'] == 'HUGO') || ($data['brand'] == 'BBD')){
                        $data['size'] = '40';
                    }

                    if(($data['brand'] == 'HUM') || ($data['brand'] == 'BMB')){
                        $data['size'] = '15.5R';
                    }
                }

            $insert_info = $this->access_model->insertingData('tb_po_detail', $data);

                echo '<pre>';
                print_r($data);
                echo '</pre>';

        }

            fclose($file);
        }

//        redirect('access/sms_file_upload');

    }

    public function getPoItemDetail(){
        $so_no = $this->input->post('so_no');
        $po_no = $this->input->post('po_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');

        $where = '';
        if($so_no != ''){
            $where .= " AND so_no = '$so_no'";
        }

        if($po_no != ''){
            $where .= " AND po_no = '$po_no'";
        }

        if($purchase_order != ''){
            $where .= " AND purchase_order = '$purchase_order'";
        }

        if($item != ''){
            $where .= " AND item = '$item'";
        }

        if($quality != ''){
            $where .= " AND quality = '$quality'";
        }

        if($color != ''){
            $where .= " AND color = '$color'";
        }

        $po_info = $this->access_model->getPoDetail($where);

        echo json_encode($po_info);
    }

    public function getPoDetail(){
        $so_no = $this->input->post('so_no');
        $po_no = $this->input->post('po_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');

        $where = '';
        if($so_no != ''){
            $where .= " AND so_no = '$so_no'";
        }

        if($po_no != ''){
            $where .= " AND po_no = '$po_no'";
        }

        if($purchase_order != ''){
            $where .= " AND purchase_order = '$purchase_order'";
        }

        if($item != ''){
            $where .= " AND item = '$item'";
        }

        if($quality != ''){
            $where .= " AND quality = '$quality'";
        }

        if($color != ''){
            $where .= " AND color = '$color'";
        }

        $data['po_detail'] = $this->access_model->getPoDetail($where);

        $this->load->view('po_item_detail', $data);
    }

    public function washGmtStatus($sap_no, $so_no, $purchase_order, $item, $quality, $color, $status){

        $where = '';

        if($so_no != ''){
            $where .= " AND so_no = '$so_no'";
        }

        if($sap_no != ''){
            $where .= " AND po_no = '$sap_no'";
        }

        if($purchase_order != ''){
            $where .= " AND purchase_order = '$purchase_order'";
        }

        if($item != '' && $item != 'NA'){
            $where .= " AND item = '$item'";
        }

        if($quality != ''){
            $where .= " AND quality = '$quality'";
        }

        if($color != ''){
            $where .= " AND color = '$color'";
        }


        $res = $this->access_model->updateWashGmtStatus($where, $status);

        $res_1 = $this->access_model->updateWashAllGmtStatus($where, $status);

//        echo '<pre>';
//        print_r($res.' - '.$res_1);
//        echo '</pre>';
//        die();

        if($res==1 && $res_1==1){
            redirect('access/wash');
        }else{
            echo '<script> alert("Failed! Try Again Please!"); window.location="'.base_url().'access/wash";</script>';
        }

    }

    public function care_label_washing(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $s_data['session_last_action_date_time'] = $date_time;
        $this->session->set_userdata($s_data);

        $data['title'] = 'Wash Return';

        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');
        $data['msg'] = '';
        $data['session_out'] = $this->session_out;

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
//        $condition = '';
//        if($data['access_points'] == 6){
//            $condition .= " ORDER BY t10.max_washing_date_time DESC";
//            $data['prod_summary'] = $this->access_model->getProducitonSummaryReportWash($condition);
//        }else{
//            $data['prod_summary'] = $this->access_model->getProducitonSummaryReport();
//        }


        $data['maincontent'] = $this->load->view('care_label_washing', $data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function care_label_going_wash(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $s_data['session_last_action_date_time'] = $date_time;
        $this->session->set_userdata($s_data);

        $data['title'] = 'Wash';

        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');
        $data['msg'] = '';
        $data['session_out'] = $this->session_out;

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
//        $condition = '';
//        if($data['access_points'] == 6){
//            $condition .= " ORDER BY t10.max_washing_date_time DESC";
//            $data['prod_summary'] = $this->access_model->getProducitonSummaryReportWash($condition);
//        }else{
//            $data['prod_summary'] = $this->access_model->getProducitonSummaryReport();
//        }


        $data['maincontent'] = $this->load->view('care_label_going_wash', $data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function wash_return_data(){
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');
        $data['msg'] = '';

        $condition = '';
        if($data['access_points'] == 6){
//            $condition .= " ORDER BY t10.max_washing_date_time DESC";  // Previous Query Condition
            $condition .= " ORDER BY t1.max_washing_date_time DESC";
//            $data['prod_summary'] = $this->access_model->getProducitonSummaryReportWash($condition); // Previous Query
            $data['prod_summary'] = $this->access_model->getProducitonSummaryReportWashViewTable($condition);
        }else{
            $data['prod_summary'] = $this->access_model->getProducitonSummaryReport();
        }

//        echo $data['maincontent'] = $this->load->view('wash_return_data', $data); // Previous Data View Page
        echo $data['maincontent'] = $this->load->view('wash_return_data_new', $data);
    }

    public function wash_going_data(){
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');
        $data['msg'] = '';

        $condition = '';

//        $condition .= " ORDER BY t10.max_going_wash_scan_date_time DESC"; // Previous Query Condition
        $condition .= " ORDER BY t1.max_going_wash_scan_date_time DESC";
//        $data['prod_summary'] = $this->access_model->getProducitonSummaryReportWashGoing($condition); // Previous Query
        $data['prod_summary'] = $this->access_model->getProducitonSummaryReportWashGoingViewTable($condition);

        echo $data['maincontent'] = $this->load->view('wash_going_data', $data);
    }

    public function finishing_alter(){
        $data['title'] = 'Finishing QC';

        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');
        $data['msg'] = '';


        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
//        $condition = '';
//        if($data['access_points'] == 7){
//            $condition .= " ORDER BY t11.max_packing_date_time DESC";
//            $data['prod_summary'] = $this->access_model->getProducitonSummaryReportFinish($condition);
//        }else{
//            $data['prod_summary'] = $this->access_model->getProducitonSummaryReport();
//        }


        $data['maincontent'] = $this->load->view('care_label_finishing_alter', $data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function finishingAlterSave(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['access_points'] = $this->session->userdata('access_points');
        $floor_id = $this->session->userdata('floor_id');

        $pc_no = $this->input->post('care_label_no');
        $status = $this->input->post('status');

        $pc_no_info = $this->access_model->checkCareLabelInfo($pc_no);

        $access_points = $pc_no_info[0]['access_points'];
        $access_points_status = $pc_no_info[0]['access_points_status'];
        $line = $pc_no_info[0]['line_name'];
        $finishing_qc_status = $pc_no_info[0]['finishing_qc_status'];

        if($line != '' && $access_points==4 && $access_points_status==4){
            if($finishing_qc_status != 2){
                $this->access_model->sendToLineForAlter($pc_no, $floor_id, $status, $date_time);

                if($status == 1){
                    echo "Pass From $line";
                }
                if($status == 2){
                    echo "Sent to $line";
                }

            }elseif ($finishing_qc_status == 2){
                echo "line pending";
            }


        }else{
            echo "";
        }
    }

    public function getPrinterOn()
    {
        $user_id = $this->session->userdata('id');
        $printer_on = $this->access_model->getPrinterOn($user_id);
        echo $printer_on;
    }

    public function getPrinterOff()
    {
        $user_id = $this->session->userdata('id');
        $printer_off = $this->access_model->getPrinterOff($user_id);
        echo $printer_off;
    }

    public function care_label_packing(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $s_data['session_last_action_date_time'] = $date_time;
        $this->session->set_userdata($s_data);

        $data['title'] = 'Packing';

        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');
        $line_id = $this->session->userdata('line_id');
        $floor_id = $this->session->userdata('floor_id');
        $data['floor_id'] = $floor_id;
        $data['msg'] = '';
        $data['session_out'] = $this->session_out;

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
//        $res = $this->access_model->isReadyTodayLineOutputTable($floor_id, $date);
        $res = $this->access_model->isReadyTodayFinishingOutputTable($floor_id, $date);

        if(sizeof($res) == 0){
//            $this->access_model->deleteTodayLineOutputTable($floor_id);
            $this->access_model->deleteTodayFinishingOutputTable($floor_id);

            $hours = $this->access_model->getHours();

            $h_data = array(
                'id' => 11,
                'hour' => 11,
                'start_time' => "19:00:00",
                'end_time' => "23:59:59",
                'u_id' => 0
            );

            array_push($hours, $h_data);

//            echo '<pre>';
//            print_r($hours);
//            echo '</pre>';
//            die();

            foreach ($hours as $v_h){

                $h_data = array(
                    'floor_id' => $floor_id,
                    'date' => $date,
                    'start_time' => $v_h['start_time'],
                    'end_time' => $v_h['end_time'],
                    'qty' => 0
                );


                $this->access_model->insertingData('tb_today_finishing_output_qty', $h_data);
            }

        }





//        $condition = '';
//        if($data['access_points'] == 7){
//            $condition .= " ORDER BY t11.max_packing_date_time DESC";
//            $data['prod_summary'] = $this->access_model->getProducitonSummaryReportFinish($condition);
//        }else{
//            $data['prod_summary'] = $this->access_model->getProducitonSummaryReport();
//        }


        $data['maincontent'] = $this->load->view('care_label_packing', $data, true);
        $this->load->view('master', $data);
        }else{
            echo $this->load->view('404');
        }
    }

    public function packing_data(){
        $user_id = $this->session->userdata('id');
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');
        $data['msg'] = '';

        $user_info = $this->access_model->getUserBrands($user_id);
        $user_brands = $user_info[0]['buyer_condition'];

        $condition = '';
        $condition_1 = '';

        if($data['access_points'] == 7){
            //Previous Query Condition Start
//            $condition .= " ORDER BY t11.max_packing_date_time DESC";
//            $condition_1 .= " AND brand in ($user_brands)";
            //Previous Query Condition End

            $condition .= " ORDER BY t1.max_packing_date_time DESC";
            $condition_1 .= " AND brand in ($user_brands)";

//            $data['prod_summary'] = $this->access_model->getProducitonSummaryReportFinish($condition, $condition_1); //Previous Query
//            $data['prod_summary'] = $this->access_model->getPackingReportViewTable($condition, $condition_1);//test case by kabir
            $data['prod_summary'] = $this->access_model->getPackingReportViewTable( $condition_1);
        }else{
            $data['prod_summary'] = $this->access_model->getProducitonSummaryReport();
        }

        echo $data['maincontent'] = $this->load->view('packing_data', $data);
    }

    public function getFinishingAlterReport(){
        $user_id = $this->session->userdata('id');
        $line_id = $this->session->userdata('line_id');
        $floor_id = $this->session->userdata('floor_id');

        $res = $this->access_model->getUserBrands($user_id);
        $buyer_condition = $res[0]['buyer_condition'];

        $where = '';

        if($floor_id != ''){
            $where .= " AND finishing_floor_id=$floor_id";
        }

        $prod_summary = $this->access_model->getFinishingAlterReport($where);

        $data['prod_summary'] = $prod_summary;

        echo $this->load->view('finishing_alter_report', $data);
    }

    public function getFinishingAlterLineReport(){
        $line_id = $this->session->userdata('line_id');

        $where = '';

        if($line_id != ''){
            $where .= " AND line_id=$line_id";
            $prod_summary = $this->access_model->getFinishingAlterLineReport($where);
        }

        $data['prod_summary'] = $prod_summary;

        echo $this->load->view('finishing_alter_report', $data);
    }

    public function getRemainingFinishingAlterPcs(){
        $line_id = $this->session->userdata('line_id');

        $so_no = $this->input->post('so_no');

        $where = '';
        if($so_no != ''){
            $where .= " AND so_no='$so_no'";
        }
        if($line_id != '' && $line_id != 0){
            $where .= " AND line_id='$line_id'";
        }

        $data['remain_size_cl'] = $this->access_model->getRemainingFinishingAlterPcs($where);

        echo $this->load->view('finishing_alter_cl_list_modal', $data);
    }

    public function care_label_carton(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $s_data['session_last_action_date_time'] = $date_time;
        $this->session->set_userdata($s_data);

        $data['title'] = 'Carton';

        $data['floor_id'] = $this->session->userdata('floor_id');
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');
        $data['msg'] = '';
        $data['session_out'] = $this->session_out;

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
//        $condition = '';
//        if($data['access_points'] == 9){
//            $condition .= " ORDER BY t12.max_carton_date_time DESC";
//            $data['prod_summary'] = $this->access_model->getProducitonSummaryReportFinish($condition);
//        }else{
//            $data['prod_summary'] = $this->access_model->getProducitonSummaryReport();
//        }


        $data['maincontent'] = $this->load->view('care_label_carton', $data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function care_label_carton_data_load(){
        $user_id = $this->session->userdata('id');
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $user_info = $this->access_model->getUserBrands($user_id);

        $user_brands = $user_info[0]['buyer_condition'];

        $condition = '';
        $condition_1 = '';
        if($data['access_points'] == 9){
            //Previous Query Condition Start
//            $condition .= " ORDER BY t12.max_carton_date_time DESC";
//            $condition_1 .= " AND brand in ($user_brands)";
            //Previous Query Condition End

            $condition .= " ORDER BY t1.max_carton_date_time DESC";
//            $condition_1 .= " AND t1.brand in ($user_brands)";
            $condition_1 .= " AND brand in ($user_brands)";//test value by kabir

//            $data['prod_summary'] = $this->access_model->getProducitonSummaryReportFinish($condition, $condition_1);    //Previous Query
//            $data['prod_summary'] = $this->access_model->getProducitonSummaryReportCartonViewTable($condition, $condition_1);
            $data['prod_summary'] = $this->access_model->getProducitonSummaryReportCartonViewTable( $condition_1);//test query by kabir

        }else{
            $data['prod_summary'] = $this->access_model->getProducitonSummaryReport();
        }


//        echo $data['maincontent'] = $this->load->view('carton_prod_data', $data); //Previous Data View Page
        echo $data['maincontent'] = $this->load->view('carton_prod_data_new', $data);
    }

    public function cutting_summary(){
        $data['title'] = 'Cutting Summary';

        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');
        $data['msg'] = '';

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
        $data['sap_no'] = $this->access_model->getSapPoNo();

        $data['maincontent'] = $this->load->view('cutting_summary', $data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function getProductionSummaryReport(){
        $line_id = $this->session->userdata('line_id');
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');
        $data['msg'] = '';

        $where = '';
        $where_1 = '';

        if($data['access_points'] == 3){
            if($line_id != 0 && $line_id != ''){
//                $where .= " AND t5.line_id=$line_id order by t3.max_mid_line_qc_date_time DESC";     // previous logic
                $where .= " order by t2.max_mid_line_qc_date_time DESC";     // New Logic

//                $data['prod_summary'] = $this->access_model->getProducitonSummaryReportFilter($where); // previous query
//                $data['prod_summary'] = $this->access_model->getProducitonSummaryReportFilterViewTable($line_id, $where); // New Query
                $data['prod_summary'] = $this->access_model->getMidProducitonSummaryReportFilterViewTable($line_id, $where); // New Query

                echo $data['maincontent'] = $this->load->view('mid_care_label_line_prod_summary_report', $data);
            }
        }
        elseif($data['access_points'] == 4){
            if($line_id != 0 && $line_id != ''){
//                $where .= " AND t5.line_id=$line_id order by t3.max_end_line_qc_date_time DESC";     // previous logic
                $where .= " order by t3.max_end_line_qc_date_time DESC";     // New Logic

//                $data['prod_summary'] = $this->access_model->getProducitonSummaryReportFilter($where);  // previous query
//                $data['prod_summary'] = $this->access_model->getProducitonSummaryReportFilterViewTable($line_id, $where);  // Previous View query
                $data['prod_summary'] = $this->access_model->getEndProducitonSummaryReportFilterViewTable($line_id, $where);  // New query

                echo $data['maincontent'] = $this->load->view('end_care_label_line_prod_summary_report', $data);
            }
        }

//        elseif ($line_id != 0 && $line_id != ''){
//            $where .= " AND t5.line_id=$line_id order by t3.max_line_input_date_time DESC";
//        }

        elseif($data['access_points'] == 2){
            if($line_id != 0 && $line_id != ''){
                $where .= " AND t5.line_id=$line_id order by t3.max_line_input_date_time DESC";
            }
        }

        elseif($data['access_points'] == 1){
            $planned_line_id = $this->input->post('line_no');

            if($planned_line_id != '' && $planned_line_id != 0){
                $line_info = $this->access_model->getLineInfo($planned_line_id);
                $data['line_name'] = $line_info[0]['line_code'];

                $where_1 .= " AND planned_line_id=$planned_line_id";
            }

            $where .= " ORDER BY t3.cut_prod_date_time DESC";
//            $data['prod_summary'] = $this->access_model->getProducitonSummaryReportCut($where); // Previous Query

            $data['prod_summary'] = $this->access_model->getProducitonSummaryReportCutViewTable($where_1, $where);


            echo $data['maincontent'] = $this->load->view('cutting_sent_to_prod_data', $data);
//            echo $data['maincontent'] = $this->load->view('cutting_sent_to_prod_data_pre', $data); // Previous Data Page
        }

    }

    public function chk_cut_no()
    {
        $purchase_no=$this->input->post('purchase_no');
        $po_no=$this->input->post('po_no');
        $so_no=$this->input->post('so_no');
        $item_no=$this->input->post('item_no');
        $quality=$this->input->post('quality');
        $color=$this->input->post('color');

        $where = '';

        if($po_no != ''){
            $where .= " AND po_no='$po_no'";
        }

        if($so_no != ''){
            $where .= " AND so_no='$so_no'";
        }

        if($purchase_no != ''){
            $where .= " AND purchase_order='$purchase_no'";
        }

        if($item_no != ''){
            $where .= " AND item='$item_no'";
        }

        if($quality != ''){
            $where .= " AND quality='$quality'";
        }

        if($color != ''){
            $where .= " AND color='$color'";
        }

        $chk_cut_no=$this->access_model->chk_cut_no($where);
        if($chk_cut_no)
            $output='';
        {
            $output .= '<option value="">Select Cut No</option>';
            foreach($chk_cut_no as $v_chk){

                $output .= '<option value="'.$v_chk->cut_no.'">'.$v_chk->cut_no.'</option>';

            }
            echo $output;
        }
    }

    public function lineInputReportChart(){
        $data['title'] = 'Line Pass Report';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');
//        $date='2017-12-24';

        $data['date'] = $date;

        $where = '';

        $data['line_report'] = $this->access_model->getLineInputReportForChart($date);

        $this->load->view('line_report', $data);
    }

    public function lineDefectReportChart(){
        $data['title'] = 'Line Defect Report';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');
//        $date='2017-12-24';

        $data['date'] = $date;

        $where = '';

        $data['line_def_report'] = $this->access_model->getLineDefectReportForChart($date);

        $this->load->view('line_defect_report', $data);
    }

    public function change_line(){
        $data['title'] = 'Change Line';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
        $data['so_nos'] = $this->access_model->getAllSOs();
        $data['lines'] = $this->access_model->getLines();
        $data['cut_no'] = $this->access_model->getCutNoList();

        $data['maincontent'] = $this->load->view('change_line', $data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function getAllSizesByCutNo(){
        $so_no = $this->input->post('so_no');
        $cut_no = $this->input->post('cut_no');

        $res = $this->access_model->getAllSizesByCutNo($so_no, $cut_no);

        $option = '';
        $option .= '<option value="">Select Size</option>';
        foreach ($res as $v){
            $option .= '<option value="'.$v['size'].'">'.$v['size'].'</option>';
        }

        echo $option;
    }

    public function getCutSizeWiseGroups(){
        $so_no = $this->input->post('so_no');
        $cut_no = $this->input->post('cut_no');
        $size = $this->input->post('size');

        $res = $this->access_model->getCutSizeWiseGroups($so_no, $cut_no, $size);

        $option = '';
        $option .= '<option value="">Select Group</option>';
        foreach ($res as $v){
            $option .= '<option value="'.$v['cut_layer'].'">'.$v['cut_layer'].'</option>';
        }

        echo $option;
    }

    public function getTotalScannedQty(){

        $so_no = $this->input->post('so_no');
        $cut_no = $this->input->post('cut_no');
        $size = $this->input->post('size');
        $line_no_from = $this->input->post('line_no_from');

        $where = '';

        if($so_no != ''){
            $where .= " AND so_no = '$so_no'";
        }
        if($cut_no != ''){
            $where .= " AND cut_no = '$cut_no'";
        }
        if($size != ''){
            $where .= " AND size = '$size'";
        }
        if($line_no_from != ''){
            $where .= " AND line_id = '$line_no_from' AND access_points != 4 AND access_points_status != 4";
        }

        $res = $this->access_model->getTotalScannedQty($where);


        echo json_encode($res);
    }

    public function changingLinePlan(){
        $so_no = $this->input->post('so_no');
        $cut_no = $this->input->post('cut_no');
        $line_no_from = $this->input->post('line_no_from');
        $line_no_to = $this->input->post('line_no_to');
        $size = $this->input->post('size');
        $group = $this->input->post('group');

        $where = '';

        if($so_no != ''){
            $where .= " AND so_no = '$so_no'";
        }
        if($cut_no != ''){
            $where .= " AND cut_no = '$cut_no'";
        }
        if($size != ''){
            $where .= " AND size = '$size'";
        }
        if($group != ''){
            $where .= " AND layer_group = '$group'";
        }
        if($line_no_from != ''){
            $where .= " AND line_id = '$line_no_from' AND access_points != 4 AND access_points_status != 4";
        }

        $this->access_model->changingLinePlan( $line_no_to, $where);

        $data['message']="Successfully Line Changed!";
        $this->session->set_userdata($data);

        redirect('access/change_line');
    }

    public function bundle_collar_cuff_track(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $s_data['session_last_action_date_time'] = $date_time;
        $this->session->set_userdata($s_data);

        $data['title'] = 'Collar-Cuff Track';
        $data['session_out'] = $this->session_out;

        $line_id = $this->session->userdata('line_id');
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');
        $data['msg'] = '';

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
//        $where = '';
//        if($line_id != 0 && $line_id != ''){
//            $where .= " AND t13.line_id=$line_id";
//        }
//
//        $data['prod_summary'] = $this->access_model->getProducitonSummaryReportForCC($where);
//        $data['prod_summary'] = $this->access_model->getProducitonSummaryReportFilter($where);

        $data['maincontent'] = $this->load->view('bundle_collar_cuff_track', $data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function bundle_collar_cuff_data(){

        $line_id = $this->session->userdata('line_id');
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');
        $data['msg'] = '';

        $where = '';
        if($line_id != 0 && $line_id != ''){
//            $where .= " AND t13.line_id=$line_id"; // Previous Query Condition
            $where .= " AND planned_line_id=$line_id OR line_id=$line_id"; // New Query Condition
        }

//        $data['prod_summary'] = $this->access_model->getProducitonSummaryReportForCC($where); // Previous Query
        $data['prod_summary'] = $this->access_model->getProducitonSummaryReportForCCViewTable($where);
//        $data['prod_summary'] = $this->access_model->getProducitonSummaryReportFilter($where);


//        echo $data['maincontent'] = $this->load->view('bundle_collar_cuff_data', $data); // Previous Query Page
        echo $data['maincontent'] = $this->load->view('bundle_collar_cuff_data_new', $data);
    }

    public function activeClByOPR()
    {
        $data['title'] = 'Search Care Label';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');
        $data['maincontent'] = $this->load->view('active_cl_by_opr_1', $data, true);
        $this->load->view('master', $data);
    }

    public function saveReprintRequest()
    {
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');
        $user_id = $this->session->userdata('id');


        $pc_no = $this->input->post('pc_no');
        $reason = $this->input->post('reason');
        $requested_by_name = $this->input->post('requested_by');


        foreach ($pc_no as $k => $pc) {

            $res = $this->access_model->getCheckClPrintValidation($pc);

            if(sizeof($res) == 0){
                $pc_no1 = $pc;
                $reasons = $reason[$k];
                $request_by_name = $requested_by_name[$k];

                $data=array(
                    'pc_tracking_no' => $pc_no1,
                    'reprint_reason' => $reasons,
                    'referenced_by' => $request_by_name,
                    'request_date_time' => $date_time
                );

                $this->access_model->insertingData('tb_label_reprint_log', $data);
//            $this->access_model->activeCl($pc_no1, $date_time);
            }

        }
        $data['message']='Reprint Request Successful!';
        $this->session->set_userdata($data);

        redirect('access/activeClByOPR');
    }

    public function activeCl()
    {
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');
        $cl_no=$this->input->post('cl_no');
        $this->access_model->activeCl($cl_no, $date_time);
        echo 'success';

    }

    public function getClDetailForActive(){
        $cl_no = $this->input->post('cl_no');
        $care_label_list = $this->access_model->getCareLabelDetailByClNo($cl_no);
        echo json_encode($care_label_list);
    }

    public function reprintRequest()
    {
        $data['title'] = 'Reprint Care Label';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
        $data['reprint_cl'] = $this->access_model->getReprintCl();
        $data['maincontent'] = $this->load->view('reprint_request', $data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function otherLineCollarBundleScanned($po_no, $so_no, $purchase_order, $item, $quality, $color){
        $line_id = $this->session->userdata('line_id');

        return $this->access_model->otherLineCollarBundleScanned($po_no, $so_no, $purchase_order, $item, $quality, $color, $line_id);
    }

    public function otherLineCuffBundleScanned($po_no, $so_no, $purchase_order, $item, $quality, $color){
        $line_id = $this->session->userdata('line_id');

        return $this->access_model->otherLineCuffBundleScanned($po_no, $so_no, $purchase_order, $item, $quality, $color, $line_id);
    }

    public function lineWIPReportChart(){
        $data['title'] = 'Line WIP Report';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');
//        $date='2017-12-24';

        $data['date'] = $date;

        $where = '';

        $data['line_wip_report'] = $this->access_model->lineWIPReportChart();

        $this->load->view('line_wip_report', $data);
    }

    public function linePerformanceDashboard(){
        $data['title'] = 'Line Dashboard';

        $line_id = $this->session->userdata('line_id');
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $where = '';
        $where1 = '';
        $where2 = '';

        $line_target = 0;
        $line_output = 0;

        if($line_id != ''){
            $data['line_id'] = $line_id;
            $data['line_info'] = $this->access_model->getLineInfo($line_id);
            $data['hours'] = $this->access_model->getHours();

            $min_max_hours = $this->access_model->getMinMaxHours();
            $min_start_time = $min_max_hours[0]['min_start_time'];
            $max_end_time = $min_max_hours[0]['max_end_time'];

//            $data['work_time'] = $this->access_model->getWorkingHours($line_id, $date, $min_start_time);
            $data['work_time'] = $this->access_model->getWorkingHoursViewTable($line_id, $date, $min_start_time);
            $data['get_smv_list'] = $this->access_model->getSMVs($line_id, $date);

            $where .= " AND line_id=$line_id AND date='$date'";
//            $line_trgt = $this->access_model->getLineTarget($where);
            $line_trgt = $this->access_model->getLineTargetViewTable($line_id);

            $line_target = $line_trgt[0]['target'];
            $man_power = $line_trgt[0]['man_power'];


            $where1 .= " AND line_id=$line_id  AND access_points_status=4 
                         AND DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') LIKE '%$date%' ";

            $where2 .= " AND planned_line_id=$line_id AND line_id=0";

//            $line_report = $this->access_model->getLineReportForChart($where1);
            $line_report = $this->access_model->getLineOutputReportViewTable($line_id);

//            $data['upcoming_po'] = $this->access_model->getUpcomingPoList($where2);
            $data['upcoming_po'] = $this->access_model->getUpcomingPoListViewTable($where2);

            $line_output = $line_report[0]['count_end_line_qc_pass'];

            $data['line_output'] = $line_output;

            $data['line_target'] = $line_target;

            $data['man_power'] = $man_power;

//            $data['line_status'] = $this->dashboard_model->getLineStatusByLine($line_id, $date);
            $data['line_status'] = $this->dashboard_model->getLineStatusByLineViewTable($line_id, $date);

        }

        $data['maincontent'] = $this->load->view('line_performance_dashboard', $data, true);
        $this->load->view('master_line', $data);
    }

    public function todayLineOutputHourly($line_id, $start_time, $end_time){
//        $line_id = $this->session->userdata('line_id');

        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $where = '';

        if($line_id != '' && $start_time != '' && $end_time != ''){
            $where .= " AND line_id=$line_id 
                        AND date_format(end_line_qc_date_time, '%Y-%m-%d') LIKE '%$date%' 
                        AND date_format(end_line_qc_date_time, '%H:%i:%s') BETWEEN '$start_time' AND '$end_time'";
//            $line_output = $this->access_model->todayLineOutput($where);
            $line_output = $this->access_model->todayLineOutputViewTable($where);
        }

        return $line_output;
    }

    public function lineWIPDetailReport($line, $date){
//        echo '<pre>';
//        print_r("WIP Detail report will be shown here of $line");
//        echo '</pre>';
        $get_data['heading_title'] = 'Line WIP Report';
        $line_info = $this->access_model->getLineId($line);
        $line_id = $line_info[0]['id'];
        $get_data['order_info'] = $this->access_model->lineWipQty($line_id);

        $data['maincontent'] = $this->load->view('all_pcs_line', $get_data);
    }

    public function lineDefectDetailReport($line, $date){
        echo '<pre>';
        print_r("Defect Detail report will be shown here of $line");
        echo '</pre>';
    }

    public function linePassDetailReport($line, $date){
        echo '<pre>';
        print_r("Pass Detail report will be shown here of $line");
        echo '</pre>';
    }

    public function viewClDefects($pc_tracking_no, $line_id, $access_point){
        $data['title'] = "CL Defects List";
        $data['heading_title'] = "$pc_tracking_no - Defects List";

        $data['cl_defect_report'] = $this->access_model->viewClDefects($pc_tracking_no, $line_id, $access_point);

        $data['maincontent'] = $this->load->view('cl_defect_list', $data, true);
        $this->load->view('master', $data);
    }

//    public function all_pcs_line($line_id, $access_point, $access_point_status){
//        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
//        
//        $date_time=$datex->format('Y-m-d H:i:s');
//        $date=$datex->format('Y-m-d');
//
//        if(($access_point == '') and ($access_point_status == '')){
//            $data['title'] = 'Inputted Quantity';
//            $get_data['heading_title'] = 'Inputted Quantity';
//        }
//
//        if(($access_point == 2) and ($access_point_status == 1)){
//            $data['title'] = 'WIP Quantity';
//            $get_data['heading_title'] = 'WIP Quantity';
//        }
//
//        if(($access_point == 3) and ($access_point_status == 1)){
//            $data['title'] = 'Mid-Line Passed Quantity';
//            $get_data['heading_title'] = 'Mid-Line Passed Quantity';
//        }
//
//        if(($access_point == 3) and ($access_point_status == 2)){
//            $data['title'] = 'Mid-Line Defected Quantity';
//            $get_data['heading_title'] = 'Mid-Line Defected Quantity';
//        }
//
//        if(($access_point == 3) and ($access_point_status == 3)){
//            $data['title'] = 'Mid-Line Rejected Quantity';
//            $get_data['heading_title'] = 'Mid-Line Rejected Quantity';
//        }
//
//        if(($access_point == 4) and ($access_point_status == 4)){
//            $data['title'] = 'End-Line Passed Quantity';
//            $get_data['heading_title'] = 'End-Line Passed Quantity';
//        }
//
//        if(($access_point == 4) and ($access_point_status == 2)){
//            $data['title'] = 'End-Line Defected Quantity';
//            $get_data['heading_title'] = 'End-Line Defected Quantity';
//        }
//
//        if(($access_point == 4) and ($access_point_status == 3)){
//            $data['title'] = 'End-Line Rejected Quantity';
//            $get_data['heading_title'] = 'End-Line Rejected Quantity';
//        }
//
//        $data['user_name'] = $this->session->userdata('user_name');
//        $data['access_points'] = $this->session->userdata('access_points');
//
//        $where = '';
//
//        if($line_id != 0){
//            $where .= " AND t1.line_id=$line_id";
//        }
//
//        if(($access_point != '')  && ($access_point != 0)){
//            $where .= " AND t1.access_points=$access_point";
//        }
//
//        if(($access_point_status != '') && ($access_point_status != 0)){
//            $where .= " AND t1.access_points_status=$access_point_status";
//        }
//
//        if(($date != '') && ($date != '1970-01-01')){
//            $where .= " AND DATE_FORMAT(t1.line_input_date_time, '%Y-%m-%d') LIKE '%$date%'";
//        }
//
//        $get_data['order_info'] = $this->access_model->getAllInputedPcsLine($where);
//
//        $data['maincontent'] = $this->load->view('all_pcs_line', $get_data, true);
//        $this->load->view('master', $data);
//    }

    public function lineInputQty($line_id){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');
        $get_data['heading_title'] = 'Line Input Report';
        $get_data['order_info'] = $this->access_model->lineInputQty($line_id, $date);

        $data['maincontent'] = $this->load->view('all_pcs_line', $get_data);
    }

    public function lineWipQty($line_id){
        $get_data['heading_title'] = 'Line WIP Report';
        $get_data['order_info'] = $this->access_model->lineWipQty($line_id);

        $data['maincontent'] = $this->load->view('all_pcs_line', $get_data);
    }

    public function midQcPass($line_id){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $get_data['heading_title'] = 'Mid Line Pass Report';
        $get_data['order_info'] = $this->access_model->midQcPass($line_id, $date);

        $data['maincontent'] = $this->load->view('all_pcs_line', $get_data);
    }

    public function midQcDefects($line_id){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $get_data['heading_title'] = 'Mid Line Defect Report';
        $get_data['order_info'] = $this->access_model->midQcDefects($line_id, $date);

        $data['maincontent'] = $this->load->view('all_pcs_line', $get_data);
    }

    public function midQcRejects($line_id){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $get_data['heading_title'] = 'Mid Line Reject Report';
        $get_data['order_info'] = $this->access_model->midQcRejects($line_id, $date);

        $data['maincontent'] = $this->load->view('all_pcs_line', $get_data);
    }

    public function endQcPass($line_id){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $get_data['heading_title'] = 'End Line Pass Report';
        $get_data['order_info'] = $this->access_model->endQcPass($line_id, $date);

        $data['maincontent'] = $this->load->view('all_pcs_line', $get_data);
    }

    public function endQcDefects($line_id){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $get_data['heading_title'] = 'End Line Defect Report';
        $get_data['order_info'] = $this->access_model->endQcDefects($line_id, $date);

        $data['maincontent'] = $this->load->view('all_pcs_line', $get_data);
    }

    public function endQcRejects($line_id){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $get_data['heading_title'] = 'Mid Line Reject Report';
        $get_data['order_info'] = $this->access_model->endQcRejects($line_id, $date);

        $data['maincontent'] = $this->load->view('all_pcs_line', $get_data);
    }

    public function lineInputReport(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $get_data['title'] = 'Line Input Report';
        $get_data['date'] = $date;
        $get_data['line_input_report'] = $this->access_model->getLineInputReport($date);

        $data['maincontent'] = $this->load->view('line_input_report', $get_data, true);
        $this->load->view('master', $data);
    }

    public function care_label_pass(){
        echo 'CL PASS';
        echo '<pre>';
        print_r($_POST);
        echo '</pre>';
    }

    public function careLabelMidDefectSave(){
        $defect_part_array = $this->input->post('defect_part_array');
        $defect_codes_array = $this->input->post('defect_codes_array');

        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $access_points_status = $this->input->post('access_points_status');
        $access_points = $this->session->userdata('access_points');
        $line = $this->session->userdata('line_id');

        $carelabel_tracking_no = $this->input->post('cl_track_no_defect');

        $line_check = $this->access_model->lineValidation($carelabel_tracking_no);
        $line_id = $line_check[0]['line_id'];
        $last_access_points = $line_check[0]['access_points'];
        $last_access_points_status = $line_check[0]['access_points_status'];
        $manually_closed = $line_check[0]['manually_closed'];

        if($line == $line_id){
            if($manually_closed == 1){
                echo 'closed';
            }else{
                if(($last_access_points == 2) && ($last_access_points_status == 1)){
                    $this->access_model->midLineQC($carelabel_tracking_no, $access_points, $access_points_status, $date_time);

                    foreach ($defect_part_array as $k => $v){

                        $defect_data = array(
                            'pc_tracking_no' => $carelabel_tracking_no,
                            'line_id' => $line,
                            'qc_point' => $access_points,
                            'defect_part' => $v,
                            'defect_code' => $defect_codes_array[$k],
                            'defect_date_time' => $date_time
                        );

                        $this->access_model->insertingData('tb_defects_tracking', $defect_data);

                    }

                    $this->access_model->midLineQC($carelabel_tracking_no, $access_points, $access_points_status, $date_time);
                    echo 'Defect Tracked!';
                }
                elseif (($last_access_points == $access_points) && ($last_access_points_status == 2)){
                    foreach ($defect_part_array as $k => $v){

                        $res_def = $this->access_model->isDefectAvailable($carelabel_tracking_no, $line, $access_points, $v, $defect_codes_array[$k]);

                        if(empty($res_def)){
                            $defect_data = array(
                                'pc_tracking_no' => $carelabel_tracking_no,
                                'line_id' => $line,
                                'qc_point' => $access_points,
                                'defect_part' => $v,
                                'defect_code' => $defect_codes_array[$k],
                                'defect_date_time' => $date_time
                            );

                            $this->access_model->insertingData('tb_defects_tracking', $defect_data);
                        }
                    }

                    echo 'Defects Updated!';
                }
                elseif (($last_access_points == $access_points) && ($last_access_points_status == 1)){
                    echo 'Already Passed!';
                }
                elseif ($last_access_points > $access_points){
                    echo 'This Process already passed!';
                }
                else{
                    echo 'Previous process in WIP!';
                }
            }

        }else{
            echo 'Line mismatch found!';
        }
    }

    public function po_close_by_merchent()
    {
        $data['title'] = 'PO Remarks';

        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
        $data['purchase_order_nos'] = $this->access_model->getAllPurchaseOrdersForOlymp();

        $data['maincontent'] = $this->load->view('po_close_by_merchent', $data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function po_closed()
    {
        $so_no=$this->input->post('so_no');
        $value=$this->input->post('value');

        $status='';

        if($value == 'CLOSE'){
            $status = $value;
        }

        if($value == 'OPEN'){
            $status = '';
        }


        $data=$this->access_model->po_closed($so_no, $status);

        echo "success";

    }

    public function careLabelEndPassSave(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $time=$datex->format('H:i:s');
        $date=$datex->format('Y-m-d');

        $s_data['session_last_action_date_time'] = $date_time;
        $this->session->set_userdata($s_data);

        $access_points_status = $this->input->post('access_points_status');
        $access_points = $this->session->userdata('access_points');
        $line = $this->session->userdata('line_id');

        $carelabel_tracking_no = $this->input->post('cl_track_no_defect');

        $line_check = $this->access_model->lineValidation($carelabel_tracking_no);
        $line_id = $line_check[0]['line_id'];
        $last_access_points = $line_check[0]['access_points'];
        $last_access_points_status = $line_check[0]['access_points_status'];
        $manually_closed = $line_check[0]['manually_closed'];
        $brand = $line_check[0]['brand'];

        if(sizeof($line_check) > 0) {
            if($manually_closed == 1){
                echo 'closed';
            }else{
                if ($line == $line_id) {
                    if (($last_access_points == 3) && ($last_access_points_status == 1)) {
                        $this->access_model->endLineQC($carelabel_tracking_no, $access_points, 4, $date_time);

                        $this->access_model->updateTodayLineOutputQty($line, $date, $time);

                        // Brand of Last Scanning Piece
                        $this->access_model->updateTblNew('tb_today_line_output_qty', 'line_id', $line, array('brand' => $brand));

                        echo 'Successfully Passed!';
                    } elseif (($last_access_points == $access_points) && ($last_access_points_status == 2)) {
                        $this->access_model->updateDefectStatus($carelabel_tracking_no, $line, $access_points, $access_points_status, $date_time);

                        $this->access_model->updateTodayLineOutputQty($line, $date, $time);

                        // Brand of Last Scanning Piece
                        $this->access_model->updateTblNew('tb_today_line_output_qty', 'line_id', $line, array('brand' => $brand));

                        $this->access_model->endLineQC($carelabel_tracking_no, $access_points, $access_points_status, $date_time);
                        echo 'Successfully Passed!';
                    }
//            elseif (($last_access_points == $access_points) && ($last_access_points_status == 3)){
//                $this->access_model->endLineQC($carelabel_tracking_no, $access_points, $access_points_status, $date_time);
//                echo 'Successfully Passed!';
//            }
                    elseif (($last_access_points == $access_points) && ($last_access_points_status == 4)) {
                        echo 'Already Passed!';
                    }

//            elseif ($last_access_points > $access_points){
//                echo 'This Process already passed!';
//            }
                    else {
                        echo 'Previous process in WIP!';
                    }
                } else {
                    echo "Line mismatch found!";
                }
            }

        }
        else{
            echo 'Not Found';
        }

    }

    public function careLabelMidPassSave(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $s_data['session_last_action_date_time'] = $date_time;
        $this->session->set_userdata($s_data);

        $access_points_status = $this->input->post('access_points_status');
        $access_points = $this->session->userdata('access_points');
        $line = $this->session->userdata('line_id');

        $carelabel_tracking_no = $this->input->post('cl_track_no_defect');

        $line_check = $this->access_model->lineValidation($carelabel_tracking_no);
        $line_id = $line_check[0]['line_id'];
        $last_access_points = $line_check[0]['access_points'];
        $last_access_points_status = $line_check[0]['access_points_status'];
        $manually_closed = $line_check[0]['manually_closed'];

        if(sizeof($line_check) > 0){
            if($manually_closed == 1){
                echo 'closed';
            }else{
                if($line == $line_id){
                    if(($last_access_points == 2) && ($last_access_points_status == 1)){
                        $this->access_model->midLineQC($carelabel_tracking_no, $access_points, $access_points_status, $date_time);
                        echo 'Successfully Passed!';
                    }
                    elseif (($last_access_points == $access_points) && ($last_access_points_status == 2)){
                        $this->access_model->updateDefectStatus($carelabel_tracking_no, $line, $access_points, $access_points_status, $date_time);

                        $this->access_model->midLineQC($carelabel_tracking_no, $access_points, $access_points_status, $date_time);
                        echo 'Successfully Passed!';
                    }
                    //            elseif (($last_access_points == $access_points) && ($last_access_points_status == 3)){
                    //                $this->access_model->midLineQC($carelabel_tracking_no, $access_points, $access_points_status, $date_time);
                    //                echo 'Successfully Passed!';
                    //            }
                    elseif (($last_access_points >= $access_points) && ($last_access_points_status == 1)){
                        echo 'Already Passed!';
                    }

                    elseif (($last_access_points >= $access_points) && ($last_access_points_status == 4)){
                        echo 'Already Passed!';
                    }
                    //            elseif ($last_access_points > $access_points){
                    //                echo 'This Process already passed!';
                    //            }
                    else{
                        echo 'Previous process in WIP!';
                    }
                }else{
                    echo 'Line mismatch found!';
                }
            }
    }else{
        echo 'Not Found';
    }
    }

    public function careLabelEndDefectSave(){
//        $defect_part_array = $this->input->post('defect_part_array');
        $defect_codes_array = $this->input->post('defect_codes_array');
//        $cl_track_no_defect = $this->input->post('cl_track_no_defect');


        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $access_points_status = $this->input->post('access_points_status');
        $access_points = $this->session->userdata('access_points');
        $line = $this->session->userdata('line_id');

        $carelabel_tracking_no = $this->input->post('cl_track_no_defect');

        $line_check = $this->access_model->lineValidation($carelabel_tracking_no);
        $line_id = $line_check[0]['line_id'];
        $last_access_points = $line_check[0]['access_points'];
        $last_access_points_status = $line_check[0]['access_points_status'];
        $manually_closed = $line_check[0]['manually_closed'];

        if($line == $line_id){
            if($manually_closed == 1){
                echo 'closed';
            }else{
                if(($last_access_points == 3) && ($last_access_points_status == 1)){

                    foreach ($defect_codes_array as $k => $v){
                        $res_def = $this->access_model->isDefectAvailable($carelabel_tracking_no, $line, $access_points, $defect_codes_array[$k], $date_time);
                        $count_def_row = sizeof($res_def);

                        if($count_def_row == 0){
                            $defect_data = array(
                                'pc_tracking_no' => $carelabel_tracking_no,
                                'line_id' => $line,
                                'qc_point' => $access_points,
//                            'defect_part' => $v,
                                'defect_code' => $defect_codes_array[$k],
                                'defect_date_time' => $date_time
                            );

                            $this->access_model->insertingData('tb_defects_tracking', $defect_data);
                        }
                    }

                    $this->access_model->endLineQC($carelabel_tracking_no, $access_points, $access_points_status, $date_time);
                    echo 'Defect Tracked!';
                }
                elseif (($last_access_points == $access_points) && ($last_access_points_status == 2)){
                    foreach ($defect_codes_array as $k => $v){

                        $res_def = $this->access_model->isDefectAvailable($carelabel_tracking_no, $line, $access_points, $defect_codes_array[$k], $date_time);
                        $count_def_row = sizeof($res_def);

                        if($count_def_row == 0){
                            $defect_data = array(
                                'pc_tracking_no' => $carelabel_tracking_no,
                                'line_id' => $line,
                                'qc_point' => $access_points,
//                            'defect_part' => $v,
                                'defect_code' => $defect_codes_array[$k],
                                'defect_date_time' => $date_time
                            );

                            $this->access_model->insertingData('tb_defects_tracking', $defect_data);
                        }
                    }

                    echo 'Defects Updated!';
                }
                elseif (($last_access_points == $access_points) && ($last_access_points_status == 1)){
                    echo 'Already Passed!';
                }
                elseif ($last_access_points >= $access_points){
                    echo 'This Process already passed!';
                }
                else{
                    echo 'Previous process in WIP!';
                }
            }

        }else{
            echo 'Line mismatch found!';
        }
    }

    public function unApproveRequest()
    {
        $data['title'] = 'Unapprove Care Label';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
        $data['get_req'] = $this->access_model->getReprintRequest();
        $data['maincontent'] = $this->load->view('unapproved_request', $data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function approveRequest()
    {
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');
        $user_id = $this->session->userdata('id');
        $user_name = $this->session->userdata('user_description');
        $pc_nos=$this->input->post('pc_nos');

        foreach ($pc_nos as $k => $pc_no){

            $this->access_model->activeCl($pc_no, $date_time);
            $data=$this->access_model->approveRequest($pc_no, $user_name);

        }

        echo 'done';
    }

    public function getReprintRequest()
    {
        $data['title'] = 'Approved Reprint Label';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
        $data['get_req'] = $this->access_model->getReprintRequest();
        $data['maincontent'] = $this->load->view('approve_reprint_request', $data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

//    public function careLabelEndDefectSave(){
//        $defect_part_array = $this->input->post('defect_part_array');
//        $defect_codes_array = $this->input->post('defect_codes_array');
////        $cl_track_no_defect = $this->input->post('cl_track_no_defect');
//
//
//        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
//        
//        $date_time=$datex->format('Y-m-d H:i:s');
//        $date=$datex->format('Y-m-d');
//
//        $access_points_status = $this->input->post('access_points_status');
//        $access_points = $this->session->userdata('access_points');
//        $line = $this->session->userdata('line_id');
//
//        $carelabel_tracking_no = $this->input->post('cl_track_no_defect');
//
//        $line_check = $this->access_model->lineValidation($carelabel_tracking_no);
//        $line_id = $line_check[0]['line_id'];
//        $last_access_points = $line_check[0]['access_points'];
//        $last_access_points_status = $line_check[0]['access_points_status'];
//
//        if($line == $line_id){
//            if(($last_access_points == 3) && ($last_access_points_status == 1)){
//
//                foreach ($defect_part_array as $k => $v){
//
//                        $defect_data = array(
//                            'pc_tracking_no' => $carelabel_tracking_no,
//                            'line_id' => $line,
//                            'qc_point' => $access_points,
//                            'defect_part' => $v,
//                            'defect_code' => $defect_codes_array[$k],
//                            'defect_date_time' => $date_time
//                        );
//
//                        $this->access_model->insertingData('tb_defects_tracking', $defect_data);
//                }
//
//                $this->access_model->endLineQC($carelabel_tracking_no, $access_points, $access_points_status, $date_time);
//                echo 'Defect Tracked!';
//            }
//            elseif (($last_access_points == $access_points) && ($last_access_points_status == 2)){
//                foreach ($defect_part_array as $k => $v){
//
//                    $res_def = $this->access_model->isDefectAvailable($carelabel_tracking_no, $line, $access_points, $v, $defect_codes_array[$k]);
//
//                    if(empty($res_def)){
//                        $defect_data = array(
//                            'pc_tracking_no' => $carelabel_tracking_no,
//                            'line_id' => $line,
//                            'qc_point' => $access_points,
//                            'defect_part' => $v,
//                            'defect_code' => $defect_codes_array[$k],
//                            'defect_date_time' => $date_time
//                        );
//
//                        $this->access_model->insertingData('tb_defects_tracking', $defect_data);
//                    }
//                }
//
//                echo 'Defects Updated!';
//            }
//            elseif (($last_access_points == $access_points) && ($last_access_points_status == 1)){
//                echo 'Already Passed!';
//            }
//            elseif ($last_access_points > $access_points){
//                echo 'This Process already passed!';
//            }
//            else{
//                echo 'Previous process in WIP!';
//            }
//        }else{
//            echo 'Line mismatch found!';
//        }
//    }

    public function careLabelFinishPassSave(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $access_points_status = $this->input->post('access_points_status');
        $access_points = $this->session->userdata('access_points');

        $carelabel_tracking_no = $this->input->post('carelabel_tracking_no');

        $line_check = $this->access_model->lineValidation($carelabel_tracking_no);
        $line_id = $line_check[0]['line_id'];
        $last_access_points = $line_check[0]['access_points'];
        $last_access_points_status = $line_check[0]['access_points_status'];
        $finishing_qc_status = $line_check[0]['finishing_qc_status'];


        if (($last_access_points == 4) && ($last_access_points_status == 4) && ($finishing_qc_status == 0)){
            $this->access_model->finishingQC($carelabel_tracking_no, $access_points_status, $date_time);
            echo 'Successfully Passed!';
        }
        elseif (($last_access_points == 4) && ($last_access_points_status == 4) && ($finishing_qc_status == 2)){
            $this->access_model->updateFinishingDefectStatus($carelabel_tracking_no, 1, $date_time);

            $this->access_model->finishingQC($carelabel_tracking_no, $access_points_status, $date_time);
            echo 'Successfully Passed!';
        }
        elseif ($finishing_qc_status == 1){
            echo 'This Process already passed!';
        }
        else{
            echo 'Previous process in WIP!';
        }
    }

    public function careLabelFinishDefectSave(){
        $defect_part_array = $this->input->post('defect_part_array');
        $defect_codes_array = $this->input->post('defect_codes_array');
//        $cl_track_no_defect = $this->input->post('cl_track_no_defect');


        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $access_points_status = $this->input->post('access_points_status');
        $access_points = $this->session->userdata('access_points');
        $line = $this->session->userdata('line_id');

        $carelabel_tracking_no = $this->input->post('cl_track_no_defect');

        $line_check = $this->access_model->lineValidation($carelabel_tracking_no);
        $line_id = $line_check[0]['line_id'];
        $last_access_points = $line_check[0]['access_points'];
        $last_access_points_status = $line_check[0]['access_points_status'];
        $finishing_qc_status = $line_check[0]['finishing_qc_status'];

            if(($last_access_points == 4) && ($last_access_points_status == 4) && ($finishing_qc_status != 1)){

                foreach ($defect_part_array as $k => $v){

                        $defect_data = array(
                            'pc_tracking_no' => $carelabel_tracking_no,
                            'qc_point' => 5,
                            'defect_part' => $v,
                            'defect_code' => $defect_codes_array[$k],
                            'defect_date_time' => $date_time
                        );

                        $this->access_model->insertingData('tb_defects_tracking', $defect_data);
                }

                $this->access_model->finishingQC($carelabel_tracking_no, $access_points_status, $date_time);
                echo 'Successful!';
            }
            elseif ($finishing_qc_status == 1){
                echo 'This Process already passed!';
            }
            else{
                echo 'Previous process in WIP!';
            }

    }

//    public function care_label_pass(){
////        $this->session->unset_userdata('exception');
////        $this->session->unset_userdata('message');
//
//        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
//        
//        $date_time=$datex->format('Y-m-d H:i:s');
//        $date=$datex->format('Y-m-d');
//
//        $get_data['user_name'] = $this->session->userdata('user_name');
//        $get_data['access_points'] = $this->session->userdata('access_points');
//
//        $access_points = $this->session->userdata('access_points');
//        $line_id = $this->session->userdata('line_id');
//
//        $carelabel_tracking_no = $this->input->post('carelabel_tracking_no');
//
//        $line_check = $this->access_model->lineCheckofCL($carelabel_tracking_no);
////        $size_of_array = sizeof($line_check);
//        $id = $line_check[0]['line_id'];
//        $sent_to_production = $line_check[0]['sent_to_production'];
//        $last_access_points = $line_check[0]['access_points'];
//        $last_access_points_status = $line_check[0]['access_points_status'];
//
//
//        $access_points_status = 1;
//
//        if($id == $line_id){
//
//            if((($last_access_points+1) == $access_points) && ($last_access_points_status == 1) && ($last_access_points != 0)){
//                $this->access_model->midLineQC($carelabel_tracking_no, $access_points, $access_points_status, $date_time);
//
//                $data['message']='Successfully Passed!';
//                $this->session->set_userdata($data);
//            }
//            elseif (($last_access_points == $access_points) && ($last_access_points_status == 1)){
//                $data['message']='Already Passed!';
//                $this->session->set_userdata($data);
//            }
//            elseif ($last_access_points > $access_points){
//                $data['exception']='This Process already passed!';
//                $this->session->set_userdata($data);
//            }
//            else{
//                $data['exception']='Previous process in WIP!';
//                $this->session->set_userdata($data);
//            }
//        }else{
//            $data['exception']='Line mismatch found!';
//            $this->session->set_userdata($data);
//        }
//
//
//        if($access_points == 3){
//            redirect('access/care_label_mid_line_new');
//        }
//
//        if($access_points == 4){
//            redirect('access/care_label_end_line_new');
//        }
//
//    }

    public function clDefects(){
        $data['title'] = 'CL Defects';

        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');
        $data['msg'] = '';

        $data['maincontent'] = $this->load->view('care_label_defects', $data, true);
        $this->load->view('master', $data);
    }

    public function clRejection(){
        $data['title'] = 'CL Rejection';

        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');
        $data['msg'] = '';

        $data['maincontent'] = $this->load->view('care_label_rejection', $data, true);
        $this->load->view('master', $data);
    }

    public function inputToLine_pre(){
        $this->session->unset_userdata('exception');
        $this->session->unset_userdata('message');

        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $get_data['user_name'] = $this->session->userdata('user_name');
        $get_data['user_description'] = $this->session->userdata('user_description');
        $get_data['access_points'] = $this->session->userdata('access_points');

        $access_points = $this->session->userdata('access_points');
        $line_id = $this->session->userdata('line_id');

        $carelabel_tracking_no = $this->input->post('carelabel_tracking_no');

        $line_check = $this->access_model->lineCheckofCL($carelabel_tracking_no);
//        $size_of_array = sizeof($line_check);
        $id = $line_check[0]['line_id'];
        $sent_to_production = $line_check[0]['sent_to_production'];
        $last_access_points = $line_check[0]['access_points'];
        $access_points_status = $line_check[0]['access_points_status'];

        // re-program
        if(($id == 0) && ($sent_to_production == 1)){
            $this->access_model->inputToLine($carelabel_tracking_no, $line_id, $access_points, 1, $date_time);

            $data['message']="$carelabel_tracking_no Successfully Inputted!";
            $this->session->set_userdata($data);
        }
//        if($id == $line_id){
//            if(($last_access_points == 2) && ($access_points_status == 1)){
//                $data['exception']='This CL Already Inputed!!';
//                $this->session->set_userdata($data);
//            }

            if (($id == $line_id) && ($last_access_points > $access_points)){
                $data['message']="$carelabel_tracking_no Successfully Inputted!";
                $this->session->set_userdata($data);
            }
//        }
        if (($id == $line_id) && ($last_access_points == 2)){
            $data['message']="$carelabel_tracking_no Successfully Inputted!";
            $this->session->set_userdata($data);
        }

        if (($id != $line_id)){
            if($sent_to_production == 0){
                $data['exception']="Cutting Process not Finished - $carelabel_tracking_no !";
                $this->session->set_userdata($data);
            }
            if($id !=0){
                $data['exception']='Line Mismatch!';
                $this->session->set_userdata($data);
            }
        }


        redirect('access/care_label_input_line');
    }

    public function inputToLine(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $s_data['session_last_action_date_time'] = $date_time;

        $this->session->set_userdata($s_data);

        $get_data['user_name'] = $this->session->userdata('user_name');
        $get_data['user_description'] = $this->session->userdata('user_description');
        $get_data['access_points'] = $this->session->userdata('access_points');

        $access_points = $this->session->userdata('access_points');
        $line_id = $this->session->userdata('line_id');

        $carelabel_tracking_no = $this->input->post('care_label_no');

        $line_check = $this->access_model->lineCheckofCL($carelabel_tracking_no);
//        $size_of_array = sizeof($line_check);
        $id = $line_check[0]['line_id'];
        $package_sent_to_production = $line_check[0]['package_sent_to_production'];
        $sent_to_production = $line_check[0]['sent_to_production'];
        $last_access_points = $line_check[0]['access_points'];
        $access_points_status = $line_check[0]['access_points_status'];
        $manually_closed = $line_check[0]['manually_closed'];

        if(sizeof($line_check) > 0){
            // re-program
            if ($manually_closed == 1){
                echo 'closed';
            }else{
                if(($id == 0) && ($sent_to_production == 1)){
                    $this->access_model->inputToLine($carelabel_tracking_no, $line_id, 2, 1, $date_time);

                    echo 'successfully inputed';
                }

//        if($id == $line_id){
//            if(($last_access_points == 2) && ($access_points_status == 1)){
//                $data['exception']='This CL Already Inputed!!';
//                $this->session->set_userdata($data);
//            }

                if (($id == $line_id) && ($last_access_points == $access_points) && ($manually_closed == 0)){
                    echo 'successfully inputed 2';
                }
//        }
                if (($id == $line_id) && ($last_access_points > 2) && ($manually_closed == 0)){
                    echo 'successfully inputted already';
                }

                if (($id != $line_id)){
                    if($sent_to_production == 0){
                        echo 'cutting process not finished';
                    }
                    if($id != 0){
                        $line_info = $this->access_model->getLineInfo($id);
                        $line_name = $line_info[0]['line_name'];

                        echo "line mismatch~$line_name";
                    }
                }
            }

        }else{
            echo 'Not Found';
        }

//        redirect('access/care_label_input_line');
    }

    public function goingForWash_pre(){
        $this->session->unset_userdata('exception');
        $this->session->unset_userdata('message');

        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $get_data['user_name'] = $this->session->userdata('user_name');
        $get_data['user_description'] = $this->session->userdata('user_description');
        $get_data['access_points'] = $this->session->userdata('access_points');

        $access_points = $this->session->userdata('access_points');

        $carelabel_tracking_no = $this->input->post('carelabel_tracking_no');

        $line_check = $this->access_model->lineCheckofCL($carelabel_tracking_no);

        $sent_to_production = $line_check[0]['sent_to_production'];
        $last_access_points = $line_check[0]['access_points'];
        $access_points_status = $line_check[0]['access_points_status'];
        $washing_status = $line_check[0]['washing_status'];
        $is_wash_gmt = $line_check[0]['is_wash_gmt'];
        $is_going_wash = $line_check[0]['is_going_wash'];

        // re-program
            if(($last_access_points == 4) && ($access_points_status == 4)){
                if($is_wash_gmt == 1){
                    $this->access_model->goingWash($carelabel_tracking_no, 1, $date_time);

                    $data['message']="$carelabel_tracking_no Successful !";
                    $this->session->set_userdata($data);
                }
                if($is_going_wash == 1){
                    $data['message']="$carelabel_tracking_no Scanned Already!";
                    $this->session->set_userdata($data);
                }
                if($is_wash_gmt == 0){
                    $data['exception']="$carelabel_tracking_no is not Wash Garment!";
                    $this->session->set_userdata($data);
                }
            }else{
                $data['exception']="$carelabel_tracking_no Previous Process Not Finished!";
                $this->session->set_userdata($data);
            }

        redirect('access/care_label_going_wash');
    }

    public function goingForWash(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $s_data['session_last_action_date_time'] = $date_time;
        $this->session->set_userdata($s_data);

        $get_data['user_name'] = $this->session->userdata('user_name');
        $get_data['user_description'] = $this->session->userdata('user_description');
        $get_data['access_points'] = $this->session->userdata('access_points');

        $access_points = $this->session->userdata('access_points');

        $carelabel_tracking_no = $this->input->post('care_label_no');

        $line_check = $this->access_model->lineCheckofCL($carelabel_tracking_no);

        $sent_to_production = $line_check[0]['sent_to_production'];
        $last_access_points = $line_check[0]['access_points'];
        $access_points_status = $line_check[0]['access_points_status'];
        $washing_status = $line_check[0]['washing_status'];
        $is_wash_gmt = $line_check[0]['is_wash_gmt'];
        $is_going_wash = $line_check[0]['is_going_wash'];
        $manually_closed = $line_check[0]['manually_closed'];

        if(sizeof($line_check) > 0){
            if($manually_closed == 1){
                echo 'closed';
            }else{
                // re-program
                if(($last_access_points == 4) && ($access_points_status == 4)){
                    if($is_wash_gmt == 1 && $is_going_wash == 0){
                        $this->access_model->goingWash($carelabel_tracking_no, 1, $date_time);

                        echo 'successful';
                    }

                    if($is_wash_gmt == 1 && $is_going_wash == 1){
                        echo 'already';
                    }

                    if($is_wash_gmt == 0){
                        echo 'non-wash';
                    }
                }
                else{
                    echo 'previous process wip';
                }
            }

        }else{
            echo 'Not Found';
        }

    }

    public function washReport(){
        $data['title'] = 'Wash Report';

        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');
        $data['msg'] = '';

        $data['maincontent'] = $this->load->view('wash_gmt_report', $data, true);
        $this->load->view('master', $data);
    }

    public function getWashGoingReport(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $data['date']=$datex->format('Y-m-d');

        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');

        $where = '';

        if($from_date != '' && $from_date !='undefined--undefined' && $from_date != '1970-01-01' && $to_date != '' && $to_date !='undefined--undefined' && $to_date != '1970-01-01'){
            $where .= " AND (DATE_FORMAT(going_wash_scan_date_time, '%Y-%m-%d') BETWEEN '$from_date' AND '$to_date')";
        }

        $data['wash_going_report'] = $this->access_model->getWashGoingReport($where);

        echo $data['maincontent'] = $this->load->view('wash_going_report_data', $data);
    }

    public function updateWashPrintedPcs(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $from_dt = $this->input->post('from_date');
        $to_dt = $this->input->post('to_date');
        $wash_going_status = 1;

        $data['wash_going_report'] = $this->access_model->updateWashPrintedPcs($from_dt, $to_dt, $wash_going_status, $date_time);

        echo 'done';
    }

    public function washReturn_pre(){
        $this->session->unset_userdata('exception');
        $this->session->unset_userdata('message');

        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $get_data['user_name'] = $this->session->userdata('user_name');
        $get_data['user_description'] = $this->session->userdata('user_description');
        $get_data['access_points'] = $this->session->userdata('access_points');

        $access_points = $this->session->userdata('access_points');

        $carelabel_tracking_no = $this->input->post('carelabel_tracking_no');

        $line_check = $this->access_model->lineCheckofCL($carelabel_tracking_no);

        $sent_to_production = $line_check[0]['sent_to_production'];
        $last_access_points = $line_check[0]['access_points'];
        $access_points_status = $line_check[0]['access_points_status'];
        $is_going_wash = $line_check[0]['is_going_wash'];
        $washing_status = $line_check[0]['washing_status'];
        $is_wash_gmt = $line_check[0]['is_wash_gmt'];

        // re-program
        if($is_wash_gmt == 1){
//            if(($last_access_points == 4) && ($access_points_status == 4) && ($washing_status != 1)){
            if(($is_going_wash == 1) && ($washing_status != 1)){
                $this->access_model->washReturn($carelabel_tracking_no, 1, $date_time);

                $data['message']="$carelabel_tracking_no Successfully Wash-Returned!";
                $this->session->set_userdata($data);
            }
            elseif(($washing_status == 1)){
                $data['message']="$carelabel_tracking_no Returned Already!";
                $this->session->set_userdata($data);
            }else{
                $data['exception']="$carelabel_tracking_no Previous Process Not Finished!";
                $this->session->set_userdata($data);
            }
        }else{
            $data['exception']="$carelabel_tracking_no is not Wash Garment!";
            $this->session->set_userdata($data);
        }

        redirect('access/care_label_washing');
    }

    public function washReturn(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $s_data['session_last_action_date_time'] = $date_time;
        $this->session->set_userdata($s_data);

        $get_data['user_name'] = $this->session->userdata('user_name');
        $get_data['user_description'] = $this->session->userdata('user_description');
        $get_data['access_points'] = $this->session->userdata('access_points');

        $access_points = $this->session->userdata('access_points');

        $carelabel_tracking_no = $this->input->post('care_label_no');

        $line_check = $this->access_model->lineCheckofCL($carelabel_tracking_no);

        $sent_to_production = $line_check[0]['sent_to_production'];
        $last_access_points = $line_check[0]['access_points'];
        $access_points_status = $line_check[0]['access_points_status'];
        $is_going_wash = $line_check[0]['is_going_wash'];
        $washing_status = $line_check[0]['washing_status'];
        $is_wash_gmt = $line_check[0]['is_wash_gmt'];
        $manually_closed = $line_check[0]['manually_closed'];

        if(sizeof($line_check) > 0){
            if($manually_closed == 1){
                echo 'closed';
            }else{
                // re-program
                if($is_wash_gmt == 1){
                    if(($is_going_wash == 1) && ($washing_status == 0)){
                        $this->access_model->washReturn($carelabel_tracking_no, 1, $date_time);
                        echo 'successfully wash returned';
                    }
                    if(($is_going_wash == 1) && ($washing_status == 1)){
                        echo 'returned already';
                    }
                    if($is_going_wash == 0){
                        echo 'previous process not finished';
                    }
                }else{
                    echo 'non-wash gmt';
                }
            }

        }else{
            echo 'Not Found';
        }

    }

    public function packingSave(){
        $this->session->unset_userdata('exception');
        $this->session->unset_userdata('message');

        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');
//        $date=format('Y-m-d');
//        $date=date("Y-m-d");
        $time=$datex->format('H:i:s');

        $s_data['session_last_action_date_time'] = $date_time;
        $this->session->set_userdata($s_data);

        $floor_id = $this->session->userdata('floor_id');
        $line_id = $this->session->userdata('line_id');
        $get_data['user_name'] = $this->session->userdata('user_name');
        $get_data['user_description'] = $this->session->userdata('user_description');
        $get_data['access_points'] = $this->session->userdata('access_points');

        $access_points = $this->session->userdata('access_points');
        $print_status = $this->session->userdata('is_print_allowed');

        $carelabel_tracking_no = $this->input->post('carelabel_tracking_no');

        $line_check = $this->access_model->lineCheckofCL($carelabel_tracking_no);

        $sent_to_production = $line_check[0]['sent_to_production'];
        $last_access_points = $line_check[0]['access_points'];
        $access_points_status = $line_check[0]['access_points_status'];
        $washing_status = $line_check[0]['washing_status'];
        $is_wash_gmt = $line_check[0]['is_wash_gmt'];
        $packing_status = $line_check[0]['packing_status'];
        $finishing_qc_status = $line_check[0]['finishing_qc_status'];
        $size = $line_check[0]['size'];
        $line = $line_check[0]['line_name'];
        $manually_closed = $line_check[0]['manually_closed'];

        $po_last_four_digit = substr($line_check[0]['purchase_order'], -4);
        $item_last_three_digit = substr($line_check[0]['item'], 0, 3);
        $color_first_three_digit = substr($line_check[0]['color'], 0, 3);

        if(sizeof($line_check) > 0){
            if($manually_closed == 1){
                $data['exception']="$carelabel_tracking_no is Closed!";
                $this->session->set_userdata($data);
            }else{
                if($is_wash_gmt == 1){
                    if(($washing_status == 1) && ($last_access_points == 4) && ($access_points_status == 4) && ($packing_status == 0) && ($finishing_qc_status != 2) && ($finishing_qc_status != 3)){
                        $this->access_model->packingShirt($carelabel_tracking_no, 1, $floor_id, $date_time);
                        $this->access_model->updateTodayFinishingOutputQty($floor_id, $date, $time);


                        $data['message']="$carelabel_tracking_no Successfully Packed!";
                        $this->session->set_userdata($data);

                        if($print_status == 1){
                            echo '<script>
                            window.open("'.base_url().'access/printSticker/'.$carelabel_tracking_no.'/'.$po_last_four_digit.'/'.$item_last_three_digit.'/'.$color_first_three_digit.'/'.$size.'");
                            window.location.href = "'.base_url().'access/care_label_packing/'.'";
                            </script>';
                        }else{
                            echo '<script>
                            window.location.href = "'.base_url().'access/care_label_packing/'.'";
                            </script>';
                        }
                    }elseif(($washing_status == 1) && ($last_access_points == 4) && ($access_points_status == 4) && ($packing_status == 1) && ($finishing_qc_status != 2) && ($finishing_qc_status != 3)){
                        $data['message']="$carelabel_tracking_no Packed Already!";
                        $this->session->set_userdata($data);

                        if($print_status == 1){
                            echo '<script>
                            window.open("'.base_url().'access/printSticker/'.$carelabel_tracking_no.'/'.$po_last_four_digit.'/'.$item_last_three_digit.'/'.$color_first_three_digit.'/'.$size.'");
                            window.location.href = "'.base_url().'access/care_label_packing/'.'";
                            </script>';
                        }else{
                            echo '<script>
                            window.location.href = "'.base_url().'access/care_label_packing/'.'";
                            </script>';
                        }
                    }elseif(($washing_status == 1) && ($last_access_points == 4) && ($access_points_status == 4) && ($finishing_qc_status == 2)){
                        $data['exception']="$carelabel_tracking_no $line Alter Not completed!";
                        $this->session->set_userdata($data);

                        echo '<script>
                        window.location.href = "'.base_url().'access/care_label_packing/'.'";
                        </script>';
                    }elseif(($washing_status == 1) && ($last_access_points == 4) && ($access_points_status == 4) && ($finishing_qc_status == 3)){
                        $data['exception']="$carelabel_tracking_no Alter Not Confirmed!";
                        $this->session->set_userdata($data);

                        echo '<script>
                        window.location.href = "'.base_url().'access/care_label_packing/'.'";
                        </script>';
                    }elseif(($last_access_points != 4) && ($access_points_status != 4)){
                        $data['exception']="$carelabel_tracking_no $line Process Not completed!";
                        $this->session->set_userdata($data);

                        echo '<script>
                        window.location.href = "'.base_url().'access/care_label_packing/'.'";
                        </script>';
                    }elseif(($washing_status == 0) && ($last_access_points == 4) && ($access_points_status == 4)){
                        $data['exception']="$carelabel_tracking_no Wash-Return not completed!";
                        $this->session->set_userdata($data);

                        echo '<script>
                        window.location.href = "'.base_url().'access/care_label_packing/'.'";
                        </script>';
                    }
                }
                if($is_wash_gmt == 0){
                    if(($last_access_points == 4) && ($access_points_status == 4) && ($packing_status == 0) && ($finishing_qc_status != 2) && ($finishing_qc_status != 3)){
                        $this->access_model->packingShirt($carelabel_tracking_no, 1, $floor_id, $date_time);
                        $this->access_model->updateTodayFinishingOutputQty($floor_id, $date, $time);

                        $data['message']="$carelabel_tracking_no Successfully Packed!";
                        $this->session->set_userdata($data);

                        if($print_status == 1){
                            echo '<script>
                            window.open("'.base_url().'access/printSticker/'.$carelabel_tracking_no.'/'.$po_last_four_digit.'/'.$item_last_three_digit.'/'.$color_first_three_digit.'/'.$size.'");
                            window.location.href = "'.base_url().'access/care_label_packing/'.'";
                            </script>';
                        }else{
                            echo '<script>
                            window.location.href = "'.base_url().'access/care_label_packing/'.'";
                            </script>';
                        }
                    }
                    elseif(($last_access_points == 4) && ($access_points_status == 4) && ($packing_status == 1) && ($finishing_qc_status != 2) && ($finishing_qc_status != 3)){
                        $data['message']="$carelabel_tracking_no Packed Already!";
                        $this->session->set_userdata($data);

                        if($print_status == 1){
                            echo '<script>
                            window.open("'.base_url().'access/printSticker/'.$carelabel_tracking_no.'/'.$po_last_four_digit.'/'.$item_last_three_digit.'/'.$color_first_three_digit.'/'.$size.'");
                            window.location.href = "'.base_url().'access/care_label_packing/'.'";
                        </script>';
                        }else{
                            echo '<script>
                            window.location.href = "'.base_url().'access/care_label_packing/'.'";
                            </script>';
                        }
                    }
                    elseif(($last_access_points == 4) && ($access_points_status == 4) && ($finishing_qc_status == 2)){
                        $data['exception']="$carelabel_tracking_no $line Alter Not completed!";
                        $this->session->set_userdata($data);

                        echo '<script>
                        window.location.href = "'.base_url().'access/care_label_packing/'.'";
                        </script>';
                    }
                    elseif(($last_access_points == 4) && ($access_points_status == 4) && ($finishing_qc_status == 3)){
                        $data['exception']="$carelabel_tracking_no Alter Not Confirmed!";
                        $this->session->set_userdata($data);

                        echo '<script>
                        window.location.href = "'.base_url().'access/care_label_packing/'.'";
                        </script>';
                    }
                    elseif(($last_access_points != 4) && ($access_points_status != 4)){
                        $data['exception']="$carelabel_tracking_no $line Process Not completed!";
                        $this->session->set_userdata($data);

                        echo '<script>
                        window.location.href = "'.base_url().'access/care_label_packing/'.'";
                        </script>';
                    }
                    else{
                        $data['exception']="$carelabel_tracking_no $line Processes Not Completed!";
                        $this->session->set_userdata($data);

                        echo '<script>
                        window.location.href = "'.base_url().'access/care_label_packing/'.'";
                        </script>';
                    }
                }
            }

        }else{
            $data['exception']="$carelabel_tracking_no $line Not Found!";
            $this->session->set_userdata($data);

            echo '<script>
                    window.location.href = "'.base_url().'access/care_label_packing/'.'";
                </script>';
        }

    }

    public function sms_file_upload_test()
    {
        $data['title'] = 'PO File Upload';

        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time = $datex->format('Y-m-d H:i:s');
        $date = $datex->format('Y-m-d');

        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
        $last_so_no = $this->access_model->getManualUploadLastSoNo();
        $data['last_so_no'] = $last_so_no[0]['so_no'];
        $data['upload_date'] = $last_so_no[0]['upload_date'];

        $data['today_upload'] = $this->access_model->todayManualUploadedList($date);

        $data['maincontent'] = $this->load->view('sms_file_upload_test', $data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function smsFileUploadTest()
    {
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time = $datex->format('Y-m-d H:i:s');
        $date = $datex->format('Y-m-d');

        $data['created_on'] = $date_time;

        $po_type=$this->input->post('po_type');

        $filename = $_FILES["file"]["tmp_name"];

        if ($_FILES["file"]["size"] > 0) {
            $file = fopen($filename, "r");
            fgetcsv($file);

            while (!feof($file)) {
                $line_of_text[] = fgetcsv($file);
            }
            fclose($file);

            foreach ($line_of_text as $k => $v) {
                if ($v[0] != '' && $v[1] != '' && $v[2] != '' && $v[3] != '' && $v[4] != '' && $v[6] != '' && $v[7] != '') {

                    $purch_order = $v[0];
                    $itm = $v[1];
                    $qlty = $v[2];
                    $clr = $v[3];
                    $style_no = $v[4];
                    $style_name = $v[5];
                    $brnd = $v[6];
                    $sz = $v[7];
                    $quantity = $v[8];
//                    $ex_factory_date = $v[9];
//                    $ex_factory_date="";
                    $exploded_date = explode(".", $v[9]);
                    $exploded_month=$exploded_date[1];
                    $exploded_day=$exploded_date[2];
                    $exploded_year=$exploded_date[0];
                    $ex_factory_date = $exploded_year."-" .$exploded_month. "-" .$exploded_day;
//                    echo '<pre>';
//                   print_r($ex_factory_date);
//                    echo '</pre>';
//                    die();

                    $exploded_crd_date = explode(".", $v[10]);
                    $exploded_crd_month=$exploded_crd_date[1];
                    $exploded_crd_day=$exploded_crd_date[2];
                    $exploded_crd_year=$exploded_crd_date[0];
                    $crd_date = $exploded_crd_year."-" .$exploded_crd_month. "-" .$exploded_crd_day;


                    $purchase_order = (str_replace(" ", "", $purch_order));
                    $item = (str_replace(" ", "", $itm));
                    $color = (str_replace(" ", "", $clr));
                    $quality = (str_replace(" ", "", $qlty));
                    $size = (str_replace(" ", "", $sz));
                    $brand = (trim($brnd));


                    $where = "";

                    if ($purchase_order != '') {
                        $where .= " AND purchase_order = '$purchase_order'";
                    }

                    if ($item != '') {
                        $where .= " AND item = '$item'";
                    }

                    if ($color != '') {
                        $where .= " AND color = '$color'";
                    }

                    if ($quality != '') {
                        $where .= " AND quality = '$quality'";
                    }

                    if ($style_no != '') {
                        $where .= " AND style_no = '$style_no'";
                    }

                    if ($po_type != '') {
                        $where .= " AND po_type = '$po_type'";
                    }

                    if ($ex_factory_date != '') {
                        $where .= " AND ex_factory_date = '$ex_factory_date'";
                    }


                    $avail_info = $this->access_model->isAvailAlready($where);
                    $id = $avail_info[0]['id'];
                    $e_so_no = $avail_info[0]['so_no'];
//                    echo '<pre>';
//                    print_r($id);
//                    print_r($e_so_no);
//                    echo '</pre>';
//                    die();


                    if($e_so_no != '')
                    {

                        if ($size != '') {
                            $where .= " AND size = '$size'";
                        }


//                        $avail_info_1 = $this->dashboard_model->isAvailAlready($where);
                        $avail_info_1 = $this->access_model->isAvailAlready($where);
                        $e_size = $avail_info_1[0]['size'];

                        if($e_size == ''){
                            $data = array(
                                'po_no' => "$e_so_no",
                                'so_no' => "$e_so_no",
                                'purchase_order' => "$purchase_order",
                                'item' => "$item",
                                'style_no' => "$style_no",
                                'style_name' => "$style_name",
                                'quality' => "$quality",
                                'color' => "$color",
                                'brand' => "$brand",
                                'quantity' => "$quantity",
                                'size' => "$size",
                                'ex_factory_date' => "$ex_factory_date",
                                'crd_date' => "$crd_date",
                                'is_manual_upload' =>1,
                                'upload_date' =>"$date",
                                'po_type' =>"$po_type"
                            );

                            $insert_info = $this->access_model->insertingData('tb_po_detail', $data);

//                            echo '<pre>';
//                            print_r($data);
//                            echo '</pre>';

                        }

                    }
                    else{

                        $last_so_no = $this->access_model->getManualUploadLastSoNo();
                        $extended_so_no = $last_so_no[0]['so_no'];



                        $substring_so_no=substr("$extended_so_no",1);

//                    echo '<pre>';
//                    print_r($substring_so_no);
//                    echo '</pre>';
//                    die();
                        $extended_so_no_final = ($substring_so_no * 1) + 1;

                        $data_1 = array(
                            'po_no' => "E$extended_so_no_final",
                            'so_no' => "E$extended_so_no_final",
                            'purchase_order' => "$purchase_order",
                            'item' => "$item",
                            'style_no' => "$style_no",
                            'style_name' => "$style_name",
                            'quality' => "$quality",
                            'color' => "$color",
                            'brand' => "$brand",
                            'quantity' => "$quantity",
                            'size' => "$size",
                            'ex_factory_date' => "$ex_factory_date",
                            'crd_date' => "$crd_date",
                            'is_manual_upload' => 1,
                            'upload_date' =>"$date",
                            'po_type' =>"$po_type"
                        );

                        $insert_info_2 = $this->access_model->insertingData('tb_po_detail', $data_1);

                        $data_2 = array(
                            'so_no' => "E$extended_so_no_final",
                            'update_date_time' => "$date_time"
                        );
                        $this->access_model->updateTbl('tb_last_so', 1, $data_2);

                    }

                }

            }
            $data['message']='Successfully Uploaded!';
            $this->session->set_userdata($data);

        }

        redirect('access/sms_file_upload_test');
    }

    public function poPartDetail()
    {
        $data['title'] = 'Set Parts';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
        $data['sap_no'] = $this->access_model->getAllSOs();
        $data['part_name'] = $this->access_model->getAllPart();
        $data['maincontent'] = $this->load->view('po_part_detail', $data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function poPartInsert()
    {
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');

        $part_name=$this->input->post('part_name');
        $po_no=$this->input->post('po_no');

        $search_result=$this->access_model->search_exfactory($po_no);
        $exfac_date=$search_result[0]['ex_factory_date'];

//        echo '<pre>';
//        print_r($part_name);
//        print_r($po_no);
//        print_r($exfac_date);
//        echo '</pre>';
//        die();

        $data['collar_outer']=$part_name[0];
        $data['cuff_outer']=$part_name[1];
        $data['back']=$part_name[2];
        $data['front_l']=$part_name[3];
        $data['front_r']=$part_name[4];
        $data['yoke_upper']=$part_name[5];
        $data['yoke_inner']=$part_name[6];
        $data['sleeve_r']=$part_name[7];
        $data['sleeve_l']=$part_name[8];
        $data['slv_plkt_r']=$part_name[9];
        $data['slv_plkt_l']=$part_name[10];
        $data['pocket']=$part_name[11];
        $data['collar_inner']=$part_name[12];
        $data['collar_inner_2']=$part_name[13];
        $data['collar_outer_2']=$part_name[14];
        $data['band_upper']=$part_name[15];
        $data['band_inner']=$part_name[16];
        $data['cuff_inner']=$part_name[17];


        foreach ($data as $v_data)

        {
            if($v_data !='') {
                $this->access_model->poPartInsert( $po_no, $v_data, $exfac_date, $date_time);
            }
        }
        echo "Done";

    }

    public function saveAsOtherPurpose(){
        $this->session->unset_userdata('exception');
        $this->session->unset_userdata('message');

        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $user_id = $this->session->userdata('id');
        $get_data['user_name'] = $this->session->userdata('user_name');
        $get_data['user_description'] = $this->session->userdata('user_description');
        $get_data['access_points'] = $this->session->userdata('access_points');

        $care_label_no = $this->input->post('carelabel_tracking_no');
        $other_purpose_reason = $this->input->post('other_purpose_reason');
        $other_purpose_liable_person = $this->input->post('other_purpose_liable_person');


        $care_label_info = $this->access_model->getCareLabelShirtInfo($care_label_no);
        $carton_status = $care_label_info[0]['carton_status'];
        $warehouse_qa_type = $care_label_info[0]['warehouse_qa_type'];

        if($carton_status==0){
            if($warehouse_qa_type != 5){
                $this->access_model->saveAsOtherPurpose($care_label_no, $other_purpose_reason, $other_purpose_liable_person, $user_id, $date_time);
                $data['message']="$care_label_no Successfully Processed !";
            }
            if($warehouse_qa_type == 5){
                $data['message']="$care_label_no Already Sent as Other Purpose!";
            }
        }

        if($carton_status==1){
            $data['exception']="Failed! $care_label_no Already in Carton!";
        }


        $this->session->set_userdata($data);

        redirect('access/other_purpose');
    }

    public function saveAsWarehouse(){
        $this->session->unset_userdata('exception');
        $this->session->unset_userdata('message');

        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $user_id = $this->session->userdata('id');
        $get_data['user_name'] = $this->session->userdata('user_name');
        $get_data['user_description'] = $this->session->userdata('user_description');
        $get_data['access_points'] = $this->session->userdata('access_points');

        $warehouse_code = $this->input->post('warehouse_code');
        $care_label_no = $this->input->post('carelabel_tracking_no');

        if($warehouse_code == 'wb00001.'){
            $store_type = 1;
            $msg_content = 'Warehouse Buyer';
        }

        if($warehouse_code == 'wf00002.'){
            $store_type = 2;
            $msg_content = 'Warehouse Factory';
        }

        if($warehouse_code == 'wt00003.'){
            $store_type = 3;
            $msg_content = 'Warehouse Trash';
        }

        if($warehouse_code == 'wp00004.'){
            $store_type = 4;
            $msg_content = 'Warehouse Production Sample';
        }



        $care_label_info = $this->access_model->getCareLabelShirtInfo($care_label_no);
        $carton_status = $care_label_info[0]['carton_status'];
        $warehouse_qa_type = $care_label_info[0]['warehouse_qa_type'];

        if($carton_status==0){
            if($warehouse_qa_type != 5){
                $this->access_model->storeAsWarehouseGoods($care_label_no, $store_type, $user_id, $date_time);
                $data['message']="$care_label_no Sent to $msg_content !";
            }
            if($warehouse_qa_type == 5){
                $data['exception']="$care_label_no Already Sent as Other Purpose !";
            }
            if($warehouse_qa_type == $store_type){
                $data['message']="$care_label_no Already Sent to $msg_content !";
            }
        }

        if($carton_status==1){
            $data['exception']="Failed! $care_label_no Already in Carton!";
        }


        $this->session->set_userdata($data);

        redirect('access/qa_warehouse');
    }

    public function saveAsWarehouseNew(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $user_id = $this->session->userdata('id');
        $get_data['user_name'] = $this->session->userdata('user_name');
        $get_data['user_description'] = $this->session->userdata('user_description');
        $get_data['access_points'] = $this->session->userdata('access_points');

        $cl_array = $this->input->post('cl_array');
        $warehouse_type = $this->input->post('warehouse_type');
        $season = $this->input->post('season');
        $remarks_array = $this->input->post('remarks_array');

        $failed_cls = array();

        foreach ($cl_array as $k => $v){
            $care_label_no = $v;
            $remarks = $remarks_array[$k];

            $care_label_info = $this->access_model->getCareLabelDetailByClNo($care_label_no);
            $line_id = $care_label_info[0]['line_id'];
            $packing_status = $care_label_info[0]['packing_status'];
            $carton_status = $care_label_info[0]['carton_status'];
            $warehouse_qa_type = $care_label_info[0]['warehouse_qa_type'];

            if($warehouse_type != 3){
                if($carton_status==0 && $packing_status==1){
                    if($warehouse_qa_type != 5){
                        $this->access_model->storeAsWarehouseGoods($care_label_no, $warehouse_type, $season, $user_id, $date_time, $remarks);
                    }
                    if($warehouse_qa_type == 5){
                        $exception="$care_label_no Already Sent as Other Purpose !";
                        array_push($failed_cls, $exception);
                    }
                }

                if($packing_status==0){
                    $exception="Failed! $care_label_no Packing not Completed!";
                    array_push($failed_cls, $exception);
                }

                if($carton_status==1){
                    $exception="Failed! $care_label_no Already in Carton!";
                    array_push($failed_cls, $exception);
                }
            }

            if($warehouse_type == 3){

                if(sizeof($care_label_info) > 0){
                    $this->access_model->warehouseTrashUpdate($care_label_no, $warehouse_type, $season, $user_id, $date_time, $remarks);
                }
                if(sizeof($care_label_info)==0){
                    $exception="Failed! $care_label_no Not Found!";
                    array_push($failed_cls, $exception);
                }

            }

        }

        $data['cl_list_array']=$failed_cls;
        $this->session->set_userdata($data);

        echo 'DONE';

    }

    public function cartonSave_pre(){
        $this->session->unset_userdata('exception');
        $this->session->unset_userdata('message');

        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $floor_id = $this->session->userdata('floor_id');
        $get_data['user_name'] = $this->session->userdata('user_name');
        $get_data['user_description'] = $this->session->userdata('user_description');
        $get_data['access_points'] = $this->session->userdata('access_points');

        $access_points = $this->session->userdata('access_points');

        $carelabel_tracking_no = $this->input->post('carelabel_tracking_no');

        $line_check = $this->access_model->lineCheckofCL($carelabel_tracking_no);

        $sent_to_production = $line_check[0]['sent_to_production'];
        $last_access_points = $line_check[0]['access_points'];
        $access_points_status = $line_check[0]['access_points_status'];
        $washing_status = $line_check[0]['washing_status'];
        $is_wash_gmt = $line_check[0]['is_wash_gmt'];
        $packing_status = $line_check[0]['packing_status'];
        $carton_status = $line_check[0]['carton_status'];
        $warehouse_qa_type = $line_check[0]['warehouse_qa_type'];


        if($packing_status == 1){
            if(($packing_status == 1) && ($carton_status != 1) && ($warehouse_qa_type != 3)){
                $this->access_model->cartonShirt($carelabel_tracking_no, 1, $date_time, $floor_id);
                $this->access_model->warehouseRelease($carelabel_tracking_no, 0);

                $data['message']="$carelabel_tracking_no Successfully in Carton!";
                $this->session->set_userdata($data);
            }elseif(($carton_status == 1) && ($packing_status == 1) && ($warehouse_qa_type != 3)){
                $data['message']="$carelabel_tracking_no Already in Carton!";
                $this->session->set_userdata($data);
            }else{
                $data['exception']="Failed! $carelabel_tracking_no in Trash!";
                $this->session->set_userdata($data);
            }
        }

        if($packing_status == 0){
                $data['exception']="$carelabel_tracking_no Packing Not Completed!";
                $this->session->set_userdata($data);
        }

        redirect('access/care_label_carton');

    }

    public function cartonSave(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $s_data['session_last_action_date_time'] = $date_time;
        $this->session->set_userdata($s_data);

        $floor_id = $this->session->userdata('floor_id');
        $get_data['user_name'] = $this->session->userdata('user_name');
        $get_data['user_description'] = $this->session->userdata('user_description');
        $get_data['access_points'] = $this->session->userdata('access_points');

        $access_points = $this->session->userdata('access_points');

        $carelabel_tracking_no = $this->input->post('care_label_no');

        $line_check = $this->access_model->lineCheckofCL($carelabel_tracking_no);

        $sent_to_production = $line_check[0]['sent_to_production'];
        $last_access_points = $line_check[0]['access_points'];
        $access_points_status = $line_check[0]['access_points_status'];
        $washing_status = $line_check[0]['washing_status'];
        $is_wash_gmt = $line_check[0]['is_wash_gmt'];
        $packing_status = $line_check[0]['packing_status'];
        $carton_status = $line_check[0]['carton_status'];
        $warehouse_qa_type = $line_check[0]['warehouse_qa_type'];
        $manually_closed = $line_check[0]['manually_closed'];



        if(sizeof($line_check) > 0){
            if($manually_closed == 1){
                echo 'closed';
            }else{
                if($packing_status == 1){
                    if(($packing_status == 1) && ($carton_status != 1) && ($warehouse_qa_type != 3)){
                        $this->access_model->cartonShirt($carelabel_tracking_no, 1, $date_time, $floor_id);
                        $this->access_model->warehouseRelease($carelabel_tracking_no, 0);

                        echo "Successfully in Carton!";
                    }elseif(($carton_status == 1) && ($packing_status == 1) && ($warehouse_qa_type != 3)){
                        echo "Already in Carton!";
                    }else{
                        echo "In Trash!";
                    }
                }

                if($packing_status == 0){
                    echo "Packing Not Completed!";
                }
            }

        }else{
            echo "Not Found!";
        }

    }

//    public function bundleCollarCuffTracking(){
//        $this->session->unset_userdata('exception');
//        $this->session->unset_userdata('message');
//
//        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
//        
//        $date_time=$datex->format('Y-m-d H:i:s');
//        $date=$datex->format('Y-m-d');
//
//        $get_data['user_name'] = $this->session->userdata('user_name');
//        $get_data['access_points'] = $this->session->userdata('access_points');
//
//        $access_points = $this->session->userdata('access_points');
//        $line_id = $this->session->userdata('line_id');
//
//        $bundle_tracking_no = $this->input->post('bundle_tracking_no');
//
////        $line_check = $this->access_model->lineCheckofBundle($bundle_tracking_no);
//        $cc_check = $this->access_model->isCCUpdatedAlready($bundle_tracking_no);
////        $size_of_array = sizeof($line_check);
//        $id = $cc_check[0]['line_id'];
//        $is_bundle_collar_cuff_scanned_line = $cc_check[0]['is_bundle_collar_cuff_scanned_line'];
//
//        // re-program
//        if(($id == 0) && ($is_bundle_collar_cuff_scanned_line == 0)){
//            $this->access_model->collarCuffTracking($bundle_tracking_no, $line_id, $date_time);
//
//            $data['message']='Collar-Cuff Tracked!';
//            $this->session->set_userdata($data);
//        }else{
//            $data['exception']='Collar Cuff Already Tracked!';
//            $this->session->set_userdata($data);
//        }
//
//        redirect('access/bundle_collar_cuff_track');
//    }


    public function finishingFloorOutputReport(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $floor_id = $this->session->userdata('floor_id');

        $where = '';
        $where1 = '';

        if($floor_id != '' && $floor_id != 0){
            $where .= " AND t1.id=$floor_id";
            $where1 .= " AND floor_id=$floor_id AND date='$date'";

            $finishing_trgt = $this->access_model->getFinishingTarget($where1);

            $data['finishing_target'] = $finishing_trgt[0]['target'];


            $finishing_report = $this->access_model->getFinishingFloorOutputReport($where, $date);
            $data['finishing_output_qty'] = $finishing_report[0]['finishing_output_qty'];
            $data['floor_name'] = $finishing_report[0]['floor_name'];
        }

        $data['maincontent'] = $this->load->view('finishing_floor_performance_dashboard', $data, true);
        $this->load->view('master_line', $data);
    }

    public function bundleCollarCuffTracking(){

        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $s_data['session_last_action_date_time'] = $date_time;
        $this->session->set_userdata($s_data);

        $get_data['user_name'] = $this->session->userdata('user_name');
        $get_data['user_description'] = $this->session->userdata('user_description');
        $get_data['access_points'] = $this->session->userdata('access_points');

        $access_points = $this->session->userdata('access_points');
        $line_id = $this->session->userdata('line_id');

        $bundle_track_no = $this->input->post('bundle_tracking_no');

        $bundle_type_status = strtolower(substr($bundle_track_no, -4));
        $bundle_tracking_no = substr_replace($bundle_track_no ,"",-4);
        $cc_check = $this->access_model->isCCUpdatedAlready($bundle_tracking_no);
        $id = $cc_check[0]['line_id'];
        $is_bundle_collar_cuff_scanned_line = $cc_check[0]['is_bundle_collar_cuff_scanned_line'];
        $is_bundle_collar_scanned_line = $cc_check[0]['is_bundle_collar_scanned_line'];
        $is_cutting_collar_bundle_ready = $cc_check[0]['is_cutting_collar_bundle_ready'];
        $is_bundle_cuff_scanned_line = $cc_check[0]['is_bundle_cuff_scanned_line'];
        $is_cutting_cuff_bundle_ready = $cc_check[0]['is_cutting_cuff_bundle_ready'];

        if(($bundle_type_status != 'cff.') && ($bundle_type_status != 'clr.') && ($bundle_type_status != 'bdy.')){
            echo 'Failed to Track!';
        }else{
            if(($bundle_type_status == 'clr.') && ($is_bundle_collar_cuff_scanned_line == 0) && ($is_bundle_collar_scanned_line == 0)){
//            echo "$bundle_tracking_no collar to be updated!";
                if($is_cutting_collar_bundle_ready == 1){
                    $this->access_model->collarTracking($bundle_tracking_no, $line_id, $date_time);

                    if($is_bundle_cuff_scanned_line == 1){
                        $this->access_model->collarCuffTracking($bundle_tracking_no, $line_id, $date_time);
                    }

                    echo "Collar Tracked!";
                }else{
                    echo "Previous Process Pending!";
                }

            }

            if (($bundle_type_status == 'cff.') && ($is_bundle_collar_cuff_scanned_line == 0) && ($is_bundle_cuff_scanned_line == 0)){
//            echo "$bundle_tracking_no cuff to be updated!";
                if($is_cutting_cuff_bundle_ready == 1){
                    $this->access_model->cuffTracking($bundle_tracking_no, $line_id, $date_time);

                    if($is_bundle_collar_scanned_line == 1){
                        $this->access_model->collarCuffTracking($bundle_tracking_no, $line_id, $date_time);
                    }

                    echo "Cuff Tracked!";
                }else{
                    echo "Previous Process Pending!";
                }

            }

//            elseif(($id == 0) && ($is_bundle_collar_cuff_scanned_line == 0) && ($bundle_type_status == 'bdy.')){
//                $this->access_model->collarCuffTracking($bundle_tracking_no, $line_id, $date_time);
//
//                $data['message']='Collar-Cuff Tracked!';
//                $this->session->set_userdata($data);
//            }

            if (($bundle_type_status == 'clr.') && ($is_bundle_collar_scanned_line == 1) && ($is_cutting_collar_bundle_ready == 1)){
                echo "Collar Tracked Already!";
            }

            if (($bundle_type_status == 'cff.') && ($is_bundle_cuff_scanned_line == 1) && ($is_cutting_cuff_bundle_ready == 1)){
                echo "Cuff Tracked Already!";
            }

            if(($bundle_type_status == 'bdy.')){
                $this->access_model->collarCuffTracking($bundle_tracking_no, $line_id, $date_time);

                echo "Please Scan Collar/Cuff!";
            }
        }


//        echo '<pre>';
//        print_r($bundle_tracking_no);
//        echo '</pre>';
//        die();

//        $line_check = $this->access_model->lineCheckofBundle($bundle_tracking_no);
//        $cc_check = $this->access_model->isCCUpdatedAlready($bundle_tracking_no);
//        $size_of_array = sizeof($line_check);
//        $id = $cc_check[0]['line_id'];
//        $is_bundle_collar_cuff_scanned_line = $cc_check[0]['is_bundle_collar_cuff_scanned_line'];

        // re-program
//        if(($id == 0) && ($is_bundle_collar_cuff_scanned_line == 0)){
//            $this->access_model->collarCuffTracking($bundle_tracking_no, $line_id, $date_time);
//
//            $data['message']='Collar-Cuff Tracked!';
//            $this->session->set_userdata($data);
//        }else{
//            $data['exception']='Collar Cuff Already Tracked!';
//            $this->session->set_userdata($data);
//        }

//        redirect('access/bundle_collar_cuff_track');
    }

    public function bundleCollarCuffTracking_pre(){
        $this->session->unset_userdata('exception');
        $this->session->unset_userdata('message');

        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $get_data['user_name'] = $this->session->userdata('user_name');
        $get_data['user_description'] = $this->session->userdata('user_description');
        $get_data['access_points'] = $this->session->userdata('access_points');

        $access_points = $this->session->userdata('access_points');
        $line_id = $this->session->userdata('line_id');

        $bundle_track_no = $this->input->post('bundle_tracking_no');

        $bundle_type_status = strtolower(substr($bundle_track_no, -4));
        $bundle_tracking_no = substr_replace($bundle_track_no ,"",-4);
        $cc_check = $this->access_model->isCCUpdatedAlready($bundle_tracking_no);
        $id = $cc_check[0]['line_id'];
        $is_bundle_collar_cuff_scanned_line = $cc_check[0]['is_bundle_collar_cuff_scanned_line'];
        $is_bundle_collar_scanned_line = $cc_check[0]['is_bundle_collar_scanned_line'];
        $is_cutting_collar_bundle_ready = $cc_check[0]['is_cutting_collar_bundle_ready'];
        $is_bundle_cuff_scanned_line = $cc_check[0]['is_bundle_cuff_scanned_line'];
        $is_cutting_cuff_bundle_ready = $cc_check[0]['is_cutting_cuff_bundle_ready'];

        if(($bundle_type_status != 'cff.') && ($bundle_type_status != 'clr.') && ($bundle_type_status != 'bdy.')){
            $data['exception']='Failed to Track!';
            $this->session->set_userdata($data);
        }else{
            if(($bundle_type_status == 'clr.') && ($is_bundle_collar_cuff_scanned_line == 0) && ($is_bundle_collar_scanned_line == 0)){
//            echo "$bundle_tracking_no collar to be updated!";
                if($is_cutting_collar_bundle_ready == 1){
                    $this->access_model->collarTracking($bundle_tracking_no, $line_id, $date_time);

                    if($is_bundle_cuff_scanned_line == 1){
                        $this->access_model->collarCuffTracking($bundle_tracking_no, $line_id, $date_time);
                    }

                    $data['message']="$bundle_tracking_no Collar Tracked!";
                    $this->session->set_userdata($data);
                }else{
                    $data['exception']="$bundle_tracking_no Previous Process Pending!";
                    $this->session->set_userdata($data);
                }

            }

            if (($bundle_type_status == 'cff.') && ($is_bundle_collar_cuff_scanned_line == 0) && ($is_bundle_cuff_scanned_line == 0)){
//            echo "$bundle_tracking_no cuff to be updated!";
                if($is_cutting_cuff_bundle_ready == 1){
                    $this->access_model->cuffTracking($bundle_tracking_no, $line_id, $date_time);

                    if($is_bundle_collar_scanned_line == 1){
                        $this->access_model->collarCuffTracking($bundle_tracking_no, $line_id, $date_time);
                    }

                    $data['message']="$bundle_tracking_no Cuff Tracked!";
                    $this->session->set_userdata($data);
                }else{
                    $data['exception']="$bundle_tracking_no Previous Process Pending!";
                    $this->session->set_userdata($data);
                }

            }

//            elseif(($id == 0) && ($is_bundle_collar_cuff_scanned_line == 0) && ($bundle_type_status == 'bdy.')){
//                $this->access_model->collarCuffTracking($bundle_tracking_no, $line_id, $date_time);
//
//                $data['message']='Collar-Cuff Tracked!';
//                $this->session->set_userdata($data);
//            }

            if (($bundle_type_status == 'clr.') && ($is_bundle_collar_scanned_line == 1) && ($is_cutting_collar_bundle_ready == 1)){
                $data['message']="$bundle_tracking_no Collar Tracked Already!";
                $this->session->set_userdata($data);
            }

            if (($bundle_type_status == 'cff.') && ($is_bundle_cuff_scanned_line == 1) && ($is_cutting_cuff_bundle_ready == 1)){
                $data['message']="$bundle_tracking_no Cuff Tracked Already!";
                $this->session->set_userdata($data);
            }

            if(($bundle_type_status == 'bdy.')){
                $this->access_model->collarCuffTracking($bundle_tracking_no, $line_id, $date_time);

                $data['exception']='Please Scan Collar/Cuff!';
                $this->session->set_userdata($data);
            }
        }


//        echo '<pre>';
//        print_r($bundle_tracking_no);
//        echo '</pre>';
//        die();

//        $line_check = $this->access_model->lineCheckofBundle($bundle_tracking_no);
//        $cc_check = $this->access_model->isCCUpdatedAlready($bundle_tracking_no);
//        $size_of_array = sizeof($line_check);
//        $id = $cc_check[0]['line_id'];
//        $is_bundle_collar_cuff_scanned_line = $cc_check[0]['is_bundle_collar_cuff_scanned_line'];

        // re-program
//        if(($id == 0) && ($is_bundle_collar_cuff_scanned_line == 0)){
//            $this->access_model->collarCuffTracking($bundle_tracking_no, $line_id, $date_time);
//
//            $data['message']='Collar-Cuff Tracked!';
//            $this->session->set_userdata($data);
//        }else{
//            $data['exception']='Collar Cuff Already Tracked!';
//            $this->session->set_userdata($data);
//        }

        redirect('access/bundle_collar_cuff_track');
    }

    public function cutting(){
        $data['title'] = 'Cutting';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $get_data['sap_no'] = $this->access_model->getSapPoNo();
        $get_data['tables'] = $this->access_model->getTables();
        $data['maincontent'] = $this->load->view('cutting_new', $get_data, true);
        $this->load->view('master', $data);
    }

    public function cutting_new(){
        $data['title'] = 'Cutting - NEW';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
        $get_data['sap_no'] = $this->access_model->getSapPoNo();
        $get_data['tables'] = $this->access_model->getTables();
        $get_data['cut_no'] = $this->access_model->getCutNoList();

        $data['maincontent'] = $this->load->view('cutting', $get_data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function multiple_po_item_remain_qty_excel(){
        $data['title'] = 'EXCEL of PO-ITEM-SIZE QTY';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
        $get_data['so_list'] = $this->access_model->getSapPoNo();

        $data['maincontent'] = $this->load->view('multiple_po_item_remain_qty_excel', $get_data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function getPoItemSizeRemainQty(){
        $sales_order = $this->input->post('sales_order');

        $data['sales_order'] = $sales_order;

        $data['sizes'] = $this->access_model->getSizesBySapNo($sales_order);

        $data['po_item'] = $this->access_model->getPoItemBySapNo($sales_order);

        $data['po_item_size_cut_qty'] = $this->access_model->getSizeWisePoItemCutQty($sales_order);

        echo $this->load->view('po_item_size_qty_table', $data, true);
    }

    public function saveBundleCutNew(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $sap_no = $this->input->post('sap_no');
        $cut_no = $this->input->post('cut_no');
        $brand = $this->input->post('brand');
        $style_no = $this->input->post('style_no');
        $style_name = $this->input->post('style_name');
        $color = $this->input->post('color');
        $ex_factory_date = $this->input->post('ex_factory_date');
        $actual_cut_qty = $this->input->post('actual_cut_qty');
        $planned_cut_qty = $this->input->post('planned_cut_qty');
        $quality = $this->input->post('quality');
        $po_type = $this->input->post('po_type');
        $style_type = $this->input->post('style_type');

        $size_field = "size";
        $qty_field = "qty";
        $item_field = "item";
        $purchase_order_field = "purchase_order";
        $so_no_field = "so_no";
        $lay_field = "lay";

        $sizes = $this->input->post("$size_field");
        $qty = $this->input->post("$qty_field");
        $purchase_order = $this->input->post("$purchase_order_field");
        $s_no = $this->input->post("$so_no_field");
        $item_no = $this->input->post("$item_field");
        $lay_no = $this->input->post("$lay_field");


        $count_tables = $this->input->post('count_tables');
        $count_rows = $this->input->post('count_rows');

        $sap_no_last_five = substr($sap_no, -5);
        $style_no_last_four = substr($style_no, -4);

//        $cut_info = $this->access_model->getCutInfo($sap_no, $cut_no);
        $cut_info = $this->access_model->getCutInfoByPoItem($sap_no, $purchase_order[0], $item_no[0]);
        $actual_cut_qty_till_prev_cut = $cut_info[0]['bundle_range_end'];
        $bundle_no_till_prev_cut = $cut_info[0]['bundle'];

        $res_last_cl = $this->access_model->getLastCareLabel();
        $pc_tracking_no = $res_last_cl[0]['pc_tracking_no'];

        $pc_tracking_no_int = (int)$pc_tracking_no;

        $bundle_start = 1;
        if($actual_cut_qty_till_prev_cut > 0){
            $bundle_end = $actual_cut_qty_till_prev_cut;
        }else{
            $bundle_end = 0;
        }
//        $bundle_end = 0;

        if($bundle_no_till_prev_cut > 0){
            $b_count = $bundle_no_till_prev_cut + 1;
        }
        else{
            $b_count = $bundle_no_till_prev_cut + 1;
        }
//        $b_count = 1;

//        echo '<pre>';
//        print_r("SAP: ".$sap_no.' / '."Cut: ".$cut_no.' / '."Style No: ".$style_no.' / '."Style Name: ".$style_name.' / '."Color: ".$color.' / '."Quality: ".$quality.' / '."Planned Qty: ".$planned_cut_qty.' / '."Actual Qty: ".$actual_cut_qty);
//        echo '</pre>';
//        echo '<br />';

//        for($i=0; $i <= ($count_rows - 1); $i++){
//            for($j=0; $j <= ($count_tables - 1); $j++){

                $return_data = '';

                $min_cl_no=0;
                $max_cl_no=0;

                foreach ($purchase_order as $k_s => $v_s){
                    $quantity = $qty[$k_s];
                    $po_no = $purchase_order[$k_s];
                    $so_no = $s_no;
                    $item = $item_no[$k_s];
                    $lay = $lay_no[$k_s];
                    $size = $sizes[$k_s];

                    $po_no_last_four = substr($po_no, -4);

                    if(($quantity != 0) && ($quantity != '')){
//                        echo '<pre>';
//                        print_r("PO: ".$po_no.' / '."Item: ".$item.' / '."Size: ".$size.'-'.$lay.' / '."Qty: ".$quantity);
//                        echo '</pre>';

                        $cut_seg = ($quantity/10);
                        $round_cut_seg = round($cut_seg);
                        $floor_cut_seg = floor($cut_seg);
                        $after_dec = ($cut_seg - (int)$cut_seg) * 10;

//                        echo '<pre>';
//                        print_r($cut_seg);
//                        echo '</pre>';

                        if($round_cut_seg < $cut_seg){
                            $bundle_cut = $round_cut_seg + 1;
                        }else{
                            $bundle_cut = $round_cut_seg;
                        }

                        // first
                        // do something

                        for ($i=1; $i <= $bundle_cut; $i++){

                            if($floor_cut_seg >= $i){
                                $bundle_start = $bundle_end+1 ;
                                $bundle_end = ($bundle_start + 10) - 1;
                            }

                            if($floor_cut_seg < $i){
                                $bundle_start = $bundle_end+1 ;
                                $bundle_end = ($bundle_start + $after_dec) - 1;
                            }


                            $max_cl_no = $pc_tracking_no_int + (($bundle_end - $bundle_start) + 1);

                            if(($max_cl_no - (($bundle_end - $bundle_start))) > 0){
                                $min_cl_no = $max_cl_no - (($bundle_end - $bundle_start));
                            }else{
                                $min_cl_no = $pc_tracking_no_int + 1;
                            }

//                            $bundle_range = $bundle_start.'-'.$bundle_end;
//                            $bundle_range_count = ($bundle_end - $bundle_start)+1;


//                     $bundle_tracking_no = $sap_no_last_five.'_'.$cut_no.'_'.$po_no_last_four.'_'.$item.'_'.$size.'-'.$lay.'_'.$b_count; //Previous Bundle Card Code
//                     $cut_tracking_no = $sap_no_last_five.'_'.$cut_no.'_'.$po_no_last_four.'_'.$item; //Previous Cutting Number Code


                    $bundle_tracking_no = $so_no.'_'.$cut_no.'_'.$size.'-'.$lay.'_'.$b_count; //New Bundle Card Code
                    $cut_tracking_no = $sap_no.'_'.$cut_no; //New Cutting Number Code

//                    echo '<pre>';
//                    print_r("Bundle Tracking No: ".$bundle_tracking_no); // $i=bundle_count reviously
//                    echo '</pre>';

//                    echo '<pre>';
//                    print_r("Bundle No: ".$b_count. ":".$bundle_start.'-'.$bundle_end.'-'.$lay);
//                    echo '</pre>';

                    $bundle_range = $bundle_start.'-'.$bundle_end;
                    $ct_qty = ($bundle_end - $bundle_start) + 1;



                            for($j=1; $j <= $ct_qty; $j++){


                                $pc_tracking_no_int = $pc_tracking_no_int + 1;

                                if($pc_tracking_no_int == 1000000000){
                                    $pc_tracking_no_int = 0;
                                    $pc_tracking_no_int = $pc_tracking_no_int + 1;
                                }
                                elseif ($pc_tracking_no_int < 1000000000){
                                    $pc_tracking_no_int = $pc_tracking_no_int;
                                }

                                $bundle_tracking_num = "$bundle_tracking_no.'.'";

                                $data_cl['pc_tracking_no'] = sprintf("%010s", $pc_tracking_no_int.'.');
                                $data_cl['cut_tracking_no'] = $cut_tracking_no.'.';
                                $data_cl['po_no'] = $sap_no;
                                $data_cl['so_no'] = $so_no;
                                $data_cl['purchase_order'] = $po_no;
                                $data_cl['item'] = "$item";
                                $data_cl['quality'] = "$quality";
                                $data_cl['style_no'] = "$style_no";
                                $data_cl['style_name'] = "$style_name";
                                $data_cl['brand'] = "$brand";
                                $data_cl['size'] = "$size";
                                $data_cl['color'] = "$color";
                                $data_cl['ex_factory_date'] = "$ex_factory_date";
                                $data_cl['cut_no'] = "$cut_no";
                                $data_cl['bundle_no'] = $b_count;
                                $data_cl['bundle_tracking_no'] = $bundle_tracking_no.'.';
                                $data_cl['bundle_range'] = $bundle_range;
                                $data_cl['layer_group'] = $lay;
                                $data_cl['date_time'] = $date_time;
                                $data_cl['po_type'] = $po_type;

                                array_push($bundle_tracking_no_array, $bundle_tracking_num);

                                $this->access_model->insertingData('tb_care_labels', $data_cl);
                            }

                    $data_summary = array(
                        'po_no' => $sap_no,
                        'so_no' => $so_no,
                        'purchase_order' => $po_no,
                        'item' => $item,
                        'quality' => $quality,
                        'style_no' => $style_no,
                        'style_name' => $style_name,
                        'color' => $color,
                        'ex_factory_date' => "$ex_factory_date",
                        'brand' => "$brand",
                        'bundle' => $b_count,
                        'cut_no' => "$cut_no",
                        'cut_tracking_no' => $cut_tracking_no.'.',
                        'bundle_tracking_no' => $bundle_tracking_no.'.',
                        'size' => $size,
                        'cut_qty' => $ct_qty,
                        'planned_cut_qty' => $planned_cut_qty,
                        'cut_layer' => $lay,
                        'bundle_range' => $bundle_range,
                        'bundle_range_start' => $bundle_start,
                        'bundle_range_end' => $bundle_end,
                        'pc_no_start' => $min_cl_no,
                        'pc_no_end' => $max_cl_no,
                        'u_id' => '',
                        'date_time' => $date_time,
                        'style_type' => $style_type,
                        'po_type' => $po_type
                    );

                    $this->access_model->insertingData('tb_cut_summary', $data_summary);

                            $b_count = $b_count + 1;
                        }
                    }
                }

                echo $cut_tracking_no.'.';
//            }
//        }
    }

//    public function saveBundleCutNew(){
//        $sap_no = $this->input->post('sap_no');
//        $cut_no = $this->input->post('cut_no');
//
//        $count_tables = $this->input->post('count_tables');
//        $count_rows = $this->input->post('count_rows');
//
//        echo '<pre>';
//        print_r("SAP: ".$sap_no.' / '."Cut: ".$cut_no);
//        echo '</pre>';
//        echo '<br />';
//
//        for($i=0; $i <= ($count_rows - 1); $i++){
//            for($j=0; $j <= ($count_tables - 1); $j++){
//                $size_field = "size_".$j."_".$i;
//                $qty_field = "qty_".$j."_".$i;
//                $item_field = "item_".$j."_".$i;
//                $purchase_order_field = "purchase_order_".$j."_".$i;
//                $lay_field = "lay_".$j."_".$i;
//
//                $sizes = $this->input->post("$size_field");
//                $qty = $this->input->post("$qty_field");
//                $purchase_order = $this->input->post("$purchase_order_field");
//                $item_no = $this->input->post("$item_field");
//                $lay_no = $this->input->post("$lay_field");
//
//                foreach ($sizes as $k_s => $v_s){
//                    $quantity = $qty[$k_s];
//                    $po_no = $purchase_order[$k_s];
//                    $item = $item_no[$k_s];
//                    $lay = $lay_no[$k_s];
//
//                    if(($quantity != 0) && ($quantity != '')){
//                        echo '<pre>';
//                        print_r("PO: ".$po_no.' / '."Item: ".$item.' / '."Size: ".$v_s.' / '."Qty: ".$quantity.' / '."Lay: ".$lay);
//                        echo '</pre>';
//                    }
//                }
//            }
//        }
//    }

    public function poWiseCuttingReport(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['title'] = 'PO Wise Cutting Report';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $get_data['purchase_order_nos'] = $this->access_model->getAllPurchaseOrders();

        $get_data['order_info'] = $this->access_model->getPoOrderInfo($date);

        $data['maincontent'] = $this->load->view('po_wise_cutting_report', $get_data, true);
        $this->load->view('master', $data);
    }

    public function lineWisePoItemReport(){
        $data['title'] = 'Line Wise PO-Item Report';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $data['lines'] = $this->access_model->getLines();

        $data['maincontent'] = $this->load->view('line_wise_po_item_report', $data, true);
        $this->load->view('master', $data);
    }

    public function getLineWisePoItemReport(){
        $line_no = $this->input->post('line_no');

        $data['line_po_items'] = $this->access_model->getLineWisePoItem($line_no);

        echo $maincontent = $this->load->view('line_po_item_report', $data, true);
    }

    public function sizeCutLayerWisePoItems($po_no, $size, $cut_no, $cut_layer){
        $cut_order = $this->access_model->sizeCutLayerWisePoItems($po_no, $size, $cut_no, $cut_layer);

        return $cut_order;
    }

    public function poWiseCuttingInfo($purchase_order, $item, $style_no, $quality, $color){

        $where = '';

        if($purchase_order != ''){
            $where .= " AND A.purchase_order like '%$purchase_order%'";
        }

        if($item != ''){
            $where .= " AND A.item like '%$item%'";
        }

        if($style_no != ''){
            $where .= " AND A.style_no like '%$style_no%'";
        }

        if($quality != ''){
            $where .= " AND A.quality like '%$quality%'";
        }

        if($color != ''){
            $where .= " AND A.color like '%$color%'";
        }

        $cut_order = $this->access_model->getPoWiseCuttingInfo($where);

        return $cut_order;
    }

    public function poItemSizeCutLayerWiseQty($po_no, $so_no, $purchase_order, $item, $size, $cut_no, $cut_layer){
        $cut_order_qty = $this->access_model->poItemSizeCutLayerWiseQty($po_no, $so_no, $purchase_order, $item, $size, $cut_no, $cut_layer);

        return $cut_order_qty;
    }

    public function poItemSizeCutLayerWiseQtyNew($po_no, $so_no, $purchase_order, $item, $size, $cut_no, $cut_layer){
        $cut_order_qty = $this->access_model->poItemSizeCutLayerWiseQtyNew($po_no, $so_no, $purchase_order, $item, $size, $cut_no, $cut_layer);

        return $cut_order_qty;
    }

    public function poItemWiseQtyNew($po_no, $so_no, $purchase_order, $item, $cut_no){
        $cut_order_qty = $this->access_model->poItemWiseQtyNew($po_no, $so_no, $purchase_order, $item, $cut_no);

        return $cut_order_qty;
    }

    public function print_input_ticket(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['title'] = 'Input Ticket';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
        $data['sap_no'] = $this->access_model->getSapPoNo();
        $data['cut_no'] = $this->access_model->getCutNoList();

        $data['maincontent'] = $this->load->view('print_input_ticket', $data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function print_bundle_summary_page(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['title'] = 'Print Bundle Summary';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
        $data['sap_no'] = $this->access_model->getSapPoNo();
        $data['cut_no'] = $this->access_model->getCutNoList();

        $data['maincontent'] = $this->load->view('print_bundle_summary_page', $data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function getPoCutInputSummaryTicket($po_no, $cut_no){

        $where = '';

        if($po_no != ''){
            $where .= " AND po_no='$po_no'";
        }

        if($cut_no != ''){
            $where .= " AND cut_no='$cut_no'";
        }

        $res = $this->access_model->checkPackageReady($where);

        if(sizeof($res) > 0){
            $this->printInputTicket($po_no, $cut_no);
        }else{
            echo '<h1>Package Not Ready!</h1>';
        }
    }

    public function printInputTicket($po_no, $cut_no){

        $get_data['po_no'] = $po_no;
        $get_data['cut_no'] = $cut_no;
        $get_data['po_cut_summary'] = $this->access_model->getPoCutSummaryInfo($po_no, $cut_no);

        if(!empty($get_data['po_cut_summary'])){

                if($po_no != '' && $cut_no != '')
                {
                    $input_ticket_no = $po_no.'_'.$cut_no;

                    $get_data['input_ticket_no'] = $input_ticket_no;

                    $this->load->library('ciqrcode');
                    $qr_image=$input_ticket_no.'.png';
                    $params['data'] = $input_ticket_no;
                    $params['level'] = 'H';
                    $params['size'] = 8;
                    $params['savename'] =FCPATH."uploads/qr_image/".$qr_image;


                    if($this->ciqrcode->generate($params))
                    {
                        $data['img_url']=$qr_image;
                    }
                }

        }

        $data['maincontent'] = $this->load->view('generated_input_ticket', $get_data);
    }

    public function getBundleSummary(){
        $sap_no = $this->input->post('sap_no');
        $cut_no = $this->input->post('cut_no');

        $data['po_items'] = $this->access_model->getPoItemBySapCut($sap_no, $cut_no);
        $data['cut_order_summary'] = $this->access_model->getBundleSummary($sap_no, $cut_no);

//        echo json_encode($data['cut_order_summary']);

        echo $maincontent = $this->load->view('bundle_summary_tbl', $data, true);
    }

    public function getBundleSummaryNew(){
        $sap_no = $this->input->post('sap_no');
        $cut_nos = $this->input->post('cut_no');

        foreach($cut_nos as $cut_no){
            $data['po_items'] = $this->access_model->getPoItemBySapCut($sap_no, $cut_no);
            $data['cut_order_summary'] = $this->access_model->getBundleSummary($sap_no, $cut_no);

            $cut_tracking_nos = $this->access_model->getCutTrackingNo($sap_no, $cut_no);
            $cut_tracking_no=$cut_tracking_nos[0]['cut_tracking_no'];


            if($sap_no != '' && $cut_no != '')
            {
                $lay_complete = $cut_tracking_no;

                $get_data['lay_complete'] = $lay_complete;

                $this->load->library('ciqrcode');
                $qr_image=$lay_complete.'png';
                $params['data'] = $lay_complete;
                $params['level'] = 'H';
                $params['size'] = 8;
                $params['savename'] =FCPATH."uploads/qr_image/".$qr_image;


                if($this->ciqrcode->generate($params))
                {
                    $data['img_url']=$qr_image;
                }
            }

            echo $maincontent = $this->load->view('bundle_summary_tbl_new', $data, true);
        }

    }

    public function lay_scan()
    {
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $s_data['session_last_action_date_time'] = $date_time;
        $this->session->set_userdata($s_data);

        $data['title'] = 'Lay Scan';

        $line_id = $this->session->userdata('line_id');
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
        $data['tables'] = $this->access_model->getTables();

        $data['msg'] = '';
        $data['session_out'] = $this->session_out;

        $data['maincontent'] = $this->load->view('lay_scan', $data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function inputToLay()
    {
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $s_data['session_last_action_date_time'] = $date_time;

        $this->session->set_userdata($s_data);

        $get_data['user_name'] = $this->session->userdata('user_name');
        $get_data['user_description'] = $this->session->userdata('user_description');
        $get_data['access_points'] = $this->session->userdata('access_points');

        $access_points = $this->session->userdata('access_points');
        $line_id = $this->session->userdata('line_id');

        $cut_tracking_no = $this->input->post('cut_tracking_no');
        $table_no = $this->input->post('table_no');

        $chk_lay=$this->access_model->chk_lay($cut_tracking_no);
        if(sizeof($chk_lay) > 0)
        {
            echo 'already pass';
        }
        else
        {
            $this->access_model->inputToLay($cut_tracking_no, $table_no, $date_time);
            $this->access_model->inputToLayCareLabelTable($cut_tracking_no, $table_no);

            echo 'done';
        }

    }

    public function cut_scan()
    {
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $s_data['session_last_action_date_time'] = $date_time;
        $this->session->set_userdata($s_data);

        $data['title'] = 'Cut Scan';

        $line_id = $this->session->userdata('line_id');
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');
        $data['msg'] = '';
        $data['session_out'] = $this->session_out;

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
        $where = '';
        if($line_id != 0 && $line_id != ''){
            $where .= " AND t5.line_id=$line_id order by t3.max_mid_line_qc_date_time DESC";
        }
        $data['maincontent'] = $this->load->view('cut_scan', $data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function inputToCut()
    {
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $s_data['session_last_action_date_time'] = $date_time;

        $this->session->set_userdata($s_data);

        $get_data['user_name'] = $this->session->userdata('user_name');
        $get_data['user_description'] = $this->session->userdata('user_description');
        $get_data['access_points'] = $this->session->userdata('access_points');

        $access_points = $this->session->userdata('access_points');
        $line_id = $this->session->userdata('line_id');

        $carelabel_tracking_no = $this->input->post('care_label_no');

        $chk_lay=$this->access_model->check_lay($carelabel_tracking_no);
        $chk_cut=$this->access_model->check_cut($carelabel_tracking_no);

        if(sizeof($chk_lay) > 0)
        {
            if(sizeof($chk_cut) > 0)
            {
                echo 'Already Pass';
            }
            else
            {
                $this->access_model->inputToCut($carelabel_tracking_no, $date_time);
                echo 'Done';
            }

        }


        else
        {
            echo 'Pending';
        }
    }

    public function getCuttingSummaryReport(){
        $sap_no = $this->input->post('sap_no');

        $data['sap_no'] = $sap_no;

        $data['sap_info'] = $this->access_model->getTotalOrderQty($sap_no);

        $data['cut_info'] = $this->access_model->getTotalCutQty($sap_no);

        $data['cut_nos'] = $this->access_model->getCutNosBySo($sap_no);

        echo $maincontent = $this->load->view('cut_summary_report', $data, true);
    }

    public function getPoItemBySapCut($sap_no, $cut_no){

        return $data['po_items'] = $this->access_model->getPoItemBySapCut($sap_no, $cut_no);

    }

    public function getCutOrderSummary($sap_no, $cut_no){

        return $data['cut_order_summary'] = $this->access_model->getBundleSummary($sap_no, $cut_no);

    }

    public function getCuttingInfo()
    {
        $purchase_order_stuff = $this->input->post('purchase_order_stuff');

        $purchase_order_stuff_array = explode('_', $purchase_order_stuff);

        $so_no = $purchase_order_stuff_array[0];
        $po_no = $purchase_order_stuff_array[1];
        $purchase_order = $purchase_order_stuff_array[2];
        $item_week = $purchase_order_stuff_array[3];
        $color = $purchase_order_stuff_array[4];
        $ex_factory = $purchase_order_stuff_array[5];
//        echo '<pre>';
//        print_r($ex_factory);
//        echo '</pre>';
//        die();

        $where = '';
//        if($so_no != ''){
//            $where .= " AND so_no = '$so_no'";
//        }
        if($po_no != ''){
            $where .= " AND po_no = '$po_no'";
        }
//        if($purchase_order != ''){
//            $where .= " AND purchase_order = '$purchase_order'";
//        }
//        if($item_week != ''){
//            $where .= " AND item = '$item_week'";
//        }
//        if($color != ''){
//            $where .= " AND color = '$color'";
//        }
//        if($ex_factory != ''){
//            $where .= " AND ex_factory_date = '$ex_factory'";
//        }



//        $get_data['order_info'] = $this->dashboard_model->getPoOrderPackingInfobyPo($where);
        $get_data['order_info'] = $this->access_model->getPOCutListForCareLabel($where);
//        echo '<pre>';
//        print_r($get_data['order_info']);
//        echo '</pre>';
//        die();

//        $maincontent = $this->load->view('po_wise_size_cutting_report', $get_data, true);
        $maincontent = $this->load->view('cutting_test_print', $get_data, true);

        echo $maincontent;
    }

    public function getPoWiseReportbyPo(){
        $purchase_order_stuff = $this->input->post('purchase_order_stuff');

        $purchase_order_stuff_array = explode('_', $purchase_order_stuff);

        $sap_no = $purchase_order_stuff_array[0];
        $po_no = $purchase_order_stuff_array[1];
        $item_week = $purchase_order_stuff_array[2];
        $color = $purchase_order_stuff_array[3];

        $where = '';
        if($sap_no != ''){
            $where .= " AND A.po_no LIKE '%$sap_no%'";
        }
        if($po_no != ''){
            $where .= " AND A.purchase_order LIKE '%$po_no%'";
        }
        if($item_week != ''){
            $where .= " AND A.item LIKE '%$item_week%'";
        }
        if($color != ''){
            $where .= " AND A.color LIKE '%$color%'";
        }

        $get_data['order_info'] = $this->access_model->getPoOrderInfobyPo($where);

        $maincontent = $this->load->view('po_wise_cutting_report_by_po', $get_data, true);

        echo $maincontent;
    }

    public function cuttingTarget(){
        $data['title'] = 'Cutting Target Assign';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
        $data['maincontent'] = $this->load->view('assign_cutting_target', $data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function assignCuttingTarget(){
        $targets = $this->input->post('target');
        $mpr = $this->input->post('mp');
        $trgt_date = $this->input->post('target_date');

        $date=explode("-", $trgt_date);

        $target_date = $date[2].'-'.$date[0].'-'.$date[1];

        $target=0;

        foreach ($targets as $k => $trg){

            $target = $targets[$k];
            $mp = $mpr[$k];

            $data=array(
                'target' => $target,
                'man_power' => $mp,
                'date' => $target_date
            );

            $is_inputed = $this->access_model->isCuttingTargetInputed($target_date);

//            echo '<pre>';
//            print_r($is_inputed);
//            echo '</pre>';
//            die();

            if(sizeof($is_inputed) > 0){
                $this->access_model->updateCuttingTarget($target, $mp, $target_date);

                $data['message']='Successfully Cutting Target Updated!';
                $this->session->set_userdata($data);
            }
            if(sizeof($is_inputed) == 0){
                $this->access_model->insertingData('cutting_daily_target', $data);

                $data['message']='Successfully Cutting Target Assigned!';
                $this->session->set_userdata($data);
            }
        }



        redirect('access/cuttingTarget');
    }

    public function finishingTarget(){
        $data['title'] = 'Finishing Target Assign';

        $floor_id = $this->session->userdata('floor_id');
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
        $where = '';
        if($floor_id != '' && $floor_id != 0){
            $where .= " AND id = $floor_id";
        }

        $data['floors'] = $this->access_model->getFloors($where);

        $data['maincontent'] = $this->load->view('assign_finishing_target', $data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function assignFinishingTarget(){
        $floors = $this->input->post('floor_id');
        $targets = $this->input->post('target');
        $target_hr = $this->input->post('target_hour');
        $mpr = $this->input->post('mp');
        $trgt_date = $this->input->post('target_date');

        $date=explode("-", $trgt_date);

        $target_date = $date[2].'-'.$date[0].'-'.$date[1];

        $target=0;

        foreach ($floors as $k => $flr){
            $floor_id = $flr;
            $target = $targets[$k];
            $target_hour = $target_hr[$k];
            $mp = $mpr[$k];

            $data=array(
                'floor_id' => $floor_id,
                'target' => $target,
                'target_hour' => $target_hour,
                'man_power' => $mp,
                'date' => $target_date
            );

            $is_inputed = $this->access_model->isFinishingTargetInputed($flr, $target_date);

            if(sizeof($is_inputed) > 0){
                $this->access_model->updateFloorTarget($floor_id, $target, $target_hour, $mp, $target_date);
            }
            if(sizeof($is_inputed) == 0){
                $this->access_model->insertingData('finishing_daily_target', $data);
            }
        }

        $data['message']='Successfully Floor Target Assigned!';
        $this->session->set_userdata($data);

        redirect('access/finishingTarget');
    }

    public function lineTarget(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $time=$datex->format('H:i:s');
        $date=$datex->format('Y-m-d');

//        $time="19:30:00";

        $data['title'] = 'Line Target Assign';

        $floor_id = $this->session->userdata('floor_id');
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
        $where = '';
        if($floor_id != '' && $floor_id != 0){
            $where .= " AND floor = $floor_id";
        }

        $data['time']=$datex;
        $data['lines'] = $this->access_model->getLines($where);

        $where_1 = '';

        $data['segment'] = $this->access_model->getSegments($time);
        $data['segments'] = $this->access_model->getSegmentList();

//        echo '<pre>';
//        print_r($data['segments']);
//        echo '</pre>';

        $data['maincontent'] = $this->load->view('assign_line_target', $data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function getLineTargetInfo(){
        $target_date = $this->input->post("target_date");
        $line_id = $this->input->post("line_id");

        $line_target_info = $this->access_model->getLineTargetinfo($target_date, $line_id);

        echo json_encode($line_target_info);
    }

    public function assignLineTarget(){
        $segment_id = $this->input->post('segments');
        $lines = $this->input->post('line_id');
        $targets = $this->input->post('target');
        $target_hr = $this->input->post('target_hr');
        $mpr = $this->input->post('mp');
        $trgt_date = $this->input->post('target_date');
        $rmrks = $this->input->post('remarks');
        $last_segment_times = $this->input->post('last_segment_time');


        $date=explode("-", $trgt_date);

        $target_date = $date[2].'-'.$date[0].'-'.$date[1];

        $target=0;


        foreach ($lines as $k => $ln){
            $line_id = $ln;
            $target_hour = $target_hr[$k];
            $target = $targets[$k];
            $mp = $mpr[$k];
            $remarks = $rmrks[$k];
            $last_segment_time = $last_segment_times[$k];


            $is_inputed = $this->access_model->isLineTargetInputed($ln, $target_date);


            if(sizeof($is_inputed) > 0){

                $set_fields = '';

                if($segment_id == 1){

                    $set_fields .= " Set target_hour='$target_hour', target='$target', man_power_1='$mp', man_power_2='$mp', man_power_3='$mp', man_power_4='$mp', remarks='$remarks' ";

                    $this->access_model->updateLineTarget($line_id, $target_date, $set_fields);
                }

                if($segment_id == 2){

                    $set_fields .= " Set target_hour='$target_hour', target='$target', man_power_2='$mp', man_power_3='$mp', man_power_4='$mp', remarks='$remarks' ";

                    $this->access_model->updateLineTarget($line_id, $target_date, $set_fields);
                }

                if($segment_id == 3){

                    $set_fields .= " Set target_hour='$target_hour', target='$target', man_power_3='$mp', man_power_4='$mp', remarks='$remarks' ";

                    $this->access_model->updateLineTarget($line_id, $target_date, $set_fields);
                }

                if($segment_id == 4){

                    $res = $this->access_model->getSegmentList(' AND id=4');
                    $last_segment_start_time = $res[0]['start_time'];


                    $parsed1 = date_parse($last_segment_time);
                    $last_segment_time_seconds = $parsed1['hour'] * 3600 + $parsed1['minute'] * 60 + $parsed1['second'];

                    $parsed2 = date_parse($last_segment_start_time);
                    $last_segment_start_time_seconds = $parsed2['hour'] * 3600 + $parsed2['minute'] * 60 + $parsed2['second'];

                    $last_segment_time_diff_sec = ($last_segment_time_seconds > 0 ? $last_segment_time_seconds : 0) - ($last_segment_start_time_seconds > 0 ? $last_segment_start_time_seconds : 0);

                    $last_segment_time_diff_min = round(($last_segment_time_diff_sec / 60), 2);
                    $last_segment_time_diff_hour = round(($last_segment_time_diff_sec / 3600), 2);

//                    echo '<pre>';
//                    print_r($last_segment_time_diff_hour.'  '.$last_segment_time_diff_sec);
//                    echo '</pre>';


                    $data5 = array(
                        'work_minute_4' => $last_segment_time_diff_min * $mp,
                        'work_hour_4' => $last_segment_time_diff_hour
                    );

                    $this->access_model->updateTblNew('tb_today_line_output_qty', 'line_id', $line_id, $data5);


                    $set_fields .= " Set target_hour='$target_hour', last_segment_time='$last_segment_time', target='$target', man_power_4='$mp', remarks='$remarks' ";

                    $this->access_model->updateLineTarget($line_id, $target_date, $set_fields);
                }

            }else{
                if($segment_id == 1){
                    $data=array(
                        'line_id' => $line_id,
                        'target_hour' => $target_hour,
                        'target' => $target,
                        'date' => $target_date,
                        'man_power_1' => $mp,
                        'man_power_2' => $mp,
                        'man_power_3' => $mp,
                        'man_power_4' => $mp,
                        'remarks' => $remarks
                    );

                    $this->access_model->insertingData('line_daily_target', $data);
                }

                if($segment_id == 2){
                    $data2=array(
                        'line_id' => $line_id,
                        'target_hour' => $target_hour,
                        'target' => $target,
                        'date' => $target_date,
                        'man_power_2' => $mp,
                        'man_power_3' => $mp,
                        'man_power_4' => $mp,
                        'remarks' => $remarks
                    );

                    $this->access_model->insertingData('line_daily_target', $data2);
                }

                if((sizeof($is_inputed) == 0) && $segment_id == 3){
                    $data3=array(
                        'line_id' => $line_id,
                        'target_hour' => $target_hour,
                        'target' => $target,
                        'date' => $target_date,
                        'man_power_3' => $mp,
                        'man_power_4' => $mp,
                        'remarks' => $remarks
                    );

                    $this->access_model->insertingData('line_daily_target', $data3);
                }

                if($segment_id == 4){

                    $res = $this->access_model->getSegmentList(' AND id=4');
                    $last_segment_start_time = $res[0]['start_time'];


                    $parsed1 = date_parse($last_segment_time);
                    $last_segment_time_seconds = $parsed1['hour'] * 3600 + $parsed1['minute'] * 60 + $parsed1['second'];

                    $parsed2 = date_parse($last_segment_start_time);
                    $last_segment_start_time_seconds = $parsed2['hour'] * 3600 + $parsed2['minute'] * 60 + $parsed2['second'];

                    $last_segment_time_diff_sec = ($last_segment_time_seconds > 0 ? $last_segment_time_seconds : 0) - ($last_segment_start_time_seconds > 0 ? $last_segment_start_time_seconds : 0);

                    $last_segment_time_diff_min = round(($last_segment_time_diff_sec / 60), 2);
                    $last_segment_time_diff_hour = round(($last_segment_time_diff_sec / 3600), 2);

//                    echo '<pre>';
//                    print_r($last_segment_time_diff_hour.'  '.$last_segment_time_diff_sec);
//                    echo '</pre>';

                    $data6 = array(
                        'work_minute_4' => $last_segment_time_diff_min * $mp,
                        'work_hour_4' => $last_segment_time_diff_hour
                    );

                    $this->access_model->updateTblNew('tb_today_line_output_qty', 'line_id', $line_id, $data6);

                    $data4=array(
                        'line_id' => $line_id,
                        'target_hour' => $target_hour,
                        'last_segment_time' => "$last_segment_time",
                        'target' => $target,
                        'date' => $target_date,
                        'man_power_4' => $mp,
                        'remarks' => $remarks

                    );

                    $this->access_model->insertingData('line_daily_target', $data4);
                }
            }

        }

        $data['message']='Successfully Line Target Assigned!';
        $this->session->set_userdata($data);

        redirect('access/lineTarget');
    }

    public function getPoWiseSizesWithLinesForm(){
        $purchase_order_stuff = $this->input->post('purchase_order_stuff');

        $purchase_order_stuff_array = explode('_', $purchase_order_stuff);

        $po_no = $purchase_order_stuff_array[0];
        $item_week = $purchase_order_stuff_array[1];
        $color = $purchase_order_stuff_array[2];

        $where = '';
        if($po_no != '' && $item_week != '' && $color != ''){
            $where .= "AND purchase_order LIKE '%$po_no%'
                       AND item LIKE '%$item_week%'
                       AND color LIKE '%$color%'";
        }

        $get_data['po_no'] = $po_no;
        $get_data['item_week'] = $item_week;
        $get_data['color'] = $color;

        $get_data['lines_floors'] = $this->access_model->getLinesFloors();
        $get_data['order_info'] = $this->access_model->getPoWiseUndistributedSizes($where);

        $maincontent = $this->load->view('po_wise_sizes_lines_form', $get_data, true);

//        echo '<pre>';
//        print_r($get_data['order_info']);
//        echo '</pre>';

        echo $maincontent;
    }

    public function assignLineFromCutting(){
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $color = $this->input->post('color');
        $sizes = $this->input->post('size');
        $line = $this->input->post('line');

        foreach ($line as $k => $v){
            $line_no = $line[$k];
            $size = $sizes[$k];

            if($line_no != ''){
                $this->access_model->assignLineSizeWisePOs($purchase_order, $item, $color, $size, $line_no);
            }
        }
        $data['message']='Successfully Assigned Lines!';
        $this->session->set_userdata($data);

        redirect('access/cut_line_distribution', 'refresh');
    }

    public function getPOs(){
        $sap_no = $this->input->post('sap_no');
        $po_no = $this->access_model->getPOs($sap_no);


        $po_dropdown = '<option value="">Select PO No...</option>';

        foreach($po_no as $po_list){
            $po_dropdown .= '<option value="' . $po_list['purchase_order'] . '">' . $po_list['purchase_order'] . '</option>';
        }

        echo $po_dropdown;
    }

    public function getItems(){
        $po_no = $this->input->post('po_no');
        $sap_no = $this->input->post('sap_no');
        $item_no = $this->access_model->getItems($po_no, $sap_no);


        $item_dropdown = '<option value="">Select Item No...</option>';

        foreach($item_no as $item_list){
            $item_dropdown .= '<option value="' . $item_list['item'] . '">' . $item_list['item'] . '</option>';
        }

        echo $item_dropdown;
    }

    public function getColors(){
        $po_no = $this->input->post('po_no');
        $sap_no = $this->input->post('sap_no');
        $item_no = $this->input->post('item_no');
        $colors = $this->access_model->getColors($po_no, $sap_no, $item_no);


        $color_dropdown = '<option value="">Select Color...</option>';

        foreach($colors as $color_list){
            $color_dropdown .= '<option value="' . $color_list['color'] . '">' . $color_list['color'] . '</option>';
        }

        echo $color_dropdown;
    }

    public function getQuality(){
        $po_no = $this->input->post('po_no');
        $sap_no = $this->input->post('sap_no');
        $item_no = $this->input->post('item_no');
        $color = $this->input->post('color');

        $quality_no_res = $this->access_model->getQuality($po_no, $sap_no, $item_no, $color);

        echo json_encode($quality_no_res);
    }

    public function getCutNo(){
        $po_no = $this->input->post('po_no');
        $sap_no = $this->input->post('sap_no');
        $item_no = $this->input->post('item_no');

        $cut_no_res = $this->access_model->getCutNo($po_no, $sap_no, $item_no);

        $cut_no = $cut_no_res[0]['cut_no'];

        echo $cut_no;
    }

    public function getQualitySizes(){
        $po_no = $this->input->post('po_no');
        $sap_no = $this->input->post('sap_no');
        $item_no = $this->input->post('item_no');

        $quality_no_res = $this->access_model->getQualitySizes($po_no, $sap_no, $item_no);

        $new_line = '';

        foreach ($quality_no_res as $k => $v){

            $balance_qty = $v['quantity'] - $v['already_cut_qty'];

            $new_line .= '<tr>';

            $new_line .= '<td><input type="text" readonly class="form-control" name="size[]" id="size'. $k .'" value="'. $v['size'] .'" /></td>';
            $new_line .= '<td><input type="text" readonly class="form-control" name="order_qty[]" id="order_qty'. $k .'" value="'. $v['quantity'] .'" /></td>';
            $new_line .= '<td><input type="text" readonly class="form-control" name="balance_qty[]" id="balance_qty'. $k .'" value="'. $balance_qty .'" /></td>';
            $new_line .= '<td><input type="text" class="form-control" name="cut_qty[]" id="cut_qty'. $k .'" value="" onblur="qtyValidity(id);" /></td>';

            $new_line .= '</tr>';
        }

        echo $new_line;
    }

    public function saveBundleCut(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $sap_no = $this->input->post('sap_no');
        $po_no = $this->input->post('po_no');
        $item_no = $this->input->post('item_no');
        $quality = $this->input->post('quality');
        $cut_tracking_no = $this->input->post('cut_tracking_no');
        $style_no = $this->input->post('style_no');
        $style_name = $this->input->post('style_name');
        $color = $this->input->post('color');
        $brand = $this->input->post('brand');
        $table = $this->input->post('table');
        $layers = $this->input->post('layers');

        $style_no_last_four = substr($style_no, -4);
        $po_no_last_four = substr($po_no, -4);
        $cut_tracking_no_array = explode("_", $cut_tracking_no);
        $cut_no = $cut_tracking_no_array[4];
        $color_code = $cut_tracking_no_array[3];

        $sizes = $this->input->post('size');
        $order_qty = $this->input->post('order_qty');
        $balance_qty = $this->input->post('balance_qty');
        $cut_qty = $this->input->post('cut_qty');

        $total_cut_qty = 0;
        $bundle_start = 1;
        $bundle_end = 0;

        $isAvailableCut = $this->access_model->isCutTrackingNoAvailable($cut_tracking_no.'.');

        $isAvailCutTrackingNo = $isAvailableCut[0]['cut_tracking_no'];

        if(empty($isAvailCutTrackingNo)){
            $lay_cnt = 0;
            $b_count = 1;

            foreach ($sizes as $key => $val){
                $cting_qty = $cut_qty[$key];
                $total_cut_qty += $cting_qty;
                $size = $sizes[$key];

                if($cting_qty != '' && $cting_qty != 0){
//                    echo '<pre>';
//                    print_r(($cting_qty/$layers).' - '.$val);
//                    echo '</pre>';
                    $lay_total_cut = $total_cut_qty/$layers;

                    $lay_res = $cting_qty/$layers;

                    for($b=1; $b <= $lay_res; $b++){
                        $lay_cnt = $lay_cnt + 1;

                        $ct_qty = $layers;

//                        echo '<pre>';
//                        print_r($ct_qty.' - '.$lay_cnt.' - '.$val);
//                        echo '</pre>';

                        $cut_seg = ($ct_qty/10);
                        $round_cut_seg = round($cut_seg);
                        $floor_cut_seg = floor($cut_seg);
                        $after_dec = ($cut_seg - (int)$cut_seg) * 10;

                        $num_layer = $ct_qty/$layers;

//                echo '<pre>';
//                print_r($ct_qty);
//                echo '</pre>';

//                echo '<pre>';
//                print_r($cut_seg);
//                echo '</pre>';

//                echo '<pre>';
//                print_r($round_cut_seg);
//                echo '</pre>';

//                echo '<pre>';
//                print_r($floor_cut_seg);
//                echo '</pre>';

//                echo '<pre>';
//                print_r($after_dec);
//                echo '</pre>';

//                echo '<pre>';
//                print_r($data_bundle_array);
//                echo '</pre>';
                        $data_summary = array(
                            'po_no' => $sap_no,
                            'purchase_order' => $po_no,
                            'item' => $item_no,
                            'quality' => $quality,
                            'style_no' => $style_no,
                            'style_name' => $style_name,
                            'color' => $color,
                            'brand' => $brand,
                            'cut_table' => $table,
                            'cut_no' => $cut_no,
                            'cut_tracking_no' => $cut_tracking_no.'.',
                            'size' => $size,
                            'cut_qty' => $ct_qty,
                            'cut_layer' => $num_layer,
                            'u_id' => '',
                            'date_time' => $date_time
                        );

                    $this->access_model->insertingData('tb_cut_summary', $data_summary);

                        if($round_cut_seg < $cut_seg){
                            $bundle_cut = $round_cut_seg + 1;
                        }else{
                            $bundle_cut = $round_cut_seg;
                        }

//                echo '<pre>';
//                print_r("Size: ".$size);
//                echo '</pre>';

//                echo '<pre>';
//                print_r("bundle count:".$bundle_cut);
//                echo '</pre>';

                        for ($i=1; $i <= $bundle_cut; $i++){

                            if($floor_cut_seg >= $i){
                                $bundle_start = $bundle_end+1 ;
                                $bundle_end = ($bundle_start + 10) - 1;
                            }
                            if($floor_cut_seg < $i){
                                $bundle_start = $bundle_end+1 ;
                                $bundle_end = ($bundle_start + $after_dec) - 1;
                            }

                            $bundle_range = $bundle_start.'-'.$bundle_end;
                            $bundle_range_count = ($bundle_end - $bundle_start)+1;

//                    echo '<pre>';
//                    print_r("Bundle No: ".$b_count. ":".$bundle_start.'-'.$bundle_end.'-'.$lay_cnt);
//                    echo '</pre>';

                            $bundle_tracking_no = $style_no_last_four.'_'.$po_no_last_four.'_'.$item_no.'_'.$color_code.'_'.$cut_no.'_'.$size.'-'.$lay_cnt.'_'.$b_count;

//                    echo '<pre>';
//                    print_r("Bundle Tracking No: ".$style_no_last_four.'_'.$po_no_last_four.'_'.$item_no.'_'.$cut_no.'_'.$size.'_'.$b_count); // $i=bundle_count reviously
//                    echo '</pre>';

                            $data_detail = array(
                                'cut_tracking_no' => $cut_tracking_no.'.',
                                'purchase_order' => $po_no,
                                'item' => $item_no,
                                'quality' => $quality,
                                'style_no' => $style_no,
                                'style_name' => $style_name,
                                'color' => $color,
                                'brand' => $brand,
                                'size' => $size,
                                'cut_table' => $table,
                                'cut_no' => $cut_no,
                                'bundle_no' => $b_count,
                                'bundle_tracking_no' => $bundle_tracking_no.'.',
                                'bundle_range' => $bundle_range,
                                'bundle_range_count' => $bundle_range_count,
                                'layer_group' => $lay_cnt,
                                'u_id' => '',
                                'date_time' => $date_time
                            );

                        $this->access_model->insertingData('tb_bundle_cut_detail', $data_detail);
                            $b_count = $b_count + 1;
                        }
//                echo '<br />';
                    }
                }
            }

//            echo '<pre>';
//            print_r($total_cut_qty);
//            echo '</pre>';
//
//            echo '<pre>';
//            print_r($layers);
//            echo '</pre>';
//            echo '<br />';

        }


        $req_data['title'] = 'Generate Care Label';
        $req_data['sap_no'] = $sap_no;
        $req_data['po_no'] = $po_no;
        $req_data['item_no'] = $item_no;
        $req_data['quality'] = $quality;
        $req_data['cut_tracking_no'] = $cut_tracking_no.'.';
        $req_data['style_no'] = $style_no;
        $req_data['style_name'] = $style_name;
        $req_data['color'] = $color;
        $req_data['brand'] = $brand;
        $req_data['cut_no'] = $cut_no;

        $data['maincontent'] = $this->load->view('individual_printing_command_page', $req_data, true);
        $this->load->view('master', $data);

//        else{
//            $data_session['exception']=$cut_tracking_no.'.'.' is Already Available!';
//            $this->session->set_userdata($data_session);
//
//            redirect('access/cutting','refresh');
//        }
    }

//    public function saveBundleCut(){
//        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
//        
//        $date_time=$datex->format('Y-m-d H:i:s');
//        $date=$datex->format('Y-m-d');
//
//        $sap_no = $this->input->post('sap_no');
//        $po_no = $this->input->post('po_no');
//        $item_no = $this->input->post('item_no');
//        $quality = $this->input->post('quality');
//        $cut_tracking_no = $this->input->post('cut_tracking_no');
//        $style_no = $this->input->post('style_no');
//        $style_name = $this->input->post('style_name');
//        $color = $this->input->post('color');
//        $brand = $this->input->post('brand');
//        $layers = $this->input->post('layers');
//
//        $style_no_last_four = substr($style_no, -4);
//        $po_no_last_four = substr($po_no, -4);
//        $cut_tracking_no_array = explode("_", $cut_tracking_no);
//        $cut_no = $cut_tracking_no_array[3];
//
//        $sizes = $this->input->post('size');
//        $order_qty = $this->input->post('order_qty');
//        $balance_qty = $this->input->post('balance_qty');
//        $cut_qty = $this->input->post('cut_qty');
//
//        $total_cut_qty = 0;
//        $bundle_start = 1;
//        $bundle_end = 0;
//
//        $isAvailableCut = $this->access_model->isCutTrackingNoAvailable($cut_tracking_no.'.');
//
//        $isAvailCutTrackingNo = $isAvailableCut[0]['cut_tracking_no'];
//
//        if(empty($isAvailCutTrackingNo)){
//            foreach ($sizes as $key => $val){
//                $cting_qty = $cut_qty[$key];
//                $total_cut_qty += $cting_qty;
//            }
//
//            foreach ($sizes as $k => $v){
//                $ordered_qty = $order_qty[$k];
//                $ct_qty = $cut_qty[$k];
//                $size = $sizes[$k];
//
//                if($ct_qty != '' && $ct_qty != 0){
//                    $bundle_cut = 0;
//
//                    $cut_seg = ($ct_qty/10);
//                    $round_cut_seg = round($cut_seg);
//                    $floor_cut_seg = floor($cut_seg);
//                    $after_dec = ($cut_seg - (int)$cut_seg) * 10;
//
//                    $num_layer = $ct_qty/$layers;
//
////                $data_bundle_array = [];
//
//
////                array_push($data_bundle_array, $round_cut_seg, $after_dec); // (array, loop_count_with_range_10, extra_to_add )
//
////                echo '<pre>';
////                print_r($ct_qty);
////                echo '</pre>';
//
////                echo '<pre>';
////                print_r($cut_seg);
////                echo '</pre>';
//
////                echo '<pre>';
////                print_r($round_cut_seg);
////                echo '</pre>';
//
////                echo '<pre>';
////                print_r($floor_cut_seg);
////                echo '</pre>';
//
////                echo '<pre>';
////                print_r($after_dec);
////                echo '</pre>';
//
////                echo '<pre>';
////                print_r($data_bundle_array);
////                echo '</pre>';
//
//
//                    $data_summary = array(
//                        'po_no' => $sap_no,
//                        'purchase_order' => $po_no,
//                        'item' => $item_no,
//                        'quality' => $quality,
//                        'style_no' => $style_no,
//                        'style_name' => $style_name,
//                        'color' => $color,
//                        'brand' => $brand,
//                        'cut_no' => $cut_no,
//                        'cut_tracking_no' => $cut_tracking_no.'.',
//                        'size' => $size,
//                        'cut_qty' => $ct_qty,
//                        'cut_layer' => $num_layer,
//                        'u_id' => '',
//                        'date_time' => $date_time
//                    );
//
//                    $this->access_model->insertingData('tb_cut_summary', $data_summary);
//
//                    if($round_cut_seg < $cut_seg){
//                        $bundle_cut = $round_cut_seg + 1;
//                    }else{
//                        $bundle_cut = $round_cut_seg;
//                    }
//
////                echo '<pre>';
////                print_r("Size: ".$size);
////                echo '</pre>';
//
////                echo '<pre>';
////                print_r("bundle count:".$bundle_cut);
////                echo '</pre>';
//
//                    $layer_count = 1;
//
//                    for ($i=1; $i <= $bundle_cut; $i++){
//
//                        if($floor_cut_seg >= $i){
//                            $bundle_start = $bundle_end+1 ;
//                            $bundle_end = ($bundle_start + 10) - 1;
//                        }
//                        if($floor_cut_seg < $i){
//                            $bundle_start = $bundle_end+1 ;
//                            $bundle_end = ($bundle_start + $after_dec) - 1;
//                        }
//
//                        $bundle_range = $bundle_start.'-'.$bundle_end;
//                        $bundle_range_count = ($bundle_end - $bundle_start)+1;
//
////                    echo '<pre>';
////                    print_r("Bundle No: ".$i. ":".$bundle_start.'-'.$bundle_end);
////                    echo '</pre>';
//
//                        $bundle_tracking_no = $style_no_last_four.'_'.$po_no_last_four.'_'.$item_no.'_'.$cut_no.'_'.$size.'_'.$i;
//
////                    echo '<pre>';
////                    print_r("Bundle Tracking No: ".$style_no_last_four.'_'.$po_no_last_four.'_'.$item_no.'_'.$cut_no.'_'.$size.'_'.$i);
////                    echo '</pre>';
//
//                        $data_detail = array(
//                            'cut_tracking_no' => $cut_tracking_no.'.',
//                            'purchase_order' => $po_no,
//                            'item' => $item_no,
//                            'quality' => $quality,
//                            'style_no' => $style_no,
//                            'style_name' => $style_name,
//                            'color' => $color,
//                            'brand' => $brand,
//                            'size' => $size,
//                            'cut_no' => $cut_no,
//                            'bundle_no' => $i,
//                            'bundle_tracking_no' => $bundle_tracking_no.'.',
//                            'bundle_range' => $bundle_range,
//                            'bundle_range_count' => $bundle_range_count,
//                            'u_id' => '',
//                            'date_time' => $date_time
//                        );
//
//                        $this->access_model->insertingData('tb_bundle_cut_detail', $data_detail);
//
//                    }
////                echo '<br />';
//
//                }
//            }
//        }
//
//
//        $req_data['title'] = 'Generate Care Label';
//        $req_data['sap_no'] = $sap_no;
//        $req_data['po_no'] = $po_no;
//        $req_data['item_no'] = $item_no;
//        $req_data['quality'] = $quality;
//        $req_data['cut_tracking_no'] = $cut_tracking_no.'.';
//        $req_data['style_no'] = $style_no;
//        $req_data['style_name'] = $style_name;
//        $req_data['color'] = $color;
//        $req_data['brand'] = $brand;
//        $req_data['cut_no'] = $cut_no;
//
//        $data['maincontent'] = $this->load->view('individual_printing_command_page', $req_data, true);
//        $this->load->view('master', $data);
//
////        else{
////            $data_session['exception']=$cut_tracking_no.'.'.' is Already Available!';
////            $this->session->set_userdata($data_session);
////
////            redirect('access/cutting','refresh');
////        }
//    }

    public function print_bundle_tags($cut_tracking_no){
        $data['bundle_detail'] = $this->access_model->getBundleInfo($cut_tracking_no);
    }

    public function generate_care_label($cut_tracking_no){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $res_last_cl = $this->access_model->getLastCareLabel();
        $pc_tracking_no = $res_last_cl[0]['pc_tracking_no'];

        $pc_tracking_no_int = (int)$pc_tracking_no;

//        if($pc_tracking_no_int >= 9999999){
//            $pc_tracking_no_int = 0;
//        }
//        elseif ($pc_tracking_no_int <= 9999999){
//            $pc_tracking_no_int = $pc_tracking_no_int;
//        }

        $checkCutCareLabelAvailability = $this->access_model->checkCutCareLabelAvailability($cut_tracking_no);

        if(empty($checkCutCareLabelAvailability[0]['cut_tracking_no'])){
            $cut_tracking_detail = $this->access_model->getCutTrackingDetail($cut_tracking_no);

            foreach ($cut_tracking_detail as $k => $v){
                $bundle_range_count = $v['bundle_range_count'];


                for($i=1; $i <= $bundle_range_count; $i++){

                    $pc_tracking_no_int = $pc_tracking_no_int + 1;

                    if($pc_tracking_no_int == 10000000){
                        $pc_tracking_no_int = 0;
                        $pc_tracking_no_int = $pc_tracking_no_int + 1;
                    }
                    elseif ($pc_tracking_no_int < 10000000){
                        $pc_tracking_no_int = $pc_tracking_no_int;
                    }

                    $data['pc_tracking_no'] = sprintf("%08s", $pc_tracking_no_int.'.');
                    $data['cut_tracking_no'] = $v['cut_tracking_no'];
                    $data['purchase_order'] = $v['purchase_order'];
                    $data['item'] = $v['item'];
                    $data['quality'] = $v['quality'];
                    $data['style_no'] = $v['style_no'];
                    $data['style_name'] = $v['style_name'];
                    $data['brand'] = $v['brand'];
                    $data['size'] = $v['size'];
                    $data['color'] = $v['color'];
                    $data['cut_table'] = $v['cut_table'];
                    $data['cut_no'] = $v['cut_no'];
                    $data['bundle_no'] = $v['bundle_no'];
                    $data['bundle_tracking_no'] = $v['bundle_tracking_no'];
                    $data['bundle_range'] = $v['bundle_range'];
                    $data['layer_group'] = $v['layer_group'];
                    $data['date_time'] = $date_time;

                    $this->access_model->insertingData('tb_care_labels', $data);

                }
        }
            redirect("bcps/generated_care_label_printing_pre.php?cut_tracking_no=$cut_tracking_no");

        }
        else{
            redirect("bcps/generated_care_label_printing_pre.php?cut_tracking_no=$cut_tracking_no");
//            echo '<h1 style="color: green;">Already Care Labels are Generated!</h1>';
        }

    }

    public function getSummaryReportbyPo(){
        $purchase_order = $this->input->post('purchase_order');

        $where = '';

        if($purchase_order != ''){
            $where .= "AND purchase_order='$purchase_order'";
        }

        $data['sent_to_prod_rep'] = $this->access_model->getSummaryReportbyPo($where);


        $maincontent = $this->load->view('sending_to_production_report_by_po', $data, true);

        echo $maincontent;
    }

    public function sendingToProductionReport(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['title'] = 'Sent To Production Report';
        $data['purchase_order_nos'] = $this->access_model->getAllPurchaseOrders();
        $data['sent_to_prod_rep'] = $this->access_model->getSendingToProductionreport($date);

        $data['maincontent'] = $this->load->view('sending_to_production_report', $data, true);
        $this->load->view('master', $data);
    }

    public function sendingToProductionReportByPO(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['title'] = 'Cutting Report By PO';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $data['purchase_order_nos'] = $this->access_model->getAllPurchaseOrders();
        $data['sent_to_prod_rep'] = $this->access_model->getSendingToProductionreport($date);

        $data['maincontent'] = $this->load->view('po_wise_sending_to_production_report', $data, true);
        $this->load->view('master', $data);
    }

    public function getNotScannedCareLabels($cut_tracking_no){
        $data['sent_to_prod_rep'] = $this->access_model->getNotScannedCareLabels($cut_tracking_no);
        $data['maincontent'] = $this->load->view('cut_pending_care_label_report', $data, true);
        $this->load->view('master', $data);
    }

//    public function updatingCLPrintLogNew(){
//        $sap_no = $this->input->post('sap_no');
//        $purchase_order = $this->input->post('purchase_order');
//        $item_no = $this->input->post('item_no');
//        $cut_no = $this->input->post('cut_no');
//
//        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
//        
//        $date_time=$datex->format('Y-m-d H:i:s');
//        $date=$datex->format('Y-m-d');
//
//        $this->access_model->updatingCLPrintLogNew($sap_no, $purchase_order, $item_no, $cut_no, $date_time);
//
//        echo 'Done';
//    }

    public function updatingCLPrintLog(){
        $cut_tracking_no = $this->input->post('cut_tracking_no');
        $so_no = $this->input->post('so_no');
        $print_qty = $this->input->post('print_qty');

        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $this->access_model->updatingCLPrintLog($so_no, $cut_tracking_no, $date_time, $print_qty);
        $this->access_model->updatingCLSummaryPrintLog($so_no, $cut_tracking_no, $date_time);

        echo 'Done';
    }

    public function po_list(){
        $data['title'] = 'PO List';
        $get_data['po_list'] = $this->access_model->getPOsForCareLabelPrinting('tb_po_detail');
        $data['maincontent'] = $this->load->view('po_list', $get_data, true);
        $this->load->view('master', $data);
    }

    public function po_list_for_cutting(){
        $data['title'] = 'PO List For Cutting';
        $get_data['po_list'] = $this->access_model->getPOsForCutting();
        $data['maincontent'] = $this->load->view('po_list_for_cutting', $get_data, true);
        $this->load->view('master', $data);
    }

    public function po_cut_for_care_label(){
        $data['title'] = 'PO Cut List';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
//        $get_data['po_cut_list'] = $this->access_model->getPOCutListForCareLabel();

        $get_data['purchase_order_nos'] = $this->access_model->getAllPurchaseOrders();

        $data['maincontent'] = $this->load->view('po_cut_list_for_carelabel', $get_data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function search_care_label(){
        $data['title'] = 'Search Care Label';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
//        $get_data['care_label_list'] = $this->access_model->getCareLabelList();

        $data['maincontent'] = $this->load->view('search_care_label', $data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function cut_line_distribution(){
        $data['title'] = 'Cut-Line Distribution';
//        $get_data['purchase_order_nos'] = $this->access_model->getNonDistributedPOs();
        $get_data['purchase_order_nos'] = $this->access_model->getAllPurchaseOrders();

        $data['maincontent'] = $this->load->view('cut_line_distribution', $get_data, true);
        $this->load->view('master', $data);
    }

    public function getClDetail(){
        $cl_no = $this->input->post('cl_no');

        $care_label_detail = $this->access_model->getCareLabelDetailByClNo($cl_no);

        foreach ($care_label_detail as $v){
            $pc_tracking_no = $v['pc_tracking_no'];
            $po_no = $v['po_no'];
            $purchase_order = $v['purchase_order'];
            $item = $v['item'];
            $quality = $v['quality'];
            $color = $v['color'];
            $style_no = $v['style_no'];
            $style_name = $v['style_name'];
            $size = $v['size'];
            $bundle_tracking_no = $v['bundle_tracking_no'];
            $brand = $v['brand'];

            $new_line = '';
            $new_line .= '<tr>';


            $new_line .= '<td class="center">'.$pc_tracking_no.'</td>';
            $new_line .= '<td class="center">'.$po_no.'</td>';
            $new_line .= '<td class="center">'.$brand.'</td>';
            $new_line .= '<td class="center">'.$purchase_order.'-'.$item.'</td>';
            $new_line .= '<td class="center">'.$quality.'-'.$color.'</td>';
            $new_line .= '<td class="center">'.$style_no.'</td>';
            $new_line .= '<td class="center">'.$style_name.'</td>';
            $new_line .= '<td class="center">'.$size.'</td>';
            $new_line .= '<td class="center">'.$bundle_tracking_no.'</td>';
            $new_line .= '<td><a target="_blank" class="btn btn-primary" href="'.base_url().'access/reprintByAdmin/'.$pc_tracking_no.'">CL</a></td>';


            $new_line .= '</tr>';
            echo $new_line;
        }
    }

    public function reprintByAdmin($pc_no)
    {

        $pc_tracking_no = str_replace("%20"," ","$pc_no");

        $get_data['pc_no'] = $pc_tracking_no;
        $get_data['care_label_list'] = $this->access_model->getCareLabelDetailByClNo($pc_tracking_no);

        $line_id=$get_data['care_label_list'][0]['line_id'];

        if(!empty($get_data['care_label_list'])){

            foreach ($get_data['care_label_list'] as $v){
                $carelabel_tracking_no = $v['pc_tracking_no'];


                $lost_point = '';
                $access_points = '';

                //0= administrator,1=cutting, 2=line_begin, 3=midline_qc, 4=endline_qc, 5=finishing,
                // 6=washing, 7=packing, 8=collar_cuff, 9=carton, 10=wash_going, 100=FLOOR, 200=OPR, 300=QA

                if($v['sent_to_production'] == 0){
                    $lost_point = 'Not Sent From Cutting';
                    $access_points='1';
                }else{
                    if($v['line_id']==0){
                        $lost_point = 'Not Inputted Line';
                        $access_points='2';
                    }else{
                        if(($v['access_points']==2) && ($v['access_points_status']==1)){
                            $lost_point = 'Lost After Input to Line';
                            $access_points='3';
                        }
                        elseif (($v['access_points']==3) && ($v['access_points_status']==1)){
                            $lost_point = 'Lost In Between Mid-End QC';
                            $access_points='4';
                        }
                        elseif (($v['access_points']==3) && ($v['access_points_status']!=1)){
                            $lost_point = 'Lost In Mid QC';
                            $access_points='4';
                        }
                        elseif (($v['access_points']==4) && ($v['access_points_status']==4)){
                            if($v['is_wash_gmt'] == 1){

                                if($v['is_going_wash'] == 0){
                                    $lost_point = 'Did Not Go To Wash';
                                    $access_points='10';
                                }else{
                                    if($v['washing_status'] == 0){
                                        $lost_point = 'Did Not Return From Wash';
                                        $access_points='6';
                                    }else{
                                        if($v['packing_status'] == 0){
                                            $lost_point = 'Poly Not Completed';
                                            $access_points='7';
                                        }else{
                                            if(($v['carton_status'] == 0) && ($v['warehouse_qa_type'] == 0)){
                                                $lost_point = 'Carton/Warehouse Not Completed';
                                                $access_points='9';
                                            }
                                        }
                                    }
                                }

                            }
                            if($v['is_wash_gmt'] == 0){

                                if($v['packing_status'] == 0){
                                    $lost_point = 'Poly Not Completed';
                                    $access_points='7';
                                }else{
                                    if(($v['carton_status'] == 0) && ($v['warehouse_qa_type'] == 0)){
                                        $lost_point = 'Carton/Warehouse Not Completed';
                                        $access_points='9';
                                    }
                                }

                            }
                        }elseif (($v['access_points']==4) && ($v['access_points_status']!=4)){
                            $lost_point = 'Lost In End-QC';
                            $access_points='4';
                        }
                    }
                }

                $get_data['lost_point'] = $lost_point;
                $get_data['access_point'] = $access_points;
                $get_data['line_id'] = $line_id;




                $data['img_url']="";
                if($carelabel_tracking_no != '')
                {
                    $this->load->library('ciqrcode');
                    $qr_image=$carelabel_tracking_no.'.png';
                    $params['data'] = $carelabel_tracking_no;
                    $params['level'] = 'H';
                    $params['size'] = 8;
                    $params['savename'] =FCPATH."uploads/qr_image/".$qr_image;


                    if($this->ciqrcode->generate($params))
                    {
                        $data['img_url']=$qr_image;
                    }
                }
            }
        }

        $data['maincontent'] = $this->load->view('reprint_by_admin', $get_data);

    }

    public function keepReprintLogForAdmin()
    {
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $user_id = $this->session->userdata('id');
        $printed_by = $this->session->userdata('access_points');

        $pc_no = $this->input->post('pc_no');
        $lost_point = $this->input->post('lost_point');
        $access_point = $this->input->post('access_point');
        $reason = $this->input->post('reason');
        $reference = $this->input->post('reference');
        $line_id = $this->input->post('line_id');

        $data['pc_tracking_no'] = $pc_no;
        $data['lost_point'] = $lost_point;
        $data['line_id'] = $line_id;
        $data['access_point'] = $access_point;
        $data['reprint_reason'] = $reason;
        $data['referenced_by'] = $reference;
        $data['printed_by'] = $printed_by;
        $data['print_date_time'] = $date_time;
        $data['request_status'] = 1;
        $data['approved_by'] = 'Admin';

        $this->access_model->insertingData('tb_label_reprint_log', $data);
//        $this->access_model->updateLabelReprintLog($pc_no, $data);
//        $this->access_model->updateReprintLog($pc_no,$date_time);

        echo 'Done';
    }

    public function aqlPlan(){
        $data['title'] = 'AQL Plan';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');
        $data['msg'] = '';

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {

            $data['so_list'] = $this->access_model->getAllSOs();

            $data['maincontent'] = $this->load->view('aql_plan', $data, true);
            $this->load->view('master', $data);
        }else{
            echo $this->load->view('404');
        }
    }

    public function saveAqlPlan(){
        $sales_order = $this->input->post('sales_order');
        $aql_pln_dt = $this->input->post('aql_plan_date');

        $plan_date_parts = explode("-", $aql_pln_dt);
        $plan_mon = $plan_date_parts[0];
        $plan_dt = $plan_date_parts[1];
        $plan_yr = $plan_date_parts[2];

        $plan_date = $plan_yr.'-'.$plan_mon.'-'.$plan_dt;

        if($plan_date == '0000-00-00'){
            $data['aql_status']=0;
            $data['aql_remarks']='';
            $data['aql_action_by']=0;
        }

        $data['aql_plan_date']=$plan_date;


        $this->access_model->updateTblNew('tb_po_detail', 'so_no', $sales_order, $data);

        $data['message'] = "$sales_order - AQL Saved Successfully!";
        $this->session->set_userdata($data);
        redirect('access/aqlPlan');
    }

    public function aqlList(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['title'] = 'AQL Summary';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');
        $data['msg'] = '';

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
        $data['aql_summary'] = $this->access_model->getAqlSummaryList($date);

        $data['maincontent'] = $this->load->view('aql_summary_list', $data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function aqlListDetail($brand){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['title'] = 'AQL List';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');
        $data['msg'] = '';

        $data['aql_list'] = $this->access_model->getAqlTargetList($date, $brand);

        $data['maincontent'] = $this->load->view('aql_list', $data, true);
        $this->load->view('master', $data);
    }

    public function getDueAqlTargetList($brand){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['title'] = 'AQL List';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');
        $data['msg'] = '';

        $data['aql_list'] = $this->access_model->getDueAqlTargetList($date, $brand);

        $data['maincontent'] = $this->load->view('aql_list', $data, true);
        $this->load->view('master', $data);
    }

    public function saveAqlStatus(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $so_no = $this->input->post('so_no');
        $aql_status = $this->input->post('aql_status');
        $aql_remarks = $this->input->post('aql_remarks');

        foreach($so_no AS $k => $v){

            if($aql_status[$k] != ''){
                //Update AQL Status Start
                if($aql_status[$k] == 2){
                    $data['aql_remarks'] = $aql_remarks[$k];
                }
                if($aql_status[$k] == 1){
                    $data['aql_remarks'] = '';
                }
                $data['aql_status'] = $aql_status[$k];
                $data['aql_action_date'] = $date;
                $data['aql_action_by'] = $this->session->userdata('id');

                $this->access_model->updateTblNew('tb_po_detail', 'so_no', $v, $data);
                //Update AQL Status End

                //Insert AQL Status Log Start
                $data_1['so_no'] = $v;
                $data_1['aql_status'] = $aql_status[$k];
                if($aql_status[$k] == 2){
                    $data_1['aql_remarks'] = $aql_remarks[$k];
                }
                if($aql_status[$k] == 1){
                    $data_1['aql_remarks'] = '';
                }
                $data_1['aql_status_date'] = $date_time;
                $data_1['aql_action_by'] = $this->session->userdata('id');

                $this->access_model->insertingData('tb_aql_status_log', $data_1);
                //Insert AQL Status Log End
            }

        }

        $data['message'] = "AQL Saved Successfully!";
        $this->session->set_userdata($data);
        redirect('access/aqlList');
    }

    public function package_send_to_sew()
    {
        $data['title'] = 'INPUT TO SEW';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
        $data['lines'] = $this->access_model->getLines();

//        $data['prod_summary'] = $this->access_model->getCuttingCollarCuffReport();

        $data['maincontent'] = $this->load->view('package_send_to_sew', $data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function sendingPackageToProduction(){
        $date = new DateTime("now", new DateTimeZone('Asia/Dhaka') );
        $date_time= $date->format('Y-m-d H:i:s');
        $po_no = $this->input->post('po_no');
        $cut_no = $this->input->post('cut_no');
        $plan_line_id = $this->input->post('line_id');

        $where = '';

        if($po_no != ''){
            $where .= " AND po_no='$po_no'";
        }

        if($cut_no != ''){
            $where .= " AND cut_no='$cut_no'";
        }

        $check_pkg= $this->access_model->checkPackageReady($where);
        $array_size = sizeof($check_pkg);

        if($array_size > 0){
            $this->access_model->updatePacakgeSentToProductionOnCL($po_no, $cut_no, $plan_line_id, $date_time);
            $this->access_model->updatePacakgeSentToProductionOnCS($po_no, $cut_no, $plan_line_id, $date_time);
            echo 'DONE';
        }
        else
        {
            echo 'CANCEL';
        }

    }

    public function getPackageSentToSewReport()
    {
        $planned_line_id = $this->input->post('line_id');

        $line_info = $this->access_model->getLineInfo($planned_line_id);
        $data['line_code'] = $line_info[0]['line_code'];

        $where = '';
        $where1 = '';

        if($planned_line_id != 0 && $planned_line_id != ''){
            $where .= " AND planned_line_id=$planned_line_id";
            $where1 .= "AND package_sent_to_production=1 AND is_package_ready=1";
        }

//        $data['prod_summary'] = $this->access_model->getCuttingCollarCuffReport(); //Previous QUery
        $data['prod_summary'] = $this->access_model->getPackageSentToSewReport($where, $where1);

        $data['maincontent'] = $this->load->view('package_sent_to_sew_report', $data);
    }

    public function getRemainingPackage()
    {
        $po_no = $this->input->post('po_no');
        $so_no = $this->input->post('so_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');
        $ex_factory = $this->input->post('ex_factory_date');


        $where = '';
        if ($po_no != '') {
            $where .= " AND po_no = '$po_no'";
        }
        if ($so_no != '') {
            $where .= " AND so_no = '$so_no'";
        }
        if ($purchase_order != '') {
            $where .= " AND purchase_order = '$purchase_order'";
        }
        if ($item != '') {
            $where .= " AND item = '$item'";
        }
        if ($quality != '') {
            $where .= " AND quality = '$quality'";
        }
        if ($color != '') {
            $where .= " AND color = '$color'";
        }
        if ($ex_factory != '') {
            $where .= " AND ex_factory_date = '$ex_factory' AND package_sent_to_production=0 AND is_package_ready=1";
        }

        $get_data['order_size'] = $this->access_model->getRemainingPart($where);
//        echo '<pre>';
//        print_r( $get_data['order_size']);
//        echo '</pre>';

//        $maincontent = $this->load->view('po_item_wise_size_end_pass_report', $get_data, true);
        $maincontent = $this->load->view('po_item_wise_back_part_report', $get_data, true);

        echo $maincontent;

    }

    public function printSingleCareLabel($pc_no){
        $pc_tracking_no = str_replace("%20"," ","$pc_no");

        $get_data['pc_no'] = $pc_tracking_no;
        $get_data['care_label_list'] = $this->access_model->getCareLabelDetailByClNo($pc_tracking_no);

        $line_id=$get_data['care_label_list'][0]['line_id'];

        if(!empty($get_data['care_label_list'])){

            foreach ($get_data['care_label_list'] as $v){
                $carelabel_tracking_no = $v['pc_tracking_no'];


                $lost_point = '';
                $access_points = '';

                //0= administrator,1=cutting, 2=line_begin, 3=midline_qc, 4=endline_qc, 5=finishing,
                // 6=washing, 7=packing, 8=collar_cuff, 9=carton, 10=wash_going, 100=FLOOR, 200=OPR, 300=QA

                if($v['sent_to_production'] == 0){
                    $lost_point = 'Not Sent From Cutting';
                    $access_points='1';
                }else{
                    if($v['line_id']==0){
                        $lost_point = 'Not Inputted Line';
                        $access_points='2';
                    }else{
                        if(($v['access_points']==2) && ($v['access_points_status']==1)){
                            $lost_point = 'Lost After Input to Line';
                            $access_points='3';
                        }
                        elseif (($v['access_points']==3) && ($v['access_points_status']==1)){
                            $lost_point = 'Lost In Between Mid-End QC';
                            $access_points='4';
                        }
                        elseif (($v['access_points']==3) && ($v['access_points_status']!=1)){
                            $lost_point = 'Lost In Mid QC';
                            $access_points='4';
                        }
                        elseif (($v['access_points']==4) && ($v['access_points_status']==4)){
                            if($v['is_wash_gmt'] == 1){

                                if($v['is_going_wash'] == 0){
                                    $lost_point = 'Did Not Go To Wash';
                                    $access_points='10';
                                }else{
                                    if($v['washing_status'] == 0){
                                        $lost_point = 'Did Not Return From Wash';
                                        $access_points='6';
                                    }else{
                                        if($v['packing_status'] == 0){
                                            $lost_point = 'Poly Not Completed';
                                            $access_points='7';
                                        }else{
                                            if(($v['carton_status'] == 0) && ($v['warehouse_qa_type'] == 0)){
                                                $lost_point = 'Carton/Warehouse Not Completed';
                                                $access_points='9';
                                            }
                                        }
                                    }
                                }

                            }
                            if($v['is_wash_gmt'] == 0){

                                if($v['packing_status'] == 0){
                                    $lost_point = 'Poly Not Completed';
                                    $access_points='7';
                                }else{
                                    if(($v['carton_status'] == 0) && ($v['warehouse_qa_type'] == 0)){
                                        $lost_point = 'Carton/Warehouse Not Completed';
                                        $access_points='9';
                                    }
                                }

                            }
                        }elseif (($v['access_points']==4) && ($v['access_points_status']!=4)){
                            $lost_point = 'Lost In End-QC';
                            $access_points='4';
                        }
                    }
                }

                $get_data['lost_point'] = $lost_point;
                $get_data['access_point'] = $access_points;
                $get_data['line_id'] = $line_id;




                $data['img_url']="";
                if($carelabel_tracking_no != '')
                {
                    $this->load->library('ciqrcode');
                    $qr_image=$carelabel_tracking_no.'.png';
                    $params['data'] = $carelabel_tracking_no;
                    $params['level'] = 'H';
                    $params['size'] = 8;
                    $params['savename'] =FCPATH."uploads/qr_image/".$qr_image;


                    if($this->ciqrcode->generate($params))
                    {
                        $data['img_url']=$qr_image;
                    }
                }
            }
        }

        $data['maincontent'] = $this->load->view('care_label_reprint', $get_data);
    }

    public function keepReprintLog(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $user_id = $this->session->userdata('id');
        $printed_by = $this->session->userdata('access_points');

        $pc_no = $this->input->post('pc_no');
        $lost_point = $this->input->post('lost_point');
        $access_point = $this->input->post('access_point');
        $reason = $this->input->post('reason');
        $reference = $this->input->post('reference');
        $line_id = $this->input->post('line_id');

//        $data['pc_tracking_no'] = $pc_no;
        $data['lost_point'] = $lost_point;
        $data['access_point'] = $access_point;
        $data['line_id'] = $line_id;
//        $data['reprint_reason'] = $reason;
//        $data['referenced_by'] = $reference;
        $data['printed_by'] = $printed_by;
        $data['print_date_time'] = $date_time;

//        $this->access_model->insertingData('tb_label_reprint_log', $data);
        $this->access_model->updateLabelReprintLog($pc_no, $data);
        $this->access_model->updateReprintLog($pc_no,$date_time);

        echo 'Done';
    }

    public function care_label_send_to_production(){
        $data['title'] = 'CL Send to Production';
        $data['maincontent'] = $this->load->view('care_label_send_to_production', '', true);
        $this->load->view('master', $data);
    }

    public function care_label_send_to_production_individual(){
        $data['title'] = 'Piece By Piece Scan';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
            $data['lines'] = $this->access_model->getLines();

            $condition = '';
            if ($data['access_points'] == 1) {
                $condition .= " ORDER BY t3.cut_prod_date_time DESC";
//            $data['prod_summary'] = $this->access_model->getProducitonSummaryReportCut($condition);
            } else {
//            $data['prod_summary'] = $this->access_model->getProducitonSummaryReport();
            }

            $data['maincontent'] = $this->load->view('care_label_send_to_production_individual', $data, true);
            $this->load->view('master', $data);
        }else{
            echo $this->load->view('404');
        }
    }

    public function care_label_send_to_production_bundle(){
        $data['title'] = 'Bundle Send to Production';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $data['prod_summary'] = $this->access_model->getProducitonSummaryReport();

        $data['maincontent'] = $this->load->view('care_label_send_to_production_bundle', $data, true);
        $this->load->view('master', $data);
    }

    public function collar_cuff_send_to_production(){
        $data['title'] = 'Bundle Scan';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
        $data['lines'] = $this->access_model->getLines();

//        $data['prod_summary'] = $this->access_model->getCuttingCollarCuffReport();

        $data['maincontent'] = $this->load->view('collar_cuff_send_to_production', $data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function get_collar_cuff_send_to_prod_data(){
        $planned_line_id = $this->input->post('line_id');

        $line_info = $this->access_model->getLineInfo($planned_line_id);
        $data['line_code'] = $line_info[0]['line_code'];

        $where = '';
        $where1 = '';

        if($planned_line_id != 0 && $planned_line_id != ''){
            $where .= " AND planned_line_id=$planned_line_id";
            $where1 .= " OR t1.is_package_ready=1";
        }

//        $data['prod_summary'] = $this->access_model->getCuttingCollarCuffReport(); //Previous QUery
        $data['prod_summary'] = $this->access_model->getCuttingCollarCuffReportViewTable($where);

        $data['maincontent'] = $this->load->view('cutting_collar_cuff_sent_to_prod_data', $data);
    }

    public function sendingCollarCuffToProduction(){

        $bundle_track_no = $this->input->post('bundle_array');
        $line_id = $this->input->post('line_id');

        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        foreach ($bundle_track_no as $k => $v){
            $bundle_type_status = substr($bundle_track_no[$k], -4);
            $bundle_tracking_no = substr_replace($bundle_track_no[$k] ,"",-4);

            if($bundle_type_status != '' && $bundle_type_status == 'clr.'){
                $res = $this->access_model->cuttingCollarCuffTracking($bundle_tracking_no, 'is_cutting_collar_bundle_ready', 1, 'cutting_collar_bundle_ready_date_time', $date_time, $line_id);

                if($res == 1){

                    $return_res = $this->packageReady($bundle_tracking_no);

                }

            }

            if($bundle_type_status != '' && $bundle_type_status == 'cff.'){
                $res = $this->access_model->cuttingCollarCuffTracking($bundle_tracking_no, 'is_cutting_cuff_bundle_ready', 1, 'cutting_cuff_bundle_ready_date_time', $date_time, $line_id);
                if($res == 1){

                    $return_res = $this->packageReady($bundle_tracking_no);

                }
            }

            if($bundle_type_status != '' && $bundle_type_status == 'bck.'){
                $res = $this->access_model->cuttingbackPartTracking($bundle_tracking_no, 'is_cutting_back_bundle_ready', 1, 'cutting_back_bundle_ready_date_time', $date_time, $line_id);
                if($res == 1){

                    $return_res = $this->packageReady($bundle_tracking_no);

                }
            }

            if($bundle_type_status != '' && $bundle_type_status == 'yok.'){
                $res = $this->access_model->cuttingYokekPartTracking($bundle_tracking_no, 'is_cutting_yoke_bundle_ready', 1, 'cutting_yoke_bundle_ready_date_time', $date_time, $line_id);
                if($res == 1){

                    $return_res = $this->packageReady($bundle_tracking_no);

                }
            }

            if($bundle_type_status != '' && $bundle_type_status == 'slv.'){
                $res = $this->access_model->cuttingSleevePartTracking($bundle_tracking_no, 'is_cutting_sleeve_bundle_ready', 1, 'cutting_sleeve_bundle_ready_date_time', $date_time, $line_id);
                if($res == 1){

                    $return_res = $this->packageReady($bundle_tracking_no);

                }
            }

            if($bundle_type_status != '' && $bundle_type_status == 'spt.'){
                $res = $this->access_model->cuttingSlvPktPartTracking($bundle_tracking_no, 'is_cutting_sleeve_plkt_bundle_ready', 1, 'cutting_sleeve_plkt_bundle_ready_date_time', $date_time, $line_id);
                if($res == 1){

                    $return_res = $this->packageReady($bundle_tracking_no);

                }
            }

            if($bundle_type_status != '' && $bundle_type_status == 'pkt.'){
                $res = $this->access_model->cuttingPocketPartTracking($bundle_tracking_no, 'is_cutting_pocket_bundle_ready', 1, 'cutting_pocket_bundle_ready_date_time', $date_time, $line_id);
                if($res == 1){

                    $return_res = $this->packageReady($bundle_tracking_no);

                }
            }

        }

        echo 'DONE';

    }

    public function packageReady($bundle_tracking_no){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $bp_array = array();

        $info=$this->access_model->search_po_no($bundle_tracking_no);

//        echo '<pre>';
//        print_r($info);
//        echo '</pre>';

        $po_no=$info[0]['po_no'];
        $bundle_part=$this->access_model->search_part_no($po_no);

        foreach ($bundle_part as $bp){
            array_push($bp_array, $bp['part_code']);
        }

//                echo '<pre>';
//                print_r($bp_array);
//                echo '</pre>';
//                die();

        $back = array_search('back', $bp_array);
        $collar_outer = array_search('collar_outer', $bp_array);
        $cuff_outer = array_search('cuff_outer', $bp_array);
        $yoke_upper = array_search('yoke_upper', $bp_array);
        $slv_pkt_r = array_search('slv_plkt_r', $bp_array);
        $slv_r = array_search('sleeve_r', $bp_array);
        $pocket = array_search('pocket', $bp_array);

//                echo '<pre>';
//                print_r($back.'-'.$collar_outer.'-'.$cuff_outer.'-'.$yoke_upper.'-'.$slv_pkt_r.'-'.$slv_r.'-'.$pocket);
//                echo '</pre>';
//                die();

        $where = "";
        if ( $po_no != '') {
            $where .= " AND po_no = '$po_no'";
        }

        if ($bundle_tracking_no != '') {
            $where .= " AND bundle_tracking_no = '$bundle_tracking_no'";
        }
        if ($collar_outer > -1) {
            $where .= " AND is_cutting_collar_bundle_ready = 1";
        }
        if ($cuff_outer > -1) {
            $where .= " AND is_cutting_cuff_bundle_ready = 1";
        }
        if ($back > -1) {
            $where .= " AND is_cutting_back_bundle_ready = 1";
        }
        if ($yoke_upper > -1) {
            $where .= " AND is_cutting_yoke_bundle_ready = 1";
        }
        if ($slv_r > -1) {
            $where .= " AND is_cutting_sleeve_bundle_ready = 1";
        }
        if ($slv_pkt_r > -1) {
            $where .= " AND is_cutting_sleeve_plkt_bundle_ready = 1";
        }
        if ($pocket > -1) {
            $where .= " AND is_cutting_pocket_bundle_ready = 1";
        }

        $check_pkg=$this->access_model->check_package($where);

        $array_size = sizeof($check_pkg);

//        echo '<pre>';
//        print_r($po_no.' ~ '.$array_size);
//        echo '</pre>';
//        die();

        if($array_size == 1){
            $this->access_model->update_package($bundle_tracking_no, $date_time);
            return $this->access_model->update_package_on_carelabel($bundle_tracking_no, $date_time);
        }else{
            return 0;
        }
    }

    public function getRemainingPart()
    {
        $po_no = $this->input->post('po_no');
        $so_no = $this->input->post('so_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');
        $ex_factory = $this->input->post('ex_factory_date');
        $part = $this->input->post('part');

        $get_data['part_name'] = $part;

        $where = '';
        if($po_no != ''){
            $where .= " AND po_no = '$po_no'";
        }
        if($so_no != ''){
            $where .= " AND so_no = '$so_no'";
        }
        if($purchase_order != ''){
            $where .= " AND purchase_order = '$purchase_order'";
        }
        if($item != ''){
            $where .= " AND item = '$item'";
        }
        if($quality != ''){
            $where .= " AND quality = '$quality'";
        }
        if($color != '') {
            $where .= " AND color = '$color'";
        }
        if($ex_factory != '') {
            $where .= " AND ex_factory_date = '$ex_factory'";
        }
        if($part == 'Collar'){
            $where .= " AND is_cutting_collar_bundle_ready = 0 ";

        }if($part == 'Cuff'){
        $where .= " AND is_cutting_cuff_bundle_ready = 0 ";

        }if($part == 'Back'){
            $where .= " AND is_cutting_back_bundle_ready = 0 ";

        }if($part == 'Yoke'){
            $where .= " AND is_cutting_yoke_bundle_ready = 0 ";

        }if($part == 'Sleeve'){
            $where .= " AND is_cutting_sleeve_bundle_ready = 0 ";

        }if($part == 'Slv Plkt'){
            $where .= " AND is_cutting_sleeve_plkt_bundle_ready = 0 ";

        }if($part == 'Pocket'){
            $where .= " AND is_cutting_pocket_bundle_ready = 0 ";

        }


//        $get_data['order_size'] = $this->access_model->getPoItemWiseSizeReport($where);
        $get_data['order_size'] = $this->access_model->getRemainingPart($where);

//        $maincontent = $this->load->view('po_item_wise_size_end_pass_report', $get_data, true);
        $maincontent = $this->load->view('po_item_wise_back_part_report', $get_data, true);

        echo $maincontent;
    }

    public function remainQtyStatus($purchase_order, $item, $status){
        $data['remain_detail'] = $this->access_model->remainQtyStatus($purchase_order, $item, $status);

        $data['maincontent'] = $this->load->view('remain_qty_report', $data, true);
        $this->load->view('master', $data);
    }

    public function getPoItemWiseSizeReport(){
        $po_no = $this->input->post('po_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');

        $where = '';
        if($po_no != ''){
            $where .= " AND t1.po_no LIKE '%$po_no%'";
        }
        if($purchase_order != ''){
            $where .= " AND t1.purchase_order LIKE '%$purchase_order%'";
        }
        if($item != ''){
            $where .= " AND t1.item LIKE '%$item%'";
        }
        if($quality != ''){
            $where .= " AND t1.quality LIKE '%$quality%'";
        }
        if($color != '') {
            $where .= " AND t1.color LIKE '%$color%'";
        }

        $get_data['order_size'] = $this->access_model->getPoItemWiseSizeReport($where);

        $maincontent = $this->load->view('po_item_wise_size_report', $get_data, true);

        echo $maincontent;
    }

    public function getPoItemWiseSizeLineInputReport(){
        $po_no = $this->input->post('po_no');
        $so_no = $this->input->post('so_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');

        $where = '';
        if($po_no != ''){
            $where .= " AND t1.po_no LIKE '%$po_no%'";
        }
        if($so_no != ''){
            $where .= " AND t1.so_no LIKE '%$so_no%'";
        }
        if($purchase_order != ''){
            $where .= " AND t1.purchase_order LIKE '%$purchase_order%'";
        }
        if($item != ''){
            $where .= " AND t1.item LIKE '%$item%'";
        }
        if($quality != ''){
            $where .= " AND t1.quality LIKE '%$quality%'";
        }
        if($color != '') {
            $where .= " AND t1.color LIKE '%$color%'";
        }

        $get_data['order_size'] = $this->access_model->getPoItemWiseSizeReport($where);

        $maincontent = $this->load->view('po_item_wise_size_line_input_report', $get_data, true);

        echo $maincontent;
    }

    public function getPoItemWiseSizeMidPassReport(){
        $po_no = $this->input->post('po_no');
        $so_no = $this->input->post('so_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');

        $where = '';
        if($po_no != ''){
            $where .= " AND t1.po_no LIKE '%$po_no%'";
        }
        if($so_no != ''){
            $where .= " AND t1.so_no LIKE '%$so_no%'";
        }
        if($purchase_order != ''){
            $where .= " AND t1.purchase_order LIKE '%$purchase_order%'";
        }
        if($item != ''){
            $where .= " AND t1.item LIKE '%$item%'";
        }
        if($quality != ''){
            $where .= " AND t1.quality LIKE '%$quality%'";
        }
        if($color != '') {
            $where .= " AND t1.color LIKE '%$color%'";
        }

        $get_data['order_size'] = $this->access_model->getPoItemWiseSizeReport($where);

        $maincontent = $this->load->view('po_item_wise_size_mid_pass_report', $get_data, true);

        echo $maincontent;
    }

    public function getPoItemWiseSizeEndPassReport(){
        $po_no = $this->input->post('po_no');
        $so_no = $this->input->post('so_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');

        $where = '';
        if($po_no != ''){
            $where .= " AND t1.po_no = '$po_no'";
        }
        if($so_no != ''){
            $where .= " AND t1.so_no = '$so_no'";
        }
        if($purchase_order != ''){
            $where .= " AND t1.purchase_order LIKE '%$purchase_order%'";
        }
        if($item != ''){
            $where .= " AND t1.item LIKE '%$item%'";
        }
        if($quality != ''){
            $where .= " AND t1.quality LIKE '%$quality%'";
        }
        if($color != '') {
            $where .= " AND t1.color LIKE '%$color%'";
        }

        $get_data['order_size'] = $this->access_model->getPoItemWiseSizeReport($where);

        $maincontent = $this->load->view('po_item_wise_size_end_pass_report', $get_data, true);

        echo $maincontent;
    }

    public function getPoItemWiseSizeWashReport(){
        $po_no = $this->input->post('po_no');
        $so_no = $this->input->post('so_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');

        $where = '';
        if($po_no != ''){
            $where .= " AND t1.po_no = '$po_no'";
        }
        if($po_no != ''){
            $where .= " AND t1.so_no = '$so_no'";
        }
        if($purchase_order != ''){
            $where .= " AND t1.purchase_order LIKE '%$purchase_order%'";
        }
        if($item != ''){
            $where .= " AND t1.item LIKE '%$item%'";
        }
        if($quality != ''){
            $where .= " AND t1.quality LIKE '%$quality%'";
        }
        if($color != '') {
            $where .= " AND t1.color LIKE '%$color%'";
        }

        $get_data['order_size'] = $this->access_model->getPoItemWiseSizeReport($where);

        $maincontent = $this->load->view('po_item_wise_size_wash_pass_report', $get_data, true);

        echo $maincontent;
    }

    public function getPoItemWiseSizeWashGoingReport(){
        $po_no = $this->input->post('po_no');
        $so_no = $this->input->post('so_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');

        $where = '';
        if($po_no != ''){
            $where .= " AND t1.po_no = '$po_no'";
        }
        if($so_no != ''){
            $where .= " AND t1.so_no = '$so_no'";
        }
        if($purchase_order != ''){
            $where .= " AND t1.purchase_order LIKE '%$purchase_order%'";
        }
        if($item != ''){
            $where .= " AND t1.item LIKE '%$item%'";
        }
        if($quality != ''){
            $where .= " AND t1.quality LIKE '%$quality%'";
        }
        if($color != '') {
            $where .= " AND t1.color LIKE '%$color%'";
        }

        $get_data['order_size'] = $this->access_model->getPoItemWiseSizeReport($where);

        $maincontent = $this->load->view('po_item_wise_size_wash_going_report', $get_data, true);

        echo $maincontent;
    }

    public function getPolyRemainingPcs(){
        $po_no = $this->input->post('po_no');
        $so_no = $this->input->post('so_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');

        $where = '';
        if($po_no != ''){
            $where .= " AND po_no = '$po_no'";
        }
        if($po_no != ''){
            $where .= " AND so_no = '$so_no'";
        }
        if($purchase_order != ''){
            $where .= " AND purchase_order = '$purchase_order'";
        }
        if($item != ''){
            $where .= " AND item = '$item'";
        }
        if($quality != ''){
            $where .= " AND quality = '$quality'";
        }
        if($color != '') {
            $where .= " AND color = '$color'";
        }

        $get_data['remain_pcs'] = $this->access_model->getPolyRemainingPcs($where);

        $maincontent = $this->load->view('po_item_wise_poly_remain_pcs', $get_data, true);

        echo $maincontent;
    }

    public function getCartonRemainingPcs(){
        $po_no = $this->input->post('po_no');
        $so_no = $this->input->post('so_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');

        $where = '';
        if($po_no != ''){
            $where .= " AND po_no = '$po_no'";
        }
        if($po_no != ''){
            $where .= " AND so_no = '$so_no'";
        }
        if($purchase_order != ''){
            $where .= " AND purchase_order = '$purchase_order'";
        }
        if($item != ''){
            $where .= " AND item = '$item'";
        }
        if($quality != ''){
            $where .= " AND quality = '$quality'";
        }
        if($color != '') {
            $where .= " AND color = '$color'";
        }

        $get_data['remain_pcs'] = $this->access_model->getCartonRemainingPcs($where);

        $maincontent = $this->load->view('po_item_wise_carton_remain_pcs', $get_data, true);

        echo $maincontent;
    }

    public function getPoItemWiseSizePackReport(){
        $po_no = $this->input->post('po_no');
        $so_no = $this->input->post('so_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');

        $where = '';
        if($po_no != ''){
            $where .= " AND t1.po_no = '$po_no'";
        }
        if($po_no != ''){
            $where .= " AND t1.so_no = '$so_no'";
        }
        if($purchase_order != ''){
            $where .= " AND t1.purchase_order = '$purchase_order'";
        }
        if($item != ''){
            $where .= " AND t1.item = '$item'";
        }
        if($quality != ''){
            $where .= " AND t1.quality = '$quality'";
        }
        if($color != '') {
            $where .= " AND t1.color = '$color'";
        }

        $get_data['order_size'] = $this->access_model->getPoItemWiseSizeReport($where);

        $maincontent = $this->load->view('po_item_wise_size_pack_pass_report', $get_data, true);

        echo $maincontent;
    }

    public function getPoItemWiseSizeWhReport(){
        $po_no = $this->input->post('po_no');
        $so_no = $this->input->post('so_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');

        $where = '';
        if($po_no != ''){
            $where .= " AND t1.po_no = '$po_no'";
        }
        if($so_no != ''){
            $where .= " AND t1.so_no = '$so_no'";
        }
        if($purchase_order != ''){
            $where .= " AND t1.purchase_order LIKE '%$purchase_order%'";
        }
        if($item != ''){
            $where .= " AND t1.item LIKE '%$item%'";
        }
        if($quality != ''){
            $where .= " AND t1.quality LIKE '%$quality%'";
        }
        if($color != '') {
            $where .= " AND t1.color LIKE '%$color%'";
        }

        $get_data['order_size'] = $this->access_model->getPoItemWiseSizeReport($where);

        $maincontent = $this->load->view('po_item_wise_size_wh_report', $get_data, true);

        echo $maincontent;
    }

    public function getPoItemWiseSizeCartonReport(){
        $po_no = $this->input->post('po_no');
        $so_no = $this->input->post('so_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');

        $where = '';
        if($po_no != ''){
            $where .= " AND t1.po_no = '$po_no'";
        }
        if($so_no != ''){
            $where .= " AND t1.so_no = '$so_no'";
        }
        if($purchase_order != ''){
            $where .= " AND t1.purchase_order LIKE '%$purchase_order%'";
        }
        if($item != ''){
            $where .= " AND t1.item LIKE '%$item%'";
        }
        if($quality != ''){
            $where .= " AND t1.quality LIKE '%$quality%'";
        }
        if($color != '') {
            $where .= " AND t1.color LIKE '%$color%'";
        }

        $get_data['order_size'] = $this->access_model->getPoItemWiseSizeReport($where);

        $maincontent = $this->load->view('po_item_wise_size_carton_pass_report', $get_data, true);

        echo $maincontent;
    }

    public function getPoItemWiseSizeCutReport(){
        $po_no = $this->input->post('po_no');
        $so_no = $this->input->post('so_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');

        $where = '';
        if($po_no != ''){
            $where .= " AND t1.po_no='$po_no'";
        }
        if($so_no != ''){
            $where .= " AND t1.so_no='$so_no'";
        }
        if($purchase_order != ''){
            $where .= " AND t1.purchase_order LIKE '%$purchase_order%'";
        }
        if($item != ''){
            $where .= " AND t1.item LIKE '%$item%'";
        }
        if($quality != ''){
            $where .= " AND t1.quality LIKE '%$quality%'";
        }
        if($color != '') {
            $where .= " AND t1.color LIKE '%$color%'";
        }

        $get_data['order_size'] = $this->access_model->getPoItemWiseSizeReport($where);

        $maincontent = $this->load->view('po_item_wise_size_cut_pass_report', $get_data, true);

        echo $maincontent;
    }

    public function getRemainingCollarBundlesBySize(){
        $po_no = $this->input->post('po_no');
        $so_no = $this->input->post('so_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');
        $size = $this->input->post('size');

        $get_data['po_no'] = $po_no;
        $get_data['purchase_order'] = $purchase_order;
        $get_data['item'] = $item;
        $get_data['quality'] = $quality;
        $get_data['color'] = $color;
        $get_data['size'] = $size;

        $where = '';

        $where .= " AND is_bundle_collar_scanned_line = 0";

        if($po_no != ''){
            $where .= " AND po_no = '$po_no'";
        }
        if($so_no != ''){
            $where .= " AND so_no = '$so_no'";
        }
        if($purchase_order != ''){
            $where .= " AND purchase_order = '$purchase_order'";
        }
        if($item != ''){
            $where .= " AND item = '$item'";
        }
        if($quality != ''){
            $where .= " AND quality = '$quality'";
        }
        if($color != '') {
            $where .= " AND color = '$color'";
        }
        if($size != '') {
            $where .= " AND size='$size'";
        }


        $get_data['remain_collar_bundles'] = $this->access_model->getRemainingCollarCuffBundlesBySize($where);

        $maincontent = $this->load->view('po_item_wise_size_remain_collar_bundle_list', $get_data, true);

        echo $maincontent;
    }

    public function getRemainingCollarBundles(){
        $po_no = $this->input->post('po_no');
        $so_no = $this->input->post('so_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');

        $get_data['po_no'] = $po_no;
        $get_data['purchase_order'] = $purchase_order;
        $get_data['item'] = $item;
        $get_data['quality'] = $quality;
        $get_data['color'] = $color;

        $where = '';

        $where .= " AND is_bundle_collar_scanned_line = 0";

        if($po_no != ''){
            $where .= " AND po_no = '$po_no'";
        }
        if($so_no != ''){
            $where .= " AND so_no = '$so_no'";
        }
        if($purchase_order != ''){
            $where .= " AND purchase_order = '$purchase_order'";
        }
        if($item != ''){
            $where .= " AND item = '$item'";
        }
        if($quality != ''){
            $where .= " AND quality = '$quality'";
        }
        if($color != '') {
            $where .= " AND color = '$color'";
        }

        $get_data['remain_collar_bundles'] = $this->access_model->getRemainingCollarCuffBundlesBySize($where);

        $maincontent = $this->load->view('po_item_wise_remain_collar_bundle_list', $get_data, true);

        echo $maincontent;
    }

    public function getRemainingCutCollarBundlesBySize(){
        $po_no = $this->input->post('po_no');
        $so_no = $this->input->post('so_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');
        $size = $this->input->post('size');

        $get_data['po_no'] = $po_no;
        $get_data['so_no'] = $so_no;
        $get_data['purchase_order'] = $purchase_order;
        $get_data['item'] = $item;
        $get_data['quality'] = $quality;
        $get_data['color'] = $color;
        $get_data['size'] = $size;

        $where = '';

        $where .= " AND is_cutting_collar_bundle_ready = 0";

        if($po_no != ''){
            $where .= " AND po_no = '$po_no'";
        }
        if($so_no != ''){
            $where .= " AND so_no = '$so_no'";
        }
        if($purchase_order != ''){
            $where .= " AND purchase_order LIKE '%$purchase_order%'";
        }
        if($item != ''){
            $where .= " AND item LIKE '%$item%'";
        }
        if($quality != ''){
            $where .= " AND quality LIKE '%$quality%'";
        }
        if($color != '') {
            $where .= " AND color LIKE '%$color%'";
        }
        if($size != '') {
            $where .= " AND size='$size'";
        }


        $get_data['remain_collar_bundles'] = $this->access_model->getRemainingCutCollarCuffBundlesBySize($where);

        $maincontent = $this->load->view('po_item_wise_size_remain_collar_bundle_list', $get_data, true);

        echo $maincontent;
    }

    public function getRemainingCuffBundlesBySize(){
        $po_no = $this->input->post('po_no');
        $so_no = $this->input->post('so_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');
        $size = $this->input->post('size');

        $get_data['po_no'] = $po_no;
        $get_data['so_no'] = $so_no;
        $get_data['purchase_order'] = $purchase_order;
        $get_data['item'] = $item;
        $get_data['quality'] = $quality;
        $get_data['color'] = $color;
        $get_data['size'] = $size;

        $where = '';

        $where .= " AND is_bundle_cuff_scanned_line = 0";

        if($po_no != ''){
            $where .= " AND po_no = '$po_no'";
        }
        if($so_no != ''){
            $where .= " AND so_no = '$so_no'";
        }
        if($purchase_order != ''){
            $where .= " AND purchase_order = '$purchase_order'";
        }
        if($item != ''){
            $where .= " AND item = '$item'";
        }
        if($quality != ''){
            $where .= " AND quality = '$quality'";
        }
        if($color != '') {
            $where .= " AND color = '$color'";
        }
        if($size != '') {
            $where .= " AND size='$size'";
        }


        $get_data['remain_collar_bundles'] = $this->access_model->getRemainingCollarCuffBundlesBySize($where);

        $maincontent = $this->load->view('po_item_wise_size_remain_cuff_bundle_list', $get_data, true);

        echo $maincontent;
    }

    public function getRemainingCuffBundles(){
        $po_no = $this->input->post('po_no');
        $so_no = $this->input->post('so_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');

        $get_data['po_no'] = $po_no;
        $get_data['so_no'] = $so_no;
        $get_data['purchase_order'] = $purchase_order;
        $get_data['item'] = $item;
        $get_data['quality'] = $quality;
        $get_data['color'] = $color;
        $get_data['collar_cuff'] = $color;

        $where = '';

        $where .= " AND is_bundle_cuff_scanned_line = 0";

        if($po_no != ''){
            $where .= " AND po_no = '$po_no'";
        }
        if($so_no != ''){
            $where .= " AND so_no = '$so_no'";
        }
        if($purchase_order != ''){
            $where .= " AND purchase_order = '$purchase_order'";
        }
        if($item != ''){
            $where .= " AND item = '$item'";
        }
        if($quality != ''){
            $where .= " AND quality = '$quality'";
        }
        if($color != '') {
            $where .= " AND color = '$color'";
        }


        $get_data['remain_collar_bundles'] = $this->access_model->getRemainingCollarCuffBundlesBySize($where);

        $maincontent = $this->load->view('po_item_wise_remain_cuff_bundle_list', $get_data, true);

        echo $maincontent;
    }

    public function getRemainingCutCuffBundlesBySize(){
        $po_no = $this->input->post('po_no');
        $so_no = $this->input->post('so_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');
        $size = $this->input->post('size');

        $get_data['po_no'] = $po_no;
        $get_data['so_no'] = $so_no;
        $get_data['purchase_order'] = $purchase_order;
        $get_data['item'] = $item;
        $get_data['quality'] = $quality;
        $get_data['color'] = $color;
        $get_data['size'] = $size;

        $where = '';

        $where .= " AND is_cutting_cuff_bundle_ready = 0";

        if($po_no != ''){
            $where .= " AND po_no = '$po_no'";
        }
        if($so_no != ''){
            $where .= " AND so_no = '$so_no'";
        }
        if($purchase_order != ''){
            $where .= " AND purchase_order LIKE '%$purchase_order%'";
        }
        if($item != ''){
            $where .= " AND item LIKE '%$item%'";
        }
        if($quality != ''){
            $where .= " AND quality LIKE '%$quality%'";
        }
        if($color != '') {
            $where .= " AND color LIKE '%$color%'";
        }
        if($size != '') {
            $where .= " AND size='$size'";
        }

        $get_data['remain_collar_bundles'] = $this->access_model->getRemainingCutCollarCuffBundlesBySize($where);

        $maincontent = $this->load->view('po_item_wise_size_remain_cuff_bundle_list', $get_data, true);

        echo $maincontent;
    }

    public function getPoItemWiseSizeCCReport(){
        $po_no = $this->input->post('po_no');
        $so_no = $this->input->post('so_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');

        $get_data['po_no'] = $po_no;
        $get_data['so_no'] = $so_no;
        $get_data['purchase_order'] = $purchase_order;
        $get_data['item'] = $item;
        $get_data['quality'] = $quality;
        $get_data['color'] = $color;


        $where = '';
        if($po_no != ''){
            $where .= " AND t1.po_no = '$po_no'";
        }
        if($so_no != ''){
            $where .= " AND t1.so_no = '$so_no'";
        }
        if($purchase_order != ''){
            $where .= " AND t1.purchase_order LIKE '%$purchase_order%'";
        }
        if($item != ''){
            $where .= " AND t1.item LIKE '%$item%'";
        }
        if($quality != ''){
            $where .= " AND t1.quality LIKE '%$quality%'";
        }
        if($color != '') {
            $where .= " AND t1.color LIKE '%$color%'";
        }

        $get_data['order_size'] = $this->access_model->getPoItemWiseSizeCCReport($where);

        $maincontent = $this->load->view('po_item_wise_size_cc_report', $get_data, true);

        echo $maincontent;
    }

    public function getPoItemWiseSizeCutCCReport(){
        $po_no = $this->input->post('po_no');
        $so_no = $this->input->post('so_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');

        $get_data['po_no'] = $po_no;
        $get_data['so_no'] = $so_no;
        $get_data['purchase_order'] = $purchase_order;
        $get_data['item'] = $item;
        $get_data['quality'] = $quality;
        $get_data['color'] = $color;


        $where = '';
        if($po_no != ''){
            $where .= " AND t1.po_no = '$po_no'";
        }
        if($so_no != ''){
            $where .= " AND t1.so_no = '$so_no'";
        }
        if($purchase_order != ''){
            $where .= " AND t1.purchase_order LIKE '%$purchase_order%'";
        }
        if($item != ''){
            $where .= " AND t1.item LIKE '%$item%'";
        }
        if($quality != ''){
            $where .= " AND t1.quality LIKE '%$quality%'";
        }
        if($color != '') {
            $where .= " AND t1.color LIKE '%$color%'";
        }

        $get_data['order_size'] = $this->access_model->getPoItemWiseSizeCutCCReport($where);

        $maincontent = $this->load->view('po_item_wise_size_cut_cc_report', $get_data, true);

        echo $maincontent;
    }

    public function getPoItemWiseSizeRemainCutSendCL(){
        $po_no = $this->input->post('po_no');
        $so_no = $this->input->post('so_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');
        $size = $this->input->post('size');


        $where = '';
        if($po_no != ''){
            $where .= " AND po_no = '$po_no'";
        }
        if($so_no != ''){
            $where .= " AND so_no = '$so_no'";
        }
        if($purchase_order != ''){
            $where .= " AND purchase_order LIKE '%$purchase_order%'";
        }
        if($item != ''){
            $where .= " AND item LIKE '%$item%'";
        }
        if($quality != ''){
            $where .= " AND quality LIKE '%$quality%'";
        }
        if($color != '') {
            $where .= " AND color LIKE '%$color%'";
        }
        if($size != '') {
            $where .= " AND size = '$size'";
        }

        $where .= " AND sent_to_production=0";

        $get_data['remain_size_cl'] = $this->access_model->getRemainingCLBySize($where);

        $maincontent = $this->load->view('po_item_wise_size_remain_cl_list', $get_data, true);

        echo $maincontent;
    }

    public function getCutBalancePcs(){
        $po_no = $this->input->post('po_no');
        $so_no = $this->input->post('so_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');

        $where = '';
        if($po_no != ''){
            $where .= " AND po_no = '$po_no'";
        }
        if($so_no != ''){
            $where .= " AND so_no = '$so_no'";
        }
        if($purchase_order != ''){
            $where .= " AND purchase_order = '$purchase_order'";
        }
        if($item != ''){
            $where .= " AND item = '$item'";
        }
        if($quality != ''){
            $where .= " AND quality = '$quality'";
        }
        if($color != '') {
            $where .= " AND color = '$color'";
        }

        $where .= " AND sent_to_production=0";

        $get_data['remain_size_cl'] = $this->access_model->getRemainingPcs($where);

        $maincontent = $this->load->view('po_item_wise_remain_cl_list_modal', $get_data, true);

        echo $maincontent;
    }

    public function getPoItemWiseSizeRemainMidCL(){
        $po_no = $this->input->post('po_no');
        $so_no = $this->input->post('so_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');
        $size = $this->input->post('size');


        $where = '';
        $where1 = '';
        $where2 = '';

        if($po_no != ''){
            $where .= " AND po_no = '$po_no'";
        }
        if($so_no != ''){
            $where .= " AND so_no = '$so_no'";
        }
        if($purchase_order != ''){
            $where .= " AND purchase_order LIKE '%$purchase_order%'";
        }
        if($item != ''){
            $where .= " AND item LIKE '%$item%'";
        }
        if($quality != ''){
            $where .= " AND quality LIKE '%$quality%'";
        }
        if($color != '') {
            $where .= " AND color LIKE '%$color%'";
        }
        if($size != '') {
            $where .= " AND size = '$size'";
        }

        $where1 .= " AND access_points < 3 AND access_points_status IN (0, 1)";
        $where2 .= " AND access_points = 3 AND access_points_status IN (0, 2, 3)";

        $get_data['remain_size_cl'] = $this->access_model->getRemainingMidEndCLBySize($where, $where1, $where2);

        $maincontent = $this->load->view('po_item_wise_size_remain_cl_list_modal', $get_data, true);

        echo $maincontent;
    }

    public function getPoItemWiseSizeRemainEndCL(){
        $po_no = $this->input->post('po_no');
        $so_no = $this->input->post('so_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');
        $size = $this->input->post('size');


        $where = '';
        $where1 = '';
        $where2 = '';

        if($po_no != ''){
            $where .= " AND po_no = '$po_no'";
        }
        if($so_no != ''){
            $where .= " AND so_no = '$so_no'";
        }
        if($purchase_order != ''){
            $where .= " AND purchase_order LIKE '%$purchase_order%'";
        }
        if($item != ''){
            $where .= " AND item LIKE '%$item%'";
        }
        if($quality != ''){
            $where .= " AND quality LIKE '%$quality%'";
        }
        if($color != '') {
            $where .= " AND color LIKE '%$color%'";
        }
        if($size != '') {
            $where .= " AND size = '$size'";
        }

        $where1 .= " AND access_points < 4 AND access_points_status IN (0, 1, 2, 3)";
        $where2 .= " AND access_points = 4 AND access_points_status IN (0, 2, 3)";

        $get_data['remain_size_cl'] = $this->access_model->getRemainingMidEndCLBySize($where, $where1, $where2);

        $maincontent = $this->load->view('po_item_wise_size_remain_cl_list_modal', $get_data, true);

        echo $maincontent;
    }

    public function getRemainingLineMidQcPcs(){
        $po_no = $this->input->post('po_no');
        $so_no = $this->input->post('so_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');
        $line_id = $this->session->userdata('line_id');


        $where = '';
        $where1 = '';
        $where2 = '';

        if($po_no != ''){
            $where .= " AND po_no = '$po_no'";
        }
        if($so_no != ''){
            $where .= " AND so_no = '$so_no'";
        }
        if($purchase_order != ''){
            $where .= " AND purchase_order = '$purchase_order'";
        }
        if($item != ''){
            $where .= " AND item = '$item'";
        }
        if($quality != ''){
            $where .= " AND quality = '$quality'";
        }
        if($color != '') {
            $where .= " AND color = '$color'";
        }
        if($line_id != '' && $line_id != 0) {
            $where .= " AND line_id = '$line_id'";
        }

        $where1 .= " AND access_points < 3 AND access_points_status IN (0, 1)";
        $where2 .= " AND access_points = 3 AND access_points_status IN (0, 2, 3)";

        $get_data['remain_size_cl'] = $this->access_model->getRemainingMidEndCL($where, $where1, $where2);

        $maincontent = $this->load->view('po_item_wise_remain_cl_list_modal', $get_data, true);

        echo $maincontent;
    }

    public function getRemainingLineOutputPcs(){
        $po_no = $this->input->post('po_no');
        $so_no = $this->input->post('so_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');
        $line_id = $this->session->userdata('line_id');



        $where = '';
        $where1 = '';
        $where2 = '';

        if($po_no != ''){
            $where .= " AND po_no = '$po_no'";
        }
        if($so_no != ''){
            $where .= " AND so_no = '$so_no'";
        }
        if($purchase_order != ''){
            $where .= " AND purchase_order = '$purchase_order'";
        }
        if($item != ''){
            $where .= " AND item = '$item'";
        }
        if($quality != ''){
            $where .= " AND quality = '$quality'";
        }
        if($color != '') {
            $where .= " AND color = '$color'";
        }
        if($line_id != 0 && $line_id != '') {
            $where .= " AND line_id = '$line_id'";
        }

        $where .= " AND access_points <= 4 AND access_points_status IN (0, 1, 2, 3)";

        $get_data['remain_size_cl'] = $this->access_model->getRemainingPcs($where);

        $maincontent = $this->load->view('po_item_wise_remain_cl_list_modal', $get_data, true);

        echo $maincontent;
    }

    public function getRemainingLineInputPcs(){
        $po_no = $this->input->post('po_no');
        $so_no = $this->input->post('so_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');
        $line_id = $this->session->userdata('line_id');


        $where = '';
        $where1 = '';
        $where2 = '';

        if($po_no != ''){
            $where .= " AND po_no = '$po_no'";
        }
        if($so_no != ''){
            $where .= " AND so_no = '$so_no'";
        }
        if($purchase_order != ''){
            $where .= " AND purchase_order = '$purchase_order'";
        }
        if($item != ''){
            $where .= " AND item = '$item'";
        }
        if($quality != ''){
            $where .= " AND quality = '$quality'";
        }
        if($color != '') {
            $where .= " AND color = '$color'";
        }

        $where .= " AND line_id = 0 AND sent_to_production=1";

        $get_data['remain_size_cl'] = $this->access_model->getRemainingPcs($where);

        $maincontent = $this->load->view('po_item_wise_remain_cl_list_modal', $get_data, true);

        echo $maincontent;
    }

    public function getPoItemWiseSizeRemainInputCL(){
        $po_no = $this->input->post('po_no');
        $so_no = $this->input->post('so_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');
        $size = $this->input->post('size');

        $where = '';
        if($po_no != ''){
            $where .= " AND po_no = '$po_no'";
        }
        if($so_no != ''){
            $where .= " AND so_no = '$so_no'";
        }
        if($purchase_order != ''){
            $where .= " AND purchase_order LIKE '%$purchase_order%'";
        }
        if($item != ''){
            $where .= " AND item LIKE '%$item%'";
        }
        if($quality != ''){
            $where .= " AND quality LIKE '%$quality%'";
        }
        if($color != '') {
            $where .= " AND color LIKE '%$color%'";
        }
        if($size != '') {
            $where .= " AND size = '$size'";
        }

        $where .= " AND line_id = 0";

        $get_data['remain_size_cl'] = $this->access_model->getRemainingCLBySize($where);

        $maincontent = $this->load->view('po_item_wise_size_remain_cl_list', $get_data, true);

        echo $maincontent;
    }

    public function getPoItemWiseSizeRemainWashCL(){
        $po_no = $this->input->post('po_no');
        $so_no = $this->input->post('so_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');
        $size = $this->input->post('size');

        $where = '';
        if($po_no != ''){
            $where .= " AND po_no = '$po_no'";
        }
        if($so_no != ''){
            $where .= " AND so_no = '$so_no'";
        }
        if($purchase_order != ''){
            $where .= " AND purchase_order LIKE '%$purchase_order%'";
        }
        if($item != ''){
            $where .= " AND item LIKE '%$item%'";
        }
        if($quality != ''){
            $where .= " AND quality LIKE '%$quality%'";
        }
        if($color != '') {
            $where .= " AND color LIKE '%$color%'";
        }
        if($size != '') {
            $where .= " AND size = '$size'";
        }

        $where .= " AND washing_status = 0";

        $get_data['remain_size_cl'] = $this->access_model->getRemainingCLBySize($where);

        $maincontent = $this->load->view('po_item_wise_size_remain_cl_list', $get_data, true);

        echo $maincontent;
    }

    public function getPoItemWiseSizeRemainWashGoingCL(){
        $po_no = $this->input->post('po_no');
        $so_no = $this->input->post('so_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');
        $size = $this->input->post('size');

        $where = '';
        if($po_no != ''){
            $where .= " AND po_no = '$po_no'";
        }
        if($so_no != ''){
            $where .= " AND so_no = '$so_no'";
        }
        if($purchase_order != ''){
            $where .= " AND purchase_order = '$purchase_order'";
        }
        if($item != ''){
            $where .= " AND item = '$item'";
        }
        if($quality != ''){
            $where .= " AND quality = '$quality'";
        }
        if($color != '') {
            $where .= " AND color = '$color'";
        }
        if($size != '') {
            $where .= " AND size = '$size'";
        }

        $where .= " AND is_going_wash = 0";
        $where .= " AND access_points = 4";
        $where .= " AND access_points_status = 4";

        $get_data['remain_size_cl'] = $this->access_model->getRemainingCLBySize($where);

        $maincontent = $this->load->view('po_item_wise_size_remain_cl_list', $get_data, true);

        echo $maincontent;
    }

    public function getPoItemWiseSizeRemainWashReturnCL()
    {
        $po_no = $this->input->post('po_no');
        $so_no = $this->input->post('so_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');
        $size = $this->input->post('size');

        $where = '';
        if($po_no != ''){
            $where .= " AND po_no = '$po_no'";
        }
        if($so_no != ''){
            $where .= " AND so_no = '$so_no'";
        }
        if($purchase_order != ''){
            $where .= " AND purchase_order = '$purchase_order'";
        }
        if($item != ''){
            $where .= " AND item ='$item'";
        }
        if($quality != ''){
            $where .= " AND quality = '$quality'";
        }
        if($color != '') {
            $where .= " AND color = '$color'";
        }
        if($size != '') {
            $where .= " AND size = '$size'";
        }

        $where .= " AND is_going_wash = 1";
        $where .= " AND washing_status = 0";


        $get_data['remain_size_cl'] = $this->access_model->getRemainingCLBySize($where);

        $maincontent = $this->load->view('po_item_wise_size_remain_cl_list', $get_data, true);

        echo $maincontent;
    }

    public function getPoItemWiseSizeRemainPackCL(){
        $po_no = $this->input->post('po_no');
        $so_no = $this->input->post('so_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');
        $size = $this->input->post('size');

        $where = '';
        if($po_no != ''){
            $where .= " AND po_no = '$po_no'";
        }
        if($so_no != ''){
            $where .= " AND so_no = '$so_no'";
        }
        if($purchase_order != ''){
            $where .= " AND purchase_order LIKE '%$purchase_order%'";
        }
        if($item != ''){
            $where .= " AND item LIKE '%$item%'";
        }
        if($quality != ''){
            $where .= " AND quality LIKE '%$quality%'";
        }
        if($color != '') {
            $where .= " AND color LIKE '%$color%'";
        }
        if($size != '') {
            $where .= " AND size = '$size'";
        }

        $where .= " AND packing_status = 0";

        $get_data['remain_size_cl'] = $this->access_model->getRemainingCLBySize($where);

        $maincontent = $this->load->view('po_item_wise_size_remain_cl_list', $get_data, true);

        echo $maincontent;
    }

    public function getPoItemWiseSizeRemainWhCL(){
        $po_no = $this->input->post('po_no');
        $so_no = $this->input->post('so_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');
        $size = $this->input->post('size');

        $where = '';
        if($po_no != ''){
            $where .= " AND po_no = '$po_no'";
        }
        if($so_no != ''){
            $where .= " AND so_no = '$so_no'";
        }
        if($purchase_order != ''){
            $where .= " AND purchase_order LIKE '%$purchase_order%'";
        }
        if($item != ''){
            $where .= " AND item LIKE '%$item%'";
        }
        if($quality != ''){
            $where .= " AND quality LIKE '%$quality%'";
        }
        if($color != '') {
            $where .= " AND color LIKE '%$color%'";
        }
        if($size != '') {
            $where .= " AND size = '$size'";
        }

        $where .= " AND carton_status=0 AND warehouse_qa_type = 0";

        $get_data['remain_size_cl'] = $this->access_model->getRemainingCLBySize($where);

        $maincontent = $this->load->view('po_item_wise_size_remain_cl_list', $get_data, true);

        echo $maincontent;
    }

    public function getPoItemWiseSizeRemainCartonCL(){
        $po_no = $this->input->post('po_no');
        $so_no = $this->input->post('so_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');
        $size = $this->input->post('size');

        $where = '';
        if($po_no != ''){
            $where .= " AND po_no = '$po_no'";
        }
        if($so_no != ''){
            $where .= " AND so_no = '$so_no'";
        }
        if($purchase_order != ''){
            $where .= " AND purchase_order LIKE '%$purchase_order%'";
        }
        if($item != ''){
            $where .= " AND item LIKE '%$item%'";
        }
        if($quality != ''){
            $where .= " AND quality LIKE '%$quality%'";
        }
        if($color != '') {
            $where .= " AND color LIKE '%$color%'";
        }
        if($size != '') {
            $where .= " AND size = '$size'";
        }

        $where .= " AND carton_status = 0";

        $get_data['remain_size_cl'] = $this->access_model->getRemainingCLBySize($where);

        $maincontent = $this->load->view('po_item_wise_size_remain_cl_list', $get_data, true);

        echo $maincontent;
    }

    public function care_label_report(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['title'] = 'Care Label Report';
        $get_data['cl_sent_to_production'] = $this->access_model->getCareLabelSentReport($date);
        $data['maincontent'] = $this->load->view('care_label_report', $get_data, true);
        $this->load->view('master', $data);
    }

    public function care_label_report_new(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['title'] = 'Care Label Report';
        $get_data['cut_tracking_list'] = $this->access_model->getCutTrackingNoList();
        $get_data['cl_sent_to_production'] = $this->access_model->getCareLabelSentReportNew();
        $data['maincontent'] = $this->load->view('care_label_report_new', $get_data, true);
        $this->load->view('master', $data);
    }

    public function getCutPendingClReport($cut_tracking_no){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['title'] = 'Cutting Care Label Pending Report';
        $get_data['cl_sent_to_production'] = $this->access_model->getCutPendingClReport($cut_tracking_no);
        $data['maincontent'] = $this->load->view('cut_pending_care_label_report', $get_data, true);
        $this->load->view('master', $data);
    }

    public function getSummaryReportbyDate(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $date_picker = $_POST['date_picker'];

//        $formated_date = date_format('Y-m-d', strtotime($date_picker));

        $cl_sent_to_production = $this->access_model->getCareLabelSentReport($date_picker);

        $sl=1;
        $new_line = '';

        foreach ($cl_sent_to_production as $v){

            $new_line .= '<tr>';

            $new_line .= '<td>' . $sl .'</td>';
            $new_line .= '<td>' . $v['cut_tracking_no'] . '</td>';
            $new_line .= '<td>' . $v['cut_tracking_no_qty'] . '</td>';
            $new_line .= '<td>' . $v['report_date'] . '</td>';

            $new_line .= '</tr>';
            $sl++;
        }

        echo $new_line;
    }

    public function getSummaryReportbyDateNew(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $date_picker = $_POST['date_picker'];

//        $formated_date = date_format('Y-m-d', strtotime($date_picker));

        $cl_sent_to_production = $this->access_model->getCareLabelSentReportNew($date_picker);

        $sl=1;
        $new_line = '';

        foreach ($cl_sent_to_production as $v){

            $new_line .= '<tr>';

            $new_line .= '<td>' . $sl .'</td>';
            $new_line .= '<td>' . $v['po_no'] . '</td>';
            $new_line .= '<td>' . $v['style_no'] . '</td>';
            $new_line .= '<td>' . $v['color'] . '</td>';
            $new_line .= '<td>' . $v['cut_tracking_no'] . '</td>';
            $new_line .= '<td>' . $v['cut_tracking_no_qty'] . '</td>';
            $new_line .= '<td>' . $v['count_sent_to_prod'] . '</td>';
            $new_line .= '<td><a target="_blank" href="'. base_url() .'access/getCutPendingClReport/' .$v['cut_tracking_no'] .'">' . ($v['cut_tracking_no_qty'] - $v['count_sent_to_prod']) . '</a></td>';
            $new_line .= '<td>' . $v['production_sending_date'] . '</td>';

            $new_line .= '</tr>';
            $sl++;
        }

        echo $new_line;
    }

    public function sendingToProduction(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');

        $cut_tracking_no = $_POST['cut_tracking_no'];
        $isAvailable = $this->access_model->isAlreadySentToProduction($cut_tracking_no);
        $array_size = sizeof($isAvailable);

        if($array_size == 0){
              $this->access_model->sendingToProduction($cut_tracking_no, $date_time);
        }
    }

    public function sendingToProductionForCareLabel(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');

//        $care_label_no = $_POST['care_label_no'];

        $care_label_no = $this->input->post('carelabel_tracking_no');

        $res = $this->access_model->isPrintedCL($care_label_no);

//        if($res[0]['is_printed'] == 1 && $res[0]['line_id'] != 0){
        if($res[0]['is_printed'] == 1){
            $this->access_model->sendingToProductionCareLabel($care_label_no, $date_time);

            $data['message']="$care_label_no Successfully Sent!";
            $this->session->set_userdata($data);
        }
        else{
            $data['exception']="$care_label_no Failed to Send!";
            $this->session->set_userdata($data);
        }

        redirect('access/care_label_send_to_production_individual', 'refresh');
    }

    public function sendingCutToProduction(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');

//        $care_label_no = $_POST['care_label_no'];

        $cl_array = $this->input->post('cl_array');
        $line_id = $this->input->post('line_id');

        $failed_cls = array();

        foreach ($cl_array as $k => $v) {
            $care_label_no = $v;

            $res = $this->access_model->isPrintedCL($care_label_no);

//        if($res[0]['is_printed'] == 1 && $res[0]['line_id'] != 0){
            if($res[0]['is_printed'] == 1){
                $this->access_model->sendingToProductionCareLabel($care_label_no, $date_time, $line_id);

//                $data['message']="$care_label_no Successfully Sent!";
//                $this->session->set_userdata($data);
            }
            else{
                array_push($failed_cls, $care_label_no);
            }
        }

        $data['cl_list_array']=$failed_cls;
        $this->session->set_userdata($data);

        echo 'DONE';

//        redirect('access/care_label_send_to_production_individual', 'refresh');
    }

    public function sendingToProductionForBundle(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');

//        $care_label_no = $_POST['care_label_no'];

        $bundle_tracking_no = $this->input->post('bundle_tracking_no');

        $res = $this->access_model->isPrintedBundle($bundle_tracking_no);

//        if($res[0]['is_printed'] == 1 && $res[0]['line_id'] != 0){
        if($res[0]['is_printed'] == 1){
            $this->access_model->sendingToProductionBundle($bundle_tracking_no, $date_time);

            $data['message']='Successfully Sent!';
            $this->session->set_userdata($data);
        }
        else{
            $data['exception']='Failed to send!';
            $this->session->set_userdata($data);
        }

        redirect('access/care_label_send_to_production_bundle', 'refresh');
    }

    public function cuttingStockReport(){
        $data['title'] = 'Cutting Stock Report';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

//        $data['purchase_order_nos'] = $this->access_model->getAllPurchaseOrders();

        $data['maincontent'] = $this->load->view('cutting_stock_report', $data, true);
        $this->load->view('master', $data);
    }

    public function printing_care_label($po_id, $po_no, $brand, $style_no, $color, $size, $quantity){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');

        $data_pc['po_id'] = $po_id;
        $data_pc['date_time'] = $date_time;
//        $data_pc['po_no'] = $po_no;
//        $data_pc['brand'] = $brand;
//        $data_pc['style_no'] = $style_no;
//        $data_pc['color'] = $color;
//        $data_pc['size'] = $size;
//        $data_pc['quantity'] = $quantity;

        $isPrintedRes = $this->access_model->isCareLabelPrinted($po_id);
        $isPrinted = $isPrintedRes[0]['care_label_printed'];

        if($isPrinted == 0)
        {

                for($i=1; $i <= $quantity; $i++){

                    $po_last_no = $this->access_model->getLastPcTrackingNo();
                    $po_last = $po_last_no[0]['pc_tracking_no'];  // Got Last Unique piece tracking id from DB

                    $to_int_conv = (int)$po_last; // Varchar to int conversion
                    if($to_int_conv < 999999999){
                        $to_int_conv = $to_int_conv + 1;
                        $new_unique_pc_no_conversion = sprintf("%09s", $to_int_conv);
                        $data_pc['pc_tracking_no'] = $new_unique_pc_no_conversion;
                        $this->access_model->insertingData('tb_pc_detail', $data_pc);
                    }
                    if($to_int_conv >= 999999999){
                        $to_int_conv = 0;
                        $to_int_conv = $to_int_conv + 1;
                        $new_unique_pc_no_conversion = sprintf("%09s", $to_int_conv);
                        $data_pc['pc_tracking_no'] = $new_unique_pc_no_conversion;
                        $this->access_model->insertingData('tb_pc_detail', $data_pc);
                    }
                }


            $this->access_model->CareLabelPrinted($po_id, 1);
        }


        $po_CareLabelInfo['po_CareLabelInfo'] = $this->access_model->getCareLabelInfo($po_id);

        $this->load->view('print_care_label', $po_CareLabelInfo);
    }

    public function print_bundlecut_summary($cut_tracking_no){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');

        $data_pc['date_time'] = $date_time;
        $data_pc['cut_tracking_no'] = $cut_tracking_no;
        $data_pc['po_cut_summary'] = $this->access_model->getPOCutSummary($cut_tracking_no);
        $data['maincontent'] = $this->load->view('print_bundlecut_summary', $data_pc);
    }

    public function create_bundle_cut($po_no){
//        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
//        
//        $date_time=$datex->format('Y-m-d H:i:s');
//
//        $data_pc['date_time'] = $date_time;

        $data_pc['po_no'] = $po_no;

//        $data_pc['po_info_cut'] = $this->access_model->getPOsForCuttingByPo($po_no);
//        $data_pc['po_quality'] = $this->access_model->getPoGetQuality($po_no);

        $data['maincontent'] = $this->load->view('cutting_input', '', true);
//        $this->load->view('master', $data);
    }

    public function bundle_creation(){
        $po_no_id = $this->input->post('po_no_id');
        $size = $this->input->post('size');
        $quantity = $this->input->post('quantity');
        $quality = $this->input->post('quality');
        $marker = $this->input->post('marker');
        $bundle_ratio = $this->input->post('bundle_ratio');
        $lot = $this->input->post('lot');

        if(!empty($marker) && !empty($bundle_ratio)){


            $bundle_count = 0;
            foreach ($bundle_ratio as $k => $v){


                $sz = $size[$k];
                $qty = $quantity[$k];
                $bndl_ratio = $bundle_ratio[$k];

//                echo '<pre>';
//                print_r();
//                echo '</pre>';
                $res_floor = floor($qty / $bndl_ratio);
                $floor_ratio = $res_floor * $bndl_ratio;

                $res_after_point = ($qty % $bndl_ratio);
                $data_array = array();

                for($i=0; $i < $floor_ratio; $i++){
//                    echo '<pre>';
//                    print_r($floor_ratio);
//                    echo '</pre>';
                    $dt_array = array_push($data_array, $bndl_ratio);
                }



                echo '<pre>';
                print_r($res_after_point);
                echo '</pre>';

                while($qty > $bundle_count){

                    $bundle_count = $bundle_count + $bndl_ratio;
                    $bundle_start = ($bundle_count+1) - ($bndl_ratio);


//                        echo '<pre>';
//                        print_r($bundle_start .' - '. $bundle_count);
//                        echo '</pre>';

                }
            }
        }
    }

    public function excelUpload(){
        $data['title'] = 'Upload Excel';
        $data['maincontent'] = 'Upload Excel Page!';
        $this->load->view('master', $data);
    }

    public function company_list() {
        $data['title'] = 'Company List';
	    $get_data['companies'] = $this->access_model->getAllTbl('tb_company');
        $data['maincontent'] = $this->load->view('company_list', $get_data, true);
        $this->load->view('master', $data);
    }

    public function vehicle_codes() {
        $data['title'] = 'Vehicle Codes';
		$get_data['v_codes'] = $this->access_model->getAllVehicleCodes();
        $data['maincontent'] = $this->load->view('vehicle_codes', $get_data, true);
        $this->load->view('master', $data);
    }

    public function isUserIDExist() {
		$user_id = trim($this->input->post('user_id'));
		$get_data = $this->access_model->isUserIDExist($user_id);
        echo json_encode($get_data);
    }

    public function isCompanyExist() {
		$company_name = ($this->input->post('company_name'));
		$get_data = $this->access_model->isCompanyExist($company_name);
        echo json_encode($get_data);
    }

    public function isOldPasswordExist() {
		$old_password = ($this->input->post('old_password'));
		$employee_code = $this->session->userdata('employee_code');
		$get_data = $this->access_model->isOldPasswordExist($employee_code, $old_password);
        echo json_encode($get_data);
    }

    public function isCardNoExist() {
		$card_no = trim($this->input->post('card_no'));
		$get_data = $this->access_model->isCardNoExist($card_no);
        echo json_encode($get_data);
    }

    public function new_card() {
        $data['title'] = 'New Card';
	$get_data['companies'] = $this->access_model->getAllCompanies();
	$get_data['v_sizes'] = $this->access_model->getVehicleSizes();
        $data['maincontent'] = $this->load->view('new_card', $get_data, true);
        $this->load->view('master', $data);
    }

    public function add_new_company() {
        $data['title'] = 'New Company';
        $data['maincontent'] = $this->load->view('new_company', $get_data, true);
        $this->load->view('master', $data);
    }

    public function change_password() {
        $data['title'] = 'Change Passord';
        $data['maincontent'] = $this->load->view('change_password', $get_data, true);
        $this->load->view('master', $data);
    }

    public function new_time_condition() {
        $data['title'] = 'New Time Condition';
	/*$get_data['times'] = $this->access_model->getAllExsistingTimes();*/
        $data['maincontent'] = $this->load->view('new_time_condition', $get_data, true);
        $this->load->view('master', $data);
    }

	public function changing_password(){
		$employee_code = $this->session->userdata('employee_code');
		$data['confirm_new_password'] = $this->input->post('confirm_new_password');

		$updated = $this->access_model->update_password($employee_code, $data['confirm_new_password']);
		$data['message']='Password Successfully Updated. Please Log in again.';
        $this->session->set_userdata($data);

		$this->session->unset_userdata('employee_code');
        $this->session->unset_userdata('employee_name');
        $this->session->unset_userdata('employee_email');
        $this->session->unset_userdata('department');
        session_destroy();

        redirect('welcome');
	}

    public function adding_new_card() {
        $data['company_id'] = $this->input->post('company_id');
        $data['user_id'] = $this->input->post('user_id');
        $data['card_no'] = $this->input->post('card_no');
        $data['vehicle_type_id'] = $this->input->post('vehicle_type_id');
        /*echo '<pre>';
        print_r($data);
        die();*/
        $inserted = $this->access_model->insertingData('tb_vehicle_cards', $data);

        $data['message']='Successfully Added New Card No. - '.$data['card_no'];
        $this->session->set_userdata($data);
        redirect('access/new_card');

    }

    public function adding_new_company() {
        $data['company_name'] = $this->input->post('company_name');
        /*echo '<pre>';
        print_r($data);
        die();*/
        $inserted = $this->access_model->insertingData('tb_company', $data);

        $data['message']='Successfully Added New Company - '.$data['company_name'];
        $this->session->set_userdata($data);
		redirect('access/add_new_company');

    }


    public function report() {
        $data['title'] = 'Report';
		$get_data['companies'] = $this->access_model->getAllCompanies();
		$get_data['years'] = $this->access_model->getYearsFromExsistingData();
        $data['maincontent'] = $this->load->view('report', $get_data, true);
        $this->load->view('master', $data);
    }


    public function getInOutCostReport() {

        $month = $this->input->post('month');
        $year = $this->input->post('year');
		$company = $this->input->post('company');

        $mon_yr = date('Y-m', strtotime($year.'-'.$month));

        $get_data_3 = $this->access_model->getVehicleInOutReportData($mon_yr, $company);

        $sl=1;
        $new_line = '';
        $total_cost = 0;
        foreach ($get_data_3 as $v_3){

            $concat_ids .= $v_3['ids'].',';

            $diff = strtotime($v_3['out_date_time'])-strtotime($v_3['in_date_time']);
			$staying_time = round(((round(abs($diff) / 60,2))/60), 0);

			if($staying_time < 10){
				$s_time = "0".$staying_time;
			}else{
				$s_time = $staying_time;
			}
			$formating_staying_time = $s_time.':'."00".':'."00";

//            echo $v_3['vehicle_type_id'];
            $get_data_4 = $this->access_model->getVehicleCostData($formating_staying_time, $v_3['vehicle_type_id']);
            $cost = $get_data_4[0]['cost'];
            $total_cost += $cost;

            $new_line .= '<tr>';

            $new_line .= '<td>' . $sl .'</td>';
            $new_line .= '<td>' . $v_3['user_id'] . '</td>';
            $new_line .= '<td>' . $v_3['user_name'] . '</td>';
            $new_line .= '<td>' . $v_3['fp_card_no'] . '</td>';
            $new_line .= '<td>' . $v_3['in_date'] . '</td>';
            $new_line .= '<td>' . $v_3['in_time'] . '</td>';
            $new_line .= '<td>' . $v_3['out_date'] . '</td>';
            $new_line .= '<td>' . $v_3['out_time'] . '</td>';
            $new_line .= '<td>' . $s_time ." Hours". '</td>';
            $new_line .= '<td>' . $v_3['vehicle_type'] . '</td>';
            $new_line .= '<td>' . $cost . '</td>';

            $new_line .= '</tr>';


            $sl++;
        }
		$new_line .= '<tr>';
			$new_line .= '<td colspan="10" align="right"><h4><b>Total</b></h4></td>';
			$new_line .= '<td align="left"><h4>' . number_format($total_cost, 2, '.', '') . '</h4></td>';
		$new_line .= '</tr>';

        $all_ids = substr("$concat_ids", 0, -1);
        echo $new_line.'<input type="hidden" class="form-control" name="ids" id="ids" value="'. $all_ids .'" required />';
    }

    public function process() {
        $data['title'] = 'Process';
	    $get_data['years'] = $this->access_model->getYearsFromExsistingData();
        $data['maincontent'] = $this->load->view('process', $get_data, true);
        $this->load->view('master', $data);
    }

    public function ProcessAndGetInOutData() {

        $month = $this->input->post('month');
        $year = $this->input->post('year');

        $mon_yr = date('Y-m', strtotime($year.'-'.$month));

        $get_data = $this->access_model->ProcessInOutData($mon_yr);

        foreach ($get_data as $v){
             $user_id = $v['user_id'];
//            $user_id = 100;

//            $where = '';
//            if($user_id != ''){
////                echo $user_id;
//                $where = " and user_id=$user_id";
//            }
             if($user_id != ''){
//                echo $user_id;
                $get_data_2 = $this->access_model->getInOutDataToProcess($user_id, $mon_yr);

                foreach ($get_data_2 as $v_1=>$key){

                    if(($v_1 % 2) == 0){
                        $up_data['flag'] = 1; //1 = IN
                        $id = $key['id'];
//                        echo $id.' '.$user_id.' '.$up_data['flag'] .' ';
                    }else{
//						$id = $get_data_2['id'];
                        $up_data['flag'] = 2; //2 = Out
                        $id = $key['id'];
//                      echo $id.' '.$user_id.' '.$up_data['flag'] .' ';
                    }
                    $updated = $this->access_model->updateTbl('tb_vehicle_in_out_info', $id, $up_data);
                 }
             }
        }


        $get_data_3 = $this->access_model->getVehicleInOutData($mon_yr);
        $get_data_3;
        $sl=1;
        $new_line = '';

        foreach ($get_data_3 as $v_3){
            $concat_ids .= $v_3['ids'].',';

            $diff = strtotime($v_3['out_date_time'])-strtotime($v_3['in_date_time']);
			$staying_time = round(((round(abs($diff) / 60,2))/60), 0);
			if($staying_time < 10){
				$s_time = "0".$staying_time;
			}else{
				$s_time = $staying_time;
			}
			$formating_staying_time = $s_time.':'."00".':'."00";


//            echo $v_3['vehicle_type_id'];
            $get_data_4 = $this->access_model->getVehicleCostData($formating_staying_time, $v_3['vehicle_type_id']);
            $cost = $get_data_4[0]['cost'];

            $new_line .= '<tr>';

            $new_line .= '<td>' . $sl .'</td>';
            $new_line .= '<td>' . $v_3['user_id'] . '</td>';
            $new_line .= '<td>' . $v_3['user_name'] . '</td>';
            $new_line .= '<td>' . $v_3['fp_card_no'] . '</td>';
            $new_line .= '<td>' . $v_3['in_date'] . '</td>';
            $new_line .= '<td>' . $v_3['in_time'] . '</td>';
            $new_line .= '<td>' . $v_3['out_date'] . '</td>';
            $new_line .= '<td>' . $v_3['out_time'] . '</td>';
            $new_line .= '<td>' . $s_time. " Hours" . '</td>';
            $new_line .= '<td>' . $v_3['vehicle_type'] . '</td>';
            $new_line .= '<td>' . $cost . '</td>';

            $new_line .= '</tr>';
            $sl++;
        }
        $all_ids = substr("$concat_ids", 0, -1);
        echo $new_line.'<input type="hidden" class="form-control" name="ids" id="ids" value="'. $all_ids .'" required />';
    }

    public function finalProcessDone() {
        $ids = $this->input->post('ids');
        $flag = $this->input->post('process_stage');

        $updated = $this->access_model->updateFinalProcessFlag($ids, $flag);
    }


    public function upload_in_file() {
        $data['title'] = 'Upload In File';
        $data['maincontent'] = $this->load->view('upload_in_file', '', true);
        $this->load->view('master', $data);
    }

    public function upload_in_out_file() {
        $data['title'] = 'Upload File';
        $data['maincontent'] = $this->load->view('upload_in_out_file', '', true);
        $this->load->view('master', $data);
    }

    public function upload_out_file() {
        $data['title'] = 'Upload Out File';
        $data['maincontent'] = $this->load->view('upload_out_file', '', true);
        $this->load->view('master', $data);
    }

    public function uploading_in_file() {
        $file_location = $_FILES['in_file']['tmp_name'];

        $file = fopen($file_location, "r");

        $lines       = file($file_location);              //file in to an array
        $second_line = explode(',', $lines[1]);     //$lines[1]->.csv second row.[0]->first row.
        $target_id   = $second_line[0];               //target id = .csv id column; $second_line[0] = .csv-> first column of second row

        $file_heading = fgetcsv($file);

        $user_id_index = array_search('user_id', $file_heading);
        $user_name_index            = array_search('user_name', $file_heading);
        $fp_card_no_index           = array_search('fp_card_no', $file_heading);
        $date_index           = array_search('date', $file_heading);
        $day_index          = array_search('day', $file_heading);
        $slave_ip_index        = array_search('slave_ip', $file_heading);
        $time_index        = array_search('time', $file_heading);
        $flag_index        = array_search('flag', $file_heading);

        while( !feof($file)){
            $row_data = fgetcsv($file);

            if($row_data){
                        $list = array(
                            'user_id' => $row_data[$user_id_index],
                            'user_name' => $row_data[$user_name_index],
                            'fp_card_no' => $row_data[$fp_card_no_index],
                            'date' => $row_data[$date_index],
                            'day' => $row_data[$day_index],
                            'slave_ip' => $row_data[$slave_ip_index],
                            'time' => $row_data[$time_index],
                            'flag' => 1
                    );
//                    echo '<pre>';
//                    print_r($list);
//                    die();
                    $this->access_model->insert_tbl('tb_vehicle_in_out_info', $list);

            }
        }
        fclose($file);

    }

    public function uploading_out_file() {
        $file_location = $_FILES['out_file']['tmp_name'];

        $file = fopen($file_location, "r");

        $lines       = file($file_location);              //file in to an array
        $second_line = explode(',', $lines[1]);     //$lines[1]->.csv second row.[0]->first row.
        $target_id   = $second_line[0];               //target id = .csv id column; $second_line[0] = .csv-> first column of second row

        $file_heading = fgetcsv($file);

        $user_id_index = array_search('user_id', $file_heading);
        $user_name_index            = array_search('user_name', $file_heading);
        $fp_card_no_index           = array_search('fp_card_no', $file_heading);
        $date_index           = array_search('date', $file_heading);
        $day_index          = array_search('day', $file_heading);
        $slave_ip_index        = array_search('slave_ip', $file_heading);
        $time_index        = array_search('time', $file_heading);
        $flag_index        = array_search('flag', $file_heading);

        while( !feof($file)){
            $row_data = fgetcsv($file);

            if($row_data){
                        $list = array(
                            'user_id' => $row_data[$user_id_index],
                            'user_name' => $row_data[$user_name_index],
                            'fp_card_no' => $row_data[$fp_card_no_index],
                            'date' => $row_data[$date_index],
                            'day' => $row_data[$day_index],
                            'slave_ip' => $row_data[$slave_ip_index],
                            'time' => $row_data[$time_index],
                            'flag' => 2
                    );
//                    echo '<pre>';
//                    print_r($list);
//                    die();
                    $this->access_model->insert_tbl('tb_vehicle_in_out_info', $list);

            }
        }
        fclose($file);
    }


     public function uploading_exl_out_file() {

		 if (isset($_FILES['out_file']))
		 {

		 move_uploaded_file($_FILES["out_file"]["tmp_name"], "assets/uploaded_exl/" . $_FILES["out_file"]["name"]);
		 $n = "assets/uploaded_exl/" . $_FILES["out_file"]["name"];

			//load the excel library
            //$this->load->library('reader');

			require_once APPPATH."/third_party/Classes/reader.php";

			//require_once(base_url().'libraries/reader.php');

			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('CP1251');
			$data->read("$n");

			error_reporting(E_ALL ^ E_NOTICE);

				for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++)
				{
				$check = $data->sheets[0]['cells'][$i][2];
				  if ($check != '')
				  {

					$out_data['user_id']=$data->sheets[0]['cells'][$i][2];  // UserID
					$out_data['user_name']=$data->sheets[0]['cells'][$i][3]; // UserName
					$out_data['fp_card_no']=$data->sheets[0]['cells'][$i][5]; //FP/Card No
					$out_data['date']=date('Y-m-d', strtotime($data->sheets[0]['cells'][$i][6])); //Date
					$out_data['day']=$data->sheets[0]['cells'][$i][7];  // Day
					$out_data['slave_ip']=$data->sheets[0]['cells'][$i][9]; //Location
					$out_data['time']=$data->sheets[0]['cells'][$i][8]; // Time
					$out_data['flag']='2'; // Flag Value: 2 = Out Data

					$this->access_model->insertingData('tb_vehicle_in_out_info', $out_data);

				  }
				}
                            $session_data['message']='Successfully "Vehicle-OUT" Data Uploaded';
                            $this->session->set_userdata($session_data);

                            redirect('access/upload_out_file');
			 }
     }

     public function uploading_exl_file() {
//         $d = array(100, 200, 400, 500);
//         foreach ($d as $v=>$key){
//             echo $key.' ';
//             if($v % 2 == 0){
//                 echo 1 .' ';
//             }else{
//                 echo 2 .' ';
//             }
//         }
//         die();
		 if (isset($_FILES['file']))
		 {

		 move_uploaded_file($_FILES["file"]["tmp_name"], "assets/uploaded_exl/" . $_FILES["file"]["name"]);
		 $n = "assets/uploaded_exl/" . $_FILES["file"]["name"];

			//load the excel library
            //$this->load->library('reader');

			require_once APPPATH."/third_party/Classes/reader.php";

			//require_once(base_url().'libraries/reader.php');

			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('CP1251');
			$data->read("$n");

			error_reporting(E_ALL ^ E_NOTICE);

				for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++)
				{
				$check = $data->sheets[0]['cells'][$i][2];
				  if ($check != '')
				  {
					$fp_card_no=$data->sheets[0]['cells'][$i][5];
					$isCardCreated = $this->access_model->isCardNumberCreated($fp_card_no);

					if(!$isCardCreated)
					{
						$cdata['not_created_cards']="Sorry, Uploading Failed.".' '.$fp_card_no.' '."is not created yet!";
                   		$this->session->set_userdata($cdata);
					}
					if($isCardCreated){
						$v_data['user_id']=$data->sheets[0]['cells'][$i][2];  // UserID
						$v_data['user_name']=$data->sheets[0]['cells'][$i][3]; // UserName
						$v_data['fp_card_no']=$data->sheets[0]['cells'][$i][5]; // FP Card No
						$v_data['date']=date('Y-m-d', strtotime($data->sheets[0]['cells'][$i][6])); //Date
						$v_data['day']=$data->sheets[0]['cells'][$i][7];  // Day
						$v_data['slave_ip']=$data->sheets[0]['cells'][$i][9]; //Location
						$v_data['time']=date("H:i:s", strtotime($data->sheets[0]['cells'][$i][8])); // Time
						$v_data['date_time_str']=strtotime($v_data['date'].' '.$v_data['time']); // Time Converting to String

					// checking data availability...

					$checkDuplicatedEntry = $this->access_model->isShortTimeDuplicatedEntry($v_data['user_id']);

					$difference_dup_time = $v_data['date_time_str'] - $checkDuplicatedEntry[0]['date_time_str'];
					$range_of_next_entry = 300; // Seconds
					if($difference_dup_time > $range_of_next_entry){
					$is_available = $this->access_model->isDataAlreadyAvailable($v_data['user_id'], $v_data['fp_card_no'], $v_data['date'], $v_data['time']);

						if(!$is_available){
							$this->access_model->insertingData('tb_vehicle_in_out_info', $v_data);
						}
                                        }
					}

				  }
				}
                            $session_data['message']='Successfully Data Uploaded';
                            $this->session->set_userdata($session_data);

                            redirect('access/upload_in_out_file');
			 }
     }

     public function uploading_exl_in_file() {

		 if (isset($_FILES['in_file']))
		 {

		 move_uploaded_file($_FILES["in_file"]["tmp_name"], "assets/uploaded_exl/" . $_FILES["in_file"]["name"]);
		 $n = "assets/uploaded_exl/" . $_FILES["in_file"]["name"];

			//load the excel library
            //$this->load->library('reader');

			require_once APPPATH."/third_party/Classes/reader.php";

			//require_once(base_url().'libraries/reader.php');

			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('CP1251');
			$data->read("$n");

			error_reporting(E_ALL ^ E_NOTICE);

				for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++)
				{
				$check = $data->sheets[0]['cells'][$i][2];
				  if ($check != '')
				  {

					$out_data['user_id']=$data->sheets[0]['cells'][$i][2];  // UserID
					$out_data['user_name']=$data->sheets[0]['cells'][$i][3]; // UserName
					$out_data['fp_card_no']=$data->sheets[0]['cells'][$i][5]; //FP/Card No
					$out_data['date']=date('Y-m-d', strtotime($data->sheets[0]['cells'][$i][6])); //Date
					$out_data['day']=$data->sheets[0]['cells'][$i][7];  // Day
					$out_data['slave_ip']=$data->sheets[0]['cells'][$i][9]; //Location
					$out_data['time']=$data->sheets[0]['cells'][$i][8]; // Time
					$out_data['flag']='1'; // Flag Value: 2 = Out Data

					$this->access_model->insertingData('tb_vehicle_in_out_info', $out_data);


				  }
				}
                                $session_data['message']='Successfully "Vehicle-IN" Data Uploaded';
                                $this->session->set_userdata($session_data);

                                redirect('access/upload_in_file');
			 }
     }


//    public function uploading_out_file() {
//        $file = $_FILES['out_file']['tmp_name'];
//
//            //load the excel library
//            $this->load->library('excel');
//
//            //read file from path
//            $objPHPExcel = PHPExcel_IOFactory::load($file);
//
//            //get only the Cell Collection
//            $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
//
//            //extract to a PHP readable array format
//            $data = array();
//            foreach ($cell_collection as $cell) {
//                $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
//                $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
//                $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
//
//                //header will/should be in row 1 only. of course this can be modified to suit your need.
//                if ($row == 1) {
//                    $header[$row][$column] = $data_value;
//                } else {
//                    $arr_data[$row][$column] = $data_value;
//                    array_push($data,$arr_data[$row][$column]);
//                    if($column == 'H'){
//                        $col = 8;
//                    }
//                    if($column == 'G'){
//                        $col = 7;
//                    }
//                    if($column == 'F'){
//                        $col = 6;
//                    }
//                    if($column == 'E'){
//                        $col = 5;
//                    }
//                    if($column == 'D'){
//                        $col = 4;
//                    }
//                    if($column == 'C'){
//                        $col = 3;
//                    }
//                    if($column == 'B'){
//                        $col = 2;
//                    }
//                    if($column == 'A'){
//                        $col = 1;
//                    }
//
////                    for ($row = 1; $row <= (count($data)/8); $row++) {
////
////                    }
//
//
//
//                }
//
////                $is_excel_data_inserted = $this->access_model->insert_tbl('tb_vehicle_in_out_info', $arr_data[$row][$column]);
//                }
//
//
//                $total_row = count($data)/$col;
//
//                foreach ($data as $v=>$key){
//                echo '<pre>';
//                print_r($data);
//                die();
//
//                    $s_data = array(
//                            'user_id' => $v,
//                            'user_name' => $v,
//                            'fp_card_no' => $v,
//                            'date' => $v,
//                            'day' => $v,
//                            'slave_ip' => $v,
//                            'time' => $v,
//                            'flag' => 2
//                        );
//                    echo '<pre>';
//                    print_r($s_data);
////                    if((($v+1)/8) != 0){
////                        echo 'true';
////                        die();
//
//
//
////                        $is_excel_data_inserted = $this->access_model->insert_tbl('tb_vehicle_in_out_info', $s_data);
//
////                    }
//                }
//
////            send the data in an array format
////            $data['header'] = $header;
////            $data['values'] = $arr_data;
//    }


//  Manual Closing Start


    public function getWashInfo(){
        $po_no=$this->input->post('po_no');
        $purchase_no=$this->input->post('purchese_no');
        $item_no=$this->input->post('item_no');
        $quality=$this->input->post('quality');
        $color=$this->input->post('color');

        $where = '';

        if($po_no != ''){
            $where .= " AND po_no like '%$po_no%'";
        }

        if($purchase_no != ''){
            $where .= " AND purchase_order like '%$purchase_no%'";
        }

        if($item_no != ''){
            $where .= " AND item like '%$item_no%'";
        }

        if($quality != ''){
            $where .= " AND quality like '%$quality%'";
        }

        if($color != ''){
            $where .= " AND color like '%$color%'";
        }

        $res = $this->access_model->getWashInfo($where);

        echo json_encode($res);

    }

    public function getWashAndShipDate(){
        $so_no=$this->input->post('so_no');
        $where = '';

        if($so_no != ''){
            $where .= " AND so_no = '$so_no'";
        }

        $res = $this->access_model->getWashInfo($where);
        echo json_encode($res);

    }

    public function po_in_carton_and_wash_gmt()
    {
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $ex_fac_date = $this->input->post('ex_fac_date');
        $data['warehouse_qa_type']=$this->input->post('destination_id');


        $data['carton_status']="1";
        $data['is_going_wash']="1";
        $data['going_wash_scan_date_time']="$ex_fac_date";
        $data['wash_going_printed']="1";
        $data['wash_going_print_date_time']="$ex_fac_date";
        $data['washing_status']="1";
        $data['washing_date_time']="$ex_fac_date";

        $data['access_points']="4";
        $data['access_points_status']="4";
        $data['end_line_qc_date_time']="$ex_fac_date";
        $data['other_purpose_remarks']="Manually Closed";
        $data['other_purpose_liable_person']="Administrator";
        $data['carton_date_time']="$ex_fac_date";
        $data['manually_closed']="1";
//        $new_line .= '<td class="center">'.$size.'</td>';
        $data['sent_to_production']="1";
        $data['sent_to_production_date_time']="$ex_fac_date";
        $data['is_printed']="1";
        $data['printing_date_time']="$ex_fac_date";
        $data['line_input_date_time']="$ex_fac_date";
        $data['mid_line_qc_date_time']="$ex_fac_date";
        $data['packing_status']="1";
        $data['packing_date_time']="$ex_fac_date";
        $data['lost_date_time']="$date";

        $po_ids=$this->input->post('po_ids');
        $lost_points=$this->input->post('lost_points');
        $line_ids=$this->input->post('line_ids');

        foreach ($po_ids as $k => $p_id){

            if($line_ids[$k]==0){
                $data['line_id']="100";
            }else{
                $data['line_id']=$line_ids[$k];
            }


            if ($lost_points[$k] != ''){
                $data['other_purpose_remarks'] = "Manually Closed - $lost_points[$k]";
            }

            $po_info = $this->access_model->manualClosedById($p_id);
            $this->access_model->update_care_labels($data, $p_id);
        }


        echo 'done';
    }
    public function po_in_carton_and_non_wash_gmt()
    {
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $ex_fac_date = $this->input->post('ex_fac_date');
        $data['carton_status']="1";
        $data['warehouse_qa_type']=$this->input->post('destination_id');
        $data['sent_to_production']="1";
        $data['sent_to_production_date_time']="$ex_fac_date";
        $data['is_printed']="1";
        $data['printing_date_time']="$ex_fac_date";

        $data['access_points']="4";
        $data['access_points_status']="4";
        $data['end_line_qc_date_time']="$ex_fac_date";
        $data['other_purpose_remarks']="Manually Closed";
        $data['other_purpose_liable_person']="Administrator";
        $data['carton_date_time']="$ex_fac_date";
        $data['manually_closed']="1";

        $data['line_input_date_time']="$ex_fac_date";
        $data['lost_date_time']="$date";
        $data['mid_line_qc_date_time']="$ex_fac_date";
        $data['packing_status']="1";
        $data['packing_date_time']="$ex_fac_date";
        $po_ids=$this->input->post('po_ids');
        $lost_points=$this->input->post('lost_points');
        $line_ids=$this->input->post('line_ids');

        foreach ($po_ids as $k => $p_id){

            if($line_ids[$k]==0){
                $data['line_id']="100";
            }else{
                $data['line_id']=$line_ids[$k];
            }

            if ($lost_points[$k] != ''){
                $data['other_purpose_remarks'] = "Manually Closed - $lost_points[$k]";
            }

            $po_info = $this->access_model->manualClosedById($p_id);
            $this->access_model->update_care_labels($data, $p_id);
        }


        echo 'done';
    }


    public function po_in_non_carton_and_wash_gmt()
    {
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['warehouse_qa_type']=$this->input->post('destination_id');
//        $date = $this->input->post('ex_fac_date');
        $data['is_going_wash']="1";
        $data['going_wash_scan_date_time']=$date;
        $data['wash_going_printed']="1";
        $data['wash_going_print_date_time']=$date;
        $data['washing_status']="1";
        $data['washing_date_time']=$date;
        $data['line_id']="100";
        $data['access_points']="4";
        $data['access_points_status']="4";
        $data['end_line_qc_date_time']=$date;
        $data['other_purpose_remarks']="Manually Closed";
        $data['other_purpose_liable_person']="Administrator";
        $data['lost_date_time']="$date";
        $data['manually_closed']="1";

        $data['sent_to_production']="1";
        $data['sent_to_production_date_time']="$date";
        $data['is_printed']="1";
        $data['printing_date_time']="$date";
        $data['line_input_date_time']="$date";
        $data['mid_line_qc_date_time']="$date";
        $data['packing_status']="1";
        $data['packing_date_time']="$date";
        $po_ids=$this->input->post('po_ids');
        $lost_points=$this->input->post('lost_points');

        foreach ($po_ids as $k => $p_id){

            if ($lost_points[$k] != ''){
                $data['other_purpose_remarks'] = "Manually Closed - $lost_points[$k]";
            }

            $po_info = $this->access_model->manualClosedById($p_id);
            $this->access_model->update_care_labels($data, $p_id);
        }


        echo 'done';
    }

    public function po_in_non_carton_and_non_wash_gmt()
    {
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['warehouse_qa_type']=$this->input->post('destination_id');
//        $date = $this->input->post('ex_fac_date');
        $data['sent_to_production']="1";
        $data['sent_to_production_date_time']=$date;
        $data['is_printed']="1";
        $data['printing_date_time']=$date;
        $data['line_id']="100";
        $data['access_points']="4";
        $data['access_points_status']="4";
        $data['end_line_qc_date_time']=$date;
        $data['other_purpose_remarks']="Manually Closed";
        $data['other_purpose_liable_person']="Administrator";
        $data['lost_date_time']="$date";
        $data['manually_closed']="1";

        $data['line_input_date_time']="$date";
        $data['mid_line_qc_date_time']="$date";
        $data['packing_status']="1";
        $data['packing_date_time']="$date";
        $po_ids=$this->input->post('po_ids');
        $lost_points=$this->input->post('lost_points');

        foreach ($po_ids as $k => $p_id){

            if ($lost_points[$k] != ''){
                $data['other_purpose_remarks'] = "Manually Closed - $lost_points[$k]";
            }

            $po_info = $this->access_model->manualClosedById($p_id);
            $this->access_model->update_care_labels($data, $p_id);
        }


        echo 'done';
    }
    public function po_in_warehouse_buyer_and_wash_gmt()
    {
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['warehouse_qa_type']=$this->input->post('destination_id');
        $ex_fac_date = $this->input->post('ex_fac_date');

        $data['is_going_wash']="1";
        $data['going_wash_scan_date_time']="$ex_fac_date";
        $data['wash_going_printed']="1";
        $data['wash_going_print_date_time']="$ex_fac_date";
        $data['washing_status']="1";
        $data['washing_date_time']="$ex_fac_date";

        $data['access_points']="4";
        $data['access_points_status']="4";
        $data['end_line_qc_date_time']="$ex_fac_date";
        $data['warehouse_buyer_date_time']="$ex_fac_date";
        $data['other_purpose_remarks']="Manually Closed";
        $data['other_purpose_liable_person']="Administrator";
        $data['manually_closed']="1";

        $data['sent_to_production']="1";
        $data['sent_to_production_date_time']="$ex_fac_date";
        $data['is_printed']="1";
        $data['printing_date_time']="$ex_fac_date";
        $data['line_input_date_time']="$ex_fac_date";
        $data['mid_line_qc_date_time']="$ex_fac_date";
        $data['packing_status']="1";
        $data['packing_date_time']="$ex_fac_date";
        $data['lost_date_time']="$date";
        $po_ids=$this->input->post('po_ids');
        $lost_points=$this->input->post('lost_points');
        $line_ids=$this->input->post('line_ids');

        foreach ($po_ids as $k => $p_id){

            if($line_ids[$k]==0){
                $data['line_id']="100";
            }else{
                $data['line_id']=$line_ids[$k];
            }

            if ($lost_points[$k] != ''){
                $data['other_purpose_remarks'] = "Manually Closed - $lost_points[$k]";
            }

            $po_info = $this->access_model->manualClosedById($p_id);
            $this->access_model->update_care_labels($data, $p_id);
        }


        echo 'done';
    }
    public function po_in_warehouse_buyer_and_non_wash_gmt()
    {
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['warehouse_qa_type']=$this->input->post('destination_id');
        $ex_fac_date = $this->input->post('ex_fac_date');

        $data['sent_to_production']="1";
        $data['sent_to_production_date_time']="$ex_fac_date";
        $data['is_printed']="1";
        $data['printing_date_time']="$ex_fac_date";

        $data['access_points']="4";
        $data['access_points_status']="4";
        $data['end_line_qc_date_time']="$ex_fac_date";
        $data['warehouse_buyer_date_time']="$ex_fac_date";
        $data['other_purpose_remarks']="Manually Closed";
        $data['other_purpose_liable_person']="Administrator";
        $data['manually_closed']="1";

        $data['line_input_date_time']="$ex_fac_date";
        $data['mid_line_qc_date_time']="$ex_fac_date";
        $data['lost_date_time']="$date";
        $data['packing_status']="1";
        $data['packing_date_time']="$ex_fac_date";
        $po_ids=$this->input->post('po_ids');
        $lost_points=$this->input->post('lost_points');
        $line_ids=$this->input->post('line_ids');

        foreach ($po_ids as $k => $p_id){
            if($line_ids[$k]==0){
                $data['line_id']="100";
            }else{
                $data['line_id']=$line_ids[$k];
            }

            if ($lost_points[$k] != ''){
                $data['other_purpose_remarks'] = "Manually Closed - $lost_points[$k]";
            }

            $po_info = $this->access_model->manualClosedById($p_id);
            $this->access_model->update_care_labels($data, $p_id);
        }


        echo 'done';
    }
    public function po_in_warehouse_factory_and_non_wash_gmt()
    {
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['warehouse_qa_type']=$this->input->post('destination_id');
        $ex_fac_date = $this->input->post('ex_fac_date');

        $data['sent_to_production']="1";
        $data['sent_to_production_date_time']="$ex_fac_date";
        $data['is_printed']="1";
        $data['printing_date_time']="$ex_fac_date";

        $data['access_points']="4";
        $data['access_points_status']="4";
        $data['end_line_qc_date_time']="$ex_fac_date";
        $data['warehouse_factory_date_time']="$ex_fac_date";
        $data['other_purpose_remarks']="Manually Closed";
        $data['other_purpose_liable_person']="Administrator";
        $data['manually_closed']="1";

        $data['line_input_date_time']="$ex_fac_date";
        $data['mid_line_qc_date_time']="$ex_fac_date";
        $data['lost_date_time']="$date";
        $data['packing_status']="1";
        $data['packing_date_time']="$ex_fac_date";
        $po_ids=$this->input->post('po_ids');
        $lost_points=$this->input->post('lost_points');
        $line_ids=$this->input->post('line_ids');

        foreach ($po_ids as $k => $p_id){
            if($line_ids[$k]==0){
                $data['line_id']="100";
            }else{
                $data['line_id']=$line_ids[$k];
            }

            if ($lost_points[$k] != ''){
                $data['other_purpose_remarks'] = "Manually Closed - $lost_points[$k]";
            }

            $po_info = $this->access_model->manualClosedById($p_id);
            $this->access_model->update_care_labels($data, $p_id);
        }


        echo 'done';
    }
    public function po_in_warehouse_trash_and_non_wash_gmt()
    {
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['warehouse_qa_type']=$this->input->post('destination_id');
        $ex_fac_date = $this->input->post('ex_fac_date');

        $data['sent_to_production']="1";
        $data['sent_to_production_date_time']="$ex_fac_date";
        $data['is_printed']="1";
        $data['printing_date_time']="$ex_fac_date";

        $data['access_points']="4";
        $data['access_points_status']="4";
        $data['end_line_qc_date_time']="$ex_fac_date";
        $data['warehouse_trash_date_time']="$ex_fac_date";
        $data['other_purpose_remarks']="Manually Closed";
        $data['other_purpose_liable_person']="Administrator";
        $data['manually_closed']="1";

        $data['line_input_date_time']="$ex_fac_date";
        $data['mid_line_qc_date_time']="$ex_fac_date";
        $data['lost_date_time']="$date";
        $data['packing_status']="1";
        $data['packing_date_time']="$ex_fac_date";
        $po_ids=$this->input->post('po_ids');
        $lost_points=$this->input->post('lost_points');
        $line_ids=$this->input->post('line_ids');

        foreach ($po_ids as $k => $p_id){
            if($line_ids[$k]==0){
                $data['line_id']="100";
            }else{
                $data['line_id']=$line_ids[$k];
            }

            if ($lost_points[$k] != ''){
                $data['other_purpose_remarks'] = "Manually Closed - $lost_points[$k]";
            }

            $po_info = $this->access_model->manualClosedById($p_id);
            $this->access_model->update_care_labels($data, $p_id);
        }


        echo 'done';
    }
    public function po_in_warehouse_production_and_non_wash_gmt()
    {
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['warehouse_qa_type']=$this->input->post('destination_id');
        $ex_fac_date = $this->input->post('ex_fac_date');

        $data['sent_to_production']="1";
        $data['sent_to_production_date_time']="$ex_fac_date";
        $data['is_printed']="1";
        $data['printing_date_time']="$ex_fac_date";

        $data['access_points']="4";
        $data['access_points_status']="4";
        $data['end_line_qc_date_time']="$ex_fac_date";
        $data['warehouse_production_sample_date_time']="$ex_fac_date";
        $data['other_purpose_remarks']="Manually Closed";
        $data['other_purpose_liable_person']="Administrator";
        $data['manually_closed']="1";

        $data['line_input_date_time']="$ex_fac_date";
        $data['mid_line_qc_date_time']="$ex_fac_date";
        $data['lost_date_time']="$date";
        $data['packing_status']="1";
        $data['packing_date_time']="$ex_fac_date";
        $po_ids=$this->input->post('po_ids');
        $lost_points=$this->input->post('lost_points');
        $line_ids=$this->input->post('line_ids');

        foreach ($po_ids as $k => $p_id){
            if($line_ids[$k]==0){
                $data['line_id']="100";
            }else{
                $data['line_id']=$line_ids[$k];
            }

            if ($lost_points[$k] != ''){
                $data['other_purpose_remarks'] = "Manually Closed - $lost_points[$k]";
            }

            $po_info = $this->access_model->manualClosedById($p_id);
            $this->access_model->update_care_labels($data, $p_id);
        }


        echo 'done';
    }
    public function po_in_warehouse_other_and_non_wash_gmt()
    {
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['warehouse_qa_type']=$this->input->post('destination_id');
        $ex_fac_date = $this->input->post('ex_fac_date');

        $data['sent_to_production']="1";
        $data['sent_to_production_date_time']="$ex_fac_date";
        $data['is_printed']="1";
        $data['printing_date_time']="$ex_fac_date";

        $data['access_points']="4";
        $data['access_points_status']="4";
        $data['end_line_qc_date_time']="$ex_fac_date";
        $data['warehouse_other_purpose_date_time']="$ex_fac_date";
        $data['other_purpose_remarks']="Manually Closed";
        $data['other_purpose_liable_person']="Administrator";
        $data['manually_closed']="1";


        $data['line_input_date_time']="$ex_fac_date";
        $data['mid_line_qc_date_time']="$ex_fac_date";
        $data['lost_date_time']="$date";
        $data['packing_status']="1";
        $data['packing_date_time']="$ex_fac_date";
        $po_ids=$this->input->post('po_ids');
        $lost_points=$this->input->post('lost_points');
        $line_ids=$this->input->post('line_ids');

        foreach ($po_ids as $k => $p_id){

            if($line_ids[$k]==0){
                $data['line_id']="100";
            }else{
                $data['line_id']=$line_ids[$k];
            }

            if ($lost_points[$k] != ''){
                $data['other_purpose_remarks'] = "Manually Closed - $lost_points[$k]";
            }

            $po_info = $this->access_model->manualClosedById($p_id);
            $this->access_model->update_care_labels($data, $p_id);
        }


        echo 'done';
    }
    public function po_in_size_set_and_non_wash_gmt()
    {
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['warehouse_qa_type']=$this->input->post('destination_id');
        $ex_fac_date = $this->input->post('ex_fac_date');

        $data['sent_to_production']="1";
        $data['sent_to_production_date_time']="$ex_fac_date";
        $data['is_printed']="1";
        $data['printing_date_time']="$ex_fac_date";

        $data['access_points']="4";
        $data['access_points_status']="4";
        $data['end_line_qc_date_time']="$ex_fac_date";
        $data['other_purpose_remarks']="Manually Closed";
        $data['other_purpose_liable_person']="Administrator";
        $data['lost_date_time']="$date";
        $data['manually_closed']="1";

        $data['line_input_date_time']="$ex_fac_date";
        $data['mid_line_qc_date_time']="$ex_fac_date";
        $data['packing_status']="1";
        $data['packing_date_time']="$ex_fac_date";
        $po_ids=$this->input->post('po_ids');
        $lost_points=$this->input->post('lost_points');
        $line_ids=$this->input->post('line_ids');

        foreach ($po_ids as $k => $p_id){
            if($line_ids[$k]==0){
                $data['line_id']="100";
            }else{
                $data['line_id']=$line_ids[$k];
            }

            if ($lost_points[$k] != ''){
                $data['other_purpose_remarks'] = "Manually Closed - $lost_points[$k]";
            }

            $po_info = $this->access_model->manualClosedById($p_id);
            $this->access_model->update_care_labels($data, $p_id);
        }


        echo 'done';
    }
    public function po_in_lost_and_non_wash_gmt()
    {
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['warehouse_qa_type']=$this->input->post('destination_id');
        $ex_fac_date = $this->input->post('ex_fac_date');

        $data['sent_to_production']="1";
        $data['sent_to_production_date_time']="$ex_fac_date";
        $data['is_printed']="1";
        $data['printing_date_time']="$ex_fac_date";

        $data['access_points']="4";
        $data['access_points_status']="4";
        $data['end_line_qc_date_time']="$ex_fac_date";
        $data['other_purpose_remarks']="Manually Closed";
        $data['other_purpose_liable_person']="Administrator";
        $data['lost_date_time']="$date";
        $data['manually_closed']="1";

        $data['line_input_date_time']="$ex_fac_date";
        $data['mid_line_qc_date_time']="$ex_fac_date";
        $data['lost_date_time']="$date";
        $data['packing_status']="1";
        $data['packing_date_time']="$ex_fac_date";
        $po_ids=$this->input->post('po_ids');
        $lost_points=$this->input->post('lost_points');
        $line_ids=$this->input->post('line_ids');

        foreach ($po_ids as $k => $p_id){
            if($line_ids[$k]==0){
                $data['line_id']="100";
            }else{
                $data['line_id']=$line_ids[$k];
            }

            if ($lost_points[$k] != ''){
                $data['other_purpose_remarks'] = "Manually Closed - $lost_points[$k]";
            }

            $po_info = $this->access_model->manualClosedById($p_id);
            $this->access_model->update_care_labels($data, $p_id);
        }


        echo 'done';
    }
    public function po_in_warehouse_factory_and_wash_gmt()
    {
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['warehouse_qa_type']=$this->input->post('destination_id');
        $ex_fac_date = $this->input->post('ex_fac_date');

        $data['is_going_wash']="1";
        $data['going_wash_scan_date_time']="$ex_fac_date";
        $data['wash_going_printed']="1";
        $data['wash_going_print_date_time']="$ex_fac_date";
        $data['washing_status']="1";
        $data['washing_date_time']="$ex_fac_date";

        $data['access_points']="4";
        $data['access_points_status']="4";
        $data['end_line_qc_date_time']="$ex_fac_date";
        $data['warehouse_factory_date_time']="$ex_fac_date";
        $data['other_purpose_remarks']="Manually Closed";
        $data['other_purpose_liable_person']="Administrator";
        $data['manually_closed']="1";

        $data['sent_to_production']="1";
        $data['sent_to_production_date_time']="$ex_fac_date";
        $data['lost_date_time']="$date";
        $data['is_printed']="1";
        $data['printing_date_time']="$ex_fac_date";
        $data['line_input_date_time']="$ex_fac_date";
        $data['mid_line_qc_date_time']="$ex_fac_date";
        $data['packing_status']="1";
        $data['packing_date_time']="$ex_fac_date";
        $po_ids=$this->input->post('po_ids');
        $lost_points=$this->input->post('lost_points');
        $line_ids=$this->input->post('line_ids');

        foreach ($po_ids as $k => $p_id){
            if($line_ids[$k]==0){
                $data['line_id']="100";
            }else{
                $data['line_id']=$line_ids[$k];
            }

            if ($lost_points[$k] != ''){
                $data['other_purpose_remarks'] = "Manually Closed - $lost_points[$k]";
            }

            $po_info = $this->access_model->manualClosedById($p_id);
            $this->access_model->update_care_labels($data, $p_id);
        }


        echo 'done';
    }

    public function po_in_warehouse_trash_and_wash_gmt()
    {
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['warehouse_qa_type']=$this->input->post('destination_id');
        $ex_fac_date = $this->input->post('ex_fac_date');

        $data['is_going_wash']="1";
        $data['going_wash_scan_date_time']="$ex_fac_date";
        $data['wash_going_printed']="1";
        $data['wash_going_print_date_time']="$ex_fac_date";
        $data['washing_status']="1";
        $data['washing_date_time']="$ex_fac_date";

        $data['access_points']="4";
        $data['access_points_status']="4";
        $data['end_line_qc_date_time']="$ex_fac_date";
        $data['warehouse_trash_date_time']="$ex_fac_date";
        $data['other_purpose_remarks']="Manually Closed";
        $data['other_purpose_liable_person']="Administrator";
        $data['manually_closed']="1";

        $data['sent_to_production']="1";
        $data['sent_to_production_date_time']="$ex_fac_date";
        $data['is_printed']="1";
        $data['printing_date_time']="$ex_fac_date";
        $data['line_input_date_time']="$ex_fac_date";
        $data['mid_line_qc_date_time']="$ex_fac_date";
        $data['packing_status']="1";
        $data['packing_date_time']="$ex_fac_date";
        $data['lost_date_time']="$date";
        $po_ids=$this->input->post('po_ids');
        $lost_points=$this->input->post('lost_points');
        $line_ids=$this->input->post('line_ids');

        foreach ($po_ids as $k => $p_id){

            if($line_ids[$k]==0){
                $data['line_id']="100";
            }else{
                $data['line_id']=$line_ids[$k];
            }

            if ($lost_points[$k] != ''){
                $data['other_purpose_remarks'] = "Manually Closed - $lost_points[$k]";
            }

            $po_info = $this->access_model->manualClosedById($p_id);
            $this->access_model->update_care_labels($data, $p_id);
        }


        echo 'done';
    }
    public function po_in_warehouse_production_and_wash_gmt()
    {
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['warehouse_qa_type']=$this->input->post('destination_id');
        $ex_fac_date = $this->input->post('ex_fac_date');

        $data['is_going_wash']="1";
        $data['going_wash_scan_date_time']="$ex_fac_date";
        $data['wash_going_printed']="1";
        $data['wash_going_print_date_time']="$ex_fac_date";
        $data['washing_status']="1";
        $data['washing_date_time']="$ex_fac_date";

        $data['access_points']="4";
        $data['access_points_status']="4";
        $data['end_line_qc_date_time']="$ex_fac_date";
        $data['warehouse_production_sample_date_time']="$ex_fac_date";
        $data['other_purpose_remarks']="Manually Closed";
        $data['other_purpose_liable_person']="Administrator";
        $data['manually_closed']="1";

        $data['sent_to_production']="1";
        $data['sent_to_production_date_time']="$ex_fac_date";
        $data['is_printed']="1";
        $data['printing_date_time']="$ex_fac_date";
        $data['line_input_date_time']="$ex_fac_date";
        $data['mid_line_qc_date_time']="$ex_fac_date";
        $data['packing_status']="1";
        $data['packing_date_time']="$ex_fac_date";
        $data['lost_date_time']="$date";
        $po_ids=$this->input->post('po_ids');
        $lost_points=$this->input->post('lost_points');
        $line_ids=$this->input->post('line_ids');

        foreach ($po_ids as $k => $p_id){

            if($line_ids[$k]==0){
                $data['line_id']="100";
            }else{
                $data['line_id']=$line_ids[$k];
            }

            if ($lost_points[$k] != ''){
                $data['other_purpose_remarks'] = "Manually Closed - $lost_points[$k]";
            }

            $po_info = $this->access_model->manualClosedById($p_id);
            $this->access_model->update_care_labels($data, $p_id);
        }

        echo 'done';
    }

    public function po_in_warehouse_other_and_wash_gmt()
    {
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['warehouse_qa_type']=$this->input->post('destination_id');
        $ex_fac_date = $this->input->post('ex_fac_date');

        $data['is_going_wash']="1";
        $data['going_wash_scan_date_time']="$ex_fac_date";
        $data['wash_going_printed']="1";
        $data['wash_going_print_date_time']="$ex_fac_date";
        $data['washing_status']="1";
        $data['washing_date_time']="$ex_fac_date";

        $data['access_points']="4";
        $data['access_points_status']="4";
        $data['end_line_qc_date_time']="$ex_fac_date";
        $data['warehouse_other_purpose_date_time']="$ex_fac_date";
        $data['other_purpose_remarks']="Manually Closed";
        $data['other_purpose_liable_person']="Administrator";
        $data['manually_closed']="1";

        $data['sent_to_production']="1";
        $data['sent_to_production_date_time']="$ex_fac_date";
        $data['is_printed']="1";
        $data['printing_date_time']="$ex_fac_date";
        $data['line_input_date_time']="$ex_fac_date";
        $data['mid_line_qc_date_time']="$ex_fac_date";
        $data['packing_status']="1";
        $data['packing_date_time']="$ex_fac_date";
        $data['lost_date_time']="$date";
        $po_ids=$this->input->post('po_ids');
        $lost_points=$this->input->post('lost_points');
        $line_ids=$this->input->post('line_ids');

        foreach ($po_ids as $k => $p_id){

            if($line_ids[$k]==0){
                $data['line_id']="100";
            }else{
                $data['line_id']=$line_ids[$k];
            }

            if ($lost_points[$k] != ''){
                $data['other_purpose_remarks'] = "Manually Closed - $lost_points[$k]";
            }

            $po_info = $this->access_model->manualClosedById($p_id);
            $this->access_model->update_care_labels($data, $p_id);
        }


        echo 'done';
    }

    public function po_in_size_set_and_wash_gmt()
    {
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['warehouse_qa_type']=$this->input->post('destination_id');
        $ex_fac_date = $this->input->post('ex_fac_date');

        $data['is_going_wash']="1";
        $data['going_wash_scan_date_time']="$ex_fac_date";
        $data['wash_going_printed']="1";
        $data['wash_going_print_date_time']="$ex_fac_date";
        $data['washing_status']="1";
        $data['washing_date_time']="$ex_fac_date";

        $data['access_points']="4";
        $data['access_points_status']="4";
        $data['end_line_qc_date_time']="$ex_fac_date";
        $data['lost_date_time']="$date";
        $data['other_purpose_remarks']="Manually Closed";
        $data['other_purpose_liable_person']="Administrator";
        $data['manually_closed']="1";

        $data['sent_to_production']="1";
        $data['sent_to_production_date_time']="$ex_fac_date";
        $data['is_printed']="1";
        $data['printing_date_time']="$ex_fac_date";
        $data['line_input_date_time']="$ex_fac_date";
        $data['mid_line_qc_date_time']="$ex_fac_date";
        $data['packing_status']="1";
        $data['packing_date_time']="$ex_fac_date";
        $po_ids=$this->input->post('po_ids');
        $lost_points=$this->input->post('lost_points');
        $line_ids=$this->input->post('line_ids');

        foreach ($po_ids as $k => $p_id){

            if($line_ids[$k]==0){
                $data['line_id']="100";
            }else{
                $data['line_id']=$line_ids[$k];
            }

            if ($lost_points[$k] != ''){
                $data['other_purpose_remarks'] = "Manually Closed - $lost_points[$k]";
            }

            $po_info = $this->access_model->manualClosedById($p_id);
            $this->access_model->update_care_labels($data, $p_id);
        }

        echo 'done';
    }

    public function po_in_lost_and_wash_gmt()
    {
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['warehouse_qa_type']=$this->input->post('destination_id');
        $ex_fac_date = $this->input->post('ex_fac_date');

        $data['is_going_wash']="1";
        $data['going_wash_scan_date_time']="$ex_fac_date";
        $data['wash_going_printed']="1";
        $data['wash_going_print_date_time']="$ex_fac_date";
        $data['washing_status']="1";
        $data['washing_date_time']="$ex_fac_date";

        $data['access_points']="4";
        $data['access_points_status']="4";
        $data['end_line_qc_date_time']="$ex_fac_date";
        $data['lost_date_time']="$date";
        $data['other_purpose_remarks']="Manually Closed";
        $data['other_purpose_liable_person']="Administrator";
        $data['manually_closed']="1";

        $data['sent_to_production']="1";
        $data['sent_to_production_date_time']="$ex_fac_date";
        $data['is_printed']="1";
        $data['printing_date_time']="$ex_fac_date";
        $data['line_input_date_time']="$ex_fac_date";
        $data['mid_line_qc_date_time']="$ex_fac_date";
        $data['packing_status']="1";
        $data['packing_date_time']="$ex_fac_date";
        $po_ids=$this->input->post('po_ids');
        $lost_points=$this->input->post('lost_points');
        $line_ids=$this->input->post('line_ids');

        foreach ($po_ids as $k => $p_id){

            if($line_ids[$k]==0){
                $data['line_id']="100";
            }else{
                $data['line_id']=$line_ids[$k];
            }

            if ($lost_points[$k] != ''){
                $data['other_purpose_remarks'] = "Manually Closed - $lost_points[$k]";
            }

            $po_info = $this->access_model->manualClosedById($p_id);
            $this->access_model->update_care_labels($data, $p_id);
        }


        echo 'done';
    }

    public function chk_purchase_order()
    {
        $po_no=$this->input->post('po_no');
        $so_no=$this->input->post('so_no');
        $where = '';

        if($po_no != ''){
            $where .= " AND po_no='$po_no'";
        }
        if($so_no != ''){
            $where .= " AND so_no='$so_no'";
        }
        $chk_purchase_order=$this->access_model->chk_purchase_order($where);
        if($chk_purchase_order)
            $output='';
        {
            $output .= '<option value="">Select Purchase Order</option>';
            foreach($chk_purchase_order as $v_chk){

                $output .= '<option value="'.$v_chk->purchase_order.'">'.$v_chk->purchase_order.'</option>';

            }
            echo $output;
        }


    }

    public function chk_item_no()
    {
        $po_no=$this->input->post('po_no');
        $so_no=$this->input->post('so_no');
        $purchase_no=$this->input->post('purchase_no');
        $where = '';

        if($po_no != ''){
            $where .= " AND po_no='$po_no'";
        }
        if($so_no != ''){
            $where .= " AND so_no='$so_no'";
        }
        if($purchase_no != ''){
            $where .= " AND purchase_order='$purchase_no'";
        }

        $chk_item_no=$this->access_model->chk_item_order($where);
        if($chk_item_no)
            $output='';
        {
            $output .= '<option value="">Select Item</option>';
            foreach($chk_item_no as $v_chk){

                $output .= '<option value="'.$v_chk->item.'">'.$v_chk->item.'</option>';

            }
            echo $output;
        }
    }

    public function chk_wsh_gmt()
    {
        $so_no=$this->input->post('so_no');
        $chk_item_no=$this->access_model->chk_wsh_gmt($so_no);
        if($chk_item_no)
            $output='';
        {
            $output .= '<option value="">Is Wash GMT?</option>';
            foreach($chk_item_no as $v_chk){

                if($v_chk->is_wash_gmt == 1){
                    $wash = "YES";
                }

                if($v_chk->is_wash_gmt == 0){
                    $wash = "NO";
                }

                $output .= '<option value="'.$v_chk->is_wash_gmt.'" selected="selected">'.$wash.'</option>';

            }
            echo $output;
        }
    }

    public function chk_quality()
    {
        $po_no=$this->input->post('po_no');
        $so_no=$this->input->post('so_no');
        $purchase_no=$this->input->post('purchase_no');
        $item_no=$this->input->post('item_no');
        $where = '';

        if($po_no != ''){
            $where .= " AND po_no='$po_no'";
        }
        if($so_no != ''){
            $where .= " AND so_no='$so_no'";
        }
        if($purchase_no != ''){
            $where .= " AND purchase_order='$purchase_no'";
        }
        if($item_no != ''){
            $where .= " AND item='$item_no'";
        }

        $chk_quality=$this->access_model->chk_quality($where);
        if($chk_quality)
            $output='';
        {
            $output .= '<option value="">Select Quality</option>';
            foreach($chk_quality as $v_chk){

                $output .= '<option value="'.$v_chk->quality.'">'.$v_chk->quality.'</option>';

            }
            echo $output;
        }
    }

    public function chk_color()
    {
        $purchase_no=$this->input->post('purchase_no');
        $so_no=$this->input->post('so_no');
        $po_no=$this->input->post('po_no');
        $item_no=$this->input->post('item_no');
        $quality=$this->input->post('quality');

        $where = '';

        if($po_no != ''){
            $where .= " AND po_no='$po_no'";
        }
        if($so_no != ''){
            $where .= " AND so_no='$so_no'";
        }
        if($purchase_no != ''){
            $where .= " AND purchase_order='$purchase_no'";
        }
        if($item_no != ''){
            $where .= " AND item='$item_no'";
        }
        if($quality != ''){
            $where .= " AND quality='$quality'";
        }

        $chk_color=$this->access_model->chk_color($where);
        if($chk_color)
            $output='';
        {
            $output .= '<option value="">Select Color</option>';
            foreach($chk_color as $v_chk){

                $output .= '<option value="'.$v_chk->color.'">'.$v_chk->color.'</option>';

            }
            echo $output;
        }
    }

    public function search_manual_closing_report()
    {
        $so_no=$this->input->post('so_no');
//        $po_no=$this->input->post('po_no');
//
//
//        $purchase_no=$this->input->post('purchase_no');
//        $item_no=$this->input->post('item_no');
//        $quality=$this->input->post('quality');
//        $color=$this->input->post('color');
        $where = '';

//        if($po_no != ''){
//            $where .= " AND po_no='$po_no'";
//        }
        if($so_no != ''){
            $where .= " AND so_no='$so_no'";
        }
//        if($purchase_no != ''){
//            $where .= " AND purchase_order='$purchase_no'";
//        }
//        if($item_no != ''){
//            $where .= " AND item='$item_no'";
//        }
//        if($quality != ''){
//            $where .= " AND quality='$quality'";
//        }
//        if($color != ''){
//            $where .= " AND color='$color'";
//        }

        $search_result=$this->access_model->search_manual_closing_report($where);

        $new_line = '';
        foreach ($search_result as $k => $v)
        {

            $lost_point = '';

            if($v['sent_to_production'] == 0){
                $lost_point = 'Not Sent From Cutting';
            }else{
                if($v['line_id']==0){
                    $lost_point = 'Not Inputted Line';
                }else{
                    if(($v['access_points']==2) && ($v['access_points_status']==1)){
                        $lost_point = 'Lost After Input to Line';
                    }
                    elseif (($v['access_points']==3) && ($v['access_points_status']==1)){
                        $lost_point = 'Lost In Between Mid-End QC';
                    }
                    elseif (($v['access_points']==3) && ($v['access_points_status']!=1)){
                        $lost_point = 'Lost In Mid QC';
                    }
                    elseif (($v['access_points']==4) && ($v['access_points_status']==4)){
                        if($v['is_wash_gmt'] == 1){

                            if($v['is_going_wash'] == 0){
                                $lost_point = 'Did Not Go To Wash';
                            }else{
                                if($v['washing_status'] == 0){
                                    $lost_point = 'Did Not Return From Wash';
                                }else{
                                    if($v['packing_status'] == 0){
                                        $lost_point = 'Poly Not Completed';
                                    }else{
                                        if(($v['carton_status'] == 0) && ($v['warehouse_qa_type'] == 0)){
                                            $lost_point = 'Carton/Warehouse Not Completed';
                                        }
                                    }
                                }
                            }

                        }
                        if($v['is_wash_gmt'] == 0){

                            if($v['packing_status'] == 0){
                                $lost_point = 'Poly Not Completed';
                            }else{
                                if(($v['carton_status'] == 0) && ($v['warehouse_qa_type'] == 0)){
                                    $lost_point = 'Carton/Warehouse Not Completed';
                                }
                            }

                        }
                    }elseif (($v['access_points']==4) && ($v['access_points_status']!=4)){
                        $lost_point = 'Lost In End-QC';
                    }
                }
            }

            $id=$v['id'];
            $pc_tracking_no = $v['pc_tracking_no'];
            $so_no = $v['so_no'];
            $purchase_order = $v['purchase_order'];
            $item = $v['item'];
            $quality = $v['quality'];
            $color = $v['color'];
            $style_no = $v['style_no'];
            $style_name = $v['style_name'];
            $size = $v['size'];
            $potype = $v['po_type'];

            $po_type = '';

            if($potype == 0){
                $po_type = "";
            }

            if($potype == 1){
                $po_type = "Size Set";
            }

            if($potype == 2){
                $po_type = "Sample";
            }

            $bundle_tracking_no = $v['bundle_tracking_no'];
            $brand = $v['brand'];
            $line_id = $v['line_id'];
            $warehouse_type = $v['warehouse_qa_type'];

            $new_line .= '<tr>';
            $new_line .='<td><input class="checkItem" type="checkbox" name="checkItem[]" id="checkItem" value="'.$id.'">'.$id.'</td>';
            $new_line .= '<td class="center">'.$pc_tracking_no.'</td>';
            $new_line .= '<td class="center">'.$so_no.'</td>';
            $new_line .= '<td class="center">'.$brand.'</td>';
            $new_line .= '<td class="center">'.$purchase_order.'-'.$item.'</td>';
            $new_line .= '<td class="center">'.$quality.'-'.$color.'</td>';
            $new_line .= '<td class="center">'.$style_no.'</td>';
            $new_line .= '<td class="center">'.$style_name.'</td>';
            $new_line .= '<td class="center"><input type="hidden" class="line_id" readonly id="line_id" name="line_id[]" value="'.$line_id.'" />'.$size.'</td>';
            $new_line .= '<td class="center">'.$po_type.'</td>';
            $new_line .= '<td class="center"><input type="hidden" class="lost_point" readonly id="lost_point" name="lost_point[]" value="'.$lost_point.'" />'.$lost_point.'</td>';
            $new_line .= '</tr>';


        }

        echo $new_line;
    }

    public function change_bundle_planned_line()
    {
        $data['title'] = 'Change Planned Line';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
        $data['so_nos'] = $this->access_model->getAllSOs();
        $data['lines'] = $this->access_model->getLines();
        $data['cut_no'] = $this->access_model->getCutNoList();

        $data['maincontent'] = $this->load->view('change_planned_line', $data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }
    public function getTotalScannedQtyBundle()
    {
        $so_no = $this->input->post('so_no');
        $cut_no = $this->input->post('cut_no');
        $size = $this->input->post('size');
        $line_no_from = $this->input->post('line_no_from');

        $res = $this->access_model->getTotalScannedQtyBundle($so_no, $cut_no, $size, $line_no_from);

        echo json_encode($res);
    }

    public function changingPlannedLine()
    {
        $so_no = $this->input->post('so_no');
        $cut_no = $this->input->post('cut_no');
        $line_no_from = $this->input->post('line_no_from');
        $line_no_to = $this->input->post('line_no_to');

        $this->access_model->changingPlannedLine($so_no, $cut_no, $line_no_from, $line_no_to);

        $data['message']="Successfully Line Changed!";
        $this->session->set_userdata($data);

        redirect('access/change_bundle_planned_line');
    }

    public function manual_closed()
    {

        $data['warehouse_qa_type']=$this->input->post('destination_id');
        $data['remarks']="Po Closed Manually";
        $po_ids=$this->input->post('po_ids');

        foreach ($po_ids as $p_id){
            $po_info = $this->access_model->manualClosedById($p_id);
            $this->access_model->update_care_labels($data, $p_id);
        }


        echo 'done';
    }

    public function pc_manual_closing()
    {
        $data['title'] = 'Piece Manual Close';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
        $data['sap_no'] = $this->access_model->getAllSos();

        $data['maincontent'] = $this->load->view('manual_closing',$data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function po_manual_closing()
    {
        $data['title'] = 'PO Manual Close';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $cur_url = __METHOD__;

        $res = $this->checkAuthorization($data['access_points'], $cur_url);

        if(sizeof($res) > 0) {
        $data['sap_no'] = $this->access_model->getAllSos();

        $data['maincontent'] = $this->load->view('po_manual_closing',$data, true);
        $this->load->view('master', $data);

        }else{
            echo $this->load->view('404');
        }
    }

    public function poManualClose(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $so_no_array = $this->input->post('so_no');

        $so_no = "'" . implode("', '", $so_no_array) . "'";

        $where = '';
        if($so_no != ''){
            $where .= " AND so_no IN ($so_no) AND carton_status=0 AND warehouse_qa_type=0";
        }

        $this->access_model->poManualClose($where, $date_time);

        echo 'done';
    }

//  Manual Closing End

    public function poManualReopen(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $so_no_array = $this->input->post('so_no');

        $so_no = "'" . implode("', '", $so_no_array) . "'";

        $where = '';
        if($so_no != ''){
            $where .= " AND so_no IN ($so_no) AND manually_closed=1";
        }

        $this->access_model->poManualReopen($where);

        echo 'done';
    }

    public function autoDbBackup()
    {
        $this->load->library('zip');

        // Load the DB utility class
        $this->load->dbutil();

        $date=date('Y-m-d');

        mkdir('db_backup/'.$date, 755, true);

        $table_array = array('tb_today_line_output_qty', 'tb_today_finishing_output_qty');

        foreach ($table_array as $v){

            $db_format = array(
                'tables'        => array("$v"),   // Array of tables to backup.
                'ignore'        => array(),                     // List of tables to omit from the backup
                'format'        => 'zip',                       // gzip, zip, txt
                'filename'      => "$v.sql",              // File name - NEEDED ONLY WITH ZIP FILES
                'add_drop'      => TRUE,                        // Whether to add DROP TABLE statements to backup file
                'add_insert'    => TRUE,                        // Whether to add INSERT data to backup file
                'newline'       => "\n"                         // Newline character used in backup file
            );
//        $db_format=array('format'=>'zip', 'filename'=>'efl_db_pts.sql');

            $backup=& $this->dbutil->backup($db_format);

            $dbname='backup_'.$date.'.zip';
            $save='db_backup/'.$date.'/'.$dbname;

            write_file($save, $backup);

//        force_download($dbname,$backup);

        }

    }

    public function logout() {
        $user_name = $this->session->unset_userdata('user_name');
        $user_description = $this->session->unset_userdata('user_description');
        $access_points = $this->session->unset_userdata('access_points');
        $line_id = $this->session->unset_userdata('line_id');
        $floor_id = $this->session->unset_userdata('floor_id');

        session_destroy();
        $data['message'] = 'Successfully Logged out!';
        $this->session->set_userdata($data);
        $this->session->sess_destroy();
        redirect('welcome');
    }


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */