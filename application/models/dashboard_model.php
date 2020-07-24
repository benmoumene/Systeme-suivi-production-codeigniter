<?php

class Dashboard_model extends CI_Model {
    //put your code here


    public function insertSapData($tbl, $data)
    {
        $this->db->INSERT($tbl, $data);
        //return $this->db->insert_id();
    }

    public function insertTblData($tbl, $data)
    {
        $this->db->INSERT($tbl, $data);
    }

    public function deleteTblData($tbl, $date)
    {
        $this->db->where('date', "$date");
        $this->db->delete($tbl);
    }

    public function testSelectQuery(){

        $sql = "Select * From tb_floor";

        $query = $this->db->query($sql)->result();
        return $query;
    }

    public function getWarehouseTypes(){

        $sql = "Select * From tb_warehouse_type";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getSeasons(){

        $sql = "Select * From tb_season ORDER BY id DESC";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function deleteProductionSo($po_no, $so_no, $purchase_order, $item, $quality, $color){
        $sql = "Delete From tb_production_summary 
                WHERE po_no='$po_no' AND so_no='$so_no' AND purchase_order='$purchase_order' 
                AND item='$item' AND quality='$quality' AND color='$color'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function deleteLineRunningProductionSo(){
        $sql = "TRUNCATE `tb_line_running_pos`";

        $query = $this->db->query($sql);
        return $query;
    }

    public function truncateProductionSummary(){
        $sql = "TRUNCATE `tb_production_summary`";

        $query = $this->db->query($sql);
        return $query;
    }

    public function getCuttingReadyPackageQty(){
        $sql = "SELECT COUNT(id) as cut_ready_qty
                FROM `tb_care_labels`
                WHERE is_package_ready=1
                AND line_id=0
                AND planned_line_id != 0 
                AND package_sent_to_production=0";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getTodayNumberOfMarker($date){
        $sql = "SELECT COUNT(t1.cut_tracking_no) AS total_no_of_marker_qty 
                FROM (SELECT cut_tracking_no FROM `tb_cut_summary` 
                WHERE DATE_FORMAT(cutting_complete_date_time, '%Y-%m-%d')='$date' 
                GROUP BY cut_tracking_no) AS t1";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getTodayNumberOfMarkerByStyleType($date, $style_type){
//        $sql = "SELECT COUNT(t1.cut_tracking_no) AS total_no_of_marker_qty
//                FROM (SELECT cut_tracking_no FROM `tb_cut_summary`
//                WHERE DATE_FORMAT(cutting_complete_date_time, '%Y-%m-%d')='$date'
//                AND style_type=$style_type
//                GROUP BY cut_tracking_no) AS t1";

        $sql = "SELECT 
                (SELECT COUNT(cut_tracking_no) FROM `tb_cut_summary` 
                WHERE DATE_FORMAT(cutting_complete_date_time, '%Y-%m-%d')='$date' 
                AND style_type=1
                GROUP BY cut_tracking_no) AS total_no_of_marker_solid_qty,
                
                (SELECT COUNT(cut_tracking_no) FROM `tb_cut_summary` 
                WHERE DATE_FORMAT(cutting_complete_date_time, '%Y-%m-%d')='$date' 
                AND style_type=2
                GROUP BY cut_tracking_no) AS total_no_of_marker_check_qty,
                
                (SELECT COUNT(cut_tracking_no) FROM `tb_cut_summary` 
                WHERE DATE_FORMAT(cutting_complete_date_time, '%Y-%m-%d')='$date' 
                AND style_type=3
                GROUP BY cut_tracking_no) AS total_no_of_marker_print_qty";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getTodayNumberOfGarment($date){
        $sql = "SELECT COUNT(t1.po_no) AS total_no_of_garments FROM 
                (SELECT po_no
                 FROM `tb_cut_summary` 
                 WHERE DATE_FORMAT(cutting_complete_date_time, '%Y-%m-%d')='$date'
                 GROUP BY po_no, cut_no, size, cut_layer) AS t1";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getTodayNumberOfGarmentByStyleType($date, $style_type){
//        $sql = "SELECT COUNT(t1.po_no) AS total_no_of_garments FROM
//                (SELECT po_no
//                 FROM `tb_cut_summary`
//                 WHERE DATE_FORMAT(cutting_complete_date_time, '%Y-%m-%d')='$date'
//                 AND style_type=$style_type
//                 GROUP BY po_no, cut_no, size, cut_layer) AS t1";

        $sql = "SELECT 
                (SELECT COUNT(po_no)
                FROM `tb_cut_summary` 
                WHERE DATE_FORMAT(cutting_complete_date_time, '%Y-%m-%d')='$date'
                AND style_type=1
                GROUP BY po_no, cut_no, size, cut_layer) AS total_no_of_garments_solid,
                
                (SELECT COUNT(po_no)
                FROM `tb_cut_summary` 
                WHERE DATE_FORMAT(cutting_complete_date_time, '%Y-%m-%d')='$date'
                AND style_type=2
                GROUP BY po_no, cut_no, size, cut_layer) AS total_no_of_garments_check,
                
                (SELECT COUNT(po_no)
                FROM `tb_cut_summary` 
                WHERE DATE_FORMAT(cutting_complete_date_time, '%Y-%m-%d')='$date'
                AND style_type=3
                GROUP BY po_no, cut_no, size, cut_layer) AS total_no_of_garments_print";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getTodayPackageReadyQty($date){

        $sql = "SELECT COUNT(id) as today_package_ready_qty
                FROM `tb_care_labels`
                WHERE DATE_FORMAT(package_ready_date_time, '%Y-%m-%d') = '$date'
                AND is_package_ready=1";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getTodayCutQty($date){

        $sql = "SELECT SUM(cut_qty) as today_cut_qty 
                FROM `tb_cut_summary` 
                WHERE is_cutting_complete=1 
                AND DATE_FORMAT(cutting_complete_date_time, '%Y-%m-%d') = '$date'";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getTodayCutQtyByStyleType($date, $style_type){

//        $sql = "SELECT SUM(cut_qty) as today_cut_qty
//                FROM `tb_cut_summary`
//                WHERE is_cutting_complete=1
//                AND DATE_FORMAT(cutting_complete_date_time, '%Y-%m-%d') = '$date'
//                AND style_type=$style_type";

        $sql = "SELECT 
                (SELECT SUM(cut_qty)
                FROM `tb_cut_summary` 
                WHERE is_cutting_complete=1 
                AND DATE_FORMAT(cutting_complete_date_time, '%Y-%m-%d') = '$date'
                AND style_type=1) AS today_cut_solid_qty,
                
                (SELECT SUM(cut_qty)
                FROM `tb_cut_summary` 
                WHERE is_cutting_complete=1 
                AND DATE_FORMAT(cutting_complete_date_time, '%Y-%m-%d') = '$date'
                AND style_type=2) AS today_cut_check_qty,
                
                (SELECT SUM(cut_qty)
                FROM `tb_cut_summary` 
                WHERE is_cutting_complete=1 
                AND DATE_FORMAT(cutting_complete_date_time, '%Y-%m-%d') = '$date'
                AND style_type=3) AS today_cut_print_qty";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getLayQty(){

        $sql = "SELECT SUM(cut_qty) as total_lay_qty
                FROM `tb_cut_summary` 
                WHERE is_lay_complete=1 AND is_cutting_complete=0";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getLayQtyByStyleType($style_type){

//        $sql = "SELECT SUM(cut_qty) as total_lay_qty
//                FROM `tb_cut_summary`
//                WHERE is_lay_complete=1 AND is_cutting_complete=0
//                AND style_type=$style_type";

        $sql = "SELECT 
                (SELECT SUM(cut_qty) FROM `tb_cut_summary` WHERE is_lay_complete=1 AND is_cutting_complete=0 AND style_type=1) AS  total_lay_qty_solid,
                (SELECT SUM(cut_qty) FROM `tb_cut_summary` WHERE is_lay_complete=1 AND is_cutting_complete=0 AND style_type=2) AS  total_lay_qty_check,
                (SELECT SUM(cut_qty) FROM `tb_cut_summary` WHERE is_lay_complete=1 AND is_cutting_complete=0 AND style_type=3) AS  total_lay_qty_print";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getLineReport($previous_date, $where)
    {
        $sql="SELECT t1.*,t2.line_code FROM
                (SELECT * FROM `tb_daily_line_summary` WHERE date='$previous_date' $where) as t1
                INNER JOIN tb_line as t2
                on t1.line_id=t2.id";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getCuttingReport($previous_date)
    {
        $sql="SELECT * FROM `tb_daily_cut_summary` WHERE date='$previous_date'";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getFinishingReport($previous_date)
    {
        $sql="SELECT * FROM `tb_daily_finish_summary` WHERE date='$previous_date'";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getCuttingReportForChart($date){

        $sql = "SELECT A.line_name, A.line_code, B.wip, C.cut_sew_ready_qty
                
                FROM 
                (SELECT * FROM `tb_line` WHERE status=1) as A
                                            
                LEFT JOIN
                (SELECT line_id, wip
                FROM `tb_today_line_output_qty` 
                WHERE line_id !=0
                AND `date`='$date'
                GROUP BY `date`, line_id
                ) as B
                ON A.id=B.line_id
                
                LEFT JOIN
                (SELECT planned_line_id, COUNT(id) as cut_sew_ready_qty
                FROM `tb_care_labels`
                WHERE is_package_ready=1 AND line_id=0 AND package_sent_to_production=1
                GROUP BY planned_line_id) AS C
                ON A.id=C.planned_line_id
                
                ORDER BY (A.line_code * 1)";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getLineInputReportForChart($date){

        $sql = "SELECT B.*, E.count_mid_pass_qty, F.count_end_line_qc_pass, G.count_wip_qty_line, 
                I.line_name, I.line_code, J.floor_name, K.target
                FROM 
                (SELECT line_id
                FROM `tb_care_labels` WHERE line_id !=0 GROUP BY  line_id) as A
                LEFT JOIN
                (SELECT line_id, COUNT(pc_tracking_no) as count_input_qty_line,
                DATE_FORMAT(line_input_date_time, '%Y-%m-%d') as line_input_date
                FROM `tb_care_labels` WHERE line_id !=0 AND DATE_FORMAT(line_input_date_time, '%Y-%m-%d') LIKE '%$date%'
                GROUP BY DATE_FORMAT(line_input_date_time, '%Y-%m-%d'), line_id) as B
                ON A.line_id=B.line_id
            
                LEFT JOIN 
                (SELECT line_id, COUNT(pc_tracking_no) as count_mid_pass_qty, 
                DATE_FORMAT(mid_line_qc_date_time, '%Y-%m-%d') as mid_line_qc_date_time 
                FROM `tb_care_labels` 
                WHERE line_id !=0  
                AND access_points >= 3
                AND access_points_status in (1, 4)
                AND DATE_FORMAT(mid_line_qc_date_time, '%Y-%m-%d') LIKE '%$date%'
                GROUP BY DATE_FORMAT(mid_line_qc_date_time, '%Y-%m-%d'), line_id) as E
                ON A.line_id=E.line_id
                
                LEFT JOIN
                (SELECT line_id, COUNT(pc_tracking_no) as count_end_line_qc_pass, 
                DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') as end_line_qc_date_time 
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points_status=4
                AND DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') LIKE '%$date%' 
                GROUP BY DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d'), line_id) as F
                ON A.line_id=F.line_id
                
                LEFT JOIN
                (SELECT line_id, COUNT(pc_tracking_no) as count_wip_qty_line 
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points_status < 4
                GROUP BY line_id) as G
                ON A.line_id=G.line_id
                
                LEFT JOIN
                (SELECT line_id, target, `date`
                FROM `line_daily_target` 
                WHERE line_id !=0 AND `date` LIKE '%$date%'
                GROUP BY line_id) as K
                ON A.line_id=K.line_id
                
                Inner Join
                tb_line as I ON A.line_id=I.id
                INNER JOIN
                tb_floor as J ON I.floor=J.id
				ORDER BY (I.line_code * 1)";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getLineStatusByLine($line_id, $date){

        $sql = "SELECT B.*, E.count_mid_pass_qty, F.count_end_line_qc_pass, G.count_wip_qty_line, 
                I.line_name, I.line_code, J.floor_name, K.target
                FROM 
                (SELECT line_id
                FROM `tb_care_labels` WHERE line_id !=0 GROUP BY  line_id) as A
                LEFT JOIN
                (SELECT line_id, COUNT(pc_tracking_no) as count_input_qty_line,
                DATE_FORMAT(line_input_date_time, '%Y-%m-%d') as line_input_date
                FROM `tb_care_labels` WHERE line_id !=0 AND DATE_FORMAT(line_input_date_time, '%Y-%m-%d') LIKE '%$date%'
                GROUP BY DATE_FORMAT(line_input_date_time, '%Y-%m-%d'), line_id) as B
                ON A.line_id=B.line_id
            
                LEFT JOIN 
                (SELECT line_id, COUNT(pc_tracking_no) as count_mid_pass_qty, 
                DATE_FORMAT(mid_line_qc_date_time, '%Y-%m-%d') as mid_line_qc_date_time 
                FROM `tb_care_labels` 
                WHERE line_id !=0  
                AND access_points >= 3
                AND access_points_status in (1, 4)
                AND DATE_FORMAT(mid_line_qc_date_time, '%Y-%m-%d') LIKE '%$date%'
                GROUP BY DATE_FORMAT(mid_line_qc_date_time, '%Y-%m-%d'), line_id) as E
                ON A.line_id=E.line_id
                
                LEFT JOIN
                (SELECT line_id, COUNT(pc_tracking_no) as count_end_line_qc_pass, 
                DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') as end_line_qc_date_time 
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points_status=4
                AND DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') LIKE '%$date%' 
                GROUP BY DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d'), line_id) as F
                ON A.line_id=F.line_id
                
                LEFT JOIN
                (SELECT line_id, COUNT(pc_tracking_no) as count_wip_qty_line 
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points_status < 4
                GROUP BY line_id) as G
                ON A.line_id=G.line_id
                
                LEFT JOIN
                (SELECT line_id, target, `date`
                FROM `line_daily_target` 
                WHERE line_id !=0 AND `date` LIKE '%$date%'
                GROUP BY line_id) as K
                ON A.line_id=K.line_id
                
                Inner Join
                tb_line as I ON A.line_id=I.id
                
                INNER JOIN
                tb_floor as J ON I.floor=J.id
                
                WHERE A.line_id=$line_id
                
				ORDER BY (I.line_code * 1)";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getLineWipMidPassStatusByLineViewTable($line_id, $date){

        $sql = "SELECT A.id, A.line_name, A.line_code, 
                E.count_mid_pass_qty, G.count_wip_qty_line, 
                J.floor_name
                FROM 
                (SELECT *
                FROM `tb_line` WHERE id=$line_id) as A
                            
                LEFT JOIN 
                (SELECT * FROM `vt_curdate_mid_line_qc`) as E
                ON A.id=E.line_id
                                
                LEFT JOIN
                (SELECT * FROM `vt_line_wip`) as G
                ON A.id=G.line_id
                                
                LEFT JOIN
                tb_floor as J ON A.floor=J.id
                                
				ORDER BY (A.line_code * 1)";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getLineStatusByLineViewTable($line_id, $date){

        $sql = "SELECT A.id, A.line_name, A.line_code, B.*, 
                E.count_mid_pass_qty, F.count_end_line_qc_pass, G.count_wip_qty_line, 
                J.floor_name, K.target
                FROM 
                (SELECT *
                FROM `tb_line` WHERE id=$line_id) as A
                
                LEFT JOIN
                (SELECT * FROM `vt_curdate_input`) as B
                ON A.id=B.line_id
            
                LEFT JOIN 
                (SELECT * FROM `vt_curdate_mid_line_qc`) as E
                ON A.id=E.line_id
                
                LEFT JOIN
                (SELECT * FROM `vt_curdate_end_line_qc`) as F
                ON A.id=F.line_id
                
                LEFT JOIN
                (SELECT * FROM `vt_line_wip`) as G
                ON A.id=G.line_id
                
                LEFT JOIN
                (SELECT * FROM `vt_curdate_line_target`) as K
                ON A.id=K.line_id
                
                LEFT JOIN
                tb_floor as J ON A.floor=J.id
                                
				ORDER BY (A.line_code * 1)";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getWorkingTimeRange(){
        $sql = "SELECT min(start_time) as starting_time, max(end_time) as ending_time FROM `tb_hours`";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getCuttingTotalProductionReport($date, $starting_time, $ending_time){

//        $sql = "SELECT COUNT(pc_tracking_no) as total_cutting_output
//                FROM `tb_care_labels`
//                WHERE sent_to_production = 1
//                AND date_format(sent_to_production_date_time, '%Y-%m-%d') LIKE '%$date%'";

//        $sql = "SELECT COUNT(pc_tracking_no) as total_cutting_output
//                FROM `vt_few_days_cut_pass`
//                WHERE date_format(sent_to_production_date_time, '%Y-%m-%d') LIKE '%$date%'";

        $sql = "Select t1.total_cutting_output, t2.normal_hour_cutting_output FROM 
                (SELECT COUNT(pc_tracking_no) as total_cutting_output,
                 date_format(sent_to_production_date_time, '%Y-%m-%d') as cutting_output_date
                FROM `vt_few_days_po_pcs` 
                WHERE date_format(sent_to_production_date_time, '%Y-%m-%d') = '$date') AS t1

                LEFT JOIN 

                (SELECT COUNT(pc_tracking_no) as normal_hour_cutting_output,
                date_format(sent_to_production_date_time, '%Y-%m-%d') as normal_hour_cutting_date
                FROM `vt_few_days_po_pcs` 
                WHERE date_format(sent_to_production_date_time, '%Y-%m-%d') = '$date' 
                AND TIME_FORMAT(sent_to_production_date_time, '%H:%i:%s') BETWEEN '$starting_time' AND '$ending_time'
                GROUP BY DATE_FORMAT(sent_to_production_date_time, '%Y-%m-%d')) AS t2
                ON t1.cutting_output_date=t2.normal_hour_cutting_date";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getLineReadyPackageReport(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $sql = "SELECT t1.*, t2.ready_qty, t3.cut_sew_ready_qty, t4.wip

                FROM 

                tb_line AS t1
                
                LEFT JOIN
                (SELECT planned_line_id, COUNT(id) as ready_qty 
                FROM `tb_care_labels` 
                WHERE is_package_ready=1 AND line_id=0 
                AND package_sent_to_production=0 AND manually_closed=0
                GROUP BY planned_line_id) AS t2
                ON t1.id=t2.planned_line_id
                
                LEFT JOIN
                (SELECT planned_line_id, COUNT(id) as cut_sew_ready_qty 
                FROM `tb_care_labels` 
                WHERE is_package_ready=1 AND line_id=0 
                AND package_sent_to_production=1 AND manually_closed=0
                GROUP BY planned_line_id) AS t3
                ON t1.id=t3.planned_line_id
                
                LEFT JOIN
                (SELECT line_id, wip
                FROM `tb_today_line_output_qty`
                WHERE line_id !=0
                AND `date`='$date'
                GROUP BY `date`, line_id) AS t4
                ON t1.id=t4.line_id
                
                ORDER BY (t1.line_code * 1)";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getCuttingTotalPackageReport($search_date){
        $sql = "SELECT t1.*
              
                FROM (
                SELECT
                    SUM(CASE WHEN is_lay_complete=1 AND DATE_FORMAT(lay_complete_date_time, '%Y-%m-%d')='$search_date'
                THEN cut_qty
                ELSE 0 end) AS lay_complete_qty,

                SUM(CASE WHEN is_cutting_complete=1 AND DATE_FORMAT(cutting_complete_date_time, '%Y-%m-%d')='$search_date'
                THEN cut_qty
                ELSE 0 end) AS cut_complete_qty,
                    
                SUM(CASE WHEN is_package_ready=1 AND DATE_FORMAT(package_ready_date_time, '%Y-%m-%d')='$search_date'
                THEN cut_qty
                ELSE 0 end) AS package_ready_qty
                  
                    
                FROM tb_cut_summary)  as t1";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function cuttingTableWiseDailyReport($date){
        $sql = "SELECT t1.table_name, t2.balance_to_cut_qty, t2.cut_complete_qty

                FROM
                (SELECT * FROM `tb_cut_table` WHERE status=1) AS t1
                
                LEFT JOIN
                (SELECT cut_table,
                SUM(CASE WHEN is_lay_complete=1 AND is_cutting_complete=0
                THEN cut_qty
                ELSE 0 end) AS balance_to_cut_qty,

                SUM(CASE WHEN is_cutting_complete=1 AND DATE_FORMAT(cutting_complete_date_time, '%Y-%m-%d')='$date'
                THEN cut_qty
                ELSE 0 end) AS cut_complete_qty
                  
                FROM tb_cut_summary GROUP BY cut_table) AS t2
                
                ON t1.id=t2.cut_table";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getDailyFusingReport($date)
    {
        $sql = "Select A.*, B.part_codes FROM (SELECT t1.*, t2.total_order_qty
              
                FROM (
                SELECT po_no,so_no,item,quality,color,purchase_order,ex_factory_date,brand,style_no,style_name,
                    
                     SUM(CASE WHEN id !=''
                THEN cut_qty
                ELSE 0 end) AS count_cut_quantity,
                    
                SUM(CASE WHEN is_cutting_collar_bundle_ready=1 AND DATE_FORMAT(cutting_collar_bundle_ready_date_time, '%Y-%m-%d')='$date'
                THEN cut_qty
                ELSE 0 end) AS count_cutting_collar_bundle_qty,

                SUM(CASE WHEN is_cutting_cuff_bundle_ready=1 AND DATE_FORMAT(cutting_cuff_bundle_ready_date_time, '%Y-%m-%d')='$date'
                THEN cut_qty
                ELSE 0 end) AS count_cutting_cuff_bundle_qty,
                    
                SUM(CASE WHEN is_cutting_sleeve_plkt_bundle_ready=1 AND DATE_FORMAT(cutting_sleeve_plkt_bundle_ready_date_time, '%Y-%m-%d')='$date'
                THEN cut_qty
                ELSE 0 end) AS count_slv_plkt_qty
                    
                FROM tb_cut_summary GROUP BY po_no,so_no,item,quality,color,purchase_order
                )  as t1
                LEFT JOIN
                vt_po_summary as t2
                ON t1.so_no=t2.so_no
                
                WHERE t1.count_cutting_collar_bundle_qty > 0 OR t1.count_cutting_cuff_bundle_qty > 0 OR t1.count_slv_plkt_qty > 0) AS A
                
                INNER JOIN
                (SELECT po_no, GROUP_CONCAT(part_code SEPARATOR ',') AS part_codes 
                FROM `tb_po_part_detail` GROUP BY po_no) AS B
                ON A.po_no=B.po_no";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getDailyLayCutPackageReportDetail($search_date){
        $sql = "SELECT t1.*, t2.total_order_qty
              
                FROM (
                SELECT po_no,so_no,item,quality,color,purchase_order,ex_factory_date,brand,style_no,style_name,
                    
                    
                SUM(CASE WHEN is_lay_complete=1 AND DATE_FORMAT(lay_complete_date_time, '%Y-%m-%d')='$search_date'
                THEN cut_qty
                ELSE 0 end) AS lay_complete_qty,

                SUM(CASE WHEN is_cutting_complete=1 AND DATE_FORMAT(cutting_complete_date_time, '%Y-%m-%d')='$search_date'
                THEN cut_qty
                ELSE 0 end) AS cut_complete_qty,

                SUM(CASE WHEN is_lay_complete=1 AND is_cutting_complete=0
                THEN cut_qty
                ELSE 0 end) AS lay_complete_cut_pending_qty
                  
                FROM tb_cut_summary GROUP BY po_no,so_no,item,quality,color,purchase_order
                )  as t1
                LEFT JOIN
                vt_po_summary as t2
                ON t1.so_no=t2.so_no
                WHERE t1.lay_complete_qty > 0 OR t1.cut_complete_qty > 0 OR t1.lay_complete_cut_pending_qty > 0";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getBalanceToCutDetailReport($po_no){
        $sql = "SELECT t1.*, t2.total_order_qty, t3.table_name
              
                FROM 
                (SELECT po_no,so_no,item,quality,color,purchase_order, cut_table,
                ex_factory_date,brand,style_no,style_name, cut_no, lay_complete_date_time, cutting_complete_date_time,
                    
                SUM(CASE WHEN is_lay_complete=1 AND is_cutting_complete=0
                THEN cut_qty
                ELSE 0 end) AS lay_complete_cut_pending_qty
                  
                FROM tb_cut_summary 
                WHERE po_no='$po_no'
                GROUP BY po_no,so_no,item,quality,color,purchase_order, cut_no)  as t1
                
                LEFT JOIN
                vt_po_summary as t2
                ON t1.so_no=t2.so_no
                
                LEFT JOIN
                tb_cut_table as t3
                ON t1.cut_table=t3.id
                WHERE t1.lay_complete_cut_pending_qty > 0";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getDailyPackageReportDetail($search_date){
        $sql = "SELECT t1.*, t2.total_order_qty
              
                FROM (
                SELECT po_no,so_no,item,quality,color,purchase_order,ex_factory_date,brand,style_no,style_name,
                    
                SUM(CASE WHEN is_package_ready=1 AND DATE_FORMAT(package_ready_date_time, '%Y-%m-%d')='$search_date'
                THEN cut_qty
                ELSE 0 end) AS package_ready_qty
                  
                    
                FROM tb_cut_summary GROUP BY po_no,so_no,item,quality,color,purchase_order
                )  as t1
                LEFT JOIN
                vt_po_summary as t2
                ON t1.so_no=t2.so_no
                WHERE t1.package_ready_qty > 0";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getLineReadyPackageDetailReport($plan_line_id){
        $sql = "SELECT po_no, so_no, brand, purchase_order, item, quality, color, 
                style_no, style_name, ex_factory_date, planned_line_id, COUNT(id) as ready_qty 
                FROM `tb_care_labels` 
                WHERE is_package_ready=1 AND line_id=0 AND manually_closed=0
                AND package_sent_to_production=0
                AND planned_line_id='$plan_line_id'
                GROUP BY so_no, po_no, purchase_order, item, quality, color, planned_line_id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getPoCutToSewReadyPackageDetail($plan_line_id){
        $sql = "SELECT po_no, so_no, brand, purchase_order, item, quality, color, 
                style_no, style_name, ex_factory_date, planned_line_id, COUNT(id) as ready_qty 
                FROM `tb_care_labels` 
                WHERE is_package_ready=1 AND line_id=0 AND manually_closed=0
                AND package_sent_to_production=1
                AND planned_line_id='$plan_line_id'
                GROUP BY so_no, po_no, purchase_order, item, quality, color, planned_line_id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getCuttingTarget($previous_date){

        $sql = "SELECT *
                FROM `cutting_daily_target` 
                WHERE `date` = '$previous_date'";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getCuttingExtraProductionReport($date, $starting_time, $ending_time){

//        $sql = "SELECT COUNT(pc_tracking_no) as normal_hour_cutting_output
//                FROM `tb_care_labels`
//                WHERE sent_to_production = 1
//                AND date_format(sent_to_production_date_time, '%Y-%m-%d') LIKE '%$date%'
//                AND TIME_FORMAT(sent_to_production_date_time, '%H:%i:%s') BETWEEN '$starting_time' AND '$ending_time'
//                GROUP BY DATE_FORMAT(sent_to_production_date_time, '%Y-%m-%d')";

        $sql = "SELECT COUNT(pc_tracking_no) as normal_hour_cutting_output
                FROM `vt_few_days_po_pcs` 
                WHERE date_format(sent_to_production_date_time, '%Y-%m-%d') = '$date' 
                AND TIME_FORMAT(sent_to_production_date_time, '%H:%i:%s') BETWEEN '$starting_time' AND '$ending_time'
                GROUP BY DATE_FORMAT(sent_to_production_date_time, '%Y-%m-%d')";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getDateWiseWashReturnReport($po_from_date){

        $sql = "SELECT t1.*, t2.total_count_wash_return_qty, t3.total_order_qty, t3.ex_factory_date, 
                t4.total_cut_qty, t5.total_line_output_qty, t6.total_count_wash_going_qty
                FROM (SELECT *, COUNT(pc_tracking_no) as count_wash_return_qty FROM `tb_care_labels` 
                WHERE washing_status=1 AND DATE_FORMAT(washing_date_time, '%Y-%m-%d') LIKE '%$po_from_date%'
                GROUP BY po_no, purchase_order, item, quality, color) as t1
                INNER JOIN
                (SELECT *, COUNT(pc_tracking_no) as total_count_wash_return_qty
                FROM `tb_care_labels` 
                WHERE washing_status=1
                GROUP BY po_no, purchase_order, item, quality, color) as t2
                ON t1.po_no=t2.po_no AND t1.purchase_order=t2.purchase_order 
                AND t1.item=t2.item AND t1.quality=t2.quality AND t1.color=t2.color
                INNER JOIN
                (SELECT *, SUM(quantity) as total_order_qty
                FROM `tb_po_detail` 
                GROUP BY po_no, purchase_order, item, quality, color) as t3
                ON t1.po_no=t3.po_no AND t1.purchase_order=t3.purchase_order 
                AND t1.item=t3.item AND t1.quality=t3.quality AND t1.color=t3.color
                INNER JOIN
                (SELECT *, SUM(cut_qty) as total_cut_qty
                FROM `tb_cut_summary` 
                GROUP BY po_no, purchase_order, item, quality, color) as t4
                ON t1.po_no=t4.po_no AND t1.purchase_order=t4.purchase_order 
                AND t1.item=t4.item AND t1.quality=t4.quality AND t1.color=t4.color
                INNER JOIN
                (SELECT *, COUNT(pc_tracking_no) as total_line_output_qty
                FROM `tb_care_labels` 
                GROUP BY po_no, purchase_order, item, quality, color) as t5
                ON t1.po_no=t5.po_no AND t1.purchase_order=t5.purchase_order 
                AND t1.item=t5.item AND t1.quality=t5.quality AND t1.color=t5.color
                INNER JOIN
                (SELECT *, COUNT(pc_tracking_no) as total_count_wash_going_qty FROM `tb_care_labels`
                 WHERE is_going_wash=1
                GROUP BY po_no, purchase_order, item, quality, color) as t6
                ON t1.po_no=t6.po_no AND t1.purchase_order=t6.purchase_order 
                AND t1.item=t6.item AND t1.quality=t6.quality AND t1.color=t6.color";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getDateWiseWashSendReport($po_from_date){

        $sql = "SELECT t1.*, t2.total_count_wash_send_qty, t3.total_order_qty, t3.ex_factory_date, 
                t4.total_cut_qty, t5.total_line_output_qty
                
                FROM (SELECT *, COUNT(pc_tracking_no) as count_wash_send_qty FROM `tb_care_labels` 
                WHERE is_going_wash=1 AND DATE_FORMAT(going_wash_scan_date_time, '%Y-%m-%d') LIKE '%$po_from_date%'
                GROUP BY po_no, purchase_order, item, quality, color) as t1
                INNER JOIN
                (SELECT *, COUNT(pc_tracking_no) as total_count_wash_send_qty
                FROM `tb_care_labels` 
                WHERE is_going_wash=1
                GROUP BY po_no, purchase_order, item, quality, color) as t2
                ON t1.po_no=t2.po_no AND t1.purchase_order=t2.purchase_order 
                AND t1.item=t2.item AND t1.quality=t2.quality AND t1.color=t2.color
                INNER JOIN
                (SELECT *, SUM(quantity) as total_order_qty
                FROM `tb_po_detail` 
                GROUP BY po_no, purchase_order, item, quality, color) as t3
                ON t1.po_no=t3.po_no AND t1.purchase_order=t3.purchase_order 
                AND t1.item=t3.item AND t1.quality=t3.quality AND t1.color=t3.color
                INNER JOIN
                (SELECT *, SUM(cut_qty) as total_cut_qty
                FROM `tb_cut_summary` 
                GROUP BY po_no, purchase_order, item, quality, color) as t4
                ON t1.po_no=t4.po_no AND t1.purchase_order=t4.purchase_order 
                AND t1.item=t4.item AND t1.quality=t4.quality AND t1.color=t4.color
                INNER JOIN
                (SELECT *, COUNT(pc_tracking_no) as total_line_output_qty
                FROM `tb_care_labels` 
                GROUP BY po_no, purchase_order, item, quality, color) as t5
                ON t1.po_no=t5.po_no AND t1.purchase_order=t5.purchase_order 
                AND t1.item=t5.item AND t1.quality=t5.quality AND t1.color=t5.color";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getShipDateWiseReportByMonth($where, $where_1){

        $sql = "SELECT F.*, A.total_carton_qty, B.total_cut_qty, D.total_end_pass_qty, E.total_packing_qty, 
                date_format(A.po_closing_date_time, '%Y-%m-%d') as po_closing_date,
                G.count_wh_qty, H.count_other_qty, I.total_cut_pass_qty, J.total_wash_qty,K.responsible_line
                
                FROM
                (SELECT po_no, so_no, purchase_order, brand, item, style_no, style_name, quality, 
                color, SUM(quantity) as order_quantity, ex_factory_date 
                FROM `tb_po_detail` 
                WHERE 1 $where $where_1
                GROUP BY po_no, so_no, purchase_order, item, style_no, quality, color, ex_factory_date) as F
                
                LEFT Join
                (SELECT COUNT(pc_tracking_no) as total_carton_qty, po_no, so_no, purchase_order, item, 
                quality, style_no, style_name, brand, size, color, max(carton_date_time) as po_closing_date_time 
                FROM `tb_care_labels` 
                WHERE carton_status=1
                GROUP BY po_no, so_no, purchase_order, item, style_no, quality, color) as A
                ON A.po_no=F.po_no AND F.so_no=A.so_no and A.purchase_order=F.purchase_order and A.item=F.item
                and A.style_no=F.style_no and A.quality=F.quality
                and A.color=F.color
                
                LEFT Join
                (SELECT po_no, so_no, purchase_order, item, style_no, quality, color, MIN(bundle) as bundle_start, MAX(bundle) as bundle_end, SUM(cut_qty) as total_cut_qty 
                 FROM `tb_cut_summary`
                GROUP BY po_no, so_no, purchase_order, item, style_no, quality, color) as B
                ON F.po_no=B.po_no AND F.so_no=B.so_no and F.purchase_order=B.purchase_order and F.item=B.item
                and F.style_no=B.style_no and F.quality=B.quality
                and F.color=B.color
                
                LEFT Join
                (SELECT COUNT(pc_tracking_no) as total_end_pass_qty, po_no, so_no, purchase_order, item, 
                quality, style_no, style_name, brand, size, color FROM `tb_care_labels` 
                WHERE access_points=4 AND access_points_status=4 
                GROUP BY po_no, so_no, purchase_order, item, style_no, quality, color) as D
                ON F.po_no=D.po_no AND F.so_no=D.so_no and F.purchase_order=D.purchase_order and F.item=D.item
                and F.style_no=D.style_no and F.quality=D.quality
                and F.color=D.color
                
                LEFT Join
                (SELECT COUNT(pc_tracking_no) as total_packing_qty, po_no, so_no, purchase_order, item, 
                quality, style_no, style_name, brand, size, color
                FROM `tb_care_labels` 
                WHERE packing_status=1
                GROUP BY po_no, so_no, purchase_order, item, style_no, quality, color) as E
                ON F.po_no=E.po_no AND F.so_no=E.so_no and F.purchase_order=E.purchase_order and F.item=E.item
                and F.style_no=E.style_no and F.quality=E.quality
                and F.color=E.color
                                
                LEFT Join
                (SELECT po_no, so_no, purchase_order, item, style_no, quality, color, COUNT(pc_tracking_no) as count_wh_qty
                FROM `tb_care_labels` WHERE warehouse_qa_type in (1,2,3,4)
                 GROUP BY po_no, so_no, purchase_order, item, style_no, quality, color) as G
                ON F.po_no=G.po_no AND F.so_no=G.so_no and F.purchase_order=G.purchase_order and F.item=G.item
                and F.style_no=G.style_no and F.quality=G.quality
                and F.color=G.color
                                       
                LEFT Join
                (SELECT po_no, so_no, purchase_order, item, style_no, quality, color, COUNT(pc_tracking_no) as count_other_qty
                FROM `tb_care_labels` WHERE warehouse_qa_type in (5, 6)
                 GROUP BY po_no, so_no, purchase_order, item, style_no, quality, color) as H
                ON F.po_no=H.po_no AND F.so_no=H.so_no and F.purchase_order=H.purchase_order and F.item=H.item
                and F.style_no=H.style_no and F.quality=H.quality
                and F.color=H.color
                                                             
                LEFT Join
                (SELECT po_no, so_no, purchase_order, item, style_no, quality, color, COUNT(pc_tracking_no) as total_cut_pass_qty,line_id
                FROM `tb_care_labels` WHERE sent_to_production=1 
                 GROUP BY po_no, so_no, purchase_order, item, style_no, quality, color) as I
                ON F.po_no=I.po_no AND F.so_no=I.so_no and F.purchase_order=I.purchase_order and F.item=I.item
                and F.style_no=I.style_no and F.quality=I.quality
                and F.color=I.color
                                                             
                LEFT Join
                (SELECT po_no, so_no, purchase_order, item, style_no, quality, color, COUNT(pc_tracking_no) as total_wash_qty
                FROM `tb_care_labels` WHERE washing_status=1 
                 GROUP BY po_no, so_no, purchase_order, item, style_no, quality, color) as J
                ON F.po_no=J.po_no AND F.so_no=J.so_no and F.purchase_order=J.purchase_order and F.item=J.item
                and F.style_no=J.style_no and F.quality=J.quality
                and F.color=J.color
                
                LEFT JOIN
                (SELECT t1.po_no, t1.so_no, t1.purchase_order, t1.style_no, t1.item, t1.quality, t1.color, 
                GROUP_CONCAT(t2.line_code SEPARATOR '; ') as responsible_line
                From (SELECT po_no, so_no, purchase_order, item, style_no, quality, color, line_id 
                FROM `tb_care_labels` WHERE line_id !=0 
                GROUP BY po_no, so_no, purchase_order, item, style_no, quality, color, line_id) as t1
                LEFT JOIN
                (SELECT id, line_name, line_code FROM `tb_line`) as t2 On t1.line_id=t2.id
                GROUP BY t1.po_no, t1.so_no, t1.purchase_order, t1.item, t1.quality, t1.color) as K
                ON F.po_no=K.po_no AND F.so_no=K.so_no and F.purchase_order=K.purchase_order and F.item=K.item
                and F.style_no=K.style_no and F.quality=K.quality
                and F.color=K.color
                                
                ORDER BY DATE_FORMAT(F.ex_factory_date, '%Y-%m-%d') DESC";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getWashDetailByDate($where){

        $sql = "SELECT * FROM `tb_care_labels` 
                WHERE 1 $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getWarehousePcsReport($where){

        $sql = "SELECT t1.*, t2.season FROM `tb_care_labels` as t1
                LEFT JOIN
                `tb_season` as t2
                ON t1.season_id=t2.id
                WHERE 1 $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getDateWiseCuttingReport($po_from_date){

//        $sql = "SELECT A.* FROM (SELECT t1.po_no, t1.so_no, t1.purchase_order, t1.item, t1.style_no, t1.style_name,
//                t1.quality, t1.color, t1.cut_pass_qty, t2.total_cut_pass_qty,
//                t3.total_order_qty, t3.ex_factory_date, t3.brand, t4.total_cut_qty,
//                t5.cut_collar_bundle_ready, t6.cut_cuff_bundle_ready,
//                t7.today_cut_collar_bundle_ready, t8.today_cut_cuff_bundle_ready
//
//                FROM
//                (SELECT *, COUNT(pc_tracking_no) as cut_pass_qty FROM `tb_care_labels`
//                 WHERE sent_to_production=1
//                 AND DATE_FORMAT(sent_to_production_date_time, '%Y-%m-%d') LIKE '%$po_from_date%'
//                 GROUP by po_no, so_no, purchase_order, item, quality, color) as t1
//
//                 LEFT JOIN
//                (SELECT *, COUNT(pc_tracking_no) as total_cut_pass_qty FROM `tb_care_labels`
//                 WHERE sent_to_production=1 GROUP by  po_no, so_no, purchase_order, item, quality, color) as t2
//                 ON t1.po_no=t2.po_no AND t1.so_no=t2.so_no AND t1.purchase_order=t2.purchase_order
//                 AND t1.item=t2.item AND t1.quality=t2.quality AND t1.color=t2.color
//
//                  LEFT JOIN
//                (SELECT *, SUM(quantity) as total_order_qty FROM `tb_po_detail`
//                GROUP by  po_no, so_no, purchase_order, item, quality, color) as t3
//                 ON t1.po_no=t3.po_no AND t1.so_no=t3.so_no AND t1.purchase_order=t3.purchase_order
//                 AND t1.item=t3.item AND t1.quality=t3.quality AND t1.color=t3.color
//
//                 LEFT JOIN
//                (SELECT *, SUM(cut_qty) as total_cut_qty FROM `tb_cut_summary`
//                GROUP by  po_no, so_no, purchase_order, item, quality, color) as t4
//                 ON t1.po_no=t4.po_no AND t1.so_no=t4.so_no AND t1.purchase_order=t4.purchase_order
//                 AND t1.item=t4.item AND t1.quality=t4.quality AND t1.color=t4.color
//
//                 LEFT JOIN
//                (SELECT *, SUM(cut_qty) as cut_collar_bundle_ready FROM `tb_cut_summary`
//                WHERE is_cutting_collar_bundle_ready=1
//                GROUP by po_no, so_no, purchase_order, item, quality, color) as t5
//                 ON t1.po_no=t5.po_no AND t1.so_no=t5.so_no AND t1.purchase_order=t5.purchase_order
//                 AND t1.item=t5.item AND t1.quality=t5.quality AND t1.color=t5.color
//
//                 LEFT JOIN
//                (SELECT *, SUM(cut_qty) as cut_cuff_bundle_ready FROM `tb_cut_summary`
//                WHERE is_cutting_cuff_bundle_ready=1 GROUP by po_no, so_no, purchase_order, item, quality, color) as t6
//                 ON t1.po_no=t6.po_no AND t1.so_no=t6.so_no AND t1.purchase_order=t6.purchase_order
//                 AND t1.item=t6.item AND t1.quality=t6.quality AND t1.color=t6.color
//
//                 LEFT JOIN
//                (SELECT *, SUM(cut_qty) as today_cut_collar_bundle_ready FROM `tb_cut_summary`
//                WHERE is_cutting_collar_bundle_ready=1
//                AND DATE_FORMAT(cutting_collar_bundle_ready_date_time, '%Y-%m-%d') LIKE '%$po_from_date%'
//                GROUP by po_no, so_no, purchase_order, item, quality, color) as t7
//                 ON t1.po_no=t7.po_no AND t1.so_no=t7.so_no AND t1.purchase_order=t7.purchase_order AND t1.item=t7.item
//                 AND t1.quality=t7.quality AND t1.color=t7.color
//
//
//                 LEFT JOIN
//                (SELECT *, SUM(cut_qty) as today_cut_cuff_bundle_ready FROM `tb_cut_summary`
//                WHERE is_cutting_cuff_bundle_ready=1
//                AND DATE_FORMAT(cutting_cuff_bundle_ready_date_time, '%Y-%m-%d') LIKE '%$po_from_date%'
//                GROUP by po_no, so_no, purchase_order, item, quality, color) as t8
//                 ON t1.po_no=t8.po_no AND t1.so_no=t8.so_no AND t1.purchase_order=t8.purchase_order AND t1.item=t8.item
//                 AND t1.quality=t8.quality AND t1.color=t8.color) as A
//
//                 UNION
//
//                SELECT B.* FROM (SELECT t0.po_no, t0.so_no, t0.purchase_order, t0.item, t0.style_no, t0.style_name,
//                t0.quality, t0.color, t1.cut_pass_qty, t2.total_cut_pass_qty,
//                t3.total_order_qty, t3.ex_factory_date, t3.brand, t4.total_cut_qty,
//                t5.cut_collar_bundle_ready, t6.cut_cuff_bundle_ready,
//                t7.today_cut_collar_bundle_ready, t8.today_cut_cuff_bundle_ready
//
//                FROM
//                (SELECT * FROM `tb_cut_summary`
//                 WHERE 1 AND DATE_FORMAT(cutting_collar_bundle_ready_date_time, '%Y-%m-%d') LIKE '%$po_from_date%'
//                 GROUP BY po_no, so_no, purchase_order, item, quality, color) as t0
//
//                LEFT JOIN
//                (SELECT *, COUNT(pc_tracking_no) as cut_pass_qty FROM `tb_care_labels`
//                 WHERE sent_to_production=1
//                 AND DATE_FORMAT(sent_to_production_date_time, '%Y-%m-%d') LIKE '%$po_from_date%'
//                 GROUP by po_no, so_no, purchase_order, item, quality, color) as t1
//                 ON t0.po_no=t1.po_no AND t0.so_no=t1.so_no AND t0.purchase_order=t1.purchase_order
//                 AND t0.item=t1.item AND t0.quality=t1.quality AND t0.color=t1.color
//
//                 LEFT JOIN
//                (SELECT *, COUNT(pc_tracking_no) as total_cut_pass_qty FROM `tb_care_labels`
//                 WHERE sent_to_production=1
//                 GROUP by  po_no, so_no, purchase_order, item, quality, color) as t2
//                 ON t0.po_no=t2.po_no AND t0.so_no=t2.so_no AND t0.purchase_order=t2.purchase_order
//                 AND t0.item=t2.item AND t0.quality=t2.quality AND t0.color=t2.color
//
//                  LEFT JOIN
//                (SELECT *, SUM(quantity) as total_order_qty FROM `tb_po_detail`
//                GROUP by  po_no, so_no, purchase_order, item, quality, color) as t3
//                 ON t0.po_no=t3.po_no AND t0.so_no=t3.so_no AND t0.purchase_order=t3.purchase_order
//                 AND t0.item=t3.item AND t0.quality=t3.quality AND t0.color=t3.color
//
//                 LEFT JOIN
//                (SELECT *, SUM(cut_qty) as total_cut_qty FROM `tb_cut_summary`
//                GROUP by  po_no, so_no, purchase_order, item, quality, color) as t4
//                 ON t0.po_no=t4.po_no AND t0.so_no=t4.so_no AND t0.purchase_order=t4.purchase_order
//                 AND t0.item=t4.item AND t0.quality=t4.quality AND t0.color=t4.color
//
//                 LEFT JOIN
//                (SELECT *, SUM(cut_qty) as cut_collar_bundle_ready FROM `tb_cut_summary`
//                WHERE is_cutting_collar_bundle_ready=1
//                GROUP by po_no, so_no, purchase_order, item, quality, color) as t5
//                 ON t0.po_no=t5.po_no AND t0.so_no=t5.so_no AND t0.purchase_order=t5.purchase_order
//                 AND t0.item=t5.item AND t0.quality=t5.quality AND t0.color=t5.color
//
//                 LEFT JOIN
//                (SELECT *, SUM(cut_qty) as cut_cuff_bundle_ready FROM `tb_cut_summary`
//                WHERE is_cutting_cuff_bundle_ready=1
//                GROUP by po_no, so_no, purchase_order, item, quality, color) as t6
//                 ON t0.po_no=t6.po_no AND t0.so_no=t6.so_no AND t0.purchase_order=t6.purchase_order
//                 AND t0.item=t6.item AND t0.quality=t6.quality AND t0.color=t6.color
//
//                 LEFT JOIN
//                (SELECT *, SUM(cut_qty) as today_cut_collar_bundle_ready FROM `tb_cut_summary`
//                WHERE is_cutting_collar_bundle_ready=1
//                AND DATE_FORMAT(cutting_collar_bundle_ready_date_time, '%Y-%m-%d') LIKE '%$po_from_date%'
//                GROUP by po_no, so_no, purchase_order, item, quality, color) as t7
//                 ON t0.po_no=t7.po_no AND t0.so_no=t7.so_no AND t0.purchase_order=t7.purchase_order AND t0.item=t7.item
//                 AND t0.quality=t7.quality AND t0.color=t7.color
//
//
//                 LEFT JOIN
//                (SELECT *, SUM(cut_qty) as today_cut_cuff_bundle_ready FROM `tb_cut_summary`
//                WHERE is_cutting_cuff_bundle_ready=1
//                AND DATE_FORMAT(cutting_cuff_bundle_ready_date_time, '%Y-%m-%d') LIKE '%$po_from_date%'
//                GROUP by po_no, so_no, purchase_order, item, quality, color) as t8
//                 ON t0.po_no=t8.po_no AND t0.so_no=t8.so_no AND t0.purchase_order=t8.purchase_order AND t0.item=t8.item
//                 AND t0.quality=t8.quality AND t0.color=t8.color) as B";

//        $sql = "SELECT A.* FROM (SELECT t1.po_no, t1.so_no, t1.purchase_order, t1.item, t1.style_no, t1.style_name,
//                t1.quality, t1.color, t1.cut_pass_qty, t2.total_cut_pass_qty,
//                t3.total_order_qty, t3.ex_factory_date, t3.brand, t4.total_cut_qty,
//                t5.cut_collar_bundle_ready, t6.cut_cuff_bundle_ready,
//                t7.today_cut_collar_bundle_ready, t8.today_cut_cuff_bundle_ready
//
//                FROM
//                (SELECT *, COUNT(pc_tracking_no) as cut_pass_qty FROM `vt_few_days_po_pcs`
//                 WHERE sent_to_production=1
//                 AND DATE_FORMAT(sent_to_production_date_time, '%Y-%m-%d') = '$po_from_date'
//                 GROUP by po_no, so_no, purchase_order, item, quality, color) as t1
//
//                 LEFT JOIN
//                (SELECT *, COUNT(pc_tracking_no) as total_cut_pass_qty FROM `vt_few_days_po_pcs`
//                 WHERE sent_to_production=1 GROUP by  po_no, so_no, purchase_order, item, quality, color) as t2
//                 ON t1.po_no=t2.po_no AND t1.so_no=t2.so_no AND t1.purchase_order=t2.purchase_order
//                 AND t1.item=t2.item AND t1.quality=t2.quality AND t1.color=t2.color
//
//                  LEFT JOIN
//                (SELECT *, SUM(quantity) as total_order_qty FROM `vt_po_detail`
//                GROUP by  po_no, so_no, purchase_order, item, quality, color) as t3
//                 ON t1.po_no=t3.po_no AND t1.so_no=t3.so_no AND t1.purchase_order=t3.purchase_order
//                 AND t1.item=t3.item AND t1.quality=t3.quality AND t1.color=t3.color
//
//                 LEFT JOIN
//                (SELECT *, SUM(cut_qty) as total_cut_qty FROM `vt_cut_summary`
//                GROUP by  po_no, so_no, purchase_order, item, quality, color) as t4
//                 ON t1.po_no=t4.po_no AND t1.so_no=t4.so_no AND t1.purchase_order=t4.purchase_order
//                 AND t1.item=t4.item AND t1.quality=t4.quality AND t1.color=t4.color
//
//                 LEFT JOIN
//                (SELECT *, SUM(cut_qty) as cut_collar_bundle_ready FROM `vt_cut_summary`
//                WHERE is_cutting_collar_bundle_ready=1
//                GROUP by po_no, so_no, purchase_order, item, quality, color) as t5
//                 ON t1.po_no=t5.po_no AND t1.so_no=t5.so_no AND t1.purchase_order=t5.purchase_order
//                 AND t1.item=t5.item AND t1.quality=t5.quality AND t1.color=t5.color
//
//                 LEFT JOIN
//                (SELECT *, SUM(cut_qty) as cut_cuff_bundle_ready FROM `vt_cut_summary`
//                WHERE is_cutting_cuff_bundle_ready=1 GROUP by po_no, so_no, purchase_order, item, quality, color) as t6
//                 ON t1.po_no=t6.po_no AND t1.so_no=t6.so_no AND t1.purchase_order=t6.purchase_order
//                 AND t1.item=t6.item AND t1.quality=t6.quality AND t1.color=t6.color
//
//                 LEFT JOIN
//                (SELECT *, SUM(cut_qty) as today_cut_collar_bundle_ready FROM `vt_cut_summary`
//                WHERE is_cutting_collar_bundle_ready=1
//                AND DATE_FORMAT(cutting_collar_bundle_ready_date_time, '%Y-%m-%d') = '$po_from_date'
//                GROUP by po_no, so_no, purchase_order, item, quality, color) as t7
//                 ON t1.po_no=t7.po_no AND t1.so_no=t7.so_no AND t1.purchase_order=t7.purchase_order AND t1.item=t7.item
//                 AND t1.quality=t7.quality AND t1.color=t7.color
//
//
//                 LEFT JOIN
//                (SELECT *, SUM(cut_qty) as today_cut_cuff_bundle_ready FROM `vt_cut_summary`
//                WHERE is_cutting_cuff_bundle_ready=1
//                AND DATE_FORMAT(cutting_cuff_bundle_ready_date_time, '%Y-%m-%d') = '$po_from_date'
//                GROUP by po_no, so_no, purchase_order, item, quality, color) as t8
//                 ON t1.po_no=t8.po_no AND t1.so_no=t8.so_no AND t1.purchase_order=t8.purchase_order AND t1.item=t8.item
//                 AND t1.quality=t8.quality AND t1.color=t8.color) as A
//
//                 UNION
//
//                SELECT B.* FROM (SELECT t0.po_no, t0.so_no, t0.purchase_order, t0.item, t0.style_no, t0.style_name,
//                t0.quality, t0.color, t1.cut_pass_qty, t2.total_cut_pass_qty,
//                t3.total_order_qty, t3.ex_factory_date, t3.brand, t4.total_cut_qty,
//                t5.cut_collar_bundle_ready, t6.cut_cuff_bundle_ready,
//                t7.today_cut_collar_bundle_ready, t8.today_cut_cuff_bundle_ready
//
//                FROM
//                (SELECT * FROM `tb_cut_summary`
//                 WHERE 1 AND DATE_FORMAT(cutting_collar_bundle_ready_date_time, '%Y-%m-%d') = '$po_from_date'
//                 GROUP BY po_no, so_no, purchase_order, item, quality, color) as t0
//
//                LEFT JOIN
//                (SELECT *, COUNT(pc_tracking_no) as cut_pass_qty FROM `vt_few_days_po_pcs`
//                 WHERE sent_to_production=1
//                 AND DATE_FORMAT(sent_to_production_date_time, '%Y-%m-%d') = '$po_from_date'
//                 GROUP by po_no, so_no, purchase_order, item, quality, color) as t1
//                 ON t0.po_no=t1.po_no AND t0.so_no=t1.so_no AND t0.purchase_order=t1.purchase_order
//                 AND t0.item=t1.item AND t0.quality=t1.quality AND t0.color=t1.color
//
//                 LEFT JOIN
//                (SELECT *, COUNT(pc_tracking_no) as total_cut_pass_qty FROM `vt_few_days_po_pcs`
//                 WHERE sent_to_production=1
//                 GROUP by  po_no, so_no, purchase_order, item, quality, color) as t2
//                 ON t0.po_no=t2.po_no AND t0.so_no=t2.so_no AND t0.purchase_order=t2.purchase_order
//                 AND t0.item=t2.item AND t0.quality=t2.quality AND t0.color=t2.color
//
//                  LEFT JOIN
//                (SELECT *, SUM(quantity) as total_order_qty FROM `vt_po_detail`
//                GROUP by  po_no, so_no, purchase_order, item, quality, color) as t3
//                 ON t0.po_no=t3.po_no AND t0.so_no=t3.so_no AND t0.purchase_order=t3.purchase_order
//                 AND t0.item=t3.item AND t0.quality=t3.quality AND t0.color=t3.color
//
//                 LEFT JOIN
//                (SELECT *, SUM(cut_qty) as total_cut_qty FROM `vt_cut_summary`
//                GROUP by  po_no, so_no, purchase_order, item, quality, color) as t4
//                 ON t0.po_no=t4.po_no AND t0.so_no=t4.so_no AND t0.purchase_order=t4.purchase_order
//                 AND t0.item=t4.item AND t0.quality=t4.quality AND t0.color=t4.color
//
//                 LEFT JOIN
//                (SELECT *, SUM(cut_qty) as cut_collar_bundle_ready FROM `vt_cut_summary`
//                WHERE is_cutting_collar_bundle_ready=1
//                GROUP by po_no, so_no, purchase_order, item, quality, color) as t5
//                 ON t0.po_no=t5.po_no AND t0.so_no=t5.so_no AND t0.purchase_order=t5.purchase_order
//                 AND t0.item=t5.item AND t0.quality=t5.quality AND t0.color=t5.color
//
//                 LEFT JOIN
//                (SELECT *, SUM(cut_qty) as cut_cuff_bundle_ready FROM `vt_cut_summary`
//                WHERE is_cutting_cuff_bundle_ready=1
//                GROUP by po_no, so_no, purchase_order, item, quality, color) as t6
//                 ON t0.po_no=t6.po_no AND t0.so_no=t6.so_no AND t0.purchase_order=t6.purchase_order
//                 AND t0.item=t6.item AND t0.quality=t6.quality AND t0.color=t6.color
//
//                 LEFT JOIN
//                (SELECT *, SUM(cut_qty) as today_cut_collar_bundle_ready FROM `vt_cut_summary`
//                WHERE is_cutting_collar_bundle_ready=1
//                AND DATE_FORMAT(cutting_collar_bundle_ready_date_time, '%Y-%m-%d') = '$po_from_date'
//                GROUP by po_no, so_no, purchase_order, item, quality, color) as t7
//                 ON t0.po_no=t7.po_no AND t0.so_no=t7.so_no AND t0.purchase_order=t7.purchase_order AND t0.item=t7.item
//                 AND t0.quality=t7.quality AND t0.color=t7.color
//
//
//                 LEFT JOIN
//                (SELECT *, SUM(cut_qty) as today_cut_cuff_bundle_ready FROM `vt_cut_summary`
//                WHERE is_cutting_cuff_bundle_ready=1
//                AND DATE_FORMAT(cutting_cuff_bundle_ready_date_time, '%Y-%m-%d') = '$po_from_date'
//                GROUP by po_no, so_no, purchase_order, item, quality, color) as t8
//                 ON t0.po_no=t8.po_no AND t0.so_no=t8.so_no AND t0.purchase_order=t8.purchase_order AND t0.item=t8.item
//                 AND t0.quality=t8.quality AND t0.color=t8.color) as B";

        $sql1="SELECT t1.*,t2.total_order_qty,t7.today_cut_collar_bundle_ready,t8.today_cut_cuff_bundle_ready,t9.total_cut_qty 


            FROM (SELECT po_no,so_no,item,quality,color,style_name,style_no,purchase_order,brand,ex_factory_date,
              COUNT(sent_to_production_date_time) as cut_pass_qty
			 
              
           FROM (
              SELECT
                so_no,po_no,item,quality,color,purchase_order,brand,ex_factory_date,packing_date_time,style_name,style_no,
          
               CASE WHEN sent_to_production_date_time !='0000-00-00 00:00:00' THEN id END sent_to_production_date_time
           
              FROM vt_few_days_po_pcs   WHERE DATE_FORMAT(sent_to_production_date_time, '%Y-%m-%d') = '$po_from_date'  
            ) vt_few_days_po_pcs GROUP BY so_no,po_no,item,quality,color,purchase_order) as t1
            LEFT JOIN
            vt_po_summary as t2
            ON t1.so_no=t2.so_no AND t1.po_no=t2.po_no AND t1.purchase_order=t2.purchase_order AND t1.quality=t2.quality AND t1.color=t2.color
            
            LEFT JOIN
                (SELECT po_no,so_no,purchase_order,item,quality,color, SUM(cut_qty) as today_cut_collar_bundle_ready FROM `tb_cut_summary`
                WHERE is_cutting_collar_bundle_ready=1
                AND DATE_FORMAT(cutting_collar_bundle_ready_date_time, '%Y-%m-%d') = '$po_from_date'
                GROUP by po_no, so_no, purchase_order, item, quality, color) as t7
                 ON t1.po_no=t7.po_no AND t1.so_no=t7.so_no AND t1.purchase_order=t7.purchase_order AND t1.item=t7.item
                 AND t1.quality=t7.quality AND t1.color=t7.color
            
            LEFT JOIN
                (SELECT po_no,so_no,purchase_order,item,quality,color, SUM(cut_qty) as today_cut_cuff_bundle_ready FROM `tb_cut_summary`
                WHERE is_cutting_cuff_bundle_ready=1
                AND DATE_FORMAT(cutting_cuff_bundle_ready_date_time, '%Y-%m-%d') = '$po_from_date'
                GROUP by po_no, so_no, purchase_order, item, quality, color) as t8
                 ON t1.po_no=t8.po_no AND t1.so_no=t8.so_no AND t1.purchase_order=t8.purchase_order AND t1.item=t8.item
                 AND t1.quality=t8.quality AND t1.color=t8.color
                 
                 LEFT JOIN 
                (SELECT po_no,so_no,item,quality,color,style_name,style_no,purchase_order,brand,ex_factory_date,
              COUNT(id) as total_cut_qty
			 
              
           FROM (
              SELECT
                so_no,po_no,item,quality,color,purchase_order,brand,ex_factory_date,packing_date_time,style_name,style_no,
          
               CASE WHEN id !='0' THEN id END id
           
              FROM vt_few_days_po_pcs  
            ) vt_few_days_po_pcs GROUP BY so_no,po_no,item,quality,color,purchase_order) as t9
            ON t1.po_no=t9.po_no AND t1.so_no=t9.so_no AND t1.purchase_order=t9.purchase_order AND t1.item=t9.item
                 AND t1.quality=t9.quality AND t1.color=t9.color";

        $sql="SELECT t1.*, t2.total_order_qty ,t3.total_cut_qty,t3.bundle_start,t3.bundle_end,t3.cutting_collar_bundle_ready_date_time
                FROM (
                SELECT po_no,so_no,item,quality,color,purchase_order,ex_factory_date,brand,style_no,style_name, planned_line_id,
                  
                SUM(CASE WHEN is_package_ready=1
                THEN cut_qty
                ELSE 0 end) AS count_package_ready_qty
                
                FROM tb_cut_summary WHERE DATE_FORMAT(package_ready_date_time,'%Y-%m-%d')='$po_from_date' GROUP BY po_no,so_no,item,quality,color,purchase_order
                )  as t1
                LEFT JOIN
                vt_po_summary as t2
                ON t1.so_no=t2.so_no AND t1.po_no=t2.po_no AND t1.purchase_order=t2.purchase_order AND t1.item=t2.item AND t1.quality=t2.quality AND t1.color=t2.color
                LEFT JOIN
                vt_cut as t3
                ON t1.so_no=t3.so_no AND t1.po_no=t3.po_no AND t1.purchase_order=t3.purchase_order 
                AND t1.item=t3.item AND t1.quality=t3.quality AND t1.color=t3.color
                ORDER  BY cutting_collar_bundle_ready_date_time";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getDateWisePackingReport($po_from_date, $floor_id){
        $sql = "SELECT t1.*, t2.total_order_qty, t2.count_packing_pass
                FROM (SELECT po_no, so_no, brand, purchase_order, style_no,
                style_name, item, quality, color, ex_factory_date,
                COUNT(pc_tracking_no) as packing_qty
                FROM `tb_care_labels`
                WHERE DATE_FORMAT(packing_date_time, '%Y-%m-%d') = '$po_from_date'
                AND finishing_floor_id=$floor_id
                GROUP BY po_no, so_no, purchase_order, item, quality, color, finishing_floor_id) AS t1
                LEFT JOIN
                tb_production_summary AS t2
                ON t1.so_no=t2.so_no";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getDateWiseCartonReport($po_from_date, $floor_id){
        $sql = "SELECT po_no, so_no, brand, purchase_order, style_no,
                style_name, item, quality, color, ex_factory_date,
                COUNT(pc_tracking_no) as carton_qty
                FROM `tb_care_labels`
                WHERE DATE_FORMAT(carton_date_time, '%Y-%m-%d') = '$po_from_date' 
                AND finishing_floor_id=$floor_id
                GROUP BY po_no, so_no, purchase_order, item, quality, color, finishing_floor_id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getLineProductionSummaryReport($date, $starting_time, $ending_time){

//        $sql = "SELECT I.id as line_id, I.line_name, I.line_code, J.floor_name, K.target,
//                B.total_line_output, F.line_normal_hours_output
//
//                FROM
//                (SELECT line_id
//                FROM `tb_care_labels` WHERE line_id != 0 GROUP BY  line_id) as A
//
//                LEFT JOIN
//                (SELECT line_id, COUNT(pc_tracking_no) as total_line_output,
//                DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') as end_line_qc_date_time
//                FROM `tb_care_labels` WHERE line_id !=0 AND access_points_status=4
//                AND DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') LIKE '%$date%'
//                GROUP BY DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d'), line_id) as B
//                ON A.line_id=B.line_id
//
//                LEFT JOIN
//                (SELECT line_id, COUNT(pc_tracking_no) as line_normal_hours_output,
//                DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') as end_line_qc_date_time
//                FROM `tb_care_labels` WHERE line_id !=0 AND access_points_status=4
//                AND DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') LIKE '%$date%'
//                AND TIME_FORMAT(end_line_qc_date_time, '%H:%i:%s') BETWEEN '$starting_time' AND '$ending_time'
//                GROUP BY DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d'), line_id) as F
//                ON A.line_id=F.line_id
//
//                LEFT JOIN
//                (SELECT line_id, target, `date`
//                FROM `line_daily_target`
//                WHERE line_id !=0 AND `date` LIKE '%$date%'
//                GROUP BY line_id) as K
//                ON A.line_id=K.line_id
//
//                LEFT JOIN
//                tb_line as I ON A.line_id=I.id
//
//                LEFT JOIN
//                tb_floor as J ON I.floor=J.id
//
//				ORDER BY (I.line_code * 1)";

//        $sql = "SELECT I.id as line_id, I.line_name, I.line_code, J.floor_name, K.target,
//                K.remarks, B.total_line_output, F.line_normal_hours_output
//
//                FROM
//                (SELECT line_id
//                FROM `vt_few_days_line_end_pass` WHERE line_id != 0 GROUP BY  line_id) as A
//
//                LEFT JOIN
//                (SELECT line_id, COUNT(pc_tracking_no) as total_line_output,
//                DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') as end_line_qc_date_time
//                FROM `vt_few_days_line_end_pass` WHERE line_id !=0
//                AND DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') LIKE '%$date%'
//                GROUP BY DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d'), line_id) as B
//                ON A.line_id=B.line_id
//
//                LEFT JOIN
//                (SELECT line_id, COUNT(pc_tracking_no) as line_normal_hours_output,
//                DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') as end_line_qc_date_time
//                FROM `vt_few_days_line_end_pass` WHERE line_id !=0
//                AND DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') LIKE '%$date%'
//                AND TIME_FORMAT(end_line_qc_date_time, '%H:%i:%s') BETWEEN '$starting_time' AND '$ending_time'
//                GROUP BY DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d'), line_id) as F
//                ON A.line_id=F.line_id
//
//                LEFT JOIN
//                (SELECT line_id, target, `date`, remarks
//                FROM `line_daily_target`
//                WHERE line_id !=0 AND `date` LIKE '%$date%'
//                GROUP BY line_id) as K
//                ON A.line_id=K.line_id
//
//                LEFT JOIN
//                tb_line as I ON A.line_id=I.id
//
//                LEFT JOIN
//                tb_floor as J ON I.floor=J.id
//
//				ORDER BY (I.line_code * 1)";

        $sql = "SELECT A.line_id, A.line_name, A.line_code, J.floor_name, K.target, 
                K.remarks, B.total_line_output, F.line_normal_hours_output
                
                FROM 
                (SELECT id AS line_id, line_name, 
                line_code, floor, status 
                FROM `tb_line` WHERE status=1) as A
                
                LEFT JOIN
                (SELECT line_id, COUNT(pc_tracking_no) as total_line_output, 
                DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') as end_line_qc_date_time 
                FROM `vt_few_days_po_pcs` WHERE line_id != 0
                AND DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') = '$date' 
                GROUP BY DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d'), line_id) as B
                ON A.line_id=B.line_id
                
                LEFT JOIN
                (SELECT line_id, COUNT(pc_tracking_no) as line_normal_hours_output, 
                DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') as end_line_qc_date_time 
                FROM `vt_few_days_po_pcs` WHERE line_id !=0
                AND DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') = '$date' 
                AND TIME_FORMAT(end_line_qc_date_time, '%H:%i:%s') BETWEEN '$starting_time' AND '$ending_time'
                GROUP BY DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d'), line_id) as F
                ON A.line_id=F.line_id
                
                LEFT JOIN
                (SELECT line_id, target, `date`, remarks
                FROM `line_daily_target` 
                WHERE line_id !=0 AND `date` = '$date'
                GROUP BY line_id) as K
                ON A.line_id=K.line_id
                                
                LEFT JOIN
                tb_floor as J ON A.floor=J.id
                
				ORDER BY (A.line_code * 1)";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getTodayLineProductionSummaryReportPre($date, $starting_time, $ending_time){
        $sql = "SELECT A.line_id, A.line_name, A.line_code, J.floor_name, K.target, 
                K.remarks, B.total_line_output, F.line_normal_hours_output
                
                FROM 
                (SELECT id AS line_id, line_name, 
                line_code, floor, status 
                FROM `tb_line` WHERE status=1) as A
                
                LEFT JOIN
                (SELECT line_id, COUNT(pc_tracking_no) as total_line_output, 
                DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') as end_line_qc_date_time 
                FROM `vt_today_line_end_pass` WHERE line_id !=0
                GROUP BY DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d'), line_id) as B
                ON A.line_id=B.line_id
                
                LEFT JOIN
                (SELECT line_id, COUNT(pc_tracking_no) as line_normal_hours_output, 
                DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') as end_line_qc_date_time 
                FROM `vt_today_line_end_pass` WHERE line_id !=0 
                AND TIME_FORMAT(end_line_qc_date_time, '%H:%i:%s') BETWEEN '$starting_time' AND '$ending_time'
                GROUP BY DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d'), line_id) as F
                ON A.line_id=F.line_id
                
                LEFT JOIN
                (SELECT line_id, target, `date`, remarks
                FROM `line_daily_target` 
                WHERE line_id !=0 AND `date` = '$date'
                GROUP BY line_id) as K
                ON A.line_id=K.line_id
                                
                LEFT JOIN
                tb_floor as J ON A.floor=J.id
                
				ORDER BY (A.line_code * 1)";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getTodayLineProductionSummaryReport($date, $floor_id){
        $sql = "SELECT A.line_id, A.line_name, A.line_code, J.floor_name, K.target, 
                K.remarks, B.total_line_output, B.efficiency, B.wip, B.dhu_sum,
                B.work_hour_1, B.work_hour_2, B.work_hour_3, B.work_hour_4
                
                FROM 
                (SELECT id AS line_id, line_name, 
                line_code, floor, status 
                FROM `tb_line` WHERE status=1 AND floor=$floor_id) as A
                
                LEFT JOIN
                (SELECT line_id, `date`, SUM(qty) as total_line_output, efficiency, wip, SUM(dhu) AS dhu_sum,
                work_hour_1, work_hour_2, work_hour_3, work_hour_4
                FROM `tb_today_line_output_qty` WHERE line_id !=0
                AND `date`='$date'
                GROUP BY `date`, line_id) as B
                ON A.line_id=B.line_id
                                
                LEFT JOIN
                (SELECT line_id, target, `date`, remarks
                FROM `line_daily_target` 
                WHERE line_id !=0 AND `date` = '$date'
                GROUP BY line_id) as K
                ON A.line_id=K.line_id
                                
                LEFT JOIN
                tb_floor as J ON A.floor=J.id
                
				ORDER BY (A.line_code * 1)";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function lineWiseWipDetailReport($line_id, $search_date){
        $sql = "SELECT t1.* FROM
                (SELECT po_no, so_no, purchase_order, item, quality, color, style_no, 
                style_name, line_id, ex_factory_date, line_po_balance 
                FROM `tb_line_running_pos`
                WHERE line_id=$line_id) AS t1";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getSecondFloorLineProductionSummaryReport($date, $starting_time, $ending_time, $condition){

        $sql = "SELECT A.id as line_id, A.line_name, A.line_code, J.floor_name, K.target, 
                B.total_line_output, F.line_normal_hours_output
                
                FROM 
                (SELECT * FROM `tb_line` WHERE 1 $condition AND status=1) as A
                
                LEFT JOIN
                (SELECT line_id, COUNT(pc_tracking_no) as total_line_output, 
                DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') as end_line_qc_date_time 
                FROM `vt_few_days_po_pcs` WHERE line_id !=0
                AND DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') = '$date' 
                GROUP BY DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d'), line_id) as B
                ON A.id=B.line_id
                
                LEFT JOIN
                (SELECT line_id, COUNT(pc_tracking_no) as line_normal_hours_output, 
                DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') as end_line_qc_date_time 
                FROM `vt_few_days_po_pcs` WHERE line_id !=0 AND access_points_status=4
                AND DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') = '$date' 
                AND TIME_FORMAT(end_line_qc_date_time, '%H:%i:%s') BETWEEN '$starting_time' AND '$ending_time'
                GROUP BY DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d'), line_id) as F
                ON A.id=F.line_id
                
                LEFT JOIN
                (SELECT line_id, target, `date`
                FROM `line_daily_target` 
                WHERE line_id !=0 AND `date` = '$date'
                GROUP BY line_id) as K
                ON A.id=K.line_id
                                
                LEFT JOIN
                tb_floor as J ON A.floor=J.id
                         
				ORDER BY (A.line_code * 1)";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getSecondFloorLineProductionSummary($date,  $condition)
    {
        $sql="SELECT A.id as line_id, A.line_name, A.line_code, K.*
                     
                FROM 
                (SELECT * FROM `tb_line` WHERE 1 $condition AND status=1) as A
                
                LEFT JOIN
                (SELECT *
                FROM `tb_daily_line_summary` 
                WHERE line_id !=0 AND `date` = '$date'
                GROUP BY line_id) as K
                ON A.id=K.line_id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getDailyPerformanceDetail($line_id, $date){
        $sql = "SELECT t1.*, t2.smv, t2.order_qty, t3.count_end_line_qc_pass
                From
                (SELECT so_no, po_no, brand, purchase_order, style_no, style_name, item, quality, color, ex_factory_date, 
                COUNT(pc_tracking_no) as line_output_po_qty
                FROM `tb_care_labels` 
                WHERE 
                access_points=4 AND access_points_status=4
                AND DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') = '$date'
                AND line_id=$line_id AND manually_closed=0
                GROUP BY so_no, po_no, purchase_order, item, quality, color, line_id) AS t1
                
                LEFT JOIN 
                (SELECT so_no, po_no, smv, purchase_order, style_no, style_name, item, quality, color,
                 SUM(quantity) as order_qty
                FROM `tb_po_detail` GROUP BY so_no, po_no, purchase_order, item, quality, color) AS t2
                ON t1.so_no=t2.so_no AND t1.po_no=t2.po_no AND t1.purchase_order=t2.purchase_order 
                AND t1.item=t2.item AND t1.quality=t2.quality AND t1.color=t2.color
                
                LEFT JOIN 
                tb_production_summary as t3
                ON t1.so_no=t3.so_no AND t1.po_no=t3.po_no AND t1.purchase_order=t3.purchase_order 
                AND t1.item=t3.item AND t1.quality=t3.quality AND t1.color=t3.color";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getFinishingProductionSummaryReport($date, $starting_time, $ending_time){

//        $sql = "SELECT J.floor_name, K.target,
//                B.total_finishing_output, F.finishing_normal_hours_output
//
//                FROM
//                (SELECT finishing_floor_id
//                FROM `tb_care_labels` WHERE finishing_floor_id !=0 GROUP BY  finishing_floor_id) as A
//
//                LEFT JOIN
//                (SELECT finishing_floor_id, COUNT(pc_tracking_no) as total_finishing_output,
//                DATE_FORMAT(carton_date_time, '%Y-%m-%d') as finishing_date_time
//                FROM `tb_care_labels` WHERE finishing_floor_id !=0 AND carton_status=1
//                AND DATE_FORMAT(carton_date_time, '%Y-%m-%d') LIKE '%$date%'
//                GROUP BY DATE_FORMAT(carton_date_time, '%Y-%m-%d'), finishing_floor_id) as B
//                ON A.finishing_floor_id=B.finishing_floor_id
//
//                LEFT JOIN
//                (SELECT finishing_floor_id, COUNT(pc_tracking_no) as finishing_normal_hours_output
//                FROM `tb_care_labels` WHERE finishing_floor_id !=0 AND carton_status=1
//                AND DATE_FORMAT(carton_date_time, '%Y-%m-%d') LIKE '%$date%'
//                AND TIME_FORMAT(carton_date_time, '%H:%i:%s') BETWEEN '$starting_time' AND '$ending_time'
//                GROUP BY DATE_FORMAT(carton_date_time, '%Y-%m-%d'), finishing_floor_id) as F
//                ON A.finishing_floor_id=F.finishing_floor_id
//
//                LEFT JOIN
//                (SELECT floor_id, target, `date`
//                FROM `finishing_daily_target`
//                WHERE floor_id !=0 AND `date` LIKE '%$date%'
//                GROUP BY floor_id) as K
//                ON A.finishing_floor_id=K.floor_id
//
//                LEFT JOIN
//                tb_floor as J ON A.finishing_floor_id=J.id
//
//				ORDER BY J.id";


        $sql = "SELECT A.finishing_floor_id, J.floor_name, K.target, 
                B.total_finishing_output, F.finishing_normal_hours_output
                
                FROM 
                (SELECT finishing_floor_id
                FROM `vt_few_days_po_pcs` WHERE finishing_floor_id !=0 GROUP BY  finishing_floor_id) as A
                
                LEFT JOIN
                (SELECT finishing_floor_id, COUNT(pc_tracking_no) as total_finishing_output, 
                DATE_FORMAT(packing_date_time, '%Y-%m-%d') as finishing_date_time 
                FROM `vt_few_days_po_pcs` WHERE finishing_floor_id !=0
                AND DATE_FORMAT(packing_date_time, '%Y-%m-%d') = '$date' 
                GROUP BY DATE_FORMAT(packing_date_time, '%Y-%m-%d'), finishing_floor_id) as B
                ON A.finishing_floor_id=B.finishing_floor_id
                
                LEFT JOIN
                (SELECT finishing_floor_id, COUNT(pc_tracking_no) as finishing_normal_hours_output
                FROM `vt_few_days_po_pcs` WHERE finishing_floor_id !=0
                AND DATE_FORMAT(packing_date_time, '%Y-%m-%d') = '$date' 
                AND TIME_FORMAT(packing_date_time, '%H:%i:%s') BETWEEN '$starting_time' AND '$ending_time'
                GROUP BY DATE_FORMAT(packing_date_time, '%Y-%m-%d'), finishing_floor_id) as F
                ON A.finishing_floor_id=F.finishing_floor_id
                
                LEFT JOIN
                (SELECT floor_id, target, `date`
                FROM `finishing_daily_target` 
                WHERE floor_id !=0 AND `date` = '$date'
                GROUP BY floor_id) as K
                ON A.finishing_floor_id=K.floor_id
                                
                LEFT JOIN
                tb_floor as J ON A.finishing_floor_id=J.id
                                
				ORDER BY J.id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getFinishingProductionReport($date, $starting_time, $ending_time){
        $sql = "SELECT A.finishing_floor_id, A.floor_name, K.target, 
                B.total_finishing_output, F.finishing_normal_hours_output
                
                FROM 
                (SELECT id as finishing_floor_id, floor_name
                FROM `tb_floor` WHERE status=1) as A
                
                LEFT JOIN
                (SELECT finishing_floor_id, COUNT(pc_tracking_no) as total_finishing_output, 
                DATE_FORMAT(packing_date_time, '%Y-%m-%d') as finishing_date_time 
                FROM `vt_few_days_po_pcs` WHERE finishing_floor_id !=0 
                AND DATE_FORMAT(packing_date_time, '%Y-%m-%d') = '$date'
                GROUP BY DATE_FORMAT(packing_date_time, '%Y-%m-%d'), finishing_floor_id) as B
                ON A.finishing_floor_id=B.finishing_floor_id
                
                LEFT JOIN
                (SELECT finishing_floor_id, COUNT(pc_tracking_no) as finishing_normal_hours_output
                FROM `vt_few_days_po_pcs` WHERE finishing_floor_id !=0 
                AND TIME_FORMAT(packing_date_time, '%H:%i:%s') BETWEEN '$starting_time' AND '$ending_time'
                AND DATE_FORMAT(packing_date_time, '%Y-%m-%d') = '$date'
                GROUP BY DATE_FORMAT(packing_date_time, '%Y-%m-%d'), finishing_floor_id) as F
                ON A.finishing_floor_id=F.finishing_floor_id
                
                LEFT JOIN
                (SELECT floor_id, target, `date`
                FROM `finishing_daily_target` 
                WHERE floor_id !=0 AND `date` = '$date'
                GROUP BY floor_id) as K
                ON A.finishing_floor_id=K.floor_id
                                                        
				ORDER BY A.finishing_floor_id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getSecondFloorFinishingProductionSummaryReport($date, $starting_time, $ending_time, $condition){

        $sql = "SELECT A.id as floor_id, A.floor_name, K.target, 
                B.total_finishing_output, F.finishing_normal_hours_output
                
                FROM 
                (SELECT * FROM `tb_floor` WHERE 1 $condition AND status=1) as A
                
                LEFT JOIN
                (SELECT finishing_floor_id, COUNT(pc_tracking_no) as total_finishing_output, 
                DATE_FORMAT(packing_date_time, '%Y-%m-%d') as finishing_date_time 
                FROM `vt_few_days_po_pcs` WHERE finishing_floor_id=2
                AND DATE_FORMAT(packing_date_time, '%Y-%m-%d') = '$date'
                GROUP BY DATE_FORMAT(packing_date_time, '%Y-%m-%d'), finishing_floor_id) as B
                ON A.id=B.finishing_floor_id
                
                LEFT JOIN
                (SELECT finishing_floor_id, COUNT(pc_tracking_no) as finishing_normal_hours_output
                FROM `vt_few_days_po_pcs` WHERE finishing_floor_id=2
                AND DATE_FORMAT(packing_date_time, '%Y-%m-%d') = '$date' 
                AND TIME_FORMAT(packing_date_time, '%H:%i:%s') BETWEEN '$starting_time' AND '$ending_time'
                GROUP BY DATE_FORMAT(packing_date_time, '%Y-%m-%d'), finishing_floor_id) as F
                ON A.id=F.finishing_floor_id
                
                LEFT JOIN
                (SELECT floor_id, target, `date`
                FROM `finishing_daily_target` 
                WHERE floor_id=2 AND `date` = '$date'
                GROUP BY floor_id) as K
                ON A.id=K.floor_id
                                
				ORDER BY A.id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getSecondFloorFinishingProductionSummary($previous_date,  $condition2)
    {
        $sql="SELECT * FROM `tb_daily_finish_summary` WHERE date='$previous_date' $condition2";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getPoOrderInfobyPo($where){
        $sql = "SELECT A.*, B.count_scanned_pc, C.count_unscanned_pc FROM
                (SELECT po_no, purchase_order, brand, item, style_no, style_name, quality, 
                color, SUM(quantity) as order_quality, ex_factory_date 
                FROM `tb_po_detail` GROUP BY purchase_order, item, style_no, quality, color) as A

                LEFT Join

                (SELECT COUNT(pc_tracking_no) as count_scanned_pc, purchase_order, item, 
                quality, style_no, style_name, brand, size, color FROM `tb_care_labels` 
                WHERE sent_to_production=1 GROUP BY purchase_order, item, style_no, quality, color) as B

                ON A.purchase_order=B.purchase_order and A.item=B.item
                and A.style_no=B.style_no and A.quality=B.quality
                and A.color=B.color
                
                LEFT Join

                (SELECT COUNT(pc_tracking_no) as count_unscanned_pc, purchase_order, item, 
                quality, style_no, style_name, brand, size, color FROM `tb_care_labels` 
                WHERE sent_to_production=0 GROUP BY purchase_order, item, style_no, quality, color) as C

                ON A.purchase_order=C.purchase_order and A.item=C.item
                and A.style_no=C.style_no and A.quality=C.quality
                and A.color=C.color
                
                WHERE 1 $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getPoOrderPackingInfobyPo($where){
        $sql="SELECT t1.*,t2.cut_qty, t3.cut_pass_qty,t4.sew_qty,t5.total_packing_qty,t6.total_carton_qty, t8.total_manually_closed_qty
                FROM
                (SELECT po_no,so_no,item,quality,color,purchase_order,style_no,style_name, ex_factory_date, status, 
                `size`,SUM(quantity) AS order_qty from tb_po_detail
                  WHERE 1 $where
                 GROUP BY po_no,so_no,item,quality,color,purchase_order,size) as t1
                 
                LEFT JOIN
                (SELECT po_no,so_no,item,quality,color,purchase_order,size,COUNT(id) as cut_qty FROM `tb_care_labels` 
                WHERE 1 $where
                 GROUP BY po_no,so_no,item,quality,color,purchase_order,size) as t2
                
                ON t1.so_no=t2.so_no AND t1.size=t2.size
                
                LEFT JOIN
                (SELECT po_no,so_no,item,quality,color,purchase_order,size,COUNT(id) as cut_pass_qty FROM `tb_care_labels` 
                WHERE 1 $where and sent_to_production=1 GROUP BY po_no,so_no,item,quality,color,purchase_order,size) as t3
                
                ON t1.so_no=t3.so_no AND t1.size=t3.size
                
                  LEFT JOIN
                (SELECT po_no,so_no,item,quality,color,purchase_order,size,COUNT(id) as sew_qty FROM `tb_care_labels` 
                WHERE 1 $where and access_points_status=4 GROUP BY po_no,so_no,item,quality,color,purchase_order,size) as t4
                
                ON t1.so_no=t4.so_no AND t1.size=t4.size
                
                  LEFT JOIN
                (SELECT po_no,so_no,item,quality,color,purchase_order,size,COUNT(id) as total_packing_qty FROM `tb_care_labels` 
                WHERE 1 $where and packing_status=1 GROUP BY po_no,so_no,item,quality,color,purchase_order,size) as t5
                
                ON t1.so_no=t5.so_no AND t1.size=t5.size
                
                 LEFT JOIN
                (SELECT po_no,so_no,item,quality,color,purchase_order,size,COUNT(id) as total_carton_qty FROM `tb_care_labels` 
                WHERE 1 $where and carton_status=1 GROUP BY po_no,so_no,item,quality,color,purchase_order,size) as t6
                
                ON t1.so_no=t6.so_no AND t1.size=t6.size
                
                 LEFT JOIN
                `tb_size_serial` as t7
                ON t1.size=t7.size
                
                 LEFT JOIN
                (SELECT po_no,so_no,item,quality,color,purchase_order,size,COUNT(id) as total_manually_closed_qty FROM `tb_care_labels` 
                WHERE 1 $where and manually_closed=1 GROUP BY po_no,so_no,item,quality,color,purchase_order,size) as t8
                
                ON t1.so_no=t8.so_no AND t1.size=t8.size
                
                ORDER BY t7.serial ASC";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getPoShippingDateWiseReport($where, $where_1){
//        $sql = "SELECT F.*, A.total_carton_qty, B.total_cut_qty, D.total_end_pass_qty, E.total_packing_qty,
//                date_format(A.po_closing_date_time, '%Y-%m-%d') as po_closing_date,
//                G.count_wh_qty, H.count_other_qty, I.total_cut_pass_qty, J.total_wash_qty
//
//                FROM
//                (SELECT po_no, so_no, purchase_order, brand, item, style_no, style_name, quality,
//                color, SUM(quantity) as order_quantity, ex_factory_date
//                FROM `tb_po_detail` GROUP BY po_no, so_no, purchase_order, item, style_no, quality, color, ex_factory_date) as F
//
//                LEFT Join
//                (SELECT COUNT(pc_tracking_no) as total_carton_qty, po_no, so_no, purchase_order, item,
//                quality, style_no, style_name, brand, size, color, max(carton_date_time) as po_closing_date_time
//                FROM `tb_care_labels`
//                WHERE carton_status=1
//                GROUP BY po_no, so_no, purchase_order, item, style_no, quality, color) as A
//                ON A.po_no=F.po_no AND F.so_no=A.so_no and A.purchase_order=F.purchase_order and A.item=F.item
//                and A.style_no=F.style_no and A.quality=F.quality
//                and A.color=F.color
//
//                LEFT Join
//                (SELECT po_no, so_no, purchase_order, item, style_no, quality, color, MIN(bundle) as bundle_start, MAX(bundle) as bundle_end, SUM(cut_qty) as total_cut_qty
//                 FROM `tb_cut_summary`
//                GROUP BY po_no, so_no, purchase_order, item, style_no, quality, color) as B
//                ON F.po_no=B.po_no AND F.so_no=B.so_no and F.purchase_order=B.purchase_order and F.item=B.item
//                and F.style_no=B.style_no and F.quality=B.quality
//                and F.color=B.color
//
//                LEFT Join
//                (SELECT COUNT(pc_tracking_no) as total_end_pass_qty, po_no, so_no, purchase_order, item,
//                quality, style_no, style_name, brand, size, color FROM `tb_care_labels`
//                WHERE access_points=4 AND access_points_status=4
//                GROUP BY po_no, so_no, purchase_order, item, style_no, quality, color) as D
//                ON F.po_no=D.po_no AND F.so_no=D.so_no and F.purchase_order=D.purchase_order and F.item=D.item
//                and F.style_no=D.style_no and F.quality=D.quality
//                and F.color=D.color
//
//                LEFT Join
//                (SELECT COUNT(pc_tracking_no) as total_packing_qty, po_no, so_no, purchase_order, item,
//                quality, style_no, style_name, brand, size, color
//                FROM `tb_care_labels`
//                WHERE packing_status=1
//                GROUP BY po_no, so_no, purchase_order, item, style_no, quality, color) as E
//                ON F.po_no=E.po_no AND F.so_no=E.so_no and F.purchase_order=E.purchase_order and F.item=E.item
//                and F.style_no=E.style_no and F.quality=E.quality
//                and F.color=E.color
//
//                LEFT Join
//                (SELECT po_no, so_no, purchase_order, item, style_no, quality, color, COUNT(pc_tracking_no) as count_wh_qty
//                FROM `tb_care_labels` WHERE warehouse_qa_type in (1,2,3,4)
//                 GROUP BY po_no, so_no, purchase_order, item, style_no, quality, color) as G
//                ON F.po_no=G.po_no AND F.so_no=G.so_no and F.purchase_order=G.purchase_order and F.item=G.item
//                and F.style_no=G.style_no and F.quality=G.quality
//                and F.color=G.color
//
//                LEFT Join
//                (SELECT po_no, so_no, purchase_order, item, style_no, quality, color, COUNT(pc_tracking_no) as count_other_qty
//                FROM `tb_care_labels` WHERE warehouse_qa_type in (5, 6)
//                 GROUP BY po_no, so_no, purchase_order, item, style_no, quality, color) as H
//                ON F.po_no=H.po_no AND F.so_no=H.so_no and F.purchase_order=H.purchase_order and F.item=H.item
//                and F.style_no=H.style_no and F.quality=H.quality
//                and F.color=H.color
//
//                LEFT Join
//                (SELECT po_no, so_no, purchase_order, item, style_no, quality, color, COUNT(pc_tracking_no) as total_cut_pass_qty
//                FROM `tb_care_labels` WHERE sent_to_production=1
//                 GROUP BY po_no, so_no, purchase_order, item, style_no, quality, color) as I
//                ON F.po_no=I.po_no AND F.so_no=I.so_no and F.purchase_order=I.purchase_order and F.item=I.item
//                and F.style_no=I.style_no and F.quality=I.quality
//                and F.color=I.color
//
//                LEFT Join
//                (SELECT po_no, so_no, purchase_order, item, style_no, quality, color, COUNT(pc_tracking_no) as total_wash_qty
//                FROM `tb_care_labels` WHERE washing_status=1
//                 GROUP BY po_no, so_no, purchase_order, item, style_no, quality, color) as J
//                ON F.po_no=J.po_no AND F.so_no=J.so_no and F.purchase_order=J.purchase_order and F.item=J.item
//                and F.style_no=J.style_no and F.quality=J.quality
//                and F.color=J.color
//
//                WHERE 1 $where
//
//                ORDER BY DATE_FORMAT(F.ex_factory_date, '%Y-%m-%d') DESC";

        $sql="SELECT F.*, A.total_carton_qty, B.total_cut_qty, D.total_end_pass_qty, E.total_packing_qty, 
                date_format(A.po_closing_date_time, '%Y-%m-%d') as po_closing_date,
                G.count_wh_qty, H.count_other_qty, I.total_cut_pass_qty, J.total_wash_qty,K.responsible_line
                
                FROM
                (SELECT po_no, so_no, purchase_order, brand, item, style_no, style_name, quality, 
                color, SUM(quantity) as order_quantity, ex_factory_date 
                FROM `tb_po_detail` 
                WHERE 1 $where $where_1
                GROUP BY po_no, so_no, purchase_order, item, style_no, quality, color, ex_factory_date) as F
                
                LEFT Join
                (SELECT COUNT(pc_tracking_no) as total_carton_qty, po_no, so_no, purchase_order, item, 
                quality, style_no, style_name, brand, size, color, max(carton_date_time) as po_closing_date_time 
                FROM `tb_care_labels` 
                WHERE carton_status=1
                GROUP BY po_no, so_no, purchase_order, item, style_no, quality, color) as A
                ON A.po_no=F.po_no AND F.so_no=A.so_no and A.purchase_order=F.purchase_order and A.item=F.item
                and A.style_no=F.style_no and A.quality=F.quality
                and A.color=F.color
                
                LEFT Join
                (SELECT po_no, so_no, purchase_order, item, style_no, quality, color, MIN(bundle) as bundle_start, MAX(bundle) as bundle_end, SUM(cut_qty) as total_cut_qty 
                 FROM `tb_cut_summary`
                GROUP BY po_no, so_no, purchase_order, item, style_no, quality, color) as B
                ON F.po_no=B.po_no AND F.so_no=B.so_no and F.purchase_order=B.purchase_order and F.item=B.item
                and F.style_no=B.style_no and F.quality=B.quality
                and F.color=B.color
                
                LEFT Join
                (SELECT COUNT(pc_tracking_no) as total_end_pass_qty, po_no, so_no, purchase_order, item, 
                quality, style_no, style_name, brand, size, color FROM `tb_care_labels` 
                WHERE access_points=4 AND access_points_status=4 
                GROUP BY po_no, so_no, purchase_order, item, style_no, quality, color) as D
                ON F.po_no=D.po_no AND F.so_no=D.so_no and F.purchase_order=D.purchase_order and F.item=D.item
                and F.style_no=D.style_no and F.quality=D.quality
                and F.color=D.color
                
                LEFT Join
                (SELECT COUNT(pc_tracking_no) as total_packing_qty, po_no, so_no, purchase_order, item, 
                quality, style_no, style_name, brand, size, color
                FROM `tb_care_labels` 
                WHERE packing_status=1
                GROUP BY po_no, so_no, purchase_order, item, style_no, quality, color) as E
                ON F.po_no=E.po_no AND F.so_no=E.so_no and F.purchase_order=E.purchase_order and F.item=E.item
                and F.style_no=E.style_no and F.quality=E.quality
                and F.color=E.color
                                
                LEFT Join
                (SELECT po_no, so_no, purchase_order, item, style_no, quality, color, COUNT(pc_tracking_no) as count_wh_qty
                FROM `tb_care_labels` WHERE warehouse_qa_type in (1,2,3,4)
                 GROUP BY po_no, so_no, purchase_order, item, style_no, quality, color) as G
                ON F.po_no=G.po_no AND F.so_no=G.so_no and F.purchase_order=G.purchase_order and F.item=G.item
                and F.style_no=G.style_no and F.quality=G.quality
                and F.color=G.color
                                       
                LEFT Join
                (SELECT po_no, so_no, purchase_order, item, style_no, quality, color, COUNT(pc_tracking_no) as count_other_qty
                FROM `tb_care_labels` WHERE warehouse_qa_type in (5, 6)
                 GROUP BY po_no, so_no, purchase_order, item, style_no, quality, color) as H
                ON F.po_no=H.po_no AND F.so_no=H.so_no and F.purchase_order=H.purchase_order and F.item=H.item
                and F.style_no=H.style_no and F.quality=H.quality
                and F.color=H.color
                                                             
                LEFT Join
                (SELECT po_no, so_no, purchase_order, item, style_no, quality, color, COUNT(pc_tracking_no) as total_cut_pass_qty,line_id
                FROM `tb_care_labels` WHERE sent_to_production=1 
                 GROUP BY po_no, so_no, purchase_order, item, style_no, quality, color) as I
                ON F.po_no=I.po_no AND F.so_no=I.so_no and F.purchase_order=I.purchase_order and F.item=I.item
                and F.style_no=I.style_no and F.quality=I.quality
                and F.color=I.color
                                                             
                LEFT Join
                (SELECT po_no, so_no, purchase_order, item, style_no, quality, color, COUNT(pc_tracking_no) as total_wash_qty
                FROM `tb_care_labels` WHERE washing_status=1 
                 GROUP BY po_no, so_no, purchase_order, item, style_no, quality, color) as J
                ON F.po_no=J.po_no AND F.so_no=J.so_no and F.purchase_order=J.purchase_order and F.item=J.item
                and F.style_no=J.style_no and F.quality=J.quality
                and F.color=J.color
                
                LEFT JOIN
                (SELECT t1.po_no, t1.so_no, t1.purchase_order, t1.style_no, t1.item, t1.quality, t1.color, 
                GROUP_CONCAT(t2.line_code SEPARATOR '; ') as responsible_line
                From (SELECT po_no, so_no, purchase_order, item, style_no, quality, color, line_id 
                FROM `tb_care_labels` WHERE line_id !=0 
                GROUP BY po_no, so_no, purchase_order, item, style_no, quality, color, line_id) as t1
                LEFT JOIN
                (SELECT id, line_name, line_code FROM `tb_line`) as t2 On t1.line_id=t2.id
                GROUP BY t1.po_no, t1.so_no, t1.purchase_order, t1.item, t1.quality, t1.color) as K
                ON F.po_no=K.po_no AND F.so_no=K.so_no and F.purchase_order=K.purchase_order and F.item=K.item
                and F.style_no=K.style_no and F.quality=K.quality
                and F.color=K.color
                                
                ORDER BY DATE_FORMAT(F.ex_factory_date, '%Y-%m-%d') DESC";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getSearchedDates($where){
        $sql = "SELECT ex_factory_date 
                FROM `tb_po_detail` 
                WHERE 1
                $where
                GROUP BY ex_factory_date";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getAllLines(){
        $sql = "SELECT * FROM `tb_line` ORDER BY (line_code * 1)";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getAllLinesByCondition($condition){
        $sql = "SELECT * FROM `tb_line` WHERE 1 $condition";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getSegments($where_seg){
        $sql = "SELECT * FROM `tb_segment` WHERE 1 $where_seg";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getPoClosingReport($where){
        $sql = "SELECT A.*, B.total_cut_qty, D.total_end_pass_qty, E.total_packing_qty, 
                F.*, date_format(A.po_closing_date_time, '%Y-%m-%d') as po_closing_date,
                G.count_wh_qty
                
                FROM 
                (SELECT COUNT(pc_tracking_no) as total_carton_qty, po_no, purchase_order, item, 
                quality, style_no, style_name, brand, size, color, max(carton_date_time) as po_closing_date_time 
                FROM `tb_care_labels` 
                WHERE carton_status=1
                GROUP BY po_no, purchase_order, item, style_no, quality, color) as A
                
                LEFT Join
                (SELECT *, MIN(bundle) as bundle_start, MAX(bundle) as bundle_end, SUM(cut_qty) as total_cut_qty 
                 FROM `tb_cut_summary`
                GROUP BY po_no, purchase_order, item, style_no, quality, color) as B
                ON A.po_no=B.po_no and A.purchase_order=B.purchase_order and A.item=B.item
                and A.style_no=B.style_no and A.quality=B.quality
                and A.color=B.color
                
                LEFT Join
                (SELECT COUNT(pc_tracking_no) as total_end_pass_qty, po_no, purchase_order, item, 
                quality, style_no, style_name, brand, size, color FROM `tb_care_labels` 
                WHERE access_points=4 AND access_points_status=4 
                GROUP BY po_no, purchase_order, item, style_no, quality, color) as D
                ON A.po_no=D.po_no and A.purchase_order=D.purchase_order and A.item=D.item
                and A.style_no=D.style_no and A.quality=D.quality
                and A.color=D.color
                
                LEFT Join
                (SELECT COUNT(pc_tracking_no) as total_packing_qty, po_no, purchase_order, item, 
                quality, style_no, style_name, brand, size, color
                FROM `tb_care_labels` 
                WHERE packing_status=1
                GROUP BY po_no, purchase_order, item, style_no, quality, color) as E
                ON A.po_no=E.po_no and A.purchase_order=E.purchase_order and A.item=E.item
                and A.style_no=E.style_no and A.quality=E.quality
                and A.color=E.color
                
                
                LEFT Join
                (SELECT po_no, so_no, purchase_order, brand, item, style_no, style_name, quality, 
                color, SUM(quantity) as order_quantity, ex_factory_date 
                FROM `tb_po_detail` GROUP BY po_no, purchase_order, item, style_no, quality, color) as F
                ON A.po_no=F.po_no and A.purchase_order=F.purchase_order and A.item=F.item
                and A.style_no=F.style_no and A.quality=F.quality
                and A.color=F.color

                
                LEFT Join
                (SELECT po_no, purchase_order, item, style_no, quality, color, COUNT(pc_tracking_no) as count_wh_qty
                FROM `tb_care_labels` WHERE warehouse_qa_type != 0
                 GROUP BY po_no, purchase_order, item, style_no, quality, color) as G
                ON A.po_no=G.po_no and A.purchase_order=G.purchase_order and A.item=G.item
                and A.style_no=G.style_no and A.quality=G.quality
                and A.color=G.color
                                
                WHERE 1 $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getPoItemWiseSizeReport($where){
        $sql = "Select t1.*, t2.po_item_size_wise_endline_qty, t4.po_item_size_wise_packing_qty, 
                t5.total_cut_input_qty, t6.count_input_qty_line,
                (IFNULL(t7.count_mid_line_qc_pass, 0)+IFNULL(t8.count_mid_line_qc_pass_in_end, 0)) as count_mid_line_qc_pass,
                t9.count_end_line_qc_pass, t10.count_washing_pass, t11.count_carton_pass, t12.total_cut_qty, t13.count_wash_going
                From 
                (SELECT po_no, so_no, purchase_order, style_no, style_name, ex_factory_date, item, 
                quality, color, size, SUM(quantity) as po_item_size_wise_order_qty
                FROM `tb_po_detail` GROUP BY po_no, so_no, purchase_order, item, quality, color, size) as t1
                
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color, size, COUNT(id) as po_item_size_wise_endline_qty
                FROM `tb_care_labels` 
                WHERE line_id != 0 AND access_points=4 AND access_points_status=4
                GROUP BY po_no, so_no, purchase_order, item, quality, color, size) as t2
                ON t1.po_no=t2.po_no AND t1.so_no=t2.so_no AND t1.purchase_order=t2.purchase_order AND t1.item=t2.item 
                AND t1.quality=t2.quality AND t1.color=t2.color AND t1.size=t2.size
                
                LEFT JOIN
                (SELECT *, COUNT(id) as total_cut_input_qty
                FROM `tb_care_labels` 
                WHERE sent_to_production=1 
                GROUP BY po_no, so_no, purchase_order, item, quality, color, size) as t5
                ON t1.po_no=t5.po_no AND t1.so_no=t5.so_no AND t1.purchase_order=t5.purchase_order AND t1.item=t5.item
                AND t1.quality=t5.quality AND t1.color=t5.color AND t1.size=t5.size
                
                LEFT JOIN
                 (SELECT po_no, so_no, purchase_order, item, quality, color, style_no, style_name, COUNT(id) as count_input_qty_line, size, line_id
                FROM `tb_care_labels` WHERE line_id !=0 GROUP BY po_no, so_no, purchase_order, item, quality, color, size) as t6
                ON t1.po_no=t6.po_no AND t1.so_no=t6.so_no AND t1.purchase_order=t6.purchase_order AND t1.item=t6.item
                AND t1.quality=t6.quality AND t1.color=t6.color AND t1.size=t6.size
                
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color, size, COUNT(id) as count_mid_line_qc_pass
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 3 
                AND access_points_status in (1)
                GROUP BY po_no, so_no, purchase_order, item, quality, color, size) as t7
                ON t1.po_no=t7.po_no AND t1.so_no=t7.so_no AND t1.purchase_order=t7.purchase_order AND t1.item=t7.item
                AND t1.quality=t7.quality AND t1.color=t7.color AND t1.size=t7.size
                
                LEFT JOIN 
                (SELECT po_no, so_no, purchase_order, item, quality, color, size, COUNT(id) as count_mid_line_qc_pass_in_end
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 4 
                AND access_points_status in (1, 2, 3, 4)
                GROUP BY po_no, so_no, purchase_order, item, quality, color, size) as t8
                ON t1.po_no=t8.po_no AND t1.so_no=t8.so_no AND t1.purchase_order=t8.purchase_order AND t1.item=t8.item
                AND t1.quality=t8.quality AND t1.color=t8.color AND t1.size=t8.size
                
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color, size, COUNT(id) as count_end_line_qc_pass
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 4 
                AND access_points_status=4 
                GROUP BY po_no, so_no, purchase_order, item, quality, color, size) as t9
                ON t1.po_no=t9.po_no AND t1.so_no=t9.so_no AND t1.purchase_order=t9.purchase_order AND t1.item=t9.item
                AND t1.quality=t9.quality AND t1.color=t9.color AND t1.size=t9.size
                
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color, size, COUNT(id) as count_washing_pass
                FROM `tb_care_labels` WHERE washing_status = 1
                GROUP BY po_no, so_no, purchase_order, item, quality, color, size) as t10
                ON t1.po_no=t10.po_no AND t1.so_no=t10.so_no AND t1.purchase_order=t10.purchase_order AND t1.item=t10.item
                AND t1.quality=t10.quality AND t1.color=t10.color AND t1.size=t10.size
                
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color, size, COUNT(id) as po_item_size_wise_packing_qty
                FROM `tb_care_labels` 
                WHERE packing_status=1
                GROUP BY po_no, so_no, purchase_order, item, quality, color, size) as t4
                ON t1.po_no=t4.po_no AND t1.so_no=t4.so_no AND t1.purchase_order=t4.purchase_order AND t1.item=t4.item 
                AND t1.quality=t4.quality AND t1.color=t4.color AND t1.size=t4.size
                
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color, size, COUNT(id) as count_carton_pass
                FROM `tb_care_labels` 
                WHERE carton_status=1
                GROUP BY po_no, so_no, purchase_order, item, quality, color, size) as t11
                ON t1.po_no=t11.po_no AND t11.so_no=t2.so_no AND t1.purchase_order=t11.purchase_order AND t1.item=t11.item 
                AND t1.quality=t11.quality AND t1.color=t11.color AND t1.size=t11.size
                
                LEFT Join
                (SELECT *, SUM(cut_qty) as total_cut_qty 
                 FROM `tb_cut_summary`
                GROUP BY po_no, so_no, purchase_order, item, style_no, quality, color, size) as t12
                ON t1.po_no=t12.po_no AND t1.so_no=t12.so_no AND t1.purchase_order=t12.purchase_order AND t1.item=t12.item 
                AND t1.quality=t12.quality AND t1.color=t12.color AND t1.size=t12.size
                
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color, size, COUNT(id) as count_wash_going
                FROM `tb_care_labels` WHERE is_going_wash = 1
                GROUP BY po_no, so_no, purchase_order, item, quality, color, size) as t13
                ON t1.po_no=t13.po_no AND t1.so_no=t13.so_no AND t1.purchase_order=t13.purchase_order AND t1.item=t13.item
                AND t1.quality=t13.quality AND t1.color=t13.color AND t1.size=t13.size
                
                LEFT JOIN
                `tb_size_serial` as t3
                ON t1.size=t3.size
                
                WHERE 1 $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getPoItemWiseWarehouseSizeReport($where){
        $sql = "Select t1.*

                From 
                
                (SELECT po_no, so_no, purchase_order, item, style_no, style_name, quality, 
                color, `size`, pc_tracking_no, warehouse_qa_type, other_purpose_remarks
                FROM `tb_care_labels` 
                WHERE line_id != 0 AND warehouse_qa_type != 0) as t1
                
                LEFT JOIN
                `tb_size_serial` as t3
                ON t1.size=t3.size
                
                WHERE 1 $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getRemainingCLBySize($where){
        $sql = "SELECT t1.*, t2.line_name 
                FROM `tb_care_labels` as t1
                LEFT JOIN 
                `tb_line` as t2
                ON t1.line_id=t2.id
                WHERE 1 $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getCutVsOutputReport($year_month){
        $sql = "SELECT A.*, B.* FROM
                (SELECT SUM(t1.cut_qty) as total_cut_qty, DATE_FORMAT(t1.date_time, '%Y-%m') as cut_date 
                FROM `tb_cut_summary` as t1  
                WHERE DATE_FORMAT(t1.date_time, '%Y-%m') = '$year_month') as A
                LEFT JOIN
                (SELECT COUNT(t2.id) as total_pack_qty, DATE_FORMAT(t2.packing_date_time, '%Y-%m') as pack_date 
                FROM `tb_care_labels` as t2  
                WHERE DATE_FORMAT(t2.packing_date_time, '%Y-%m') = '$year_month') as B
                ON A.cut_date=B.pack_date";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getRemainingMidEndCLBySize($where, $where1, $where2){
//        $sql = "SELECT A.* From (SELECT t1.* FROM
//                (SELECT * FROM `tb_care_labels` WHERE 1 $where $where1) as t1) as A
//
//                UNION
//
//                SELECT B.* From(SELECT t2.* FROM
//                (SELECT * FROM `tb_care_labels` WHERE 1 $where $where2) as t2) as B";

        $sql = "SELECT A.* From (SELECT t1.*, t3.line_name FROM
                (SELECT * FROM `tb_care_labels` WHERE 1 $where $where1) as t1
                LEFT JOIN 
                `tb_line` as t3 
                ON t1.line_id=t3.id) as A

                UNION
                
                SELECT B.* From(SELECT t2.*, t4.line_name FROM
                (SELECT * FROM `tb_care_labels` WHERE 1 $where $where2) as t2
                LEFT JOIN 
                `tb_line` as t4 
                ON t2.line_id=t4.id) as B";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getLinePoItemWiseSizeReport($where){
        $sql = "Select t1.*, t2.*, t4.po_item_size_wise_endline_qty From 
                (SELECT po_no, purchase_order, item, quality, color, size, line_id, COUNT(id) as po_item_size_wise_inline_qty
                FROM `tb_care_labels` 
                WHERE line_id != 0
                GROUP BY po_no, purchase_order, item, quality, color, size, line_id) as t1
                
                LEFT JOIN 
                (SELECT po_no, purchase_order, style_no, style_name, 
                ex_factory_date, item, quality, color, size, SUM(quantity) as po_item_size_wise_order_qty
                FROM `tb_po_detail` GROUP BY po_no, purchase_order, item, color, size) as t2
                ON t1.po_no=t2.po_no AND t1.purchase_order=t2.purchase_order 
                AND t1.item=t2.item AND t1.quality=t2.quality AND t1.color=t2.color AND t1.size=t2.size
                
                LEFT JOIN
                (SELECT po_no, purchase_order, item, quality, color, size, COUNT(id) as po_item_size_wise_endline_qty
                FROM `tb_care_labels` 
                WHERE line_id != 0 AND access_points=4 AND access_points_status=4
                GROUP BY po_no, purchase_order, item, quality, color, size, line_id) as t4
                ON t1.po_no=t4.po_no AND t1.purchase_order=t4.purchase_order AND t1.item=t4.item 
                AND t1.quality=t4.quality AND t1.color=t4.color AND t1.size=t4.size
                
                LEFT JOIN
                `tb_size_serial` as t3
                ON t1.size=t3.size
                
                WHERE 1 $where";

//        $sql = "SELECT po_no, purchase_order, item, line_id, size, COUNT(id) AS total_size_qty
//                FROM `tb_care_labels`
//                WHERE 1 $where
//                GROUP BY line_id, po_no, purchase_order, item, `size`";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getPoWiseCuttingInfo($where){
        $sql = "SELECT A.*, B.count_scanned_pc, C.count_unscanned_pc, D.total_cut_qty FROM
                
                (SELECT po_no, purchase_order, brand, item, style_no, style_name, quality, 
                color, size, quantity, ex_factory_date
                FROM `tb_po_detail`
                GROUP BY purchase_order, item, style_no, quality, color, size) as A
                
                LEFT Join
                
                (SELECT COUNT(pc_tracking_no) as count_scanned_pc, purchase_order, item, 
                quality, style_no, style_name, brand, size, color FROM `tb_care_labels` 
                WHERE sent_to_production=1 GROUP BY purchase_order, item, style_no, quality, color, size) as B
                ON A.purchase_order=B.purchase_order and A.item=B.item
                and A.style_no=B.style_no and A.quality=B.quality
                and A.color=B.color AND A.size=B.size
                
                LEFT Join
                
                (SELECT COUNT(sent_to_production) as count_unscanned_pc, purchase_order, item, 
                quality, style_no, style_name, brand, color, size FROM `tb_care_labels` 
                WHERE sent_to_production=0
                GROUP BY purchase_order, item, color, style_no, quality, size) as C
                ON A.purchase_order=C.purchase_order and A.item=C.item
                and A.style_no=C.style_no and A.quality=C.quality
                and A.color=C.color AND A.size=C.size
                
                LEFT Join
                (SELECT *, MIN(bundle) as bundle_start, MAX(bundle) as bundle_end, SUM(cut_qty) as total_cut_qty 
                 FROM `tb_cut_summary`
                GROUP BY po_no, purchase_order, item, style_no, quality, color, size) as D
                ON A.purchase_order=D.purchase_order and A.item=D.item
                and A.style_no=D.style_no and A.quality=D.quality
                and A.color=D.color AND A.size=D.size
                
                WHERE 1 $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getPoSizeWisePackingInfo($where){
        $sql = "SELECT A.*, B.total_cut_qty, D.total_end_pass_qty, E.total_packing_qty, G.total_carton_qty, H.total_wh_qty
                FROM 
                (SELECT po_no, purchase_order, brand, item, style_no, style_name, quality, 
                color, SUM(quantity) as order_quantity, ex_factory_date, size 
                FROM `tb_po_detail` GROUP BY po_no, purchase_order, item, style_no, quality, color, size) as A
                
                LEFT Join
                (SELECT *, MIN(bundle) as bundle_start, MAX(bundle) as bundle_end, SUM(cut_qty) as total_cut_qty 
                 FROM `tb_cut_summary`
                GROUP BY po_no, purchase_order, item, style_no, quality, color, size) as B
                ON A.po_no=B.po_no AND A.purchase_order=B.purchase_order and A.item=B.item
                and A.style_no=B.style_no and A.quality=B.quality
                and A.color=B.color AND A.size=B.size
                
                LEFT Join
                (SELECT COUNT(pc_tracking_no) as total_end_pass_qty, po_no, purchase_order, item, size, 
                quality, style_no, style_name, brand, color FROM `tb_care_labels` 
                WHERE access_points=4 AND access_points_status=4 
                GROUP BY po_no, purchase_order, item, style_no, quality, color, size) as D
                ON A.po_no=D.po_no AND A.purchase_order=D.purchase_order and A.item=D.item
                and A.style_no=D.style_no and A.quality=D.quality
                and A.color=D.color AND A.size=D.size
                
                LEFT Join
                (SELECT COUNT(pc_tracking_no) as total_packing_qty, po_no, purchase_order, item, size, 
                quality, style_no, style_name, brand, color FROM `tb_care_labels` 
                WHERE packing_status=1
                GROUP BY po_no, purchase_order, item, style_no, quality, color, size) as E
                ON A.po_no=E.po_no AND A.purchase_order=E.purchase_order and A.item=E.item
                and A.style_no=E.style_no and A.quality=E.quality
                and A.color=E.color AND A.size=E.size
                
                LEFT Join
                (SELECT COUNT(pc_tracking_no) as total_carton_qty, po_no, purchase_order, item, size, 
                quality, style_no, style_name, brand, color FROM `tb_care_labels` 
                WHERE carton_status=1
                GROUP BY po_no, purchase_order, item, style_no, quality, color, size) as G
                ON A.po_no=G.po_no AND A.purchase_order=G.purchase_order and A.item=G.item
                and A.style_no=G.style_no and A.quality=G.quality
                and A.color=G.color AND A.size=G.size
                
                LEFT Join
                (SELECT COUNT(pc_tracking_no) as total_wh_qty, po_no, purchase_order, item, size, 
                quality, style_no, style_name, brand, color FROM `tb_care_labels` 
                WHERE warehouse_qa_type != 0
                GROUP BY po_no, purchase_order, item, style_no, quality, color, size) as H
                ON A.po_no=H.po_no AND A.purchase_order=H.purchase_order and A.item=H.item
                and A.style_no=H.style_no and A.quality=H.quality
                and A.color=H.color AND A.size=H.size
                
                LEFT JOIN
                `tb_size_serial` as F
                ON A.size=F.size
                
                WHERE 1 $where
                
                Order By F.serial";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getLineInputReport($date){
        $sql = "SELECT A.line_id, B.count_qty_line, C.count_mid_line_qc_pass, D.count_mid_line_qc_defect, 
                E.count_mid_line_qc_reject, F.count_wip_qty, G.count_end_line_qc_pass, 
                H.count_end_line_qc_defect, I.count_end_line_qc_reject, J.line_name, K.floor_name 
                FROM 
                (SELECT line_id, COUNT(pc_tracking_no) as count_input_qty_line
                FROM `tb_care_labels` WHERE line_id !=0 GROUP BY line_id) as A
                LEFT JOIN 
                (SELECT line_id, COUNT(pc_tracking_no) as count_qty_line, 
                DATE_FORMAT(line_input_date_time, '%Y-%m-%d') as line_input_date 
                FROM `tb_care_labels` WHERE line_id !=0 AND DATE_FORMAT(line_input_date_time, '%Y-%m-%d') LIKE '%$date%' 
                GROUP BY DATE_FORMAT(line_input_date_time, '%Y-%m-%d'), line_id) as B
                ON A.line_id=B.line_id
                LEFT JOIN 
                (SELECT line_id, COUNT(pc_tracking_no) as count_mid_line_qc_pass, 
                DATE_FORMAT(mid_line_qc_date_time, '%Y-%m-%d') as line_input_date 
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points >= 3 
                AND access_points_status in (1, 4)
                AND DATE_FORMAT(mid_line_qc_date_time, '%Y-%m-%d') LIKE '%$date%' 
                GROUP BY DATE_FORMAT(mid_line_qc_date_time, '%Y-%m-%d'), line_id) as C
                ON A.line_id=C.line_id
                LEFT JOIN 
                (SELECT line_id, COUNT(pc_tracking_no) as count_mid_line_qc_defect, 
                DATE_FORMAT(mid_line_qc_date_time, '%Y-%m-%d') as line_input_date 
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 3 
                AND access_points_status=2
                AND DATE_FORMAT(mid_line_qc_date_time, '%Y-%m-%d') LIKE '%$date%' 
                GROUP BY DATE_FORMAT(mid_line_qc_date_time, '%Y-%m-%d'), line_id) as D
                ON A.line_id=D.line_id
                LEFT JOIN 
                (SELECT line_id, COUNT(pc_tracking_no) as count_mid_line_qc_reject, 
                DATE_FORMAT(mid_line_qc_date_time, '%Y-%m-%d') as line_input_date 
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 3 
                AND access_points_status=3
                AND DATE_FORMAT(mid_line_qc_date_time, '%Y-%m-%d') LIKE '%$date%' 
                GROUP BY DATE_FORMAT(mid_line_qc_date_time, '%Y-%m-%d'), line_id) as E
                ON A.line_id=E.line_id
                LEFT JOIN 
                (SELECT line_id, COUNT(pc_tracking_no) as count_wip_qty 
                FROM `tb_care_labels` WHERE line_id !=0  AND access_points_status < 4 
                GROUP BY line_id) as F
                ON A.line_id=F.line_id
                LEFT JOIN 
                (SELECT line_id, COUNT(pc_tracking_no) as count_end_line_qc_pass, 
                DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') as line_input_date 
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 4 
                AND access_points_status=4
                AND DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') LIKE '%$date%' 
                GROUP BY DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d'), line_id) as G
                ON A.line_id=G.line_id
                LEFT JOIN 
                (SELECT line_id, COUNT(pc_tracking_no) as count_end_line_qc_defect, 
                DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') as line_input_date 
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 4 
                AND access_points_status=2
                AND DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') LIKE '%$date%' 
                GROUP BY DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d'), line_id) as H
                ON A.line_id=H.line_id
                LEFT JOIN 
                (SELECT line_id, COUNT(pc_tracking_no) as count_end_line_qc_reject, 
                DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') as line_input_date 
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 4 
                AND access_points_status=3
                AND DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') LIKE '%$date%' 
                GROUP BY DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d'), line_id) as I
                ON A.line_id=I.line_id
                Inner Join
                tb_line as J ON A.line_id=J.id
                INNER JOIN
                tb_floor as K ON J.floor=K.id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getOtherLineInputQty(){

    }

    public function getProductionReport($where){
        $sql = "SELECT * FROM `tb_production_summary` WHERE 1 $where ORDER BY ex_factory_date ASC";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getLineWiseRunningPOs(){
        $sql = "SELECT t1.*, 
                (IFNULL(t1.count_input_qty_line, 0)-(IFNULL(t1.count_end_line_qc_pass, 0)+IFNULL(t1.count_manual_close, 0))) AS line_po_balance, 
                t2.min_line_input_date_time 

                FROM 
                (SELECT po_no,so_no,item,quality,color,purchase_order,line_id,brand,ex_factory_date,style_no,style_name,
 	            COUNT(id) as count_input_qty_line,
                COUNT(end_line_qc_date_time) as count_end_line_qc_pass,
                COUNT(manually_closed) as count_manual_close
                
                FROM (
                  SELECT
                    so_no,po_no,item,quality,color,purchase_order,line_id,brand,ex_factory_date,style_no,style_name,
                    
                    CASE WHEN line_id != 0 THEN id END id,
                    CASE WHEN access_points=4 AND access_points_status=4 THEN end_line_qc_date_time END end_line_qc_date_time,
                    CASE WHEN manually_closed=1 THEN manually_closed END manually_closed
                   
                  FROM vt_few_days_po_pcs 
                    
                ) vt_few_days_po_pcs WHERE line_id != 0 GROUP BY so_no,po_no,item,quality,color,purchase_order, line_id) as t1
                
                LEFT JOIN
                (SELECT so_no,po_no,item,quality,color,purchase_order, line_id, MIN(line_input_date_time) AS min_line_input_date_time
                FROM vt_few_days_po_pcs WHERE line_id != 0 GROUP BY so_no,po_no,item,quality,color,purchase_order, line_id) AS t2
                ON t1.so_no=t2.so_no AND t1.po_no=t2.po_no AND t1.item=t2.item AND t1.quality=t2.quality 
                AND t1.color=t2.color AND t1.purchase_order=t2.purchase_order AND t1.line_id=t2.line_id
                
                WHERE (IFNULL(t1.count_input_qty_line, 0) - IFNULL(t1.count_end_line_qc_pass, 0)) > 0";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getProductionReportLive($where)
    {
        $sql="SELECT t1.line_id,t1.packing_date_time,  t1.total_cut_input_qty, 
              t1.count_input_line_qc_pass, t1.count_mid_line_qc_pass, t1.count_end_line_qc_pass, t1.count_wash_send, 
              t1.count_washing_pass, t1.count_finishing_alter_qty, t1.count_packing_pass, t1.count_carton_pass, t1.total_wh_qa, 
              t2.*, t3.responsible_line, t4.so_fail_count
              FROM
              (Select * FROM vt_po_summary WHERE 1 $where) as t2
              
              LEFT JOIN
              (SELECT po_no,so_no,item,quality,color,style_name,style_no,
              purchase_order,brand,ex_factory_date,packing_date_time,line_id,
              COUNT(sent_to_production_date_time) as total_cut_input_qty,
              COUNT(line_input_date_time) as count_input_line_qc_pass,
              COUNT(mid_line_qc_date_time) as count_mid_line_qc_pass,
              COUNT(end_line_qc_date_time) as count_end_line_qc_pass,
              COUNT(is_going_wash) as count_wash_send, 
              COUNT(washing_status) as count_washing_pass, 
              COUNT(packing_status) as count_packing_pass,  
              COUNT(finishing_qc_status) as count_finishing_alter_qty,  
          	  COUNT(carton_status) as count_carton_pass,
              COUNT(warehouse_qa_type) as total_wh_qa
           FROM (
              SELECT
                so_no,po_no,item,quality,color,purchase_order,brand,ex_factory_date,packing_date_time,style_name,style_no,line_id,
                CASE WHEN  access_points=4 AND access_points_status=4 THEN end_line_qc_date_time END end_line_qc_date_time,    
                CASE WHEN sent_to_production=1 THEN sent_to_production_date_time END sent_to_production_date_time,
                CASE WHEN access_points>=3 AND access_points_status in (1, 4) THEN mid_line_qc_date_time END mid_line_qc_date_time,
                CASE WHEN access_points>=2 AND access_points_status in (1, 4) THEN line_input_date_time END line_input_date_time,
                CASE WHEN packing_status = 1 THEN packing_status END packing_status,
                CASE WHEN carton_status = 1 THEN carton_status END carton_status,
                CASE WHEN is_going_wash = 1 THEN is_going_wash END is_going_wash,
                CASE WHEN washing_status = 1 THEN washing_status END washing_status,
                CASE WHEN finishing_qc_status = 2 THEN finishing_qc_status END finishing_qc_status,
                CASE WHEN warehouse_qa_type != 0 THEN warehouse_qa_type END warehouse_qa_type 
              FROM vt_few_days_po_pcs    
            ) vt_few_days_po_pcs GROUP BY so_no,po_no,item,quality,color,purchase_order) as t1
            
            ON t1.so_no=t2.so_no AND t1.po_no=t2.po_no AND t1.purchase_order=t2.purchase_order 
            AND t1.quality=t2.quality AND t1.color=t2.color
            
            LEFT JOIN
            tb_production_summary as t3
            ON t1.so_no=t3.so_no
            
            LEFT JOIN
            (Select so_no, COUNT(so_no) AS so_fail_count FROM tb_aql_status_log WHERE aql_status=2 GROUP BY so_no) as t4
            ON t1.so_no=t4.so_no
            
            ORDER by t1.packing_date_time DESC";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getHourlyReportByLineCode($line_code, $date){
        $sql="SELECT t1.*, t2.date, t2.start_time, t2.end_time, t2.qty, t2.efficiency, t2.wip, t2.dhu, 
             t2.produce_minute_1, t2.work_minute_1, t2.work_hour_1, 
             t2.produce_minute_2, t2.work_minute_2, t2.work_hour_2, 
             t2.produce_minute_3, t2.work_minute_3, t2.work_hour_3, 
             t2.produce_minute_4, t2.work_minute_4, t2.work_hour_4, 
             t3.target, t3.target_hour, t3.man_power_1, t3.man_power_2, 
             t3.man_power_3, t3.man_power_4, t3.remarks,
             round(t3.target/t3.target_hour) AS per_hour_target
                 
            FROM 
            (SELECT * FROM `tb_line` WHERE line_code='$line_code') AS t1
            LEFT JOIN
            `tb_today_line_output_qty` AS t2
            ON t1.id=t2.line_id
            LEFT JOIN
            (SELECT * FROM line_daily_target WHERE date='$date') AS t3
            ON t1.id=t3.line_id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getAqlSummaryReport($date)
    {
        $sql="SELECT t0.brand, t1.today_plan_aql_count, t2.today_plan_aql_pass_count, t3.today_plan_aql_fail_count,
              t4.previous_due_aql_count, t5.previous_due_aql_pass_count
              
            FROM 
            (SELECT brand FROM `tb_po_detail` GROUP BY brand) AS t0

            LEFT JOIN
            (SELECT A.brand, COUNT(A.so_no) AS today_plan_aql_count 
            FROM (SELECT brand, so_no FROM `tb_po_detail` 
            WHERE aql_plan_date!='0000-00-00'
            AND aql_plan_date='$date'
            GROUP BY brand, so_no) AS A 
            GROUP BY A.brand) AS t1
            ON t0.brand=t1.brand
            
            LEFT JOIN
            (SELECT B.brand, COUNT(B.so_no) AS today_plan_aql_pass_count
            FROM (SELECT brand, so_no FROM `tb_po_detail` 
            WHERE aql_plan_date!='0000-00-00'
            AND aql_plan_date='$date'
            AND aql_status IN (1)
            GROUP BY brand, so_no) AS B 
            GROUP BY B.brand) AS t2
            ON t0.brand=t2.brand
            
            LEFT JOIN
            (SELECT C.brand, COUNT(C.so_no) AS today_plan_aql_fail_count
            FROM (SELECT brand, so_no FROM `tb_po_detail` 
            WHERE aql_plan_date!='0000-00-00'
            AND aql_plan_date='$date'
            AND aql_status IN (2)
            GROUP BY brand, so_no) AS C
            GROUP BY C.brand) AS t3
            ON t0.brand=t3.brand
            
            LEFT JOIN
            (SELECT D.brand, COUNT(D.so_no) AS previous_due_aql_count 
            FROM (SELECT brand, so_no FROM `tb_po_detail` 
            WHERE aql_plan_date!='0000-00-00'
            AND aql_plan_date<'$date'
            AND aql_status IN (0, 2)
            GROUP BY brand, so_no) AS D 
            GROUP BY D.brand) AS t4
            ON t0.brand=t4.brand
            
            LEFT JOIN
            (SELECT E.brand, COUNT(E.so_no) AS previous_due_aql_pass_count 
            FROM (SELECT brand, so_no FROM `tb_po_detail` 
            WHERE aql_plan_date!='0000-00-00'
            AND aql_plan_date<'$date'
            AND aql_status IN (1)
            AND aql_action_date='$date'
            GROUP BY brand, so_no) AS E 
            GROUP BY E.brand) AS t5
            ON t0.brand=t5.brand
            
            LEFT JOIN
            (SELECT F.brand, COUNT(F.so_no) AS previous_due_aql_fail_count 
            FROM (SELECT brand, so_no FROM `tb_po_detail` 
            WHERE aql_plan_date!='0000-00-00'
            AND aql_plan_date<'$date'
            AND aql_status IN (2)
            AND aql_action_date='$date'
            GROUP BY brand, so_no) AS F 
            GROUP BY F.brand) AS t6
            ON t0.brand=t6.brand";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getFloorWiseTargets($floor_id, $date)
    {
        $sql="SELECT t1.*, t2.*
              FROM (SELECT * FROM `tb_line` WHERE floor=$floor_id) AS t1
              LEFT JOIN
              (SELECT * FROM `line_daily_target` WHERE `date`='$date') AS t2
              ON t1.id=t2.line_id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getReadyPackageByPo($where)
    {
        $sql="SELECT t1.*, t2.total_order_qty ,t3.total_cut_qty,t3.bundle_start,t3.bundle_end,t3.cutting_collar_bundle_ready_date_time,
              t4.count_cut_package_ready_qty
              
                FROM (
                SELECT po_no,so_no,item,quality,color,purchase_order,ex_factory_date,brand,style_no,style_name, planned_line_id,
                SUM(CASE WHEN is_cutting_collar_bundle_ready=1
                THEN cut_qty
                ELSE 0 end) AS count_cutting_collar_bundle_qty,
                
                SUM(CASE WHEN is_cutting_back_bundle_ready=1
                THEN cut_qty
                ELSE 0 end) AS count_cutting_back_bundle_qty,
                
                SUM(CASE WHEN is_cutting_yoke_bundle_ready=1
                THEN cut_qty
                ELSE 0 end) AS count_cutting_yoke_bundle_qty,
                
                SUM(CASE WHEN is_cutting_sleeve_bundle_ready=1
                THEN cut_qty
                ELSE 0 end) AS count_cutting_sleeve_bundle_qty,
                
                SUM(CASE WHEN is_cutting_sleeve_plkt_bundle_ready=1
                THEN cut_qty
                ELSE 0 end) AS count_cutting_sleeve_plkt_bundle_qty,
                
                SUM(CASE WHEN is_cutting_pocket_bundle_ready=1
                THEN cut_qty
                ELSE 0 end) AS count_cutting_pocket_bundle_qty,

                SUM(CASE WHEN is_cutting_cuff_bundle_ready=1
                THEN cut_qty
                ELSE 0 end) AS count_cutting_cuff_bundle_qty,
                
                SUM(CASE WHEN is_package_ready=1
                THEN cut_qty
                ELSE 0 end) AS count_package_ready_qty
                
                FROM tb_cut_summary WHERE 1 $where GROUP BY po_no,so_no,item,quality,color,purchase_order
                )  as t1
                
                LEFT JOIN
                vt_po_summary as t2
                ON t1.so_no=t2.so_no AND t1.po_no=t2.po_no AND t1.purchase_order=t2.purchase_order 
                AND t1.item=t2.item AND t1.quality=t2.quality AND t1.color=t2.color
                
                LEFT JOIN
                vt_cut as t3
                ON t1.so_no=t3.so_no AND t1.po_no=t3.po_no AND t1.purchase_order=t3.purchase_order 
                AND t1.item=t3.item AND t1.quality=t3.quality AND t1.color=t3.color
                
                LEFT JOIN
                (SELECT po_no,so_no,item,quality,color,purchase_order, SUM(cut_qty) AS count_cut_package_ready_qty 
                FROM tb_cut_summary
                WHERE is_package_ready=1
                GROUP BY po_no,so_no,item,quality,color,purchase_order) AS t4
                ON t1.so_no=t4.so_no AND t1.po_no=t4.po_no AND t1.purchase_order=t4.purchase_order 
                AND t1.item=t4.item AND t1.quality=t4.quality AND t1.color=t4.color
                
                ORDER  BY cutting_collar_bundle_ready_date_time";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getPendingPOPackage()
    {
        $sql="SELECT t1.*, t2.total_order_qty, t2.total_cut_qty
                FROM (
                SELECT po_no,so_no,item,quality,color,purchase_order,ex_factory_date,brand,style_no,style_name, planned_line_id,
                SUM(CASE WHEN is_cutting_collar_bundle_ready=1
                THEN cut_qty
                ELSE 0 end) AS count_cutting_collar_bundle_qty,
                
                SUM(CASE WHEN is_cutting_back_bundle_ready=1
                THEN cut_qty
                ELSE 0 end) AS count_cutting_back_bundle_qty,
                
                SUM(CASE WHEN is_cutting_yoke_bundle_ready=1
                THEN cut_qty
                ELSE 0 end) AS count_cutting_yoke_bundle_qty,
                
                SUM(CASE WHEN is_cutting_sleeve_bundle_ready=1
                THEN cut_qty
                ELSE 0 end) AS count_cutting_sleeve_bundle_qty,
                
                SUM(CASE WHEN is_cutting_sleeve_plkt_bundle_ready=1
                THEN cut_qty
                ELSE 0 end) AS count_cutting_sleeve_plkt_bundle_qty,
                
                SUM(CASE WHEN is_cutting_pocket_bundle_ready=1
                THEN cut_qty
                ELSE 0 end) AS count_cutting_pocket_bundle_qty,

                SUM(CASE WHEN is_cutting_cuff_bundle_ready=1
                THEN cut_qty
                ELSE 0 end) AS count_cutting_cuff_bundle_qty,
                
                SUM(CASE WHEN is_package_ready=1
                THEN cut_qty
                ELSE 0 end) AS count_package_ready_qty
                
                FROM tb_cut_summary WHERE 1 
                GROUP BY po_no,so_no,item,quality,color,purchase_order
                ) AS t1
                
                LEFT JOIN
                tb_production_summary AS t2
                ON t1.so_no=t2.so_no
                
                WHERE t2.total_cut_qty > t2.count_input_qty_line";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getRemainingPart($where)
    {
        $sql = "Select *,sum(cut_qty) as total_qty From `tb_cut_summary` 
                WHERE 1 $where GROUP  BY size,cut_no";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getLastDayProduction($where, $date){
//        $sql = "SELECT t1.so_no, t1.po_no, t1.purchase_order, t1.item, t1.quality, t1.color,
//                t1.responsible_line, t1.ex_factory_date, t1.status, t2.line_output_qty, t3.packing_qty, t4.carton_qty
//
//                FROM
//                (SELECT so_no, po_no, purchase_order, item, quality, color,
//                responsible_line, ex_factory_date, status FROM `tb_production_summary`
//                WHERE 1 $where) AS t1
//
//                LEFT JOIN
//                (SELECT so_no, po_no, purchase_order, item, quality, color, COUNT(id) as line_output_qty
//                 FROM `vt_few_days_po_pcs`
//                WHERE DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d')='$date'
//                $where
//                GROUP BY so_no, po_no, purchase_order, item, quality, color) as t2
//                ON t1.so_no=t2.so_no AND t1.purchase_order=t2.purchase_order
//                AND t1.item=t2.item AND t1.quality=t2.quality AND t1.color=t2.color
//
//                LEFT JOIN
//                (SELECT so_no, po_no, purchase_order, item, quality, color, COUNT(id) as packing_qty
//                 FROM `vt_few_days_po_pcs`
//                WHERE DATE_FORMAT(packing_date_time, '%Y-%m-%d')='$date'
//                $where
//                GROUP BY so_no, po_no, purchase_order, item, quality, color) as t3
//                ON t1.so_no=t3.so_no AND t1.purchase_order=t3.purchase_order
//                AND t1.item=t3.item AND t1.quality=t3.quality AND t1.color=t3.color
//
//                LEFT JOIN
//                (SELECT so_no, po_no, purchase_order, item, quality, color, COUNT(id) as carton_qty
//                 FROM `vt_few_days_po_pcs`
//                WHERE DATE_FORMAT(carton_date_time, '%Y-%m-%d')='$date'
//                $where
//                GROUP BY so_no, po_no, purchase_order, item, quality, color) as t4
//                ON t1.so_no=t4.so_no AND t1.purchase_order=t4.purchase_order
//                AND t1.item=t4.item AND t1.quality=t4.quality AND t1.color=t4.color";

        $sql = "SELECT t1.so_no, t1.po_no, t1.purchase_order, t1.item, t1.quality, t1.color, t1.style_no, t1.style_name, 
                t1.responsible_line, t1.ex_factory_date, t1.status, t1.brand, t1.po_type, t2.line_output_qty, 
                t3.packing_qty, t4.carton_qty, t5.cut_pass_qty, t6.line_mid_pass_qty
                
                FROM 
                (SELECT so_no, po_no, purchase_order, item, quality, color, style_no, style_name, 
                responsible_line, ex_factory_date, status, brand, po_type FROM `tb_production_summary`) AS t1
                
                LEFT JOIN
                (SELECT so_no, po_no, purchase_order, item, quality, color, COUNT(id) as line_output_qty 
                 FROM `tb_care_labels` 
                WHERE DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d')='$date'
                AND access_points=4 AND access_points_status=4
                
                GROUP BY so_no, po_no, purchase_order, item, quality, color) as t2
                ON t1.so_no=t2.so_no AND t1.purchase_order=t2.purchase_order 
                AND t1.item=t2.item AND t1.quality=t2.quality AND t1.color=t2.color
                
                LEFT JOIN
                (SELECT so_no, po_no, purchase_order, item, quality, color, COUNT(id) as packing_qty 
                 FROM `tb_care_labels` 
                WHERE DATE_FORMAT(packing_date_time, '%Y-%m-%d')='$date' AND packing_status=1
                
                GROUP BY so_no, po_no, purchase_order, item, quality, color) as t3
                ON t1.so_no=t3.so_no AND t1.purchase_order=t3.purchase_order 
                AND t1.item=t3.item AND t1.quality=t3.quality AND t1.color=t3.color
                
                LEFT JOIN
                (SELECT so_no, po_no, purchase_order, item, quality, color, COUNT(id) as carton_qty 
                 FROM `tb_care_labels` 
                WHERE DATE_FORMAT(carton_date_time, '%Y-%m-%d')='$date' AND carton_status=1                
                GROUP BY so_no, po_no, purchase_order, item, quality, color) as t4
                ON t1.so_no=t4.so_no AND t1.purchase_order=t4.purchase_order
                AND t1.item=t4.item AND t1.quality=t4.quality AND t1.color=t4.color
                
                 LEFT JOIN
                (SELECT so_no, po_no, purchase_order, item, quality, color, COUNT(id) as cut_pass_qty 
                 FROM `tb_care_labels` 
                WHERE DATE_FORMAT(sent_to_production_date_time, '%Y-%m-%d')='$date' AND sent_to_production=1
                
                GROUP BY so_no, po_no, purchase_order, item, quality, color) as t5
                ON t1.so_no=t5.so_no AND t1.purchase_order=t5.purchase_order 
                AND t1.item=t5.item AND t1.quality=t5.quality AND t1.color=t5.color
                
                LEFT JOIN
                (SELECT so_no, po_no, purchase_order, item, quality, color, COUNT(id) as line_mid_pass_qty 
                 FROM `tb_care_labels` 
                WHERE DATE_FORMAT(mid_line_qc_date_time, '%Y-%m-%d')='$date' 
                AND access_points >= 3 AND access_points_status IN (1, 4)
                
                GROUP BY so_no, po_no, purchase_order, item, quality, color) as t6
                ON t1.so_no=t6.so_no AND t1.purchase_order=t6.purchase_order 
                AND t1.item=t6.item AND t1.quality=t6.quality AND t1.color=t6.color";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getProductionSummaryReport($where, $order_by_condition){
//        $sql = "SELECT t1.*, t2.bundle_start, t2.bundle_end, t3.total_cut_input_qty,
//                t4.total_cut_qty, t5.count_input_qty_line, IFNULL(t7.count_mid_line_qc_pass, 0) as count_mid_line_qc_pass,
//                IFNULL(t8.count_end_line_qc_pass, 0) as count_end_line_qc_pass,
//                t10.count_washing_pass, t11.count_packing_pass, t11.max_packing_date_time,
//                t12.count_carton_pass, t12.max_carton_date_time,
//                t13.count_wh_prod_sample, t14.count_wh_buyer, t15.count_wh_factory, t17.count_wh_trash,
//                t18.responsible_line, t19.collar_bndl_qty, t20.cuff_bndl_qty, t22.planned_lines, t23.count_wh_others,
//                t24.count_washing_qty, t25.count_wh_lost, t26.count_wh_size_set, t27.total_manual_close_qty
//
//                From (SELECT * FROM `vt_po_summary`
//                WHERE 1 $where) as t1
//
//                LEFT JOIN
//                `vt_cut` as t2
//                ON t1.po_no=t2.po_no AND t1.so_no=t2.so_no AND t1.purchase_order=t2.purchase_order AND t1.item=t2.item
//                AND t1.quality=t2.quality AND t1.color=t2.color
//
//                LEFT JOIN
//                `vt_cut_pass` as t3
//                ON t1.po_no=t3.po_no AND t1.so_no=t3.so_no AND t1.purchase_order=t3.purchase_order AND t1.item=t3.item
//                AND t1.quality=t3.quality AND t1.color=t3.color
//
//                LEFT JOIN
//                (SELECT po_no, so_no, purchase_order, item, quality, color, COUNT(id) as total_cut_qty
//                FROM vt_few_days_po_pcs GROUP BY po_no, so_no, purchase_order, item, quality, color) as t4
//                ON t1.po_no=t4.po_no AND t1.so_no=t4.so_no AND t1.purchase_order=t4.purchase_order AND t1.item=t4.item
//                AND t1.quality=t4.quality AND t1.color=t4.color
//
//                LEFT JOIN
//                (SELECT po_no, so_no, purchase_order, item, quality, color, SUM(count_input_qty_line) as count_input_qty_line
//                FROM vt_input_line GROUP BY po_no, so_no, purchase_order, item, quality, color) as t5
//                ON t1.po_no=t5.po_no AND t1.so_no=t5.so_no AND t1.purchase_order=t5.purchase_order AND t1.item=t5.item
//                AND t1.quality=t5.quality AND t1.color=t5.color
//
//                LEFT JOIN
//                (SELECT po_no, so_no, purchase_order, item, quality, color, SUM(count_mid_line_qc_pass) as count_mid_line_qc_pass
//                FROM vt_mid_line_pass GROUP BY po_no, so_no, purchase_order, item, quality, color) as t7
//                ON t1.po_no=t7.po_no AND t1.so_no=t7.so_no AND t1.purchase_order=t7.purchase_order AND t1.item=t7.item
//                AND t1.quality=t7.quality AND t1.color=t7.color
//
//                LEFT JOIN
//                (SELECT po_no, so_no, purchase_order, item, quality, color, SUM(count_end_line_qc_pass) as count_end_line_qc_pass
//                FROM `vt_end_line_pass` GROUP BY po_no, so_no, purchase_order, item, quality, color) as t8
//                ON t1.po_no=t8.po_no AND t1.so_no=t8.so_no AND t1.purchase_order=t8.purchase_order AND t1.item=t8.item
//                AND t1.quality=t8.quality AND t1.color=t8.color
//
//                LEFT JOIN
//                (SELECT * FROM `vt_wash_return` GROUP BY po_no, so_no, purchase_order, item, quality, color) as t10
//                ON t1.po_no=t10.po_no AND t1.so_no=t10.so_no AND t1.purchase_order=t10.purchase_order AND t1.item=t10.item
//                AND t1.quality=t10.quality AND t1.color=t10.color
//
//                LEFT JOIN
//                (SELECT * FROM `vt_packing` GROUP BY po_no, so_no, purchase_order, item, quality, color) as t11
//                ON t1.po_no=t11.po_no AND t1.so_no=t11.so_no AND t1.purchase_order=t11.purchase_order AND t1.item=t11.item
//                AND t1.quality=t11.quality AND t1.color=t11.color
//
//                LEFT JOIN
//                (SELECT * FROM `vt_carton` GROUP BY po_no, so_no, purchase_order, item, quality, color) as t12
//                ON t1.po_no=t12.po_no AND t1.so_no=t12.so_no AND t1.purchase_order=t12.purchase_order AND t1.item=t12.item
//                AND t1.quality=t12.quality AND t1.color=t12.color
//
//                LEFT JOIN
//                (SELECT * FROM `vt_wh_prod_sample` GROUP BY po_no, so_no, purchase_order, item, quality, color) as t13
//                ON t1.po_no=t13.po_no AND t1.so_no=t13.so_no AND t1.purchase_order=t13.purchase_order AND t1.item=t13.item
//                AND t1.quality=t13.quality AND t1.color=t13.color
//
//                LEFT JOIN
//                (SELECT * FROM `vt_wh_buyer` GROUP BY po_no, so_no, purchase_order, item, quality, color) as t14
//                ON t1.po_no=t14.po_no AND t1.so_no=t14.so_no AND t1.purchase_order=t14.purchase_order AND t1.item=t14.item
//                AND t1.quality=t14.quality AND t1.color=t14.color
//
//                LEFT JOIN
//                (SELECT * FROM `vt_wh_factory` GROUP BY po_no, so_no, purchase_order, item, quality, color) as t15
//                ON t1.po_no=t15.po_no AND t1.so_no=t15.so_no AND t1.purchase_order=t15.purchase_order AND t1.item=t15.item
//                AND t1.quality=t15.quality AND t1.color=t15.color
//
//                LEFT JOIN
//                (SELECT * FROM `vt_wh_trash` GROUP BY po_no, so_no, purchase_order, item, quality, color) as t17
//                ON t1.po_no=t17.po_no AND t1.so_no=t17.so_no AND t1.purchase_order=t17.purchase_order AND t1.item=t17.item
//                AND t1.quality=t17.quality AND t1.color=t17.color
//
//                LEFT JOIN
//                (SELECT t1.po_no, t1.so_no, t1.purchase_order, t1.item, t1.quality, t1.color,
//                GROUP_CONCAT(t2.line_code SEPARATOR '; ') as responsible_line
//                From (SELECT *
//                FROM `vt_input_line`
//                GROUP BY po_no, so_no, purchase_order, item, quality, color, line_id) as t1
//
//                LEFT JOIN
//                (SELECT id, line_name, line_code FROM `tb_line`) as t2 On t1.line_id=t2.id
//                GROUP BY t1.po_no, t1.so_no, t1.purchase_order, t1.item, t1.quality, t1.color) as t18
//                ON t1.po_no=t18.po_no AND t1.so_no=t18.so_no AND t1.purchase_order=t18.purchase_order AND t1.item=t18.item
//                AND t1.quality=t18.quality AND t1.color=t18.color
//
//                LEFT JOIN
//                (SELECT po_no, so_no, purchase_order, item, style_no, quality, color,
//                SUM(cut_qty) as collar_bndl_qty FROM `tb_cut_summary`
//                WHERE is_bundle_collar_scanned_line=1 GROUP BY po_no, so_no, purchase_order, item, quality, color) as t19
//                ON t1.po_no=t19.po_no AND t1.so_no=t19.so_no AND t1.purchase_order=t19.purchase_order AND t1.item=t19.item
//                AND t1.quality=t19.quality AND t1.color=t19.color
//
//                LEFT JOIN
//                (SELECT po_no, so_no, purchase_order, item, style_no, quality, color,
//                SUM(cut_qty) as cuff_bndl_qty FROM `tb_cut_summary`
//                WHERE is_bundle_cuff_scanned_line=1 GROUP BY po_no, so_no, purchase_order, item, quality, color) as t20
//                ON t1.po_no=t20.po_no AND t1.so_no=t20.so_no AND t1.purchase_order=t20.purchase_order AND t1.item=t20.item
//                AND t1.quality=t20.quality AND t1.color=t20.color
//
//                LEFT JOIN
//                (SELECT t1.po_no, t1.so_no, t1.purchase_order, t1.item, t1.quality, t1.color,
//                GROUP_CONCAT(t2.line_code SEPARATOR '; ') as planned_lines
//                From (SELECT po_no, so_no, purchase_order, item, quality, color, planned_line_id
//                FROM `tb_care_labels` WHERE planned_line_id !=0
//                GROUP BY po_no, so_no, purchase_order, item, quality, color, planned_line_id) as t1
//
//                LEFT JOIN
//                (SELECT id, line_name, line_code FROM `tb_line`) as t2 On t1.planned_line_id=t2.id
//                GROUP BY t1.po_no, t1.so_no, t1.purchase_order, t1.item, t1.quality, t1.color) as t22
//                ON t1.po_no=t22.po_no AND t1.so_no=t22.so_no AND t1.purchase_order=t22.purchase_order AND t1.item=t22.item
//                AND t1.quality=t22.quality AND t1.color=t22.color
//
//                LEFT JOIN
//                (SELECT * FROM `vt_wh_others` GROUP BY po_no, so_no, purchase_order, item, quality, color) as t23
//                ON t1.po_no=t23.po_no AND t1.so_no=t23.so_no AND t1.purchase_order=t23.purchase_order AND t1.item=t23.item
//                AND t1.quality=t23.quality AND t1.color=t23.color
//
//                LEFT JOIN
//                (SELECT * FROM `vt_wash_send` GROUP BY po_no, so_no, purchase_order, item, quality, color) as t24
//                ON t1.po_no=t24.po_no AND t1.so_no=t24.so_no AND t1.purchase_order=t24.purchase_order AND t1.item=t24.item
//                AND t1.quality=t24.quality AND t1.color=t24.color
//
//                LEFT JOIN
//                (SELECT * FROM `vt_wh_lost` GROUP BY po_no, so_no, purchase_order, item, quality, color) as t25
//                ON t1.po_no=t25.po_no AND t1.so_no=t25.so_no AND t1.purchase_order=t25.purchase_order AND t1.item=t25.item
//                AND t1.quality=t25.quality AND t1.color=t25.color
//
//                LEFT JOIN
//                (SELECT * FROM `vt_wh_size_set` GROUP BY po_no, so_no, purchase_order, item, quality, color) as t26
//                ON t1.po_no=t26.po_no AND t1.so_no=t26.so_no AND t1.purchase_order=t26.purchase_order AND t1.item=t26.item
//                AND t1.quality=t26.quality AND t1.color=t26.color
//
//
//                LEFT JOIN
//                (SELECT po_no, so_no, purchase_order, item, quality, color, COUNT(id) as total_manual_close_qty
//                FROM vt_few_days_po_pcs WHERE manually_closed=1 GROUP BY po_no, so_no, purchase_order, item, quality, color) as t27
//                ON t1.po_no=t27.po_no AND t1.so_no=t27.so_no AND t1.purchase_order=t27.purchase_order AND t1.item=t27.item
//                AND t1.quality=t27.quality AND t1.color=t27.color
//
//                $order_by_condition";

        $sql = "SELECT t1.*, t2.total_cut_qty, t2.total_cut_qty, t2.total_cut_input_qty, 
                t2.count_input_qty_line, t2.count_mid_line_qc_pass, t2.count_end_line_qc_pass,
                t2.count_washing_qty, t2.count_washing_pass, t2.count_packing_pass, 
                t2.count_carton_pass, t2.total_wh_qa, t2.count_manual_close_qty, t2.count_cut_package_ready_qty, 
                t3.responsible_line, t4.collar_bndl_qty, t5.cuff_bndl_qty, t6.planned_lines, t7.max_carton_date_time
                
                FROM 
                (SELECT so_no, po_no, brand, purchase_order, item, quality, color, style_no, style_name, 
                ex_factory_date, crd_date, SUM(quantity) AS total_order_qty, wash_gmt, po_type, status
                FROM tb_po_detail 
                WHERE 1 $where
                GROUP BY so_no) AS t1
                
                LEFT JOIN
                (SELECT so_no, COUNT(id) AS total_cut_qty, COUNT(sent_to_production) AS total_cut_input_qty, 
                COUNT(line_id) AS count_input_qty_line, COUNT(mid_line_qc_date_time) AS count_mid_line_qc_pass, COUNT(end_line_qc_date_time) AS count_end_line_qc_pass,
                COUNT(is_going_wash) AS count_washing_qty, COUNT(washing_status) AS count_washing_pass, COUNT(packing_status) AS count_packing_pass, 
                COUNT(carton_status) AS count_carton_pass, COUNT(warehouse_qa_type) AS total_wh_qa, COUNT(manually_closed) AS count_manual_close_qty,
                COUNT(is_package_ready) AS count_cut_package_ready_qty
                FROM 
                (SELECT so_no,
                 CASE WHEN id > 0 THEN id END id,
                 CASE WHEN sent_to_production = 1 THEN sent_to_production END sent_to_production,
                 CASE WHEN line_id != 0 THEN line_id END line_id,
                 CASE WHEN access_points >= 3 AND access_points_status IN (1, 4) THEN mid_line_qc_date_time END mid_line_qc_date_time,
                 CASE WHEN access_points = 4 AND access_points_status = 4 THEN end_line_qc_date_time END end_line_qc_date_time,
                 CASE WHEN is_going_wash = 1 THEN is_going_wash END is_going_wash,
                 CASE WHEN washing_status = 1 THEN washing_status END washing_status,
                 CASE WHEN packing_status = 1 THEN packing_status END packing_status,
                 CASE WHEN carton_status = 1 THEN carton_status END carton_status,
                 CASE WHEN warehouse_qa_type != 0 THEN warehouse_qa_type END warehouse_qa_type,
                 CASE WHEN manually_closed = 1 THEN manually_closed END manually_closed,
                 CASE WHEN is_package_ready = 1 THEN is_package_ready END is_package_ready
                 
                FROM tb_care_labels) tb_care_labels 
                GROUP BY so_no) AS t2
                ON t1.so_no=t2.so_no
                
                LEFT JOIN
                (SELECT t1.so_no, GROUP_CONCAT(t2.line_code SEPARATOR '; ') as responsible_line
                From (SELECT so_no, line_id 
                FROM `tb_care_labels` 
                GROUP BY so_no, line_id) as t1
                                
                LEFT JOIN
                (SELECT id, line_name, line_code FROM `tb_line`) as t2 On t1.line_id=t2.id
                GROUP BY t1.so_no) as t3
                ON t1.so_no=t3.so_no
                
                LEFT JOIN
                (SELECT so_no, SUM(cut_qty) as collar_bndl_qty 
                FROM `tb_cut_summary`
                WHERE is_bundle_collar_scanned_line=1 
                GROUP BY so_no) as t4
                ON t1.so_no=t4.so_no
                
                LEFT JOIN
                (SELECT so_no, SUM(cut_qty) as cuff_bndl_qty 
                FROM `tb_cut_summary`
                WHERE is_bundle_cuff_scanned_line=1 
                GROUP BY so_no) as t5
                ON t1.so_no=t5.so_no
                
                LEFT JOIN
                (SELECT t1.so_no, GROUP_CONCAT(t2.line_code SEPARATOR '; ') as planned_lines
                From (SELECT so_no, planned_line_id 
                FROM `tb_care_labels` WHERE planned_line_id !=0 
                GROUP BY so_no, planned_line_id) as t1
                
                LEFT JOIN
                (SELECT id, line_name, line_code FROM `tb_line`) as t2 On t1.planned_line_id=t2.id
                GROUP BY t1.so_no) as t6
                ON t1.so_no=t6.so_no
                
                LEFT JOIN
                (SELECT so_no, MAX(carton_date_time) AS max_carton_date_time FROM `tb_care_labels` GROUP BY so_no) as t7
                ON t1.so_no=t7.so_no
                                
                WHERE t1.ex_factory_date != ''
                
                $order_by_condition";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getProducitonSummaryReportNew($where){
        $sql = "SELECT t1.*, t2.bundle_start, t2.bundle_end, t2.total_cut_qty, t3.cut_prod_date_time,
                t3.total_cut_input_qty, t4.min_care_label, t4.max_care_label, t5.count_input_qty_line,
                t6.collar_cuff_bndl_qty, (IFNULL(t7.count_mid_line_qc_pass, 0)+IFNULL(t8.count_mid_line_qc_pass_in_end, 0)) as count_mid_line_qc_pass,
                t9.count_end_line_qc_pass, t10.count_washing_pass, t11.count_packing_pass, t11.max_packing_date_time, t12.count_carton_pass, t12.max_carton_date_time,
                t13.count_wh_prod_sample, t14.count_wh_buyer, t15.count_wh_factory, t16.max_warehouse_last_action_date_time, t17.count_wh_trash,
                t18.responsible_line, t19.collar_bndl_qty, t20.cuff_bndl_qty, t21.min_line_input_date_time, t22.planned_lines, t23.count_other_purpose,
                t24.count_wash_going, t25.count_lost_qty
                
                From (SELECT * FROM `vt_po_summary`
                WHERE 1 
                $where
                GROUP BY po_no, so_no, purchase_order, item, quality, color) as t1
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color, MIN(bundle) as bundle_start, 
                MAX(bundle) as bundle_end, SUM(cut_qty) as total_cut_qty
                 FROM `tb_cut_summary` GROUP BY po_no, so_no, purchase_order, item, quality, color) as t2
                ON t1.po_no=t2.po_no AND t1.so_no=t2.so_no AND t1.purchase_order=t2.purchase_order AND t1.item=t2.item
                AND t1.quality=t2.quality AND t1.color=t2.color
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color, COUNT(id) as total_cut_input_qty,
                MAX(sent_to_production_date_time) as cut_prod_date_time
                FROM `vt_running_po_pcs` WHERE sent_to_production=1 
                GROUP BY po_no, so_no, purchase_order, item, quality, color) as t3
                ON t1.po_no=t3.po_no AND t1.so_no=t3.so_no AND t1.purchase_order=t3.purchase_order AND t1.item=t3.item
                AND t1.quality=t3.quality AND t1.color=t3.color
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color, MIN(CAST(pc_tracking_no AS UNSIGNED)) as min_care_label,
                MAX(CAST(pc_tracking_no AS UNSIGNED)) as max_care_label
                 FROM `vt_running_po_pcs` GROUP BY po_no, so_no, purchase_order, item, quality, color) as t4
                 ON t1.po_no=t4.po_no AND t1.so_no=t4.so_no AND t1.purchase_order=t4.purchase_order AND t1.item=t4.item
                AND t1.quality=t4.quality AND t1.color=t4.color
                 LEFT JOIN
                 (SELECT po_no, so_no, purchase_order, item, quality, color, style_no, style_name, COUNT(id) as count_input_qty_line
                FROM `vt_running_po_pcs` WHERE line_id !=0 GROUP BY po_no, so_no, purchase_order, item, quality, color) as t5
                ON t1.po_no=t5.po_no AND t1.so_no=t5.so_no AND t1.purchase_order=t5.purchase_order AND t1.item=t5.item
                AND t1.quality=t5.quality AND t1.color=t5.color
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, style_no, quality, color, SUM(cut_qty) as collar_cuff_bndl_qty FROM `tb_cut_summary`
                WHERE is_bundle_collar_cuff_scanned_line=1 GROUP BY po_no, so_no, purchase_order, item, quality, color) as t6
                ON t1.po_no=t6.po_no AND t1.so_no=t6.so_no AND t1.purchase_order=t6.purchase_order AND t1.item=t6.item
                AND t1.quality=t6.quality AND t1.color=t6.color
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color, COUNT(id) as count_mid_line_qc_pass
                FROM `vt_running_po_pcs` WHERE line_id !=0 AND access_points = 3
                AND access_points_status in (1)
                GROUP BY po_no, so_no, purchase_order, item, quality, color) as t7
                ON t1.po_no=t7.po_no AND t1.so_no=t7.so_no AND t1.purchase_order=t7.purchase_order AND t1.item=t7.item
                AND t1.quality=t7.quality AND t1.color=t7.color
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color, COUNT(id) as count_mid_line_qc_pass_in_end
                FROM `vt_running_po_pcs` WHERE line_id !=0 AND access_points = 4
                AND access_points_status in (1, 2, 3, 4)
                GROUP BY po_no, so_no, purchase_order, item, quality, color) as t8
                ON t1.po_no=t8.po_no AND t1.so_no=t8.so_no AND t1.purchase_order=t8.purchase_order AND t1.item=t8.item
                AND t1.quality=t8.quality AND t1.color=t8.color
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color, COUNT(pc_tracking_no) as count_end_line_qc_pass
                FROM `vt_running_po_pcs` WHERE line_id !=0 AND access_points = 4
                AND access_points_status=4
                GROUP BY po_no, so_no, purchase_order, item, quality, color) as t9
                ON t1.po_no=t9.po_no AND t1.so_no=t9.so_no AND t1.purchase_order=t9.purchase_order AND t1.item=t9.item
                AND t1.quality=t9.quality AND t1.color=t9.color
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color, COUNT(pc_tracking_no) as count_washing_pass
                FROM `vt_running_po_pcs` WHERE washing_status = 1
                GROUP BY po_no, so_no, purchase_order, item, quality, color) as t10
                ON t1.po_no=t10.po_no AND t1.so_no=t10.so_no AND t1.purchase_order=t10.purchase_order AND t1.item=t10.item
                AND t1.quality=t10.quality AND t1.color=t10.color
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color, COUNT(pc_tracking_no) as count_packing_pass,
                MAX(packing_date_time) as max_packing_date_time
                FROM `vt_running_po_pcs` WHERE packing_status = 1
                GROUP BY po_no, so_no, purchase_order, item, quality, color) as t11
                ON t1.po_no=t11.po_no AND t1.so_no=t11.so_no AND t1.purchase_order=t11.purchase_order AND t1.item=t11.item
                AND t1.quality=t11.quality AND t1.color=t11.color
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color, COUNT(pc_tracking_no) as count_carton_pass,
                MAX(carton_date_time) as max_carton_date_time
                FROM `vt_running_po_pcs` WHERE carton_status = 1
                GROUP BY po_no, so_no, purchase_order, item, quality, color) as t12
                ON t1.po_no=t12.po_no AND t1.so_no=t12.so_no AND t1.purchase_order=t12.purchase_order AND t1.item=t12.item
                AND t1.quality=t12.quality AND t1.color=t12.color
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color, COUNT(pc_tracking_no) as count_wh_prod_sample
                FROM `vt_running_po_pcs` WHERE warehouse_qa_type = 4
                GROUP BY po_no, so_no, purchase_order, item, quality, color) as t13
                ON t1.po_no=t13.po_no AND t1.so_no=t13.so_no AND t1.purchase_order=t13.purchase_order AND t1.item=t13.item
                AND t1.quality=t13.quality AND t1.color=t13.color
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color, COUNT(pc_tracking_no) as count_wh_buyer
                FROM `vt_running_po_pcs` WHERE warehouse_qa_type = 1
                GROUP BY po_no, so_no, purchase_order, item, quality, color) as t14
                ON t1.po_no=t14.po_no AND t1.so_no=t14.so_no AND t1.purchase_order=t14.purchase_order AND t1.item=t14.item
                AND t1.quality=t14.quality AND t1.color=t14.color
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color, COUNT(pc_tracking_no) as count_wh_factory
                FROM `vt_running_po_pcs` WHERE warehouse_qa_type = 2
                GROUP BY po_no, so_no, purchase_order, item, quality, color) as t15
                ON t1.po_no=t15.po_no AND t1.so_no=t15.so_no AND t1.purchase_order=t15.purchase_order AND t1.item=t15.item
                AND t1.quality=t15.quality AND t1.color=t15.color
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color,
                MAX(warehouse_last_action_date_time) as max_warehouse_last_action_date_time
                FROM `vt_running_po_pcs`
                GROUP BY po_no, so_no, purchase_order, item, quality, color) as t16
                ON t1.po_no=t16.po_no AND t1.so_no=t16.so_no AND t1.purchase_order=t16.purchase_order AND t1.item=t16.item
                AND t1.quality=t16.quality AND t1.color=t16.color
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color, COUNT(pc_tracking_no) as count_wh_trash
                FROM `vt_running_po_pcs` WHERE warehouse_qa_type = 3
                GROUP BY po_no, so_no, purchase_order, item, quality, color) as t17
                ON t1.po_no=t17.po_no AND t1.so_no=t17.so_no AND t1.purchase_order=t17.purchase_order AND t1.item=t17.item
                AND t1.quality=t17.quality AND t1.color=t17.color
                LEFT JOIN
                (SELECT t1.po_no, t1.so_no, t1.purchase_order, t1.item, t1.quality, t1.color, 
                GROUP_CONCAT(t2.line_code SEPARATOR '; ') as responsible_line
                From (SELECT po_no, so_no, purchase_order, item, quality, color, line_id 
                FROM `vt_running_po_pcs` WHERE line_id !=0 
                GROUP BY po_no, so_no, purchase_order, item, quality, color, line_id) as t1
                LEFT JOIN
                (SELECT id, line_name, line_code FROM `tb_line`) as t2 On t1.line_id=t2.id
                GROUP BY t1.po_no, t1.so_no, t1.purchase_order, t1.item, t1.quality, t1.color) as t18
                ON t1.po_no=t18.po_no AND t1.so_no=t18.so_no AND t1.purchase_order=t18.purchase_order AND t1.item=t18.item
                AND t1.quality=t18.quality AND t1.color=t18.color
                
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, style_no, quality, color,
                SUM(cut_qty) as collar_bndl_qty FROM `tb_cut_summary`
                WHERE is_bundle_collar_scanned_line=1 GROUP BY po_no, so_no, purchase_order, item, quality, color) as t19
                ON t1.po_no=t19.po_no AND t1.so_no=t19.so_no AND t1.purchase_order=t19.purchase_order AND t1.item=t19.item
                AND t1.quality=t19.quality AND t1.color=t19.color
                
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, style_no, quality, color,
                SUM(cut_qty) as cuff_bndl_qty FROM `tb_cut_summary`
                WHERE is_bundle_cuff_scanned_line=1 GROUP BY po_no, so_no, purchase_order, item, quality, color) as t20
                ON t1.po_no=t20.po_no AND t1.so_no=t20.so_no AND t1.purchase_order=t20.purchase_order AND t1.item=t20.item
                AND t1.quality=t20.quality AND t1.color=t20.color
                
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color, MIN(line_input_date_time) as min_line_input_date_time
                FROM `vt_running_po_pcs` WHERE sent_to_production=1 AND line_input_date_time != '0000-00-00 00:00:00'
                GROUP BY po_no, so_no, purchase_order, item, quality, color) as t21
                ON t1.po_no=t21.po_no AND t1.so_no=t21.so_no AND t1.purchase_order=t21.purchase_order AND t1.item=t21.item
                AND t1.quality=t21.quality AND t1.color=t21.color
                
                LEFT JOIN
                (SELECT t1.po_no, t1.so_no, t1.purchase_order, t1.item, t1.quality, t1.color, 
                GROUP_CONCAT(t2.line_code SEPARATOR '; ') as planned_lines
                From (SELECT po_no, so_no, purchase_order, item, quality, color, planned_line_id 
                FROM `vt_running_po_pcs` WHERE planned_line_id !=0 
                GROUP BY po_no, so_no, purchase_order, item, quality, color, planned_line_id) as t1
                
                LEFT JOIN
                (SELECT id, line_name, line_code FROM `tb_line`) as t2 On t1.planned_line_id=t2.id
                GROUP BY t1.po_no, t1.so_no, t1.purchase_order, t1.item, t1.quality, t1.color) as t22
                ON t1.po_no=t22.po_no AND t1.so_no=t22.so_no AND t1.purchase_order=t22.purchase_order AND t1.item=t22.item
                AND t1.quality=t22.quality AND t1.color=t22.color
                
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color, 
                COUNT(pc_tracking_no) as count_other_purpose
                FROM `vt_running_po_pcs` WHERE warehouse_qa_type = 5
                GROUP BY po_no, so_no, purchase_order, item, quality, color) as t23
                ON t1.po_no=t23.po_no AND t1.so_no=t23.so_no AND t1.purchase_order=t23.purchase_order AND t1.item=t23.item
                AND t1.quality=t23.quality AND t1.color=t23.color
                
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color, COUNT(pc_tracking_no) as count_wash_going
                FROM `vt_running_po_pcs` WHERE is_going_wash = 1
                GROUP BY po_no, so_no, purchase_order, item, quality, color) as t24
                ON t1.po_no=t24.po_no AND t1.so_no=t24.so_no AND t1.purchase_order=t24.purchase_order AND t1.item=t24.item
                AND t1.quality=t24.quality AND t1.color=t24.color
                
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color, COUNT(pc_tracking_no) as count_lost_qty
                FROM `vt_running_po_pcs` WHERE warehouse_qa_type = 6
                GROUP BY po_no, so_no, purchase_order, item, quality, color) as t25
                ON t1.po_no=t25.po_no AND t1.so_no=t25.so_no AND t1.purchase_order=t25.purchase_order AND t1.item=t25.item
                AND t1.quality=t25.quality AND t1.color=t25.color
                
                WHERE ((IFNULL(t2.total_cut_qty, 0) - IFNULL(t12.count_carton_pass, 0) + IFNULL(t13.count_wh_prod_sample, 0) + IFNULL(t15.count_wh_factory, 0) + IFNULL(t14.count_wh_buyer, 0) + IFNULL(t17.count_wh_trash, 0) + IFNULL(t23.count_other_purpose, 0) + IFNULL(t25.count_lost_qty, 0))) > 0
                
                ORDER BY t1.ex_factory_date DESC";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getBuyerShipDateWiseReport($where){
        $sql = "SELECT t1.*, t2.count_carton_qty
                
                From (SELECT ex_factory_date, SUM(quantity) as total_order_qty FROM `tb_po_detail`
                WHERE 1
                AND DATE_FORMAT(ex_factory_date, '%Y-%m-%d') 
                BETWEEN (CURDATE() - INTERVAL 60 day) AND (CURDATE() + INTERVAL 30 day) 
                $where
                GROUP BY ex_factory_date) as t1
                
                LEFT JOIN 
                (SELECT ex_factory_date, COUNT(id) AS count_carton_qty 
                FROM `tb_care_labels` 
                WHERE carton_status=1 
                $where
                AND DATE_FORMAT(ex_factory_date, '%Y-%m-%d') 
                BETWEEN (CURDATE() - INTERVAL 60 day) AND (CURDATE() + INTERVAL 30 day) 
                GROUP BY ex_factory_date) AS t2
                ON t1.ex_factory_date=t2.ex_factory_date
                
                ORDER BY t1.ex_factory_date DESC";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function lineWIPReportChart(){
        $sql = "Select A.*, B.line_name, C.floor_name From (SELECT line_id, COUNT(pc_tracking_no) as count_wip_qty 
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points_status < 4
                GROUP BY line_id) as A
                
                Inner Join
                tb_line as B ON A.line_id=B.id
                INNER JOIN
                tb_floor as C ON B.floor=C.id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getLineDefectReportForChart($date){
//        $sql = "SELECT A.*, E.count_mid_pass_qty, F.count_end_line_qc_pass, I.line_name, J.floor_name
//                FROM (SELECT line_id, COUNT(pc_tracking_no) as count_qty_line
//                FROM `tb_care_labels` WHERE line_id !=0 AND access_points_status < 4
//                GROUP BY line_id) as A
//
//                LEFT JOIN
//                (SELECT line_id, COUNT(pc_tracking_no) as count_mid_pass_qty,
//                DATE_FORMAT(mid_line_qc_date_time, '%Y-%m-%d') as mid_line_qc_date_time
//                FROM `tb_care_labels`
//                WHERE line_id !=0
//                AND sent_to_production=1
//                AND access_points = 3
//                AND access_points_status = 2
//                AND DATE_FORMAT(mid_line_qc_date_time, '%Y-%m-%d') LIKE '%$date%'
//                GROUP BY DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d'), line_id) as E
//                ON A.line_id=E.line_id
//
//                LEFT JOIN
//                (SELECT line_id, COUNT(pc_tracking_no) as count_end_line_qc_pass,
//                DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') as end_line_qc_date_time
//                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 4 AND access_points_status=2
//                AND DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') LIKE '%$date%'
//                GROUP BY DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d'), line_id) as F
//                ON A.line_id=F.line_id
//
//                Inner Join
//                tb_line as I ON A.line_id=I.id
//                INNER JOIN
//                tb_floor as J ON I.floor=J.id";

        $sql = "SELECT A.*, E.count_mid_defect_qty, F.count_end_defect_qty, 
                G.count_mid_defect_recovered_qty, H.count_end_defect_recovered_qty, I.line_name, J.floor_name 
                FROM (SELECT line_id FROM `tb_defects_tracking` WHERE line_id !=0
                GROUP BY line_id) as A
            
                LEFT JOIN 
                (Select t1.*, COUNT(pc_tracking_no) as count_mid_defect_qty From 
                (SELECT line_id, pc_tracking_no, 
                DATE_FORMAT(defect_date_time, '%Y-%m-%d') as mid_defect_date_time 
                FROM `tb_defects_tracking` 
                WHERE line_id !=0 
                AND qc_point=3 
                AND DATE_FORMAT(defect_date_time, '%Y-%m-%d') LIKE '%$date%'
                GROUP BY DATE_FORMAT(defect_date_time, '%Y-%m-%d'), line_id, pc_tracking_no) as t1) as E
                ON A.line_id=E.line_id
                
                LEFT JOIN
                (Select t1.*, COUNT(pc_tracking_no) as count_end_defect_qty 
                From (SELECT line_id, pc_tracking_no,
                DATE_FORMAT(defect_date_time, '%Y-%m-%d') as end_defect_date_time 
                FROM `tb_defects_tracking` 
                WHERE line_id !=0 
                AND qc_point=4 
                AND DATE_FORMAT(defect_date_time, '%Y-%m-%d') LIKE '%$date%'
                GROUP BY DATE_FORMAT(defect_date_time, '%Y-%m-%d'), line_id, pc_tracking_no) as t1) as F
                ON A.line_id=F.line_id
                
                LEFT JOIN 
                (Select t1.*, COUNT(pc_tracking_no) as count_mid_defect_recovered_qty From 
                (SELECT line_id, pc_tracking_no, 
                DATE_FORMAT(defect_recovered_date_time, '%Y-%m-%d') as mid_defect_recovered_date_time 
                FROM `tb_defects_tracking` 
                WHERE line_id !=0 
                AND qc_point=3 
                AND defect_recovered=1
                AND DATE_FORMAT(defect_recovered_date_time, '%Y-%m-%d') LIKE '%$date%'
                GROUP BY DATE_FORMAT(defect_recovered_date_time, '%Y-%m-%d'), line_id, pc_tracking_no) as t1) as G
                ON A.line_id=G.line_id
                
                LEFT JOIN 
                (Select t1.*, COUNT(pc_tracking_no) as count_end_defect_recovered_qty From 
                (SELECT line_id, pc_tracking_no, 
                DATE_FORMAT(defect_recovered_date_time, '%Y-%m-%d') as end_defect_recovered_date_time 
                FROM `tb_defects_tracking` 
                WHERE line_id !=0 
                AND qc_point=4 
                AND defect_recovered=1
                AND DATE_FORMAT(defect_recovered_date_time, '%Y-%m-%d') LIKE '%$date%'
                GROUP BY DATE_FORMAT(defect_recovered_date_time, '%Y-%m-%d'), line_id, pc_tracking_no) as t1) as H
                ON A.line_id=H.line_id
                
                Inner Join
                tb_line as I ON A.line_id=I.id
                INNER JOIN
                tb_floor as J ON I.floor=J.id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getDailyCutProductionSummaryReport($search_date){
        $sql = "SELECT * FROM `tb_daily_cut_summary` WHERE date='$search_date'";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getDailyLineProductionSummaryReport($search_date){
        $sql = "SELECT t1.*, t2.line_name, t2.line_code 
                FROM `tb_daily_line_summary` as t1
                LEFT JOIN 
                `tb_line` as t2
                ON t1.line_id=t2.id
                WHERE date='$search_date'";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getDailyFinishingProductionSummaryReport($search_date){
        $sql = "SELECT t1.*, t2.floor_name, t2.floor_code, t3.carton_qty
                FROM 
                (SELECT * FROM `tb_daily_finish_summary` WHERE date='$search_date') as t1 
                LEFT JOIN 
                `tb_floor` as t2
                ON t1.floor_id=t2.id
                LEFT JOIN
                (SELECT COUNT(id) AS carton_qty, finishing_floor_id 
                 FROM vt_few_days_po_pcs 
                 WHERE DATE_FORMAT(carton_date_time, '%Y-%m-%d')='$search_date' 
                 GROUP BY finishing_floor_id) AS t3
                 ON t1.floor_id=t3.finishing_floor_id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getDetailsAqlreportToday($encoded_brand, $date)
    {
        $sql = "SELECT *,sum(quantity) as total_order_qty FROM `tb_po_detail` WHERE aql_status IN('0', '2') 
                AND aql_plan_date = '$date' AND brand='$encoded_brand' 
                AND aql_plan_date!='0000-00-00' GROUP BY so_no";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getDetailsAqlreport($encoded_brand, $date)
    {
        $sql = "SELECT *,sum(quantity) as total_order_qty FROM `tb_po_detail` WHERE aql_status IN('0', '2') 
                AND aql_plan_date < '$date' AND brand='$encoded_brand' 
                AND aql_plan_date!='0000-00-00' GROUP BY so_no";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function isAvailAlready($where){
        $sql = "SELECT * FROM `tb_po_detail` 
                WHERE 1 $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getLineId($line)
    {
        $sql = "SELECT * FROM `tb_line` 
                WHERE line_name='$line' 
                AND line_code='$line'";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function lineWipQty($line_id){
        $sql = "Select A.*, I.line_name, J.floor_name FROM 
                (SELECT * FROM `tb_care_labels` 
                WHERE line_id=$line_id AND access_points_status < 4) as A               
                
                Inner Join
                tb_line as I ON A.line_id=I.id
                INNER JOIN
                tb_floor as J ON I.floor=J.id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function midQcPass($line_id, $date){
        $sql = "Select A.*, I.line_name, J.floor_name FROM 
                (SELECT * FROM `tb_care_labels` 
                WHERE line_id=$line_id 
                AND access_points >= 3
                AND access_points_status in (1, 4)
                AND DATE_FORMAT(mid_line_qc_date_time, '%Y-%m-%d') LIKE '%$date%') as A
                
                Inner Join
                tb_line as I ON A.line_id=I.id
                INNER JOIN
                tb_floor as J ON I.floor=J.id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function midQcDefects($line_id, $date){
        $sql = "Select A.*, I.line_name, J.floor_name FROM 
                (SELECT * FROM `tb_care_labels` 
                WHERE line_id=$line_id 
                AND access_points = 3 
                AND access_points_status=2
                AND DATE_FORMAT(mid_line_qc_date_time, '%Y-%m-%d') LIKE '%$date%') as A
                
                Inner Join
                tb_line as I ON A.line_id=I.id
                INNER JOIN
                tb_floor as J ON I.floor=J.id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function midQcRejects($line_id, $date){
        $sql = "Select A.*, I.line_name, J.floor_name FROM 
                (SELECT * FROM `tb_care_labels` 
                WHERE line_id=$line_id 
                AND access_points = 3 
                AND access_points_status=3
                AND DATE_FORMAT(mid_line_qc_date_time, '%Y-%m-%d') LIKE '%$date%') as A
                
                Inner Join
                tb_line as I ON A.line_id=I.id
                INNER JOIN
                tb_floor as J ON I.floor=J.id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function endQcPass($line_id, $date){
        $sql = "Select A.*, I.line_name, J.floor_name FROM 
                (SELECT * FROM `tb_care_labels` 
                WHERE line_id=$line_id 
                AND access_points = 4
                AND access_points_status = 4
                AND DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') LIKE '%$date%') as A
                
                Inner Join
                tb_line as I ON A.line_id=I.id
                INNER JOIN
                tb_floor as J ON I.floor=J.id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function endQcDefects($line_id, $date){
        $sql = "Select A.*, I.line_name, J.floor_name FROM 
                (SELECT * FROM `tb_care_labels` 
                WHERE line_id=$line_id 
                AND access_points = 4
                AND access_points_status = 2
                AND DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') LIKE '%$date%') as A
                
                Inner Join
                tb_line as I ON A.line_id=I.id
                INNER JOIN
                tb_floor as J ON I.floor=J.id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function endQcRejects($line_id, $date){
        $sql = "Select A.*, I.line_name, J.floor_name FROM 
                (SELECT * FROM `tb_care_labels` 
                WHERE line_id=$line_id 
                AND access_points = 4
                AND access_points_status = 3
                AND DATE_FORMAT(mid_line_qc_date_time, '%Y-%m-%d') LIKE '%$date%') as A
                
                Inner Join
                tb_line as I ON A.line_id=I.id
                INNER JOIN
                tb_floor as J ON I.floor=J.id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function lineInputQty($line_id, $date){
        $sql = "Select A.*, I.line_name, J.floor_name FROM 
                (SELECT * FROM `tb_care_labels` 
                WHERE line_id=$line_id AND DATE_FORMAT(line_input_date_time, '%Y-%m-%d') LIKE '%$date%' 
                GROUP BY DATE_FORMAT(line_input_date_time, '%Y-%m-%d'), line_id) as A
                
                Inner Join
                tb_line as I ON A.line_id=I.id
                INNER JOIN
                tb_floor as J ON I.floor=J.id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getBundleSummary($where){
        $sql = "SELECT po_no, purchase_order, item, quality, style_no, style_name, 
                color, brand, cut_no, cut_tracking_no, `size`, cut_qty, cut_layer, bundle, bundle_range 
                FROM `tb_cut_summary` WHERE 1 $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getAllShipDates(){
//        $sql = "SELECT ex_factory_date
//                FROM `tb_po_detail`
//                GROUP BY ex_factory_date";

         $sql = "SELECT ex_factory_date 
                 FROM `tb_po_detail` 
                 WHERE ex_factory_date 
                 BETWEEN (CURDATE() - INTERVAL 60 day) AND (CURDATE() + INTERVAL 60 day)
                 GROUP BY ex_factory_date";


        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getBrandWiseShipDates($where){
        $sql = "SELECT ex_factory_date
                 FROM `tb_po_detail`
                 WHERE 1
                 $where
                 GROUP BY ex_factory_date";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getDailyLineOutputReport($where){
        $sql = "SELECT A.*, B.line_code, C.total_order_qty
                FROM 
                (SELECT po_no,so_no,item,quality,color,purchase_order,line_id,brand,
                ex_factory_date,style_no,style_name, line_output_date,
                    
                  COUNT(line_output) as line_output_qty,
                  COUNT(line_manual_output) as line_manual_output_qty
                  
                 
                FROM (
                  SELECT
                    so_no,po_no,item,quality,color,purchase_order,line_id,brand,ex_factory_date,line_input_date_time,style_no,style_name,
                    DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') AS line_output_date,                   
                    
                   CASE WHEN access_points=4 AND access_points_status=4 AND manually_closed=0 AND line_id != 0 THEN id END line_output,
                   CASE WHEN access_points=4 AND access_points_status=4 AND manually_closed=1 AND line_id != 0 THEN id END line_manual_output
                   
                  FROM tb_care_labels 
                ) tb_care_labels 
                WHERE 1 $where 
                GROUP BY so_no, line_id, line_output_date) AS A
                
                LEFT JOIN
                tb_line AS B
                ON A.line_id=B.id
                
                LEFT JOIN
                tb_production_summary AS C
                ON A.so_no=C.so_no
                
                WHERE A.line_output_date != '0000-00-00'";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getShipDateWiseDailyReport($where)
    {
        $sql = "SELECT A.*, B.line_code, C.total_order_qty
                FROM 
                (SELECT po_no,so_no,item,quality,color,purchase_order,line_id,brand,
                ex_factory_date,style_no,style_name, line_output_date,
                    
                  COUNT(line_output) as line_output_qty,
                  COUNT(line_manual_output) as line_manual_output_qty
                  
                 
                FROM (
                  SELECT
                    so_no,po_no,item,quality,color,purchase_order,line_id,brand,ex_factory_date,line_input_date_time,style_no,style_name,po_type,
                    DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') AS line_output_date,                   
                    
                   CASE WHEN access_points=4 AND access_points_status=4 AND manually_closed=0 AND line_id != 0 THEN id END line_output,
                   CASE WHEN access_points=4 AND access_points_status=4 AND manually_closed=1 AND line_id != 0 THEN id END line_manual_output
                   
                  FROM tb_care_labels 
                ) tb_care_labels 
                WHERE 1 $where
                GROUP BY so_no, line_id, line_output_date) AS A
                
                LEFT JOIN
                tb_line AS B
                ON A.line_id=B.id
                
                LEFT JOIN
                tb_production_summary AS C
                ON A.so_no=C.so_no
                
                WHERE A.line_output_date != '0000-00-00'";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getAllLinePerformanceSummaryReport($date){
        $sql = "SELECT t1.*, t2.line_name, t2.line_code, t3.target
                FROM 
                (SELECT line_id, `date`, SUM(qty) as total_output_qty, efficiency, 
                SUM(dhu) as sum_dhu, work_hour_1, work_hour_2, work_hour_3, work_hour_4
                FROM `tb_today_line_output_qty` 
                WHERE `date`='$date'
                GROUP BY line_id) as t1
                LEFT JOIN 
                `tb_line` as t2
                ON t1.line_id=t2.id
                LEFT JOIN 
                `line_daily_target` as t3
                ON t1.line_id=t3.line_id AND t1.date=t3.date
                ORDER BY (t2.line_code * 1) ASC";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getLineWisePerformanceDashboard($date){
        $sql = "SELECT t1.*, t2.line_name, t2.line_code, t3.target
                FROM 
                (SELECT line_id, `date`, SUM(qty) as total_output_qty, efficiency, 
                SUM(dhu) as sum_dhu, work_hour_1, work_hour_2, work_hour_3, work_hour_4
                FROM `tb_today_line_output_qty` 
                WHERE `date`='$date'
                GROUP BY line_id) as t1
                LEFT JOIN 
                `tb_line` as t2
                ON t1.line_id=t2.id
                LEFT JOIN 
                `line_daily_target` as t3
                ON t1.line_id=t3.line_id AND t1.date=t3.date
                ORDER BY (t2.line_code * 1) ASC";

        $query = $this->db->query($sql)->result();
        return $query;
    }

    public function updateTodayEfficiency($line_id, $set_fields){
        $sql = "UPDATE tb_today_line_output_qty 
                $set_fields
                WHERE line_id=$line_id";

        $query = $this->db->query($sql);
        return $query;
    }

    public function lineQualityDefectSave($line_id, $dhu, $time){
        $sql="UPDATE `tb_today_line_output_qty`
              SET dhu='$dhu'
              WHERE '$time' BETWEEN start_time AND end_time
              AND `line_id`=$line_id";

        $query = $this->db->query($sql);
        return $query;
    }

    public function updatePerHourTarget($line_id, $start_time, $end_time, $per_hour_actual_target){
        $sql="UPDATE `tb_today_line_output_qty`
              SET target_hr='$per_hour_actual_target'
              WHERE start_time='$start_time' AND end_time='$end_time'
              AND `line_id`=$line_id";

        $query = $this->db->query($sql);
        return $query;
    }

    public function updateTbl($tbl, $id, $data)
    {
        $this->db->where('id', $id);
        $query = $this->db->update($tbl, $data);

        return $query;
    }

    public function updateTbl_2($tbl, $po_no, $data)
    {
        $this->db->where('po_no', $po_no);
        $query = $this->db->update($tbl, $data);

        return $query;
    }
}

?>