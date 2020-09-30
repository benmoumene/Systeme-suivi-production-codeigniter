<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//session_start();
class Dashboard extends CI_Controller {

   public function __construct()
   {
        parent::__construct();

        $this->method_call = &get_instance();
   }

    function action()
    {
        $this->load->library("excel");
        $object = new PHPExcel();

        $object->setActiveSheetIndex(0);

        $table_columns = array("Name", "Address", "Gender", "Designation", "Age");

        $column = 0;

        foreach($table_columns as $field)
        {
            $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
            $column++;
        }

        $employee_data = $this->dashboard_model->testSelectQuery();

//        echo '<pre>';
//        print_r($employee_data);
//        echo '</pre>';

        $excel_row = 2;

        foreach($employee_data as $row)
        {
            $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->id);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->floor_name);
            $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->floor_code);
            $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->floor_description);
            $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->status);
            $excel_row++;
        }

        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="hb_running_po.xlsx"');

        $object_writer->save('php://output');
    }

    public function mailAttachmentOlympFileDownload()
    {
        $data['title']='Production Summary Report OLYMP';
        $this->load->library("excel");
        $object = new PHPExcel();

        $where = '';
        $where .= " AND brand in ('OLYMP') AND status != 'CLOSE' AND po_type = 0";

        $order_by_condition = '';
//        $order_by_condition .= " ORDER BY t1.ex_factory_date, t18.responsible_line ASC";
        $order_by_condition .= " ORDER BY t1.ex_factory_date, t3.responsible_line ASC";


        $prod_summary = $this->dashboard_model->getProductionSummaryReport($where, $order_by_condition);

//        $content_data = $this->load->view('reports/report_file_export', $data);

        $new_row_tbl = '';
        $new_row = '';
        $new_row_head = '';
        $purchase_order_item = '';
        $exfac_style = '';
        $wash_gmt_style = '';
        $cur_date = date('Y-m-d');
        $cut_balance_qty = 0;


        $object->setActiveSheetIndex(0);

        $table_columns = array("PO", "Plan Line", "Lines", "Brand", "ORDER", "ExFac", "CUT", "CUT PASS", "CUT BLNC", "INPUT", "COLLAR", "COLLAR BLNC", "CUFF", "CUFF BLNC", "MID", "MID BLNC", "END", "END BLNC", "PACK", "PACK BLNC", "CARTON", "CARTON BLNC", "OTHERS", "REMARKS");

        $column = 0;

        $excel_row = 2;

        foreach($table_columns as $field)
        {
            $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
            $column++;
        }

        $today = date('Y-m-d');
        $till_date = date("Y-m-d", strtotime("+ 30 days"));

        foreach ($prod_summary as $k => $v){

            $total_finishing_wh_qa = $v['count_carton_pass'] + $v['total_wh_qa'] + $v['count_manual_close_qty'];
            $total_others = $v['total_wh_qa'] + $v['count_manual_close_qty'];

//            $total_finishing_wh_qa = $v['count_carton_pass'] + $v['count_wh_prod_sample'] + $v['count_wh_factory'] + $v['count_wh_buyer'] + $v['count_wh_trash'] + $v['count_wh_others'] + $v['count_wh_lost'] + $v['total_manual_close_qty'];
//            $total_wh_qa = $v['count_wh_prod_sample'] + $v['count_wh_factory'] + $v['count_wh_buyer'] + $v['count_wh_trash'] + $v['count_wh_others'] + $v['count_wh_lost'];

//            if((($v['total_cut_qty'] - $total_finishing_wh_qa) != 0) && ($v['responsible_line'] != '')){
//            if(($today <= $v['ex_factory_date']) || ($till_date <= $v['ex_factory_date']) || (($v['total_cut_qty'] - $total_finishing_wh_qa) > 0)){
//            if((($v['total_cut_qty'] - $total_finishing_wh_qa) > 0)){

            if($v['status'] != 'CLOSE') {
                $ship_date = $v['ex_factory_date'];

                if ($v['item'] == '') {
                    $item = 'NA';
                } else {
                    $item = $v['item'];
                }

                if ($v['item'] != '') {
                    $purchase_order_item = $v['purchase_order'] . '_' . $v['item'];
                } else {
                    $purchase_order_item = $v['purchase_order'];
                }


                if ($cur_date > $ship_date) {
                    $exfac_style .= 'style="background-color: #ff481f; color: #fff;"';
                }

                if ($v['wash_gmt'] == 1) {
                    $wash_gmt_style .= 'style="background-color: #faff88;"';
                }

                $cut_balance_qty = $v['total_cut_qty'] - $v['total_cut_input_qty'];
                $collar_balance_qty = $v['total_cut_qty'] - $v['collar_bndl_qty'];
                $cuff_balance_qty = $v['total_cut_qty'] - $v['cuff_bndl_qty'];
                $mid_balance_qty = $v['total_cut_qty'] - $v['count_mid_line_qc_pass'];
                $end_balance_qty = $v['total_cut_qty'] - $v['count_end_line_qc_pass'];
                $pack_balance_qty = $v['total_order_qty'] - $v['count_packing_pass'];
                $carton_balance_qty = $v['total_order_qty'] - $v['count_carton_pass'];

                $total_po_item_balance = $v['total_cut_qty'] - $total_finishing_wh_qa;


                $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $v["purchase_order"]);
                $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $v["planned_lines"]);
                $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $v["responsible_line"]);
                $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $v["brand"]);
                $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $v["total_order_qty"]);
                $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $v["ex_factory_date"]);
                $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $v["total_cut_qty"]);
                $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $v["total_cut_input_qty"]);
                $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $cut_balance_qty);
                $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $v["count_input_qty_line"]);
                $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $v["collar_bndl_qty"]);
                $object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $collar_balance_qty);
                $object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $v["cuff_bndl_qty"]);
                $object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, $cuff_balance_qty);
                $object->getActiveSheet()->setCellValueByColumnAndRow(14, $excel_row, $v["count_mid_line_qc_pass"]);
                $object->getActiveSheet()->setCellValueByColumnAndRow(15, $excel_row, $mid_balance_qty);
                $object->getActiveSheet()->setCellValueByColumnAndRow(16, $excel_row, $v["count_end_line_qc_pass"]);
                $object->getActiveSheet()->setCellValueByColumnAndRow(17, $excel_row, $end_balance_qty);
                $object->getActiveSheet()->setCellValueByColumnAndRow(18, $excel_row, $v["count_packing_pass"]);
                $object->getActiveSheet()->setCellValueByColumnAndRow(19, $excel_row, ($pack_balance_qty > 0 ? $pack_balance_qty : 0));
                $object->getActiveSheet()->setCellValueByColumnAndRow(20, $excel_row, $v["count_carton_pass"]);
                $object->getActiveSheet()->setCellValueByColumnAndRow(21, $excel_row, ($carton_balance_qty > 0 ? $carton_balance_qty : 0));
                $object->getActiveSheet()->setCellValueByColumnAndRow(22, $excel_row, $total_others);
                $object->getActiveSheet()->setCellValueByColumnAndRow(23, $excel_row, $v["status"]);
                $excel_row++;

            }

//            }
        }

        $object->getActiveSheet()->freezePane('A2');
        $object->getActiveSheet()->setAutoFilter('A1:Z1');

        $object->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);

        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
//        header('Content-Type: application/vnd.ms-excel');
//        header('Content-Disposition: attachment;filename="olymp_running_po.xlsx"');

        $name = 'uploads/mail_attachment/olymp_running_po.xlsx';
//        $object_writer->save('php://output');
        $object_writer->save($name);

        echo  "<script type='text/javascript'>";
        echo "window.open('', '_self', ''); window.close();";
        echo "</script>";
    }

    public function mailAttachmentHBFileDownload()
    {
        $data['title']='Production Summary Report HB';
        $this->load->library("excel");
        $object = new PHPExcel();

        $where = '';
        $where .= " AND brand in ('BBD', 'BMB', 'BBS', 'BGM', 'BMA', 'BMC', 'BMS', 'BOM', 'HUGO', 'HUM') AND po_type IN (0, 2)";

        $order_by_condition = '';
        $order_by_condition .= " ORDER BY t1.ex_factory_date DESC";

        $prod_summary = $this->dashboard_model->getProductionSummaryReport($where, $order_by_condition);

//        $content_data = $this->load->view('reports/report_file_export', $data);

        $new_row_tbl = '';
        $new_row = '';
        $new_row_head = '';
        $purchase_order_item = '';
        $exfac_style = '';
        $wash_gmt_style = '';
        $cur_date = date('Y-m-d');
        $cut_balance_qty = 0;


        $object->setActiveSheetIndex(0);

        $table_columns = array("PO", "ITEM", "Plan Line", "Lines", "Brand", "STYLE", "QLTY-CLR", "ORDER", "ExFac", "CUT", "CUT BLNC", "CUT PASS", "INPUT", "Collar", "Cuff", "MID", "END", "WASH", "PACK", "CARTON", "Warehouse", "BALANCE", "PO TYPE");

        $column = 0;

        $excel_row = 2;

        foreach($table_columns as $field)
        {
            $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
            $column++;
        }

        $today = date('Y-m-d');
        $till_date = date("Y-m-d", strtotime("+ 30 days"));

        foreach ($prod_summary as $k => $v){
            $total_finishing_wh_qa = $v['count_carton_pass'] + $v['total_wh_qa'] + $v['count_manual_close_qty'];
//            $total_finishing_wh_qa = $v['count_carton_pass'] + $v['count_wh_prod_sample'] + $v['count_wh_factory'] + $v['count_wh_buyer'] + $v['count_wh_trash'] + $v['count_wh_others'] + $v['count_wh_lost'] + $v['total_manual_close_qty'];
//            $total_wh_qa = $v['count_wh_prod_sample'] + $v['count_wh_factory'] + $v['count_wh_buyer'] + $v['count_wh_trash'] + $v['count_wh_others'] + $v['count_wh_lost'];

//            if((($v['total_cut_qty'] - $total_finishing_wh_qa) != 0) && ($v['responsible_line'] != '')){
//            if(($today <= $v['ex_factory_date']) || ($till_date <= $v['ex_factory_date']) || (($v['total_cut_qty'] - $total_finishing_wh_qa) > 0)){
            if((($v['total_cut_qty'] - $total_finishing_wh_qa) > 0)){

                $ship_date = $v['ex_factory_date'];

                if($v['item'] == ''){
                    $item = 'NA';
                }else{
                    $item = $v['item'];
                }

                if($v['item'] != ''){
                    $purchase_order_item = $v['purchase_order'].'_'.$v['item'];
                }else{
                    $purchase_order_item = $v['purchase_order'];
                }


                $po_type='';

                if($v['po_type'] == 0){
                    $po_type='BULK';
                }
                if($v['po_type'] == 1){
                    $po_type='SIZE SET';
                }
                if($v['po_type'] == 2){
                    $po_type='SAMPLE';
                }

                if($cur_date > $ship_date){ $exfac_style .= 'style="background-color: #ff481f; color: #fff;"'; }
                if($v['wash_gmt'] == 1){ $wash_gmt_style .= 'style="background-color: #faff88;"'; }
                $cut_balance_qty = $v['total_cut_qty']-$v['total_cut_input_qty'];
                $total_po_item_balance = $v['total_cut_qty'] - $total_finishing_wh_qa;


                $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $v["purchase_order"]);
                $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $v["item"]);
                $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $v["planned_lines"]);
                $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $v["responsible_line"]);
                $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $v["brand"]);
                $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $v["style_no"].'-'.$v["style_name"]);
                $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $v["quality"].'_'.$v["color"]);
                $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $v["total_order_qty"]);
                $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $v["ex_factory_date"]);
                $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $v["total_cut_qty"]);
                $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $cut_balance_qty);
                $object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $v["total_cut_input_qty"]);
                $object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $v["count_input_qty_line"]);
                $object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, $v["collar_bndl_qty"]);
                $object->getActiveSheet()->setCellValueByColumnAndRow(14, $excel_row, $v["cuff_bndl_qty"]);
                $object->getActiveSheet()->setCellValueByColumnAndRow(15, $excel_row, $v["count_mid_line_qc_pass"]);
                $object->getActiveSheet()->setCellValueByColumnAndRow(16, $excel_row, $v["count_end_line_qc_pass"]);
                $object->getActiveSheet()->setCellValueByColumnAndRow(17, $excel_row, $v["count_washing_pass"]);
                $object->getActiveSheet()->setCellValueByColumnAndRow(18, $excel_row, $v["count_packing_pass"]);
                $object->getActiveSheet()->setCellValueByColumnAndRow(19, $excel_row, $v["count_carton_pass"]);
                $object->getActiveSheet()->setCellValueByColumnAndRow(20, $excel_row, $v["total_wh_qa"]);
                $object->getActiveSheet()->setCellValueByColumnAndRow(21, $excel_row, $total_po_item_balance);
                $object->getActiveSheet()->setCellValueByColumnAndRow(22, $excel_row, $po_type);
                $excel_row++;

            }
        }

        $object->getActiveSheet()->freezePane('A2');
        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
//        header('Content-Type: application/vnd.ms-excel');
//        header('Content-Disposition: attachment;filename="hb_running_po.xlsx"');

//        $object_writer->save('php://output');

        $name = 'uploads/mail_attachment/hb_running_po.xlsx';
//        $object_writer->save('php://output');
        $object_writer->save($name);

        echo  "<script type='text/javascript'>";
        echo "window.open('', '_self', ''); window.close();";
        echo "</script>";
    }

    public function index()
	{
		$data['title']='Running PO Report';

        $data['brands'] = $this->access_model->getAllBrands();

		$data['prod_summary'] = $this->dashboard_model->getProductionReport();

        $data['maincontent'] = $this->load->view('reports/report_index', $data, true);
        $this->load->view('reports/master', $data);
	}

    public function indexPc()
    {
        redirect('dashboard/index');
//        $data['title']='1st Floor';
//
//        $where = '';
//        $where .= " AND brand in ('BBD', 'BMB', 'BBS', 'BGM', 'BMA', 'BMC', 'BMS', 'BOM', 'HUGO', 'HUM', 'M&S T11', 'M&ST11', 'M&S', 'TIMBERLAND')";
//
//        $data['maincontent'] = $this->load->view('reports/report_index_pc', $data, true);
//        $this->load->view('reports/master', $data);
    }

    public function index_1()
    {
//        $this->output->clear_all_cache();
        $data['title']='Production Summary Report';

        $where = '';
        $where .= " AND brand in ('BBD', 'BMB', 'BBS', 'BGM', 'BMA', 'BMC', 'BMS', 'BOM', 'HUGO', 'HUM', 'M&S T11', 'M&ST11', 'M&S')";

        $data['summary_report'] = $this->dashboard_model->getBuyerShipDateWiseReport($where);

        $data['maincontent'] = $this->load->view('reports/index_1', $data, true);
        $this->load->view('reports/master', $data);
    }

    public function getBuyerShipDateWiseDetailReport_1($ex_factory_date){
       $brands = "'BBD', 'BMB', 'BBS', 'BGM', 'BMA', 'BMC', 'BMS', 'BOM', 'HUGO', 'HUM', 'M&S T11', 'M&ST11', 'M&S'";

       $data['ex_factory_date'] = $ex_factory_date;

//        $where = '';
//        $where .= " AND ex_factory_date='$ex_factory_date' AND brand in ($brands)";
////
//        $data['prod_summary'] = $this->dashboard_model->getProductionSummaryReport($where);

        $data['maincontent'] = $this->load->view('reports/report_index_1', $data, true);
        $this->load->view('reports/master', $data);
    }

    public function getProductionSummaryReportNew(){
        $ex_factory_date = $this->input->post('ex_factory_date');

        $where = '';
        $where .= " AND brand in ('BBD', 'BMB', 'BBS', 'BGM', 'BMA', 'BMC', 'BMS', 'BOM', 'HUGO', 'HUM', 'M&S T11', 'M&ST11', 'M&S', 'TIMBERLAND')";

        if ($ex_factory_date != ''){
            $where .= " AND ex_factory_date='$ex_factory_date'";
        }

        $data['prod_summary'] = $this->dashboard_model->getProductionSummaryReport($where);

        echo $data['maincontent'] = $this->load->view('reports/care_label_line_prod_summary_report', $data);
    }

    public function finishingRunningPoReportByBrand(){
        $data['title']='Finishing PO Report';

        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['brands'] = $this->access_model->getAllBrands();

        $data['maincontent'] = $this->load->view('reports/floor_wise_finishing_po_item_report', $data, true);
        $this->load->view('reports/master', $data);
    }

    public function getFinishingRunningPoReportByBrand(){
        $brands = $this->input->post('brands');
        $data['brands_string'] = implode(", ", $brands);
        $brands_string = $data['brands_string'];

        $po_type = $this->input->post('po_type');

        $po_from_date = $this->input->post('from_date');
        $po_to_date = $this->input->post('to_date');

        $where = '';

        if($po_type != ''){
            $where .= " AND po_type = $po_type";
        }

        if($brands_string != ''){
            $where .= " AND brand in ($brands_string) AND count_end_line_qc_pass > 0 AND balance > 0";
        }

        if($po_from_date != '' && $po_from_date != 'undefined--undefined' && $po_to_date != '' && $po_to_date != 'undefined--undefined'){
            $where .= " AND ex_factory_date Between '$po_from_date' AND '$po_to_date'";
        }

        $data['prod_summary'] = $this->dashboard_model->getProductionReport($where);

        echo $maincontent = $this->load->view('reports/floor_wise_finishing_po_item_report_data', $data);
    }

    public function aqlReport()
    {
        $data['title']='AQL Report';

        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['aql_summary'] = $this->dashboard_model->getAqlSummaryReport($date);

        $data['maincontent'] = $this->load->view('reports/aql_summary_report', $data, true);
        $this->load->view('reports/master', $data);
    }

    public function shipDateWiseReportlive()
    {
        $data['title']='Ship Date Wise Report Live';

        $data['brands'] = $this->access_model->getAllBrands();

        $data['ship_dates'] = $this->dashboard_model->getAllShipDates();

        $data['maincontent'] = $this->load->view('reports/ship_date_wise_report_live', $data, true);
        $this->load->view('reports/master', $data);
    }

    public function getShipDateWiseReportLive()
    {
        $po_type = $this->input->post('po_type');
        $brands_string = $this->input->post('brands');
//        $data['brands_string'] = implode(", ", $brands);
//        $brands_string = $data['brands_string'];

        $ship_date = $this->input->post('ship_date');

        $data['ex_factory_date'] = $ship_date;

        $where = '';
        $where_1 = '';

        if($po_type != ''){
            $where .= " AND po_type=$po_type";
        }

        if($brands_string != ''){
//            $where_1 .= " AND brand in ($brands_string)";
            $where .= " AND brand in ($brands_string)";
        }

        if($ship_date != '' && $ship_date != '1970-01-01'){
            $where .= " AND approved_ex_factory_date='$ship_date'";
        }

//        $data['po_close_report'] = $this->dashboard_model->getPoShippingDateWiseReport($where, $where_1);
        $data['po_close_report'] = $this->dashboard_model->getProductionReportLive($where);
//        echo '<pre>';
//        print_r( $data['po_close_report']);
//        echo '</pre>';
//        die();

        echo $maincontent = $this->load->view('reports/po_wise_report_by_ship_date_live', $data);
    }

    public function getProductionSummaryReport(){
//        $this->output->clear_all_cache();

        $where = '';
        $where .= " AND brand in ('BBD', 'BMB', 'BBS', 'BGM', 'BMA', 'BMC', 'BMS', 'BOM', 'HUGO', 'HUM', 'M&S T11', 'M&ST11', 'M&S', 'TIMBERLAND', 'CONBIPEL', 'MOSS', 'WOOLWORTH', 'John Lewis')";

//        $data['prod_summary'] = $this->dashboard_model->getProductionSummaryReport($where);
        $data['prod_summary'] = $this->dashboard_model->getProductionReport($where);

//        $this->output->cache(1);

        echo $data['maincontent'] = $this->load->view('reports/care_label_line_prod_summary_report', $data);
    }

    public function getRunningPOs(){
        $brands_string = $this->input->post('brands');

        $where = '';

        if($brands_string != ''){
            $where .= " AND brand in ($brands_string)";
        }

        $data['prod_summary'] = $this->dashboard_model->getProductionReport($where);

        echo $data['maincontent'] = $this->load->view('reports/care_label_line_prod_summary_report', $data);

    }

    public function getProductionReport(){
        $where = '';

        $data['prod_summary'] = $this->dashboard_model->getProductionSummaryReport($where);

        $truncate_result = $this->dashboard_model->truncateProductionSummary();

//        echo '<pre>';
//        print_r($truncate_result);
//        echo '</pre>';
//        die();

        if($truncate_result == 1){
            $cur_date = date('Y-m-d');
            $till_date = date("Y-m-d", strtotime("+ 30 days"));
            foreach($data['prod_summary'] as $k => $v) {

                $total_finishing_wh_qa = $v['count_carton_pass'] + $v['total_wh_qa'] + $v['count_manual_close_qty'];
//                $total_finishing_wh_qa = $v['count_carton_pass'] + $v['count_wh_prod_sample'] + $v['count_wh_factory'] + $v['count_wh_buyer'] + $v['count_wh_trash'] + $v['count_wh_others'] + $v['count_wh_lost'] + $v['count_wh_size_set'] + $v['total_manual_close_qty'];
//                $total_wh_qa = $v['count_wh_prod_sample'] + $v['count_wh_factory'] + $v['count_wh_buyer'] + $v['count_wh_trash'] + $v['count_wh_others'] + $v['count_wh_lost'] + $v['count_wh_size_set'];
                $balance = $v['total_cut_qty'] - $total_finishing_wh_qa;

//            if(((($v['total_cut_qty'] - $total_finishing_wh_qa) != 0) && ($v['responsible_line'] != ''))){
//            if (($cur_date <= $v['ex_factory_date']) || ($till_date <= $v['ex_factory_date']) || (($v['total_cut_qty'] - $total_finishing_wh_qa) >= 0)) {
//            if (($balance > 0)) {

                $ship_date = $v['ex_factory_date'];

                $idata['po_no'] = ($v['po_no'] != NULL ? $v['po_no'] : '');
                $idata['so_no'] = ($v['so_no'] != NULL ? $v['so_no'] : '');
                $idata['purchase_order'] = ($v['purchase_order'] != NULL ? $v['purchase_order'] : '');
                $idata['item'] = ($v['item'] != NULL ? $v['item'] : '');
                $idata['quality'] = ($v['quality'] != NULL ? $v['quality'] : '');
                $idata['color'] = ($v['color'] != NULL ? $v['color'] : '');
                $idata['style_no'] = ($v['style_no'] != NULL ? $v['style_no'] : '');
                $idata['style_name'] = ($v['style_name'] != NULL ? $v['style_name'] : '');
                $idata['brand'] = ($v['brand'] != NULL ? $v['brand'] : '');
                $idata['ex_factory_date'] = ($v['ex_factory_date'] != NULL ? $v['ex_factory_date'] : '0000-00-00');
                $idata['approved_ex_factory_date'] = ($v['approved_ex_factory_date'] != NULL ? $v['approved_ex_factory_date'] : '0000-00-00');
                $idata['crd_date'] = ($v['crd_date'] != NULL ? $v['crd_date'] : '0000-00-00');
                $idata['status'] = ($v['status'] != NULL ? $v['status'] : '');
                $idata['planned_lines'] = ($v['planned_lines'] != NULL ? $v['planned_lines'] : '');
                $idata['responsible_line'] = ($v['responsible_line'] != NULL ? $v['responsible_line'] : '');
                $idata['total_order_qty'] = ($v['total_order_qty'] != NULL ? $v['total_order_qty'] : 0);
                $idata['total_cut_qty'] = ($v['total_cut_qty'] != NULL ? $v['total_cut_qty'] : 0);
                $idata['total_cut_input_qty'] = ($v['total_cut_input_qty'] != NULL ? $v['total_cut_input_qty'] : 0);
                $idata['count_cut_package_ready_qty'] = ($v['count_cut_package_ready_qty'] != NULL ? $v['count_cut_package_ready_qty'] : 0);
                $idata['count_input_qty_line'] = ($v['count_input_qty_line'] != NULL ? $v['count_input_qty_line'] : 0);
                $idata['collar_bndl_qty'] = ($v['collar_bndl_qty'] != NULL ? $v['collar_bndl_qty'] : 0);
                $idata['cuff_bndl_qty'] = ($v['cuff_bndl_qty'] != NULL ? $v['cuff_bndl_qty'] : 0);
                $idata['count_mid_line_qc_pass'] = ($v['count_mid_line_qc_pass'] != NULL ? $v['count_mid_line_qc_pass'] : 0);
                $idata['count_end_line_qc_pass'] = ($v['count_end_line_qc_pass'] != NULL ? $v['count_end_line_qc_pass'] : 0);
                $idata['count_washing_qty'] = ($v['count_washing_qty'] != NULL ? $v['count_washing_qty'] : 0);
                $idata['wash_gmt'] = ($v['wash_gmt'] != NULL ? $v['wash_gmt'] : 0);
                $idata['count_washing_pass'] = ($v['count_washing_pass'] != NULL ? $v['count_washing_pass'] : 0);
                $idata['count_packing_pass'] = ($v['count_packing_pass'] != NULL ? $v['count_packing_pass'] : 0);
                $idata['count_carton_pass'] = ($v['count_carton_pass'] != NULL ? $v['count_carton_pass'] : 0);
                $idata['count_manual_close_qty'] = ($v['count_manual_close_qty'] != NULL ? $v['count_manual_close_qty'] : 0);
                $idata['total_wh_qa'] = ($v['total_wh_qa'] != NULL ? $v['total_wh_qa'] : 0);
                $idata['balance'] = ($balance != NULL ? $balance : 0);
                $idata['max_carton_date_time'] = (($v['max_carton_date_time'] != NULL || $v['max_carton_date_time'] != '') ? $v['max_carton_date_time'] : '0000-00-00 00:00:00');
                $idata['po_type'] = ($v['po_type'] != NULL ? $v['po_type'] : '');

//                if($balance > 0){
//                    $res_status = $this->dashboard_model->deleteProductionSo($idata['po_no'], $idata['so_no'], $idata['purchase_order'], $idata['item'], $idata['quality'], $idata['color']);

//                    if($res_status == 1){
                $this->dashboard_model->insertTblData('tb_production_summary', $idata);
//                    }
//                }
//                if($balance <= 0){
//                    $this->dashboard_model->deleteProductionSo($idata['po_no'], $idata['so_no'], $idata['purchase_order'], $idata['item'], $idata['quality'], $idata['color']);
//                }

//            }
            }
        }


        echo  "<script type='text/javascript'>";
        echo "window.open('', '_self', ''); window.close();";
        echo "</script>";

//        echo 'Done';

//        $data['maincontent'] = $this->load->view('reports/care_label_line_prod_summary_report', $data);
    }

    public function indexPc_2()
    {
        redirect('dashboard/index');

//        $data['title']='2nd Floor';
//
//        $where = '';
//        $where .= " AND t1.brand in ('OLYMP')";
//
//        $data['maincontent'] = $this->load->view('reports/report_index_pc_2', $data, true);
//        $this->load->view('reports/master', $data);
    }

    public function getProductionSummaryReport_2(){
//        $this->output->clear_all_cache();

        $where = '';
        $where .= " AND brand in ('OLYMP')";

//        $data['prod_summary'] = $this->dashboard_model->getProductionSummaryReport($where);
        $data['prod_summary'] = $this->dashboard_model->getProductionReport($where);

//        $this->output->cache(3);

        $data['maincontent'] = $this->load->view('reports/care_label_line_prod_summary_report', $data);
    }

    public function mailAttachmentHB_1()
    {
        $data['title']='Production Summary Report HB';

        // Start XML file, create parent node
        $dom = new DOMDocument("1.0");
        $node = $dom->createElement("markers");
        $parnode = $dom->appendChild($node);

        $where = '';
        $where .= " AND t1.brand in ('BBD', 'BBS', 'BGM', 'BMA', 'BMC', 'BMS', 'BOM', 'HUGO', 'HUM')";

        $prod_summary = $this->dashboard_model->getProductionSummaryReport($where);

//        $content_data = $this->load->view('reports/report_file_export', $data);

        //$new_row = '';
        $purchase_order_item = '';
        $exfac_style = '';
        $wash_gmt_style = '';
        $cur_date = date('Y-m-d');
        $cut_balance_qty = 0;

        $csv = "PO, ITEM, Lines, Brand, STYLE, STYLE NAME, QLTY, CLR, ORDER, ExFac, CUT, CUT BLNC, CUT PASS, INPUT, Collar, Cuff, MID PASS, END PASS, WASH, PACK, CARTON, WAREHOUSE, BALANCE \n";//Column headers

        foreach ($prod_summary as $k => $v){
            $total_finishing_wh_qa = $v['count_carton_pass'] + $v['count_wh_prod_sample'] + $v['count_wh_factory'] + $v['count_wh_buyer'] + $v['count_wh_trash'] + $v['count_other_purpose'] + $v['count_lost_qty'];
            $total_wh_qa = $v['count_wh_prod_sample'] + $v['count_wh_factory'] + $v['count_wh_buyer'] + $v['count_wh_trash'] + $v['count_other_purpose'] + $v['count_lost_qty'];

            if((($v['total_cut_qty'] - $total_finishing_wh_qa) != 0) && ($v['responsible_line'] != '')){
                $ship_date = $v['ex_factory_date'];

                if($v['item'] == ''){
                    $item = 'NA';
                }else{
                    $item = $v['item'];
                }

                $style_name = str_replace(',', '', $v["style_name"]);

                if($v['item'] != ''){
                    $purchase_order_item = $v['purchase_order'].'_'.$v['item'];
                }else{
                    $purchase_order_item = $v['purchase_order'];
                }



                if($cur_date > $ship_date){ $exfac_style .= 'style="background-color: #ff481f; color: #fff;"'; }
                if($v['wash_gmt'] == 1){ $wash_gmt_style .= 'style="background-color: #faff88;"'; }
                $cut_balance_qty = $v['total_cut_qty']-$v['total_cut_input_qty'];
                $total_po_item_balance = $v['total_cut_qty'] - $total_finishing_wh_qa;

                $csv .= $v["purchase_order"].','.$v["item"].','.$v["responsible_line"].','.$v["brand"].','.$v["style_no"].','.$style_name.','.$v["quality"].','.$v["color"].','.$v["total_order_qty"].','.$v["ex_factory_date"].','.$v["total_cut_qty"].','.$cut_balance_qty.','.$v["total_cut_input_qty"].','.$v["count_input_qty_line"].','.$v["collar_bndl_qty"].','.$v["cuff_bndl_qty"].','.$v["count_mid_line_qc_pass"].','.$v["count_end_line_qc_pass"].','.$v["count_washing_pass"].','.$v["count_packing_pass"].','.$v["count_carton_pass"].','.$total_wh_qa.','.$total_po_item_balance."\n";

            }
        }


        $csv_handler = fopen ('uploads/mail_attachment/hb_running_po.csv','w') or die("Unable to open file!");
        fwrite ($csv_handler, $csv);
        fclose ($csv_handler);


        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'webmail.viyellatexgroup.com',
            'smtp_port' => 25,
            'smtp_timeout' => 10,
            'smtp_user' => '', // change it to yours
            'smtp_pass' => '', // change it to yours
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'wordwrap' => TRUE
        );

        $content_data = '';
        $content_data .= 'Dear Sir,'.'<br />';
        $content_data .= 'Please find the running PO-ITEM from attached file.'.'<br />'.'<br />'.'<br />';
        $content_data .= 'Best Regards'.'<br />';
        $content_data .= 'Ecofab Ltd'.'<br />';
        $content_data .= 'VIYELLATEX Group, BANGLADESH';

            $this->load->library('email', $config);
            $this->email->set_newline('\r\n');
            $this->email->from('noreply@viyellatexgroup.com'); // change it to yours
            $this->email->to('nipun.sarker@interfabshirt.com');// change it to yours
            $this->email->cc('nipun.sarker@interfabshirt.com');// change it to yours
            $this->email->subject('PTS Test Mail');
            $this->email->message("$content_data");
            $this->email->attach("uploads/mail_attachment/hb_running_po.csv");

            if($this->email->send())
            {
                echo 'Email sent.';
            }
            else
            {
                show_error($this->email->print_debugger());
            }
    }

    public function linePerformanceDashboard(){
        $data['title'] = 'Line Dashboard';

        $line_id = $this->input->post('line_no');

        $data['user_name'] = $this->session->userdata('user_name');
        $data['access_points'] = $this->session->userdata('access_points');

        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['lines'] = $this->access_model->getLines();

        $where = '';
        $where1 = '';
        $where2 = '';

        $line_target = 0;
        $line_output = 0;

        if($line_id != ''){
            $data['line_info'] = $this->access_model->getLineInfo($line_id);
//            $data['hours'] = $this->access_model->getHours();
//
//            $min_max_hours = $this->access_model->getMinMaxHours();
//            $min_start_time = $min_max_hours[0]['min_start_time'];
//            $max_end_time = $min_max_hours[0]['max_end_time'];
//
//
//            $data['work_time'] = $this->access_model->getWorkingHoursViewTable($line_id, $date, $min_start_time);
//            $data['get_smv_list'] = $this->access_model->getSMVs($line_id, $date);
//
//            $where .= " AND line_id=$line_id AND date='$date'";
//
//            $line_trgt = $this->access_model->getLineTargetViewTable($line_id);
//
//            $line_target = $line_trgt[0]['target'];
//            $man_power = $line_trgt[0]['man_power'];
//
//
//            $where1 .= " AND line_id=$line_id  AND access_points_status=4
//                         AND DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') LIKE '%$date%' ";
//
//            $where2 .= " AND planned_line_id=$line_id AND line_id=0";
//
//
//            $line_report = $this->access_model->getLineOutputReportViewTable($line_id);
//
//
//            $data['upcoming_po'] = $this->access_model->getUpcomingPoListViewTable($where2);
//            $line_output = $line_report[0]['count_end_line_qc_pass'];
//
//            $data['line_output'] = $line_output;
//
//            $data['line_target'] = $line_target;
//
//            $data['man_power'] = $man_power;
//
//
//            $data['line_status'] = $this->dashboard_model->getLineStatusByLineViewTable($line_id, $date);

        }

        $data['maincontent'] = $this->load->view('reports/line_performance_dashboard', $data);
    }

    public function todayLineOutputHourly($line_id, $start_time, $end_time){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $where = '';

        if($line_id != '' && $start_time != '' && $end_time != ''){
            $where .= " AND line_id=$line_id 
                        AND date_format(end_line_qc_date_time, '%Y-%m-%d') LIKE '%$date%' 
                        AND date_format(end_line_qc_date_time, '%H:%i:%s') BETWEEN '$start_time' AND '$end_time'";
            $line_output = $this->access_model->todayLineOutputViewTable($where);
        }

        return $line_output;
    }

    public function mailLastDayProduction()
    {
        $data['title']='Auto Mail Last Day Production';

        $previous_date = date('Y-m-d',strtotime("-1 days"));

//         Start XML file, create parent node
        $dom = new DOMDocument("1.0");
        $node = $dom->createElement("markers");
        $parnode = $dom->appendChild($node);

        $where = '';
//        $where .= " AND brand IN ('OLYMP')";

        $prod_summary = $this->dashboard_model->getLastDayProduction($where, $previous_date);

//        $content_data = $this->load->view('reports/report_file_export', $data);

        $new_row_tbl = '';
        $new_row = '';
        $new_row_head = '';
        $purchase_order_item = '';
        $exfac_style = '';
        $wash_gmt_style = '';
        $cur_date = date('Y-m-d');
        $cut_balance_qty = 0;

        $new_row_head .= '<tr>
                        <th class="">Brand</th>
                        <th class="">SO</th>
                        <th class="">PO Type</th>
                        <th class="">PO</th>
                        <th class="">Item</th>
                        <th class="">Quality</th>
                        <th class="">Color</th>
                        <th class="">Style</th>
                        <th class="">Style Name</th>
                        <th class="">Line</th>
                        <th class="">Ex-Fac-Date</th>
                        <th class="">Cut Pass</th>
                        <th class="">Mid QC</th>
                        <th class="">End QC</th>
                        <th class="">Pack Qty</th>
                        <th class="">Carton Qty</th>
                        <th class="">Remarks</th>
                    </tr>';

        $today = date('Y-m-d');
        $till_date = date("Y-m-d", strtotime("+ 30 days"));

        foreach ($prod_summary as $k => $v){

            if($v["line_output_qty"] != '' || $v["cut_pass_qty"] != '' || $v["packing_qty"] != '' || $v["carton_qty"] != '' || $v["line_mid_pass_qty"] != ''){

                $po_type='';

                if($v["po_type"] == 0){
                    $po_type = 'BULK';
                }

                if($v["po_type"] == 1){
                    $po_type = 'SIZE SET';
                }

                if($v["po_type"] == 2){
                    $po_type = 'SAMPLE';
                }

                $new_row .= '<tr>
								<td>'.$v["brand"].'</td>
								<td>'.$v["so_no"].'</td>
								<td>'.$po_type.'</td>
                                <td>'.$v["purchase_order"].'</td>
                                <td>'.$v["item"].'</td>
                                <td>'.$v["quality"].'</td>
                                <td>'.$v["color"].'</td>
                                <td>'.$v["style_no"].'</td>
                                <td>'.$v["style_name"].'</td>
                                <td>'.$v["responsible_line"].'</td>
                                <td>'.$v["ex_factory_date"].'</td>
                                <td>'.$v["cut_pass_qty"].'</td>
                                <td>'.$v["line_mid_pass_qty"].'</td>
                                <td>'.$v["line_output_qty"].'</td>
                                <td>'.$v["packing_qty"].'</td>
                                <td>'.$v["carton_qty"].'</td>
                                <td>'.$v["status"].'</td>
                              </tr>';
            }
        }

//        echo '<pre>';
//        print_r($new_row);
//        echo '</pre>';
//        die();

//        if($new_row != ''){

//            echo $content_data;

//        echo file_exists('uploads/mail_attachment/hb_running_po.xlsx');
//        die();

        $new_row_tbl .= '<table border="1"><thead>'.$new_row_head.'</thead><tbody>'.$new_row.'</tbody></table>';

        $excel_handler = fopen ('uploads/mail_attachment/last_day_prod.xls','w') or die("Unable to open file!");
        fwrite ($excel_handler, $new_row_tbl);
        fclose ($excel_handler);

        if(file_exists('uploads/mail_attachment/last_day_prod.xls') == 1) {
//            $config = Array(
//                'protocol' => 'smtp',
//                'smtp_host' => 'webmail.viyellatexgroup.com',
//                'smtp_port' => 25,
//                'smtp_user' => '', // change it to yours
//                'smtp_pass' => '', // change it to yours
//                'mailtype' => 'html',
//                'charset' => 'utf-8',
//                'wordwrap' => TRUE
//            );

            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://smtp.gmail.com',
                'smtp_port' => 465,
                'smtp_user' => 'ecofab.pts@gmail.com', // change it to yours
                'smtp_pass' => 'productiontrackingsystem@123', // change it to yours
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'wordwrap' => TRUE
            );

            $content_data = '';
            $content_data .= 'Dear Concern,' . '<br />';
            $content_data .= 'Please find the Last Day Production from attached file.' . '<br />' . '<br />' . '<br />';
            $content_data .= 'Best Regards' . '<br />';
            $content_data .= 'Ecofab Ltd' . '<br />';
            //$content_data .= 'VIYELLATEX Group, BANGLADESH';

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
//            $this->email->from('pts@interfabshirt.com'); // change it to yours
            $this->email->from('ecofab.pts@gmail.com'); // change it to yours
            $this->email->to('shehab.ahameed@interfabshirt.com, monirul.islam@interfabshirt.com, shafayet.chowdhury@interfabshirt.com, ecofab.ie@interfabshirt.com, mehedi.hassan@interfabshirt.com, hasnain.mehedi@interfabshirt.com'); // change it to yours
            $this->email->cc('nipun.sarker@interfabshirt.com, hasib.hossain@interfabshirt.com, sahil.islam@interfabshirt.com, fahim.ashab@interfabshirt.com');// change it to yours
//            $this->email->to('nipun.sarker@interfabshirt.com'); // change it to yours
            $this->email->subject("Production: $previous_date (Auto-Mail)");
            $this->email->message("$content_data");
            $this->email->attach("uploads/mail_attachment/last_day_prod.xls");
            if ($this->email->send()) {

                echo  "<script type='text/javascript'>";
                echo "window.open('', '_self', ''); window.close();";
                echo "</script>";

            } else {
                show_error($this->email->print_debugger());
            }
        }else{
            echo 'File is not exist!';
        }

    }

    public function shipDateWiseReportBYDate(){
        $data['title']='Ship Date Wise Report By Date';

        $data['brands'] = $this->access_model->getAllBrands();

//        $data['ship_dates'] = $this->dashboard_model->getAllShipDates();

        $data['maincontent'] = $this->load->view('reports/ship_date_wise_report_by_date', $data, true);
        $this->load->view('reports/master', $data);
    }

    public function getShipDateWiseReportByDate(){
        $po_type = $this->input->post('po_type');
        $data['po_type'] = $po_type;
        $brands = $this->input->post('brands');
        $data['brands_string'] = implode(", ", $brands);
        $brands_string = $data['brands_string'];

        $po_from_date = $this->input->post('from_date');
        $po_to_date = $this->input->post('to_date');

        $month_year = $this->input->post('month_year');

        $where = '';

        if($brands_string != ''){
            $where .= " AND brand in ($brands_string)";
        }

        if($po_from_date != '' && $po_from_date != '1970-01-01' && $po_to_date != '' && $po_to_date != '1970-01-01'){
            $where .= " AND approved_ex_factory_date Between '$po_from_date' AND '$po_to_date'";
        }

        $data['dates'] = $this->dashboard_model->getSearchedDates($where);

        echo $maincontent = $this->load->view('reports/po_wise_report_by_shipping_date', $data);
    }

    public function mailAttachmentOlympLocalMail()
    {
//        $data['title']='Production Summary Report HB';

        // Start XML file, create parent node
//        $dom = new DOMDocument("1.0");
//        $node = $dom->createElement("markers");
//        $parnode = $dom->appendChild($node);
//
//        $where = '';
//        $where .= " AND t1.brand in ('BBD', 'BBS', 'BGM', 'BMA', 'BMC', 'BMS', 'BOM', 'HUGO', 'HUM')";
//
//        $prod_summary = $this->dashboard_model->getProductionSummaryReport($where);
//
////        $content_data = $this->load->view('reports/report_file_export', $data);
//
//        $new_row_tbl = '';
//        $new_row = '';
//        $new_row_head = '';
//        $purchase_order_item = '';
//        $exfac_style = '';
//        $wash_gmt_style = '';
//        $cur_date = date('Y-m-d');
//        $cut_balance_qty = 0;
//
//        $new_row_head .= '<tr>
//                        <th class="">PO</th>
//                        <th class="">ITEM</th>
//                        <th class="">Planned Line</th>
//                        <th class="">Lines</th>
//                        <th class="">Brand</span></th>
//                        <th class="">STYLE</th>
//                        <th class="">QLTY-CLR</th>
//                        <th class="">ORDER</th>
//                        <th class="">ExFac</th>
//                        <th class="">CUT</th>
//                        <th class="">CUT BLNC</th>
//                        <th class="">CUT PASS</th>
//                        <th class="">BUNDLE</th>
//                        <th class="">IDENTITY</th>
//                        <th class="">INPUT</th>
//                        <th class="">Collar</th>
//                        <th class="">Cuff</th>
//                        <th class="">MID PASS</th>
//                        <th class="">END PASS</th>
//                        <th class="">WASH</th>
//                        <th class="">PACK</th>
//                        <th class="">CARTON</th>
//                        <th class="">WAREHOUSE BUYER</th>
//                        <th class="">WAREHOUSE FACTORY</th>
//                        <th class="">WAREHOUSE SAMPLE</th>
//                        <th class="">WAREHOUSE TRASH</th>
//                        <th class="">OTHER PURPOSE</th>
//                        <th class="">BALANCE</th>
//                    </tr>';
//
//        $today = date('Y-m-d');
//        $till_date = date("Y-m-d", strtotime("+ 30 days"));
//
//        foreach ($prod_summary as $k => $v){
//            $total_finishing_wh_qa = $v['count_carton_pass'] + $v['count_wh_prod_sample'] + $v['count_wh_factory'] + $v['count_wh_buyer'] + $v['count_wh_trash'] + $v['count_other_purpose'];
//            $total_wh_qa = $v['count_wh_prod_sample'] + $v['count_wh_factory'] + $v['count_wh_buyer'] + $v['count_wh_trash'];
//
////            if((($v['total_cut_qty'] - $total_finishing_wh_qa) != 0) && ($v['responsible_line'] != '')){
//            if(($today <= $v['ex_factory_date']) || ($till_date <= $v['ex_factory_date']) || (($v['total_cut_qty'] - $total_finishing_wh_qa) != 0)){
//                $ship_date = $v['ex_factory_date'];
//
//                if($v['item'] == ''){
//                    $item = 'NA';
//                }else{
//                    $item = $v['item'];
//                }
//
//
//                if($v['item'] != ''){
//                    $purchase_order_item = $v['purchase_order'].'_'.$v['item'];
//                }else{
//                    $purchase_order_item = $v['purchase_order'];
//                }
//
//
//
//                if($cur_date > $ship_date){ $exfac_style .= 'style="background-color: #ff481f; color: #fff;"'; }
//                if($v['wash_gmt'] == 1){ $wash_gmt_style .= 'style="background-color: #faff88;"'; }
//                $cut_balance_qty = $v['total_cut_qty']-$v['total_cut_input_qty'];
//                $total_po_item_balance = $v['total_cut_qty'] - $total_finishing_wh_qa;
//
//                $new_row .= '<tr>
//								<td>'.$v["purchase_order"].'</td>
//                                <td>'.$v["item"].'</td>
//                                <td>'.$v["planned_lines"].'</td>
//                                <td>'.$v["responsible_line"].'</td>
//                                <td>'.$v["brand"].'</td>
//                                <td>'.$v["style_no"].'-'.$v["style_name"].'</td>
//                                <td>'.$v["quality"].'_'.$v["color"].'</td>
//                                <td>'.$v["total_order_qty"].'</td>
//                                <td>'.$v["ex_factory_date"].'</td>
//                                <td>'.$v["total_cut_qty"].'</td>
//                                <td>'.$cut_balance_qty.'</td>
//                                <td>'.$v["total_cut_input_qty"].'</td>
//                                <td><span style="color: #ffffff;">'."'".'</span>'.$v["bundle_start"].'-'.$v["bundle_end"].'</td>
//                                <td>'.$v["min_care_label"].'-'.$v["max_care_label"].'</td>
//
//                                <td>'.$v["count_input_qty_line"].'</td>
//
//                                <td>'.$v["collar_bndl_qty"].'</td>
//                                <td>'.$v["cuff_bndl_qty"].'</td>
//                                <td>'.$v["count_mid_line_qc_pass"].'</td>
//                                <td>'.$v["count_end_line_qc_pass"].'</td>
//                                <td>'.$v["count_washing_pass"].'</td>
//                                <td>'.$v["count_packing_pass"].'</td>
//                                <td>'.$v["count_carton_pass"].'</td>
//                                <td>'.$v['count_wh_buyer'].'</td>
//                                <td>'.$v['count_wh_factory'].'</td>
//                                <td>'.$v['count_wh_prod_sample'].'</td>
//                                <td>'.$v['count_wh_trash'].'</td>
//                                <td>'.$v['count_other_purpose'].'</td>
//                                <td>'.$total_po_item_balance.'</td></tr>';
//            }
//        }
//
////        echo '<pre>';
////        print_r($new_row);
////        echo '</pre>';
////        die();
//
////        if($new_row != ''){
//
////            echo $content_data;
//
////        echo file_exists('uploads/mail_attachment/hb_running_po.xlsx');
////        die();
//
//        $new_row_tbl .= '<table border="1"><thead>'.$new_row_head.'</thead><tbody>'.$new_row.'</tbody></table>';
//
//        $excel_handler = fopen ('uploads/mail_attachment/hb_running_po.xls','w') or die("Unable to open file!");
//        fwrite ($excel_handler, $new_row_tbl);
//        fclose ($excel_handler);

        if(file_exists('uploads/mail_attachment/olymp_running_po.xlsx') == 1) {
            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'webmail.viyellatexgroup.com',
                'smtp_port' => 25,
                'smtp_user' => '', // change it to yours
                'smtp_pass' => '', // change it to yours
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'wordwrap' => TRUE
            );

            $content_data = '';
            $content_data .= 'Dear Sir/Madam,' . '<br />';
            $content_data .= 'Please find the running PO-ITEM from attached file.' . '<br />' . '<br />' . '<br />';
            $content_data .= 'Best Regards' . '<br />';
            $content_data .= 'Ecofab Ltd' . '<br />';
            //$content_data .= 'VIYELLATEX Group, BANGLADESH';

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('pts@interfabshirt.com'); // change it to yours
            $this->email->to('Silke.Wippert@olymp.com'); // change it to yours
            $this->email->cc('ahasan-interfab@viyellatexgroup.com, abdullah.khan@viyellatexgroup.com, moazzem.huq@interfabshirt.com, ali.hossain@interfabshirt.com, nesar.ahmed@interfabshirt.com, arif.abdulla@interfabshirt.com, monirul.islam@interfabshirt.com, ecofab.ie@interfabshirt.com, dinendra.sanjeewa@interfabshirt.com, mehedi.hassan@interfabshirt.com, hasnain.mehedi@interfabshirt.com, nipun.sarker@interfabshirt.com, ecofab.itsupport@interfabshirt.com, qa.audit@interfabshirt.com, mostafa.shak@interfabshirt.com, nipunsarker56@gmail.com, shafayet.chowdhury@interfabshirt.com, shehab.ahameed@interfabshirt.com, hasib.hossain@interfabshirt.com, sahil.islam@interfabshirt.com, fahim.ashab@interfabshirt.com');// change it to yours
//            $this->email->to('nipun.sarker@interfabshirt.com'); // change it to yours
            $this->email->subject('OLYMP PTS Report (Auto-Mail)');
            $this->email->message("$content_data");
            $this->email->attach("uploads/mail_attachment/olymp_running_po.xlsx");
            if ($this->email->send()) {

                echo  "<script type='text/javascript'>";
                echo "window.open('', '_self', ''); window.close();";
                echo "</script>";

            } else {
                show_error($this->email->print_debugger());
            }
        }else{
            echo 'File is not exist!';
        }

    }

    public function mailAttachmentOlymp()
    {
//        $data['title']='Production Summary Report HB';
//
//        // Start XML file, create parent node
//        $dom = new DOMDocument("1.0");
//        $node = $dom->createElement("markers");
//        $parnode = $dom->appendChild($node);
//
//        $where = '';
//        $where .= " AND t1.brand in ('BBD', 'BBS', 'BGM', 'BMA', 'BMC', 'BMS', 'BOM', 'HUGO', 'HUM')";
//
//        $prod_summary = $this->dashboard_model->getProductionSummaryReport($where);
//
////        $content_data = $this->load->view('reports/report_file_export', $data);
//
//        $new_row_tbl = '';
//        $new_row = '';
//        $new_row_head = '';
//        $purchase_order_item = '';
//        $exfac_style = '';
//        $wash_gmt_style = '';
//        $cur_date = date('Y-m-d');
//        $cut_balance_qty = 0;
//
//        $new_row_head .= '<tr>
//                        <th class="">PO</th>
//                        <th class="">ITEM</th>
//                        <th class="">Planned Line</th>
//                        <th class="">Lines</th>
//                        <th class="">Brand</span></th>
//                        <th class="">STYLE</th>
//                        <th class="">QLTY-CLR</th>
//                        <th class="">ORDER</th>
//                        <th class="">ExFac</th>
//                        <th class="">CUT</th>
//                        <th class="">CUT BLNC</th>
//                        <th class="">CUT PASS</th>
//                        <th class="">BUNDLE</th>
//                        <th class="">IDENTITY</th>
//                        <th class="">INPUT</th>
//                        <th class="">Collar</th>
//                        <th class="">Cuff</th>
//                        <th class="">MID PASS</th>
//                        <th class="">END PASS</th>
//                        <th class="">WASH</th>
//                        <th class="">PACK</th>
//                        <th class="">CARTON</th>
//                        <th class="">WAREHOUSE BUYER</th>
//                        <th class="">WAREHOUSE FACTORY</th>
//                        <th class="">WAREHOUSE SAMPLE</th>
//                        <th class="">WAREHOUSE TRASH</th>
//                        <th class="">OTHER PURPOSE</th>
//                        <th class="">BALANCE</th>
//                    </tr>';
//
//        $today = date('Y-m-d');
//        $till_date = date("Y-m-d", strtotime("+ 30 days"));
//
//        foreach ($prod_summary as $k => $v){
//            $total_finishing_wh_qa = $v['count_carton_pass'] + $v['count_wh_prod_sample'] + $v['count_wh_factory'] + $v['count_wh_buyer'] + $v['count_wh_trash'];
//            $total_wh_qa = $v['count_wh_prod_sample'] + $v['count_wh_factory'] + $v['count_wh_buyer'] + $v['count_wh_trash'];
//
////            if((($v['total_cut_qty'] - $total_finishing_wh_qa) != 0) && ($v['responsible_line'] != '')){
//            if(($today <= $v['ex_factory_date']) || ($till_date <= $v['ex_factory_date']) || (($v['total_cut_qty'] - $total_finishing_wh_qa) != 0)){
//                $ship_date = $v['ex_factory_date'];
//
//                if($v['item'] == ''){
//                    $item = 'NA';
//                }else{
//                    $item = $v['item'];
//                }
//
//
//                if($v['item'] != ''){
//                    $purchase_order_item = $v['purchase_order'].'_'.$v['item'];
//                }else{
//                    $purchase_order_item = $v['purchase_order'];
//                }
//
//
//
//                if($cur_date > $ship_date){ $exfac_style .= 'style="background-color: #ff481f; color: #fff;"'; }
//                if($v['wash_gmt'] == 1){ $wash_gmt_style .= 'style="background-color: #faff88;"'; }
//                $cut_balance_qty = $v['total_cut_qty']-$v['total_cut_input_qty'];
//                $total_po_item_balance = $v['total_cut_qty'] - $total_finishing_wh_qa;
//
//                $new_row .= '<tr>
//								<td>'.$v["purchase_order"].'</td>
//                                <td>'.$v["item"].'</td>
//                                <td>'.$v["planned_lines"].'</td>
//                                <td>'.$v["responsible_line"].'</td>
//                                <td>'.$v["brand"].'</td>
//                                <td>'.$v["style_no"].'-'.$v["style_name"].'</td>
//                                <td>'.$v["quality"].'_'.$v["color"].'</td>
//                                <td>'.$v["total_order_qty"].'</td>
//                                <td>'.$v["ex_factory_date"].'</td>
//                                <td>'.$v["total_cut_qty"].'</td>
//                                <td>'.$cut_balance_qty.'</td>
//                                <td>'.$v["total_cut_input_qty"].'</td>
//                                <td><span style="color: #ffffff;">'."'".'</span>'.$v["bundle_start"].'-'.$v["bundle_end"].'</td>
//                                <td>'.$v["min_care_label"].'-'.$v["max_care_label"].'</td>
//
//                                <td>'.$v["count_input_qty_line"].'</td>
//
//                                <td>'.$v["collar_bndl_qty"].'</td>
//                                <td>'.$v["cuff_bndl_qty"].'</td>
//                                <td>'.$v["count_mid_line_qc_pass"].'</td>
//                                <td>'.$v["count_end_line_qc_pass"].'</td>
//                                <td>'.$v["count_washing_pass"].'</td>
//                                <td>'.$v["count_packing_pass"].'</td>
//                                <td>'.$v["count_carton_pass"].'</td>
//                                <td>'.$v['count_wh_buyer'].'</td>
//                                <td>'.$v['count_wh_factory'].'</td>
//                                <td>'.$v['count_wh_prod_sample'].'</td>
//                                <td>'.$v['count_wh_trash'].'</td>
//                                <td>'.$v['count_other_purpose'].'</td>
//                                <td>'.$total_po_item_balance.'</td></tr>';
//            }
//        }
//
////        echo '<pre>';
////        print_r($new_row);
////        echo '</pre>';
////        die();
//
////        if($new_row != ''){
//
////            echo $content_data;
//
////        echo file_exists('uploads/mail_attachment/hb_running_po.xlsx');
////        die();
//
//        $new_row_tbl .= '<table border="1"><thead>'.$new_row_head.'</thead><tbody>'.$new_row.'</tbody></table>';
//
//        $excel_handler = fopen ('uploads/mail_attachment/hb_running_po.xls','w') or die("Unable to open file!");
//        fwrite ($excel_handler, $new_row_tbl);
//        fclose ($excel_handler);

        if(file_exists('uploads/mail_attachment/olymp_running_po.xlsx') == 1){
            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'localhost',
                'smtp_port' => 25,
                'smtp_user' => '', // change it to yours
                'smtp_pass' => '', // change it to yours
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'wordwrap' => TRUE
            );

//            $config = Array(
//                'protocol' => 'smtp',
//                'smtp_host' => 'ssl://smtp.gmail.com',
//                'smtp_port' => 465,
//                'smtp_user' => 'ecofab.pts@gmail.com', // change it to yours
//                'smtp_pass' => 'productiontrackingsystem@123', // change it to yours
//                'mailtype' => 'html',
//                'charset' => 'utf-8',
//                'wordwrap' => TRUE
//            );

            $content_data = '';
            $content_data .= 'Dear Sir/Madam,'.'<br />';
            $content_data .= 'Please find the running PO-ITEM from attached file.'.'<br />'.'<br />'.'<br />';
            $content_data .= 'Best Regards'.'<br />';
            $content_data .= 'Ecofab Ltd'.'<br />';
            //$content_data .= 'VIYELLATEX Group, BANGLADESH';

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('pts@interfabshirt.com'); // change it to yours
//            $this->email->from('ecofab.pts@gmail.com'); // change it to yours
//            $this->email->to('nipunsarker56@gmail.com, nipun.sarker@interfabshirt.com');// change it to yours
            $this->email->to('Silke.Wippert@olymp.com');// change it to yours
            $this->email->cc('ahasan-interfab@viyellatexgroup.com, abdullah.khan@viyellatexgroup.com, moazzem.huq@interfabshirt.com, ali.hossain@interfabshirt.com, nesar.ahmed@interfabshirt.com, arif.abdulla@interfabshirt.com, monirul.islam@interfabshirt.com, ecofab.ie@interfabshirt.com, dinendra.sanjeewa@interfabshirt.com, mehedi.hassan@interfabshirt.com, hasnain.mehedi@interfabshirt.com, nipun.sarker@interfabshirt.com, ecofab.itsupport@interfabshirt.com, qa.audit@interfabshirt.com, mostafa.shak@interfabshirt.com, nipunsarker56@gmail.com, shafayet.chowdhury@interfabshirt.com, shehab.ahameed@interfabshirt.com, hasib.hossain@interfabshirt.com, sahil.islam@interfabshirt.com, fahim.ashab@interfabshirt.com');// change it to yours
            $this->email->cc('nipun.sarker@interfabshirt.com');// change it to yours
            $this->email->subject('Olymp PTS Report (Auto-Mail)');
            $this->email->message("$content_data");
            $this->email->attach("uploads/mail_attachment/olymp_running_po.xlsx");
            if($this->email->send())
            {

                echo  "<script type='text/javascript'>";
                echo "window.open('', '_self', ''); window.close();";
                echo "</script>";

            }
            else
            {
                show_error($this->email->print_debugger());
            }
        }else{
            echo 'File is not exist!';
        }

    }

    public function mailAttachmentHBTestMail()
    {
//        $data['title']='Production Summary Report HB';
//
//        // Start XML file, create parent node
//        $dom = new DOMDocument("1.0");
//        $node = $dom->createElement("markers");
//        $parnode = $dom->appendChild($node);
//
//        $where = '';
//        $where .= " AND t1.brand in ('BBD', 'BBS', 'BGM', 'BMA', 'BMC', 'BMS', 'BOM', 'HUGO', 'HUM')";
//
//        $prod_summary = $this->dashboard_model->getProductionSummaryReport($where);

//        $content_data = $this->load->view('reports/report_file_export', $data);

//        $new_row_tbl = '';
//        $new_row = '';
//        $new_row_head = '';
//        $purchase_order_item = '';
//        $exfac_style = '';
//        $wash_gmt_style = '';
//        $cur_date = date('Y-m-d');
//        $cut_balance_qty = 0;

//        $new_row_head .= '<tr>
//                        <th class="">PO</th>
//                        <th class="">ITEM</th>
//                        <th class="">Planned Line</th>
//                        <th class="">Lines</th>
//                        <th class="">Brand</span></th>
//                        <th class="">STYLE</th>
//                        <th class="">QLTY-CLR</th>
//                        <th class="">ORDER</th>
//                        <th class="">ExFac</th>
//                        <th class="">CUT</th>
//                        <th class="">CUT BLNC</th>
//                        <th class="">CUT PASS</th>
//                        <th class="">BUNDLE</th>
//                        <th class="">IDENTITY</th>
//                        <th class="">INPUT</th>
//                        <th class="">Collar</th>
//                        <th class="">Cuff</th>
//                        <th class="">MID PASS</th>
//                        <th class="">END PASS</th>
//                        <th class="">WASH</th>
//                        <th class="">PACK</th>
//                        <th class="">CARTON</th>
//                        <th class="">WAREHOUSE BUYER</th>
//                        <th class="">WAREHOUSE FACTORY</th>
//                        <th class="">WAREHOUSE SAMPLE</th>
//                        <th class="">WAREHOUSE TRASH</th>
//                        <th class="">OTHER PURPOSE</th>
//                        <th class="">BALANCE</th>
//                    </tr>';

//        $today = date('Y-m-d');
//        $till_date = date("Y-m-d", strtotime("+ 30 days"));

//        echo '<pre>';
//        print_r($till_date);
//        echo '</pre>';
//        die();

//        foreach ($prod_summary as $k => $v){
//            $total_finishing_wh_qa = $v['count_carton_pass'] + $v['count_wh_prod_sample'] + $v['count_wh_factory'] + $v['count_wh_buyer'] + $v['count_wh_trash'] + $v['count_other_purpose'];
//            $total_wh_qa = $v['count_wh_prod_sample'] + $v['count_wh_factory'] + $v['count_wh_buyer'] + $v['count_wh_trash'];
//
////            if((($v['total_cut_qty'] - $total_finishing_wh_qa) != 0) && ($v['responsible_line'] != '')){
//            if(($today <= $v['ex_factory_date']) || ($till_date <= $v['ex_factory_date']) || (($v['total_cut_qty'] - $total_finishing_wh_qa) != 0)){
//                $ship_date = $v['ex_factory_date'];
//
//                if($v['item'] == ''){
//                    $item = 'NA';
//                }else{
//                    $item = $v['item'];
//                }
//
//
//                if($v['item'] != ''){
//                    $purchase_order_item = $v['purchase_order'].'_'.$v['item'];
//                }else{
//                    $purchase_order_item = $v['purchase_order'];
//                }
//
//
//
//                if($cur_date > $ship_date){ $exfac_style .= 'style="background-color: #ff481f; color: #fff;"'; }
//                if($v['wash_gmt'] == 1){ $wash_gmt_style .= 'style="background-color: #faff88;"'; }
//                $cut_balance_qty = $v['total_cut_qty']-$v['total_cut_input_qty'];
//                $total_po_item_balance = $v['total_cut_qty'] - $total_finishing_wh_qa;
//
//                $new_row .= '<tr>
//								<td>'.$v["purchase_order"].'</td>
//                                <td>'.$v["item"].'</td>
//                                <td>'.$v["planned_lines"].'</td>
//                                <td>'.$v["responsible_line"].'</td>
//                                <td>'.$v["brand"].'</td>
//                                <td>'.$v["style_no"].'-'.$v["style_name"].'</td>
//                                <td>'.$v["quality"].'_'.$v["color"].'</td>
//                                <td>'.$v["total_order_qty"].'</td>
//                                <td>'.$v["ex_factory_date"].'</td>
//                                <td>'.$v["total_cut_qty"].'</td>
//                                <td>'.$cut_balance_qty.'</td>
//                                <td>'.$v["total_cut_input_qty"].'</td>
//                                <td><span style="color: #ffffff;">'."'".'</span>'.$v["bundle_start"].'-'.$v["bundle_end"].'</td>
//                                <td>'.$v["min_care_label"].'-'.$v["max_care_label"].'</td>
//
//                                <td>'.$v["count_input_qty_line"].'</td>
//
//                                <td>'.$v["collar_bndl_qty"].'</td>
//                                <td>'.$v["cuff_bndl_qty"].'</td>
//                                <td>'.$v["count_mid_line_qc_pass"].'</td>
//                                <td>'.$v["count_end_line_qc_pass"].'</td>
//                                <td>'.$v["count_washing_pass"].'</td>
//                                <td>'.$v["count_packing_pass"].'</td>
//                                <td>'.$v["count_carton_pass"].'</td>
//                                <td>'.$v['count_wh_buyer'].'</td>
//                                <td>'.$v['count_wh_factory'].'</td>
//                                <td>'.$v['count_wh_prod_sample'].'</td>
//                                <td>'.$v['count_wh_trash'].'</td>
//                                <td>'.$v['count_other_purpose'].'</td>
//                                <td>'.$total_po_item_balance.'</td></tr>';
//            }
//        }

//        echo '<pre>';
//        print_r($new_row);
//        echo '</pre>';
//        die();

//        if($new_row != ''){

//            echo $content_data;

//        echo file_exists('uploads/mail_attachment/hb_running_po.xlsx');
//        die();

//        $new_row_tbl .= '<table border="1"><thead>'.$new_row_head.'</thead><tbody>'.$new_row.'</tbody></table>';

//        $excel_handler = fopen ('uploads/mail_attachment/hb_running_po.xls','w') or die("Unable to open file!");
//        fwrite ($excel_handler, $new_row_tbl);
//        fclose ($excel_handler);

        if(file_exists('uploads/mail_attachment/hb_running_po.xlsx') == 1){
            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'webmail.viyellatexgroup.com',
                'smtp_port' => 25,
                'smtp_user' => '', // change it to yours
                'smtp_pass' => '', // change it to yours
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'wordwrap' => TRUE
            );

            $content_data = '';
            $content_data .= 'Dear Sir,'.'<br />';
            $content_data .= 'Please find the running PO-ITEM from attached file.'.'<br />'.'<br />'.'<br />';
            $content_data .= 'Best Regards'.'<br />';
            $content_data .= 'Ecofab Ltd'.'<br />';
            //$content_data .= 'VIYELLATEX Group, BANGLADESH';

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('pts@interfabshirt.com'); // change it to yours
            $this->email->to('ali.hossain@interfabshirt.com, monirul.islam@interfabshirt.com, ecofab.ie@interfabshirt.com, dinendra.sanjeewa@interfabshirt.com, mehedi.hassan@interfabshirt.com, hasnain.mehedi@interfabshirt.com, shafayet.chowdhury@interfabshirt.com, shefat.hossain@interfabshirt.com, nipun.sarker@interfabshirt.com, ecofab.itsupport@interfabshirt.com, qa.audit@interfabshirt.com, mostafa.shak@interfabshirt.com, shafayet.chowdhury@interfabshirt.com, maksudul.hasan@interfabshirt.com, shehab.ahameed@interfabshirt.com');// change it to yours
//            $this->email->to('nipun.sarker@interfabshirt.com');// change it to yours
            $this->email->subject('PTS Test Auto-Mail');
            $this->email->message("$content_data");
            $this->email->attach("uploads/mail_attachment/hb_running_po.xlsx");


            if($this->email->send())
            {
                echo  "<script type='text/javascript'>";
                echo "window.open('', '_self', ''); window.close();";
                echo "</script>";
            }
            else
            {
                show_error($this->email->print_debugger());
            }
        }else{
            echo 'File is not exist!';
        }

    }

    public function mailAttachmentHBLocalMail()
    {
//        $data['title']='Production Summary Report HB';

        // Start XML file, create parent node
//        $dom = new DOMDocument("1.0");
//        $node = $dom->createElement("markers");
//        $parnode = $dom->appendChild($node);
//
//        $where = '';
//        $where .= " AND t1.brand in ('BBD', 'BBS', 'BGM', 'BMA', 'BMC', 'BMS', 'BOM', 'HUGO', 'HUM')";
//
//        $prod_summary = $this->dashboard_model->getProductionSummaryReport($where);
//
////        $content_data = $this->load->view('reports/report_file_export', $data);
//
//        $new_row_tbl = '';
//        $new_row = '';
//        $new_row_head = '';
//        $purchase_order_item = '';
//        $exfac_style = '';
//        $wash_gmt_style = '';
//        $cur_date = date('Y-m-d');
//        $cut_balance_qty = 0;
//
//        $new_row_head .= '<tr>
//                        <th class="">PO</th>
//                        <th class="">ITEM</th>
//                        <th class="">Planned Line</th>
//                        <th class="">Lines</th>
//                        <th class="">Brand</span></th>
//                        <th class="">STYLE</th>
//                        <th class="">QLTY-CLR</th>
//                        <th class="">ORDER</th>
//                        <th class="">ExFac</th>
//                        <th class="">CUT</th>
//                        <th class="">CUT BLNC</th>
//                        <th class="">CUT PASS</th>
//                        <th class="">BUNDLE</th>
//                        <th class="">IDENTITY</th>
//                        <th class="">INPUT</th>
//                        <th class="">Collar</th>
//                        <th class="">Cuff</th>
//                        <th class="">MID PASS</th>
//                        <th class="">END PASS</th>
//                        <th class="">WASH</th>
//                        <th class="">PACK</th>
//                        <th class="">CARTON</th>
//                        <th class="">WAREHOUSE BUYER</th>
//                        <th class="">WAREHOUSE FACTORY</th>
//                        <th class="">WAREHOUSE SAMPLE</th>
//                        <th class="">WAREHOUSE TRASH</th>
//                        <th class="">OTHER PURPOSE</th>
//                        <th class="">BALANCE</th>
//                    </tr>';
//
//        $today = date('Y-m-d');
//        $till_date = date("Y-m-d", strtotime("+ 30 days"));
//
//        foreach ($prod_summary as $k => $v){
//            $total_finishing_wh_qa = $v['count_carton_pass'] + $v['count_wh_prod_sample'] + $v['count_wh_factory'] + $v['count_wh_buyer'] + $v['count_wh_trash'] + $v['count_other_purpose'];
//            $total_wh_qa = $v['count_wh_prod_sample'] + $v['count_wh_factory'] + $v['count_wh_buyer'] + $v['count_wh_trash'];
//
////            if((($v['total_cut_qty'] - $total_finishing_wh_qa) != 0) && ($v['responsible_line'] != '')){
//            if(($today <= $v['ex_factory_date']) || ($till_date <= $v['ex_factory_date']) || (($v['total_cut_qty'] - $total_finishing_wh_qa) != 0)){
//                $ship_date = $v['ex_factory_date'];
//
//                if($v['item'] == ''){
//                    $item = 'NA';
//                }else{
//                    $item = $v['item'];
//                }
//
//
//                if($v['item'] != ''){
//                    $purchase_order_item = $v['purchase_order'].'_'.$v['item'];
//                }else{
//                    $purchase_order_item = $v['purchase_order'];
//                }
//
//
//
//                if($cur_date > $ship_date){ $exfac_style .= 'style="background-color: #ff481f; color: #fff;"'; }
//                if($v['wash_gmt'] == 1){ $wash_gmt_style .= 'style="background-color: #faff88;"'; }
//                $cut_balance_qty = $v['total_cut_qty']-$v['total_cut_input_qty'];
//                $total_po_item_balance = $v['total_cut_qty'] - $total_finishing_wh_qa;
//
//                $new_row .= '<tr>
//								<td>'.$v["purchase_order"].'</td>
//                                <td>'.$v["item"].'</td>
//                                <td>'.$v["planned_lines"].'</td>
//                                <td>'.$v["responsible_line"].'</td>
//                                <td>'.$v["brand"].'</td>
//                                <td>'.$v["style_no"].'-'.$v["style_name"].'</td>
//                                <td>'.$v["quality"].'_'.$v["color"].'</td>
//                                <td>'.$v["total_order_qty"].'</td>
//                                <td>'.$v["ex_factory_date"].'</td>
//                                <td>'.$v["total_cut_qty"].'</td>
//                                <td>'.$cut_balance_qty.'</td>
//                                <td>'.$v["total_cut_input_qty"].'</td>
//                                <td><span style="color: #ffffff;">'."'".'</span>'.$v["bundle_start"].'-'.$v["bundle_end"].'</td>
//                                <td>'.$v["min_care_label"].'-'.$v["max_care_label"].'</td>
//
//                                <td>'.$v["count_input_qty_line"].'</td>
//
//                                <td>'.$v["collar_bndl_qty"].'</td>
//                                <td>'.$v["cuff_bndl_qty"].'</td>
//                                <td>'.$v["count_mid_line_qc_pass"].'</td>
//                                <td>'.$v["count_end_line_qc_pass"].'</td>
//                                <td>'.$v["count_washing_pass"].'</td>
//                                <td>'.$v["count_packing_pass"].'</td>
//                                <td>'.$v["count_carton_pass"].'</td>
//                                <td>'.$v['count_wh_buyer'].'</td>
//                                <td>'.$v['count_wh_factory'].'</td>
//                                <td>'.$v['count_wh_prod_sample'].'</td>
//                                <td>'.$v['count_wh_trash'].'</td>
//                                <td>'.$v['count_other_purpose'].'</td>
//                                <td>'.$total_po_item_balance.'</td></tr>';
//            }
//        }
//
////        echo '<pre>';
////        print_r($new_row);
////        echo '</pre>';
////        die();
//
////        if($new_row != ''){
//
////            echo $content_data;
//
////        echo file_exists('uploads/mail_attachment/hb_running_po.xlsx');
////        die();
//
//        $new_row_tbl .= '<table border="1"><thead>'.$new_row_head.'</thead><tbody>'.$new_row.'</tbody></table>';
//
//        $excel_handler = fopen ('uploads/mail_attachment/hb_running_po.xls','w') or die("Unable to open file!");
//        fwrite ($excel_handler, $new_row_tbl);
//        fclose ($excel_handler);

        if(file_exists('uploads/mail_attachment/hb_running_po.xlsx') == 1) {
            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'webmail.viyellatexgroup.com',
                'smtp_port' => 25,
                'smtp_user' => '', // change it to yours
                'smtp_pass' => '', // change it to yours
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'wordwrap' => TRUE
            );

            $content_data = '';
            $content_data .= 'Dear Sir,' . '<br />';
            $content_data .= 'Please find the running PO-ITEM from attached file.' . '<br />' . '<br />' . '<br />';
            $content_data .= 'Best Regards' . '<br />';
            $content_data .= 'Ecofab Ltd' . '<br />';
            //$content_data .= 'VIYELLATEX Group, BANGLADESH';

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('pts@interfabshirt.com'); // change it to yours
//            $this->email->to('nipun.sarker@interfabshirt.com');// change it to yours
//            $this->email->to('Heinrich_Vinke@hugoboss.com');// change it to yours
            $this->email->to('ahasan-interfab@viyellatexgroup.com, abdullah.khan@viyellatexgroup.com, moazzem.huq@interfabshirt.com, ali.hossain@interfabshirt.com, nesar.ahmed@interfabshirt.com, arif.abdulla@interfabshirt.com, monirul.islam@interfabshirt.com, ecofab.ie@interfabshirt.com, dinendra.sanjeewa@interfabshirt.com, mehedi.hassan@interfabshirt.com, hasnain.mehedi@interfabshirt.com, shafayet.chowdhury@interfabshirt.com, shefat.hossain@interfabshirt.com, nipun.sarker@interfabshirt.com, ecofab.itsupport@interfabshirt.com, qa.audit@interfabshirt.com, mostafa.shak@interfabshirt.com, nipunsarker56@gmail.com, shafayet.chowdhury@interfabshirt.com, maksudul.hasan@interfabshirt.com, shehab.ahameed@interfabshirt.com');// change it to yours
            $this->email->subject('PTS Report (Auto-Mail)');
            $this->email->message("$content_data");
            $this->email->attach("uploads/mail_attachment/hb_running_po.xlsx");
            if ($this->email->send()) {

                echo  "<script type='text/javascript'>";
                echo "window.open('', '_self', ''); window.close();";
                echo "</script>";

            } else {
                show_error($this->email->print_debugger());
            }
        }else{
            echo 'File is not exist!';
        }

    }

    public function mailAttachmentHB()
    {
//        $data['title']='Production Summary Report HB';
//
//        // Start XML file, create parent node
//        $dom = new DOMDocument("1.0");
//        $node = $dom->createElement("markers");
//        $parnode = $dom->appendChild($node);
//
//        $where = '';
//        $where .= " AND t1.brand in ('BBD', 'BBS', 'BGM', 'BMA', 'BMC', 'BMS', 'BOM', 'HUGO', 'HUM')";
//
//        $prod_summary = $this->dashboard_model->getProductionSummaryReport($where);
//
////        $content_data = $this->load->view('reports/report_file_export', $data);
//
//        $new_row_tbl = '';
//        $new_row = '';
//        $new_row_head = '';
//        $purchase_order_item = '';
//        $exfac_style = '';
//        $wash_gmt_style = '';
//        $cur_date = date('Y-m-d');
//        $cut_balance_qty = 0;
//
//        $new_row_head .= '<tr>
//                        <th class="">PO</th>
//                        <th class="">ITEM</th>
//                        <th class="">Planned Line</th>
//                        <th class="">Lines</th>
//                        <th class="">Brand</span></th>
//                        <th class="">STYLE</th>
//                        <th class="">QLTY-CLR</th>
//                        <th class="">ORDER</th>
//                        <th class="">ExFac</th>
//                        <th class="">CUT</th>
//                        <th class="">CUT BLNC</th>
//                        <th class="">CUT PASS</th>
//                        <th class="">BUNDLE</th>
//                        <th class="">IDENTITY</th>
//                        <th class="">INPUT</th>
//                        <th class="">Collar</th>
//                        <th class="">Cuff</th>
//                        <th class="">MID PASS</th>
//                        <th class="">END PASS</th>
//                        <th class="">WASH</th>
//                        <th class="">PACK</th>
//                        <th class="">CARTON</th>
//                        <th class="">WAREHOUSE BUYER</th>
//                        <th class="">WAREHOUSE FACTORY</th>
//                        <th class="">WAREHOUSE SAMPLE</th>
//                        <th class="">WAREHOUSE TRASH</th>
//                        <th class="">OTHER PURPOSE</th>
//                        <th class="">BALANCE</th>
//                    </tr>';
//
//        $today = date('Y-m-d');
//        $till_date = date("Y-m-d", strtotime("+ 30 days"));
//
//        foreach ($prod_summary as $k => $v){
//            $total_finishing_wh_qa = $v['count_carton_pass'] + $v['count_wh_prod_sample'] + $v['count_wh_factory'] + $v['count_wh_buyer'] + $v['count_wh_trash'];
//            $total_wh_qa = $v['count_wh_prod_sample'] + $v['count_wh_factory'] + $v['count_wh_buyer'] + $v['count_wh_trash'];
//
////            if((($v['total_cut_qty'] - $total_finishing_wh_qa) != 0) && ($v['responsible_line'] != '')){
//            if(($today <= $v['ex_factory_date']) || ($till_date <= $v['ex_factory_date']) || (($v['total_cut_qty'] - $total_finishing_wh_qa) != 0)){
//                $ship_date = $v['ex_factory_date'];
//
//                if($v['item'] == ''){
//                    $item = 'NA';
//                }else{
//                    $item = $v['item'];
//                }
//
//
//                if($v['item'] != ''){
//                    $purchase_order_item = $v['purchase_order'].'_'.$v['item'];
//                }else{
//                    $purchase_order_item = $v['purchase_order'];
//                }
//
//
//
//                if($cur_date > $ship_date){ $exfac_style .= 'style="background-color: #ff481f; color: #fff;"'; }
//                if($v['wash_gmt'] == 1){ $wash_gmt_style .= 'style="background-color: #faff88;"'; }
//                $cut_balance_qty = $v['total_cut_qty']-$v['total_cut_input_qty'];
//                $total_po_item_balance = $v['total_cut_qty'] - $total_finishing_wh_qa;
//
//                $new_row .= '<tr>
//								<td>'.$v["purchase_order"].'</td>
//                                <td>'.$v["item"].'</td>
//                                <td>'.$v["planned_lines"].'</td>
//                                <td>'.$v["responsible_line"].'</td>
//                                <td>'.$v["brand"].'</td>
//                                <td>'.$v["style_no"].'-'.$v["style_name"].'</td>
//                                <td>'.$v["quality"].'_'.$v["color"].'</td>
//                                <td>'.$v["total_order_qty"].'</td>
//                                <td>'.$v["ex_factory_date"].'</td>
//                                <td>'.$v["total_cut_qty"].'</td>
//                                <td>'.$cut_balance_qty.'</td>
//                                <td>'.$v["total_cut_input_qty"].'</td>
//                                <td><span style="color: #ffffff;">'."'".'</span>'.$v["bundle_start"].'-'.$v["bundle_end"].'</td>
//                                <td>'.$v["min_care_label"].'-'.$v["max_care_label"].'</td>
//
//                                <td>'.$v["count_input_qty_line"].'</td>
//
//                                <td>'.$v["collar_bndl_qty"].'</td>
//                                <td>'.$v["cuff_bndl_qty"].'</td>
//                                <td>'.$v["count_mid_line_qc_pass"].'</td>
//                                <td>'.$v["count_end_line_qc_pass"].'</td>
//                                <td>'.$v["count_washing_pass"].'</td>
//                                <td>'.$v["count_packing_pass"].'</td>
//                                <td>'.$v["count_carton_pass"].'</td>
//                                <td>'.$v['count_wh_buyer'].'</td>
//                                <td>'.$v['count_wh_factory'].'</td>
//                                <td>'.$v['count_wh_prod_sample'].'</td>
//                                <td>'.$v['count_wh_trash'].'</td>
//                                <td>'.$v['count_other_purpose'].'</td>
//                                <td>'.$total_po_item_balance.'</td></tr>';
//            }
//        }
//
////        echo '<pre>';
////        print_r($new_row);
////        echo '</pre>';
////        die();
//
////        if($new_row != ''){
//
////            echo $content_data;
//
////        echo file_exists('uploads/mail_attachment/hb_running_po.xlsx');
////        die();
//
//        $new_row_tbl .= '<table border="1"><thead>'.$new_row_head.'</thead><tbody>'.$new_row.'</tbody></table>';
//
//        $excel_handler = fopen ('uploads/mail_attachment/hb_running_po.xls','w') or die("Unable to open file!");
//        fwrite ($excel_handler, $new_row_tbl);
//        fclose ($excel_handler);

        if(file_exists('uploads/mail_attachment/hb_running_po.xlsx') == 1){
//            $config = Array(
//                'protocol' => 'smtp',
//                'smtp_host' => 'localhost',
//                'smtp_port' => 25,
//                'smtp_user' => '', // change it to yours
//                'smtp_pass' => '', // change it to yours
//                'mailtype' => 'html',
//                'charset' => 'utf-8',
//                'wordwrap' => TRUE
//            );

            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://smtp.gmail.com',
                'smtp_port' => 465,
                'smtp_user' => 'ecofab.pts@gmail.com', // change it to yours
                'smtp_pass' => 'productiontrackingsystem@123', // change it to yours
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'wordwrap' => TRUE
            );

            $content_data = '';
            $content_data .= 'Dear Sir,'.'<br />';
            $content_data .= 'Please find the running PO-ITEM from attached file.'.'<br />'.'<br />'.'<br />';
            $content_data .= 'Best Regards'.'<br />';
            $content_data .= 'Ecofab Ltd'.'<br />';
            //$content_data .= 'VIYELLATEX Group, BANGLADESH';

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
//            $this->email->from('pts@interfabshirt.com'); // change it to yours
            $this->email->from('ecofab.pts@gmail.com'); // change it to yours
//            $this->email->from('ecofab.pts@interfabshirt.com'); // change it to yours
//            $this->email->to('nipunsarker56@gmail.com, nipun.sarker@interfabshirt.com');// change it to yours
//            $this->email->to('Heinrich_Vinke@hugoboss.com');// change it to yours
//            $this->email->cc('ahasan-interfab@viyellatexgroup.com, abdullah.khan@viyellatexgroup.com, moazzem.huq@interfabshirt.com, yaman.hasanat@viyellatexgroup.com, ali.hossain@interfabshirt.com, nesar.ahmed@interfabshirt.com, arif.abdulla@interfabshirt.com, monirul.islam@interfabshirt.com, ecofab.ie@interfabshirt.com, dinendra.sanjeewa@interfabshirt.com, athula.bandara@interfabshirt.com, mehedi.hassan@interfabshirt.com, hasnain.mehedi@interfabshirt.com, faijul.haque@interfabshirt.com, shafayet.chowdhury@interfabshirt.com, shefat.hossain@interfabshirt.com, nipun.sarker@interfabshirt.com, ecofab.itsupport@interfabshirt.com, qa.audit@interfabshirt.com, mostafa.shak@interfabshirt.com, nipunsarker56@gmail.com, shafayet.chowdhury@interfabshirt.com, maksudul.hasan@interfabshirt.com, shehab.ahameed@interfabshirt.com');// change it to yours
            $this->email->to('Galya_Milcheva@hugoboss.com, Diego_Quadrelli@hugoboss.com, nipun.sarker@interfabshirt.com, maksudul.hasan@interfabshirt.com, nipunsarker56@gmail.com, ecofab.itsupport@interfabshirt.com');// change it to yours
            $this->email->subject('PTS Report (Auto-Mail)');
            $this->email->message("$content_data");
            $this->email->attach("uploads/mail_attachment/hb_running_po.xlsx");
            if($this->email->send())
            {

                echo  "<script type='text/javascript'>";
                echo "window.open('', '_self', ''); window.close();";
                echo "</script>";

            }
            else
            {
                show_error($this->email->print_debugger());
            }
        }else{
            echo 'File is not exist!';
        }

    }

    public function poWiseSizeReport()
    {

        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['title'] = 'PO Wise Packing Report';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['access_points'] = $this->session->userdata('access_points');

        $get_data['purchase_order_nos'] = $this->access_model->getAllPurchaseOrders();

        $data['maincontent'] = $this->load->view('reports/po_wise_packing_report', $get_data, true);
        $this->load->view('reports/master', $data);

    }

    public function deleteTblData($tbl, $date){
        $this->dashboard_model->deleteTblData($tbl, $date);
    }

    public function insertTblData($tbl, $data){
        $this->dashboard_model->insertTblData($tbl, $data);
    }

    public function production_summary_report_mail()
    {
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $previous_date = date( "Y-m-d", strtotime( $date . "-1 day"));
        //      $previous_date = date('Y-m-d');
        $data['previous_date'] = $previous_date;

        $time_range = $this->dashboard_model->getWorkingTimeRange();

        $starting_time = $time_range[0]['starting_time'];
        $ending_time = $time_range[0]['ending_time'];

        $data['cutting_target'] = $this->dashboard_model->getCuttingTarget($previous_date);
        $data['cutting_prod'] = $this->dashboard_model->getCuttingTotalProductionReport($previous_date, $starting_time, $ending_time);
//        $data['cutting_normal_prod'] = $this->dashboard_model->getCuttingExtraProductionReport($previous_date, $starting_time, $ending_time);
        $data['line_prod'] = $this->dashboard_model->getLineProductionSummaryReport($previous_date, $starting_time, $ending_time);
        $data['finishing_prod'] = $this->dashboard_model->getFinishingProductionSummaryReport($previous_date, $starting_time, $ending_time);

        $mail_content = $this->load->view('reports/production_summary_report_mail_body', $data, true);

        $count_line_output=0;
        $count_finishing_output=0;
        foreach ($data['line_prod'] as $v_l){
            $count_line_output += $v_l['total_line_output'];
        }

        foreach ($data['finishing_prod'] as $v_2){
            $count_finishing_output += $v_2['total_finishing_output'];
        }

        if($count_line_output != 0 && $count_finishing_output != 0){
            $new_row_tbl = '';
            $new_row_tbl .= "$mail_content";

            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'webmail.viyellatexgroup.com',
                'smtp_port' => 25,
                'smtp_user' => '', // change it to yours
                'smtp_pass' => '', // change it to yours
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'wordwrap' => TRUE
            );

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('pts@interfabshirt.com'); // change it to yours
//            $this->email->to('nipun.sarker@interfabshirt.com');// change it to yours
            $this->email->to('ahasan-interfab@viyellatexgroup.com');// change it to yours
            $this->email->cc('abdullah.khan@viyellatexgroup.com, yaman.hasanat@viyellatexgroup.com, moazzem.huq@interfabshirt.com, ali.hossain@interfabshirt.com, nesar.ahmed@interfabshirt.com, arif.abdulla@interfabshirt.com, mahesh.hewage@interfabshirt.com, monirul.islam@interfabshirt.com, ecofab.ie@interfabshirt.com, dinendra.sanjeewa@interfabshirt.com, mehedi.hassan@interfabshirt.com, hasnain.mehedi@interfabshirt.com, shafayet.chowdhury@interfabshirt.com, shefat.hossain@interfabshirt.com, nipun.sarker@interfabshirt.com, ecofab.itsupport@interfabshirt.com, qa.audit@interfabshirt.com, mostafa.shak@interfabshirt.com, shafayet.chowdhury@interfabshirt.com, shehab.ahameed@interfabshirt.com, sahil.islam@interfabshirt.com, maksudul.hasan@interfabshirt.com');// change it to yours
            $this->email->subject('PTS Summary Report (Auto-Mail)');
            $this->email->message("$new_row_tbl");
            if($this->email->send())
            {
                echo  "<script type='text/javascript'>";
                echo "window.open('', '_self', ''); window.close();";
                echo "</script>";
            }
            else
            {
                show_error($this->email->print_debugger());
            }
        }else{
            echo 'No Output Found!';
        }

    }

    public function generate_production_summary_report()
    {
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $previous_date = date( "Y-m-d", strtotime( $date . "-1 day"));
//        $previous_date = "2020-03-16";
        $data['previous_date'] = $previous_date;

//        echo '<pre>';
//        print_r($previous_date);
//        echo '</pre>';
//
//        die();

        $time_range = $this->dashboard_model->getWorkingTimeRange();

        $starting_time = $time_range[0]['starting_time'];
        $ending_time = $time_range[0]['ending_time'];

        $where_seg = "";
        if($starting_time != '' && $ending_time != ''){
            $where_seg .= "  ORDER BY id DESC LIMIT 1";
        }

        $data['segments'] = $this->dashboard_model->getSegments($where_seg);

        $data['hour_ranges'] = $this->access_model->getHours();

        $data['lines'] = $this->dashboard_model->getAllLines();

        $data['cutting_target'] = $this->dashboard_model->getCuttingTarget($previous_date);
        $data['cutting_prod'] = $this->dashboard_model->getCuttingTotalPackageReport($previous_date);
//        $data['cutting_prod'] = $this->dashboard_model->getCuttingTotalProductionReport($previous_date, $starting_time, $ending_time);
//        $data['cutting_normal_prod'] = $this->dashboard_model->getCuttingExtraProductionReport($previous_date, $starting_time, $ending_time);

//        $data['line_prod'] = $this->dashboard_model->getLineProductionSummaryReportNew($previous_date, $starting_time, $ending_time);

        $data['finishing_prod'] = $this->dashboard_model->getFinishingProductionSummaryReport($previous_date, $starting_time, $ending_time);


        echo $mail_content = $this->load->view('reports/production_summary_report_mail_body_new', $data, true);


        $count_finishing_output=0;

        foreach ($data['finishing_prod'] as $v_2){
            $count_finishing_output += $v_2['total_finishing_output'];
        }

//        echo '<pre>';
//        print_r($count_finishing_output);
//        echo '</pre>';
//        die();

//        if($count_finishing_output != 0){
//            $new_row_tbl = '';
//            $new_row_tbl .= "$mail_content";
//
//            $config = Array(
//                'protocol' => 'smtp',
//                'smtp_host' => 'webmail.viyellatexgroup.com',
//                'smtp_port' => 25,
//                'smtp_user' => '', // change it to yours
//                'smtp_pass' => '', // change it to yours
//                'mailtype' => 'html',
//                'charset' => 'utf-8',
//                'wordwrap' => TRUE
//            );
//
//            $this->load->library('email', $config);
//            $this->email->set_newline("\r\n");
//            $this->email->from('pts@interfabshirt.com'); // change it to yours
////            $this->email->to('nipun.sarker@interfabshirt.com');// change it to yours
//            $this->email->to('ahasan-interfab@viyellatexgroup.com');// change it to yours
//            $this->email->cc('abdullah.khan@viyellatexgroup.com, yaman.hasanat@viyellatexgroup.com, moazzem.huq@interfabshirt.com, ali.hossain@interfabshirt.com, nesar.ahmed@interfabshirt.com, arif.abdulla@interfabshirt.com, monirul.islam@interfabshirt.com, ecofab.ie@interfabshirt.com, dinendra.sanjeewa@interfabshirt.com, athula.bandara@interfabshirt.com, mehedi.hassan@interfabshirt.com, hasnain.mehedi@interfabshirt.com, faijul.haque@interfabshirt.com, shafayet.chowdhury@interfabshirt.com, shefat.hossain@interfabshirt.com, nipun.sarker@interfabshirt.com, ecofab.itsupport@interfabshirt.com, qa.audit@interfabshirt.com, mostafa.shak@interfabshirt.com, shafayet.chowdhury@interfabshirt.com, shehab.ahameed@interfabshirt.com, sahil.islam@interfabshirt.com, maksudul.hasan@interfabshirt.com');// change it to yours
//            $this->email->subject('PTS Summary Report (Auto-Mail)');
//            $this->email->message("$new_row_tbl");
//            if($this->email->send())
//            {
//                echo  "<script type='text/javascript'>";
//                echo "window.open('', '_self', ''); window.close();";
//                echo "</script>";
//            }
//            else
//            {
//                show_error($this->email->print_debugger());
//            }
//        }else{
//            echo 'No Output Found!';
//        }

        if($mail_content != ''){
            echo  "<script type='text/javascript'>";
            echo "window.open('', '_self', ''); window.close();";
            echo "</script>";
        }
    }

    public function production_summary_report_mail_new()
    {
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $previous_date = date( "Y-m-d", strtotime( $date . "-1 day"));
//        $previous_date = "2019-10-08";
        $data['previous_date'] = $previous_date;
        $data['line_report']=$this->dashboard_model->getLineReport($previous_date, '');

        $cutting_prod=$this->dashboard_model->getCuttingReport($previous_date);

        if(sizeof($cutting_prod) > 0){
            $data['cutting_prod'] = $cutting_prod;
        }else{

            $this->lastDayCuttingReportBackup($previous_date);

            $cutting_prod = $this->dashboard_model->getCuttingReport($previous_date);

            $data['cutting_prod'] = $cutting_prod;

        }

        $finishing_prod = $this->dashboard_model->getFinishingReport($previous_date);

        if(sizeof($finishing_prod)){
            $data['finishing_report'] = $finishing_prod;
        }else{
            $this->lastDayFinishingReportBackup($previous_date);

            $finishing_prod = $this->dashboard_model->getFinishingReport($previous_date);

            $data['finishing_report'] = $finishing_prod;
        }



        /* Total Efficiency Calculation Start */
        $floor_eff_sum=0;
        $floor_count=0;

        $floor_efficiency_array = array();

        $floors = $this->access_model->getFloors();

//        $floor_count = sizeof($floors);

        foreach ($floors as $vf){
            $floor_id = $vf['id'];

            $floor_sum_efficiency = 0;
            $floor_efficiency = 0;
            $line_count = 0;

            $where = '';
            $where .= " AND floor=$floor_id";
//
            $lines = $this->dashboard_model->getAllLinesByCondition($where);

//            $line_count = sizeof($lines);

            foreach ($lines as $vl){

                $where_1 = '';

                $line_id = $vl['id'];
                $where_1 .= " AND line_id=$line_id";

                $line_output_report = $this->dashboard_model->getLineReport($previous_date, $where_1);

                if($line_output_report[0]['efficiency'] > 0){
                    $floor_sum_efficiency += $line_output_report[0]['efficiency'];

                    $line_count++;
                }

                $floor_efficiency = round($floor_sum_efficiency/$line_count, 2);
            }

            array_push($floor_efficiency_array, $floor_efficiency);
        }

        foreach ($floor_efficiency_array as $ve){
            if($ve > 0){
                $floor_eff_sum += $ve;

                $floor_count++;
            }
        }

        $floor_line_efficiency = round($floor_eff_sum/$floor_count, 2);

        $data['total_line_efficiency']=$floor_line_efficiency;

        /* Total Efficiency Calculation End */

        $mail_content = $this->load->view('reports/production_summary_report_mail_new_check', $data, true);


//        echo '<pre>';
//        print_r($mail_content);
//        echo '</pre>';
//        die();

        if($floor_line_efficiency > 0){
            $new_row_tbl = '';
            $new_row_tbl .= "$mail_content";

            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'webmail.viyellatexgroup.com',
                'smtp_port' => 25,
                'smtp_user' => '', // change it to yours
                'smtp_pass' => '', // change it to yours
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'wordwrap' => TRUE
            );

//            $from_email = "noreply@interfabshirt.com";
////            $from_email = "kabir14235@gmail.com";
//            $to_email = $this->input->post('email');
//            $this->load->library('email', $config);

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('pts@interfabshirt.com'); // change it to yours
//            $this->email->to('nipun.sarker@interfabshirt.com');// change it to yours
            $this->email->to('ahasan-interfab@viyellatexgroup.com');// change it to yours
            $this->email->cc('abdullah.khan@viyellatexgroup.com, yaman.hasanat@viyellatexgroup.com, moazzem.huq@interfabshirt.com, ali.hossain@interfabshirt.com, nesar.ahmed@interfabshirt.com, arif.abdulla@interfabshirt.com, mahesh.hewage@interfabshirt.com, monirul.islam@interfabshirt.com, ecofab.ie@interfabshirt.com, dinendra.sanjeewa@interfabshirt.com, mehedi.hassan@interfabshirt.com, hasnain.mehedi@interfabshirt.com, shafayet.chowdhury@interfabshirt.com, shefat.hossain@interfabshirt.com, nipun.sarker@interfabshirt.com, ecofab.itsupport@interfabshirt.com, qa.audit@interfabshirt.com, mostafa.shak@interfabshirt.com, shehab.ahameed@interfabshirt.com, maksudul.hasan@interfabshirt.com, tanzir.hassan@interfabshirt.com');// change it to yours
            $this->email->subject('PTS Summary Report (Auto-Mail)');
            $this->email->message("$new_row_tbl");
            if($this->email->send())
            {
                echo "Mail Sent";
            }
            else
            {
                show_error($this->email->print_debugger());
            }
        }else{
            echo 'No Output Found!';
        }

        echo  "<script type='text/javascript'>";
        echo "window.open('', '_self', ''); window.close();";
        echo "</script>";
    }

    public function second_floor_production_summary_report_mail_new()
    {
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $previous_date = date( "Y-m-d", strtotime( $date . "-1 day"));
//        $previous_date = date('Y-m-d');
//        $previous_date = '2019-10-26';
        $data['previous_date'] = $previous_date;

        $condition = '';
        $condition .= " AND floor in (2)";

        $condition2 = '';
        $condition2 .= " AND floor_id in (2)";


        $cutting_prod = $this->dashboard_model->getCuttingReport($previous_date);

        if(sizeof($cutting_prod) > 0){
            $data['cutting_prod'] = $cutting_prod;
        }else{

            $this->lastDayCuttingReportBackup($previous_date);

            $cutting_prod = $this->dashboard_model->getCuttingReport($previous_date);

            $data['cutting_prod'] = $cutting_prod;

        }

        $data['line_prod'] = $this->dashboard_model->getSecondFloorLineProductionSummary($previous_date, $condition);

        $finishing_prod = $this->dashboard_model->getSecondFloorFinishingProductionSummary($previous_date,  $condition2);

        if(sizeof($finishing_prod)){
            $data['finishing_prod'] = $finishing_prod;
        }else{
            $this->lastDayFinishingReportBackup($previous_date);

            $finishing_prod = $this->dashboard_model->getSecondFloorFinishingProductionSummary($previous_date,  $condition2);

            $data['finishing_prod'] = $finishing_prod;
        }

        $mail_content = $this->load->view('reports/second_floor_production_summary_report_mail_body', $data, true);


        $count_finishing_output=0;
        $count_line_output=0;

        foreach ($data['line_prod'] as $v_1){
            $count_line_output += $v_1['output'];
        }

        foreach ($data['finishing_prod'] as $v_2){
            $count_finishing_output += $v_2['output'];
        }

        if( $count_line_output != 0){
            $new_row_tbl = '';
            $new_row_tbl .= "$mail_content";

            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://smtp.gmail.com',
                'smtp_port' => 465,
                'smtp_user' => 'ecofab.pts@gmail.com', // change it to yours
                'smtp_pass' => 'productiontrackingsystem@123', // change it to yours
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'wordwrap' => TRUE
            );

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('ecofab.pts@gmail.com'); // change it to yours
            $this->email->to('Silke.Wippert@olymp.com'); // change it to yours
            $this->email->cc('nipun.sarker@interfabshirt.com');// change it to yours
//            $this->email->to('ahasan-interfab@viyellatexgroup.com');// change it to yours
//            $this->email->cc('abdullah.khan@viyellatexgroup.com, yaman.hasanat@viyellatexgroup.com, moazzem.huq@interfabshirt.com, ali.hossain@interfabshirt.com, nesar.ahmed@interfabshirt.com, arif.abdulla@interfabshirt.com, monirul.islam@interfabshirt.com, ecofab.ie@interfabshirt.com, dinendra.sanjeewa@interfabshirt.com, athula.bandara@interfabshirt.com, mehedi.hassan@interfabshirt.com, hasnain.mehedi@interfabshirt.com, faijul.haque@interfabshirt.com, shafayet.chowdhury@interfabshirt.com, shefat.hossain@interfabshirt.com, nipun.sarker@interfabshirt.com, ecofab.itsupport@interfabshirt.com, qa.audit@interfabshirt.com, mostafa.shak@interfabshirt.com, shafayet.chowdhury@interfabshirt.com, shehab.ahameed@interfabshirt.com, sahil.islam@interfabshirt.com, maksudul.hasan@interfabshirt.com');// change it to yours
            $this->email->subject('Second Floor PTS Summary Report (Auto-Mail)');
            $this->email->message("$new_row_tbl");
            if($this->email->send())
            {
                echo "Mail Sent";
            }
            else
            {
                show_error($this->email->print_debugger());
            }
        }else{
            echo 'No Output Found!';
        }

        echo  "<script type='text/javascript'>";
        echo "window.open('', '_self', ''); window.close();";
        echo "</script>";

    }

    public function lastDayCuttingReportBackup($previous_date){
        $cutting_target = $this->dashboard_model->getCuttingTarget($previous_date);
        $cutting_prod = $this->dashboard_model->getCuttingTotalPackageReport($previous_date);

        $data_c = array(
            'cut_target' => ($cutting_target[0]['target'] != '' ? $cutting_target[0]['target'] : 0),
            'cut_output' => ($cutting_prod[0]['cut_complete_qty'] != '' ? $cutting_prod[0]['cut_complete_qty'] : 0),
            'cut_package_ready' => ($cutting_prod[0]['package_ready_qty'] != '' ? $cutting_prod[0]['package_ready_qty'] : 0),
            'date' => $previous_date
        );

        return $this->insertTblData('tb_daily_cut_summary', $data_c);
    }

    public function lastDayFinishingReportBackup($previous_date){
        $time_range = $this->dashboard_model->getWorkingTimeRange();

        $starting_time = $time_range[0]['starting_time'];
        $ending_time = $time_range[0]['ending_time'];

        $where_seg = "";
        if($starting_time != '' && $ending_time != ''){
            $where_seg .= "  ORDER BY id DESC LIMIT 1";
        }

        $finishing_prod = $this->dashboard_model->getFinishingProductionSummaryReport($previous_date, $starting_time, $ending_time);

        foreach ($finishing_prod as $f) {

            $over_time_finish_qty = $f['total_finishing_output'] - $f['finishing_normal_hours_output'];

            $data_f = array(

                'floor_id' => ($f['finishing_floor_id'] != '' ? $f['finishing_floor_id'] : 0),
                'target' => ($f['target'] != '' ? $f['target'] : 0),
                'normal_output' => ($f['finishing_normal_hours_output'] != 0 ? $f['finishing_normal_hours_output'] : 0),
                'eot_output' => ($over_time_finish_qty != '' ? $over_time_finish_qty : 0),
                'output' => ($f['total_finishing_output'] != '' ? $f['total_finishing_output'] : 0),
                'date' => $previous_date

            );
            $this->insertTblData('tb_daily_finish_summary', $data_f);
        }

        return 1;
    }

    public function packageReadyByPO()
    {
        $data['title'] = 'PO LIST FOR READY PACKAGE';
//        $data['user_name'] = $this->session->userdata('user_name');
//        $data['access_points'] = $this->session->userdata('access_points');

        $data['purchase_order_nos'] = $this->access_model->getAllPurchaseOrders();

        $data['pending_po_package_list'] = $this->dashboard_model->getPendingPOPackage();

        $data['maincontent'] = $this->load->view('package_ready_by_po', $data, true);
        $this->load->view('reports/master', $data);
    }

    public function getReadyPackageByPo()
    {
        $purchase_order_stuff = $this->input->post('purchase_order_stuff');
        $purchase_order_stuff_array = explode('_', $purchase_order_stuff);

        $so_no = $purchase_order_stuff_array[0];
        $po_no = $purchase_order_stuff_array[1];
        $purchase_order = $purchase_order_stuff_array[2];
        $item_week = $purchase_order_stuff_array[3];
        $color = $purchase_order_stuff_array[4];
        $ex_factory = $purchase_order_stuff_array[5];

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
        if($item_week != ''){
            $where .= " AND item = '$item_week'";
        }
        if($color != ''){
            $where .= " AND color = '$color'";
        }
        if($ex_factory != ''){
            $where .= " AND ex_factory_date = '$ex_factory'";
        }
        $get_data['package_info'] = $this->dashboard_model->getReadyPackageByPo($where);

        $maincontent = $this->load->view('get_ready_package_by_po', $get_data, true);

        echo $maincontent;
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

    }
        if($part == 'Package'){
            $where .= " AND is_package_ready = 0 ";

        }

        if($part == 'Back'){
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
        $get_data['order_size'] = $this->dashboard_model->getRemainingPart($where);

//        $maincontent = $this->load->view('po_item_wise_size_end_pass_report', $get_data, true);
        $maincontent = $this->load->view('po_item_wise_back_part_report', $get_data, true);

        echo $maincontent;
    }

    public function getLinePerformanceSummary($line_id, $date, $start_time, $end_time){
        return $this->access_model->getLineOutputReport($line_id, $date, $start_time, $end_time);
    }

    public function getLineDhuSumReport($line_id, $date){
        return $this->access_model->getLineDhuSumReport($line_id, $date);
    }

    public function second_floor_production_summary_report_mail()
    {
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $previous_date = date( "Y-m-d", strtotime( $date . "-1 day"));
//        $previous_date = date('Y-m-d');
        $data['previous_date'] = $previous_date;

        $time_range = $this->dashboard_model->getWorkingTimeRange();

        $starting_time = $time_range[0]['starting_time'];
        $ending_time = $time_range[0]['ending_time'];

        $condition = '';
        $condition .= " AND floor in (2)";

        $condition2 = '';
        $condition2 .= " AND id in (2)";

        $data['cutting_target'] = $this->dashboard_model->getCuttingTarget($previous_date);
        $data['cutting_prod'] = $this->dashboard_model->getCuttingTotalProductionReport($previous_date, $starting_time, $ending_time);
//        $data['cutting_normal_prod'] = $this->dashboard_model->getCuttingExtraProductionReport($previous_date, $starting_time, $ending_time);
        $data['line_prod'] = $this->dashboard_model->getSecondFloorLineProductionSummaryReport($previous_date, $starting_time, $ending_time, $condition);
        $data['finishing_prod'] = $this->dashboard_model->getSecondFloorFinishingProductionSummaryReport($previous_date, $starting_time, $ending_time, $condition2);

        $mail_content = $this->load->view('reports/second_floor_production_summary_report_mail_body', $data, true);

        $count_line_output=0;
        $count_finishing_output=0;
        foreach ($data['line_prod'] as $v_l){
            $count_line_output += $v_l['total_line_output'];
        }

        foreach ($data['finishing_prod'] as $v_2){
            $count_finishing_output += $v_2['total_finishing_output'];
        }

        if($count_line_output != 0 && $count_finishing_output !=0){
            $new_row_tbl = '';
            $new_row_tbl .= "$mail_content";

            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'localhost',
                'smtp_port' => 25,
                'smtp_user' => '', // change it to yours
                'smtp_pass' => '', // change it to yours
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'wordwrap' => TRUE
            );

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('pts@interfabshirt.com'); // change it to yours
            $this->email->to('Silke.Wippert@olymp.com'); // change it to yours
//            $this->email->to('nipun.sarker@interfabshirt.com');// change it to yours
//            $this->email->cc('');// change it to yours
//            $this->email->to('ahasan-interfab@viyellatexgroup.com');// change it to yours
//            $this->email->cc('abdullah.khan@viyellatexgroup.com, yaman.hasanat@viyellatexgroup.com, moazzem.huq@interfabshirt.com, ali.hossain@interfabshirt.com, nesar.ahmed@interfabshirt.com, arif.abdulla@interfabshirt.com, monirul.islam@interfabshirt.com, ecofab.ie@interfabshirt.com, dinendra.sanjeewa@interfabshirt.com, athula.bandara@interfabshirt.com, mehedi.hassan@interfabshirt.com, hasnain.mehedi@interfabshirt.com, faijul.haque@interfabshirt.com, shafayet.chowdhury@interfabshirt.com, shefat.hossain@interfabshirt.com, nipun.sarker@interfabshirt.com, ecofab.itsupport@interfabshirt.com, qa.audit@interfabshirt.com, mostafa.shak@interfabshirt.com, shafayet.chowdhury@interfabshirt.com, shehab.ahameed@interfabshirt.com, maksudul.hasan@interfabshirt.com');// change it to yours
            $this->email->subject('PTS Summary Report (Auto-Mail)');
            $this->email->message("$new_row_tbl");
            if($this->email->send())
            {
                echo  "<script type='text/javascript'>";
                echo "window.open('', '_self', ''); window.close();";
                echo "</script>";
            }
            else
            {
                show_error($this->email->print_debugger());
            }
        }else{
            echo 'No Output Found!';
        }

    }

    public function second_floor_production_summary_report_mail_test()
    {
//        $previous_date = date('Y-m-d',strtotime("-1 days"));
        $previous_date = date('Y-m-d');
        $data['previous_date'] = $previous_date;

        $time_range = $this->dashboard_model->getWorkingTimeRange();

        $starting_time = $time_range[0]['starting_time'];
        $ending_time = $time_range[0]['ending_time'];

        $condition = '';
        $condition .= " AND floor in (2)";

        $condition2 = '';
        $condition2 .= " AND id in (2)";

        $data['cutting_target'] = $this->dashboard_model->getCuttingTarget($previous_date);
        $data['cutting_prod'] = $this->dashboard_model->getCuttingTotalProductionReport($previous_date, $starting_time, $ending_time);
        $data['cutting_normal_prod'] = $this->dashboard_model->getCuttingExtraProductionReport($previous_date, $starting_time, $ending_time);
        $data['line_prod'] = $this->dashboard_model->getSecondFloorLineProductionSummaryReport($previous_date, $starting_time, $ending_time, $condition);
        $data['finishing_prod'] = $this->dashboard_model->getSecondFloorFinishingProductionSummaryReport($previous_date, $starting_time, $ending_time, $condition2);

        $mail_content = $this->load->view('reports/second_floor_production_summary_report_mail_body', $data, true);


        $count_line_output=0;
        $count_finishing_output=0;
        foreach ($data['line_prod'] as $v_l){
            $count_line_output += $v_l['total_line_output'];
        }

        foreach ($data['finishing_prod'] as $v_2){
            $count_finishing_output += $v_2['total_finishing_output'];
        }

        if($count_line_output != 0 && $count_finishing_output !=0){
            $new_row_tbl = '';
            $new_row_tbl .= "$mail_content";

            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'localhost',
                'smtp_port' => 25,
                'smtp_user' => '', // change it to yours
                'smtp_pass' => '', // change it to yours
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'wordwrap' => TRUE
            );

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('pts@interfabshirt.com'); // change it to yours
            $this->email->to('nipunsarker56@gmail.com'); // change it to yours
//            $this->email->to('nipun.sarker@interfabshirt.com');// change it to yours
//            $this->email->cc('');// change it to yours
//            $this->email->to('ahasan-interfab@viyellatexgroup.com');// change it to yours
//            $this->email->cc('abdullah.khan@viyellatexgroup.com, yaman.hasanat@viyellatexgroup.com, moazzem.huq@interfabshirt.com, ali.hossain@interfabshirt.com, nesar.ahmed@interfabshirt.com, arif.abdulla@interfabshirt.com, monirul.islam@interfabshirt.com, ecofab.ie@interfabshirt.com, dinendra.sanjeewa@interfabshirt.com, athula.bandara@interfabshirt.com, mehedi.hassan@interfabshirt.com, hasnain.mehedi@interfabshirt.com, faijul.haque@interfabshirt.com, shafayet.chowdhury@interfabshirt.com, shefat.hossain@interfabshirt.com, nipun.sarker@interfabshirt.com, ecofab.itsupport@interfabshirt.com, qa.audit@interfabshirt.com, mostafa.shak@interfabshirt.com, shafayet.chowdhury@interfabshirt.com, shehab.ahameed@interfabshirt.com, maksudul.hasan@interfabshirt.com');// change it to yours
            $this->email->subject('PTS Summary Report (Auto-Mail)');
            $this->email->message("$new_row_tbl");
            if($this->email->send())
            {
                echo  "<script type='text/javascript'>";
                echo "window.open('', '_self', ''); window.close();";
                echo "</script>";
            }
            else
            {
                show_error($this->email->print_debugger());
            }
        }else{
            echo 'No Output Found!';
        }

    }

    public function package_ready_report(){
        $data['title']='Ready Package';

        $data['ready_package'] = $this->dashboard_model->getLineReadyPackageReport();

        $data['maincontent'] = $this->load->view('reports/line_ready_package_report', $data, true);
        $this->load->view('reports/master', $data);
    }

    public function getPoCuttingReadyPackageDetail($plan_line_id, $line_code){
        $data['title']='Line Wise Cut Ready Package';

        $data['plan_line'] = $line_code;
        $data['ready_package_pos'] = $this->dashboard_model->getLineReadyPackageDetailReport($plan_line_id);

        $data['maincontent'] = $this->load->view('reports/line_ready_package_report_detail', $data, true);
        $this->load->view('reports/master', $data);
    }

    public function getPoCutToSewReadyPackageDetail($plan_line_id, $line_code){
        $data['title']='Line Cut To Sew Package';

        $data['plan_line'] = $line_code;
        $data['ready_package_pos'] = $this->dashboard_model->getPoCutToSewReadyPackageDetail($plan_line_id);

        $data['maincontent'] = $this->load->view('reports/line_ready_package_report_detail', $data, true);
        $this->load->view('reports/master', $data);
    }

    public function dailyPerformanceReportNew(){
        $data['title']='Daily Performance Report';

        $data['maincontent'] = $this->load->view('reports/daily_performance_report_new', $data, true);
        $this->load->view('reports/master', $data);
    }

    public function dailyPerformanceReport(){
        $data['title']='Daily Performance Report';

        $data['maincontent'] = $this->load->view('reports/daily_performance_report', $data, true);
        $this->load->view('reports/master', $data);
    }

    public function getDailySummaryReportByDate(){
        $department = $this->input->post('department');
        $search_date = $this->input->post('date');
        $data['search_date'] = $search_date;

//        $data['cutting_prod'] = $this->dashboard_model->getDailyCutProductionSummaryReport($search_date);
//        $data['line_prod'] = $this->dashboard_model->getDailyLineProductionSummaryReport($search_date);
//        $data['finishing_prod'] = $this->dashboard_model->getDailyFinishingProductionSummaryReport($search_date);
//
//        echo $content = $this->load->view('reports/daily_performance_report_by_date', $data);

        if($department == 'finishing'){
            $data['finishing_prod'] = $this->dashboard_model->getDailyFinishingProductionSummaryReport($search_date);

            echo $content = $this->load->view('reports/daily_finishing_performance_report_by_date', $data);
        }

        if($department == 'cutting'){
            $data['cutting_target'] = $this->dashboard_model->getCuttingTarget($search_date);

//            $data['cutting_prod'] = $this->dashboard_model->getDailyCutProductionSummaryReport($search_date);
            $data['cutting_prod'] = $this->dashboard_model->getCuttingTotalPackageReport($search_date);

//            echo $content = $this->load->view('reports/daily_cutting_performance_report_by_date', $data);
            echo $content = $this->load->view('reports/daily_cutting_performance_report_by_today', $data);
        }

        if($department == 'sewing'){
            $data['line_prod'] = $this->dashboard_model->getDailyLineProductionSummaryReport($search_date);

            echo $content = $this->load->view('reports/daily_sewing_performance_report_by_date', $data);
        }
    }

    public function getDailySummaryReportByDateToday(){
        $search_date = $this->input->post('date');
        $data['search_date'] = $search_date;

        $time_range = $this->dashboard_model->getWorkingTimeRange();

        $starting_time = $time_range[0]['starting_time'];
        $ending_time = $time_range[0]['ending_time'];

        $data['cutting_target'] = $this->dashboard_model->getCuttingTarget($search_date);
        $data['cutting_prod'] = $this->dashboard_model->getCuttingTotalProductionReport($search_date, $starting_time, $ending_time);
        $data['cutting_normal_prod'] = $this->dashboard_model->getCuttingExtraProductionReport($search_date, $starting_time, $ending_time);
        $data['line_prod'] = $this->dashboard_model->getLineProductionSummaryReport($search_date, $starting_time, $ending_time);
        $data['finishing_prod'] = $this->dashboard_model->getFinishingProductionSummaryReport($search_date, $starting_time, $ending_time);

        echo $content = $this->load->view('reports/daily_performance_report_by_date_today', $data);
    }

    public function getDailyReportByDateToday(){
        $department = $this->input->post('department');
        $search_date = $this->input->post('date');
        $data['search_date'] = $search_date;

        $time_range = $this->dashboard_model->getWorkingTimeRange();

        $starting_time = $time_range[0]['starting_time'];
        $ending_time = $time_range[0]['ending_time'];

//        $data['cutting_target'] = $this->dashboard_model->getCuttingTarget($search_date);
//        $data['cutting_prod'] = $this->dashboard_model->getCuttingTotalProductionReport($search_date, $starting_time, $ending_time);
//        $data['cutting_normal_prod'] = $this->dashboard_model->getCuttingExtraProductionReport($search_date, $starting_time, $ending_time);
//        $data['line_prod'] = $this->dashboard_model->getLineProductionSummaryReport($search_date, $starting_time, $ending_time);

        $where='';

        if($department == 'finishing'){
            $data['finishing_prod'] = $this->dashboard_model->getFinishingProductionReport($search_date, $starting_time, $ending_time);

            echo $content = $this->load->view('reports/daily_finishing_performance_report_by_today', $data);
        }

        if($department == 'cutting'){
            $data['cutting_target'] = $this->dashboard_model->getCuttingTarget($search_date);
//            $data['cutting_prod'] = $this->dashboard_model->getCuttingTotalProductionReport($search_date, $starting_time, $ending_time); //Last Query
//            $data['cutting_normal_prod'] = $this->dashboard_model->getCuttingExtraProductionReport($search_date, $starting_time, $ending_time);

            $data['cutting_prod'] = $this->dashboard_model->getCuttingTotalPackageReport($search_date);

            echo $content = $this->load->view('reports/daily_cutting_performance_report_by_today', $data);
        }

        if($department == 'sewing'){
            //Previous Query
//            $data['line_prod'] = $this->dashboard_model->getTodayLineProductionSummaryReportPre($search_date, $starting_time, $ending_time);

            $where .= " Order By floor_code DESC";

            $data['floors'] = $this->access_model->getFloors($where);

//            $data['line_prod'] = $this->dashboard_model->getTodayLineProductionSummaryReport($search_date, $starting_time, $ending_time);

            echo $content = $this->load->view('reports/daily_sewing_performance_report_by_today', $data);
        }
    }

    public function getTodayLineProductionSummaryReport($search_date, $floor_id){
        return $data['line_prod'] = $this->dashboard_model->getTodayLineProductionSummaryReport($search_date, $floor_id);
    }

    public function getDailyPerformanceDetail($line_name, $line_id, $search_date){
        $data['title']='Production Report Detail';

        $data['line_name'] = $line_name;
        $data['search_date'] = $search_date;

        $data['performance_detail'] = $this->dashboard_model->getDailyPerformanceDetail($line_id, $search_date);

        $data['maincontent'] = $this->load->view('reports/line_daily_performance_report_detail', $data, true);
        $this->load->view('reports/master', $data);
    }

    public function lineWiseWipDetailReport($line_name, $line_id, $search_date){
        $data['line_id'] = $line_id;
        $data['line_name'] = $line_name;
        $data['search_date'] = $search_date;

        $data['wip_detail'] = $this->dashboard_model->lineWiseWipDetailReport($line_id, $search_date);

        $data['maincontent'] = $this->load->view('reports/line_wise_wip_detail_report', $data, true);
        $this->load->view('reports/master', $data);
    }

    public function getWorkTime($line_id, $date){

        if($line_id != ''){

            $min_max_hours = $this->access_model->getMinMaxHours();
            $min_start_time = $min_max_hours[0]['min_start_time'];
            $max_end_time = $min_max_hours[0]['max_end_time'];

            $work_time = $this->access_model->getWorkingHours($line_id, $date, $min_start_time);

        }

        return $work_time[0]['working_time_diff_to_sec'];

    }

    public function getManPower($line_id, $date){

        $where='';

        if($line_id != ''){
            $where .= " AND line_id=$line_id AND date='$date'";
            $line_trgt = $this->access_model->getLineTarget($where);

            $man_power = $line_trgt[0]['man_power'];
        }

        return $man_power;

    }

    public function getSmvList($line_id, $date){

        if($line_id != ''){

            $get_smv_list = $this->access_model->getSMVs($line_id, $date);

        }

        return $get_smv_list;

    }

//    public function mailAttachmentHB()
//    {
//        $data['title']='Production Summary Report HB';
//
//        // Start XML file, create parent node
//        $dom = new DOMDocument("1.0");
//        $node = $dom->createElement("markers");
//        $parnode = $dom->appendChild($node);
//
//
//        $prod_summary = $this->dashboard_model->getProductionSummaryReport();
//
////        $content_data = $this->load->view('reports/report_file_export', $data);
//
//        $new_row_tbl = '';
//        $new_row = '';
//        $new_row_head = '';
//        $purchase_order_item = '';
//        $exfac_style = '';
//        $wash_gmt_style = '';
//        $cur_date = date('Y-m-d');
//        $cut_balance_qty = 0;
//
//        $new_row_head .= '<tr>
//                        <th class="">PO</th>
//                        <th class="">ITEM</th>
//                        <th class="">Lines</th>
//                        <th class="">Brand</span></th>
//                        <th class="">STYLE</th>
//                        <th class="">QLTY-CLR</th>
//                        <th class="">ORDER</th>
//                        <th class="">ExFac</th>
//                        <th class="">CUT</th>
//                        <th class="">CUT BLNC</th>
//                        <th class="">CUT PASS</th>
//                        <th class="">BUNDLE</th>
//                        <th class="">IDENTITY</th>
//                        <th class="">INPUT</th>
//                        <th class="">Collar</th>
//                        <th class="">Cuff</th>
//                        <th class="">MID PASS</th>
//                        <th class="">END PASS</th>
//                        <th class="">WASH</th>
//                        <th class="">PACK</th>
//                        <th class="">CARTON</th>
//                        <th class="">WAREHOUSE</th>
//                        <th class="">BALANCE</th>
//                    </tr>';
//
//        foreach ($prod_summary as $k => $v){
//            $total_finishing_wh_qa = $v['count_carton_pass'] + $v['count_wh_prod_sample'] + $v['count_wh_factory'] + $v['count_wh_buyer'] + $v['count_wh_trash'];
//            $total_wh_qa = $v['count_wh_prod_sample'] + $v['count_wh_factory'] + $v['count_wh_buyer'] + $v['count_wh_trash'];
//
//            if((($v['total_cut_qty'] - $total_finishing_wh_qa) != 0) && ($v['responsible_line'] != '')){
//                $ship_date = $v['ex_factory_date'];
//
//                if($v['item'] == ''){
//                    $item = 'NA';
//                }else{
//                    $item = $v['item'];
//                }
//
//
//                if($v['item'] != ''){
//                    $purchase_order_item = $v['purchase_order'].'_'.$v['item'];
//                }else{
//                    $purchase_order_item = $v['purchase_order'];
//                }
//
//
//
//                if($cur_date > $ship_date){ $exfac_style .= 'style="background-color: #ff481f; color: #fff;"'; }
//                if($v['wash_gmt'] == 1){ $wash_gmt_style .= 'style="background-color: #faff88;"'; }
//                $cut_balance_qty = $v['total_cut_qty']-$v['total_cut_input_qty'];
//                $total_po_item_balance = $v['total_cut_qty'] - $total_finishing_wh_qa;
//
//                $new_row .= '<tr>
//								<td>'.$v["purchase_order"].'</td>
//                                <td>'.$v["item"].'</td>
//                                <td>'.$v["responsible_line"].'</td>
//                                <td>'.$v["brand"].'</td>
//                                <td>'.$v["style_no"].'-'.$v["style_name"].'</td>
//                                <td>'.$v["quality"].'_'.$v["color"].'</td>
//                                <td>'.$v["total_order_qty"].'</td>
//                                <td>'.$v["ex_factory_date"].'</td>
//                                <td>'.$v["total_cut_qty"].'</td>
//                                <td>'.$cut_balance_qty.'</td>
//                                <td>'.$v["total_cut_input_qty"].'</td>
//                                <td><span style="color: #ffffff;">'."'".'</span>'.$v["bundle_start"].'-'.$v["bundle_end"].'</td>
//                                <td>'.$v["min_care_label"].'-'.$v["max_care_label"].'</td>
//
//                                <td>'.$v["count_input_qty_line"].'</td>
//
//                                <td>'.$v["collar_bndl_qty"].'</td>
//                                <td>'.$v["cuff_bndl_qty"].'</td>
//                                <td>'.$v["count_mid_line_qc_pass"].'</td>
//                                <td>'.$v["count_end_line_qc_pass"].'</td>
//                                <td>'.$v["count_washing_pass"].'</td>
//                                <td>'.$v["count_packing_pass"].'</td>
//                                <td>'.$v["count_carton_pass"].'</td>
//                                <td>'.$total_wh_qa.'</td>
//                                <td>'.$total_po_item_balance.'</td></tr>';
//            }
//        }
//
////        echo '<pre>';
////        print_r($new_row);
////        echo '</pre>';
////        die();
//
////        if($new_row != ''){
//
////            echo $content_data;
//
////        echo file_exists('uploads/mail_attachment/hb_running_po.xlsx');
////        die();
//
//        $new_row_tbl .= '<table border="1"><thead>'.$new_row_head.'</thead><tbody>'.$new_row.'</tbody></table>';
//
//        $excel_handler = fopen ('uploads/mail_attachment/hb_running_po.xls','w') or die("Unable to open file!");
//        fwrite ($excel_handler, $new_row_tbl);
//        fclose ($excel_handler);
//
//            echo 'Data saved to hb_running_po.xls';
//
////            $config = Array(
////                'protocol' => 'smtp',
////                'smtp_host' => '10.234.20.22',
////                'smtp_port' => 25,
////                'smtp_user' => '', // change it to yours
////                'smtp_pass' => '', // change it to yours
////                'mailtype' => 'html',
////                'charset' => 'utf-8',
////                'wordwrap' => TRUE
////            );
////
////
////            $this->load->library('email', $config);
////            $this->email->set_newline("\r\n");
////            $this->email->from('noreply@interfabshirt.com'); // change it to yours
////            $this->email->to('nipun.sarker@interfabshirt.com');// change it to yours
////            $this->email->subject('PTS Test Mail');
////            $this->email->message("$content_data");
////            if($this->email->send())
////            {
////                echo 'Email sent.';
////            }
////            else
////            {
////                show_error($this->email->print_debugger());
////            }
//
////        }
//    }

    public function send_mail(){
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => '10.234.20.22',
            'smtp_port' => 25,
            'smtp_user' => '', // change it to yours
            'smtp_pass' => '', // change it to yours
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE
        );

        $message = '';
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('noreply@interfabshirt.com'); // change it to yours
        $this->email->to('nipun.sarker@interfabshirt.com');// change it to yours
        $this->email->subject('Test Mail');
        $this->email->message($message);
        if($this->email->send())
        {
            echo 'Email sent.';
        }
        else
        {
            show_error($this->email->print_debugger());
        }
    }


    public function getProductionSummaryReportDashboard(){
        $data['prod_summary'] = $this->dashboard_model->getProductionSummaryReport();
        $data['maincontent'] = $this->load->view('reports/care_label_line_prod_summary_report_dashboard', $data);
    }

    public function remainQtyStatus($sap_no, $purchase_order, $item, $status){

        $where = '';

        if($sap_no != ''){
            $where .= " AND A.po_no LIKE '%$sap_no%'";
        }

        if($purchase_order != ''){
            $where .= " AND A.purchase_order LIKE '%$purchase_order%'";
        }

        if($item != '' && $item != 'NA'){
            $where .= " AND A.item LIKE '%$item%'";
        }

        $where .= " AND A.packing_status != 1";

        echo $data['remain_detail'] = $this->access_model->remainQtyStatus($where);

        $data['maincontent'] = $this->load->view('reports/remain_qty_report', $data, true);
        $this->load->view('reports/master', $data);
    }

    public function poWisePackingReport(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['title'] = 'PO Wise Packing Report';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['access_points'] = $this->session->userdata('access_points');

        $get_data['purchase_order_nos'] = $this->access_model->getAllPurchaseOrders();

        $data['maincontent'] = $this->load->view('po_wise_packing_report', $get_data, true);
        $this->load->view('master', $data);
    }

    public function lineInputReportChartPre(){
        $data['title'] = 'Line Pass Report';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['access_points'] = $this->session->userdata('access_points');

        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');
//        $date='2017-12-24';

        $data['date'] = $date;

        $where = '';

        $data['line_report'] = $this->dashboard_model->getLineInputReportForChart($date);

        $data['maincontent'] = $this->load->view('reports/line_graph_report_new', $data);
//        $this->load->view('master_line', $data);
    }

    public function lineInputReportChart(){
        $data['title'] = 'Line Pass Report';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['access_points'] = $this->session->userdata('access_points');

        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');
//        $date='2018-11-17';

        $data['date'] = $date;

        $where = '';

        $data['line_report'] = $this->dashboard_model->getLineInputReportForChart($date);

        $data['maincontent'] = $this->load->view('reports/line_graph_report_n', $data);
//        $this->load->view('master_line', $data);
    }

    public function cuttingTableWiseReport($date){
        $data['title'] = 'Cut-Table Report';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['user_description'] = $this->session->userdata('user_description');
        $data['access_points'] = $this->session->userdata('access_points');

        $data['date'] = $date;

        $data['table_report'] = $this->dashboard_model->cuttingTableWiseDailyReport($date);

        $this->load->view('cutting_table_wise_report', $data);
    }

    public function cutting_table_wise_report_detail($table){
        echo '<pre>';
        print_r($table);
        echo '</pre>';
    }

    public function lineInputReportChart_1(){
        $data['title'] = 'Line Pass Report';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['access_points'] = $this->session->userdata('access_points');

        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');
//        $date='2017-12-24';

        $data['date'] = $date;

        $where = '';

        $data['line_report'] = $this->dashboard_model->getLineInputReportForChart($date);

        $this->load->view('reports/line_report', $data);
    }

    public function getCutVsOutputReport(){
        $data['title'] = 'Cut Vs Output Report';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['access_points'] = $this->session->userdata('access_points');

        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');
//        $date='2017-12-24';

        $year_month = $this->input->post('year_month');

        $data['year_month'] = $year_month;

        if($year_month != '' && $year_month != '1970-01'){
            $cut_output_report = $this->dashboard_model->getCutVsOutputReport($year_month);
        }

        echo json_encode($cut_output_report);
    }

    public function lineInputReport(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $get_data['title'] = 'Line Input Report';
        $get_data['date'] = $date;
        $get_data['line_input_report'] = $this->dashboard_model->getLineInputReport($date);

        $data['maincontent'] = $this->load->view('reports/line_input_report', $get_data, true);
        $this->load->view('reports/master', $data);
    }

    public function lineInputQty($line_id){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $get_data['heading_title'] = 'Line Input Report';
        $get_data['order_info'] = $this->dashboard_model->lineInputQty($line_id, $date);

        $data['maincontent'] = $this->load->view('reports/all_pcs_line', $get_data);
    }

    public function lineWipQty($line_id){
        $get_data['heading_title'] = 'Line WIP Report';
        $get_data['order_info'] = $this->dashboard_model->lineWipQty($line_id);

        $data['maincontent'] = $this->load->view('reports/all_pcs_line', $get_data);
    }

    public function lineWIPDetailReport($line, $date){
//        echo '<pre>';
//        print_r("WIP Detail report will be shown here of $line");
//        echo '</pre>';
        $get_data['heading_title'] = 'Line WIP Report';
        $line_info = $this->access_model->getLineId($line);
        $line_id = $line_info[0]['id'];
        $get_data['order_info'] = $this->dashboard_model->lineWipQty($line_id);

        $data['maincontent'] = $this->load->view('reports/all_pcs_line', $get_data);
    }

    public function midQcPass($line_id){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $get_data['heading_title'] = 'Mid Line Pass Report';
        $get_data['order_info'] = $this->dashboard_model->midQcPass($line_id, $date);

        $data['maincontent'] = $this->load->view('reports/all_pcs_line', $get_data);
    }

    public function midQcDefects($line_id){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $get_data['heading_title'] = 'Mid Line Defect Report';
        $get_data['order_info'] = $this->dashboard_model->midQcDefects($line_id, $date);

        $data['maincontent'] = $this->load->view('reports/all_pcs_line', $get_data);
    }

    public function midQcRejects($line_id){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $get_data['heading_title'] = 'Mid Line Reject Report';
        $get_data['order_info'] = $this->dashboard_model->midQcRejects($line_id, $date);

        $data['maincontent'] = $this->load->view('reports/all_pcs_line', $get_data);
    }

    public function endQcPass($line_id){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $get_data['heading_title'] = 'End Line Pass Report';
        $get_data['order_info'] = $this->dashboard_model->endQcPass($line_id, $date);

        $data['maincontent'] = $this->load->view('reports/all_pcs_line', $get_data);
    }

    public function endQcDefects($line_id){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $get_data['heading_title'] = 'End Line Defect Report';
        $get_data['order_info'] = $this->dashboard_model->endQcDefects($line_id, $date);

        $data['maincontent'] = $this->load->view('reports/all_pcs_line', $get_data);
    }

    public function endQcRejects($line_id){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $get_data['heading_title'] = 'End Line Reject Report';
        $get_data['order_info'] = $this->dashboard_model->endQcRejects($line_id, $date);

        $data['maincontent'] = $this->load->view('reports/all_pcs_line', $get_data);
    }

    public function cutPackageReportChart(){
        $data['title'] = 'Cutting Dashboard';

        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');
//        $date='2017-12-24';

        $data['date'] = $date;

        $where = '';

//        $data['cut_wip_report'] = $this->dashboard_model->getCuttingReportForChart($date);

        $this->load->view('reports/line_wip_graph_report', $data);
    }

    public function tableWiseLayCutReport(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['date'] = $date;
        $data['table_report'] = $this->dashboard_model->cuttingTableWiseDailyReport($date);

        $this->load->view('reports/table_wise_lay_cut_report', $data);
    }

    public function getCuttingTargetVsAchievementReport(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['date'] = $date;
        $data['cut_target_actual'] = $this->dashboard_model->getCuttingTargetVsAchievementReport($date);

        $this->load->view('reports/cutting_target_vs_actual_report', $data);
    }

    public function layCutPackageReadySummaryReport(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

//        $data['cut_ready_package'] = $this->dashboard_model->getCuttingReadyPackageQty();
//        $data['today_no_of_marker'] = $this->dashboard_model->getTodayNumberOfMarker($date);
//        $data['today_no_of_garments'] = $this->dashboard_model->getTodayNumberOfGarment($date);
//        $data['today_cut_ready_package'] = $this->dashboard_model->getTodayPackageReadyQty($date);
//        $data['today_cut'] = $this->dashboard_model->getTodayCutQty($date);
//        $data['lay_qty'] = $this->dashboard_model->getLayQty();

        $data['cut_dashboard_report'] = $this->dashboard_model->getCuttingDashboardReport($date);

        $this->load->view('reports/lay_cut_package_summary_report', $data);
    }

    public function getStyleTypeWiseCuttingReport(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

//        START MARKER REPORT STYLE TYPE WISE (SOLID=1, CHECK=2, PRINT=3)
        $data['today_no_of_marker'] = $this->dashboard_model->getTodayNumberOfMarkerByStyleType($date);
//        END MARKER REPORT STYLE TYPE WISE (SOLID=1, CHECK=2, PRINT=3)

//        START GARMENTS/RATIO REPORT STYLE TYPE WISE (SOLID=1, CHECK=2, PRINT=3)
        $data['today_no_of_garments'] = $this->dashboard_model->getTodayNumberOfGarmentByStyleType($date);
//        END GARMENTS/RATIO REPORT STYLE TYPE WISE (SOLID=1, CHECK=2, PRINT=3)

//        START CUT REPORT STYLE TYPE WISE (SOLID=1, CHECK=2, PRINT=3)
        $data['today_cut'] = $this->dashboard_model->getTodayCutQtyByStyleType($date);
//        END CUT REPORT STYLE TYPE WISE (SOLID=1, CHECK=2, PRINT=3)

//        START LAY REPORT STYLE TYPE WISE (SOLID=1, CHECK=2, PRINT=3)
        $data['lay_qty'] = $this->dashboard_model->getLayQtyByStyleType();
//        END LAY REPORT STYLE TYPE WISE (SOLID=1, CHECK=2, PRINT=3)

        $this->load->view('reports/style_type_wise_cutting_report', $data);
    }

    public function getBuyerWiseCuttingReport(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['date'] = $date;
        $data['cutting_buyers'] = $this->dashboard_model->getCuttingReportBuyers($date);

//        $data['buyer_cut_dashboard_report'] = $this->dashboard_model->getBuyerWiseCuttingDashboardReport($date);

        $this->load->view('reports/buyer_wise_cutting_report', $data);
    }

    public function getBuyerWiseCuttingDashboardReport($brand){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        return $this->dashboard_model->getBuyerWiseCuttingDashboardReport($date, $brand);
    }

    public function viewClDefects($pc_tracking_no, $line_id, $access_point){
        $data['title'] = "CL Defects List";
        $data['heading_title'] = "$pc_tracking_no - Defects List";

        $data['cl_defect_report'] = $this->access_model->viewClDefects($pc_tracking_no, $line_id, $access_point);

        $data['maincontent'] = $this->load->view('reports/cl_defect_list', $data, true);
        $this->load->view('reports/master', $data);
    }

    public function lineSummaryReport(){
//        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
//        
//        $date_time=$datex->format('Y-m-d H:i:s');
//        $date=$datex->format('Y-m-d');

        $get_data['title'] = 'Line Summary Report';
//        $get_data['date'] = $date;
//        $get_data['line_input_report'] = $this->access_model->getLineInputReport($date);

        $data['maincontent'] = $this->load->view('reports/line_summary_report', $get_data);
    }

    public function lineDefectReportChart(){
        $data['title'] = 'Line Defect Report';

        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');
//        $date='2017-12-24';

        $data['date'] = $date;

        $where = '';

        $data['line_def_report'] = $this->dashboard_model->getLineDefectReportForChart($date);

        $this->load->view('reports/line_defect_report', $data);
    }

    public function poWiseCuttingReport(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['title'] = 'PO Wise Cutting Report';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['access_points'] = $this->session->userdata('access_points');

        $get_data['purchase_order_nos'] = $this->access_model->getAllPurchaseOrders();

//        $get_data['order_info'] = $this->access_model->getPoOrderInfo($date);

        $data['maincontent'] = $this->load->view('reports/po_wise_cutting_report', $get_data, true);
        $this->load->view('reports/master', $data);
    }

    public function getPoWiseReportbyPoNo(){
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

    public function getPoWiseReportbyPo(){
        $purchase_order_stuff = $this->input->post('purchase_order_stuff');

        $purchase_order_stuff_array = explode('_', $purchase_order_stuff);

        $po_no = $purchase_order_stuff_array[0];
        $item_week = $purchase_order_stuff_array[1];
        $color = $purchase_order_stuff_array[2];

        $where = '';
        if($po_no != ''){
            $where .= " AND A.purchase_order LIKE '%$po_no%'";
        }
        if($item_week != ''){
            $where .= " AND A.item LIKE '%$item_week%'";
        }
        if($color != ''){
            $where .= " AND A.color LIKE '%$color%'";
        }

        $get_data['order_info'] = $this->dashboard_model->getPoOrderInfobyPo($where);

        $maincontent = $this->load->view('reports/po_wise_cutting_report_by_po', $get_data, true);

        echo $maincontent;
    }

    public function getBundleSummary(){
        $purchase_order_stuff = $this->input->post('purchase_order_stuff');
        $cut_no = $this->input->post('cut_no');

        $purchase_order_stuff_array = explode('_', $purchase_order_stuff);

        $sap_no = $purchase_order_stuff_array[0];
        $po_no = $purchase_order_stuff_array[1];
        $item_week = $purchase_order_stuff_array[2];
        $color = $purchase_order_stuff_array[3];

        $where = '';
        if($sap_no != ''){
            $where .= " AND po_no = '$sap_no'";
        }
        if($po_no != ''){
            $where .= " AND purchase_order = '$po_no'";
        }
        if($item_week != ''){
            $where .= " AND item = '$item_week'";
        }
        if($color != ''){
            $where .= " AND color = '$color'";
        }
        if($cut_no != ''){
            $where .= " AND cut_no = '$cut_no'";
        }

        $data['po'] = $po_no;
        $data['item'] = $item_week;
        $data['cut_order_summary'] = $this->dashboard_model->getBundleSummary($where);

        echo $maincontent = $this->load->view('reports/bundle_summary_tbl', $data, true);
    }

    public function poItemSizeCutLayerWiseQty($po_no, $purchase_order, $item, $size, $cut_no, $cut_layer){
        $cut_order_qty = $this->access_model->poItemSizeCutLayerWiseQty($po_no, $purchase_order, $item, $size, $cut_no, $cut_layer);

        return $cut_order_qty;
    }

    public function sizeCutLayerWisePoItems($po_no, $size, $cut_no, $cut_layer){
        $cut_order = $this->access_model->sizeCutLayerWisePoItems($po_no, $size, $cut_no, $cut_layer);

        return $cut_order;
    }

    public function getPackingReportbyPo(){
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

        $get_data['order_info'] = $this->dashboard_model->getPoOrderPackingInfobyPo($where);


        $maincontent = $this->load->view('po_wise_size_cutting_report', $get_data, true);

        echo $maincontent;
    }

    public function getPoItemWiseSizeReport(){
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
        if($color != ''){
            $where .= " AND t1.color LIKE '%$color%'";
        }
        $get_data['order_size'] = $this->dashboard_model->getPoItemWiseSizeReport($where);

        $maincontent = $this->load->view('reports/po_item_wise_size_report', $get_data, true);

        echo $maincontent;
    }

    public function getWarehousePcs(){
        $po_no = $this->input->post('po_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');

        $where = '';
        if($po_no != ''){
            $where .= " AND t1.po_no = '$po_no'";
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
        if($color != ''){
            $where .= " AND t1.color = '$color'";
        }
        $get_data['order_size'] = $this->dashboard_model->getPoItemWiseWarehouseSizeReport($where);

        $maincontent = $this->load->view('reports/po_item_wise_size_warehouse_report', $get_data, true);

        echo $maincontent;
    }

    public function getWarehouseSizePcs(){
        $po_no = $this->input->post('po_no');
        $so_no = $this->input->post('so_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');
        $size = $this->input->post('size');

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
        if($color != ''){
            $where .= " AND t1.color LIKE '%$color%'";
        }
        if($size != ''){
            $where .= " AND t1.size = '$size'";
        }
        $get_data['order_size'] = $this->dashboard_model->getPoItemWiseWarehouseSizeReport($where);

        $maincontent = $this->load->view('reports/po_item_wise_size_warehouse_report', $get_data, true);

        echo $maincontent;
    }

    public function dailyPackageReport()
    {
        $data['title']='Daily Package Report';

        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');
        $data['date']=$date;

        $data['maincontent'] = $this->load->view('reports/daily_package_report', $data, true);
        $this->load->view('reports/master', $data);
    }

    public function getPackageDetailReport(){
        $date = $this->input->post('date');

        $data['date'] = $date;

        $where = '';

        if($date != ''){
            $where .= " AND DATE_FORMAT(package_ready_date_time, '%Y-%m-%d')='$date'";
        }

//        $data['fusing_report'] = $this->dashboard_model->getDailyFusingReport($date);
        $data['fusing_report'] = $this->dashboard_model->getReadyPackageByPo($where);

        echo $data['maincontent'] = $this->load->view('reports/daily_package_summary_report', $data);

    }

    public function print_bundle_summary_page(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['title'] = 'Print Bundle Summary';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['access_points'] = $this->session->userdata('access_points');

        $data['purchase_order_nos'] = $this->access_model->getAllPurchaseOrders();
        $data['cut_no'] = $this->access_model->getCutNoList();

        $data['maincontent'] = $this->load->view('reports/print_bundle_summary_page', $data, true);
        $this->load->view('reports/master', $data);
    }

    public function lineWisePoItemReport(){
        $data['title'] = 'Line Wise PO-Item Report';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['access_points'] = $this->session->userdata('access_points');

        $data['lines'] = $this->access_model->getLines();

        $data['maincontent'] = $this->load->view('reports/line_wise_po_item_report', $data, true);
        $this->load->view('reports/master', $data);
    }

    public function lineHourlyReport(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $time=$datex->format('H:i:s');
        $min=$datex->format('i');
        $date=$datex->format('Y-m-d');

        $data['min_to_hour']=round($min / 60, 2);
        $data['time']=$time;

        $segments = $this->access_model->getSegments($time);

        $segment_id=$segments[0]['id'];
        $data['segment_id']=$segment_id;

        $data['title'] = 'Today Line Hourly Report';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['access_points'] = $this->session->userdata('access_points');

        $data['hours'] = $this->access_model->getHours();
        $data['lines'] = $this->access_model->getLines();
        $data['floors'] = $this->access_model->getFloors();

        $where = '';
        if($time != ''){
            $where .= " AND '$time' between start_time AND end_time";
        }

        $present_hour_to_second = round($min / 60, 2);

        $present_hour = $this->access_model->getHours($where);
        $data['working_hour'] = ($present_hour[0]['hour'] - 1) + $present_hour_to_second;

        $data['maincontent'] = $this->load->view('reports/line_hourly_report', $data);
//        $this->load->view('reports/master', $data);
    }

    public function lineHourlyReportAutoMail(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        $date_time=$datex->format('Y-m-d H:i:s');
        $time=$datex->format('H:i:s');
        $hour=$datex->format('H');
        $min=$datex->format('i');
        $date=$datex->format('Y-m-d');

        $last_hour = ($hour-1).':00:00';

        $where = '';
        $select_fields = " date, start_time, end_time, SUM(qty) as total_hour_output_qty ";

        if($last_hour != ''){
            $where .= " AND '$last_hour' BETWEEN start_time AND end_time";
        }

        if($date != ''){
            $where .= " AND `date`='$date'";
        }

        $res = $this->access_model->getLineOutputHourlyReport($select_fields, $where);

        $total_hour_output_qty = $res[0]['total_hour_output_qty'];

        if($time <= '20:00:00'){
            if($total_hour_output_qty > 0){
                $data['min_to_hour']=round($min / 60, 2);
                $data['time']=$time;

                $segments = $this->access_model->getSegments($time);

                $segment_id=$segments[0]['id'];
                $data['segment_id']=$segment_id;

                $data['title'] = 'Today Line Hourly Report';
                $data['user_name'] = $this->session->userdata('user_name');
                $data['access_points'] = $this->session->userdata('access_points');

                $data['hours'] = $this->access_model->getHours();
                $data['lines'] = $this->access_model->getLines();
                $data['floors'] = $this->access_model->getFloors();

                $where = '';
                if($time != ''){
                    $where .= " AND '$time' between start_time AND end_time";
                }

                $present_hour_to_second = round($min / 60, 2);

                $present_hour = $this->access_model->getHours($where);
                $data['working_hour'] = ($present_hour[0]['hour'] - 1) + $present_hour_to_second;

                $mail_content = $this->load->view('reports/line_hourly_report_auto_mail', $data, true);


                $config = Array(
                    'protocol' => 'smtp',
                    'smtp_host' => 'webmail.viyellatexgroup.com',
                    'smtp_port' => 25,
                    'smtp_user' => '', // change it to yours
                    'smtp_pass' => '', // change it to yours
                    'mailtype' => 'html',
                    'charset' => 'utf-8',
                    'wordwrap' => TRUE
                );

                $this->load->library('email', $config);
                $this->email->set_newline("\r\n");
                $this->email->from('pts@interfabshirt.com'); // change it to yours
                $this->email->to('abdullah.khan@viyellatexgroup.com, moazzem.huq@interfabshirt.com, nesar.ahmed@interfabshirt.com, shafayet.chowdhury@interfabshirt.com, nipun.sarker@interfabshirt.com, ecofab.itsupport@interfabshirt.com'); // change it to yours
    //            $this->email->cc('nipun.sarker@interfabshirt.com');// change it to yours
    //            $this->email->to('nipun.sarker@interfabshirt.com'); // change it to yours
                $this->email->subject('ECOFAB Hourly Production Report');
                $this->email->message("$mail_content");
                if ($this->email->send()) {

                    echo  "Mail Sent!";

                } else {
                    show_error($this->email->print_debugger());
                }

            }
        }

        echo  "<script type='text/javascript'>";
        echo "window.open('', '_self', ''); window.close();";
        echo "</script>";
    }

    public function getDetailsAqlreportToday($brand)
    {
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');
        $encoded_brand = urldecode($brand);
        $get_data['title']='Today Plan AQL Report';
        $get_data['aql_detail_today'] = $this->dashboard_model->getDetailsAqlreportToday($encoded_brand, $date);

        $data['maincontent'] = $this->load->view('reports/aql_balance_report_today', $get_data, true);
        $this->load->view('reports/master', $data);

    }

    public function getDetailsAqlreport($brand)
    {
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $encoded_brand = urldecode($brand);
        $get_data['title']='Previous Date AQL Report';
        $get_data['aql_detail'] = $this->dashboard_model->getDetailsAqlreport($encoded_brand, $date);

        $data['maincontent'] = $this->load->view('reports/aql_balance_report', $get_data, true);
        $this->load->view('reports/master', $data);
    }

    public function getFloorWiseTargets($floor_id){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $time=$datex->format('H:i:s');
        $date=$datex->format('Y-m-d');

        return $this->dashboard_model->getFloorWiseTargets($floor_id, $date);

    }

    public function getLineWisePoItemReport(){
        $data['line_no'] = $this->input->post('line_no');

//        $data['line_po_items'] = $this->access_model->getLineWisePoItem($line_no);
//        $data['line_po_items'] = $this->access_model->getLineProductionReport($line_no);

        echo $maincontent = $this->load->view('reports/line_po_item_report', $data, true);
    }

    public function getLineWisePoItemDetailReport($line_no){

        return $data['line_po_items'] = $this->access_model->getLineProductionReport($line_no);

    }

    public function getLineWiseRunningPOs(){
        $line_po_items = $this->dashboard_model->getLineWiseRunningPOs();

        $res_status = $this->dashboard_model->deleteLineRunningProductionSo();

        foreach ($line_po_items as $k => $v){

            if($v['line_po_balance'] > 0){
                $idata['po_no'] = $v['po_no'];
                $idata['so_no'] = $v['so_no'];
                $idata['purchase_order'] = $v['purchase_order'];
                $idata['item'] = $v['item'];
                $idata['quality'] = $v['quality'];
                $idata['color'] = $v['color'];
                $idata['ex_factory_date'] = $v['ex_factory_date'];
                $idata['style_no'] = $v['style_no'];
                $idata['style_name'] = $v['style_name'];
                $idata['line_id'] = $v['line_id'];
                $idata['min_line_input_date_time'] = $v['min_line_input_date_time'];
                $idata['count_input_qty_line'] = $v['count_input_qty_line'];
                $idata['count_end_line_qc_pass'] = $v['count_end_line_qc_pass'];
                $idata['min_line_output_date'] = $v['min_line_output_date'];
                $idata['line_po_balance'] = $v['line_po_balance'];

                if($res_status == 1){
                    $this->dashboard_model->insertTblData('tb_line_running_pos', $idata);
                }
            }

        }

        echo  "<script type='text/javascript'>";
        echo "window.open('', '_self', ''); window.close();";
        echo "</script>";
    }

    public function finishingPerformanceDashboard(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['title'] = 'Finishing Performance';
        $data['user_name'] = $this->session->userdata('user_name');
        $data['access_points'] = $this->session->userdata('access_points');

        $floor_id = $this->input->post('floor');

        $where = '';
        $where1 = '';
        $where2 = '';

        if($floor_id != '' && $floor_id != 0){
            $where .= " AND id=$floor_id";
            $where1 .= " AND floor_id=$floor_id AND date='$date'";
            $where2 .= " AND DAte_FORMAT(packing_date_time, '%Y-%m-%d')='$date'";

            $finishing_trgt = $this->access_model->getFinishingTarget($where1);

            $data['finishing_target'] = $finishing_trgt[0]['target'];


            $finishing_report = $this->access_model->getFinishingFloorOutputReport($where, $where2);
            $data['finishing_output_qty'] = $finishing_report[0]['finishing_output_qty'];
            $data['floor_name'] = $finishing_report[0]['floor_name'];
        }

        $data['floors'] = $this->access_model->getFloors();

        $data['maincontent'] = $this->load->view('reports/finishing_performance_dashboard', $data);
    }

    public function finishingFloorOutputReport($floor_id){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');
        $data['hours'] = $this->access_model->getHours();

        $where = '';
        $where1 = '';
        $where2 = '';

        if($floor_id != '' && $floor_id != 0){
            $data['floor_id'] = $floor_id;

            $where .= " AND id=$floor_id";
            $where1 .= " AND floor_id=$floor_id AND date='$date'";
            $where2 .= " AND DATE_FORMAT(packing_date_time, '%Y-%m-%d') ='$date'";

            $finishing_trgt = $this->access_model->getFinishingTarget($where1);
            $data['hours'] = $this->access_model->getHours();

            $data['finishing_target'] = $finishing_trgt[0]['target'];

            $finishing_report = $this->access_model->getFinishingFloorOutputReport($where, $where2);
            $data['finishing_output_qty'] = $finishing_report[0]['finishing_output_qty'];
            $data['floor_name'] = $finishing_report[0]['floor_name'];
        }

//        $data['maincontent'] = $this->load->view('finishing_floor_performance_dashboard', $data, true);
        $data['maincontent'] = $this->load->view('finishing_floor_performance_dashboard_new', $data);
//        $this->load->view('master_line', $data);
    }

    public function warehouseReport(){
        $data['title']='Warehouse Report';

        $data['brands'] = $this->access_model->getAllBrands();
        $data['wh_types'] = $this->dashboard_model->getWarehouseTypes();

        $data['maincontent'] = $this->load->view('reports/warehouse_report', $data, true);
        $this->load->view('reports/master', $data);
    }

    public function getWarehousePcsReport(){

        $brands = $this->input->post('brands');
        $brands_string = implode(", ", $brands);

        $warehouse_type = $this->input->post('warehouse_type');
        $search_date = $this->input->post('search_date');
        $where = '';
        if($brands_string != ''){
            $where .= " AND brand in ($brands_string)";
        }

        if($warehouse_type != 0 && $warehouse_type != ''){
            $where .= " AND warehouse_qa_type=$warehouse_type";
        }

        if($search_date != ''){
            $where .= " AND DATE_FORMAT(ex_factory_date, '%Y-%m') = '$search_date'";
        }

        $data['wh_pcs'] = $this->dashboard_model->getWarehousePcsReport($where);

        echo $maincontent = $this->load->view('reports/warehouse_pcs_report', $data);
    }

    public function shipDateWiseReportByMonth(){
        $data['title']='Ship Date Wise Report By Month';

        $data['brands'] = $this->access_model->getAllBrands();

        $data['maincontent'] = $this->load->view('reports/ship_date_wise_report_by_month', $data, true);
        $this->load->view('reports/master', $data);
    }

    public function getShipDateWiseReportByMonth(){
        $brands = $this->input->post('brands');
        $brands_string = implode(", ", $brands);

        $search_date = $this->input->post('search_date');

        $where = '';
        $where_1 = '';
        if($brands_string != ''){
            $where_1 .= " AND brand in ($brands_string)";
        }

        if($search_date != ''){
            $where .= " AND DATE_FORMAT(ex_factory_date, '%Y-%m') = '$search_date'";
        }

        $data['monthly_ship_report'] = $this->dashboard_model->getShipDateWiseReportByMonth($where, $where_1);

        echo $maincontent = $this->load->view('reports/monthly_ship_wise_report', $data);
    }

    public function dateWiseWashSendReport(){
        $data['title']='Date Wise Wash Return Report';

        $data['brands'] = $this->access_model->getAllBrands();

        $data['maincontent'] = $this->load->view('reports/date_wise_wash_send_report', $data, true);
        $this->load->view('reports/master', $data);
    }

    public function getDateWiseWashSendReport(){

        $po_from_date = $this->input->post('po_from_date');
        $data['date'] = $po_from_date;

        if($po_from_date != '' && $po_from_date != '1970-01-01'){
            $data['wash_return_report'] = $this->dashboard_model->getDateWiseWashSendReport($po_from_date);
        }

        echo $maincontent = $this->load->view('reports/wash_send_report_by_date', $data);
    }

    public function getWashSendDetailByDate($date, $so, $purchase_order, $item, $quality, $color){

        $where = '';

        if($date != ''){
            $where .= " AND is_going_wash=1 AND date_format(going_wash_scan_date_time, '%Y-%m-%d') LIKE '%$date%' ";
        }

        if($so != ''){
            $where .= " AND po_no LIKE '%$so%'";
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

        if($color != ''){
            $where .= " AND color LIKE '%$color%'";
        }

        $data['date'] = $date;
        $data['wash_detail'] = $this->dashboard_model->getWashDetailByDate($where);


        $data['maincontent'] = $this->load->view('reports/wash_going_detail', $data, true);
        $this->load->view('reports/master', $data);

    }

    public function getWashReturnDetailByDate($date, $so, $purchase_order, $item, $quality, $color){

        $where = '';

        if($date != ''){
            $where .= " AND washing_status=1 AND date_format(washing_date_time, '%Y-%m-%d') LIKE '%$date%' ";
        }

        if($so != ''){
            $where .= " AND po_no LIKE '%$so%'";
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

        if($color != ''){
            $where .= " AND color LIKE '%$color%'";
        }

        $data['date'] = $date;
        $data['wash_detail'] = $this->dashboard_model->getWashDetailByDate($where);


        $data['maincontent'] = $this->load->view('reports/wash_return_detail', $data, true);
        $this->load->view('reports/master', $data);

    }

    public function dateWiseWashReturnReport(){
        $data['title']='Date Wise Wash Return Report';

        $data['brands'] = $this->access_model->getAllBrands();

        $data['maincontent'] = $this->load->view('reports/date_wise_wash_return_report', $data, true);
        $this->load->view('reports/master', $data);
    }

    public function getDateWiseWashReturnReport(){

        $po_from_date = $this->input->post('po_from_date');
        $data['date'] = $po_from_date;

        if($po_from_date != '' && $po_from_date != '1970-01-01'){
            $data['wash_return_report'] = $this->dashboard_model->getDateWiseWashReturnReport($po_from_date);
        }

        echo $maincontent = $this->load->view('reports/wash_return_report_by_date', $data);
    }

    public function dateWiseCuttingReport(){
        $data['title']='Date Wise Cutting Report';

        $data['brands'] = $this->access_model->getAllBrands();

        $data['maincontent'] = $this->load->view('reports/date_wise_cutting_report', $data, true);
        $this->load->view('reports/master', $data);
    }

    public function getDateWiseCuttingReport(){

        $po_from_date = $this->input->post('po_from_date');
        $data['date'] = $po_from_date;

        if($po_from_date != '' && $po_from_date != '1970-01-01'){
            $data['cut_report'] = $this->dashboard_model->getDateWiseCuttingReport($po_from_date);
        }

        echo $maincontent = $this->load->view('reports/cutting_report_by_date', $data);
    }

    public function getDailyCuttingReportDetail($search_date){
        $data['title']='Cutting Package Ready Detail';

        $data['date'] = $search_date;

        if($search_date != '' && $search_date != '1970-01-01'){
            $data['cut_report'] = $this->dashboard_model->getDateWiseCuttingReport($search_date);
        }

        $data['maincontent'] = $this->load->view('reports/cutting_report_by_date', $data, true);
        $this->load->view('reports/master', $data);
    }

    public function getDailyLayCutPackageReportDetail($search_date){
        $data['title']='Cutting Report';

        $data['date'] = $search_date;

        if($search_date != '' && $search_date != '1970-01-01'){
            $data['cut_report'] = $this->dashboard_model->getDailyLayCutPackageReportDetail($search_date);
        }

        $data['maincontent'] = $this->load->view('reports/cutting_report_by_date', $data, true);
        $this->load->view('reports/master', $data);
    }

    public function getBalanceToCutDetailReport($po_no){
        $data['title']='Balance to Cut Report';

        $data['cut_report'] = $this->dashboard_model->getBalanceToCutDetailReport($po_no);

        $data['maincontent'] = $this->load->view('reports/balance_to_cut_report', $data, true);
        $this->load->view('reports/master', $data);
    }

    public function getDailyPackageReportDetail($search_date){
        $data['title']='Package Ready Report';

        $data['date'] = $search_date;

        if($search_date != '' && $search_date != '1970-01-01'){
            $data['cut_report'] = $this->dashboard_model->getDailyPackageReportDetail($search_date);
        }

        $data['maincontent'] = $this->load->view('reports/cutting_package_report_by_date', $data, true);
        $this->load->view('reports/master', $data);
    }

    public function getDailyPackingReportDetail($search_date, $floor_name, $floor_id){
        $data['title'] = "Packing Report";

        $data['search_date'] = $search_date;
        $data['floor_name'] = $floor_name;

        if($search_date != '' && $search_date != '1970-01-01'){
            $data['finishing_report'] = $this->dashboard_model->getDateWisePackingReport($search_date, $floor_id);
        }

        $data['maincontent'] = $this->load->view('reports/packing_report_by_date', $data, true);
        $this->load->view('reports/master', $data);
    }

    public function getDailyCartonReportDetail($search_date, $floor_name, $floor_id){
        $data['title'] = "Carton Report";

        $data['search_date'] = $search_date;
        $data['floor_name'] = $floor_name;

        if($search_date != '' && $search_date != '1970-01-01'){
            $data['finishing_report'] = $this->dashboard_model->getDateWiseCartonReport($search_date, $floor_id);
        }

        $data['maincontent'] = $this->load->view('reports/carton_report_by_date', $data, true);
        $this->load->view('reports/master', $data);
    }

    public function getPoInfoReport(){
        $po_type = $this->input->post('po_type');
        $brands_string = $this->input->post('brands');
//        $data['brands_string'] = implode(", ", $brands);
//        $brands_string = $data['brands_string'];

        $ship_date = $this->input->post('ship_date');

        $data['ex_factory_date'] = $ship_date;

        $where = '';

        if($brands_string != ''){
            $where .= " AND brand in ($brands_string)";
        }

        if($po_type != ''){
            $where .= " AND po_type = $po_type";
        }

        if($ship_date != '' && $ship_date != '1970-01-01'){
            $where .= " AND ex_factory_date=$ship_date";
        }

        $data['po_info_report'] = $this->dashboard_model->isAvailAlready($where);

        echo $maincontent = $this->load->view('reports/po_detail_info_report', $data);
    }

    public function shipDateWiseReport(){
        $data['title']='Ship Date Wise Report';

        $data['brands'] = $this->access_model->getAllBrands();

        $data['ship_dates'] = $this->dashboard_model->getAllShipDates();

        $data['maincontent'] = $this->load->view('reports/ship_date_wise_report', $data, true);
        $this->load->view('reports/master', $data);
    }

    public function getShipDateLists(){
        $brands = $this->input->post('brands');
        $data['brands_string'] = implode(", ", $brands);
        $brands_string = $data['brands_string'];

        $where = '';

        if($brands_string != ''){
            $where .= " AND brand in ($brands_string)";
        }

        $ship_dates = $this->dashboard_model->getBrandWiseShipDates($where);

        $options = '';
        $options .= '<option value="">Select Ship Date...</option>';

        foreach ($ship_dates as $v_d){
            $options .= '<option value="'.$v_d['approved_ex_factory_date'].'">'.$v_d['approved_ex_factory_date'].'</option>';
        }

        echo $options;

    }

    public function shipDateWiseReportMonth(){
        $data['title']='Monthly Report';

        $data['brands'] = $this->access_model->getAllBrands();

//        $data['ship_dates'] = $this->dashboard_model->getAllShipDates();

        $data['maincontent'] = $this->load->view('reports/ship_date_wise_report_month', $data, true);
        $this->load->view('reports/master', $data);
    }

    public function getShipDateWiseReportMonth(){
        $po_type = $this->input->post('po_type');
        $data['po_type'] = $po_type;
        $brands = $this->input->post('brands');
        $data['brands_string'] = implode(", ", $brands);
        $brands_string = $data['brands_string'];

//        $po_from_date = $this->input->post('po_from_date');
//        $po_to_date = $this->input->post('po_to_date');

        $month_year = $this->input->post('month_year');

        $where = '';

        if($brands_string != ''){
            $where .= " AND brand in ($brands_string)";
        }

        if($month_year != '' && $month_year != '1970-01'){
            $where .= " AND DATE_FORMAT(approved_ex_factory_date, '%Y-%m') = '$month_year'";
        }

        $data['dates'] = $this->dashboard_model->getSearchedDates($where);

        echo $maincontent = $this->load->view('reports/po_wise_report_by_shipping_date', $data);
    }

    public function getDailyLineOutputReport($so_no){
        $data['title']='Daily Line Output Report';

        $where = "";

        if($so_no != ''){
            $where .= " AND so_no='$so_no'";
        }

        $data['daily_output'] = $this->dashboard_model->getDailyLineOutputReport($where);

        $data['maincontent'] = $this->load->view('reports/po_wise_daily_line_output_report', $data, true);
        $this->load->view('reports/master', $data);
    }

    public function getShipDateWiseReport(){
        $po_type = $this->input->post('po_type');
        $brands_string = $this->input->post('brands');
//        $data['brands_string'] = implode(", ", $brands);
//        $brands_string = $data['brands_string'];

        $ship_date = $this->input->post('ship_date');

        $data['ex_factory_date'] = $ship_date;

        $where = '';
        $where_1 = '';

        if($brands_string != ''){
//            $where_1 .= " AND brand in ($brands_string)";
            $where .= " AND brand in ($brands_string)";
        }

        if($po_type != ''){
            $where .= " AND po_type = $po_type";
        }

        if($ship_date != '' && $ship_date != '1970-01-01'){
            $where .= " AND approved_ex_factory_date='$ship_date'";
        }

//        $data['po_close_report'] = $this->dashboard_model->getPoShippingDateWiseReport($where, $where_1);
        $data['po_close_report'] = $this->dashboard_model->getProductionReport($where);

        echo $maincontent = $this->load->view('reports/po_wise_report_by_ship_date', $data);
    }

    public function getShipReportByDate($ship_date, $brands_string, $po_type){
        $where = '';
        $where_1 = '';

        if($po_type != ''){
            $where .= " AND po_type = $po_type";
        }

        if($brands_string != ''){
//            $where_1 .= " AND brand in ($brands_string)";
            $where .= " AND brand in ($brands_string)";
        }

        if($ship_date != '' && $ship_date != '1970-01-01' && $ship_date != '' && $ship_date != '1970-01-01'){
            $where .= " AND approved_ex_factory_date='$ship_date'";
        }

//        return $po_close_report = $this->dashboard_model->getPoShippingDateWiseReport($where, $where_1);
        return $po_close_report = $this->dashboard_model->getProductionReport($where);
    }

    public function shipDateWiseDailyProductionReport()
    {
        $data['title']='Ship Date Wise Daily Production';

        $data['brands'] = $this->access_model->getAllBrands();

        $data['ship_dates'] = $this->dashboard_model->getAllShipDates();

        $data['maincontent'] = $this->load->view('reports/ship_date_wise_production_report', $data, true);
        $this->load->view('reports/master', $data);
    }

    public function getShipDateWiseDailyReport()
    {
        $po_type = $this->input->post('po_type');
        $brands_string = $this->input->post('brands');
//        $data['brands_string'] = implode(", ", $brands);
//        $brands_string = $data['brands_string'];

        $ship_date = $this->input->post('ship_date');

        $data['ex_factory_date'] = $ship_date;

//        echo '<pre>';
//        print_r($po_type);
//        print_r($brands_string);
//        print_r($ship_date);
//        echo '</pre>';

        $where = '';
        $where_1 = '';

        if($brands_string != ''){
//            $where_1 .= " AND brand in ($brands_string)";
            $where .= " AND brand in ($brands_string)";
        }

        if($po_type != ''){
            $where .= " AND po_type = $po_type";
        }

        if($ship_date != '' && $ship_date != '1970-01-01'){
            $where .= " AND ex_factory_date='$ship_date'";
        }

//        $data['po_close_report'] = $this->dashboard_model->getPoShippingDateWiseReport($where, $where_1);
        $data['daily_output'] = $this->dashboard_model->getShipDateWiseDailyReport($where);

        echo $maincontent = $this->load->view('reports/ship_date_wise_daily_performance_report', $data);
    }

    public function poClosingReport(){
        $data['title']='PO Closing Report';

        $data['maincontent'] = $this->load->view('reports/po_closing_report', $data, true);
        $this->load->view('reports/master', $data);
    }

    public function getPoClosingReport(){
//        $ship_frm_dt = $this->input->post('ship_frm_dt');
        $po_from_date = $this->input->post('po_from_date');
        $po_to_date = $this->input->post('po_to_date');

        $where = '';

        if($po_from_date != '' && $po_from_date != '1970-01-01' && $po_to_date != '' && $po_to_date != '1970-01-01'){
            $where .= " AND DATE_FORMAT(A.po_closing_date_time, '%Y-%m-%d') between '$po_from_date' and '$po_to_date'";
        }

        $data['po_close_report'] = $this->dashboard_model->getPoClosingReport($where);

        echo $maincontent = $this->load->view('reports/po_wise_report_by_po_closing_date', $data);
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

        $cut_order = $this->dashboard_model->getPoWiseCuttingInfo($where);

        return $cut_order;
    }

    public function poWiseCatonInfo($po_no, $purchase_order, $item, $style_no, $quality, $color){
        $where = '';

        if($po_no != ''){
            $where .= " AND A.po_no like '%$po_no%'";
        }

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

        $cut_order = $this->dashboard_model->getPoSizeWisePackingInfo($where);

        return $cut_order;
    }

    public function poSizeWisePackingInfo($sap_no, $purchase_order, $item, $style_no, $quality, $color){
        $where = '';
        if($sap_no != ''){
            $where .= " AND A.po_no LIKE '%$sap_no%'";
        }
        if($purchase_order != ''){
            $where .= " AND A.purchase_order LIKE '%$purchase_order%'";
        }
        if($item != ''){
            $where .= " AND A.item LIKE '%$item%'";
        }

        $po_size_order = $this->dashboard_model->getPoSizeWisePackingInfo($where);

        return $po_size_order;
    }

    public function getLinePoItemWiseSizeReport(){
        $po_no = $this->input->post('po_no');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $color = $this->input->post('color');
        $line_no = $this->input->post('line_no');

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
        if($color != ''){
            $where .= " AND t1.color LIKE '%$color%'";
        }
        if($line_no != ''){
            $where .= " AND t1.line_id=$line_no";
        }
        $get_data['order_size'] = $this->dashboard_model->getLinePoItemWiseSizeReport($where);

        $maincontent = $this->load->view('reports/line_po_item_wise_size_report', $get_data, true);

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
        if($po_no != ''){
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

        $get_data['remain_size_cl'] = $this->dashboard_model->getRemainingCLBySize($where);

        $maincontent = $this->load->view('po_item_wise_size_remain_cl_list', $get_data, true);

        echo $maincontent;
    }

    public function getPoItemWiseRemainCL(){
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

        $where .= " AND t1.carton_status=0 AND t1.warehouse_qa_type=0 AND t1.manually_closed=0";

        $get_data['remain_pcs'] = $this->dashboard_model->getRemainingCLBySize($where);

        $maincontent = $this->load->view('po_item_wise_carton_remain_pcs', $get_data, true);

        echo $maincontent;
    }

    public function getPoItemWiseFinishingRemainCL(){
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

        $where .= " AND t1.access_points=4 AND t1.access_points_status=4 AND t1.carton_status=0 AND t1.warehouse_qa_type=0";

        $get_data['remain_pcs'] = $this->dashboard_model->getRemainingCLBySize($where);

        $maincontent = $this->load->view('po_item_wise_carton_remain_pcs', $get_data, true);

        echo $maincontent;
    }

    public function getPoItemWiseLineRemainCL(){
        $so_no = $this->input->post('so_no');
        $line_id = $this->input->post('line_id');

        $where = '';

        if($so_no != ''){
            $where .= " AND t1.so_no = '$so_no'";
        }

        if($so_no != ''){
            $where .= " AND t1.line_id = '$line_id'";
        }

        $where .= "  AND t1.access_points IN (2, 3, 4) AND t1.access_points_status IN (1, 2)";

        $get_data['remain_pcs'] = $this->dashboard_model->getRemainingCLBySize($where);

        $maincontent = $this->load->view('po_item_wise_carton_remain_pcs', $get_data, true);

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

        $get_data['remain_size_cl'] = $this->dashboard_model->getRemainingCLBySize($where);

        $maincontent = $this->load->view('po_item_wise_size_remain_cl_list', $get_data, true);

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

        $get_data['remain_size_cl'] = $this->dashboard_model->getRemainingMidEndCLBySize($where, $where1, $where2);

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

        $get_data['remain_size_cl'] = $this->dashboard_model->getRemainingMidEndCLBySize($where, $where1, $where2);

        $maincontent = $this->load->view('po_item_wise_size_remain_cl_list_modal', $get_data, true);

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

        $get_data['remain_size_cl'] = $this->dashboard_model->getRemainingCLBySize($where);

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

        $where .= " AND is_going_wash = 0";

        $get_data['remain_size_cl'] = $this->dashboard_model->getRemainingCLBySize($where);

        $maincontent = $this->load->view('po_item_wise_size_remain_cl_list', $get_data, true);

        echo $maincontent;
    }

    public function cutVsOutpotReportByDateRange(){
        $data['title']='Cut Vs Output Report';

        $data['prod_summary'] = $this->dashboard_model->getProductionSummaryReport();

        $data['maincontent'] = $this->load->view('reports/report_cut_output', $data, true);
        $this->load->view('reports/master', $data);
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

        $get_data['remain_size_cl'] = $this->dashboard_model->getRemainingCLBySize($where);

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

        $get_data['remain_size_cl'] = $this->dashboard_model->getRemainingCLBySize($where);

        $maincontent = $this->load->view('po_item_wise_size_remain_cl_list', $get_data, true);

        echo $maincontent;
    }

    public function linePerformanceDashboardNew($line_id){
        $data['title'] = 'Line Dashboard';

//        $line_id = $this->session->userdata('line_id');
//        $data['user_name'] = $this->session->userdata('user_name');
//        $data['access_points'] = $this->session->userdata('access_points');

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
//            $data['hours'] = $this->access_model->getHours();

//            $min_max_hours = $this->access_model->getMinMaxHours();
//            $min_start_time = $min_max_hours[0]['min_start_time'];
//            $max_end_time = $min_max_hours[0]['max_end_time'];


//            $data['work_time'] = $this->access_model->getWorkingHoursViewTable($line_id, $date, $min_start_time);
//            $data['get_smv_list'] = $this->access_model->getSMVs($line_id, $date);

            $where .= " AND line_id=$line_id AND date='$date'";

//            $line_trgt = $this->access_model->getLineTargetViewTable($line_id);

//            $line_target = $line_trgt[0]['target'];
//            $man_power = $line_trgt[0]['man_power'];

            $where1 .= " AND line_id=$line_id  AND access_points_status=4 
                         AND DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') LIKE '%$date%' ";

            $where2 .= " AND planned_line_id=$line_id AND line_id=0";

//            $line_report = $this->access_model->getLineOutputReportViewTable($line_id);

//            $data['upcoming_po'] = $this->access_model->getUpcomingPoListViewTable($where2);

//            $line_output = $line_report[0]['count_end_line_qc_pass'];

//            $data['line_output'] = $line_output;

//            $data['line_target'] = $line_target;

//            $data['man_power'] = $man_power;

//            $data['line_status'] = $this->dashboard_model->getLineWipMidPassStatusByLineViewTable($line_id, $date);

        }

        $data['maincontent'] = $this->load->view('line_performance_dashboard', $data);
//        $this->load->view('master_line', $data);
    }

    public function updatePerHourTarget($line_id, $start_time, $end_time, $per_hour_actual_target){
        $this->dashboard_model->updatePerHourTarget($line_id, $start_time, $end_time, $per_hour_actual_target);
    }

    public function allLinePerformanceDashboard(){
        $data['title'] = 'EcoFab Line Performance';

        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');
        $time=$datex->format('H:i:s');

        $data['res_hour'] = $this->access_model->getHoursByTimeRange($time);

        $data['line_report'] = $this->dashboard_model->getAllLinePerformanceSummaryReport($date);

        $data['maincontent'] = $this->load->view('all_line_performance_dashboard', $data);
    }

    public function getHourlyReportByLineCode(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $line_code = $this->input->post('line_code');

        $data = $this->dashboard_model->getHourlyReportByLineCode($line_code, $date);

        echo json_encode($data);
    }

    public function getLineHourlyOutputReloadPre($line_id){
        $data['line_info'] = $this->access_model->getLineInfo($line_id);

        $data['hours'] = $this->access_model->getHours();

        $line_trgt = $this->access_model->getLineTargetViewTable($line_id);

        $line_target = $line_trgt[0]['target'];

        $line_report = $this->access_model->getLineOutputReportViewTable($line_id);

        $line_output = $line_report[0]['count_end_line_qc_pass'];

        $data['line_output'] = $line_output;

        $data['line_target'] = $line_target;

        echo $data['maincontent'] = $this->load->view('line_hourly_output_reload_pre', $data, true);
    }

    public function getLineInfo($line_id){
        return $this->access_model->getTodayLineOutputReport($line_id);
    }

    public function getLineHourlyOutputReload($line_id){
        $data['line_info'] = $this->access_model->getLineInfo($line_id);

        $data['hours'] = $this->access_model->getHours();

        $line_trgt = $this->access_model->getLineTargetViewTable($line_id);

        $line_target = $line_trgt[0]['target'];
        $line_target_hour = $line_trgt[0]['target_hour'];

        $data['line_report'] = $this->access_model->getTodayLineOutputReport($line_id);

        $line_output = 0;

        foreach ($data['line_report'] as $v){
            $line_output += $v['qty'];
        }

        $data['line_output'] = $line_output;

        $data['line_target'] = $line_target;
        $data['line_target_hour'] = $line_target_hour;

        echo $data['maincontent'] = $this->load->view('line_hourly_output_reload', $data, true);
    }

    public function getFinishingHourlyOutputReload($floor_id){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['hours'] = $this->access_model->getHours();

        $flr_trgt = $this->access_model->getTodayFinishingTarget($floor_id, $date);

        $floor_target = $flr_trgt[0]['target'];
        $floor_target_hour = $flr_trgt[0]['target_hour'];

        $data['line_report'] = $this->access_model->getTodayFinishingOutputReport($floor_id);

        $floor_output = 0;

        foreach ($data['line_report'] as $v){
            $floor_output += $v['qty'];
        }

        $data['line_output'] = $floor_output;

        $data['line_target'] = $floor_target;
        $data['line_target_hour'] = $floor_target_hour;

        echo $data['maincontent'] = $this->load->view('finishing_hourly_output_reload', $data, true);
    }

    public function getLineHourlyReport($line_id, $start_time, $end_time){

        $select_fields = '';
        $select_fields .= " * ";

        $where = '';

        if($line_id != ''){
            $where .= " AND line_id=$line_id";
        }

        if($start_time != '' && $end_time != ''){
            $where .= " AND start_time='$start_time' AND end_time='$end_time'";
        }

        return $this->access_model->getLineOutputHourlyReport($select_fields, $where);
    }

    public function getHourlySummaryReport($start_time, $end_time){

        $select_fields = '';
        $select_fields .= " `date`, start_time, end_time, SUM(qty) AS total_hour_qty ";

        $where = '';

        if($start_time != '' && $end_time != ''){
            $where .= " AND start_time='$start_time' AND end_time='$end_time'";
        }

        return $this->access_model->getLineOutputHourlyReport($select_fields, $where);
    }

    public function getHourlyFloorSummaryReport($start_time, $end_time, $floor_id){
        return $this->access_model->getFloorLineOutputHourlyReport($start_time, $end_time, $floor_id);
    }

    public function getFloorSummaryReport($floor_id){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        return $this->access_model->getFloorLineOutputReport($floor_id);
    }

    public function getFinishingOutputSummaryReload($floor_id){

        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $where = '';
        $where1 = '';
        $where2 = '';

        if($floor_id != '' && $floor_id != 0){
            $where .= " AND id=$floor_id";
            $where1 .= " AND floor_id=$floor_id AND date='$date'";
            $where2 .= " AND DATE_FORMAT(packing_date_time, '%Y-%m-%d') ='$date'";

            $finishing_trgt = $this->access_model->getFinishingTarget($where1);
            $data['hours'] = $this->access_model->getHours();

            $data['finishing_target'] = $finishing_trgt[0]['target'];


            $finishing_report = $this->access_model->getFinishingFloorOutputReport($where, $where2);
            $data['finishing_output_qty'] = $finishing_report[0]['finishing_output_qty'];
            $data['floor_name'] = $finishing_report[0]['floor_name'];
        }

        echo $data['maincontent'] = $this->load->view('finishing_output_summary_reload', $data, true);
//        echo $finishing_report;
    }

    public function getFinishingQcSummaryReload($floor_id){

        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $where = '';

        if($floor_id != '' && $floor_id != 0){
            $where .= " AND finishing_qc_status in (2, 3) AND finishing_floor_id=$floor_id";

            $finishing_report = $this->access_model->getFinishingQcSummaryReload($where);
            $finishing_alter_qty = ($finishing_report[0]['finishing_alter_qty'] != '' ? $finishing_report[0]['finishing_alter_qty'] : 0);

            echo $finishing_alter_qty;
        }

    }

    public function getLineFinishingAlterReload($line_id){

        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $where = '';

        if($line_id != '' && $line_id != 0){
            $where .= " AND finishing_qc_status=2 AND line_id=$line_id";

            $finishing_report = $this->access_model->getLineFinishingQcSummaryReload($where);
            $finishing_alter_qty = ($finishing_report[0]['finishing_alter_qty'] != '' ? $finishing_report[0]['finishing_alter_qty'] : 0);

            echo $finishing_alter_qty;
        }

    }

    public function getLineOutputSummaryReload($line_id){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');
        $line_trgt = $this->access_model->getLineTargetViewTable($line_id);

        $line_target = $line_trgt[0]['target'];

//        $line_report = $this->access_model->getLineOutputReportViewTable($line_id); //Previous Query
        $line_report = $this->access_model->getTodayLineOutputSummaryReport($line_id); //Latest Query

        $line_output = $line_report[0]['count_end_line_qc_pass'];

        $data['line_output'] = $line_output;

        $data['line_target'] = $line_target;

        echo $data['maincontent'] = $this->load->view('line_output_summary_reload', $data, true);
    }

    public function getWipReload($line_id){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $data['line_no']=$line_id;

        $where = '';

        if($date != '' && $line_id != ''){
            $where .= " AND line_id=$line_id";
        }

//        $data['line_status'] = $this->dashboard_model->getLineStatusByLineViewTable($line_id, $date);
        $data['line_status'] = $this->access_model->getLineWipReport($where);

        echo $data['maincontent'] = $this->load->view('line_wip_reload', $data, true);
    }

    public function updateTodayWip($count_wip_qty_line,$line_no)
    {
        $wip=$count_wip_qty_line;
        $line_id=$line_no;
        $update_wip=$this->access_model->updateTodayWip($line_id, $wip);
    }

    public function getMidQcPassReload($line_id){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $where = '';

        if($date != '' && $line_id != ''){
            $where .= " AND DATE_FORMAT(mid_line_qc_date_time, '%Y-%m-%d')='$date' AND line_id=$line_id";
        }

//        $data['line_status'] = $this->dashboard_model->getLineStatusByLineViewTable($line_id, $date);
        $data['line_status'] = $this->access_model->getMidPassReportFilterViewTable($where);

        echo $data['maincontent'] = $this->load->view('line_mid_qc_pass_reload', $data, true);
    }

    public function getEfficiencyReload_1($line_id){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');
//        $date='2019-07-04';


        $time=$datex->format('H:i:s');
//        $time="19:00:00";
        $data['time'] = $time;


        $min_max_hours = $this->access_model->getSegments($time);
//        $min_max_hours = $this->access_model->getTime();
        $segment_id = $min_max_hours[0]['id'];
        $min_start_time = $min_max_hours[0]['start_time'];
        $max_end_time = $min_max_hours[0]['end_time'];

        $data['get_smv_list'] = $this->access_model->getSegmentWiseSMVs($line_id, $date, $min_start_time, $max_end_time);


//        $line_trgt = $this->access_model->getLineTargetViewTable($line_id,$date);

//        echo '<pre>';
//        print_r( $data['work_time']);
//        print_r( $data['get_smv_list']);
//        print_r( $line_trgt);
//        echo '</pre>';



//        $segment_id=4;



        $select_fields = '';

        $data['segment_id'] = $segment_id;

        if($segment_id == 1)
        {
            $minhours = $this->access_model->getMinMaxHours();
            $min_time_to_sec = $minhours[0]['min_time_to_sec'];

//            $data['work_time'] = $this->access_model->getSegments($time);
            $maxhours = $this->access_model->getHoursByTimeRange($time);
            $max_time_to_sec = $maxhours[0]['max_time_to_sec'];

            $data['work_time'] = ($max_time_to_sec - $min_time_to_sec);

            $select_fields .= "  id, line_id, target, man_power_1, date, remarks ";

            $line_trgt = $this->access_model->getLineTargetinfo($date, $line_id, $select_fields);

            $line_target = $line_trgt[0]['target'];
            $man_power = $line_trgt[0]['man_power_1'];
//            $man_power =60;
            $data['man_power'] = $man_power;
            $data['line_id'] = $line_id;


            echo $data['maincontent'] = $this->load->view('line_efficiency_reload_1', $data, true);
        }

        if($segment_id == 2)
        {
            $work_time = $this->access_model->getSegments($time);
            $data['work_time'] = $work_time[0]['working_time_diff_to_sec'];

            $select_fields .= "  id, line_id, target, man_power_2, date, remarks ";

            $line_trgt = $this->access_model->getLineTargetinfo($date, $line_id, $select_fields);

            $line_target = $line_trgt[0]['target'];

            $man_power = $line_trgt[0]['man_power_2'];
            $data['man_power'] = $man_power;
            $data['line_id'] = $line_id;


            echo $data['maincontent'] = $this->load->view('line_efficiency_reload_1', $data, true);
        }

        if($segment_id == 3)
        {
            $work_time = $this->access_model->getSegments($time);
            $data['work_time'] = $work_time[0]['working_time_diff_to_sec'];

            $select_fields .= "  id, line_id, target, man_power_3, date, remarks ";

            $line_trgt = $this->access_model->getLineTargetinfo($date, $line_id, $select_fields);

            $line_target = $line_trgt[0]['target'];

            $man_power = $line_trgt[0]['man_power_3'];
            $data['man_power'] = $man_power;
            $data['line_id'] = $line_id;


            echo $data['maincontent'] = $this->load->view('line_efficiency_reload_1', $data, true);
        }

        if($segment_id == 4)
        {
            $work_time = $this->access_model->getWorkingHoursViewTable($line_id, $date, $min_start_time, $max_end_time);
            $data['work_time'] = $work_time[0]['working_time_diff_to_sec'];

            $select_fields .= "  id, line_id, target, man_power_4, date, remarks ";

            $line_trgt = $this->access_model->getLineTargetinfo($date, $line_id, $select_fields);

            $line_target = $line_trgt[0]['target'];

            $man_power = $line_trgt[0]['man_power_4'];
            $data['man_power'] = $man_power;
            $data['line_id'] = $line_id;

            echo $data['maincontent'] = $this->load->view('line_efficiency_reload_1', $data, true);
        }

    }

    public function getEfficiencyReload($line_id){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');
//        $date='2019-07-04';

        $time=$datex->format('H:i:s');

//        $time="19:05:00";
        $data['time'] = $time;


        $min_max_hours = $this->access_model->getSegments($time);
//        $min_max_hours = $this->access_model->getTime();
        $segment_id = $min_max_hours[0]['id'];
        $min_start_time = $min_max_hours[0]['start_time'];
        $max_end_time = $min_max_hours[0]['end_time'];

        $data['get_smv_list'] = $this->access_model->getSegmentWiseSMVs($line_id, $date, $min_start_time, $max_end_time);

        $condition = '';

        if($line_id != ''){
            $condition .= " AND id=$line_id";
        }

        $line_info = $this->dashboard_model->getAllLinesByCondition($condition);
        $data['floor'] = $line_info[0]['floor'];

//        $line_trgt = $this->access_model->getLineTargetViewTable($line_id,$date);

//        echo '<pre>';
//        print_r( $data['work_time']);
//        print_r( $data['get_smv_list']);
//        print_r( $line_trgt);
//        echo '</pre>';



//        $segment_id=4;



        $select_fields = '';

        $data['segment_id'] = $segment_id;

        list($hours, $minutes) = explode(':', $time, 2);
        $max_time_to_sec = $minutes * 60 + $hours * 3600;

        if($segment_id == 1)
        {
            $minhours = $this->access_model->getMinMaxHours();
            $min_time_to_sec = $minhours[0]['min_time_to_sec'];

//            $data['work_time'] = $this->access_model->getSegments($time);
//            $maxhours = $this->access_model->getHoursByTimeRange($time);
//            $max_time_to_sec = $maxhours[0]['max_time_to_sec'];

            $data['work_time'] = ($max_time_to_sec - $min_time_to_sec);

            $select_fields .= "  id, line_id, target, man_power_1, date, remarks ";

            $line_trgt = $this->access_model->getLineTargetinfo($date, $line_id, $select_fields);

            $line_target = $line_trgt[0]['target'];
            $man_power = $line_trgt[0]['man_power_1'];
//            $man_power =60;
            $data['man_power'] = $man_power;
            $data['line_id'] = $line_id;


            echo $data['maincontent'] = $this->load->view('line_efficiency_reload', $data, true);
        }

        if($segment_id == 2)
        {
            $work_time = $this->access_model->getSegments($time);
//            $data['work_time'] = $work_time[0]['working_time_diff_to_sec'];
            $min_time_to_sec = $work_time[0]['min_time_to_sec'];

            $data['work_time'] = ($max_time_to_sec - $min_time_to_sec);

            $select_fields .= "  id, line_id, target, man_power_2, date, remarks ";

            $line_trgt = $this->access_model->getLineTargetinfo($date, $line_id, $select_fields);

            $line_target = $line_trgt[0]['target'];

            $man_power = $line_trgt[0]['man_power_2'];
            $data['man_power'] = $man_power;
            $data['line_id'] = $line_id;


            echo $data['maincontent'] = $this->load->view('line_efficiency_reload', $data, true);
        }

        if($segment_id == 3)
        {
            $work_time = $this->access_model->getSegments($time);
//            $data['work_time'] = $work_time[0]['working_time_diff_to_sec'];
            $min_time_to_sec = $work_time[0]['min_time_to_sec'];

            $data['work_time'] = ($max_time_to_sec - $min_time_to_sec);

            $select_fields .= "  id, line_id, target, man_power_3, date, remarks ";

            $line_trgt = $this->access_model->getLineTargetinfo($date, $line_id, $select_fields);

            $line_target = $line_trgt[0]['target'];

            $man_power = $line_trgt[0]['man_power_3'];
            $data['man_power'] = $man_power;
            $data['line_id'] = $line_id;


            echo $data['maincontent'] = $this->load->view('line_efficiency_reload', $data, true);
        }

        if($segment_id == 4)
        {
//            $work_time = $this->access_model->getWorkingHoursViewTable($line_id, $date, $min_start_time, $max_end_time);
//            $data['work_time'] = $work_time[0]['working_time_diff_to_sec'];

            $work_time = $this->access_model->getSegments($time);
//            $segment_start_time = $work_time[0]['start_time'];
            $min_time_to_sec = $work_time[0]['min_time_to_sec'];


//            $parsed1 = date_parse($segment_start_time);
//            $segment_start_time_seconds = $parsed1['hour'] * 3600 + $parsed1['minute'] * 60 + $parsed1['second'];

            $select_fields .= "  id, line_id, target, man_power_4, date, remarks ";

            $line_trgt = $this->access_model->getLineTargetinfo($date, $line_id, $select_fields);

            $line_target = $line_trgt[0]['target'];
            $last_segment_time = $line_trgt[0]['last_segment_time'];

//            $parsed2 = date_parse($last_segment_time);
//            $last_segment_time_seconds = $parsed2['hour'] * 3600 + $parsed2['minute'] * 60 + $parsed2['second'];

//            $data['work_time'] = $last_segment_time_seconds - $segment_start_time_seconds;

            $data['work_time'] = ($max_time_to_sec - $min_time_to_sec);

            $man_power = $line_trgt[0]['man_power_4'];
            $data['man_power'] = $man_power;
            $data['line_id'] = $line_id;

            echo $data['maincontent'] = $this->load->view('line_efficiency_reload', $data, true);
        }

    }

    public function clockTimer(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time=$datex->format('Y-m-d H:i:s');
        $time=$datex->format('H:i:s');
        $date=$datex->format('Y-m-d');

        echo $clock_time=$datex->format('h:i:s A');
    }

    public function updateTodayEfficiency($line_id, $line_efficiency, $segment_id, $produce_minute, $work_minute, $hour){
        $line_report = $this->access_model->getTodayLineOutputReport($line_id);

        $total_efficiency = 0;

        $produce_minute_1 = $line_report[0]['produce_minute_1'];
        $work_minute_1 = $line_report[0]['work_minute_1'];

        $produce_minute_2 = $line_report[0]['produce_minute_2'];
        $work_minute_2 = $line_report[0]['work_minute_2'];

        $produce_minute_3 = $line_report[0]['produce_minute_3'];
        $work_minute_3 = $line_report[0]['work_minute_3'];

        $produce_minute_4 = $line_report[0]['produce_minute_4'];
        $work_minute_4 = $line_report[0]['work_minute_4'];


        $set_fields = '';

        if($segment_id == 1){

            $avg_effiency=round(($produce_minute_1/$work_minute_1)*100, 2);
            $set_fields .= " SET produce_minute_1=$produce_minute, work_minute_1=$work_minute ,work_hour_1='$hour', efficiency=$avg_effiency";

            $this->dashboard_model->updateTodayEfficiency($line_id, $set_fields);
        }

        if($segment_id == 2){

            $avg_effiency = round((($produce_minute_1+$produce_minute_2)/($work_minute_1+$work_minute_2))*100, 2);
            $set_fields .= " SET produce_minute_2=$produce_minute, work_minute_2=$work_minute , work_hour_2='$hour', efficiency=$avg_effiency";
            $this->dashboard_model->updateTodayEfficiency($line_id, $set_fields);
        }

        if($segment_id == 3){
            $avg_effiency = round((($produce_minute_1+$produce_minute_2+$produce_minute_3)/($work_minute_1+$work_minute_2+$work_minute_3))*100, 2);
            $set_fields .= " SET produce_minute_3=$produce_minute, work_minute_3=$work_minute , work_hour_3='$hour', efficiency=$avg_effiency";
            $this->dashboard_model->updateTodayEfficiency($line_id, $set_fields);
        }

        if($segment_id == 4){
            $avg_effiency = round((($produce_minute_1+$produce_minute_2+$produce_minute_3+$produce_minute_4)/($work_minute_1+$work_minute_2+$work_minute_3+$work_minute_4))*100, 2);
            $set_fields .= " SET produce_minute_4=$produce_minute_4, work_minute_4=$work_minute_4 , work_hour_4='$hour',efficiency=$avg_effiency";
            $this->dashboard_model->updateTodayEfficiency($line_id, $set_fields);
        }

    }

    public function getLineTargetInfo($line_id){

        return $this->access_model->getLineTargetViewTable($line_id);

    }

    public function getLineTargetInfos($line_id, $date){

        $where = '';
        if($line_id != ''){
            $where .= " AND line_id=$line_id";
        }

        if($date != ''){
            $where .= " AND date='$date'";
        }

        return $this->access_model->getLineTarget($where);

    }

    public function getManPowerReload($line_id){

        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $time=$datex->format('H:i:s');
        $date=$datex->format('Y-m-d');


//        $date='2019-07-04';


//        $time = "17:30:00";
        $data['time']=$time;

//        $data['lines'] = $this->access_model->getLines($where);
        $segments = $this->access_model->getSegments($time);

        $segment_id=$segments[0]['id'];



//        $segment_id=4;

        if($segment_id == 1)
        {


            $line_trgt = $this->access_model->getLineTargetViewTable($line_id);
//            $line_segment = $this->access_model->getSegmentById();

            $line_target = $line_trgt[0]['target'];
            $man_power = $line_trgt[0]['man_power_1'];

            $data['man_power'] = $man_power;


            echo $data['maincontent'] = $this->load->view('line_man_power_reload', $data, true);
        }

        if($segment_id == 2)
        {
            $line_trgt = $this->access_model->getLineTargetViewTable($line_id,$date);
//            $line_segment = $this->access_model->getSegmentById();

            $line_target = $line_trgt[0]['target'];
            $man_power = $line_trgt[0]['man_power_2'];

            $data['man_power'] = $man_power;

            echo $data['maincontent'] = $this->load->view('line_man_power_reload', $data, true);
        }

        if($segment_id == 3)
        {
            $line_trgt = $this->access_model->getLineTargetViewTable($line_id,$date);
//            $line_segment = $this->access_model->getSegmentById();

            $line_target = $line_trgt[0]['target'];
            $man_power = $line_trgt[0]['man_power_3'];

            $data['man_power'] = $man_power;

            echo $data['maincontent'] = $this->load->view('line_man_power_reload', $data, true);
        }

        if($segment_id == 4)
        {
            $line_trgt = $this->access_model->getLineTargetViewTable($line_id,$date);
//            $line_segment = $this->access_model->getSegmentById();

            $line_target = $line_trgt[0]['target'];
            $man_power = $line_trgt[0]['man_power_4'];

            $data['man_power'] = $man_power;

            echo $data['maincontent'] = $this->load->view('line_man_power_reload', $data, true);
        }

    }

    public function getUpcomingPosReload($line_id){
        $where2 = '';

        if($line_id != ''){
            $where2 .= " AND planned_line_id=$line_id AND line_id=0";
        }

        $data['upcoming_po'] = $this->access_model->getUpcomingPoListViewTable($where2);

        echo $data['maincontent'] = $this->load->view('line_upcoming_pos_reload', $data, true);
    }

    public function getRunningPoQtyReload($line_id){
        $where = '';

        if($line_id != ''){
            $where .= " AND line_id=$line_id";
        }

        $running_po_qty = $this->access_model->getRunningPoQtyReport($where);
        $data['running_po_qty'] = $running_po_qty[0]['running_po_qty'];

        echo $data['maincontent'] = $this->load->view('line_running_po_qty_reload', $data, true);
    }

    public function getQualityDefectsReload($line_id){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $time=$datex->format('H:i:s');
        $date=$datex->format('Y-m-d');

        $data['line_id'] = $line_id;

        $where = '';
        $where_1 = '';
        $where_2 = '';

        $where_3 = " AND '$time'  BETWEEN start_time AND end_time";

        $where_4 = '';

        $this_hour = $this->access_model->getHours($where_3);
        $start_time = $this_hour[0]['start_time'];
        $data['start_time'] = $start_time;
        $end_time = $this_hour[0]['end_time'];
        $data['end_time'] = $end_time;

        $data['hour'] = $this_hour[0]['hour'];

        if($line_id != ''){
            $where .= " AND DATE_FORMAT(defect_date_time, '%Y-%m-%d')='$date' AND line_id=$line_id AND DATE_FORMAT(defect_date_time, '%H:%i:%s') BETWEEN '$start_time' AND '$end_time'";
            $where_1 .= " AND line_id=$line_id AND DATE_FORMAT(defect_date_time, '%Y-%m-%d')='$date' AND DATE_FORMAT(defect_date_time, '%H:%i:%s') BETWEEN '$start_time' AND '$end_time'";
            $where_2 .= " AND line_id=$line_id AND '$time' BETWEEN start_time AND end_time";
            $where_4 .= " AND DATE_FORMAT(defect_date_time, '%Y-%m-%d')='$date' AND line_id=$line_id";
        }

        $data['qa_major_defects'] = $this->access_model->getQualityDefectsReport($where_4);
        $data['dhu_report'] = $this->access_model->getDHUReport($where, $where_2, $where_1);
        $data['dhu_summary'] = $this->access_model->getLineDHUSummary($line_id);

        $data['dhu_count'] = $this->getDefectCount($line_id, '', $date);

        echo $data['maincontent'] = $this->load->view('line_quality_defects_reload', $data, true);
    }

    public function lineQualityReport(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        $date_time=$datex->format('Y-m-d H:i:s');
        $time=$datex->format('H:i:s');
        $date=$datex->format('Y-m-d');

        $data['date'] = $date;
        $data['title'] = 'Line Quality Report';

        $where = " AND '$time'  BETWEEN start_time AND end_time";

        $this_hour = $this->access_model->getHours($where);
        $data['hour'] = $this_hour[0]['hour'];

        $data['defect_types'] = $this->access_model->getAllTbl('tb_defect_types');
        $data['lines'] = $this->access_model->getLineDhuSummaryReport($date);

        $data['maincontent'] = $this->load->view('reports/line_quality_report', $data);
    }

    public function getDefectCount($line_id, $defect_code, $date){
        return $this->dashboard_model->getDefectCount($line_id, $defect_code, $date);
    }

    public function getLineDHUSummary($line_id){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time=$datex->format('Y-m-d H:i:s');
        $time=$datex->format('H:i:s');
        $date=$datex->format('Y-m-d');

        $data['line_id'] = $line_id;

        return $dhu_summary = $this->access_model->getLineDHUSummary($line_id);
    }

    public function lineQualityDefectSave($line_id, $dhu){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time=$datex->format('Y-m-d H:i:s');
        $time=$datex->format('H:i:s');
        $date=$datex->format('Y-m-d');

        $this->dashboard_model->lineQualityDefectSave($line_id, $dhu, $time);
    }

    public function getHoursByTimeRange(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time=$datex->format('Y-m-d H:i:s');
        $time=$datex->format('H:i:s');
        $date=$datex->format('Y-m-d');

        $hour = $this->access_model->getHoursByTimeRange($time);

        return $hour;
    }

    public function getSapDataNew(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $file = fopen("C:/PTL/PTL.csv", "r");

        while (!feof($file) ) {
            $line_of_text[] = fgetcsv($file);
//            $line_of_text[] = fgetcsv($file, 1000, "\t");
        }
        fclose($file);

//        return $line_of_text;

        $array_pushed = [];

//        echo '<pre>';
//        print_r($line_of_text);
//        echo '</pre>';
//        die();

        foreach ($line_of_text as $k => $v_data){
//            if($k > 0){

                if($v_data[2] != '' && $v_data[15] == 'PC'){

                    $exploded_po_item = explode("_", $v_data[5]);

                    $ex_fac_dt = date_create($v_data[6]);
                    $ex_factory_date = date_format($ex_fac_dt,"Y-m-d");

                    $create_dt = date_create($v_data[10]);
                    $created_on = date_format($create_dt,"Y-m-d");

                    $changed_dt = date_create($v_data[4]);
                    $changed_on = date_format($changed_dt,"Y-m-d");

                    $size = str_replace (" ", "", $v_data[13]); // Remove white spaces from size field
                    $sap_po = ($v_data[2] * 1);
                    $pur_order = $exploded_po_item[0];

                    $search =  "/-~_'" ;
                    $search = str_split($search);
                    $str = $pur_order ;

                    $purch_order = (str_replace($search, "", $str));
                    $purchase_order = (str_replace(" ", "", $purch_order));

                    $color = (str_replace(" ", "", $v_data[26]));

                    if($exploded_po_item[1] != ''){
                        $item = (str_replace(" ", "", $exploded_po_item[1]));
                    }else{
                        $item = $color;
                    }

                    $brand = $v_data[27];
                    $style_no = $v_data[1];
                    $style_name = $v_data[29];

                    if($v_data[30] != ''){
                        $quality = $v_data[30];
                    }else{
                        $quality = $style_no;
                    }

                    $qty = $v_data[14];


                    $where = "";
                    if($sap_po != ''){
                        $where .= " AND so_no = '$sap_po'";
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

//                    if($purchase_order != ''){
//                        $where .= " AND purchase_order LIKE '%$purchase_order%'";
//                    }
//
//                    if($item != ''){
//                        $where .= " AND item LIKE '%$item%'";
//                    }
//
//                    if($style_no != ''){
//                        $where .= " AND style_no LIKE '%$style_no%'";
//                    }
//
//                    if($quality != ''){
//                        $where .= " AND quality LIKE '%$quality%'";
//                    }
//
//                    if($color != ''){
//                        $where .= " AND color LIKE '%$color%'";
//                    }

                    if($size != ''){
                        $where .= " AND size='$size'";
                    }

                    $avail_info = $this->dashboard_model->isAvailAlready($where);


                    $id = $avail_info[0]['id'];
                    $res_po_no = $avail_info[0]['po_no'];
                    $res_so_no = $avail_info[0]['so_no'];
                    $res_changed_on = $avail_info[0]['changed_on'];

                    if(($id != '') && ($res_so_no != '') && ($changed_on != '') && ($res_changed_on != '') && ($changed_on != '1970-01-01') && ($changed_on != '-0001-11-30') && ($res_changed_on != '1970-01-01') && ($res_changed_on < $changed_on)){
                        $data = array(
//                            'po_no' => "$sap_po",
//                            'so_no' => "$sap_po",
                            'purchase_order' => "$purchase_order",
                            'created_on' => "$created_on",
                            'changed_on' => "$changed_on",
                            'item' => "$item",
                            'brand' => "$brand",
                            'style_no' => "$style_no",
                            'style_name' => "$style_name",
                            'quality' => "$quality",
                            'color' => "$color",
                            'quantity' => "$qty",
                            'size' => "$size",
                            'ex_factory_date' => "$ex_factory_date"
                        );

                        $avail_info = $this->dashboard_model->updateTbl('tb_po_detail', $id, $data);

                        echo '<pre>';
                        print_r($data);
                        echo '</pre>';

                        $data_2 = array(
                            'purchase_order' => "$purchase_order",
                            'item' => "$item",
                            'brand' => "$brand",
                            'style_no' => "$style_no",
                            'style_name' => "$style_name",
                            'quality' => "$quality",
                            'color' => "$color"
                        );

                        $avail_info_2 = $this->dashboard_model->updateTbl_2('tb_care_labels', $res_po_no, $data_2);
                        $avail_info_3 = $this->dashboard_model->updateTbl_2('tb_cut_summary', $res_po_no, $data_2);
                    }

                    if(($id == '')){
                        $data_1 = array(
                            'po_no' => "$sap_po",
                            'so_no' => "$sap_po",
                            'purchase_order' => "$purchase_order",
                            'created_on' => "$created_on",
                            'changed_on' => "$changed_on",
                            'item' => "$item",
                            'brand' => "$brand",
                            'style_no' => "$style_no",
                            'style_name' => "$style_name",
                            'quality' => "$quality",
                            'color' => "$color",
                            'quantity' => "$qty",
                            'size' => "$size",
                            'ex_factory_date' => "$ex_factory_date",
                            'upload_date' => "$date"
                        );

                        $insert_info = $this->dashboard_model->insertSapData('tb_po_detail', $data_1);

                        echo '<pre>';
                        print_r($data_1);
                        echo '</pre>';
                    }


                }

//            }
        }

        echo 'Successful Operation!';

    }

    public function getSapData(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $file = fopen("//10.234.15.22/Nipun_Shared/ptl.txt", "r");

        while (!feof($file) ) {
//            $line_of_text[] = fgetcsv($file);
            $line_of_text[] = fgetcsv($file, 1000, "\t");
        }
        fclose($file);

//        return $line_of_text;

        $array_pushed = [];

//        echo '<pre>';
//        print_r($line_of_text);
//        echo '</pre>';
//        die();

        foreach ($line_of_text as $k => $v_data){
            if($k > 0){

                if($v_data[2] != ''){

                    $exploded_description = explode("/", $v_data[7]);
                    $exploded_po_item = explode("_", $v_data[3]);

//                    $exploded_date = explode("-", $v_data[18]);
//                    $ex_factory_date = $exploded_date[2].'-'.$exploded_date[1].'-'.$exploded_date[0];
                    $ex_factory_date = $v_data[18];

//                    $exploded_create_date = explode("-", $v_data[19]);
//                    $created_on = $exploded_create_date[2].'-'.$exploded_create_date[1].'-'.$exploded_create_date[0];
                    $created_on = $v_data[19];

//                    $exploded_changed_date = explode("-", $v_data[17]);
//                    $changed_on = $exploded_changed_date[2].'-'.$exploded_changed_date[1].'-'.$exploded_changed_date[0];
                    $changed_on = $v_data[17];

                    $size = str_replace (" ", "", $v_data[8]); // Remove white spaces from size field
                    $sap_po = $v_data[2];
                    $purchase_order = $exploded_po_item[0];
                    $item = $exploded_po_item[1];
                    $brand = $exploded_description[0];
                    $style_no = $exploded_description[1];
                    $style_name = $exploded_description[2];
                    $quality = $exploded_description[3];
                    $color = $exploded_description[4];
                    $qty = $v_data[21];


                    $where = "";
                    if($sap_po != ''){
                        $where .= " AND po_no LIKE '%$sap_po%'";
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

                    if($color != ''){
                        $where .= " AND color LIKE '%$color%'";
                    }

//                    if($purchase_order != ''){
//                        $where .= " AND purchase_order LIKE '%$purchase_order%'";
//                    }
//
//                    if($item != ''){
//                        $where .= " AND item LIKE '%$item%'";
//                    }
//
//                    if($style_no != ''){
//                        $where .= " AND style_no LIKE '%$style_no%'";
//                    }
//
//                    if($quality != ''){
//                        $where .= " AND quality LIKE '%$quality%'";
//                    }
//
//                    if($color != ''){
//                        $where .= " AND color LIKE '%$color%'";
//                    }

                    if($size != ''){
                        $where .= " AND size='$size'";
                    }

                    $avail_info = $this->dashboard_model->isAvailAlready($where);



                    $id = $avail_info[0]['id'];
                    $res_po_no = $avail_info[0]['po_no'];
                    $res_changed_on = $avail_info[0]['changed_on'];

                        if(($id != '') && ($res_po_no != '') && ($changed_on != '') && ($res_changed_on != '') && ($changed_on != '1970-01-01') && ($res_changed_on != '1970-01-01') && ($res_changed_on < $changed_on)){
                            $data = array(
                                'po_no' => "$sap_po",
                                'purchase_order' => "$purchase_order",
                                'created_on' => "$created_on",
                                'changed_on' => "$changed_on",
                                'item' => "$item",
                                'brand' => "$brand",
                                'style_no' => "$style_no",
                                'style_name' => "$style_name",
                                'quality' => "$quality",
                                'color' => "$color",
                                'quantity' => "$qty",
                                'size' => "$size",
                                'ex_factory_date' => "$ex_factory_date"
                            );

                            $avail_info = $this->dashboard_model->updateTbl('tb_po_detail', $id, $data);

                            echo '<pre>';
                            print_r($data);
                            echo '</pre>';
                        }

                        if(($id == '')){
                            $data = array(
                                'po_no' => "$sap_po",
                                'purchase_order' => "$purchase_order",
                                'created_on' => "$created_on",
                                'changed_on' => "$changed_on",
                                'item' => "$item",
                                'brand' => "$brand",
                                'style_no' => "$style_no",
                                'style_name' => "$style_name",
                                'quality' => "$quality",
                                'color' => "$color",
                                'quantity' => "$qty",
                                'size' => "$size",
                                'ex_factory_date' => "$ex_factory_date"
                            );

                        $insert_info = $this->dashboard_model->insertSapData('tb_po_detail', $data);

                        echo '<pre>';
                        print_r($data);
                        echo '</pre>';
                    }

                }

            }
        }

        echo 'Successful Operation!';

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

            echo  "<script type='text/javascript'>";
            echo "window.open('', '_self', ''); window.close();";
            echo "</script>";

        }

    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */