<?php

class Access_model extends CI_Model {
    //put your code here

    public function insertingData($tbl, $data)
    {
	    $this->db->INSERT($tbl, $data);
        //return $this->db->insert_id();
    }

    public function selectTableData($fields, $tbl, $condition_column, $condition_value)
    {
        $this->db->select($fields);
        $this->db->from($tbl);
        $this->db->where($condition_column, $condition_value);
        $query=  $this->db->get();
        $result=$query->result_array();
        return $result;
    }

    public function deleteTableData($tbl, $condition_column, $condition_value)
    {
        $this->db->where($condition_column, $condition_value);
        $this->db->delete($tbl);
    }

    public function getSegments($time)
    {
        $sql = "SELECT *,
                (TIME_TO_SEC(end_time) - TIME_TO_SEC(start_time)) as working_time_diff_to_sec, 
                SEC_TO_TIME((TIME_TO_SEC(end_time) - TIME_TO_SEC(start_time))) as working_hours_min_sec,
                TIME_TO_SEC(start_time) AS min_time_to_sec
                FROM `tb_segment` 
                WHERE '$time' BETWEEN start_time AND end_time";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getSegmentList($where)
    {
        $sql = "SELECT *
                FROM `tb_segment` 
                WHERE 1 $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function isDefectAvailable($carelabel_tracking_no, $line, $access_points, $defect_code, $date_time)
    {
        $sql = "SELECT * FROM `tb_defects_tracking`
                WHERE pc_tracking_no = '$carelabel_tracking_no' 
                AND line_id=$line AND qc_point=$access_points
                AND defect_code = '$defect_code'
                AND defect_recovered=0
                AND defect_date_time='$date_time'";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function updateTodayWip($line_id, $wip)
    {
        $sql = "UPDATE tb_today_line_output_qty SET wip='$wip' WHERE `line_id` = '$line_id'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function deleteTodayLineOutputTable($line_id){
        $sql = "Delete From tb_today_line_output_qty WHERE line_id=$line_id";

        $query = $this->db->query($sql);
        return $query;
    }

    public function activeCl($cl_no, $date_time)
    {
        $sql = "UPDATE tb_care_labels SET is_reprint_allow=1,reprint_allow_date_time='$date_time' WHERE pc_tracking_no='$cl_no'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function updateLabelReprintLog($pc_no, $data)
    {
        $this->db->where('pc_tracking_no',$pc_no);
        $this->db->update('tb_label_reprint_log',$data);
    }

    public function getReprintCl()
    {
        $sql = "SELECT t1.pc_tracking_no, t1.referenced_by, t2.* 
                FROM (SELECT *  FROM `tb_label_reprint_log` 
                WHERE request_status=1 
                AND print_date_time='0000-00-00 00:00:00') AS t1
                LEFT JOIN
                vt_few_days_po_pcs as t2
                on t1.pc_tracking_no=t2.pc_tracking_no
                 WHERE t2.is_reprint_allow=1";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getCheckClPrintValidation($pc)
    {
        $sql = "SELECT *  FROM `tb_label_reprint_log` 
                WHERE pc_tracking_no='$pc'
                AND print_date_time='0000-00-00 00:00:00'";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getTodayLineOutputReport($line_id){
        $sql = "SELECT * FROM tb_today_line_output_qty 
                WHERE line_id=$line_id 
                ORDER BY start_time DESC";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getLineOutputReport($line_id, $date, $start_time, $end_time){
        $sql = "Select t1.*, t2.target, t2.remarks
                FROM 
                (SELECT * FROM 
                tb_today_line_output_qty
                WHERE line_id=$line_id
                AND `date`='$date'
                AND start_time='$start_time'
                AND end_time='$end_time') as t1
                LEFT JOIN
                (SELECT * FROM line_daily_target 
                WHERE `date`='$date' AND line_id=$line_id) AS t2
                ON t1.line_id=t2.line_id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getLineDhuSumReport($line_id, $date){
        $sql = "SELECT SUM(dhu) AS sum_dhu FROM 
                tb_today_line_output_qty
                WHERE line_id=$line_id
                AND `date`='$date'";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getLineOutputHourlyReport($select_fields, $where){
        $sql = "SELECT $select_fields FROM tb_today_line_output_qty 
                WHERE 1 $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getFloorLineOutputReport($floor_id){
        $sql = "SELECT t1.*, t2.*
                FROM (SELECT * FROM `tb_line` WHERE floor=$floor_id) AS t1
                LEFT JOIN
                (SELECT line_id, efficiency, (work_hour_1+work_hour_2+work_hour_3+work_hour_4) AS work_hour
                 FROM `tb_today_line_output_qty`
                 GROUP BY line_id) AS t2
                ON t1.id=t2.line_id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function cuttingbackPartTracking($bundle_tracking_no, $status_field, $status, $date_time_field, $date_time, $planned_line_id)
    {
        $sql = "Update `tb_cut_summary` 
                Set `is_cutting_back_bundle_ready`=1, `cutting_back_bundle_ready_date_time`='$date_time',  
                `planned_line_id`='$planned_line_id'
                WHERE bundle_tracking_no = '$bundle_tracking_no'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function cuttingSleevePartTracking($bundle_tracking_no, $status_field, $status, $date_time_field, $date_time, $planned_line_id)
    {
        $sql = "Update `tb_cut_summary` 
                Set `is_cutting_sleeve_bundle_ready`=1, `cutting_sleeve_bundle_ready_date_time`='$date_time',  
                `planned_line_id`='$planned_line_id'
                WHERE bundle_tracking_no = '$bundle_tracking_no'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function cuttingYokekPartTracking($bundle_tracking_no, $status_field, $status, $date_time_field, $date_time, $planned_line_id)
    {
        $sql = "Update `tb_cut_summary` 
                Set `is_cutting_yoke_bundle_ready`=1, `cutting_yoke_bundle_ready_date_time`='$date_time',  
                `planned_line_id`='$planned_line_id'
                WHERE bundle_tracking_no = '$bundle_tracking_no'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function cuttingSlvPktPartTracking($bundle_tracking_no, $status_field, $status, $date_time_field, $date_time, $planned_line_id)
    {
        $sql = "Update `tb_cut_summary` 
                Set `is_cutting_sleeve_plkt_bundle_ready`=1, `cutting_sleeve_plkt_bundle_ready_date_time`='$date_time',  
                `planned_line_id`='$planned_line_id'
                WHERE bundle_tracking_no = '$bundle_tracking_no'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function cuttingPocketPartTracking($bundle_tracking_no, $status_field, $status, $date_time_field, $date_time, $planned_line_id)
    {
        $sql = "Update `tb_cut_summary` 
                Set `is_cutting_pocket_bundle_ready`=1, `cutting_pocket_bundle_ready_date_time`='$date_time',  
                `planned_line_id`='$planned_line_id'
                WHERE bundle_tracking_no = '$bundle_tracking_no'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function search_po_no($bundle_tracking_no)
    {
        $sql = "SELECT po_no,so_no FROM `tb_cut_summary` WHERE bundle_tracking_no='$bundle_tracking_no' GROUP BY po_no,so_no";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function search_part_no($po_no)
    {
        $sql = "SELECT * FROM `tb_po_part_detail` WHERE po_no='$po_no' GROUP BY po_no,part_code";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function check_package($where)
    {
        $sql = "SELECT * FROM `tb_cut_summary`
                WHERE 1 $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function update_package($bundle_tracking_no, $date_time)
    {
        $sql = "UPDATE tb_cut_summary 
                SET is_package_ready=1,package_ready_date_time='$date_time' 
                WHERE `bundle_tracking_no` = '$bundle_tracking_no'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function update_package_on_carelabel($bundle_tracking_no, $date_time)
    {
        $sql = "UPDATE tb_care_labels SET is_package_ready=1,package_ready_date_time='$date_time' WHERE `bundle_tracking_no` = '$bundle_tracking_no'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function getFloorLineOutputHourlyReport($start_time, $end_time, $floor_id){
        $sql = "SELECT t1.*, t2.*
                FROM (SELECT * FROM `tb_line` WHERE floor=$floor_id) AS t1
                LEFT JOIN
                (SELECT line_id,SUM(qty) AS line_qty, efficiency 
                 FROM `tb_today_line_output_qty` 
                 WHERE start_time='$start_time' AND end_time='$end_time'
                 GROUP BY line_id) AS t2
                ON t1.id=t2.line_id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getTodayLineOutputSummaryReport($line_id){
        $sql = "SELECT SUM(qty) as count_end_line_qc_pass FROM tb_today_line_output_qty WHERE line_id=$line_id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getUserBrands($user_id)
    {
        $sql = "SELECT * FROM `tb_user` 
                WHERE id = $user_id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function isDefectsInserted($carelabel_tracking_no, $line, $access_points)
    {
        $sql = "SELECT * FROM `tb_defects_tracking` 
                WHERE pc_tracking_no LIKE '%$carelabel_tracking_no%' 
                AND line_id=$line AND qc_point=$access_points
                AND defect_recovered=0";

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

    public function updateDefectStatus($carelabel_tracking_no, $line, $access_points, $access_points_status, $date_time){
        $sql = "UPDATE `tb_defects_tracking` 
                SET defect_recovered=1, defect_recovered_date_time='$date_time' 
                WHERE pc_tracking_no = '$carelabel_tracking_no' 
                AND line_id=$line AND qc_point=$access_points";

        $query = $this->db->query($sql);
        return $query;
    }

    public function updateFinishingDefectStatus($carelabel_tracking_no, $finishing_qc_status, $date_time){
        $sql = "UPDATE `tb_defects_tracking` 
                SET defect_recovered=$finishing_qc_status, defect_recovered_date_time='$date_time' 
                WHERE pc_tracking_no LIKE '%$carelabel_tracking_no%' 
                AND qc_point=5";

        $query = $this->db->query($sql);
        return $query;
    }

    public function getPOsForCareLabelPrinting($tbl)
    {
        $sql = "SELECT * FROM `$tbl`";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getSapPoNo()
    {
        $sql = "SELECT * FROM `tb_po_detail` GROUP BY po_no";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getPOs($sap_no){
        $sql = "SELECT * FROM `tb_po_detail` 
                WHERE po_no LIKE '%$sap_no%' 
                GROUP BY po_no, purchase_order";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getItems($po_no, $sap_no){
        $sql = "SELECT * FROM `tb_po_detail` 
                WHERE purchase_order LIKE '%$po_no%'
                AND po_no LIKE '%$sap_no%'
                GROUP BY po_no, purchase_order, item";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getColors($po_no, $sap_no, $item_no){
        $sql = "SELECT * FROM `tb_po_detail` 
                WHERE purchase_order LIKE '%$po_no%'
                AND po_no LIKE '%$sap_no%'
                AND item LIKE '%$item_no%'
                GROUP BY po_no, purchase_order, item, color";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getQuality($po_no, $sap_no, $item_no, $color){
        $sql = "SELECT * FROM `tb_po_detail` 
                WHERE purchase_order LIKE '%$po_no%'
                AND po_no LIKE '%$sap_no%'
                AND item LIKE '%$item_no%'
                AND color LIKE '%$color%'
                GROUP BY po_no, purchase_order, item, color";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getPoOrderInfo($date){
        $sql = "SELECT A.*, B.count_scanned_pc FROM
                (SELECT po_no, purchase_order, brand, item, style_no, style_name, quality, 
                color, SUM(quantity) as order_quality, ex_factory_date 
                FROM `tb_po_detail` GROUP BY purchase_order, item, style_no, quality, color) as A

                Inner Join

                (SELECT COUNT(pc_tracking_no) as count_scanned_pc, purchase_order, item, 
                quality, style_no, style_name, brand, size, color FROM `tb_care_labels` 
                WHERE sent_to_production=1 and DATE_FORMAT(date_time, '%Y-%m-%d') LIKE '%$date%' GROUP BY purchase_order, item, style_no, quality, color) as B

                ON A.purchase_order=B.purchase_order and A.item=B.item
                and A.style_no=B.style_no and A.quality=B.quality
                and A.color=B.color";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getNonDistributedPOs(){
        $sql = "SELECT purchase_order, item, quality, style_no, style_name, brand, color 
                FROM `tb_care_labels` WHERE line_id=0 GROUP BY purchase_order, item, color";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getPoWiseUndistributedSizes($where){
//        $sql = "SELECT purchase_order, item, quality, style_no, style_name,
//                brand, color, size, COUNT(pc_tracking_no) as qty
//                FROM `tb_care_labels` WHERE line_id=0 AND is_printed=1 $where
//                GROUP BY purchase_order, item, color, size";

        $sql = "Select A.*, B.line_name, B.line_code FROM 
                (SELECT purchase_order, item, quality, style_no, style_name, 
                brand, color, size, COUNT(pc_tracking_no) as qty, line_id 
                FROM `tb_care_labels` WHERE is_printed=1 $where
                GROUP BY purchase_order, item, color, size) as A
                LEFT JOIN 
                `tb_line` as B
                ON A.line_id=B.id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getLinesFloors(){
        $sql = "SELECT t1.*, t2.floor_name, t2.floor_code, 
                t2.floor_description 
                FROM `tb_line` as t1
                INNER JOIN
                `tb_floor` as t2
                ON t1.floor=t2.id
                WHERE t1.status=1";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function remainQtyStatus($where){
        $sql = "SELECT A.*, B.line_name FROM `tb_care_labels` as A
                LEFT JOIN 
                `tb_line` as B
                ON A.line_id=B.id
                WHERE 1 $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function lineCheckofCL($carelabel_tracking_no){
//        $sql = "SELECT * FROM `tb_care_labels`
//                WHERE sent_to_production = 1 and access_points=0
//                and line_id=0 and pc_tracking_no LIKE '$carelabel_tracking_no'";

        $sql = "SELECT t1.*, t2.line_name FROM `tb_care_labels` as t1 
                LEFT  JOIN 
                `tb_line` as t2
                ON  t1.line_id=t2.id
                WHERE t1.pc_tracking_no='$carelabel_tracking_no'";

        $query = $this->db->query($sql)->result_array();
//        $query = $this->db->query($sql)->num_rows();
        return $query;
    }

    public function checkCareLabelInfo($carelabel_tracking_no){
        $sql = "SELECT t1.*, t2.line_name 
                FROM `vt_few_days_po_pcs` as t1 
                LEFT  JOIN 
                `tb_line` as t2
                ON  t1.line_id=t2.id
                WHERE t1.pc_tracking_no='$carelabel_tracking_no'";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function lineCheckofBundle($bundle_tracking_no){
        $sql = "SELECT * FROM `tb_care_labels` 
                WHERE bundle_tracking_no LIKE '%$bundle_tracking_no%'";

        $query = $this->db->query($sql)->result_array();
//        $query = $this->db->query($sql)->num_rows();
        return $query;
    }

    public function getAllInputedPcsLine($where){

        $sql = "SELECT t1.*, t2.line_name, t3.floor_name FROM `tb_care_labels` as t1
                Inner Join
                tb_line as t2 ON t1.line_id=t2.id
                INNER JOIN
                tb_floor as t3 ON t2.floor=t3.id
                WHERE 1 $where";

//        echo '<pre>';
//        print_r($sql);
//        echo '</pre>';

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function viewClDefects($pc_tracking_no, $line_id, $access_point){

        $sql = "SELECT A.*, B.part_name FROM `tb_defects_tracking` as A
                LEFT  JOIN
                `tb_gmt_part` as B
                ON A.defect_part=B.part_code
                WHERE A.pc_tracking_no LIKE '%$pc_tracking_no%' 
                AND A.line_id=$line_id 
                AND A.qc_point=$access_point
                AND A.defect_recovered=0";

//        echo '<pre>';
//        print_r($sql);
//        echo '</pre>';

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getTotalScannedQtyBundle($so_no, $cut_no, $size, $line_no_from)
    {

        $sql1="SELECT sum(cut_qty) AS line_scan_qty FROM `tb_cut_summary`
                 WHERE so_no='$so_no' and cut_no='$cut_no' 
                 and size='$size' AND planned_line_id='$line_no_from'";

        $query = $this->db->query($sql1)->result_array();
        return $query;
    }

    public function changingPlannedLine($so_no, $cut_no, $line_no_from, $line_no_to)
    {
        $sql="UPDATE `tb_cut_summary` 
              SET planned_line_id='$line_no_to'
              WHERE `so_no`='$so_no' 
              AND cut_no='$cut_no' 
              AND planned_line_id='$line_no_from'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function getPoItemBySapNo($sap_no){
        $sql = "SELECT *  FROM `vt_po_detail_cutting_dept` 
               WHERE `po_no` = '$sap_no' 
               GROUP BY po_no, so_no, purchase_order, item 
               ORDER BY po_no, so_no, purchase_order, item";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getSAPCutInfoQty($sap_no, $cut_no){
        $sql = "SELECT t1.*, t2.purchase_order, t2.cut_no, t2.bundle, t2.planned_cut_qty, 
                t2.bundle_range_start, t2.bundle_range_end, t2.total_cut_qty 
                FROM (SELECT *  FROM `tb_po_detail` WHERE `po_no` = '$sap_no' GROUP BY po_no LIMIT 1) as t1
                INNER JOIN
                (SELECT *, sum(cut_qty) as total_cut_qty FROM `tb_cut_summary`  
                WHERE `po_no` = '$sap_no' AND cut_no='$cut_no'  GROUP BY po_no, cut_no) as t2
                ON t1.po_no=t2.po_no";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getCutInfoByPoItem($sap_no, $po_no, $item_no){
        $sql = "SELECT t1.*, t2.purchase_order, t2.cut_no, t2.bundle, t2.planned_cut_qty, t2.bundle_range_start, t2.bundle_range_end
                FROM (SELECT *  FROM `tb_po_detail` WHERE `po_no` LIKE '%$sap_no%' AND `purchase_order` LIKE '%$po_no%' AND `item` LIKE '%$item_no%' GROUP BY po_no, purchase_order, item LIMIT 1) as t1
                INNER JOIN
                (SELECT * FROM `tb_cut_summary`  WHERE `po_no` LIKE '%$sap_no%' AND `purchase_order` LIKE '%$po_no%' AND `item` LIKE '%$item_no%' ORDER BY id DESC LIMIT 1) as t2
                ON t1.po_no=t2.po_no AND t1.purchase_order=t2.purchase_order AND t1.item=t2.item";


        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getAllBundles(){
        $sql = "SELECT * FROM `tb_cut_summary`";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getSizeWisePoItemCutQty($sap_no, $so_no, $purchase_no, $item, $quality, $color){
        $sql = "Select t1.*, t2.po_item_size_wise_cut_qty From 
                (SELECT po_no, so_no, purchase_order, item, quality, color, size, SUM(quantity) as po_item_size_wise_order_qty
                FROM `vt_po_detail_cutting_dept` GROUP BY po_no, so_no, purchase_order, item, quality, color, size) as t1
                
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color, size, SUM(cut_qty) as po_item_size_wise_cut_qty
                FROM `vt_cut_summary_cutting_dept` GROUP BY po_no, so_no, purchase_order, item, quality, color, size) as t2
                
                ON t1.po_no=t2.po_no AND t1.so_no=t2.so_no AND t1.purchase_order=t2.purchase_order 
                AND t1.item=t2.item AND t1.quality=t2.quality AND t1.color=t2.color AND t1.size=t2.size
                
                LEFT JOIN
                `tb_size_serial` as t3
                ON t1.size=t3.size
                
                WHERE t1.po_no='$sap_no' AND t1.so_no='$so_no' AND t1.purchase_order='$purchase_no' AND t1.item='$item'
                AND t1.quality='$quality' AND t1.color='$color'
                ORDER BY t1.purchase_order, t1.item, t3.serial";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getSizeWisePoItemRemainCutQty($sap_no, $purchase_no, $item, $size){
        $sql = "Select t1.*, t2.po_item_size_wise_cut_qty From 
                (SELECT po_no, purchase_order, item, size, SUM(quantity) as po_item_size_wise_order_qty
                FROM `tb_po_detail` GROUP BY po_no, purchase_order, item, size) as t1
                LEFT JOIN
                (SELECT po_no, purchase_order, item, size, SUM(cut_qty) as po_item_size_wise_cut_qty
                FROM `tb_cut_summary` GROUP BY po_no, purchase_order, item, size) as t2
                
                ON t1.po_no=t2.po_no AND t1.purchase_order=t2.purchase_order AND t1.item=t2.item AND t1.size=t2.size
                LEFT JOIN
                `tb_size_serial` as t3
                ON t1.size=t3.size
                WHERE t1.po_no='$sap_no' AND t1.purchase_order='$purchase_no' AND t1.item='$item' AND t1.size='$size'
                ORDER BY t1.purchase_order, t1.item, t3.serial";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getSizeWisePoItemCutQtyBySize($sap_no, $so_no, $purchase_order, $item, $quality, $color, $size){
        $sql = "Select t1.*, t2.cut_qty From 
                (SELECT po_no, so_no, purchase_order, item, quality, color, size, ex_factory_date, SUM(quantity) as order_qty
                FROM `vt_po_detail_cutting_dept` 
                WHERE po_no='$sap_no' AND so_no='$so_no' AND purchase_order='$purchase_order' 
                AND item='$item' AND quality='$quality' AND color='$color' AND size='$size'
                GROUP BY po_no, so_no, purchase_order, item, quality, color, size) as t1
                
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color, size, SUM(cut_qty) as cut_qty
                FROM `vt_cut_summary_cutting_dept` 
                WHERE po_no='$sap_no' AND so_no='$so_no' AND purchase_order='$purchase_order' 
                AND item='$item' AND quality='$quality' AND color='$color' AND size='$size'
                GROUP BY po_no, so_no, purchase_order, item, quality, color, size) as t2
                ON t1.po_no=t2.po_no AND t1.so_no=t2.so_no AND t1.purchase_order=t2.purchase_order 
                AND t1.item=t2.item AND t1.quality=t2.quality AND t1.color=t2.color AND t1.size=t2.size
                
                LEFT JOIN
                `tb_size_serial` as t3
                ON t1.size=t3.size
                
                ORDER BY t1.purchase_order, t1.item, t3.serial";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function logForDeleteCutting($po_no,$cut_no,$cut_qty,$date)
    {
        $sql="INSERT INTO tb_cut_delete_log (po_no,cut_no,cut_qty,`date`)
              VALUES('$po_no','$cut_no','$cut_qty','$date')";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getSizesBySapNo($sap_no){
        $sql = "SELECT t1.* FROM (SELECT *, SUM(quantity) as total_qty FROM `vt_po_detail_cutting_dept`
                WHERE po_no='$sap_no' GROUP by po_no, size) as t1
                LEFT JOIN
                `tb_size_serial` as t2
                ON t1.size=t2.size
                ORDER BY t2.serial";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getLines($where){
        $sql = "SELECT * FROM `tb_line` WHERE status=1 $where ORDER BY (line_code * 1)";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getFloors($where){
        $sql = "SELECT * FROM `tb_floor` WHERE status=1 $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getLineWisePoItem($line_no){
        $sql = "SELECT t1.po_no, t1.purchase_order, t1.item, t1.quality, t1.style_no, t1.style_name, 
                t1.brand, t1.color, t1.line_id, t2.smv, t2.so_no, t2.total_order_qty, t2.ex_factory_date,
                t3.count_input_qty_line, t3.min_line_input_date_time, IFNULL(t4.collar_cuff_bndl_qty, 0) as collar_cuff_bndl_qty, 
                (IFNULL(t5.count_mid_line_qc_pass, 0)+IFNULL(t6.count_mid_line_qc_pass_in_end, 0)) as count_mid_line_qc_pass, 
                IFNULL(t7.count_end_line_qc_pass, 0) as count_end_line_qc_pass, t8.line_name, t9.floor_name, t10.total_cut_qty,
                t11.total_cut_input_qty, t12.collar_bndl_qty, t13.cuff_bndl_qty, t14.min_line_input_date_time, t15.count_other_input_qty_line
                FROM 
                (SELECT * FROM `tb_care_labels` WHERE line_id!=0 and line_id=$line_no GROUP BY line_id, po_no, purchase_order, item) as t1
                LEFT JOIN
                (SELECT *, SUM(quantity) as total_order_qty FROM `tb_po_detail` GROUP BY po_no, purchase_order, item) as t2
                ON t1.po_no=t2.po_no AND t1.purchase_order=t2.purchase_order AND t1.item=t2.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, quality, style_no, style_name, COUNT(id) as count_input_qty_line,
                MIN(line_input_date_time) as min_line_input_date_time
                FROM `tb_care_labels` WHERE line_id !=0 and line_id=$line_no GROUP BY po_no, purchase_order, item) as t3
                ON t1.po_no=t3.po_no AND t1.purchase_order=t3.purchase_order AND t1.item=t3.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, style_no, quality, color, SUM(cut_qty) as collar_cuff_bndl_qty FROM `tb_cut_summary` 
                WHERE is_bundle_collar_cuff_scanned_line=1 GROUP BY po_no, purchase_order, item) as t4
                ON t1.po_no=t4.po_no AND t1.purchase_order=t4.purchase_order AND t1.item=t4.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(id) as count_mid_line_qc_pass
                FROM `tb_care_labels` WHERE line_id !=0 AND line_id=$line_no AND access_points = 3 
                AND access_points_status in (1)
                GROUP BY po_no, purchase_order, item) as t5
                ON t1.po_no=t5.po_no AND t1.purchase_order=t5.purchase_order AND t1.item=t5.item
                LEFT JOIN 
                (SELECT po_no, purchase_order, item, COUNT(id) as count_mid_line_qc_pass_in_end
                FROM `tb_care_labels` WHERE line_id != 0 AND line_id=$line_no AND access_points = 4 
                AND access_points_status in (1, 2, 3, 4)
                GROUP BY po_no, purchase_order, item) as t6
                ON t1.po_no=t6.po_no AND t1.purchase_order=t6.purchase_order AND t1.item=t6.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(pc_tracking_no) as count_end_line_qc_pass
                FROM `tb_care_labels` WHERE line_id != 0 AND line_id=$line_no AND access_points = 4 
                AND access_points_status=4 
                GROUP BY po_no, purchase_order, item) as t7
                ON t1.po_no=t7.po_no AND t1.purchase_order=t7.purchase_order AND t1.item=t7.item
                
                LEFT Join
                tb_line as t8 ON t1.line_id=t8.id
                LEFT JOIN
                tb_floor as t9 ON t8.floor=t9.id
                
                LEFT JOIN 
                (SELECT *, MIN(bundle) as bundle_start, MAX(bundle) as bundle_end, SUM(cut_qty) as total_cut_qty 
                 FROM `tb_cut_summary` GROUP BY po_no, purchase_order, item) as t10
                ON t1.po_no=t10.po_no AND t1.purchase_order=t10.purchase_order AND t1.item=t10.item
                
                LEFT JOIN
                (SELECT *, COUNT(id) as total_cut_input_qty,
                MAX(sent_to_production_date_time) as cut_prod_date_time
                FROM `tb_care_labels` WHERE sent_to_production=1 GROUP BY po_no, purchase_order, item) as t11
                ON t1.po_no=t11.po_no AND t1.purchase_order=t11.purchase_order AND t1.item=t11.item
                
                LEFT JOIN
                (SELECT po_no, purchase_order, item, style_no, quality, color, 
                SUM(cut_qty) as collar_bndl_qty FROM `tb_cut_summary` 
                WHERE is_bundle_collar_scanned_line=1 GROUP BY po_no, purchase_order, item) as t12
                ON t1.po_no=t12.po_no AND t1.purchase_order=t12.purchase_order AND t1.item=t12.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, style_no, quality, color, 
                SUM(cut_qty) as cuff_bndl_qty FROM `tb_cut_summary` 
                WHERE is_bundle_cuff_scanned_line=1 GROUP BY po_no, purchase_order, item) as t13
                ON t1.po_no=t13.po_no AND t1.purchase_order=t13.purchase_order AND t1.item=t13.item
                LEFT JOIN
                (SELECT *, MIN(line_input_date_time) as min_line_input_date_time
                FROM `tb_care_labels` WHERE sent_to_production=1 AND line_input_date_time != '0000-00-00 00:00:00' 
                GROUP BY po_no, purchase_order, item) as t14
                ON t1.po_no=t14.po_no AND t1.purchase_order=t14.purchase_order AND t1.item=t14.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, quality, style_no, style_name, COUNT(id) as count_other_input_qty_line
                FROM `tb_care_labels` WHERE line_id != 0 and line_id != $line_no GROUP BY po_no, purchase_order, item) as t15
                ON t1.po_no=t15.po_no AND t1.purchase_order=t15.purchase_order AND t1.item=t15.item
                                
                ORDER BY t3.min_line_input_date_time";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getProducitonSummaryReport(){
        $sql = "SELECT t1.*, t2.bundle_start, t2.bundle_end, t2.total_cut_qty,
                t3.total_cut_input_qty, t3.max_line_input_date_time, t4.min_care_label, t4.max_care_label, t5.count_input_qty_line,
                t6.collar_cuff_bndl_qty, (IFNULL(t7.count_mid_line_qc_pass, 0)+IFNULL(t8.count_mid_line_qc_pass_in_end, 0)) as count_mid_line_qc_pass,
                t9.count_end_line_qc_pass, t10.count_washing_pass, t11.count_packing_pass
                From (SELECT *, SUM(quantity) as total_order_qty FROM `tb_po_detail`
                GROUP BY po_no, purchase_order, item) as t1
                INNER JOIN
                (SELECT *, MIN(bundle) as bundle_start, MAX(bundle) as bundle_end, SUM(cut_qty) as total_cut_qty
                 FROM `tb_cut_summary` GROUP BY po_no, purchase_order, item) as t2
                ON t1.po_no=t2.po_no AND t1.purchase_order=t2.purchase_order AND t1.item=t2.item
                LEFT JOIN
                (SELECT *, COUNT(id) as total_cut_input_qty, MAX(line_input_date_time) as max_line_input_date_time
                FROM `tb_care_labels` WHERE sent_to_production=1 GROUP BY po_no, purchase_order, item) as t3
                ON t1.po_no=t3.po_no AND t1.purchase_order=t3.purchase_order AND t1.item=t3.item
                LEFT JOIN
                (SELECT *, MIN(CAST(pc_tracking_no AS UNSIGNED)) as min_care_label,
                MAX(CAST(pc_tracking_no AS UNSIGNED)) as max_care_label
                 FROM `tb_care_labels` GROUP BY po_no, purchase_order, item) as t4
                 ON t1.po_no=t4.po_no AND t1.purchase_order=t4.purchase_order AND t1.item=t4.item
                 LEFT JOIN
                 (SELECT po_no, purchase_order, item, quality, style_no, style_name, COUNT(id) as count_input_qty_line
                FROM `tb_care_labels` WHERE line_id !=0 GROUP BY po_no, purchase_order, item) as t5
                ON t1.po_no=t5.po_no AND t1.purchase_order=t5.purchase_order AND t1.item=t5.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, style_no, quality, color, SUM(cut_qty) as collar_cuff_bndl_qty FROM `tb_cut_summary`
                WHERE is_bundle_collar_cuff_scanned_line=1 GROUP BY po_no, purchase_order, item) as t6
                ON t1.po_no=t6.po_no AND t1.purchase_order=t6.purchase_order AND t1.item=t6.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(id) as count_mid_line_qc_pass
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 3
                AND access_points_status in (1)
                GROUP BY po_no, purchase_order, item) as t7
                ON t1.po_no=t7.po_no AND t1.purchase_order=t7.purchase_order AND t1.item=t7.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(id) as count_mid_line_qc_pass_in_end
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 4
                AND access_points_status in (1, 2, 3, 4)
                GROUP BY po_no, purchase_order, item) as t8
                ON t1.po_no=t8.po_no AND t1.purchase_order=t8.purchase_order AND t1.item=t8.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(pc_tracking_no) as count_end_line_qc_pass
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 4
                AND access_points_status=4
                GROUP BY po_no, purchase_order, item) as t9
                ON t1.po_no=t9.po_no AND t1.purchase_order=t9.purchase_order AND t1.item=t9.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(pc_tracking_no) as count_washing_pass
                FROM `tb_care_labels` WHERE washing_status = 1
                GROUP BY po_no, purchase_order, item) as t10
                ON t1.po_no=t10.po_no AND t1.purchase_order=t10.purchase_order AND t1.item=t10.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(pc_tracking_no) as count_packing_pass
                FROM `tb_care_labels` WHERE packing_status = 1
                GROUP BY po_no, purchase_order, item) as t11
                ON t1.po_no=t11.po_no AND t1.purchase_order=t11.purchase_order AND t1.item=t11.item
                ORDER BY t3.max_line_input_date_time DESC";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getCuttingCollarCuffReport(){
        $sql = "SELECT t1.*, t2.bundle_start, t2.bundle_end, t2.total_cut_qty, t2.max_cutting_collar_cuff_bundle_last_action_date_time,
                t3.total_cut_input_qty, t3.max_line_input_date_time, t4.min_care_label, t4.max_care_label, t5.count_input_qty_line,
                t6.collar_cuff_bndl_qty, (IFNULL(t7.count_mid_line_qc_pass, 0)+IFNULL(t8.count_mid_line_qc_pass_in_end, 0)) as count_mid_line_qc_pass,
                t9.count_end_line_qc_pass, t10.count_washing_pass, t11.count_packing_pass,
                t12.count_cutting_collar_bundle_qty, t13.count_cutting_cuff_bundle_qty
                
                From (SELECT *, SUM(quantity) as total_order_qty FROM `tb_po_detail`
                GROUP BY po_no, purchase_order, item, quality, color) as t1
                
                INNER JOIN
                (SELECT *, MIN(bundle) as bundle_start, 
                MAX(cutting_collar_cuff_bundle_last_action_date_time) as max_cutting_collar_cuff_bundle_last_action_date_time,
                MAX(bundle) as bundle_end, SUM(cut_qty) as total_cut_qty
                 FROM `tb_cut_summary` GROUP BY po_no, purchase_order, item, quality, color) as t2
                ON t1.po_no=t2.po_no AND t1.purchase_order=t2.purchase_order AND t1.item=t2.item
                AND t1.quality=t2.quality AND t1.color=t2.color
                
                LEFT JOIN
                (SELECT *, COUNT(id) as total_cut_input_qty, MAX(line_input_date_time) as max_line_input_date_time
                FROM `tb_care_labels` WHERE sent_to_production=1 
                GROUP BY po_no, purchase_order, item, quality, color) as t3
                ON t1.po_no=t3.po_no AND t1.purchase_order=t3.purchase_order AND t1.item=t3.item
                AND t1.quality=t3.quality AND t1.color=t3.color
                
                LEFT JOIN
                (SELECT *, MIN(CAST(pc_tracking_no AS UNSIGNED)) as min_care_label,
                MAX(CAST(pc_tracking_no AS UNSIGNED)) as max_care_label
                 FROM `tb_care_labels` GROUP BY po_no, purchase_order, item, quality, color) as t4
                 ON t1.po_no=t4.po_no AND t1.purchase_order=t4.purchase_order AND t1.item=t4.item
                 AND t1.quality=t4.quality AND t1.color=t4.color
                 
                 LEFT JOIN
                 (SELECT po_no, purchase_order, item, quality, style_no, style_name, 
                 color, COUNT(id) as count_input_qty_line
                FROM `tb_care_labels` WHERE line_id !=0 GROUP BY po_no, purchase_order, item, quality, color) as t5
                ON t1.po_no=t5.po_no AND t1.purchase_order=t5.purchase_order AND t1.item=t5.item
                AND t1.quality=t5.quality AND t1.color=t5.color
                
                LEFT JOIN
                (SELECT po_no, purchase_order, item, style_no, quality, color, SUM(cut_qty) as collar_cuff_bndl_qty 
                FROM `tb_cut_summary`
                WHERE is_bundle_collar_cuff_scanned_line=1 GROUP BY po_no, purchase_order, item, quality, color) as t6
                ON t1.po_no=t6.po_no AND t1.purchase_order=t6.purchase_order AND t1.item=t6.item
                AND t1.quality=t6.quality AND t1.color=t6.color
                
                LEFT JOIN
                (SELECT po_no, purchase_order, item, quality, color, COUNT(id) as count_mid_line_qc_pass
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 3
                AND access_points_status in (1)
                GROUP BY po_no, purchase_order, item, quality, color) as t7
                ON t1.po_no=t7.po_no AND t1.purchase_order=t7.purchase_order AND t1.item=t7.item
                AND t1.quality=t7.quality AND t1.color=t7.color
                
                LEFT JOIN
                (SELECT po_no, purchase_order, item, quality, color, COUNT(id) as count_mid_line_qc_pass_in_end
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 4
                AND access_points_status in (1, 2, 3, 4)
                GROUP BY po_no, purchase_order, item, quality, color) as t8
                ON t1.po_no=t8.po_no AND t1.purchase_order=t8.purchase_order AND t1.item=t8.item
                AND t1.quality=t8.quality AND t1.color=t8.color
                
                LEFT JOIN
                (SELECT po_no, purchase_order, item, quality, color, COUNT(pc_tracking_no) as count_end_line_qc_pass
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 4
                AND access_points_status=4
                GROUP BY po_no, purchase_order, item, quality, color) as t9
                ON t1.po_no=t9.po_no AND t1.purchase_order=t9.purchase_order AND t1.item=t9.item
                AND t1.quality=t9.quality AND t1.color=t9.color
                
                LEFT JOIN
                (SELECT po_no, purchase_order, item, quality, color, COUNT(pc_tracking_no) as count_washing_pass
                FROM `tb_care_labels` WHERE washing_status = 1
                GROUP BY po_no, purchase_order, item, quality, color) as t10
                ON t1.po_no=t10.po_no AND t1.purchase_order=t10.purchase_order AND t1.item=t10.item
                AND t1.quality=t10.quality AND t1.color=t10.color
                
                LEFT JOIN
                (SELECT po_no, purchase_order, item, quality, color, COUNT(pc_tracking_no) as count_packing_pass
                FROM `tb_care_labels` WHERE packing_status = 1
                GROUP BY po_no, purchase_order, item, quality, color) as t11
                ON t1.po_no=t11.po_no AND t1.purchase_order=t11.purchase_order AND t1.item=t11.item
                AND t1.quality=t11.quality AND t1.color=t11.color
                
                LEFT JOIN
                (SELECT po_no, purchase_order, item, quality, color, SUM(cut_qty) as count_cutting_collar_bundle_qty
                FROM `tb_cut_summary` WHERE is_cutting_collar_bundle_ready = 1
                GROUP BY po_no, purchase_order, item, quality, color) as t12
                ON t1.po_no=t12.po_no AND t1.purchase_order=t12.purchase_order AND t1.item=t12.item
                AND t1.quality=t12.quality AND t1.color=t12.color
                
                LEFT JOIN
                (SELECT po_no, purchase_order, item, quality, color, SUM(cut_qty) as count_cutting_cuff_bundle_qty
                FROM `tb_cut_summary` WHERE is_cutting_cuff_bundle_ready = 1
                GROUP BY po_no, purchase_order, item, quality, color) as t13
                ON t1.po_no=t13.po_no AND t1.purchase_order=t13.purchase_order AND t1.item=t13.item
                AND t1.quality=t13.quality AND t1.color=t13.color
                
                ORDER BY t2.max_cutting_collar_cuff_bundle_last_action_date_time DESC";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getRemainingPart($where){
        $sql = "Select *,sum(cut_qty) as total_qty From `tb_cut_summary` 
                WHERE 1 $where 
                GROUP BY size,cut_no, bundle
                ORDER BY cut_no, bundle";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getCuttingCollarCuffReportViewTable($where, $where1){
//        $sql = "SELECT t1.po_no, t1.so_no, t1.purchase_order, t1.item, t1.quality,
//                t1.color, t1. brand, t1.style_no, t1.style_name,t1.bundle_start,t1.bundle_end, t1.total_cut_qty,
//                t2.count_cutting_collar_bundle_qty, t3.count_cutting_cuff_bundle_qty,
//                t4.ex_factory_date, t4.total_order_qty, t5.min_care_label, t5.max_care_label, t6.count_end_line_qc_pass
//                FROM
//                `vt_cut`  as t1
//                LEFT JOIN
//                `vt_cut_collar_bundle_scan` as t2
//                ON t1.po_no=t2.po_no AND t1.so_no=t2.so_no AND t1.purchase_order=t2.purchase_order
//                AND t1.item=t2.item AND t1.quality=t2.quality AND t1.color=t2.color
//                LEFT JOIN
//                `vt_cut_cuff_bundle_scan` as t3
//                ON t1.po_no=t3.po_no AND t1.so_no=t3.so_no AND t1.purchase_order=t3.purchase_order
//                AND t1.item=t3.item AND t1.quality=t3.quality AND t1.color=t3.color
//                LEFT JOIN
//                `vt_po_summary` as t4
//                ON t1.po_no=t4.po_no AND t1.so_no=t4.so_no AND t1.purchase_order=t4.purchase_order
//                AND t1.item=t4.item AND t1.quality=t4.quality AND t1.color=t4.color
//                LEFT JOIN
//                `vt_cut_pass` as t5
//                ON t1.po_no=t5.po_no AND t1.so_no=t5.so_no AND t1.purchase_order=t5.purchase_order
//                AND t1.item=t5.item AND t1.quality=t5.quality AND t1.color=t5.color
//                LEFT JOIN
//                `vt_end_line_pass` as t6
//                ON t1.po_no=t6.po_no AND t1.so_no=t6.so_no AND t1.purchase_order=t6.purchase_order
//                AND t1.item=t6.item AND t1.quality=t6.quality AND t1.color=t6.color
//
//                WHERE (IFNULL(t1.total_cut_qty, 0) - IFNULL(t6.count_end_line_qc_pass, 0)) > 0
//
//                ORDER BY t1.max_cutting_collar_cuff_bundle_last_action_date_time DESC";

//        $sql="SELECT t1.*, t2.total_order_qty ,t3.total_cut_qty,t3.bundle_start,
//              t3.bundle_end,t3.cutting_collar_bundle_ready_date_time, t4.count_cutting_ready_package_qty
//                FROM (
//                SELECT po_no,so_no,item,quality,color,purchase_order,ex_factory_date, is_package_ready,
//                brand,style_no,style_name, planned_line_id,
//                SUM(CASE WHEN is_cutting_collar_bundle_ready=1
//                THEN cut_qty
//                ELSE 0 end) AS count_cutting_collar_bundle_qty,
//
//                SUM(CASE WHEN is_cutting_back_bundle_ready=1
//                THEN cut_qty
//                ELSE 0 end) AS count_cutting_back_bundle_qty,
//
//                SUM(CASE WHEN is_cutting_yoke_bundle_ready=1
//                THEN cut_qty
//                ELSE 0 end) AS count_cutting_yoke_bundle_qty,
//
//                SUM(CASE WHEN is_cutting_sleeve_bundle_ready=1
//                THEN cut_qty
//                ELSE 0 end) AS count_cutting_sleeve_bundle_qty,
//
//                SUM(CASE WHEN is_cutting_sleeve_plkt_bundle_ready=1
//                THEN cut_qty
//                ELSE 0 end) AS count_cutting_sleeve_plkt_bundle_qty,
//
//                SUM(CASE WHEN is_cutting_pocket_bundle_ready=1
//                THEN cut_qty
//                ELSE 0 end) AS count_cutting_pocket_bundle_qty,
//
//                SUM(CASE WHEN is_cutting_cuff_bundle_ready=1
//                THEN cut_qty
//                ELSE 0 end) AS count_cutting_cuff_bundle_qty
//
//                FROM tb_cut_summary WHERE 1 $where GROUP BY po_no,so_no,item,quality,color,purchase_order
//                )  as t1
//
//                LEFT JOIN
//                vt_po_summary as t2
//                ON t1.so_no=t2.so_no AND t1.po_no=t2.po_no AND t1.purchase_order=t2.purchase_order
//                AND t1.item=t2.item AND t1.quality=t2.quality AND t1.color=t2.color
//
//                LEFT JOIN
//                vt_cut as t3
//                ON t1.so_no=t3.so_no AND t1.po_no=t3.po_no AND t1.purchase_order=t3.purchase_order
//                AND t1.item=t3.item AND t1.quality=t3.quality AND t1.color=t3.color
//
//                LEFT JOIN
//                (
//                SELECT po_no,so_no,item,quality,color,purchase_order,ex_factory_date,brand,style_no,style_name, planned_line_id,
//                SUM(CASE WHEN is_package_ready=1
//                THEN cut_qty
//                ELSE 0 end) AS count_cutting_ready_package_qty
//                FROM tb_cut_summary
//                GROUP BY po_no,so_no,item,quality,color,purchase_order
//                )  as t4
//                ON t1.so_no=t4.so_no AND t1.po_no=t4.po_no AND t1.purchase_order=t4.purchase_order
//                AND t1.item=t4.item AND t1.quality=t4.quality AND t1.color=t4.color
//
//                WHERE 1 $where1
//
//                ORDER  BY t3.cutting_collar_bundle_ready_date_time";


        $sql="SELECT t2.*, t3.total_order_qty, t3.total_cut_qty, t3.total_cut_input_qty,
              t3.count_cut_package_ready_qty, t1.count_cutting_ready_package_qty
              
                FROM 
                (SELECT so_no, po_no, purchase_order, item, quality, color, style_no, style_name, brand,
                SUM(CASE WHEN is_package_ready=1
                THEN cut_qty
                ELSE 0 end) AS count_cutting_ready_package_qty
                
                FROM `tb_cut_summary` WHERE 1 $where GROUP BY so_no) AS t1
                
                LEFT JOIN
                (
                SELECT po_no,so_no,item,quality,color,purchase_order,ex_factory_date, is_package_ready,
                brand,style_no,style_name, planned_line_id,
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
                ) AS t2
                ON t1.so_no=t2.so_no
                
                LEFT JOIN
                tb_production_summary AS t3
                ON t1.so_no=t3.so_no
                
                WHERE t3.balance > 0";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getProducitonSummaryReportCut($condition){
        $sql = "SELECT t1.*, t2.bundle_start, t2.bundle_end, t2.total_cut_qty, t3.cut_prod_date_time,
                t3.total_cut_input_qty, t4.min_care_label, t4.max_care_label, t5.count_input_qty_line,
                t6.collar_cuff_bndl_qty, (IFNULL(t7.count_mid_line_qc_pass, 0)+IFNULL(t8.count_mid_line_qc_pass_in_end, 0)) as count_mid_line_qc_pass,
                t9.count_end_line_qc_pass, t10.count_washing_pass, t11.count_packing_pass
                From (SELECT *, SUM(quantity) as total_order_qty FROM `tb_po_detail`
                GROUP BY po_no, purchase_order, item) as t1
                INNER JOIN
                (SELECT *, MIN(bundle) as bundle_start, MAX(bundle) as bundle_end, SUM(cut_qty) as total_cut_qty
                 FROM `tb_cut_summary` GROUP BY po_no, purchase_order, item) as t2
                ON t1.po_no=t2.po_no AND t1.purchase_order=t2.purchase_order AND t1.item=t2.item
                LEFT JOIN
                (SELECT *, COUNT(id) as total_cut_input_qty,
                MAX(sent_to_production_date_time) as cut_prod_date_time
                FROM `tb_care_labels` WHERE sent_to_production=1 GROUP BY po_no, purchase_order, item) as t3
                ON t1.po_no=t3.po_no AND t1.purchase_order=t3.purchase_order AND t1.item=t3.item
                LEFT JOIN
                (SELECT *, MIN(CAST(pc_tracking_no AS UNSIGNED)) as min_care_label,
                MAX(CAST(pc_tracking_no AS UNSIGNED)) as max_care_label
                 FROM `tb_care_labels` GROUP BY po_no, purchase_order, item) as t4
                 ON t1.po_no=t4.po_no AND t1.purchase_order=t4.purchase_order AND t1.item=t4.item
                 LEFT JOIN
                 (SELECT po_no, purchase_order, item, quality, style_no, style_name, COUNT(id) as count_input_qty_line
                FROM `tb_care_labels` WHERE line_id !=0 GROUP BY po_no, purchase_order, item) as t5
                ON t1.po_no=t5.po_no AND t1.purchase_order=t5.purchase_order AND t1.item=t5.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, style_no, quality, color, SUM(cut_qty) as collar_cuff_bndl_qty FROM `tb_cut_summary`
                WHERE is_bundle_collar_cuff_scanned_line=1 GROUP BY po_no, purchase_order, item) as t6
                ON t1.po_no=t6.po_no AND t1.purchase_order=t6.purchase_order AND t1.item=t6.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(id) as count_mid_line_qc_pass
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 3
                AND access_points_status in (1)
                GROUP BY po_no, purchase_order, item) as t7
                ON t1.po_no=t7.po_no AND t1.purchase_order=t7.purchase_order AND t1.item=t7.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(id) as count_mid_line_qc_pass_in_end
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 4
                AND access_points_status in (1, 2, 3, 4)
                GROUP BY po_no, purchase_order, item) as t8
                ON t1.po_no=t8.po_no AND t1.purchase_order=t8.purchase_order AND t1.item=t8.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(pc_tracking_no) as count_end_line_qc_pass
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 4
                AND access_points_status=4
                GROUP BY po_no, purchase_order, item) as t9
                ON t1.po_no=t9.po_no AND t1.purchase_order=t9.purchase_order AND t1.item=t9.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(pc_tracking_no) as count_washing_pass
                FROM `tb_care_labels` WHERE washing_status = 1
                GROUP BY po_no, purchase_order, item) as t10
                ON t1.po_no=t10.po_no AND t1.purchase_order=t10.purchase_order AND t1.item=t10.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(pc_tracking_no) as count_packing_pass
                FROM `tb_care_labels` WHERE packing_status = 1
                GROUP BY po_no, purchase_order, item) as t11
                ON t1.po_no=t11.po_no AND t1.purchase_order=t11.purchase_order AND t1.item=t11.item
                $condition";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getProducitonSummaryReportWash($condition){
        $sql = "SELECT t1.*, t2.bundle_start, t2.bundle_end, t2.total_cut_qty, t3.cut_prod_date_time,
                t3.total_cut_input_qty, t4.min_care_label, t4.max_care_label, t5.count_input_qty_line,
                t6.collar_cuff_bndl_qty, (IFNULL(t7.count_mid_line_qc_pass, 0)+IFNULL(t8.count_mid_line_qc_pass_in_end, 0)) as count_mid_line_qc_pass,
                t9.count_end_line_qc_pass, t10.count_washing_pass, t10.max_washing_date_time, 
                t11.count_packing_pass, t12.count_wash_going_qty, t12.max_going_wash_scan_date_time
                
                From (SELECT *, SUM(quantity) as total_order_qty FROM `tb_po_detail` 
                WHERE wash_gmt=1
                GROUP BY po_no, purchase_order, item) as t1
                INNER JOIN
                (SELECT *, MIN(bundle) as bundle_start, MAX(bundle) as bundle_end, SUM(cut_qty) as total_cut_qty
                 FROM `tb_cut_summary` GROUP BY po_no, purchase_order, item) as t2
                ON t1.po_no=t2.po_no AND t1.purchase_order=t2.purchase_order AND t1.item=t2.item
                LEFT JOIN
                (SELECT *, COUNT(id) as total_cut_input_qty,
                MAX(sent_to_production_date_time) as cut_prod_date_time
                FROM `tb_care_labels` WHERE sent_to_production=1 GROUP BY po_no, purchase_order, item) as t3
                ON t1.po_no=t3.po_no AND t1.purchase_order=t3.purchase_order AND t1.item=t3.item
                LEFT JOIN
                (SELECT *, MIN(CAST(pc_tracking_no AS UNSIGNED)) as min_care_label,
                MAX(CAST(pc_tracking_no AS UNSIGNED)) as max_care_label
                 FROM `tb_care_labels` GROUP BY po_no, purchase_order, item) as t4
                 ON t1.po_no=t4.po_no AND t1.purchase_order=t4.purchase_order AND t1.item=t4.item
                 LEFT JOIN
                 (SELECT po_no, purchase_order, item, quality, style_no, style_name, COUNT(id) as count_input_qty_line
                FROM `tb_care_labels` WHERE line_id !=0 GROUP BY po_no, purchase_order, item) as t5
                ON t1.po_no=t5.po_no AND t1.purchase_order=t5.purchase_order AND t1.item=t5.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, style_no, quality, color, SUM(cut_qty) as collar_cuff_bndl_qty FROM `tb_cut_summary`
                WHERE is_bundle_collar_cuff_scanned_line=1 GROUP BY po_no, purchase_order, item) as t6
                ON t1.po_no=t6.po_no AND t1.purchase_order=t6.purchase_order AND t1.item=t6.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(id) as count_mid_line_qc_pass
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 3
                AND access_points_status in (1)
                GROUP BY po_no, purchase_order, item) as t7
                ON t1.po_no=t7.po_no AND t1.purchase_order=t7.purchase_order AND t1.item=t7.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(id) as count_mid_line_qc_pass_in_end
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 4
                AND access_points_status in (1, 2, 3, 4)
                GROUP BY po_no, purchase_order, item) as t8
                ON t1.po_no=t8.po_no AND t1.purchase_order=t8.purchase_order AND t1.item=t8.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(pc_tracking_no) as count_end_line_qc_pass
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 4
                AND access_points_status=4
                GROUP BY po_no, purchase_order, item) as t9
                ON t1.po_no=t9.po_no AND t1.purchase_order=t9.purchase_order AND t1.item=t9.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(pc_tracking_no) as count_washing_pass,
                MAX(washing_date_time) as max_washing_date_time
                FROM `tb_care_labels` WHERE washing_status = 1
                GROUP BY po_no, purchase_order, item) as t10
                ON t1.po_no=t10.po_no AND t1.purchase_order=t10.purchase_order AND t1.item=t10.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(pc_tracking_no) as count_packing_pass
                FROM `tb_care_labels` WHERE packing_status = 1
                GROUP BY po_no, purchase_order, item) as t11
                ON t1.po_no=t11.po_no AND t1.purchase_order=t11.purchase_order AND t1.item=t11.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(pc_tracking_no) as count_wash_going_qty,
                MAX(going_wash_scan_date_time) as max_going_wash_scan_date_time
                FROM `tb_care_labels` WHERE is_going_wash = 1
                GROUP BY po_no, purchase_order, item) as t12
                ON t1.po_no=t12.po_no AND t1.purchase_order=t12.purchase_order AND t1.item=t12.item
                
                $condition";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getProducitonSummaryReportWashViewTable($condition){
        $sql = "SELECT t1.*, t2.brand, t2.total_order_qty, t2.ex_factory_date, 
                t3.count_washing_qty as count_wash_going_qty, t4.count_manual_close_qty
                FROM `vt_wash_return` as t1
                
                LEFT JOIN
                (SELECT *, SUM(quantity) as total_order_qty FROM `vt_po_detail` 
                GROUP BY po_no, so_no, purchase_order, item, quality, color) as t2
                ON t1.po_no=t2.po_no AND t1.so_no=t2.so_no AND t1.purchase_order=t2.purchase_order 
                AND t1.item=t2.item AND t1.quality=t2.quality AND t1.color=t2.color
                
                LEFT JOIN
                `vt_wash_send` as t3
                ON t1.po_no=t3.po_no AND t1.so_no=t3.so_no AND t1.purchase_order=t3.purchase_order 
                AND t1.item=t3.item AND t1.quality=t3.quality AND t1.color=t3.color
                
                LEFT JOIN 
                tb_production_summary AS t4
                ON t1.so_no=t4.so_no
                
                $condition";
        

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getProducitonSummaryReportWashGoing($condition){
        $sql = "SELECT t1.*, t2.bundle_start, t2.bundle_end, t2.total_cut_qty, t3.cut_prod_date_time,
                t3.total_cut_input_qty, t4.min_care_label, t4.max_care_label, t5.count_input_qty_line,
                t6.collar_cuff_bndl_qty, (IFNULL(t7.count_mid_line_qc_pass, 0)+IFNULL(t8.count_mid_line_qc_pass_in_end, 0)) as count_mid_line_qc_pass,
                t9.count_end_line_qc_pass, t10.count_washing_qty, t10.max_going_wash_scan_date_time
                
                From (SELECT *, SUM(quantity) as total_order_qty FROM `tb_po_detail`
                WHERE wash_gmt=1
                GROUP BY po_no, purchase_order, item) as t1
                INNER JOIN
                (SELECT *, MIN(bundle) as bundle_start, MAX(bundle) as bundle_end, SUM(cut_qty) as total_cut_qty
                 FROM `tb_cut_summary` GROUP BY po_no, purchase_order, item) as t2
                ON t1.po_no=t2.po_no AND t1.purchase_order=t2.purchase_order AND t1.item=t2.item
                LEFT JOIN
                (SELECT *, COUNT(id) as total_cut_input_qty,
                MAX(sent_to_production_date_time) as cut_prod_date_time
                FROM `tb_care_labels` WHERE sent_to_production=1 GROUP BY po_no, purchase_order, item) as t3
                ON t1.po_no=t3.po_no AND t1.purchase_order=t3.purchase_order AND t1.item=t3.item
                LEFT JOIN
                (SELECT *, MIN(CAST(pc_tracking_no AS UNSIGNED)) as min_care_label,
                MAX(CAST(pc_tracking_no AS UNSIGNED)) as max_care_label
                 FROM `tb_care_labels` GROUP BY po_no, purchase_order, item) as t4
                 ON t1.po_no=t4.po_no AND t1.purchase_order=t4.purchase_order AND t1.item=t4.item
                 LEFT JOIN
                 (SELECT po_no, purchase_order, item, quality, style_no, style_name, COUNT(id) as count_input_qty_line
                FROM `tb_care_labels` WHERE line_id !=0 GROUP BY po_no, purchase_order, item) as t5
                ON t1.po_no=t5.po_no AND t1.purchase_order=t5.purchase_order AND t1.item=t5.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, style_no, quality, color, SUM(cut_qty) as collar_cuff_bndl_qty FROM `tb_cut_summary`
                WHERE is_bundle_collar_cuff_scanned_line=1 GROUP BY po_no, purchase_order, item) as t6
                ON t1.po_no=t6.po_no AND t1.purchase_order=t6.purchase_order AND t1.item=t6.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(id) as count_mid_line_qc_pass
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 3
                AND access_points_status in (1)
                GROUP BY po_no, purchase_order, item) as t7
                ON t1.po_no=t7.po_no AND t1.purchase_order=t7.purchase_order AND t1.item=t7.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(id) as count_mid_line_qc_pass_in_end
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 4
                AND access_points_status in (1, 2, 3, 4)
                GROUP BY po_no, purchase_order, item) as t8
                ON t1.po_no=t8.po_no AND t1.purchase_order=t8.purchase_order AND t1.item=t8.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(pc_tracking_no) as count_end_line_qc_pass
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 4
                AND access_points_status=4
                GROUP BY po_no, purchase_order, item) as t9
                ON t1.po_no=t9.po_no AND t1.purchase_order=t9.purchase_order AND t1.item=t9.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(pc_tracking_no) as count_washing_qty,
                MAX(going_wash_scan_date_time) as max_going_wash_scan_date_time
                FROM `tb_care_labels` WHERE is_going_wash = 1
                GROUP BY po_no, purchase_order, item) as t10
                ON t1.po_no=t10.po_no AND t1.purchase_order=t10.purchase_order AND t1.item=t10.item
                
                $condition";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getProducitonSummaryReportWashGoingViewTable($condition){
//        $sql = "SELECT t1.*, t2.total_order_qty, t2.ex_factory_date, t3.count_end_line_qc_pass
//                FROM `vt_wash_send` as t1
//
//                LEFT JOIN
//                (SELECT *, SUM(quantity) as total_order_qty FROM `vt_po_detail`
//                GROUP BY po_no, so_no, purchase_order, item, quality, color) as t2
//                ON t1.po_no=t2.po_no AND t1.so_no=t2.so_no AND t1.purchase_order=t2.purchase_order
//                AND t1.item=t2.item AND t1.quality=t2.quality AND t1.color=t2.color
//
//                LEFT JOIN
//                `vt_end_line_pass` as t3
//                ON t1.po_no=t3.po_no AND t1.so_no=t3.so_no AND t1.purchase_order=t3.purchase_order
//                AND t1.item=t3.item AND t1.quality=t3.quality AND t1.color=t3.color
//
//                $condition";


        $sql = "SELECT t1.*, t2.total_order_qty, t2.ex_factory_date, t3.count_end_line_qc_pass, t4.count_manual_close_qty
                FROM `vt_wash_send` as t1
                
                LEFT JOIN
                (SELECT *, SUM(quantity) as total_order_qty FROM `vt_po_detail` 
                GROUP BY po_no, so_no, purchase_order, item, quality, color) as t2
                ON t1.po_no=t2.po_no AND t1.so_no=t2.so_no AND t1.purchase_order=t2.purchase_order 
                AND t1.item=t2.item AND t1.quality=t2.quality AND t1.color=t2.color
                
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color, 
                SUM(count_end_line_qc_pass) as count_end_line_qc_pass From `vt_end_line_pass` 
                GROUP BY po_no, so_no, purchase_order, item, quality, color) as t3
                ON t1.po_no=t3.po_no AND t1.so_no=t3.so_no AND t1.purchase_order=t3.purchase_order 
                AND t1.item=t3.item AND t1.quality=t3.quality AND t1.color=t3.color
                
                LEFT JOIN 
                tb_production_summary AS t4
                ON t1.so_no=t4.so_no
                                
                $condition";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getPackingReportViewTable( $condition_1,$condition){
//        $sql = "SELECT t1.*, t2.total_order_qty, t2.ex_factory_date, t2.wash_gmt, t3.count_end_line_qc_pass,
//                t4.count_washing_pass, t10.total_cut_input_qty
//
//                FROM
//
//                (SELECT * FROM `vt_packing` WHERE 1 $condition_1) as t1
//
//                LEFT JOIN
//                (SELECT *, SUM(quantity) as total_order_qty FROM `vt_po_detail`
//                GROUP BY po_no, so_no, purchase_order, item, quality, color) as t2
//                ON t1.po_no=t2.po_no AND t1.so_no=t2.so_no AND t1.purchase_order=t2.purchase_order
//                AND t1.item=t2.item AND t1.quality=t2.quality AND t1.color=t2.color
//
//                LEFT JOIN
//                (SELECT po_no, so_no, purchase_order, item, quality, color,
//                SUM(count_end_line_qc_pass) as count_end_line_qc_pass
//                FROM `vt_end_line_pass`
//                GROUP BY po_no, so_no, purchase_order, item, quality, color) as t3
//                ON t1.po_no=t3.po_no AND t1.so_no=t3.so_no AND t1.purchase_order=t3.purchase_order
//                AND t1.item=t3.item AND t1.quality=t3.quality AND t1.color=t3.color
//
//                LEFT JOIN
//                `vt_wash_return` as t4
//                ON t1.po_no=t4.po_no AND t1.so_no=t4.so_no AND t1.purchase_order=t4.purchase_order
//                AND t1.item=t4.item AND t1.quality=t4.quality AND t1.color=t4.color
//
//                LEFT JOIN
//                `vt_cut_pass` as t10
//                ON t1.po_no=t10.po_no AND t1.so_no=t10.so_no AND t1.purchase_order=t10.purchase_order
//                AND t1.item=t10.item AND t1.quality=t10.quality AND t1.color=t10.color
//
//                WHERE (t10.total_cut_input_qty - t1.count_packing_pass) > 0
//
//                $condition";

        $sql1="SELECT t1.*, t2.total_order_qty FROM (SELECT po_no,so_no,item,quality,color,
               style_name,style_no,purchase_order,brand,ex_factory_date,packing_date_time,
               COUNT(packing_status) as count_packing_pass,  
               COUNT(washing_status) as count_washing_pass, 
               COUNT(sent_to_production_date_time) as total_cut_input_qty,
               COUNT(end_line_qc_date_time) as count_end_line_qc_pass,
               COUNT(manually_closed) as count_manual_close
            FROM (
              SELECT
                so_no,po_no,item,quality,color,purchase_order,brand,ex_factory_date,packing_date_time,style_name,style_no,
               CASE WHEN access_points=4 AND access_points_status=4 THEN end_line_qc_date_time END end_line_qc_date_time,    
               CASE WHEN sent_to_production=1 THEN sent_to_production_date_time END sent_to_production_date_time,
                CASE WHEN packing_status = 1 THEN packing_status END packing_status,
                CASE WHEN washing_status = 1 THEN washing_status END washing_status,
                CASE WHEN manually_closed = 1 THEN manually_closed END manually_closed
              FROM vt_few_days_po_pcs    
            ) vt_few_days_po_pcs WHERE 1 $condition_1  GROUP BY so_no,po_no,item,quality,color,purchase_order) as t1
            LEFT JOIN
            vt_po_summary as t2
            ON t1.so_no=t2.so_no AND t1.po_no=t2.po_no AND t1.purchase_order=t2.purchase_order AND t1.quality=t2.quality AND t1.color=t2.color
              WHERE  (t1.total_cut_input_qty - t1.count_packing_pass) > 0
            ORDER by packing_date_time DESC";

        $query = $this->db->query($sql1)->result_array();
        return $query;
    }

    public function getFinishingAlterReport($where){
        $sql="SELECT so_no, finishing_floor_id, purchase_order, item, quality, color, style_no, style_name,
               brand, ex_factory_date, COUNT(id) as total_finishing_alter_qty
               FROM `vt_few_days_po_pcs`
               WHERE finishing_qc_status=2
               $where
               GROUP BY so_no";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getFinishingAlterLineReport($where){
        $sql="SELECT so_no, line_id, purchase_order, item, quality, color, style_no, style_name,
               brand, ex_factory_date, COUNT(id) as total_finishing_alter_qty
               FROM `vt_running_po_pcs`
               WHERE finishing_qc_status=2
               $where
               GROUP BY so_no";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getRemainingFinishingAlterPcs($where){
        $sql1="SELECT t1.*, t2.line_code
               FROM (SELECT pc_tracking_no, so_no, purchase_order, item, size, 
               quality, color, style_no, style_name, ex_factory_date, line_id
               FROM `vt_running_po_pcs` 
               WHERE finishing_qc_status=2 $where) AS t1
               LEFT JOIN
               tb_line AS t2
               ON t1.line_id=t2.id";

        $query = $this->db->query($sql1)->result_array();
        return $query;
    }

//    public function getProducitonSummaryReportFinishViewTable($condition, $condition_1){
    public function getProducitonSummaryReportFinishViewTable($condition_1, $condition){
        $sql = "SELECT t1.*, t2.total_order_qty, t2.ex_factory_date, t2.wash_gmt, t3.count_end_line_qc_pass,
                t4.count_washing_pass, t5.count_carton_pass, t6.count_wh_buyer, t7.count_wh_factory, 
                t8.count_wh_trash, t9.count_wh_others, t10.total_cut_input_qty, t11.count_wh_prod_sample

                FROM `vt_packing` as t1
                
                LEFT JOIN
                (SELECT *, SUM(quantity) as total_order_qty FROM `vt_po_detail`
                GROUP BY po_no, so_no, purchase_order, item, quality, color) as t2
                ON t1.po_no=t2.po_no AND t1.so_no=t2.so_no AND t1.purchase_order=t2.purchase_order 
                AND t1.item=t2.item AND t1.quality=t2.quality AND t1.color=t2.color
                
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color, 
                SUM(count_end_line_qc_pass) as count_end_line_qc_pass 
                FROM `vt_end_line_pass` 
                GROUP BY po_no, so_no, purchase_order, item, quality, color) as t3
                ON t1.po_no=t3.po_no AND t1.so_no=t3.so_no AND t1.purchase_order=t3.purchase_order 
                AND t1.item=t3.item AND t1.quality=t3.quality AND t1.color=t3.color
                
                LEFT JOIN
                `vt_wash_return` as t4
                ON t1.po_no=t4.po_no AND t1.so_no=t4.so_no AND t1.purchase_order=t4.purchase_order 
                AND t1.item=t4.item AND t1.quality=t4.quality AND t1.color=t4.color
                
                LEFT JOIN
                `vt_carton` as t5
                ON t1.po_no=t5.po_no AND t1.so_no=t5.so_no AND t1.purchase_order=t5.purchase_order 
                AND t1.item=t5.item AND t1.quality=t5.quality AND t1.color=t5.color
                
                LEFT JOIN
                `vt_wh_buyer` as t6
                ON t1.po_no=t6.po_no AND t1.so_no=t6.so_no AND t1.purchase_order=t6.purchase_order 
                AND t1.item=t6.item AND t1.quality=t6.quality AND t1.color=t6.color
                
                LEFT JOIN
                `vt_wh_factory` as t7
                ON t1.po_no=t7.po_no AND t1.so_no=t7.so_no AND t1.purchase_order=t7.purchase_order 
                AND t1.item=t7.item AND t1.quality=t7.quality AND t1.color=t7.color
                
                LEFT JOIN
                `vt_wh_trash` as t8
                ON t1.po_no=t8.po_no AND t1.so_no=t8.so_no AND t1.purchase_order=t8.purchase_order 
                AND t1.item=t8.item AND t1.quality=t8.quality AND t1.color=t8.color
                
                LEFT JOIN
                `vt_wh_others` as t9
                ON t1.po_no=t9.po_no AND t1.so_no=t9.so_no AND t1.purchase_order=t9.purchase_order 
                AND t1.item=t9.item AND t1.quality=t9.quality AND t1.color=t9.color
                
                LEFT JOIN
                `vt_cut_pass` as t10
                ON t1.po_no=t10.po_no AND t1.so_no=t10.so_no AND t1.purchase_order=t10.purchase_order 
                AND t1.item=t10.item AND t1.quality=t10.quality AND t1.color=t10.color
                
                LEFT JOIN
                `vt_wh_prod_sample` as t11
                ON t1.po_no=t11.po_no AND t1.so_no=t11.so_no AND t1.purchase_order=t11.purchase_order 
                AND t1.item=t11.item AND t1.quality=t11.quality AND t1.color=t11.color
                
                WHERE 1 $condition_1
                 
                $condition";

        $sql1="SELECT t1.* FROM (SELECT  po_no,so_no,item,quality,color,purchase_order,style_no,style_name,brand,ex_factory_date,
              COUNT(packing_status) as count_packing_pass,  
              COUNT(carton_status) as count_carton_pass, 
              COUNT(warehouse_buyer_date_time) as count_wh_buyer,
             COUNT(warehouse_factory_date_time) as count_wh_factory,
              COUNT(warehouse_trash_date_time) as count_wh_trash,
              COUNT(warehouse_production_sample_date_time) as count_wh_prod_sample,
              COUNT(warehouse_sizeset_date_time) as count_wh_size_set
              
            FROM (
            SELECT
            so_no,po_no,item,quality,color,purchase_order,brand,ex_factory_date,style_no,style_name,  
         
            CASE WHEN packing_status = 1 THEN packing_status END packing_status,
             CASE WHEN warehouse_buyer_date_time != '0000-00-00 00:00:00' THEN warehouse_buyer_date_time END warehouse_buyer_date_time,
            CASE WHEN warehouse_factory_date_time != '0000-00-00 00:00:00' THEN warehouse_factory_date_time END warehouse_factory_date_time,
            CASE WHEN warehouse_trash_date_time != '0000-00-00 00:00:00' THEN warehouse_trash_date_time END warehouse_trash_date_time,
            CASE WHEN warehouse_production_sample_date_time != '0000-00-00 00:00:00' THEN warehouse_production_sample_date_time END warehouse_production_sample_date_time,
            CASE WHEN warehouse_sizeset_date_time != '0000-00-00 00:00:00' THEN warehouse_sizeset_date_time END warehouse_sizeset_date_time,
            CASE WHEN carton_status = 1 THEN carton_status END carton_status 
          FROM tb_care_labels    
        ) tb_care_labels WHERE 1 $condition_1
        GROUP BY so_no,po_no,item,quality,color,purchase_order 
        ORDER BY ex_factory_date DESC) as t1";

        $query = $this->db->query($sql1)->result_array();
        return $query;
    }

    public function getProducitonSummaryReportCartonViewTable($condition_1,$condition){
//        $sql = "SELECT t1.*, t2.total_order_qty, t2.ex_factory_date, t2.wash_gmt,
//                t5.count_packing_pass, t6.count_wh_buyer, t7.count_wh_factory,
//                t8.count_wh_trash, t9.count_wh_others, t10.total_cut_input_qty,
//                t11.count_wh_lost, t12.count_wh_prod_sample
//
//                FROM
//
//                `vt_carton` as t1
//
//                LEFT JOIN
//                (SELECT *, SUM(quantity) as total_order_qty FROM `vt_po_detail`
//                GROUP BY po_no, so_no, purchase_order, item, quality, color) as t2
//                ON t1.po_no=t2.po_no AND t1.so_no=t2.so_no AND t1.purchase_order=t2.purchase_order
//                AND t1.item=t2.item AND t1.quality=t2.quality AND t1.color=t2.color
//
//                LEFT JOIN
//                `vt_packing` as t5
//                ON t1.po_no=t5.po_no AND t1.so_no=t5.so_no AND t1.purchase_order=t5.purchase_order
//                AND t1.item=t5.item AND t1.quality=t5.quality AND t1.color=t5.color
//
//                LEFT JOIN
//                `vt_wh_buyer` as t6
//                ON t1.po_no=t6.po_no AND t1.so_no=t6.so_no AND t1.purchase_order=t6.purchase_order
//                AND t1.item=t6.item AND t1.quality=t6.quality AND t1.color=t6.color
//
//                LEFT JOIN
//                `vt_wh_factory` as t7
//                ON t1.po_no=t7.po_no AND t1.so_no=t7.so_no AND t1.purchase_order=t7.purchase_order
//                AND t1.item=t7.item AND t1.quality=t7.quality AND t1.color=t7.color
//
//                LEFT JOIN
//                `vt_wh_trash` as t8
//                ON t1.po_no=t8.po_no AND t1.so_no=t8.so_no AND t1.purchase_order=t8.purchase_order
//                AND t1.item=t8.item AND t1.quality=t8.quality AND t1.color=t8.color
//
//                LEFT JOIN
//                `vt_wh_others` as t9
//                ON t1.po_no=t9.po_no AND t1.so_no=t9.so_no AND t1.purchase_order=t9.purchase_order
//                AND t1.item=t9.item AND t1.quality=t9.quality AND t1.color=t9.color
//
//                LEFT JOIN
//                `vt_cut_pass` as t10
//                ON t1.po_no=t10.po_no AND t1.so_no=t10.so_no AND t1.purchase_order=t10.purchase_order
//                AND t1.item=t10.item AND t1.quality=t10.quality AND t1.color=t10.color
//
//                LEFT JOIN
//                `vt_wh_lost` as t11
//                ON t1.po_no=t11.po_no AND t1.so_no=t11.so_no AND t1.purchase_order=t11.purchase_order
//                AND t1.item=t11.item AND t1.quality=t11.quality AND t1.color=t11.color
//
//                LEFT JOIN
//                `vt_wh_prod_sample` as t12
//                ON t1.po_no=t12.po_no AND t1.so_no=t12.so_no AND t1.purchase_order=t12.purchase_order
//                AND t1.item=t12.item AND t1.quality=t12.quality AND t1.color=t12.color
//
//                WHERE 1
//
//                $condition_1
//
//                $condition";

        $sql = "SELECT t1.*, t2.total_order_qty, t2.ex_factory_date, t2.wash_gmt, 
                t5.count_packing_pass, t10.total_cut_input_qty, t12.total_wh_qa

                FROM 
                
                `vt_carton` as t1
                
                LEFT JOIN
                (SELECT *, SUM(quantity) as total_order_qty FROM `vt_po_detail`
                GROUP BY po_no, so_no, purchase_order, item, quality, color) as t2
                ON t1.po_no=t2.po_no AND t1.so_no=t2.so_no AND t1.purchase_order=t2.purchase_order 
                AND t1.item=t2.item AND t1.quality=t2.quality AND t1.color=t2.color
                                
                LEFT JOIN
                `vt_packing` as t5
                ON t1.po_no=t5.po_no AND t1.so_no=t5.so_no AND t1.purchase_order=t5.purchase_order 
                AND t1.item=t5.item AND t1.quality=t5.quality AND t1.color=t5.color
                
                LEFT JOIN
                `vt_cut_pass` as t10
                ON t1.po_no=t10.po_no AND t1.so_no=t10.so_no AND t1.purchase_order=t10.purchase_order 
                AND t1.item=t10.item AND t1.quality=t10.quality AND t1.color=t10.color
                
                LEFT JOIN
                `tb_production_summary` as t12
                ON t1.po_no=t12.po_no AND t1.so_no=t12.so_no AND t1.purchase_order=t12.purchase_order 
                AND t1.item=t12.item AND t1.quality=t12.quality AND t1.color=t12.color
                
                WHERE 1
                
                $condition_1
                
                $condition";
        $sql1="SELECT t1.*, t2.total_order_qty FROM (SELECT po_no,so_no,item,quality,color,purchase_order,style_no,style_name,line_id,brand,ex_factory_date,carton_date_time,
                  COUNT(packing_status) as count_packing_pass,  
                  COUNT(carton_status) as count_carton_pass, 
                  COUNT(warehouse_qa_type) as total_wh_qa,
                  COUNT(sent_to_production_date_time) as total_cut_input_qty,
                  COUNT(manually_closed) as count_manual_close
                
                FROM (
                  SELECT
                    so_no,po_no,item,quality,color,purchase_order,line_id,brand,ex_factory_date,carton_date_time,style_no,style_name,  
                   CASE WHEN sent_to_production = 1 THEN sent_to_production_date_time END sent_to_production_date_time,
                    CASE WHEN packing_status = 1 THEN packing_status END packing_status,
                     CASE WHEN warehouse_qa_type != 0 THEN warehouse_qa_type END warehouse_qa_type,
                    CASE WHEN carton_status = 1 THEN carton_status END carton_status, 
                    CASE WHEN manually_closed = 1 THEN manually_closed END manually_closed 
                  FROM vt_few_days_po_pcs    
                ) vt_few_days_po_pcs WHERE  1 $condition_1  GROUP BY so_no,po_no,item,quality,color,purchase_order) as t1
                LEFT JOIN
                vt_po_summary as t2
                ON t1.so_no=t2.so_no AND t1.po_no=t2.po_no AND t1.purchase_order=t2.purchase_order AND t1.quality=t2.quality AND t1.color=t2.color
                ORDER by carton_date_time DESC";

        $query = $this->db->query($sql1)->result_array();
        return $query;
    }

    public function getProducitonSummaryReportFinish($condition, $condition_1){
        $sql = "SELECT t1.*, t2.bundle_start, t2.bundle_end, t2.total_cut_qty, t3.cut_prod_date_time,
                t3.total_cut_input_qty, t4.min_care_label, t4.max_care_label, t5.count_input_qty_line,
                t6.collar_cuff_bndl_qty, (IFNULL(t7.count_mid_line_qc_pass, 0)+IFNULL(t8.count_mid_line_qc_pass_in_end, 0)) as count_mid_line_qc_pass,
                t9.count_end_line_qc_pass, t10.count_washing_pass, t11.count_packing_pass, t11.max_packing_date_time, t12.count_carton_pass, t12.max_carton_date_time,
                t13.count_wh_prod_sample, t14.count_wh_buyer, t15.count_wh_factory, t16.max_warehouse_last_action_date_time, t17.count_wh_trash,
                t18.count_wh_others
                From (SELECT *, SUM(quantity) as total_order_qty FROM `tb_po_detail`
                WHERE 1 $condition_1
                GROUP BY po_no, purchase_order, item) as t1
                INNER JOIN
                (SELECT *, MIN(bundle) as bundle_start, MAX(bundle) as bundle_end, SUM(cut_qty) as total_cut_qty
                 FROM `tb_cut_summary` GROUP BY po_no, purchase_order, item) as t2
                ON t1.po_no=t2.po_no AND t1.purchase_order=t2.purchase_order AND t1.item=t2.item
                LEFT JOIN
                (SELECT *, COUNT(id) as total_cut_input_qty,
                MAX(sent_to_production_date_time) as cut_prod_date_time
                FROM `tb_care_labels` WHERE sent_to_production=1 GROUP BY po_no, purchase_order, item) as t3
                ON t1.po_no=t3.po_no AND t1.purchase_order=t3.purchase_order AND t1.item=t3.item
                LEFT JOIN
                (SELECT *, MIN(CAST(pc_tracking_no AS UNSIGNED)) as min_care_label,
                MAX(CAST(pc_tracking_no AS UNSIGNED)) as max_care_label
                 FROM `tb_care_labels` GROUP BY po_no, purchase_order, item) as t4
                 ON t1.po_no=t4.po_no AND t1.purchase_order=t4.purchase_order AND t1.item=t4.item
                 LEFT JOIN
                 (SELECT po_no, purchase_order, item, quality, style_no, style_name, COUNT(id) as count_input_qty_line
                FROM `tb_care_labels` WHERE line_id !=0 GROUP BY po_no, purchase_order, item) as t5
                ON t1.po_no=t5.po_no AND t1.purchase_order=t5.purchase_order AND t1.item=t5.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, style_no, quality, color, SUM(cut_qty) as collar_cuff_bndl_qty FROM `tb_cut_summary`
                WHERE is_bundle_collar_cuff_scanned_line=1 GROUP BY po_no, purchase_order, item) as t6
                ON t1.po_no=t6.po_no AND t1.purchase_order=t6.purchase_order AND t1.item=t6.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(id) as count_mid_line_qc_pass
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 3
                AND access_points_status in (1)
                GROUP BY po_no, purchase_order, item) as t7
                ON t1.po_no=t7.po_no AND t1.purchase_order=t7.purchase_order AND t1.item=t7.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(id) as count_mid_line_qc_pass_in_end
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 4
                AND access_points_status in (1, 2, 3, 4)
                GROUP BY po_no, purchase_order, item) as t8
                ON t1.po_no=t8.po_no AND t1.purchase_order=t8.purchase_order AND t1.item=t8.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(pc_tracking_no) as count_end_line_qc_pass
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 4
                AND access_points_status=4
                GROUP BY po_no, purchase_order, item) as t9
                ON t1.po_no=t9.po_no AND t1.purchase_order=t9.purchase_order AND t1.item=t9.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(pc_tracking_no) as count_washing_pass
                FROM `tb_care_labels` WHERE washing_status = 1
                GROUP BY po_no, purchase_order, item) as t10
                ON t1.po_no=t10.po_no AND t1.purchase_order=t10.purchase_order AND t1.item=t10.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(pc_tracking_no) as count_packing_pass,
                MAX(packing_date_time) as max_packing_date_time
                FROM `tb_care_labels` WHERE packing_status = 1
                GROUP BY po_no, purchase_order, item) as t11
                ON t1.po_no=t11.po_no AND t1.purchase_order=t11.purchase_order AND t1.item=t11.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(pc_tracking_no) as count_carton_pass,
                MAX(carton_date_time) as max_carton_date_time
                FROM `tb_care_labels` WHERE carton_status = 1
                GROUP BY po_no, purchase_order, item) as t12
                ON t1.po_no=t12.po_no AND t1.purchase_order=t12.purchase_order AND t1.item=t12.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(pc_tracking_no) as count_wh_prod_sample
                FROM `tb_care_labels` WHERE warehouse_qa_type = 4
                GROUP BY po_no, purchase_order, item) as t13
                ON t1.po_no=t13.po_no AND t1.purchase_order=t13.purchase_order AND t1.item=t13.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(pc_tracking_no) as count_wh_buyer
                FROM `tb_care_labels` WHERE warehouse_qa_type = 1
                GROUP BY po_no, purchase_order, item) as t14
                ON t1.po_no=t14.po_no AND t1.purchase_order=t14.purchase_order AND t1.item=t14.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(pc_tracking_no) as count_wh_factory
                FROM `tb_care_labels` WHERE warehouse_qa_type = 2
                GROUP BY po_no, purchase_order, item) as t15
                ON t1.po_no=t15.po_no AND t1.purchase_order=t15.purchase_order AND t1.item=t15.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item,
                MAX(warehouse_last_action_date_time) as max_warehouse_last_action_date_time
                FROM `tb_care_labels`
                GROUP BY po_no, purchase_order, item) as t16
                ON t1.po_no=t16.po_no AND t1.purchase_order=t16.purchase_order AND t1.item=t16.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(pc_tracking_no) as count_wh_trash
                FROM `tb_care_labels` WHERE warehouse_qa_type = 3
                GROUP BY po_no, purchase_order, item) as t17
                ON t1.po_no=t17.po_no AND t1.purchase_order=t17.purchase_order AND t1.item=t17.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(pc_tracking_no) as count_wh_others
                FROM `tb_care_labels` WHERE warehouse_qa_type = 5
                GROUP BY po_no, purchase_order, item) as t18
                ON t1.po_no=t18.po_no AND t1.purchase_order=t18.purchase_order AND t1.item=t18.item
                WHERE 1
                $condition";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getAllBrands(){
        $sql = "SELECT brand FROM `tb_po_detail` GROUP BY brand";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getProducitonSummaryReportByUID($where){
//        $sql = "SELECT t1.*, t2.bundle_start, t2.bundle_end, t2.total_cut_qty,
//                t3.total_cut_input_qty, t4.min_care_label, t4.max_care_label, t5.count_input_qty_line,
//                t6.collar_cuff_bndl_qty, (IFNULL(t7.count_mid_line_qc_pass, 0)+IFNULL(t8.count_mid_line_qc_pass_in_end, 0)) as count_mid_line_qc_pass,
//                t9.count_end_line_qc_pass, t10.count_washing_pass, t11.count_packing_pass
//                From (SELECT *, SUM(quantity) as total_order_qty FROM `tb_po_detail`
//                GROUP BY po_no, purchase_order, item) as t1
//                INNER JOIN
//                (SELECT *, MIN(bundle) as bundle_start, MAX(bundle) as bundle_end, SUM(cut_qty) as total_cut_qty
//                 FROM `tb_cut_summary` GROUP BY po_no, purchase_order, item) as t2
//                ON t1.po_no=t2.po_no AND t1.purchase_order=t2.purchase_order AND t1.item=t2.item
//                LEFT JOIN
//                (SELECT *, COUNT(id) as total_cut_input_qty
//                FROM `tb_care_labels` WHERE sent_to_production=1 GROUP BY po_no, purchase_order, item) as t3
//                ON t1.po_no=t3.po_no AND t1.purchase_order=t3.purchase_order AND t1.item=t3.item
//                LEFT JOIN
//                (SELECT *, MIN(CAST(pc_tracking_no AS UNSIGNED)) as min_care_label,
//                MAX(CAST(pc_tracking_no AS UNSIGNED)) as max_care_label
//                 FROM `tb_care_labels` GROUP BY po_no, purchase_order, item) as t4
//                 ON t1.po_no=t4.po_no AND t1.purchase_order=t4.purchase_order AND t1.item=t4.item
//                 LEFT JOIN
//                 (SELECT po_no, purchase_order, item, quality, style_no, style_name, COUNT(id) as count_input_qty_line
//                FROM `tb_care_labels` WHERE line_id !=0 GROUP BY po_no, purchase_order, item) as t5
//                ON t1.po_no=t5.po_no AND t1.purchase_order=t5.purchase_order AND t1.item=t5.item
//                LEFT JOIN
//                (SELECT po_no, purchase_order, item, style_no, quality, color, SUM(cut_qty) as collar_cuff_bndl_qty FROM `tb_cut_summary`
//                WHERE is_bundle_collar_cuff_scanned_line=1 GROUP BY po_no, purchase_order, item) as t6
//                ON t1.po_no=t6.po_no AND t1.purchase_order=t6.purchase_order AND t1.item=t6.item
//                LEFT JOIN
//                (SELECT po_no, purchase_order, item, COUNT(id) as count_mid_line_qc_pass
//                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 3
//                AND access_points_status in (1)
//                GROUP BY po_no, purchase_order, item) as t7
//                ON t1.po_no=t7.po_no AND t1.purchase_order=t7.purchase_order AND t1.item=t7.item
//                LEFT JOIN
//                (SELECT po_no, purchase_order, item, COUNT(id) as count_mid_line_qc_pass_in_end
//                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 4
//                AND access_points_status in (1, 2, 3, 4)
//                GROUP BY po_no, purchase_order, item) as t8
//                ON t1.po_no=t8.po_no AND t1.purchase_order=t8.purchase_order AND t1.item=t8.item
//                LEFT JOIN
//                (SELECT po_no, purchase_order, item, COUNT(pc_tracking_no) as count_end_line_qc_pass
//                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 4
//                AND access_points_status=4
//                GROUP BY po_no, purchase_order, item) as t9
//                ON t1.po_no=t9.po_no AND t1.purchase_order=t9.purchase_order AND t1.item=t9.item
//                LEFT JOIN
//                (SELECT po_no, purchase_order, item, COUNT(pc_tracking_no) as count_washing_pass
//                FROM `tb_care_labels` WHERE washing_status = 1
//                GROUP BY po_no, purchase_order, item) as t10
//                ON t1.po_no=t10.po_no AND t1.purchase_order=t10.purchase_order AND t1.item=t10.item
//                LEFT JOIN
//                (SELECT po_no, purchase_order, item, COUNT(pc_tracking_no) as count_packing_pass
//                FROM `tb_care_labels` WHERE packing_status = 1
//                GROUP BY po_no, purchase_order, item) as t11
//                ON t1.po_no=t11.po_no AND t1.purchase_order=t11.purchase_order AND t1.item=t11.item
//                WHERE 1 $where";

        $sql = "SELECT t1.*, t2.bundle_start, t2.bundle_end, t2.total_cut_qty, 
                t3.total_cut_input_qty, t3.line_input_date_time, t3.line_id, t3.max_line_input_date_time,
                t4.min_care_label, t4.max_care_label, t5.count_input_qty_line,
                t6.collar_cuff_bndl_qty, (IFNULL(t7.count_mid_line_qc_pass, 0)+IFNULL(t8.count_mid_line_qc_pass_in_end, 0)) as count_mid_line_qc_pass, 
                t9.count_end_line_qc_pass, t10.count_washing_pass, t11.count_packing_pass 
                From (SELECT *, SUM(quantity) as total_order_qty FROM `tb_po_detail` 
                GROUP BY po_no, purchase_order, item) as t1
                INNER JOIN 
                (SELECT *, MIN(bundle) as bundle_start, MAX(bundle) as bundle_end, SUM(cut_qty) as total_cut_qty 
                 FROM `tb_cut_summary` GROUP BY po_no, purchase_order, item) as t2
                ON t1.po_no=t2.po_no AND t1.purchase_order=t2.purchase_order AND t1.item=t2.item
                LEFT JOIN
                (SELECT *, COUNT(id) as total_cut_input_qty, MAX(line_input_date_time) as max_line_input_date_time
                FROM `tb_care_labels` WHERE sent_to_production=1 GROUP BY po_no, purchase_order, item) as t3
                ON t1.po_no=t3.po_no AND t1.purchase_order=t3.purchase_order AND t1.item=t3.item
                
                LEFT JOIN
                (SELECT *, MIN(CAST(pc_tracking_no AS UNSIGNED)) as min_care_label, 
                MAX(CAST(pc_tracking_no AS UNSIGNED)) as max_care_label 
                 FROM `tb_care_labels` GROUP BY po_no, purchase_order, item) as t4
                 ON t1.po_no=t4.po_no AND t1.purchase_order=t4.purchase_order AND t1.item=t4.item
                 
                 LEFT JOIN
                 (SELECT po_no, purchase_order, item, quality, style_no, style_name, COUNT(id) as count_input_qty_line, line_id
                FROM `tb_care_labels` WHERE line_id !=0 GROUP BY po_no, purchase_order, item, line_id) as t5
                ON t1.po_no=t5.po_no AND t1.purchase_order=t5.purchase_order AND t1.item=t5.item
                
                LEFT JOIN
                (SELECT po_no, purchase_order, item, style_no, quality, color, SUM(cut_qty) as collar_cuff_bndl_qty, line_id FROM `tb_cut_summary` 
                WHERE is_bundle_collar_cuff_scanned_line=1 GROUP BY po_no, purchase_order, item, line_id) as t6
                ON t1.po_no=t6.po_no AND t1.purchase_order=t6.purchase_order AND t1.item=t6.item
                AND t5.line_id=t6.line_id
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(id) as count_mid_line_qc_pass, line_id
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 3 
                AND access_points_status in (1)
                GROUP BY po_no, purchase_order, item, line_id) as t7
                ON t1.po_no=t7.po_no AND t1.purchase_order=t7.purchase_order AND t1.item=t7.item
                AND t5.line_id=t7.line_id
                LEFT JOIN 
                (SELECT po_no, purchase_order, item, COUNT(id) as count_mid_line_qc_pass_in_end, line_id
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 4 
                AND access_points_status in (1, 2, 3, 4)
                GROUP BY po_no, purchase_order, item, line_id) as t8
                ON t1.po_no=t8.po_no AND t1.purchase_order=t8.purchase_order AND t1.item=t8.item
                AND t5.line_id=t8.line_id
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(pc_tracking_no) as count_end_line_qc_pass, line_id
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 4 
                AND access_points_status=4 
                GROUP BY po_no, purchase_order, item, line_id) as t9
                ON t1.po_no=t9.po_no AND t1.purchase_order=t9.purchase_order AND t1.item=t9.item
                AND t5.line_id=t9.line_id
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(pc_tracking_no) as count_washing_pass, line_id
                FROM `tb_care_labels` WHERE washing_status = 1
                GROUP BY po_no, purchase_order, item, line_id) as t10
                ON t1.po_no=t10.po_no AND t1.purchase_order=t10.purchase_order AND t1.item=t10.item
                AND t5.line_id=t10.line_id
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(pc_tracking_no) as count_packing_pass, line_id
                FROM `tb_care_labels` WHERE packing_status = 1
                GROUP BY po_no, purchase_order, item, line_id) as t11
                ON t1.po_no=t11.po_no AND t1.purchase_order=t11.purchase_order AND t1.item=t11.item
                AND t5.line_id=t11.line_id
                
                WHERE 1 $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getLineInfo($line_id){
        $sql = "Select * From tb_line WHERE id=$line_id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getLineTarget($where){
        $sql = "Select * From line_daily_target WHERE 1 $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getLineTargetViewTable($line_id){
        $sql = "Select * From vt_curdate_line_target WHERE line_id = $line_id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function isReadyTodayLineOutputTable($line_id, $date){
        $sql = "Select * From tb_today_line_output_qty WHERE line_id = $line_id AND date='$date'";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getPrinterOn($user_id)
    {
        $sql = "UPDATE tb_user SET is_print_allowed='1' WHERE id =$user_id";

        $query = $this->db->query($sql);
        return $query;
    }

    public function getPrinterOff($user_id)
    {
        $sql = "UPDATE tb_user SET is_print_allowed='0' WHERE id = $user_id";

        $query = $this->db->query($sql);
        return $query;
    }

    public function updateTodayLineOutputQty($line_id, $date, $time){
        $sql = "UPDATE tb_today_line_output_qty 
                SET qty=(qty+1) 
                WHERE line_id = $line_id AND `date`='$date' 
                AND '$time' BETWEEN start_time AND end_time";

        $query = $this->db->query($sql);
        return $query;
    }

    public function getAllPurchaseOrdersForOlymp()
    {
        $sql = "SELECT * FROM `tb_po_detail`
                GROUP BY so_no, po_no, purchase_order, item, quality, color";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function po_closed($so_no, $status)
    {
        $sql = "UPDATE tb_po_detail SET status='$status' WHERE so_no='$so_no'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function getFinishingTarget($where){
        $sql = "Select * From finishing_daily_target WHERE 1 $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function warehouseTrashUpdate($care_label_no, $warehouse_type, $season, $user_id, $date_time, $remarks){
        $sql = "UPDATE `tb_care_labels`
                SET warehouse_qa_type=$warehouse_type,
                other_purpose_remarks='$remarks', warehouse_trash_date_time='$date_time', 
                season_id=$season, warehouse_qa_by=$user_id
                WHERE pc_tracking_no='$care_label_no'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function poManualClose($where, $date_time){
        $sql = "UPDATE `tb_care_labels`
                SET manually_closed=1, lost_date_time='$date_time'
                WHERE 1 $where";

        $query = $this->db->query($sql);
        return $query;
    }

    public function poManualReopen($where){
        $sql = "UPDATE `tb_care_labels`
                SET manually_closed=0
                WHERE 1 $where";

        $query = $this->db->query($sql);
        return $query;
    }

    public function getUpcomingPoList($where){
        $sql = "SELECT t1.*, t2.total_order_qty FROM 
                (SELECT po_no, so_no, purchase_order, item, quality, color, style_no, style_name, 
                planned_line_id, line_id, MIN(sent_to_production_date_time) as min_sent_date_time FROM `tb_care_labels` 
                WHERE 1 $where
                GROUP BY po_no, so_no, purchase_order, item, quality, color, planned_line_id, line_id) as t1
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color, ex_factory_date, 
                style_no, style_name, SUM(quantity) as total_order_qty 
                FROM `tb_po_detail` GROUP BY po_no, so_no, purchase_order, item, quality, color) as t2
                ON t1.po_no=t2.po_no AND t1.purchase_order=t2.purchase_order AND t1.item=t2.item 
                AND t1.quality=t2.quality AND t1.color=t2.color
                ORDER BY t1.min_sent_date_time";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getUpcomingPoListViewTable($where){
        $sql = "SELECT t1.*, t2.total_order_qty FROM 
                (SELECT * FROM `vt_upcoming_pos` 
                WHERE 1 $where
                GROUP BY po_no,so_no, purchase_order, item, quality, color, planned_line_id, line_id) as t1
                LEFT JOIN
                (SELECT *, SUM(quantity) as total_order_qty FROM `vt_po_detail` 
                GROUP BY po_no, purchase_order, item, quality, color) as t2
                ON t1.po_no=t2.po_no AND t1.purchase_order=t2.purchase_order AND t1.item=t2.item 
                AND t1.quality=t2.quality AND t1.color=t2.color
                ORDER BY t1.min_sent_date_time";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getQualityDefectsReport($where){
        $sql = "SELECT t1.*, t2.defect_name 
                FROM (SELECT defect_code, line_id, DATE_FORMAT(defect_date_time, '%Y-%m-%d') AS defect_date, 
                COUNT(pc_tracking_no) AS defect_count FROM `tb_defects_tracking`  
                WHERE 1 $where 
                GROUP BY defect_code) AS t1
                LEFT JOIN
                tb_defect_types AS t2
                ON t1.defect_code=t2.defect_code
                ORDER BY defect_count DESC
                LIMIT 5";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getDHUReport($where, $where_2, $where_1){
        $sql = "SELECT t1.line_id, t1.qty, t1.start_time, t1.end_time, 
                t2.defect_checking_count, t3.total_defect_count 

                FROM 

                (SELECT line_id, qty, start_time, end_time 
                FROM `tb_today_line_output_qty` WHERE 1 $where_2) AS t1

                LEFT JOIN
                (SELECT line_id, COUNT(t1.pc_tracking_no) AS defect_checking_count
                FROM
                (SELECT line_id, pc_tracking_no FROM `tb_defects_tracking`
                WHERE 1 $where
                GROUP BY pc_tracking_no, defect_date_time) AS t1) AS t2
                ON t1.line_id=t2.line_id

                LEFT JOIN
                (SELECT line_id, COUNT(pc_tracking_no) AS total_defect_count
                FROM `tb_defects_tracking`
                WHERE 1 $where_1) AS t3
                ON t1.line_id=t3.line_id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getLineDHUSummary($line_id){
        $sql = "SELECT t1.line_id, t1.dhu_sum, t1.brand,
                t1.work_hour_1, t1.work_hour_2, t1.work_hour_3, t1.work_hour_4
                FROM
                (SELECT line_id, SUM(dhu) AS dhu_sum, brand,
                work_hour_1, work_hour_2, work_hour_3, work_hour_4
                FROM `tb_today_line_output_qty` 
                WHERE 1 AND line_id=$line_id) AS t1";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getReprintRequest()
    {
        $sql = "SELECT t1.*,t2.po_no,t2.purchase_order, t2.item, t2.quality, t2.color, t2.brand, t2.style_no, t2.style_name FROM
                (SELECT * FROM `tb_label_reprint_log`) as t1
                INNER JOIN vt_few_days_po_pcs as t2
                ON t1.pc_tracking_no=t2.pc_tracking_no
                WHERE t1.request_status=0";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function approveRequest($pc_no, $user_name)
    {
        $sql = "UPDATE tb_label_reprint_log SET request_status=1,approved_by='$user_name' WHERE pc_tracking_no='$pc_no'";

        $query = $this->db->query($sql);
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

    public function copyToBackUpPoDetailTable($src_date, $des_db){

        $sql = "INSERT INTO $des_db.tb_po_detail
                SELECT * from efl_db_pts.tb_po_detail 
                WHERE DATE_FORMAT(ex_factory_date, '%Y-%m') = '$src_date'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function getAllDatabases(){
        $anotherdb = $this->load->database('anotherdb', TRUE);

        $sql = "SELECT TABLE_SCHEMA 
                FROM `VIEWS` 
                WHERE TABLE_SCHEMA LIKE '%efl_%' 
                GROUP BY TABLE_SCHEMA
                ORDER BY TABLE_SCHEMA DESC";

        $query = $anotherdb->query($sql)->result_array();

        return $query;
    }

    public function getExfactory($so_no)
    {
        $sql = "SELECT * FROM `tb_po_detail` WHERE so_no='$so_no'";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function updateExfacOnPoDetail($so_no, $target_date)
    {
        $sql = "UPDATE tb_po_detail SET ex_factory_date='$target_date' WHERE so_no='$so_no'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function updateExfacOnCarelabel($so_no, $target_date)
    {
        $sql = "UPDATE tb_care_labels SET ex_factory_date='$target_date' WHERE so_no='$so_no'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function updateExfacOnCutSumamry($so_no, $target_date)
    {
        $sql = "UPDATE tb_cut_summary SET ex_factory_date='$target_date' WHERE so_no='$so_no'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function deleteFromPoDetailTable($src_date){

        $sql = "DELETE FROM efl_db_pts.tb_po_detail 
                WHERE DATE_FORMAT(ex_factory_date, '%Y-%m') = '$src_date'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function copyToBackUpCutSummaryTable($src_date, $des_db){

        $sql = "INSERT INTO $des_db.tb_cut_summary
                SELECT * from efl_db_pts.tb_cut_summary
                WHERE DATE_FORMAT(ex_factory_date, '%Y-%m') = '$src_date'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function deleteFromCutSummaryTable($src_date){

        $sql = "DELETE FROM efl_db_pts.tb_cut_summary 
                WHERE DATE_FORMAT(ex_factory_date, '%Y-%m') = '$src_date'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function copyToBackUpCareLabelTable($src_date, $des_db){

//        $sql_pre = "INSERT INTO $des_db.tb_care_labels
//                SELECT t1.*
//                FROM (SELECT * from efl_db_pts.tb_care_labels
//                WHERE ex_factory_date < (CURRENT_DATE() - INTERVAL 45 DAY)) as t1
//                WHERE 1 AND t1.carton_status=1";

        $sql = "INSERT INTO $des_db.tb_care_labels
                SELECT t1.* 
                FROM (SELECT * from efl_db_pts.tb_care_labels 
                WHERE DATE_FORMAT(ex_factory_date, '%Y-%m') = '$src_date') as t1 
                WHERE 1 AND t1.carton_status=1";

        $query = $this->db->query($sql);
        return $query;
    }

    public function deleteFromCareLabelTable($src_date){

        $sql_pre = "DELETE FROM efl_db_pts.tb_care_labels where id IN 
                (SELECT t1.id FROM (SELECT id, carton_status, 
                warehouse_qa_type from efl_db_pts.tb_care_labels 
                WHERE ex_factory_date < (CURRENT_DATE() - INTERVAL 45 DAY)) as t1
                WHERE t1.carton_status=1 OR t1.warehouse_qa_type in (3, 5, 6))";

        $sql = "DELETE FROM efl_db_pts.tb_care_labels where id IN 
                (SELECT t1.id FROM (SELECT id, carton_status, 
                warehouse_qa_type from efl_db_pts.tb_care_labels 
                WHERE DATE_FORMAT(ex_factory_date, '%Y-%m') = '$src_date') as t1
                WHERE t1.carton_status=1 OR t1.warehouse_qa_type in (3, 5, 6))";

        $query = $this->db->query($sql);
        return $query;
    }

    public function getLineOutputReportViewTable($line_id){

        $sql = "SELECT * FROM `vt_curdate_end_line_qc` Where line_id=$line_id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function deleteCareLabelNos($po_no, $cut_no){

        $sql = "DELETE FROM `tb_care_labels` Where po_no = '$po_no' AND cut_no = '$cut_no'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function deleteCutSummary($po_no, $cut_no){

        $sql = "DELETE FROM `tb_cut_summary` Where po_no = '$po_no' AND cut_no = '$cut_no'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function getCuttingSummary($po_no, $cut_no){

        $sql = "SELECT MIN(bundle_range_start) as bundle_start, 
                MAX(bundle_range_end) as bundle_end, SUM(cut_qty) as total_cut_qty 
                FROM `tb_cut_summary` 
                WHERE po_no = '$po_no' AND cut_no = '$cut_no'";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getPoCutSummaryInfo($po_no, $cut_no){
        $sql = "SELECT t1.*, t2.total_order_qty FROM 
                (SELECT po_no, so_no, brand, quality, color, style_no, cut_no, 
                style_name, ex_factory_date, SUM(cut_qty) AS total_cut_qty 
                FROM `tb_cut_summary` AS t1
                WHERE t1.po_no='$po_no' AND t1.cut_no='$cut_no' 
                AND t1.package_sent_to_production=0
                AND t1.is_package_ready=1
                GROUP BY po_no) AS t1
                LEFT JOIN 
                (SELECT po_no, SUM(quantity) AS total_order_qty 
                FROM tb_po_detail 
                GROUP BY po_no) AS t2
                ON t1.po_no=t2.po_no";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getProducitonSummaryReportForCC($where){
        $sql = "SELECT t1.*, t2.bundle_start, t2.bundle_end, t2.total_cut_qty, t2.max_bundle_collar_cuff_scanned_line_date_time, 
                t3.total_cut_input_qty, t4.min_care_label, t4.max_care_label, t5.count_input_qty_line,
                t6.collar_bndl_qty, t12.cuff_bndl_qty, (IFNULL(t7.count_mid_line_qc_pass, 0)+IFNULL(t8.count_mid_line_qc_pass_in_end, 0)) as count_mid_line_qc_pass, 
                t9.count_end_line_qc_pass, t10.count_washing_pass, t11.count_packing_pass, t13.line_id,
                t14.cut_collar_bndl_qty, t15.cut_cuff_bndl_qty
                
                From (SELECT *, SUM(quantity) as total_order_qty FROM `tb_po_detail` 
                GROUP BY po_no, purchase_order, item) as t1
                INNER JOIN 
                (SELECT *, MIN(bundle) as bundle_start, MAX(bundle) as bundle_end, SUM(cut_qty) as total_cut_qty,
                 MAX(bundle_collar_cuff_scanned_line_date_time) as max_bundle_collar_cuff_scanned_line_date_time
                 FROM `tb_cut_summary` GROUP BY po_no, purchase_order, item) as t2
                ON t1.po_no=t2.po_no AND t1.purchase_order=t2.purchase_order AND t1.item=t2.item
                LEFT JOIN 
                (SELECT * 
                 FROM `tb_cut_summary` GROUP BY po_no, purchase_order, item, line_id) as t13
                ON t1.po_no=t13.po_no AND t1.purchase_order=t13.purchase_order AND t1.item=t13.item
                LEFT JOIN
                (SELECT *, COUNT(id) as total_cut_input_qty
                FROM `tb_care_labels` WHERE sent_to_production=1 GROUP BY po_no, purchase_order, item) as t3
                ON t1.po_no=t3.po_no AND t1.purchase_order=t3.purchase_order AND t1.item=t3.item
                LEFT JOIN
                (SELECT *, MIN(CAST(pc_tracking_no AS UNSIGNED)) as min_care_label, 
                MAX(CAST(pc_tracking_no AS UNSIGNED)) as max_care_label 
                 FROM `tb_care_labels` GROUP BY po_no, purchase_order, item) as t4
                 ON t1.po_no=t4.po_no AND t1.purchase_order=t4.purchase_order AND t1.item=t4.item
                 LEFT JOIN
                 (SELECT po_no, purchase_order, item, quality, style_no, style_name, COUNT(id) as count_input_qty_line
                FROM `tb_care_labels` WHERE line_id !=0 GROUP BY po_no, purchase_order, item) as t5
                ON t1.po_no=t5.po_no AND t1.purchase_order=t5.purchase_order AND t1.item=t5.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, style_no, quality, color, 
                SUM(cut_qty) as collar_bndl_qty FROM `tb_cut_summary` 
                WHERE is_bundle_collar_scanned_line=1 GROUP BY po_no, purchase_order, item) as t6
                ON t1.po_no=t6.po_no AND t1.purchase_order=t6.purchase_order AND t1.item=t6.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, style_no, quality, color, 
                SUM(cut_qty) as cuff_bndl_qty FROM `tb_cut_summary` 
                WHERE is_bundle_cuff_scanned_line=1 GROUP BY po_no, purchase_order, item) as t12
                ON t1.po_no=t12.po_no AND t1.purchase_order=t12.purchase_order AND t1.item=t12.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(id) as count_mid_line_qc_pass
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 3 
                AND access_points_status in (1)
                GROUP BY po_no, purchase_order, item) as t7
                ON t1.po_no=t7.po_no AND t1.purchase_order=t7.purchase_order AND t1.item=t7.item
                LEFT JOIN 
                (SELECT po_no, purchase_order, item, COUNT(id) as count_mid_line_qc_pass_in_end
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 4 
                AND access_points_status in (1, 2, 3, 4)
                GROUP BY po_no, purchase_order, item) as t8
                ON t1.po_no=t8.po_no AND t1.purchase_order=t8.purchase_order AND t1.item=t8.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(pc_tracking_no) as count_end_line_qc_pass
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 4 
                AND access_points_status=4 
                GROUP BY po_no, purchase_order, item) as t9
                ON t1.po_no=t9.po_no AND t1.purchase_order=t9.purchase_order AND t1.item=t9.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(pc_tracking_no) as count_washing_pass
                FROM `tb_care_labels` WHERE washing_status = 1
                GROUP BY po_no, purchase_order, item) as t10
                ON t1.po_no=t10.po_no AND t1.purchase_order=t10.purchase_order AND t1.item=t10.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(pc_tracking_no) as count_packing_pass
                FROM `tb_care_labels` WHERE packing_status = 1
                GROUP BY po_no, purchase_order, item) as t11
                ON t1.po_no=t11.po_no AND t1.purchase_order=t11.purchase_order AND t1.item=t11.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, style_no, quality, color, 
                SUM(cut_qty) as cut_collar_bndl_qty FROM `tb_cut_summary` 
                WHERE is_cutting_collar_bundle_ready=1 GROUP BY po_no, purchase_order, item) as t14
                ON t1.po_no=t14.po_no AND t1.purchase_order=t14.purchase_order AND t1.item=t14.item
                LEFT JOIN
                (SELECT po_no, purchase_order, item, style_no, quality, color, 
                SUM(cut_qty) as cut_cuff_bndl_qty FROM `tb_cut_summary` 
                WHERE is_cutting_cuff_bundle_ready=1 GROUP BY po_no, purchase_order, item) as t15
                ON t1.po_no=t15.po_no AND t1.purchase_order=t15.purchase_order AND t1.item=t15.item
                
                WHERE 1 $where
                ORDER BY t2.max_bundle_collar_cuff_scanned_line_date_time DESC";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getProducitonSummaryReportForCCViewTable($where){

//        $sql = "SELECT t1.*, t2.bundle_start, t2.bundle_end, t2.total_cut_qty, t4.max_bundle_collar_cuff_scanned_line_date_time,
//                t3.total_cut_input_qty, t4.count_collar_bundle_qty, t4.line_id, t5.count_cuff_bundle_qty,
//                t6.count_end_line_qc_pass, t14.count_cutting_collar_bundle_qty, t15.count_cutting_cuff_bundle_qty
//
//                FROM
//
//                (SELECT po_no, so_no, purchase_order, item, quality, color, line_id
//                FROM `tb_cut_summary`
//                WHERE 1 $where
//                GROUP BY po_no, so_no, purchase_order, item, quality, color, line_id) as t0
//
//                LEFT JOIN
//                `vt_po_summary` as t1
//                ON t1.po_no=t0.po_no AND t1.so_no=t0.so_no AND t1.purchase_order=t0.purchase_order AND t1.item=t0.item
//                AND t1.quality=t0.quality AND t1.color=t0.color
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
//                (SELECT po_no, so_no, purchase_order, item, quality, color, count_collar_bundle_qty,
//                line_id, max_bundle_collar_cuff_scanned_line_date_time
//                FROM `vt_sew_collar_bundle_scan`
//                WHERE 1 $where
//                GROUP BY po_no, so_no, purchase_order, item, quality, color, line_id) as t4
//                ON t1.po_no=t4.po_no AND t1.so_no=t4.so_no AND t1.purchase_order=t4.purchase_order AND t1.item=t4.item
//                AND t1.quality=t4.quality AND t1.color=t4.color
//
//                LEFT JOIN
//                (SELECT po_no, so_no, purchase_order, item, quality, color, count_cuff_bundle_qty, line_id
//                FROM `vt_sew_cuff_bundle_scan`
//                WHERE 1 $where
//                GROUP BY po_no, so_no, purchase_order, item, quality, color, line_id) as t5
//                ON t1.po_no=t5.po_no AND t1.so_no=t5.so_no AND t1.purchase_order=t5.purchase_order AND t1.item=t5.item
//                AND t1.quality=t5.quality AND t1.color=t5.color
//
//                LEFT JOIN
//                (SELECT po_no, so_no, purchase_order, item, quality, color, SUM(count_end_line_qc_pass) as count_end_line_qc_pass
//                FROM `vt_end_line_pass`
//                GROUP BY po_no, so_no, purchase_order, item, quality, color) as t6
//                ON t1.po_no=t6.po_no AND t1.so_no=t6.so_no AND t1.purchase_order=t6.purchase_order AND t1.item=t6.item
//                AND t1.quality=t6.quality AND t1.color=t6.color
//
//                LEFT JOIN
//                `vt_cut_collar_bundle_scan` as t14
//                ON t1.po_no=t14.po_no AND t1.so_no=t14.so_no AND t1.purchase_order=t14.purchase_order AND t1.item=t14.item
//                AND t1.quality=t14.quality AND t1.color=t14.color
//
//                LEFT JOIN
//                `vt_cut_cuff_bundle_scan` as t15
//                ON t1.po_no=t15.po_no AND t1.so_no=t15.so_no AND t1.purchase_order=t15.purchase_order AND t1.item=t15.item
//                AND t1.quality=t15.quality AND t1.color=t15.color
//
//
//                ORDER BY t4.max_bundle_collar_cuff_scanned_line_date_time DESC";

        $sql = "Select A.* FROM (SELECT t1.*, t2.total_order_qty,t3.bundle_start,
                t3.bundle_end,t3.cutting_collar_bundle_ready_date_time
                FROM (
                SELECT po_no,so_no,item,quality,color,purchase_order,ex_factory_date,brand,style_no,style_name,
                SUM(CASE WHEN is_cutting_collar_bundle_ready=1
                THEN cut_qty
                ELSE 0 end) AS count_cutting_collar_bundle_qty,

                SUM(CASE WHEN is_cutting_cuff_bundle_ready=1
                THEN cut_qty
                ELSE 0 end) AS count_cutting_cuff_bundle_qty,
                    SUM(CASE WHEN is_bundle_collar_scanned_line=1
                THEN cut_qty
                ELSE 0 end) AS count_collar_bundle_qty,
                    SUM(CASE WHEN is_bundle_cuff_scanned_line=1
                THEN cut_qty
                ELSE 0 end) AS count_cuff_bundle_qty
                FROM tb_cut_summary WHERE 1 $where GROUP BY po_no,so_no,item,quality,color,purchase_order
                )  as t1
                LEFT JOIN
                vt_po_summary as t2
                ON t1.so_no=t2.so_no AND t1.po_no=t2.po_no AND t1.purchase_order=t2.purchase_order AND t1.item=t2.item AND t1.quality=t2.quality AND t1.color=t2.color
                LEFT JOIN
                vt_cut as t3
                ON t1.so_no=t3.so_no AND t1.po_no=t3.po_no AND t1.purchase_order=t3.purchase_order AND t1.item=t3.item AND t1.quality=t3.quality AND t1.color=t3.color
                ORDER  BY cutting_collar_bundle_ready_date_time) AS A
                
                INNER JOIN 
                (SELECT so_no FROM tb_production_summary 
                WHERE balance > 0 AND (count_input_qty_line - count_end_line_qc_pass) > 0) AS B
                ON A.so_no=B.so_no";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function otherLineCollarBundleScanned($po_no, $so_no, $purchase_order, $item, $quality, $color, $line_id){
        $sql = "SELECT count_collar_bundle_qty FROM `vt_sew_collar_bundle_scan` 
                WHERE po_no='$po_no' AND so_no='$so_no' AND purchase_order='$purchase_order' 
                AND item='$item' AND quality='$quality' AND color='$color' AND line_id != $line_id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function otherLineCuffBundleScanned($po_no, $so_no, $purchase_order, $item, $quality, $color, $line_id){
        $sql = "SELECT count_cuff_bundle_qty FROM `vt_sew_cuff_bundle_scan` 
                WHERE po_no='$po_no' AND so_no='$so_no' AND purchase_order='$purchase_order' 
                AND item='$item' AND quality='$quality' AND color='$color' AND line_id != $line_id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getProducitonSummaryReportCutViewTable($where_1, $where){
//        $sql = "SELECT t1.po_no, t1.so_no, t1.purchase_order, t1.item, t1.quality, t1.color,
//                t1.brand, t1.style_no, t1.style_name, t1.ex_factory_date,
//                t1.total_order_qty, t2.total_cutting_qty,
//                t2.bundle_start, t2.bundle_end, t3.total_cut_input_qty,
//                t3.min_care_label, t3.max_care_label, t3.cut_prod_date_time
//                FROM
//                (SELECT *, SUM(quantity) as total_order_qty FROM `vt_po_detail`
//                GROUP BY po_no, so_no, purchase_order, item, quality, color) as t1
//                LEFT JOIN
//                (SELECT *, SUM(total_cut_qty) as total_cutting_qty From vt_cut
//                GROUP BY po_no, so_no, purchase_order, item, quality, color) as t2
//                ON t1.po_no=t2.po_no AND t1.so_no=t2.so_no AND t1.purchase_order=t2.purchase_order
//                AND t1.item=t2.item AND t1.quality=t2.quality AND t1.color=t2.color
//                LEFT JOIN
//                (SELECT *, MAX(max_sent_to_production_date_time) as cut_prod_date_time
//                From vt_cut_pass GROUP BY po_no, so_no, purchase_order, item, quality, color) as t3
//                ON t1.po_no=t3.po_no AND t1.so_no=t3.so_no AND t1.purchase_order=t3.purchase_order
//                AND t1.item=t3.item AND t1.quality=t3.quality AND t1.color=t3.color
//
//                $where";

//        $sql = "SELECT t1.po_no, t1.so_no, t1.purchase_order, t1.item, t1.quality, t1.color,
//                t1.brand, t1.style_no, t1.style_name, t1.ex_factory_date,
//                t1.total_order_qty, t2.total_cut_qty,
//                t2.bundle_start, t2.bundle_end, t3.total_cut_input_qty,
//                t3.min_care_label, t3.max_care_label, t3.cut_prod_date_time
//                FROM
//                `vt_po_summary` as t1
//                LEFT JOIN
//                vt_cut as t2
//                ON t1.po_no=t2.po_no AND t1.so_no=t2.so_no AND t1.purchase_order=t2.purchase_order
//                AND t1.item=t2.item AND t1.quality=t2.quality AND t1.color=t2.color
//                LEFT JOIN
//                (SELECT *, MAX(max_sent_to_production_date_time) as cut_prod_date_time
//                From vt_cut_pass GROUP BY po_no, so_no, purchase_order, item, quality, color) as t3
//                ON t1.po_no=t3.po_no AND t1.so_no=t3.so_no AND t1.purchase_order=t3.purchase_order
//                AND t1.item=t3.item AND t1.quality=t3.quality AND t1.color=t3.color
//
//                $where";

//        $sql = "SELECT t1.po_no, t1.so_no, t1.purchase_order, t1.item, t1.quality, t1.color,
//                t1.brand, t1.style_no, t1.style_name, t1.ex_factory_date,
//                t1.total_order_qty, t2.total_cut_qty, t3.total_cut_input_qty,
//                t3.cut_prod_date_time, t4.cut_balance_qty
//
//                FROM
//
//                (SELECT po_no,so_no,purchase_order,item,quality,color,
//                 MAX(sent_to_production_date_time) as cut_prod_date_time,
//                 COUNT(sent_to_production) as total_cut_input_qty
//                 FROM (SELECT so_no,po_no,item,quality,color,purchase_order,line_id,brand,
//                 ex_factory_date,style_no,style_name,planned_line_id,sent_to_production_date_time,
//                 CASE WHEN sent_to_production != 0 THEN sent_to_production END sent_to_production
//                 FROM vt_few_days_po_pcs) vt_few_days_po_pcs
//                 WHERE 1 $where_1
//                 GROUP BY so_no,po_no,item,quality,color,purchase_order, planned_line_id) as t3
//
//                LEFT JOIN
//                `vt_po_summary` as t1
//                ON t1.po_no=t3.po_no AND t1.so_no=t3.so_no AND t1.purchase_order=t3.purchase_order
//                AND t1.item=t3.item AND t1.quality=t3.quality AND t1.color=t3.color
//
//                LEFT JOIN
//                vt_cut as t2
//                ON t1.po_no=t2.po_no AND t1.so_no=t2.so_no AND t1.purchase_order=t2.purchase_order
//                AND t1.item=t2.item AND t1.quality=t2.quality AND t1.color=t2.color
//
//                LEFT JOIN
//                (SELECT po_no,so_no,purchase_order,item,quality,color,
//                 COUNT(sent_to_production) as cut_balance_qty
//                 FROM (SELECT so_no,po_no,item,quality,color,purchase_order,line_id,brand,
//                 ex_factory_date,style_no,style_name,planned_line_id,
//                 CASE WHEN sent_to_production = 0 THEN sent_to_production END sent_to_production
//                 FROM vt_few_days_po_pcs) vt_few_days_po_pcs
//                 GROUP BY so_no,po_no,item,quality,color,purchase_order, planned_line_id) as t4
//                ON t4.po_no=t3.po_no AND t4.so_no=t3.so_no AND t4.purchase_order=t3.purchase_order
//                AND t4.item=t3.item AND t4.quality=t3.quality AND t4.color=t3.color
//
//                $where";

        $sql = "SELECT t1.po_no, t1.so_no, t1.purchase_order, t1.item, t1.quality, t1.color,
                t1.brand, t1.style_no, t1.style_name, t1.ex_factory_date, t1.total_order_qty,
                t1.total_cut_qty, t1.total_cut_input_qty, t1.count_manual_close_qty, t1.planned_lines,
                t3.cut_input_qty, t3.cut_prod_date_time

                FROM

                (SELECT po_no,so_no,purchase_order,item,quality,color,
                 MAX(sent_to_production_date_time) as cut_prod_date_time,
                 COUNT(sent_to_production) as cut_input_qty
                 FROM (SELECT so_no,po_no,item,quality,color,purchase_order,line_id,brand,
                 ex_factory_date,style_no,style_name,planned_line_id,sent_to_production_date_time,
                 CASE WHEN sent_to_production != 0 THEN sent_to_production END sent_to_production
                 FROM vt_few_days_po_pcs) vt_few_days_po_pcs
                 WHERE 1 $where_1
                 GROUP BY so_no,po_no,item,quality,color,purchase_order, planned_line_id) as t3

                LEFT JOIN
                `tb_production_summary` as t1
                ON t1.po_no=t3.po_no AND t1.so_no=t3.so_no AND t1.purchase_order=t3.purchase_order
                AND t1.item=t3.item AND t1.quality=t3.quality AND t1.color=t3.color
          
                $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getLineProductionReport($line_no){
        $sql = "SELECT A.min_line_input_date_time, A.min_line_output_date,
                B.*, C.line_name, D.collar_bndl_qty, D.cuff_bndl_qty, D.po_type
                
                FROM (SELECT po_no, so_no, line_id, min_line_input_date_time, min_line_output_date 
                FROM `tb_line_running_pos` WHERE line_id=$line_no) as A
                
                LEFT JOIN
                (SELECT t1.*, t2.total_order_qty, t2.smv 
                FROM (SELECT po_no,so_no,item,quality,color,purchase_order,line_id,brand,
                ex_factory_date,mid_line_qc_date_time,style_no,style_name,
                    
                  count(line_input_date_time) as count_input_qty_line,
                  COUNT(mid_line_qc_date_time) as count_mid_line_qc_pass,
                  COUNT(end_line_qc_date_time) as count_end_line_qc_pass,
                  COUNT(lost_date_time) as count_manual_close
                  
                 
                FROM (
                  SELECT
                    so_no,po_no,item,quality,color,purchase_order,line_id,brand,ex_factory_date,style_no,style_name,
                                       
                    
                   CASE WHEN line_id != 0 THEN line_input_date_time END line_input_date_time,
                   CASE WHEN access_points >= 3 AND access_points_status IN (1, 4) THEN mid_line_qc_date_time END mid_line_qc_date_time,
                   CASE WHEN access_points = 4 AND access_points_status = 4 THEN end_line_qc_date_time END end_line_qc_date_time,
                   CASE WHEN manually_closed = 1 THEN lost_date_time END lost_date_time
                   
                  FROM vt_few_days_po_pcs 
                    
                ) vt_few_days_po_pcs WHERE line_id=$line_no GROUP BY so_no,po_no,item,quality,color,purchase_order, line_id) as t1
                
                LEFT JOIN
                vt_po_summary as t2
                ON t1.so_no=t2.so_no AND t1.po_no=t2.po_no AND t1.purchase_order=t2.purchase_order AND t1.quality=t2.quality AND t1.color=t2.color
                
                ORDER by mid_line_qc_date_time DESC
                ) as B
                ON A.so_no=B.so_no AND A.po_no=B.po_no AND A.line_id=B.line_id
                
                LEFT Join
                tb_line as C ON A.line_id=C.id
                
                LEFT Join
                tb_production_summary as D ON A.so_no=D.so_no
                
                ORDER BY A.min_line_input_date_time ASC";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getLineWiseRunningPOs($where){
        $sql = "SELECT t1.*, t2.so_no, t2.order_quantity, t2.smv, t2.po_type, t2.brand, t3.is_allowed_to_output 
                FROM 
                (SELECT * FROM `tb_line_running_pos` WHERE 1 $where) AS t1
                LEFT JOIN
                (SELECT so_no, SUM(quantity) AS order_quantity, smv, po_type, brand 
                FROM `tb_po_detail` GROUP BY so_no) AS t2
                ON t1.so_no=t2.so_no
                LEFT JOIN
                (SELECT so_no, line_id, is_allowed_to_output 
                FROM `tb_care_labels` 
                WHERE 1 $where 
                GROUP BY so_no, line_id) AS t3
                ON t1.so_no=t3.so_no";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function checkPackageReady($where)
    {
        $sql = "SELECT * FROM `tb_cut_summary` WHERE is_package_ready=1 AND package_sent_to_production=0 $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function updatePacakgeSentToProductionOnCL($po_no, $cut_no, $plan_line_id, $date_time)
    {
        $sql = "UPDATE tb_care_labels SET package_sent_to_production=1,
                package_sent_to_production_date_time='$date_time',
                planned_line_id='$plan_line_id' 
                WHERE `po_no` = '$po_no' AND cut_no='$cut_no'
                AND is_package_ready=1
                AND package_sent_to_production=0";

        $query = $this->db->query($sql);
        return $query;
    }

    public function allowDenyLinePoOutput($so_no, $line_id, $status, $responsible_person)
    {
        $sql = "UPDATE `tb_care_labels` 
                SET is_allowed_to_output=$status, is_allowed_to_output_remarks='$responsible_person'
                WHERE so_no='$so_no' AND line_id='$line_id'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function updatePacakgeSentToProductionOnCS($po_no, $cut_no, $plan_line_id, $date_time)
    {
        $sql = "UPDATE tb_cut_summary SET package_sent_to_production=1,
                package_sent_to_production_date_time='$date_time',
                planned_line_id='$plan_line_id'
                WHERE `po_no` = '$po_no' AND cut_no='$cut_no'
                AND is_package_ready=1
                AND package_sent_to_production=0";

        $query = $this->db->query($sql);
        return $query;
    }

    public function getPackageSentToSewReport($where, $where1)
    {
        $sql="SELECT t1.*, t2.total_order_qty ,t3.total_cut_qty,t3.bundle_start,t3.bundle_end,t3.cutting_collar_bundle_ready_date_time
                FROM (
                SELECT po_no,so_no,item,quality,color,purchase_order,ex_factory_date,brand,style_no,style_name, planned_line_id,package_sent_to_production,is_package_ready,
                SUM(CASE WHEN package_sent_to_production=1
                THEN cut_qty
                ELSE 0 end) AS pkg_sew_qty,
                SUM(CASE WHEN is_package_ready=1
                THEN cut_qty
                ELSE 0 end) AS pkg_rdy_qty 
                FROM tb_cut_summary WHERE 1 $where GROUP BY po_no,so_no,item,quality,color,purchase_order
                )  as t1
                LEFT JOIN
                vt_po_summary as t2
                ON t1.so_no=t2.so_no AND t1.po_no=t2.po_no AND t1.purchase_order=t2.purchase_order AND t1.item=t2.item AND t1.quality=t2.quality AND t1.color=t2.color
                LEFT JOIN
                vt_cut as t3
                ON t1.so_no=t3.so_no AND t1.po_no=t3.po_no AND t1.purchase_order=t3.purchase_order 
                AND t1.item=t3.item AND t1.quality=t3.quality AND t1.color=t3.color
                
               WHERE 1 $where1
                
                ORDER  BY cutting_collar_bundle_ready_date_time";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getRunningPoQtyReport($where)
    {
        $sql="SELECT COUNT(so_no) AS running_po_qty FROM `tb_line_running_pos` WHERE 1 $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getInputProducitonSummaryReportFilterViewTable($line_id, $where){

//        $sql = "SELECT t1.*, t3.count_end_line_qc_pass,
//                t4.total_order_qty, t4.ex_factory_date, t5.total_cut_qty,
//                t6.total_cut_input_qty, t6.max_sent_to_production_date_time
//
//                FROM (SELECT * FROM `vt_input_line` WHERE line_id=$line_id) as t1
//
//                LEFT JOIN
//                `vt_end_line_pass` as t3
//                ON t1.po_no=t3.po_no AND t1.so_no=t3.so_no AND t1.purchase_order=t3.purchase_order AND t1.item=t3.item
//                AND t1.quality=t3.quality AND t1.color=t3.color AND t1.line_id=t3.line_id
//
//                LEFT JOIN
//                `vt_po_summary` as t4
//                ON t1.po_no=t4.po_no AND t1.so_no=t4.so_no AND t1.purchase_order=t4.purchase_order AND t1.item=t4.item
//                AND t1.quality=t4.quality AND t1.color=t4.color
//
//                LEFT JOIN
//                `vt_cut` as t5
//                ON t1.po_no=t5.po_no AND t1.so_no=t5.so_no AND t1.purchase_order=t5.purchase_order AND t1.item=t5.item
//                AND t1.quality=t5.quality AND t1.color=t5.color
//
//                LEFT JOIN
//                `vt_cut_pass` as t6
//                ON t1.po_no=t6.po_no AND t1.so_no=t6.so_no AND t1.purchase_order=t6.purchase_order AND t1.item=t6.item
//                AND t1.quality=t6.quality AND t1.color=t6.color
//
//                WHERE (IFNULL(t1.count_input_qty_line, 0) - IFNULL(t3.count_end_line_qc_pass, 0)) > 0
//
//                $where";

        $sql="SELECT B.*
                 FROM (SELECT po_no, so_no,line_id FROM `tb_line_running_pos` WHERE line_id=$line_id) as A
                 LEFT JOIN(SELECT t1.*, t2.total_order_qty, t2.smv,t3.total_cut_qty 
                 FROM (SELECT po_no,so_no,item,quality,color,purchase_order,
                 line_id,brand,ex_factory_date,style_no,style_name,line_input_date_time,
                 count(line_input_date_time) as count_input_qty_line,
                 COUNT(sent_to_production_date_time) as total_cut_input_qty
                 FROM (SELECT so_no,po_no,item,quality,color,purchase_order,line_id,brand,ex_factory_date,style_no,style_name,
                CASE WHEN line_input_date_time !='0000-00-00 00:00:00' THEN line_input_date_time END line_input_date_time,
                CASE WHEN sent_to_production_date_time !='0000-00-00 00:00:00' THEN sent_to_production_date_time END sent_to_production_date_time
                 FROM vt_few_days_po_pcs) vt_few_days_po_pcs
                 GROUP BY so_no,po_no,item,quality,color,purchase_order) as t1
                 LEFT JOIN
                  vt_po_summary as t2
                    ON t1.so_no=t2.so_no AND t1.po_no=t2.po_no AND t1.purchase_order=t2.purchase_order AND t1.quality=t2.quality AND t1.color=t2.color
                 LEFT JOIN
                 vt_cut as t3
                   ON t1.so_no=t3.so_no AND t1.po_no=t3.po_no AND t1.purchase_order=t3.purchase_order AND t1.quality=t3.quality AND t1.color=t3.color
                   ORDER by line_input_date_time DESC) as B
                 ON A.so_no=B.so_no AND A.po_no=B.po_no 

                  ORDER BY line_input_date_time DESC";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getEndProducitonSummaryReportFilterViewTable($line_id, $where){
//        $sql = "SELECT t1.*, t2.count_mid_line_qc_pass, t2.max_mid_line_qc_date_time,
//                t3.count_end_line_qc_pass, t3.max_end_line_qc_date_time,
//                t4.total_order_qty, t4.ex_factory_date
//
//                FROM (SELECT * FROM `vt_input_line` WHERE line_id=$line_id) as t1
//
//                LEFT JOIN
//                `vt_mid_line_pass` as t2
//                ON t1.po_no=t2.po_no AND t1.so_no=t2.so_no AND t1.purchase_order=t2.purchase_order AND t1.item=t2.item
//                AND t1.quality=t2.quality AND t1.color=t2.color AND t1.line_id=t2.line_id
//
//                LEFT JOIN
//                `vt_end_line_pass` as t3
//                ON t1.po_no=t3.po_no AND t1.so_no=t3.so_no AND t1.purchase_order=t3.purchase_order AND t1.item=t3.item
//                AND t1.quality=t3.quality AND t1.color=t3.color AND t1.line_id=t3.line_id
//
//                LEFT JOIN
//                `vt_po_summary` as t4
//                ON t1.po_no=t4.po_no AND t1.so_no=t4.so_no AND t1.purchase_order=t4.purchase_order AND t1.item=t4.item
//                AND t1.quality=t4.quality AND t1.color=t4.color
//
//                $where";

        $sql = "SELECT B.*, C.line_name
                
                FROM (SELECT po_no, so_no,line_id FROM `tb_line_running_pos` WHERE line_id=$line_id) as A
                LEFT JOIN
                (SELECT t1.*, t2.total_order_qty, t2.smv 
                FROM (SELECT po_no,so_no,item,quality,color,purchase_order,line_id,brand,ex_factory_date,
                mid_line_qc_date_time,style_no,style_name,
                    
                  count(line_input_date_time) as count_input_qty_line,
                  COUNT(mid_line_qc_date_time) as count_mid_line_qc_pass,
                  COUNT(end_line_qc_date_time) as count_end_line_qc_pass,
                  COUNT(manually_closed) as count_manual_close
                      
                FROM (
                  SELECT
                    so_no,po_no,item,quality,color,purchase_order,line_id,brand,ex_factory_date,style_no,style_name,
                    
                    CASE WHEN line_id != 0 THEN line_input_date_time END line_input_date_time,
                    CASE WHEN access_points>=3 AND access_points_status in (1, 4) THEN mid_line_qc_date_time END mid_line_qc_date_time,
                    CASE WHEN access_points=4 AND access_points_status=4 THEN end_line_qc_date_time END end_line_qc_date_time,
                    CASE WHEN manually_closed=1 THEN manually_closed END manually_closed
                   
                  FROM vt_few_days_po_pcs 
                    
                ) vt_few_days_po_pcs WHERE line_id=$line_id GROUP BY so_no,po_no,item,quality,color,purchase_order, line_id) as t1
                
                LEFT JOIN
                vt_po_summary as t2
                ON t1.so_no=t2.so_no AND t1.po_no=t2.po_no AND t1.purchase_order=t2.purchase_order AND t1.quality=t2.quality AND t1.color=t2.color
                
                ORDER by mid_line_qc_date_time DESC
                ) as B
                ON A.so_no=B.so_no AND A.po_no=B.po_no AND A.line_id=B.line_id
                
                LEFT Join
                tb_line as C ON A.line_id=C.id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getProducitonSummaryReportFilterViewTable($line_id, $where){
        $sql = "SELECT t1.*, t2.count_mid_line_qc_pass, t2.max_mid_line_qc_date_time, 
                t3.count_end_line_qc_pass, t3.max_end_line_qc_date_time,
                t4.total_order_qty, t4.ex_factory_date, t5.total_cut_qty,t5.bundle_start, 
                t5. bundle_end, t6.total_cut_input_qty, t6.max_sent_to_production_date_time,
                t7.count_other_input_qty_line
                
                FROM (SELECT * FROM `vt_input_line` WHERE line_id=$line_id) as t1
                
                LEFT JOIN
                `vt_mid_line_pass` as t2
                ON t1.po_no=t2.po_no AND t1.so_no=t2.so_no AND t1.purchase_order=t2.purchase_order AND t1.item=t2.item 
                AND t1.quality=t2.quality AND t1.color=t2.color AND t1.line_id=t2.line_id
                
                LEFT JOIN
                `vt_end_line_pass` as t3
                ON t1.po_no=t3.po_no AND t1.so_no=t3.so_no AND t1.purchase_order=t3.purchase_order AND t1.item=t3.item 
                AND t1.quality=t3.quality AND t1.color=t3.color AND t1.line_id=t3.line_id
                
                LEFT JOIN
                (SELECT *, SUM(quantity) as total_order_qty FROM `vt_po_detail` 
                GROUP BY po_no, so_no, purchase_order, item, quality, color) as t4
                ON t1.po_no=t4.po_no AND t1.so_no=t4.so_no AND t1.purchase_order=t4.purchase_order AND t1.item=t4.item 
                AND t1.quality=t4.quality AND t1.color=t4.color
                
                LEFT JOIN
                (SELECT * FROM `vt_cut`) as t5
                ON t1.po_no=t5.po_no AND t1.so_no=t5.so_no AND t1.purchase_order=t5.purchase_order AND t1.item=t5.item 
                AND t1.quality=t5.quality AND t1.color=t5.color
                
                LEFT JOIN
                (SELECT * FROM `vt_cut_pass`) as t6
                ON t1.po_no=t6.po_no AND t1.so_no=t6.so_no AND t1.purchase_order=t6.purchase_order AND t1.item=t6.item 
                AND t1.quality=t6.quality AND t1.color=t6.color
                        
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color, 
                COUNT(id) as count_other_input_qty_line
                FROM `tb_care_labels` 
                WHERE line_id != 0 and line_id != $line_id 
                GROUP BY po_no, so_no, purchase_order, item, quality, color) as t7
                ON t1.po_no=t7.po_no AND t1.so_no=t7.so_no AND t1.purchase_order=t7.purchase_order AND t1.item=t7.item 
                AND t1.quality=t7.quality AND t1.color=t7.color

                $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }


    public function getMidPassReportFilterViewTable($where){

        $sql = "SELECT line_id, COUNT(id) AS count_mid_pass_qty  
                FROM `tb_care_labels` 
                WHERE 1 $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getLineWipReport($where){

//        $sql = "SELECT (B.count_line_input - (B.count_end_line_pass + B.count_manual_close)) AS count_wip_qty_line
//
//                FROM
//                (SELECT t1.*
//                FROM (SELECT
//
//                  COUNT(id) as count_line_input,
//                  COUNT(end_line_qc_date_time) as count_end_line_pass,
//                  COUNT(manually_closed) as count_manual_close
//
//                FROM (
//                  SELECT
//                    line_id,
//                    CASE WHEN access_points=4 AND access_points_status=4 THEN end_line_qc_date_time END end_line_qc_date_time,
//                    CASE WHEN line_id != 0 THEN id END id,
//                    CASE WHEN manually_closed = 1 THEN manually_closed END manually_closed
//
//                  FROM vt_few_days_po_pcs
//                ) vt_few_days_po_pcs ) as t1
//                ) as B
//                $where";


        $sql = "SELECT SUM(line_po_balance) AS count_wip_qty_line
                FROM `tb_line_running_pos` 
                WHERE 1 $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getMidProducitonSummaryReportFilterViewTable($line_id, $where){
//        $sql = "SELECT t1.*, t2.count_mid_line_qc_pass, t2.max_mid_line_qc_date_time,
//                t3.count_end_line_qc_pass, t3.max_end_line_qc_date_time,
//                t4.total_order_qty, t4.ex_factory_date
//
//                FROM (SELECT * FROM `vt_input_line` WHERE line_id=$line_id) as t1
//
//                LEFT JOIN
//                `vt_mid_line_pass` as t2
//                ON t1.po_no=t2.po_no AND t1.so_no=t2.so_no AND t1.purchase_order=t2.purchase_order AND t1.item=t2.item
//                AND t1.quality=t2.quality AND t1.color=t2.color AND t1.line_id=t2.line_id
//
//                LEFT JOIN
//                `vt_end_line_pass` as t3
//                ON t1.po_no=t3.po_no AND t1.so_no=t3.so_no AND t1.purchase_order=t3.purchase_order AND t1.item=t3.item
//                AND t1.quality=t3.quality AND t1.color=t3.color AND t1.line_id=t3.line_id
//
//                LEFT JOIN
//                `vt_po_summary` as t4
//                ON t1.po_no=t4.po_no AND t1.so_no=t4.so_no AND t1.purchase_order=t4.purchase_order AND t1.item=t4.item
//                AND t1.quality=t4.quality AND t1.color=t4.color
//
//                $where";
//
//        $query = $this->db->query($sql)->result_array();
//        return $query;

        $sql = "SELECT B.*, C.line_name
                
                FROM (SELECT po_no, so_no,line_id FROM `tb_line_running_pos` WHERE line_id=$line_id) as A
                LEFT JOIN
                (SELECT t1.*, t2.total_order_qty, t2.smv 
                FROM (SELECT po_no,so_no,item,quality,color,purchase_order,line_id,brand,ex_factory_date,
                mid_line_qc_date_time,style_no,style_name,
                    
                  count(line_input_date_time) as count_input_qty_line,
                  COUNT(mid_line_qc_date_time) as count_mid_line_qc_pass,
                  COUNT(end_line_qc_date_time) as count_end_line_qc_pass,
                  COUNT(manually_closed) as count_manual_close
                  
                  
                 
                FROM (
                  SELECT
                    so_no,po_no,item,quality,color,purchase_order,line_id,brand,ex_factory_date, style_no,style_name,
                    
                    CASE WHEN line_id != 0 THEN line_input_date_time END line_input_date_time,
                    CASE WHEN access_points >= 3 AND access_points_status IN (1, 4) THEN mid_line_qc_date_time END mid_line_qc_date_time,
                    CASE WHEN access_points = 4 AND access_points_status = 4 THEN end_line_qc_date_time END end_line_qc_date_time,
                    CASE WHEN manually_closed = 1 THEN manually_closed END manually_closed
                   
                  FROM vt_few_days_po_pcs 
                    
                ) vt_few_days_po_pcs WHERE line_id=$line_id GROUP BY so_no,po_no,item,quality,color,purchase_order, line_id) as t1
                
                LEFT JOIN
                vt_po_summary as t2
                ON t1.so_no=t2.so_no AND t1.po_no=t2.po_no AND t1.purchase_order=t2.purchase_order AND t1.quality=t2.quality AND t1.color=t2.color
                
                ORDER by mid_line_qc_date_time DESC
                ) as B
                ON A.so_no=B.so_no AND A.po_no=B.po_no AND A.line_id=B.line_id
                
                LEFT Join
                tb_line as C ON A.line_id=C.id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function isAvailAlready($where)
    {
        $sql = "SELECT * FROM `tb_po_detail`
                WHERE 1 $where AND is_manual_upload=1 ORDER BY id DESC LIMIT 1";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getManualUploadLastSoNo()
    {
//        $sql = "SELECT * FROM `tb_po_detail` WHERE is_manual_upload=1 ORDER BY ID DESC LIMIT 1";
        $sql = "SELECT * FROM `tb_last_so`";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function chk_cut_no($where)
    {
        $sql="SELECT cut_no FROM `tb_care_labels`
        WHERE 1 $where 
        GROUP BY po_no,so_no,purchase_order,item,quality,color,cut_no";
        $query = $this->db->query($sql)->result();
        return $query;
    }

    public function getProducitonSummaryReportFilter($where){
//        $sql = "SELECT t1.*, t2.bundle_start, t2.bundle_end, t2.total_cut_qty,
//                t3.total_cut_input_qty, t3.line_input_date_time, t4.min_care_label, t4.max_care_label, t5.count_input_qty_line,
//                t6.collar_cuff_bndl_qty, (IFNULL(t7.count_mid_line_qc_pass, 0)+IFNULL(t8.count_mid_line_qc_pass_in_end, 0)) as count_mid_line_qc_pass,
//                t9.count_end_line_qc_pass, t10.count_washing_pass, t11.count_packing_pass
//                From (SELECT *, SUM(quantity) as total_order_qty FROM `tb_po_detail`
//                GROUP BY po_no, purchase_order, item) as t1
//                INNER JOIN
//                (SELECT *, MIN(bundle) as bundle_start, MAX(bundle) as bundle_end, SUM(cut_qty) as total_cut_qty
//                 FROM `tb_cut_summary` GROUP BY po_no, purchase_order, item) as t2
//                ON t1.po_no=t2.po_no AND t1.purchase_order=t2.purchase_order AND t1.item=t2.item
//                LEFT JOIN
//                (SELECT *, COUNT(id) as total_cut_input_qty
//                FROM `tb_care_labels` WHERE sent_to_production=1 GROUP BY po_no, purchase_order, item) as t3
//                ON t1.po_no=t3.po_no AND t1.purchase_order=t3.purchase_order AND t1.item=t3.item
//                LEFT JOIN
//                (SELECT *, MIN(CAST(pc_tracking_no AS UNSIGNED)) as min_care_label,
//                MAX(CAST(pc_tracking_no AS UNSIGNED)) as max_care_label
//                 FROM `tb_care_labels` GROUP BY po_no, purchase_order, item) as t4
//                 ON t1.po_no=t4.po_no AND t1.purchase_order=t4.purchase_order AND t1.item=t4.item
//                 LEFT JOIN
//                 (SELECT po_no, purchase_order, item, quality, style_no, style_name, COUNT(id) as count_input_qty_line
//                FROM `tb_care_labels` WHERE line_id !=0 GROUP BY po_no, purchase_order, item) as t5
//                ON t1.po_no=t5.po_no AND t1.purchase_order=t5.purchase_order AND t1.item=t5.item
//                LEFT JOIN
//                (SELECT po_no, purchase_order, item, style_no, quality, color, SUM(cut_qty) as collar_cuff_bndl_qty FROM `tb_cut_summary`
//                WHERE is_bundle_collar_cuff_scanned_line=1 GROUP BY po_no, purchase_order, item) as t6
//                ON t1.po_no=t6.po_no AND t1.purchase_order=t6.purchase_order AND t1.item=t6.item
//                LEFT JOIN
//                (SELECT po_no, purchase_order, item, COUNT(id) as count_mid_line_qc_pass
//                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 3
//                AND access_points_status in (1)
//                GROUP BY po_no, purchase_order, item) as t7
//                ON t1.po_no=t7.po_no AND t1.purchase_order=t7.purchase_order AND t1.item=t7.item
//                LEFT JOIN
//                (SELECT po_no, purchase_order, item, COUNT(id) as count_mid_line_qc_pass_in_end
//                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 4
//                AND access_points_status in (1, 2, 3, 4)
//                GROUP BY po_no, purchase_order, item) as t8
//                ON t1.po_no=t8.po_no AND t1.purchase_order=t8.purchase_order AND t1.item=t8.item
//                LEFT JOIN
//                (SELECT po_no, purchase_order, item, COUNT(pc_tracking_no) as count_end_line_qc_pass
//                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 4
//                AND access_points_status=4
//                GROUP BY po_no, purchase_order, item) as t9
//                ON t1.po_no=t9.po_no AND t1.purchase_order=t9.purchase_order AND t1.item=t9.item
//                LEFT JOIN
//                (SELECT po_no, purchase_order, item, COUNT(pc_tracking_no) as count_washing_pass
//                FROM `tb_care_labels` WHERE washing_status = 1
//                GROUP BY po_no, purchase_order, item) as t10
//                ON t1.po_no=t10.po_no AND t1.purchase_order=t10.purchase_order AND t1.item=t10.item
//                LEFT JOIN
//                (SELECT po_no, purchase_order, item, COUNT(pc_tracking_no) as count_packing_pass
//                FROM `tb_care_labels` WHERE packing_status = 1
//                GROUP BY po_no, purchase_order, item) as t11
//                ON t1.po_no=t11.po_no AND t1.purchase_order=t11.purchase_order AND t1.item=t11.item
//                WHERE 1 $where";

        $sql = "SELECT t1.*, t2.bundle_start, t2.bundle_end, t2.total_cut_qty, 
                t3.total_cut_input_qty, t3.max_line_input_date_time, t3.max_mid_line_qc_date_time, 
                t3.max_end_line_qc_date_time, t3.line_id, t4.min_care_label, 
                t4.max_care_label, t5.count_input_qty_line, t6.collar_cuff_bndl_qty, 
                (IFNULL(t7.count_mid_line_qc_pass, 0)+IFNULL(t8.count_mid_line_qc_pass_in_end, 0)) as count_mid_line_qc_pass, 
                t9.count_end_line_qc_pass, t10.count_washing_pass, t11.count_packing_pass, t12.collar_bndl_qty, t13.cuff_bndl_qty 
                From (SELECT *, SUM(quantity) as total_order_qty FROM `tb_po_detail` 
                GROUP BY po_no, purchase_order, item) as t1
                INNER JOIN 
                (SELECT *, MIN(bundle) as bundle_start, MAX(bundle) as bundle_end, SUM(cut_qty) as total_cut_qty 
                 FROM `tb_cut_summary` GROUP BY po_no, purchase_order, item) as t2
                ON t1.po_no=t2.po_no AND t1.purchase_order=t2.purchase_order AND t1.item=t2.item
                LEFT JOIN
                (SELECT *, COUNT(id) as total_cut_input_qty, MAX(line_input_date_time) as max_line_input_date_time,
                MAX(mid_line_qc_date_time) as max_mid_line_qc_date_time, MAX(end_line_qc_date_time) as max_end_line_qc_date_time
                FROM `tb_care_labels` WHERE sent_to_production=1 GROUP BY po_no, purchase_order, item) as t3
                ON t1.po_no=t3.po_no AND t1.purchase_order=t3.purchase_order AND t1.item=t3.item
                
                LEFT JOIN
                (SELECT *, MIN(CAST(pc_tracking_no AS UNSIGNED)) as min_care_label, 
                MAX(CAST(pc_tracking_no AS UNSIGNED)) as max_care_label 
                 FROM `tb_care_labels` GROUP BY po_no, purchase_order, item) as t4
                 ON t1.po_no=t4.po_no AND t1.purchase_order=t4.purchase_order AND t1.item=t4.item
                 
                 LEFT JOIN
                 (SELECT po_no, purchase_order, item, quality, style_no, style_name, COUNT(id) as count_input_qty_line, line_id
                FROM `tb_care_labels` WHERE line_id !=0 GROUP BY po_no, purchase_order, item, line_id) as t5
                ON t1.po_no=t5.po_no AND t1.purchase_order=t5.purchase_order AND t1.item=t5.item
                
                LEFT JOIN
                (SELECT po_no, purchase_order, item, style_no, quality, color, 
                SUM(cut_qty) as collar_cuff_bndl_qty, line_id FROM `tb_cut_summary` 
                WHERE is_bundle_collar_cuff_scanned_line=1 GROUP BY po_no, purchase_order, item, line_id) as t6
                ON t1.po_no=t6.po_no AND t1.purchase_order=t6.purchase_order AND t1.item=t6.item
                AND t5.line_id=t6.line_id
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(id) as count_mid_line_qc_pass, line_id
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 3 
                AND access_points_status in (1)
                GROUP BY po_no, purchase_order, item, line_id) as t7
                ON t1.po_no=t7.po_no AND t1.purchase_order=t7.purchase_order AND t1.item=t7.item
                AND t5.line_id=t7.line_id
                LEFT JOIN 
                (SELECT po_no, purchase_order, item, COUNT(id) as count_mid_line_qc_pass_in_end, line_id
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 4 
                AND access_points_status in (1, 2, 3, 4)
                GROUP BY po_no, purchase_order, item, line_id) as t8
                ON t1.po_no=t8.po_no AND t1.purchase_order=t8.purchase_order AND t1.item=t8.item
                AND t5.line_id=t8.line_id
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(pc_tracking_no) as count_end_line_qc_pass, line_id
                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 4 
                AND access_points_status=4 
                GROUP BY po_no, purchase_order, item, line_id) as t9
                ON t1.po_no=t9.po_no AND t1.purchase_order=t9.purchase_order AND t1.item=t9.item
                AND t5.line_id=t9.line_id
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(pc_tracking_no) as count_washing_pass, line_id
                FROM `tb_care_labels` WHERE washing_status = 1
                GROUP BY po_no, purchase_order, item, line_id) as t10
                ON t1.po_no=t10.po_no AND t1.purchase_order=t10.purchase_order AND t1.item=t10.item
                AND t5.line_id=t10.line_id
                LEFT JOIN
                (SELECT po_no, purchase_order, item, COUNT(pc_tracking_no) as count_packing_pass, line_id
                FROM `tb_care_labels` WHERE packing_status = 1
                GROUP BY po_no, purchase_order, item, line_id) as t11
                ON t1.po_no=t11.po_no AND t1.purchase_order=t11.purchase_order AND t1.item=t11.item
                AND t5.line_id=t11.line_id
                
                
                LEFT JOIN
                (SELECT po_no, purchase_order, item, style_no, quality, color,
                SUM(cut_qty) as collar_bndl_qty, line_id FROM `tb_cut_summary`
                WHERE is_bundle_collar_scanned_line=1 GROUP BY po_no, purchase_order, item, line_id) as t12
                ON t1.po_no=t12.po_no AND t1.purchase_order=t12.purchase_order AND t1.item=t12.item
                AND t5.line_id=t12.line_id
                
                LEFT JOIN
                (SELECT po_no, purchase_order, item, style_no, quality, color,
                SUM(cut_qty) as cuff_bndl_qty, line_id FROM `tb_cut_summary`
                WHERE is_bundle_cuff_scanned_line=1 GROUP BY po_no, purchase_order, item, line_id) as t13
                ON t1.po_no=t13.po_no AND t1.purchase_order=t13.purchase_order AND t1.item=t13.item
                AND t5.line_id=t13.line_id
                
                WHERE 1 $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getPolyRemainingPcs($where){
        $sql = "Select * From `tb_care_labels` 
                WHERE packing_status=0 
                AND sent_to_production=1 $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getCartonRemainingPcs($where){
        $sql = "Select * From `tb_care_labels` 
                WHERE sent_to_production=1 AND carton_status=0 
                AND warehouse_qa_type=0 $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getRemainingPcs($where){
        $sql = "Select * From `tb_care_labels` 
                WHERE 1 $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getPoItemWiseSizeReport($where){
        $sql = "Select t1.*, t2.po_item_size_wise_endline_qty, t4.po_item_size_wise_packing_qty, 
                t5.total_cut_input_qty, t6.count_input_qty_line,
                (IFNULL(t7.count_mid_line_qc_pass, 0)+IFNULL(t8.count_mid_line_qc_pass_in_end, 0)) as count_mid_line_qc_pass,
                t9.count_end_line_qc_pass, t10.count_washing_pass, t11.total_cut_qty, t12.po_item_size_wise_carton_qty,
                t14.po_item_size_wise_wash_going_qty, t15.po_item_size_wise_wh_qty
                
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
                (SELECT *, MIN(bundle) as bundle_start, MAX(bundle) as bundle_end, SUM(cut_qty) as total_cut_qty 
                 FROM `tb_cut_summary` GROUP BY po_no, so_no, purchase_order, item, quality, color, size) as t11
                ON t1.po_no=t11.po_no AND t1.so_no=t11.so_no AND t1.purchase_order=t11.purchase_order AND t1.item=t11.item
                AND t1.quality=t11.quality AND t1.color=t11.color AND t1.size=t11.size
                
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color, size, COUNT(id) as po_item_size_wise_packing_qty
                FROM `tb_care_labels` 
                WHERE packing_status=1
                GROUP BY po_no, so_no, purchase_order, item, quality, color, size) as t4
                ON t1.po_no=t4.po_no AND t1.so_no=t4.so_no AND t1.purchase_order=t4.purchase_order AND t1.item=t4.item 
                AND t1.quality=t4.quality AND t1.color=t4.color AND t1.size=t4.size
                
                
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color, size, COUNT(id) as po_item_size_wise_carton_qty
                FROM `tb_care_labels` 
                WHERE carton_status=1
                GROUP BY po_no, so_no, purchase_order, item, quality, color, size) as t12
                ON t1.po_no=t12.po_no AND t1.so_no=t12.so_no AND t1.purchase_order=t12.purchase_order AND t1.item=t12.item 
                AND t1.quality=t12.quality AND t1.color=t12.color AND t1.size=t12.size
                
                LEFT JOIN 
                (SELECT *, MIN(bundle) as bundle_start, MAX(bundle) as bundle_end, SUM(cut_qty) as total_cut_qty 
                 FROM `tb_cut_summary` GROUP BY po_no, so_no, purchase_order, item, quality, color, size) as t13
                ON t1.po_no=t13.po_no AND t1.so_no=t13.so_no AND t1.purchase_order=t13.purchase_order AND t1.item=t13.item
                AND t1.quality=t13.quality AND t1.color=t13.color AND t1.size=t13.size
                
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color, size, COUNT(id) as po_item_size_wise_wash_going_qty
                FROM `tb_care_labels` 
                WHERE is_going_wash=1
                GROUP BY po_no, so_no, purchase_order, item, quality, color, size) as t14
                ON t1.po_no=t14.po_no AND t1.so_no=t14.so_no AND t1.purchase_order=t14.purchase_order AND t1.item=t14.item 
                AND t1.quality=t14.quality AND t1.color=t14.color AND t1.size=t14.size
                
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color, size, COUNT(id) as po_item_size_wise_wh_qty
                FROM `tb_care_labels` 
                WHERE warehouse_qa_type in (1, 2, 3, 4, 5, 6)
                GROUP BY po_no, so_no, purchase_order, item, quality, color, size) as t15
                ON t1.po_no=t15.po_no AND t1.so_no=t15.so_no AND t1.purchase_order=t15.purchase_order AND t1.item=t15.item 
                AND t1.quality=t15.quality AND t1.color=t15.color AND t1.size=t15.size
                
                LEFT JOIN
                `tb_size_serial` as t3
                ON t1.size=t3.size
                
                WHERE 1 $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getSizeBySo($so_no)
    {
        $sql = "SELECT so_no,cut_no FROM `tb_cut_summary` WHERE so_no='$so_no' GROUP BY cut_no";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getCareLabelShirtInfo($care_label_no){
        $sql = "Select * From tb_care_labels WHERE pc_tracking_no='$care_label_no' AND carton_status=0 AND is_reprint_allow=0";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function checkUserAuthorization($access_level, $cur_url)
    {
        $sql = "SELECT * FROM `tb_access_control` WHERE access_level='$access_level'
                AND url='$cur_url'
                AND status=1";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function isSeasonExist($season){
        $sql = "Select * From tb_season 
                WHERE season =  '$season'";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getAllSeasons(){
        $sql = "Select * From tb_season 
                ORDER BY id DESC";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function storeAsWarehouseGoods($care_label_no, $store_type, $season, $user_id, $date_time, $remarks){
        $set_datetime_fld = '';

        if($store_type == 1){
            $set_datetime_fld .= ", warehouse_buyer_date_time='$date_time'";
        }

        if($store_type == 2){
            $set_datetime_fld .= ", warehouse_factory_date_time='$date_time'";
        }

        if($store_type == 3){
            $set_datetime_fld .= ", warehouse_trash_date_time='$date_time'";
        }

        if($store_type == 4){
            $set_datetime_fld .= ", warehouse_production_sample_date_time='$date_time'";
        }

        if($store_type == 6){
            $set_datetime_fld .= ", lost_date_time='$date_time'";
        }

        if($store_type == 7){
            $set_datetime_fld .= ", warehouse_sizeset_date_time='$date_time'";
        }

        $sql = "Update `tb_care_labels` 
                Set warehouse_qa_type=$store_type, warehouse_qa_by=$user_id 
                $set_datetime_fld , warehouse_last_action_date_time='$date_time',
                season_id='$season', other_purpose_remarks='$remarks'
                WHERE pc_tracking_no = '$care_label_no'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function saveAsOtherPurpose($care_label_no, $other_purpose_reason, $other_purpose_liable_person, $user_id, $date_time){

        $sql = "Update `tb_care_labels` 
                Set warehouse_qa_type=5, warehouse_qa_by=$user_id,
                other_purpose_remarks='$other_purpose_reason', 
                other_purpose_liable_person='$other_purpose_liable_person',
                warehouse_last_action_date_time='$date_time',
                warehouse_other_purpose_date_time='$date_time'
                WHERE pc_tracking_no = '$care_label_no'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function cuttingCollarCuffTracking($bundle_tracking_no, $status_field, $status, $date_time_field, $date_time, $planned_line_id){
        $sql = "Update `tb_cut_summary` 
                Set `$status_field`=$status, `$date_time_field`='$date_time', 
                `cutting_collar_cuff_bundle_last_action_date_time`='$date_time', 
                `planned_line_id`='$planned_line_id'
                WHERE bundle_tracking_no = '$bundle_tracking_no'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function getPoItemWiseSizeCCReport($where){
        $sql = "Select t1.*, t2.total_collar_scanned_qty, t4.total_cuff_scanned_qty, t5.total_cut_qty
                From 
                (SELECT po_no, so_no, purchase_order, style_no, style_name, ex_factory_date, item, 
                quality, color, size, SUM(quantity) as po_item_size_wise_order_qty
                FROM `tb_po_detail` GROUP BY po_no, so_no, purchase_order, item, quality, color, size) as t1
                
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color, size, COUNT(id) as total_collar_bundle_scanned, 
                SUM(cut_qty) as total_collar_scanned_qty
                FROM `tb_cut_summary` 
                WHERE line_id != 0 AND is_bundle_collar_scanned_line=1
                GROUP BY po_no, so_no, purchase_order, item, quality, color, size) as t2
                ON t1.po_no=t2.po_no AND t1.so_no=t2.so_no AND t1.purchase_order=t2.purchase_order AND t1.item=t2.item 
                AND t1.quality=t2.quality AND t1.color=t2.color AND t1.size=t2.size
                
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color, size, COUNT(id) as total_cuff_bundle_scanned, 
                SUM(cut_qty) as total_cuff_scanned_qty
                FROM `tb_cut_summary` 
                WHERE line_id != 0 AND is_bundle_cuff_scanned_line=1
                GROUP BY po_no, so_no, purchase_order, item, quality, color, size) as t4
                ON t1.po_no=t4.po_no AND t1.so_no=t4.so_no AND t1.purchase_order=t4.purchase_order AND t1.item=t4.item 
                AND t1.quality=t4.quality AND t1.color=t4.color AND t1.size=t4.size
                
                LEFT JOIN 
                (SELECT *, MIN(bundle) as bundle_start, MAX(bundle) as bundle_end, SUM(cut_qty) as total_cut_qty 
                 FROM `tb_cut_summary` GROUP BY po_no, so_no, purchase_order, item, quality, color, size) as t5
                ON t1.po_no=t5.po_no AND t1.so_no=t5.so_no AND t1.purchase_order=t5.purchase_order AND t1.item=t5.item
                AND t1.quality=t5.quality AND t1.color=t5.color AND t1.size=t5.size
                
                LEFT JOIN
                `tb_size_serial` as t3
                ON t1.size=t3.size
                
                WHERE 1 $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getPoItemWiseSizeCutCCReport($where){
        $sql = "Select t1.*, t2.total_collar_scanned_qty, t4.total_cuff_scanned_qty, t5.total_cut_qty
                From 
                (SELECT po_no, so_no, purchase_order, style_no, style_name, ex_factory_date, item, 
                quality, color, size, SUM(quantity) as po_item_size_wise_order_qty
                FROM `tb_po_detail` GROUP BY po_no, so_no, purchase_order, item, quality, color, size) as t1
                
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color, size, COUNT(id) as total_collar_bundle_scanned, 
                SUM(cut_qty) as total_collar_scanned_qty
                FROM `tb_cut_summary` 
                WHERE is_cutting_collar_bundle_ready=1
                GROUP BY po_no, so_no, purchase_order, item, quality, color, size) as t2
                ON t1.po_no=t2.po_no AND t1.so_no=t2.so_no AND t1.purchase_order=t2.purchase_order AND t1.item=t2.item 
                AND t1.quality=t2.quality AND t1.color=t2.color AND t1.size=t2.size
                
                LEFT JOIN
                (SELECT po_no, so_no, purchase_order, item, quality, color, size, COUNT(id) as total_cuff_bundle_scanned, 
                SUM(cut_qty) as total_cuff_scanned_qty
                FROM `tb_cut_summary` 
                WHERE is_cutting_cuff_bundle_ready=1
                GROUP BY po_no, so_no, purchase_order, item, quality, color, size) as t4
                ON t1.po_no=t4.po_no AND t1.so_no=t4.so_no AND t1.purchase_order=t4.purchase_order AND t1.item=t4.item 
                AND t1.quality=t4.quality AND t1.color=t4.color AND t1.size=t4.size
                
                LEFT JOIN 
                (SELECT *, MIN(bundle) as bundle_start, MAX(bundle) as bundle_end, SUM(cut_qty) as total_cut_qty 
                 FROM `tb_cut_summary` GROUP BY po_no, so_no, purchase_order, item, quality, color, size) as t5
                ON t1.po_no=t5.po_no AND t1.so_no=t5.so_no AND t1.purchase_order=t5.purchase_order AND t1.item=t5.item
                AND t1.quality=t5.quality AND t1.color=t5.color AND t1.size=t5.size
                
                LEFT JOIN
                `tb_size_serial` as t3
                ON t1.size=t3.size
                
                WHERE 1 $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getSoInfo($sales_order){
        $sql = "Select * From `tb_po_detail` WHERE so_no LIKE '%$sales_order%'";

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

    public function getLineReportForChart($where){
        $sql = "SELECT line_id, COUNT(pc_tracking_no) as count_end_line_qc_pass, 
                DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') as end_line_qc_date_time 
                FROM `tb_care_labels` 
                
                WHERE 1 $where
                
                GROUP BY DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d'), line_id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getLineInputReportForChart($date){
//        $sql = "SELECT A.*, E.count_wip_qty, F.count_end_line_qc_pass, I.line_name, J.floor_name
//                FROM (SELECT line_id, COUNT(pc_tracking_no) as count_qty_line,
//                DATE_FORMAT(line_input_date_time, '%Y-%m-%d') as line_input_date
//                FROM `tb_care_labels` WHERE line_id !=0 AND DATE_FORMAT(line_input_date_time, '%Y-%m-%d') LIKE '%$date%'
//                GROUP BY DATE_FORMAT(line_input_date_time, '%Y-%m-%d'), line_id) as A
//
//
//                LEFT JOIN
//                (SELECT line_id, COUNT(pc_tracking_no) as count_wip_qty,
//                DATE_FORMAT(line_input_date_time, '%Y-%m-%d') as line_input_date
//                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 2
//                AND access_points_status=1
//                AND DATE_FORMAT(line_input_date_time, '%Y-%m-%d') LIKE '%$date%'
//                GROUP BY DATE_FORMAT(line_input_date_time, '%Y-%m-%d'), line_id) as E
//                ON A.line_id=E.line_id
//
//                LEFT JOIN
//                (SELECT line_id, COUNT(pc_tracking_no) as count_end_line_qc_pass,
//                DATE_FORMAT(line_input_date_time, '%Y-%m-%d') as line_input_date
//                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 4
//                AND access_points_status=1
//                AND DATE_FORMAT(line_input_date_time, '%Y-%m-%d') LIKE '%$date%'
//                GROUP BY DATE_FORMAT(line_input_date_time, '%Y-%m-%d'), line_id) as F
//                ON A.line_id=F.line_id
//
//                Inner Join
//                tb_line as I ON A.line_id=I.id
//                INNER JOIN
//                tb_floor as J ON I.floor=J.id";

//        $sql = "SELECT A.*, E.count_wip_qty, F.count_end_line_qc_pass, I.line_name, J.floor_name
//                FROM (SELECT line_id, COUNT(pc_tracking_no) as count_qty_line,
//                DATE_FORMAT(line_input_date_time, '%Y-%m-%d') as line_input_date
//                FROM `tb_care_labels` WHERE line_id !=0 AND DATE_FORMAT(line_input_date_time, '%Y-%m-%d') LIKE '%$date%'
//                GROUP BY DATE_FORMAT(line_input_date_time, '%Y-%m-%d'), line_id) as A
//
//                LEFT JOIN
//                (SELECT line_id, COUNT(pc_tracking_no) as count_wip_qty,
//                DATE_FORMAT(line_input_date_time, '%Y-%m-%d') as line_input_date
//                FROM `tb_care_labels`
//                WHERE line_id !=0
//                AND sent_to_production=1
//                AND access_points >= 3
//                AND access_points_status=1
//                GROUP BY line_id) as E
//                ON A.line_id=E.line_id
//
//                LEFT JOIN
//                (SELECT line_id, COUNT(pc_tracking_no) as count_end_line_qc_pass,
//                DATE_FORMAT(line_input_date_time, '%Y-%m-%d') as line_input_date
//                FROM `tb_care_labels` WHERE line_id !=0 AND access_points = 4
//                AND access_points_status=1
//                AND DATE_FORMAT(line_input_date_time, '%Y-%m-%d') LIKE '%$date%'
//                GROUP BY DATE_FORMAT(line_input_date_time, '%Y-%m-%d'), line_id) as F
//                ON A.line_id=F.line_id
//
//                Inner Join
//                tb_line as I ON A.line_id=I.id
//                INNER JOIN
//                tb_floor as J ON I.floor=J.id";

        $sql = "SELECT B.*, E.count_mid_pass_qty, F.count_end_line_qc_pass, G.count_wip_qty_line, I.line_name, J.floor_name 
                FROM 
                (SELECT line_id, COUNT(pc_tracking_no) as count_input_qty_line
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
                
                Inner Join
                tb_line as I ON A.line_id=I.id
                INNER JOIN
                tb_floor as J ON I.floor=J.id";

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

    public function lineValidation($carelabel_tracking_no){
        $sql = "SELECT * FROM `tb_care_labels`
                WHERE pc_tracking_no='$carelabel_tracking_no'";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function isLineTargetInputed($line_id, $target_date){
        $sql = "SELECT * FROM `line_daily_target` 
                WHERE line_id=$line_id AND date='$target_date'";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function isFinishingTargetInputed($floor_id, $target_date){
        $sql = "SELECT * FROM `finishing_daily_target` 
                WHERE floor_id=$floor_id AND date='$target_date'";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function isCuttingTargetInputed($target_date){
        $sql = "SELECT * FROM `cutting_daily_target` 
                WHERE date='$target_date'";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getPoOrderInfobyPo($where){
        $sql = "SELECT A.*, B.count_scanned_pc, C.count_unscanned_pc, D.total_cut_qty, E.responsible_line 

                FROM
                (SELECT po_no, purchase_order, brand, item, style_no, style_name, quality, 
                color, SUM(quantity) as order_quality, ex_factory_date 
                FROM `tb_po_detail` GROUP BY po_no, purchase_order, item, style_no, quality, color) as A

                LEFT Join
                (SELECT COUNT(pc_tracking_no) as count_scanned_pc, po_no, purchase_order, item, 
                quality, style_no, style_name, brand, size, color FROM `tb_care_labels` 
                WHERE sent_to_production=1 GROUP BY po_no, purchase_order, item, style_no, quality, color) as B

                ON A.po_no=B.po_no and A.purchase_order=B.purchase_order and A.item=B.item
                and A.style_no=B.style_no and A.quality=B.quality
                and A.color=B.color
                
                LEFT Join
                (SELECT COUNT(pc_tracking_no) as count_unscanned_pc, po_no, purchase_order, item, 
                quality, style_no, style_name, brand, size, color FROM `tb_care_labels` 
                WHERE sent_to_production=0 GROUP BY po_no, purchase_order, item, style_no, quality, color) as C

                ON A.po_no=C.po_no and A.purchase_order=C.purchase_order and A.item=C.item
                and A.style_no=C.style_no and A.quality=C.quality
                and A.color=C.color
                
                
                LEFT Join
                (SELECT *, MIN(bundle) as bundle_start, MAX(bundle) as bundle_end, SUM(cut_qty) as total_cut_qty 
                 FROM `tb_cut_summary`
                GROUP BY po_no, purchase_order, item, style_no, quality, color) as D
                ON A.po_no=D.po_no and A.purchase_order=D.purchase_order and A.item=D.item
                and A.style_no=D.style_no and A.quality=D.quality
                and A.color=D.color
                
                LEFT JOIN
                (SELECT t1.po_no, t1.purchase_order, t1.item, t1.style_no, t1.quality, t1.color, 
                GROUP_CONCAT(t2.line_code SEPARATOR ', ') as responsible_line
                From (SELECT po_no, purchase_order, item, style_no, quality, color, planned_line_id as line_id 
                FROM `tb_care_labels` WHERE planned_line_id !=0 
                GROUP BY po_no, purchase_order, item, planned_line_id) as t1
                LEFT JOIN
                (SELECT id, line_name, line_code FROM `tb_line`) as t2 On t1.line_id=t2.id
                GROUP BY t1.po_no, t1.purchase_order, t1.item) as E
                ON A.po_no=E.po_no and A.purchase_order=E.purchase_order and A.item=E.item
                and A.style_no=E.style_no and A.quality=E.quality
                and A.color=E.color
                
                WHERE 1 $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getPoItemBySapCut($sap_no, $cut_no){
        $sql = "SELECT cut_tracking_no, po_no, so_no, purchase_order, item, quality, style_no, style_name, 
                color, brand, cut_no
                FROM `vt_cut_summary` WHERE `po_no` = '$sap_no' AND `cut_no` = '$cut_no' 
                GROUP BY po_no, so_no, purchase_order, item
                ORDER BY purchase_order, item";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getCutNosBySo($sap_no){
        $sql = "SELECT cut_no
                FROM `vt_cut_summary` WHERE `po_no` = '$sap_no'
                GROUP BY po_no, cut_no
                ORDER BY (cut_no * 1)";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function sizeCutLayerWisePoItems($po_no, $size, $cut_no, $cut_layer){
        $sql = "SELECT po_no, purchase_order, item 
                FROM `tb_cut_summary` WHERE `po_no` = '$po_no' AND `size` = '$size' 
                AND `cut_no` = '$cut_no' AND `cut_layer` = '$cut_layer'
                GROUP BY po_no, purchase_order, item";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getRemainingCollarCuffBundlesBySize($where){
        $sql = "SELECT * FROM `tb_cut_summary` 
                WHERE 1 $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getRemainingCutCollarCuffBundlesBySize($where){
        $sql = "SELECT * FROM `tb_cut_summary` 
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

    public function getHours($where){
        $sql = "SELECT * FROM `tb_hours` WHERE 1 $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getHoursByTimeRange($time){
        $sql = "SELECT `hour`, end_time, TIME_TO_SEC(end_time) AS max_time_to_sec 
                FROM `tb_hours` 
                WHERE '$time' BETWEEN start_time AND end_time";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getMinMaxHours(){
        $sql = "SELECT MIN(start_time) as min_start_time, TIME_TO_SEC(MIN(start_time)) AS min_time_to_sec, 
                MAX(end_time) as max_end_time, TIME_TO_SEC(MIN(end_time)) AS max_time_to_sec 
                FROM `tb_hours`";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getWorkingHours($line_id, $date, $min_start_time){
        $sql = "SELECT date_format(max(end_line_qc_date_time), '%H:%i:%s') as time_format, 
                TIME_TO_SEC(date_format(max(end_line_qc_date_time), '%H:%i:%s')) as time_to_sec_format,
                TIME_TO_SEC('$min_start_time') as time_sec_start_format, 
                (TIME_TO_SEC(date_format(max(end_line_qc_date_time), '%H:%i:%s')) - TIME_TO_SEC('$min_start_time')) as working_time_diff_to_sec, 
                SEC_TO_TIME((TIME_TO_SEC(date_format(max(end_line_qc_date_time), '%H:%i:%s')) - TIME_TO_SEC('$min_start_time'))) as working_hours_min_sec
                FROM `vt_few_days_line_end_pass` 
                WHERE date_format(end_line_qc_date_time, '%Y-%m-%d') LIKE '%$date%' 
                AND date_format(end_line_qc_date_time, '%H:%i:%s') BETWEEN '$min_start_time' AND '23:59:59'
                AND line_id=$line_id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getWorkingHoursViewTable($line_id, $date, $min_start_time){
//        $sql = "SELECT date_format(max_end_line_qc_date_time, '%H:%i:%s') as time_format,
//                TIME_TO_SEC(date_format(max_end_line_qc_date_time, '%H:%i:%s')) as time_to_sec_format,
//                TIME_TO_SEC('$min_start_time') as time_sec_start_format,
//                (TIME_TO_SEC(date_format(max_end_line_qc_date_time, '%H:%i:%s')) - TIME_TO_SEC('$min_start_time')) as working_time_diff_to_sec,
//                SEC_TO_TIME((TIME_TO_SEC(date_format(max_end_line_qc_date_time, '%H:%i:%s')) - TIME_TO_SEC('$min_start_time'))) as working_hours_min_sec
//                FROM `vt_few_days_po_pcs`
//                WHERE end_line_qc_date = '$date'
//                AND line_id=$line_id";


        $sql = "SELECT date_format(MAX(end_line_qc_date_time), '%H:%i:%s') as time_format, 
                TIME_TO_SEC(date_format(MAX(end_line_qc_date_time), '%H:%i:%s')) as time_to_sec_format,
                TIME_TO_SEC('$min_start_time') as time_sec_start_format, 
                (TIME_TO_SEC(date_format(MAX(end_line_qc_date_time), '%H:%i:%s')) - TIME_TO_SEC('$min_start_time')) as working_time_diff_to_sec, 
                SEC_TO_TIME((TIME_TO_SEC(date_format(MAX(end_line_qc_date_time), '%H:%i:%s')) - TIME_TO_SEC('$min_start_time'))) as working_hours_min_sec
                FROM `vt_few_days_po_pcs` 
                WHERE DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') = '$date'
                AND line_id=$line_id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getSMVs($line_id, $date){
        $sql = "SELECT t1.*, t2.so_no, t2.smv FROM 
                (SELECT po_no,so_no, purchase_order, item, quality, color, 
                DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') as line_date_format, 
                count(id) as total_line_output
                FROM `vt_few_days_po_pcs`
                WHERE DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') = '$date'
                AND line_id=$line_id AND access_points_status=4
                GROUP BY po_no, so_no, purchase_order, item, quality, color) AS t1
                LEFT JOIN
                (SELECT * FROM `tb_po_detail` 
                GROUP BY po_no, so_no, purchase_order, item, quality, color) as t2
                ON t1.po_no=t2.po_no AND t1.purchase_order=t2.purchase_order 
                AND t1.item=t2.item AND t1.color=t2.color";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function todayLineOutput($where){
        $sql = "SELECT  count(id) as hourly_output FROM `tb_care_labels` 
                WHERE 1 $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function todayLineOutputViewTable($where){
        $sql = "SELECT  count(id) as hourly_output FROM `vt_curdate_line_output` 
                WHERE 1 $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getRemainingMidEndCLBySize($where, $where1, $where2){
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

    public function getRemainingMidEndCL($where, $where1, $where2){
        $sql = "SELECT A.* From (SELECT t1.* FROM
                (SELECT * FROM `tb_care_labels` WHERE 1 $where $where1) as t1) as A

                UNION
                
                SELECT B.* From(SELECT t2.* FROM
                (SELECT * FROM `tb_care_labels` WHERE 1 $where $where2) as t2) as B";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function poItemSizeCutLayerWiseQty($po_no, $so_no, $purchase_order, $item, $size, $cut_no, $cut_layer){
//        $sql = "SELECT cut_tracking_no, po_no, purchase_order, item, quality, style_no, style_name,
//                color, brand, cut_no, size, cut_qty, cut_layer, SUM(cut_qty) as qty
//                FROM `tb_cut_summary` WHERE `po_no`='$po_no'
//                AND `purchase_order` = '$purchase_order'
//                AND `item`='$item'
//                AND `size`='$size'
//                AND `cut_layer`='$cut_layer'
//                AND `cut_no` = '$cut_no'
//                GROUP BY po_no, purchase_order, item, cut_no, size, cut_layer";

        $sql = "Select t1.*, t2.start_cl, t2.end_cl 
                From (SELECT cut_tracking_no, po_no, so_no, purchase_order, item, quality, style_no, style_name, 
                color, brand, cut_no, size, cut_qty, cut_layer, SUM(cut_qty) as qty  
                FROM `vt_cut_summary_cutting_dept` WHERE `po_no`='$po_no'
                AND `so_no`='$so_no'
                AND `purchase_order` = '$purchase_order' 
                AND `item`='$item'
                AND `size`='$size'
                AND `cut_layer`='$cut_layer'
                AND `cut_no` = '$cut_no'
                GROUP BY po_no, so_no, purchase_order, item, cut_no, size, cut_layer) as t1
                
                INNER JOIN
                
                (SELECT po_no, so_no, purchase_order, item, cut_no, size, layer_group, 
                MIN(pc_tracking_no) as start_cl, MAX(pc_tracking_no) as end_cl FROM `vt_few_days_po_pcs` 
                GROUP BY po_no, so_no, purchase_order, item, cut_no, size, layer_group) as t2
 
                ON t1.po_no=t2.po_no AND t1.so_no=t2.so_no AND t1.purchase_order=t2.purchase_order 
                AND t1.item=t2.item AND t1.cut_no=t2.cut_no AND t1.size=t2.size AND t1.cut_layer=t2.layer_group";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function poItemSizeCutLayerWiseQtyNew($po_no, $so_no, $purchase_order, $item, $size, $cut_no, $cut_layer){
        $sql = "Select t1.*
                From (SELECT cut_tracking_no, po_no, so_no, purchase_order, item, quality, style_no, style_name, 
                color, brand, cut_no, size, cut_qty, cut_layer, SUM(cut_qty) as qty, MIN(pc_no_start) AS start_cl, MAX(pc_no_end) AS end_cl
                FROM `tb_cut_summary` WHERE `po_no`='$po_no'
                AND `so_no`='$so_no'
                AND `purchase_order` = '$purchase_order' 
                AND `item`='$item'
                AND `size`='$size'
                AND `cut_layer`='$cut_layer'
                AND `cut_no` = '$cut_no'
                GROUP BY po_no, so_no, purchase_order, item, cut_no, size, cut_layer) as t1";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function poItemWiseQtyNew($po_no, $so_no, $purchase_order, $item, $cut_no){
        $sql = "Select t1.*
                From (SELECT cut_tracking_no, po_no, so_no, purchase_order, item, quality, style_no, style_name, 
                color, brand, cut_no, cut_layer, SUM(cut_qty) as qty
                FROM `tb_cut_summary` WHERE `po_no`='$po_no'
                AND `so_no`='$so_no'
                AND `purchase_order` = '$purchase_order' 
                AND `item`='$item'
                AND `cut_no` = '$cut_no'
                GROUP BY po_no, so_no, purchase_order, item, cut_no) as t1";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function sendToLineForAlter($care_label_no, $floor_id, $status, $date_time){
        $sql = "UPDATE tb_care_labels 
                SET finishing_qc_status=$status, finishing_qc_date_time='$date_time', 
                finishing_floor_id='$floor_id', packing_status=0
                WHERE pc_tracking_no='$care_label_no'";

        $query = $this->db->query($sql);
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

    public function getCutNo($po_no, $sap_no, $item_no){

//        $sql = "SELECT * FROM `tb_cut_summary`
//                WHERE purchase_order LIKE '%$po_no%'
//                AND po_no LIKE '%$sap_no%'
//                AND item LIKE '%$item_no%'
//                GROUP BY po_no, purchase_order, item";

        $sql = "SELECT * FROM `tb_cut_summary` 
                WHERE purchase_order LIKE '%$po_no%'
                AND po_no LIKE '%$sap_no%'
                AND item LIKE '%$item_no%'
                ORDER BY id DESC LIMIT 1";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getCutNoList(){
        $sql = "SELECT * FROM `tb_cut_no`";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getQualitySizes($po_no, $sap_no, $item_no){
//        $sql = "SELECT * FROM `tb_po_detail`
//                WHERE purchase_order LIKE '%$po_no%'
//                AND po_no LIKE '%$sap_no%'
//                AND item LIKE '%$item_no%'";

//        $sql = "SELECT t1.*, t2.cut_qty
//                FROM
//                (Select * From `tb_po_detail` WHERE purchase_order LIKE '%$po_no%'
//                AND po_no LIKE '%$sap_no%'
//                AND item LIKE '%$item_no%') as t1
//                LEFT JOIN
//                `tb_cut_summary` as t2
//                ON t1.po_no=t2.po_no and t1.purchase_order=t2.purchase_order and t1.item=t2.item and t1.size=t2.size";

        $sql = "SELECT t1.*, t2.already_cut_qty
                FROM
                (Select A.* From `tb_po_detail` as A 
                INNER JOIN `tb_size_serial` as B
                ON A.size=B.size
                WHERE A.purchase_order LIKE '%$po_no%'
                AND A.po_no LIKE '%$sap_no%'
                AND A.item LIKE '%$item_no%' ORDER BY B.serial) as t1
                LEFT JOIN
                (Select po_no, purchase_order, item, quality, size, SUM(cut_qty) as already_cut_qty  
                From `tb_cut_summary` GROUP BY po_no, purchase_order, item, size) as t2
                ON t1.po_no=t2.po_no and t1.purchase_order=t2.purchase_order and t1.item=t2.item and t1.size=t2.size";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }
    public function chk_so_no($where)
    {
        $sql="SELECT so_no FROM tb_care_labels WHERE 1 $where
            GROUP BY so_no";
        $query = $this->db->query($sql)->result();
        return $query;
    }

    public function getCutTrackingDetail($cut_tracking_no){
        $sql = "SELECT * FROM `tb_bundle_cut_detail` WHERE cut_tracking_no='$cut_tracking_no'";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getBundleSummaryInfo($po_no, $so_no, $cut_tracking_no){
        $sql = "SELECT * FROM `vt_cut_summary` 
                WHERE po_no='$po_no' AND so_no='$so_no' 
                AND cut_tracking_no='$cut_tracking_no' 
                ORDER BY bundle DESC";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getTotalOrderQty($po_no){
        $sql = "SELECT *, SUM(quantity) as total_order_qty FROM `tb_po_detail` WHERE po_no='$po_no' GROUP BY po_no";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getBundleInfoDetail($po_no, $bundle_tracking_no){
        $sql = "SELECT A.bundle_tracking_no, A.pc_tracking_no as cl_ending, B.pc_tracking_no as cl_starting 
            From (SELECT *  FROM efl_db_pts.`tb_care_labels` 
            WHERE `po_no`='$po_no' AND `bundle_tracking_no` LIKE '%$bundle_tracking_no%' ORDER BY `id`  DESC LIMIT 1) as A
            INNER JOIN
            (SELECT *  FROM efl_db_pts.`tb_care_labels` 
            WHERE `po_no`='$po_no' AND `bundle_tracking_no` LIKE '%$bundle_tracking_no%' ORDER BY `id`  ASC LIMIT 1) as B";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getAllPurchaseOrders(){
        $sql = "SELECT * FROM `tb_po_detail` GROUP BY so_no, po_no, purchase_order, item, quality, color";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function isValidSo($po_no){
        $sql = "SELECT po_no, purchase_order, item FROM `tb_po_detail` 
                WHERE po_no='$po_no' 
                GROUP BY po_no";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function isValidPo($sales_order, $purchase_order){
        $sql = "SELECT po_no, purchase_order, item FROM `tb_po_detail` 
                WHERE po_no='$sales_order' AND purchase_order='$purchase_order' 
                GROUP BY po_no, purchase_order, item";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function isValidItem($sales_order, $purchase_order, $item){
        $sql = "SELECT po_no, purchase_order, item FROM `tb_po_detail` 
                WHERE po_no='$sales_order' AND purchase_order='$purchase_order' AND item='$item'
                GROUP BY po_no, purchase_order, item";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getAllSOs(){
        $sql = "SELECT po_no, so_no, purchase_order, item, quality, color, style_no, style_name, ex_factory_date, po_type  
                FROM `tb_po_detail` WHERE po_no != '' GROUP BY po_no, so_no";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function search_exfactory($po_no)
    {
        $sql = "SELECT * FROM `tb_po_detail` WHERE po_no='$po_no'";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function isReadyTodayFinishingOutputTable($floor_id, $date){
        $sql = "Select * From tb_today_finishing_output_qty
                WHERE floor_id = $floor_id AND date='$date'";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function deleteTodayFinishingOutputTable($floor_id)
    {
        $sql = "Delete From tb_today_finishing_output_qty
                WHERE floor_id=$floor_id";

        $query = $this->db->query($sql);
        return $query;
    }

    public function updateTodayFinishingOutputQty($floor_id, $date, $time){
        $sql = "UPDATE tb_today_finishing_output_qty
                SET qty=(qty+1) 
                WHERE floor_id = $floor_id AND `date`='$date' 
                AND '$time' BETWEEN start_time AND end_time";

        $query = $this->db->query($sql);
        return $query;
    }

    public function getTodayFinishingTarget($line_id, $date)
    {
        $sql = "SELECT * FROM `finishing_daily_target` WHERE floor_id = $line_id and date='$date'";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getTodayFinishingOutputReport($line_id)
    {
        $sql = "SELECT * FROM tb_today_finishing_output_qty 
                WHERE floor_id=$line_id 
                ORDER BY start_time DESC";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getTodayFinishingOutputSummaryReport($line_id){
        $sql = "SELECT SUM(qty) as count_total_finishing_qty FROM tb_today_finishing_output_qty
                WHERE floor_id=$line_id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function poPartInsert( $po_no, $v_data, $exfac_date, $date_time)
    {
        $sql = "insert into tb_po_part_detail (po_no, part_code, ex_factory_date, upload_date_time)
                VALUES ('$po_no', '$v_data', '$exfac_date', '$date_time')";

        $query = $this->db->query($sql);
        return $query;
    }

    public function getAllPart()
    {
        $sql = "SELECT * FROM `tb_gmt_part`";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function search_bundle_ticket_other_part($po_no)
    {
        $sql = "SELECT * FROM `tb_po_part_detail` WHERE po_no='$po_no' GROUP BY po_no, part_code";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    // Care Label Print Unlock from Admin Panel Start
    public function getAllSoFromCutSummary()
    {
        $sql="SELECT * FROM tb_cut_summary GROUP BY po_no";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function search_active_care_label($po_no,$purchase_no,$item_no,$quality,$color,$cut_no)
    {
        $sql="SELECT COUNT(id) FROM `tb_cut_summary` WHERE po_no='$po_no' AND
              purchase_order='$purchase_no' AND item='$item_no' AND quality='$quality' AND 
              color=$color AND cut_no='$cut_no'";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function activeCutSummary($po_no, $cut_no, $purchase_no, $item_no, $quality, $color)
    {
        $sql = "UPDATE tb_cut_summary SET is_care_label_printed=0 WHERE po_no='$po_no' AND purchase_order='$purchase_no'
            AND item='$item_no' AND quality='$quality' AND color='$color' AND cut_no='$cut_no' ";

        $query = $this->db->query($sql);
        return $query;
    }

    public function activeCareLabel($po_no, $cut_no, $purchase_no, $item_no, $quality, $color)
    {
        $sql = "UPDATE tb_care_labels SET is_printed=0 WHERE po_no='$po_no' AND purchase_order='$purchase_no'
            AND item='$item_no' AND quality='$quality' AND color='$color' AND cut_no='$cut_no'";

        $query = $this->db->query($sql);
        return $query;
    }
    // Care Label Print Unlock from Admin Panel End

    public function getAllPOs(){
        $sql = "SELECT purchase_order FROM `tb_po_detail` WHERE purchase_order != '' GROUP BY purchase_order";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getAllItems(){
        $sql = "SELECT item FROM `tb_po_detail` WHERE item != '' GROUP BY item";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getAllStyles(){
        $sql = "SELECT style_no, style_name FROM `tb_po_detail` WHERE style_no != '' GROUP BY style_no";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getAllQuality(){
        $sql = "SELECT quality FROM `tb_po_detail` WHERE quality != '' GROUP BY quality";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getAllColor(){
        $sql = "SELECT color FROM `tb_po_detail` WHERE color != '' GROUP BY color";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getPoDetail($where){
        $sql = "SELECT *, sum(quantity) as order_qty 
                FROM `tb_po_detail` 
                where 1 $where 
                GROUP BY so_no, po_no, purchase_order, item, quality, color";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getSendingToProductionreport($date){
        $sql = "SELECT A.*, B.count_sent_prod_care_label 
                From (SELECT purchase_order, item, quality, style_no, style_name, brand, color, cut_no, cut_tracking_no, 
                COUNT(is_printed) as count_care_label, (DATE_FORMAT(printing_date_time, '%Y-%m-%d')) as print_date FROM `tb_care_labels` 
                WHERE DATE_FORMAT(printing_date_time, '%Y-%m-%d') LIKE '%$date%' 
                and is_printed=1 GROUP BY cut_tracking_no) as A
                LEFT JOIN
                (SELECT purchase_order, item, quality, style_no, style_name, brand, color, cut_no, cut_tracking_no, 
                COUNT(sent_to_production) as count_sent_prod_care_label FROM `tb_care_labels` 
                WHERE DATE_FORMAT(sent_to_production_date_time, '%Y-%m-%d') LIKE '%$date%'
                and sent_to_production=1 GROUP BY cut_tracking_no) as B
                ON A.cut_tracking_no=B.cut_tracking_no";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getSummaryReportbyPo($where){
        $sql = "SELECT A.*, B.count_sent_prod_care_label 
                From (SELECT purchase_order, item, quality, style_no, style_name, brand, color, cut_no, cut_tracking_no, 
                COUNT(is_printed) as count_care_label, (DATE_FORMAT(printing_date_time, '%Y-%m-%d')) as print_date FROM `tb_care_labels` 
                WHERE 1 $where and is_printed=1 and line_id != 0 GROUP BY cut_tracking_no) as A
                LEFT JOIN
                (SELECT purchase_order, item, quality, style_no, style_name, brand, color, cut_no, cut_tracking_no, 
                COUNT(sent_to_production) as count_sent_prod_care_label FROM `tb_care_labels` 
                WHERE 1 $where and sent_to_production=1 GROUP BY cut_tracking_no) as B
                ON A.cut_tracking_no=B.cut_tracking_no";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getNotScannedCareLabels($cut_tracking_no){
        $sql = "SELECT pc_tracking_no, purchase_order, item, quality, style_no, style_name, brand, 
                size, color, cut_no, cut_tracking_no, bundle_no, bundle_tracking_no, bundle_range, layer_group 
                FROM `tb_care_labels` WHERE sent_to_production=0 AND cut_tracking_no='$cut_tracking_no'";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getBundleInfo($cut_tracking_no){
        $sql = "SELECT * FROM `tb_bundle_cut_detail` WHERE cut_tracking_no='$cut_tracking_no'";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function checkCutCareLabelAvailability($po_no, $so_no, $cut_tracking_no, $limit){
        $sql = "SELECT * FROM `vt_few_days_po_pcs` 
                WHERE po_no='$po_no' AND so_no='$so_no' 
                AND cut_tracking_no='$cut_tracking_no' AND is_printed=0
                ORDER BY id DESC
                $limit";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getLastCareLabel(){
        $sql = "SELECT * FROM `tb_care_labels` ORDER BY ID DESC LIMIT 1";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function isCutTrackingNoAvailable($cut_tracking_no){
        $sql = "SELECT * FROM `tb_cut_summary` WHERE cut_tracking_no LIKE '%$cut_tracking_no%'";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getPOsForCutting()
    {
        $sql = "SELECT po_no, purchase_order, brand, item, style_no, style_name, 
                color, quality, sum(quantity) as total_qty, ex_factory_date 
                FROM `tb_po_detail`
                Group By po_no, purchase_order, style_no, item, quality, color";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getPOCutSummary($cut_tracking_no)
    {
        $sql = "SELECT cut_tracking_no, style_no, size, COUNT(bundle_range) as count_bundle_range, bundle_range 
                FROM `tb_pc_detail` WHERE cut_tracking_no LIKE '%$cut_tracking_no%' Group BY cut_tracking_no, bundle_range";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function isAlreadySentToProduction($cut_tracking_no)
    {
        $sql = "Select * From `tb_cut_scan` WHERE cut_tracking_no='$cut_tracking_no'";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function isAlreadySentToProductionCareLabel($care_label_no)
    {
        $sql = "Select * From `tb_care_labels` WHERE pc_tracking_no='$care_label_no' and sent_to_production=0";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getCareLabelSentReport($date)
    {
        $sql = "SELECT t1.*, t2.*, DATE_FORMAT(t1.date_time, '%Y-%m-%d') as report_date FROM `tb_cut_scan` as t1
                Inner Join
                (SELECT cut_tracking_no ,COUNT(cut_tracking_no) as cut_tracking_no_qty FROM `tb_pc_detail` GROUP BY cut_tracking_no) as t2
                ON t1.cut_tracking_no=t2.cut_tracking_no
                WHERE DATE_FORMAT(t1.date_time, '%Y-%m-%d') LIKE '%$date%'";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getCutTrackingNoList()
    {
        $sql = "SELECT cut_tracking_no FROM `tb_pc_detail` GROUP BY cut_tracking_no";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function chk_lay($carelabel_tracking_no)
    {
        $sql = "SELECT * FROM `tb_cut_summary` WHERE is_lay_complete=1 AND cut_tracking_no='$carelabel_tracking_no'";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function inputToLay($cut_tracking_no, $table_no, $date_time)
    {
        $sql="UPDATE tb_cut_summary 
              SET is_lay_complete=1,
              cut_table='$table_no',
              lay_complete_date_time='$date_time'             
              WHERE cut_tracking_no = '$cut_tracking_no'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function inputToLayCareLabelTable($cut_tracking_no, $table_no)
    {
        $sql="UPDATE vt_few_days_po_pcs 
              SET cut_table='$table_no'       
              WHERE cut_tracking_no = '$cut_tracking_no'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function check_lay($carelabel_tracking_no)
    {
        $sql="SELECT *  FROM `tb_cut_summary` WHERE `cut_tracking_no` = '$carelabel_tracking_no' AND is_lay_complete=1";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function check_cut($carelabel_tracking_no)
    {
        $sql="SELECT *  FROM `tb_cut_summary` WHERE `cut_tracking_no` = '$carelabel_tracking_no' AND is_cutting_complete=1";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function inputToCut($carelabel_tracking_no, $date_time)
    {
        $sql="UPDATE tb_cut_summary SET is_cutting_complete=1,
                cutting_complete_date_time='$date_time'             
                WHERE cut_tracking_no = '$carelabel_tracking_no'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function getCutTrackingNo($sap_no, $cut_nos)
    {
        $sql="SELECT cut_tracking_no  FROM `tb_cut_summary` WHERE `po_no` = '$sap_no' AND cut_no='$cut_nos' GROUP BY cut_no";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getCareLabelSentReportNew()
    {
        $sql = "Select A.*, count(A.sent_to_production) as count_sent_to_prod, B.cut_tracking_no_qty 
                From (Select t1.pc_tracking_no, t1.po_no, t1.style_no, t1.cut_no, t1.cut_tracking_no, t1.size, t1.suff, 
                t1.bundle_range, t1.care_label_printed, t1.sent_to_production, t1.production_sending_date_time, 
                SUBSTRING_INDEX(SUBSTRING_INDEX(t1.cut_tracking_no, '_', -3), '_', 1) as color, 
                DATE_FORMAT(production_sending_date_time, '%Y-%m-%d') as production_sending_date, t2.brand, t2.item, 
                t2.quality, t2.ex_factory_date FROM `tb_pc_detail` as t1
                Inner Join `tb_po_detail` as t2
                On t1.po_no=t2.po_no and t1.style_no=t2.style_no 
                and SUBSTRING_INDEX(SUBSTRING_INDEX(t1.cut_tracking_no, '_', -3), '_', 1)=t2.color
                where sent_to_production=1 GROUP BY t1.po_no, t1.cut_tracking_no, t1.pc_tracking_no) as A
                INNER JOIN
                (SELECT cut_tracking_no,COUNT(cut_tracking_no) as cut_tracking_no_qty FROM `tb_pc_detail` GROUP BY cut_tracking_no) as B
                ON A.cut_tracking_no=B.cut_tracking_no
                GROUP BY A.cut_tracking_no";

//        $sql = "Select A.*, count(A.sent_to_production) as count_sent_to_prod, B.cut_tracking_no_qty
//                From (Select t1.pc_tracking_no, t1.po_no, t1.style_no, t1.cut_no, t1.cut_tracking_no, t1.size, t1.suff,
//                t1.bundle_range, t1.care_label_printed, t1.sent_to_production, t1.production_sending_date_time,
//                SUBSTRING_INDEX(SUBSTRING_INDEX(t1.cut_tracking_no, '_', -3), '_', 1) as color,
//                DATE_FORMAT(production_sending_date_time, '%Y-%m-%d') as production_sending_date, t2.brand, t2.item,
//                t2.quality, t2.ex_factory_date FROM `tb_pc_detail` as t1
//                Inner Join `tb_po_detail` as t2
//                On t1.po_no=t2.po_no and t1.style_no=t2.style_no
//                and SUBSTRING_INDEX(SUBSTRING_INDEX(t1.cut_tracking_no, '_', -3), '_', 1)=t2.color
//                where DATE_FORMAT(t1.production_sending_date_time, '%Y-%m-%d') LIKE '%$date%'
//                and sent_to_production=1 GROUP BY t1.po_no, t1.cut_tracking_no, t1.pc_tracking_no) as A
//                INNER JOIN
//                (SELECT cut_tracking_no,COUNT(cut_tracking_no) as cut_tracking_no_qty FROM `tb_pc_detail` GROUP BY cut_tracking_no) as B
//                ON A.cut_tracking_no=B.cut_tracking_no
//                GROUP BY A.cut_tracking_no";
//echo '<pre>';
//print_r($sql);
//echo '</pre>';
//        $sql = "SELECT t1.*, t2.*, DATE_FORMAT(t1.date_time, '%Y-%m-%d') as report_date FROM `tb_cut_scan` as t1
//                Inner Join
//                (SELECT cut_tracking_no ,COUNT(cut_tracking_no) as cut_tracking_no_qty FROM `tb_pc_detail` GROUP BY cut_tracking_no) as t2
//                ON t1.cut_tracking_no=t2.cut_tracking_no
//                WHERE DATE_FORMAT(t1.date_time, '%Y-%m-%d') LIKE '%$date%'";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getCareLabelList(){
//        $sql = "SELECT t1.*, t2.* FROM `tb_pc_detail` as t1
//                Inner Join
//                `tb_po_detail` as t2
//                ON t1.po_no=t2.po_no and t1.style_no=t2.style_no
//                and SUBSTRING_INDEX(SUBSTRING_INDEX(t1.cut_tracking_no, '_', -3), '_', 1)=t2.color and t1.size=t2.size";

        $sql = "SELECT * FROM `tb_care_labels`";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getCareLabelDetailByClNo($cl_no){
        $sql = "SELECT * FROM `vt_few_days_po_pcs` WHERE pc_tracking_no = '$cl_no'";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getCutPendingClReport($cut_tracking_no)
    {
        $sql = "SELECT * FROM `tb_pc_detail` 
                WHERE cut_tracking_no LIKE '%$cut_tracking_no%' and sent_to_production=0";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function updateReprintLog($pc_no,$date_time)
    {
        $sql = "UPDATE tb_care_labels SET is_reprint_allow=0,reprint_allow_date_time='$date_time' WHERE pc_tracking_no='$pc_no'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function isPrintedCL($care_label_no)
    {
        $sql = "SELECT * FROM `tb_care_labels` 
                WHERE pc_tracking_no = '$care_label_no' and is_printed=1";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function isPrintedBundle($bundle_tracking_no)
    {
        $sql = "SELECT * FROM `vt_running_po_pcs` 
                WHERE bundle_tracking_no LIKE '%$bundle_tracking_no%' and is_printed=1";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function sendingToProduction($cut_tracking_no, $date_time)
    {
        $sql = "INSERT INTO `tb_cut_scan`(`cut_tracking_no`, `u_id`, `date_time`) VALUES ('$cut_tracking_no', '', '$date_time')";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function sendingToProductionCareLabel($care_label_no, $date_time, $line_id)
    {
        $sql = "Update `tb_care_labels` 
                Set sent_to_production=1, access_points=1, access_points_status=1, 
                sent_to_production_date_time='$date_time', planned_line_id=$line_id
                WHERE pc_tracking_no = '$care_label_no'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function updateWashGmtStatus($where, $status)
    {
        $sql = "Update `tb_po_detail` 
                Set wash_gmt=$status
                WHERE 1 $where";

        $query = $this->db->query($sql);
        return $query;
    }

    public function updateLineTarget($line_id, $target_date, $set_fields)
    {
        $sql = "Update `line_daily_target` 
                $set_fields
                WHERE line_id='$line_id'
                AND `date`='$target_date'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function getSegmentWiseSMVs($line_id, $date, $min_start_time, $max_start_time){
        $sql = "SELECT t1.*, t2.so_no, t2.smv FROM 
                (SELECT po_no,so_no, purchase_order, item, quality, color, 
                DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') as line_date_format, 
                count(id) as total_line_output
                FROM `vt_few_days_po_pcs`
                WHERE DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') = '$date'
                AND line_id=$line_id
                AND DATE_FORMAT(end_line_qc_date_time, '%H:%i:%s') BETWEEN '$min_start_time' AND '$max_start_time'
                AND access_points_status=4
                GROUP BY po_no, so_no, purchase_order, item, quality, color) AS t1
                LEFT JOIN
                (SELECT * FROM `tb_po_detail` 
                GROUP BY po_no, so_no, purchase_order, item, quality, color) as t2
                ON t1.po_no=t2.po_no AND t1.purchase_order=t2.purchase_order 
                AND t1.item=t2.item AND t1.color=t2.color";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function updateFloorTarget($floor_id, $target, $target_hour, $mp, $target_date)
    {
        $sql = "Update `finishing_daily_target` 
                Set target='$target', target_hour='$target_hour',
                man_power='$mp'
                WHERE floor_id='$floor_id'
                AND `date`='$target_date'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function updateCuttingTarget($target, $mp, $target_date)
    {
        $sql = "Update `cutting_daily_target` 
                Set target='$target', man_power='$mp'
                WHERE `date`='$target_date'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function updateWashAllGmtStatus($where, $status)
    {
        $sql = "Update `tb_care_labels`
                Set is_wash_gmt=$status
                WHERE 1 $where";

        $query = $this->db->query($sql);
        return $query;
    }

    public function sendingToProductionBundle($bundle_tracking_no, $date_time)
    {
        $sql = "Update `vt_running_po_pcs` 
                Set sent_to_production=1, access_points=1, access_points_status=1, sent_to_production_date_time='$date_time'
                WHERE bundle_tracking_no LIKE '%$bundle_tracking_no%'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function bundleAssignToLine($bundle_tracking_no, $line_no)
    {
        $sql = "Update `tb_care_labels`
                Set line_id=$line_no
                WHERE bundle_tracking_no LIKE '%$bundle_tracking_no%' and line_id != 0";

        $query = $this->db->query($sql);

        return $query;
    }

    public function assignLineSizeWisePOs($purchase_order, $item, $color, $size, $line_no)
    {
        $sql = "Update `tb_care_labels` Set line_id=$line_no
                WHERE purchase_order LIKE '%$purchase_order%'
                AND item LIKE '%$item%' AND color LIKE '%$color%'
                AND size LIKE '%$size%'";

        $query = $this->db->query($sql);
        return $query;
    }

//    public function isSentToProduction($care_label_no)
//    {
//        $sql = "SELECT * FROM `tb_care_labels` WHERE pc_tracking_no='$care_label_no' and sent_to_production=1";
//
//        $query = $this->db->query($sql)->result_array();
//        return $query;
//    }

    public function getPOsForCuttingByPo($po_no)
    {
        $sql = "SELECT id, po_no, purchase_order, brand, item, style_no, style_name, size, quantity,
                quality, color, ex_factory_date 
                FROM `tb_po_detail`
                WHERE po_no LIKE '%$po_no%'";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getPoGetQuality($po_no)
    {
        $sql = "SELECT po_no, quality
                FROM `tb_po_detail`
                WHERE po_no LIKE '%$po_no%'
                Group By po_no, quality";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getPoInfoForCutting($po_no)
    {
        $sql = "SELECT * FROM `tb_po_detail` where po_no LIKE '%$po_no%'";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getLastPcTrackingNo()
    {
        $sql = "SELECT * FROM `tb_pc_detail` ORDER BY ID DESC LIMIT 1";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function isCareLabelPrinted($po_id)
    {
        $sql = "SELECT * FROM `tb_po_detail` WHERE id=$po_id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getPOCutListForCareLabel($where)
    {
        $sql = "Select t1.*, t2.remaining_qty 
                From
                (SELECT * FROM `vt_cut_summary` 
                WHERE 1 $where
                GROUP BY po_no, so_no, cut_tracking_no 
                ORDER BY po_no, so_no, cut_no) as t1
                LEFT JOIN
                (SELECT po_no, so_no, cut_tracking_no, 
                SUM(id) as remaining_qty 
                FROM `vt_few_days_po_pcs` 
                WHERE is_printed=0
                $where
                GROUP BY po_no, so_no, cut_tracking_no 
                ORDER BY po_no, so_no, cut_no) as t2
                ON t1.po_no=t2.po_no AND t1.so_no=t2.so_no 
                AND t1.cut_tracking_no=t2.cut_tracking_no";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function CareLabelPrinted($po_id, $flag)
    {
        $sql = "Update `tb_po_detail` set care_label_printed = $flag where id=$po_id";

        $query = $this->db->query($sql);
        return $query;
    }

    public function getCareLabelInfo($po_id)
    {
        $sql = "SELECT t1.pc_tracking_no, t2.po_no, t2.purchase_order, 
                t2.brand, t2.item, t2.style_no, t2.style_name, t2.quality, 
                t2.color, t2.quantity, t2.size FROM `tb_pc_detail` as t1
                
                INNER JOIN
                
                `tb_po_detail` as t2
                ON t1.po_id=t2.id
                
                WHERE t1.po_id=$po_id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getTotalCutQty($po_no){
        $sql = "SELECT SUM(cut_qty) as total_cut_qty 
                FROM `tb_cut_summary` 
                WHERE po_no='$po_no'";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function ProcessInOutData($mon_yr)
    {
        $sql = "SELECT * FROM `tb_vehicle_in_out_info` 
                where (date_format(date,'%Y-%m') between (Select date_format(date,'%Y-%m') 
                FROM `tb_vehicle_in_out_info` 
                where process_stage=0 Limit 1) AND '$mon_yr') 
                group by user_id
                order by user_id,date_time_str";
        
         $query = $this->db->query($sql)->result_array();
         return $query;
    }

    public function getTables()
    {
        $sql = "SELECT * FROM `tb_cut_table` where status=1";

         $query = $this->db->query($sql)->result_array();
         return $query;
    }

//    public function updatingCLPrintLogNew($sap_no, $purchase_order, $item_no, $cut_no, $date_time){
//        $sql = "Update `tb_care_labels` SET is_printed=1, printing_date_time='$date_time'
//                WHERE po_no='$sap_no' AND purchase_order='$purchase_order' AND item='$item_no' AND cut_no='$cut_no'";
//
//        $query = $this->db->query($sql);
//        return $query;
//    }

    public function updatingCLPrintLog($so_no, $cut_tracking_no, $date_time, $print_qty){
        $sql = "Update `tb_care_labels` SET is_printed=1, printing_date_time='$date_time' 
                WHERE so_no='$so_no' AND cut_tracking_no = '$cut_tracking_no' AND is_printed=0
                ORDER BY id DESC
                LIMIT $print_qty";

        $query = $this->db->query($sql);
        return $query;
    }

    public function updatingCLSummaryPrintLog($so_no, $cut_tracking_no, $date_time){
        $sql = "Update `tb_cut_summary` SET is_care_label_printed=1 
                WHERE so_no='$so_no' AND cut_tracking_no = '$cut_tracking_no'";

        $query = $this->db->query($sql);
        return $query;
    }

	public function isShortTimeDuplicatedEntry($user_id){
		$sql = "SELECT * FROM `tb_vehicle_in_out_info` where user_id=$user_id ORDER BY id DESC Limit 1";
        
        $query = $this->db->query($sql)->result_array();
        return $query;
	}

	public function getBundleSummary($sap_no, $cut_no){
//		$sql = "SELECT t1.* FROM (SELECT po_no, purchase_order, item, quality, style_no, style_name,
//                color, brand, cut_no, cut_tracking_no, size, cut_qty, cut_layer, SUM(cut_qty) as qty
//                FROM `tb_cut_summary` WHERE `po_no` = '$sap_no' AND cut_no='$cut_no'
//                GROUP BY po_no, purchase_order, item, cut_no, size, cut_layer) as t1
//                LEFT JOIN
//                `tb_size_serial` as t2
//                ON t1.size=t2.size
//                ORDER BY t2.serial, t1.cut_layer, t1.purchase_order, t1.item, t1.size, t1.cut_layer";

		$sql = "SELECT t1.* FROM (SELECT po_no, purchase_order, item, quality, style_no, style_name, 
                color, brand, ex_factory_date, cut_no, cut_tracking_no, size, cut_qty, cut_layer, SUM(cut_qty) as qty,
                is_lay_complete, is_cutting_complete
                FROM `tb_cut_summary` WHERE `po_no` = '$sap_no' AND cut_no='$cut_no'  
                GROUP BY po_no, cut_no, size, cut_layer) as t1
                LEFT JOIN
                `tb_size_serial` as t2
                ON t1.size=t2.size
                ORDER BY t2.serial, t1.cut_layer, t1.size, t1.cut_layer";

        $query = $this->db->query($sql)->result_array();
        return $query;
	}
	
	public function isDataAlreadyAvailable($user_id, $fp_card_no, $date, $time){
		$sql = "SELECT * FROM `tb_vehicle_in_out_info` where user_id='$user_id' and fp_card_no = '$fp_card_no' and date='$date' and time = '$time'";
        
         $query = $this->db->query($sql)->result_array();
         return $query;
	}
	
		
	public function isCardNumberCreated($fp_card_no){
		$sql = "SELECT * FROM tb_vehicle_cards where card_no='$fp_card_no'";
        
         $query = $this->db->query($sql)->result_array();
         return $query;
	}
	    
    public function isUserIDExist($user_id)
    {
        $sql = "SELECT * FROM  tb_vehicle_cards where user_id='$user_id'";
         $query = $this->db->query($sql)->result_array();
         return $query;
    }  
	    
    public function isCompanyExist($company)
    {
        $sql = "SELECT * FROM  tb_company where company_name like '%$company%'";
         $query = $this->db->query($sql)->result_array();
         return $query;
    }
		    
    public function isOldPasswordExist($employee_code, $oldpassword)
    {
		$emp_master_db = $this->load->database('emp_master', TRUE);
		
        $sql = "SELECT * FROM  tb_employee_master where employee_code = '$employee_code' and password = '$oldpassword'";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }
	 
    public function isCardNoExist($card_no)
    {
        $sql = "SELECT * FROM  tb_vehicle_cards where card_no='$card_no'";
         $query = $this->db->query($sql)->result_array();
         return $query;
    }

    public function getAllCompanies()
    {
        $sql = "SELECT * FROM `tb_company`";
        
         $query = $this->db->query($sql)->result_array();
         return $query;
    }

    public function getVehicleSizes()
    {
        $sql = "SELECT * FROM  `tb_vehicle_types`";
        
         $query = $this->db->query($sql)->result_array();
         return $query;
    }

    public function getAllVehicleCodes()
    {
        $sql = "SELECT t1.*,t2.company_name,t3.vehicle_type 
                FROM `tb_vehicle_cards` as t1 
                Inner Join `tb_company` as t2 on t1.company_id=t2.id
                Inner Join tb_vehicle_types as t3 on t1.vehicle_type_id=t3.id";
        
         $query = $this->db->query($sql)->result_array();
         return $query;
    }
	
	public function getYearsFromExsistingData()
    {
        $sql = "SELECT date_format(date,'%Y') as year FROM `tb_vehicle_in_out_info` group by date_format(date,'%Y')";
        
         $query = $this->db->query($sql)->result_array();
         return $query;
    }

	public function getLineDhuSummaryReport($date)
    {
        $sql = "SELECT t1.*, t2.id, t2.line_code FROM 
                (SELECT line_id, SUM(dhu) AS sum_of_dhu 
                FROM `tb_today_line_output_qty` 
                WHERE date='$date' 
                GROUP BY line_id) AS t1
                
                LEFT JOIN
                tb_line AS t2
                ON t1.line_id=t2.id
                ORDER BY (t2.line_code * 1)";

         $query = $this->db->query($sql)->result_array();
         return $query;
    }

    public function getAllTbl($tbl)
    {
        $this->db->select('*');
        $this->db->from($tbl);
        $query=  $this->db->get();
        $result=$query->result_array();
        return $result;
    }
    
    public function getInOutDataToProcess($user_id, $mon_yr)
    {
      
        $sql = "SELECT * FROM `tb_vehicle_in_out_info` 
                where (date_format(date,'%Y-%m') between (Select date_format(date,'%Y-%m') 
                FROM `tb_vehicle_in_out_info` 
                where process_stage=0 Limit 1) AND '$mon_yr')
                and user_id = $user_id
                order by user_id,date_time_str";
        
         $query = $this->db->query($sql)->result_array();
         return $query;
//         return $sql;
//         return $user_id;
    }
    
    public function getVehicleInOutReportData($mon_yr, $company)
    {
		$where = '';
        if($company != ''){
            $where .= " and t1.user_name Like '%$company%'";
        }

		if($mon_yr != '1970-01'){
		   $where .= " and date_format(t1.date,'%Y-%m') = '$mon_yr'";
		}
		
        $sql = "Select t1.id as in_id,t1.user_id,t1.user_name,t1.fp_card_no,t1.date as in_date,
        t1.time as in_time,t1.flag as in_flag,
        t1.process_stage as in_stage_flag, t1.date_time_str as in_date_time_str,
        t2.id as out_id,t2.user_id,t2.date as out_date,t2.time as out_time,
        t2.flag as out_flag,t2.process_stage as out_stage_flag, t2.date_time_str as out_date_time_str,
        CONCAT(t1.date,' ',t1.time) AS in_date_time, CONCAT(t2.date,' ',t2.time) AS out_date_time, 
        t3.vehicle_type_id, t4.vehicle_type, CONCAT(t1.id,',',t2.id) as ids
        From 
        (SELECT * FROM tb_vehicle_in_out_info 
        where (date_format(date,'%Y-%m') between (Select date_format(date,'%Y-%m') FROM `tb_vehicle_in_out_info` 
        where process_stage=0 Limit 1) and '$mon_yr')  AND flag = 1 and process_stage=1) as t1

        Inner Join

        (SELECT * FROM tb_vehicle_in_out_info 
        where (date_format(date,'%Y-%m') between (Select date_format(date,'%Y-%m')  FROM `tb_vehicle_in_out_info` 
        where process_stage=0 Limit 1) and '$mon_yr')  AND flag = 2 and process_stage=1) as t2

        On t1.user_id = t2.user_id and CONCAT(t1.date,' ',t1.time) < CONCAT(t2.date,' ',t2.time)

        Left Join 

        tb_vehicle_cards as t3 On t1.user_id=t3.user_id and t1.fp_card_no=t3.card_no

        Left Join 

        tb_vehicle_types as t4 On t4.id=t3.vehicle_type_id
        where 1 $where
        group by t1.user_id,t1.date,t1.time
        Order By t1.user_id";

         $query = $this->db->query($sql)->result_array();
         return $query;
//         echo $sql;
    }
	
	
    public function getVehicleInOutData($mon_yr)
    {
		
        $sql = "Select t1.id as in_id,t1.user_id,t1.user_name,t1.fp_card_no,t1.date as in_date,t1.time as in_time,t1.flag as in_flag,
        t1.process_stage as in_stage_flag, t1.date_time_str as in_date_time_str,
        t2.id as out_id,t2.user_id,t2.date as out_date,t2.time as out_time,
        t2.flag as out_flag,t2.process_stage as out_stage_flag, t2.date_time_str as out_date_time_str,
        CONCAT(t1.date,' ',t1.time) AS in_date_time, CONCAT(t2.date,' ',t2.time) AS out_date_time, 
        t3.vehicle_type_id, t4.vehicle_type, CONCAT(t1.id,',',t2.id) as ids
        From 
        (SELECT * FROM tb_vehicle_in_out_info 
        where (date_format(date,'%Y-%m') between (Select date_format(date,'%Y-%m') FROM `tb_vehicle_in_out_info` where process_stage=0 Limit 1) and '$mon_yr')  AND flag = 1 and process_stage=0) as t1

        Inner Join

        (SELECT * FROM tb_vehicle_in_out_info 
        where (date_format(date,'%Y-%m') between (Select date_format(date,'%Y-%m')  FROM `tb_vehicle_in_out_info` where process_stage=0 Limit 1) and '$mon_yr')  AND flag = 2 and process_stage=0) as t2

        On t1.user_id = t2.user_id and CONCAT(t1.date,' ',t1.time) < CONCAT(t2.date,' ',t2.time)

        Left Join 

        tb_vehicle_cards as t3 On t1.user_id=t3.user_id and t1.fp_card_no=t3.card_no

        Left Join 

        tb_vehicle_types as t4 On t4.id=t3.vehicle_type_id
        group by t1.user_id,t1.date,t1.time
        Order By t1.user_id";
        
         $query = $this->db->query($sql)->result_array();
         return $query;
//         echo $sql;
    }
    
    public function getVehicleCostData($staying_time, $vehicle_type_id)
    {
	$sql = "Select B.*,C.vehicle_type_id,C.cost,C.high_time_id 
                From (Select A.* From (SELECT t1.*,IF(t2.highest_staying_time IS NULL, '00:00:00', 
                t2.highest_staying_time) as starting_time FROM `tb_time_conditions` as t1 
                left Join `tb_time_conditions` as t2 on t1.starting_time_id=t2.id) as A 
                where '$staying_time' between A.starting_time and A.highest_staying_time) as B 
                Inner Join
                tb_vehicle_type_cost as C On C.vehicle_type_id=$vehicle_type_id and C.high_time_id=B.id";
        
        $query = $this->db->query($sql)->result_array();
        return $query;
//        return $sql;
    }

    public function isCCUpdatedAlready($bundle_tracking_no)
    {
	$sql = "Select * From `vt_cut_summary`
            WHERE bundle_tracking_no='$bundle_tracking_no'";

        $query = $this->db->query($sql)->result_array();
        return $query;
//        return $sql;
    }

    public function todayManualUploadedList($date)
    {
	$sql = "Select *, SUM(quantity) AS total_order_qty From `tb_po_detail`
            WHERE upload_date='$date' AND is_manual_upload=1
            GROUP BY so_no, po_no, purchase_order, item, quality, color, upload_date";

        $query = $this->db->query($sql)->result_array();
        return $query;
//        return $sql;
    }

    public function isCollarUpdatedAlready($bundle_tracking_no)
    {
	$sql = "Select * From `tb_cut_summary`
            WHERE bundle_tracking_no LIKE '%$bundle_tracking_no%'";

        $query = $this->db->query($sql)->result_array();
        return $query;
//        return $sql;
    }

    public function getLineTargetinfo($target_date, $line_id)
    {
	    $sql = "SELECT * FROM `line_daily_target` WHERE `date`='$target_date' AND line_id=$line_id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getWashGoingReport($where)
    {
//	$sql = "SELECT po_no, purchase_order, item, brand, style_no, style_name,
//            quality, color, COUNT(id) as wash_going_qty
//
//            FROM `tb_care_labels`
//            WHERE is_going_wash=1 AND wash_going_printed=0 $where
//            GROUP BY po_no, purchase_order, item, quality, color";

	$sql = "SELECT t1.po_no, t1.purchase_order, t1.item, t1.brand, t1.style_no, t1.style_name, 
            t1.quality, t1.color, t1.wash_going_qty, t2.total_order_qty, t3.already_went_wash_qty
                         
            FROM 
            (Select po_no, purchase_order, item, brand, style_no, style_name, 
            quality, color, COUNT(id) as wash_going_qty FROM `tb_care_labels` 
             WHERE is_going_wash=1 AND wash_going_printed=0
            $where
            GROUP BY po_no, purchase_order, item, quality, color) as t1
            
            Left JOIN
            (Select *, SUM(quantity) as total_order_qty FROM tb_po_detail 
             GROUP BY po_no, purchase_order, item, quality, color) as t2
            ON t1.po_no=t2.po_no AND t1.purchase_order=t2.purchase_order 
            AND t1.item=t2.item AND t1.quality=t2.quality AND t1.color=t2.color
            
            LEFT JOIN
            (SELECT *, COUNT(id) as already_went_wash_qty FROM `tb_care_labels` 
            WHERE is_going_wash=1 AND wash_going_printed=1
            GROUP BY po_no, purchase_order, item, quality, color) as t3
            ON t1.po_no=t3.po_no AND t1.purchase_order=t3.purchase_order 
            AND t1.item=t3.item AND t1.quality=t3.quality AND t1.color=t3.color";

    $query = $this->db->query($sql)->result_array();
    return $query;
//        return $sql;
    }
    
    public function updateFinalProcessFlag($ids, $flag)
    {
        $sql = "Update `tb_vehicle_in_out_info` set process_stage = $flag
               where id in ($ids)";

        $query = $this->db->query($sql);
        return $query;
    }

    public function updateWashPrintedPcs($from_dt, $to_dt, $wash_going_status, $date_time)
    {
        $sql = "Update `tb_care_labels` SET wash_going_printed = $wash_going_status, 
                wash_going_print_date_time='$date_time'
                WHERE (date_format(going_wash_scan_date_time, '%Y-%m-%d') BETWEEN '$from_dt' AND '$to_dt') 
                AND is_going_wash=1
                AND  wash_going_printed=0";

        $query = $this->db->query($sql);
        return $query;
    }

    public function updateLineFinishingAlter($carelabel_tracking_no, $date_time)
    {
        $sql = "Update `vt_running_po_pcs` 
                SET finishing_qc_status = 3, 
                finishing_qc_date_time='$date_time'
                WHERE pc_tracking_no='$carelabel_tracking_no'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function inputToLine($carelabel_tracking_no, $line_id, $access_points, $access_point_status, $date_time)
    {
        $sql = "Update `tb_care_labels` 
                SET line_id = $line_id, 
                access_points = 2,
                access_points_status = 1,
                line_input_date_time = '$date_time'
                WHERE pc_tracking_no = '$carelabel_tracking_no'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function collarCuffTracking($bundle_tracking_no, $line_id, $date_time)
    {
        $sql = "Update `vt_cut_summary` 
                SET line_id = $line_id, 
                is_bundle_collar_cuff_scanned_line = 1,
                bundle_collar_cuff_scanned_line_date_time = '$date_time'
                where bundle_tracking_no = '$bundle_tracking_no'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function collarTracking($bundle_tracking_no, $line_id, $date_time)
    {
        $sql = "Update `vt_cut_summary` 
                SET is_bundle_collar_scanned_line = 1, line_id=$line_id,
                bundle_collar_scanned_datetime = '$date_time',
                bundle_collar_cuff_scanned_line_date_time = '$date_time'
                where bundle_tracking_no = '$bundle_tracking_no'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function updateSOofPoItem($where, $po_no)
    {
        $sql = "Update `tb_po_detail`
                SET po_no = '$po_no'
                where 1 $where";

        $query = $this->db->query($sql);
        return $query;
    }

    public function updateCutSummarySOofPoItem($where, $po_no)
    {
        $sql = "Update `tb_cut_summary`
                SET po_no = '$po_no'
                where 1 $where";

        $query = $this->db->query($sql);
        return $query;
    }

    public function updateCareLabelsSOofPoItem($where, $po_no)
    {
        $sql = "Update `tb_care_labels`
                SET po_no = '$po_no'
                where 1 $where";

        $query = $this->db->query($sql);
        return $query;
    }

    public function cuffTracking($bundle_tracking_no, $line_id, $date_time)
    {
        $sql = "Update `vt_cut_summary` 
                SET is_bundle_cuff_scanned_line = 1, line_id=$line_id,
                bundle_cuff_scanned_datetime = '$date_time',
                bundle_collar_cuff_scanned_line_date_time = '$date_time'
                where bundle_tracking_no = '$bundle_tracking_no'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function midLineQC($carelabel_tracking_no, $access_points, $access_point_status, $date_time)
    {
//        $sql = "Update `tb_care_labels`
//                SET
//                access_points = $access_points,
//                access_points_status = $access_point_status,
//                mid_line_qc_date_time = '$date_time'
//                where pc_tracking_no = '$carelabel_tracking_no'";

        $sql = "Update `tb_care_labels` 
                SET 
                access_points = $access_points,
                access_points_status = $access_point_status,
                mid_line_qc_date_time = '$date_time'
                where pc_tracking_no = '$carelabel_tracking_no'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function endLineQC($carelabel_tracking_no, $access_points, $access_point_status, $date_time)
    {
//        $sql = "Update `tb_care_labels`
//                SET
//                access_points = '$access_points',
//                access_points_status = '$access_point_status',
//                end_line_qc_date_time = '$date_time'
//                where pc_tracking_no = '$carelabel_tracking_no'";

        $sql = "Update `tb_care_labels`
                SET 
                access_points = '$access_points',
                access_points_status = '$access_point_status',
                end_line_qc_date_time = '$date_time'
                where pc_tracking_no = '$carelabel_tracking_no'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function finishingQC($carelabel_tracking_no, $finishing_qc_status, $date_time)
    {
        $sql = "Update `tb_care_labels` 
                SET 
                finishing_qc_status = $finishing_qc_status,
                finishing_qc_date_time = '$date_time'
                where pc_tracking_no = '$carelabel_tracking_no'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function goingWash($carelabel_tracking_no, $status, $date_time)
    {
        $sql = "Update `vt_running_po_pcs` 
                SET 
                is_going_wash = $status,
                going_wash_scan_date_time = '$date_time'
                where pc_tracking_no = '$carelabel_tracking_no'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function washReturn($carelabel_tracking_no, $status, $date_time)
    {
        $sql = "Update `tb_care_labels`
                SET 
                washing_status = $status,
                washing_date_time = '$date_time'
                where pc_tracking_no = '$carelabel_tracking_no'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function packingShirt($carelabel_tracking_no, $status, $floor_id, $date_time)
    {
        $sql = "Update `tb_care_labels` 
                SET 
                packing_status = $status,
                packing_date_time = '$date_time',
                finishing_floor_id = '$floor_id'

                WHERE pc_tracking_no = '$carelabel_tracking_no'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function getFinishingFloorOutputReport($where, $where2){
        $sql = "SELECT t1.*, t2.finishing_output_qty, t2.finishing_floor_id 
                FROM 
                (SELECT * From `tb_floor` WHERE status=1 $where) as t1
                LEFT JOIN
                (Select COUNT(id) as finishing_output_qty, finishing_floor_id 
                From `vt_few_days_po_pcs`
                WHERE 1 $where2
                GROUP BY finishing_floor_id) as t2
                ON t1.id=t2.finishing_floor_id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getFinishingQcSummaryReload($where){
        $sql = "Select COUNT(id) as finishing_alter_qty, finishing_floor_id 
                From `vt_few_days_po_pcs`
                WHERE 1 $where
                GROUP BY finishing_floor_id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getLineFinishingQcSummaryReload($where){
        $sql = "Select COUNT(id) as finishing_alter_qty, line_id, finishing_floor_id 
                From `vt_few_days_po_pcs`
                WHERE 1 $where
                GROUP BY line_id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getAqlSummaryList($date){
        $sql = "SELECT t0.brand, t1.today_plan_aql_count, t2.previous_due_aql_count, 
                t3.today_plan_aql_pass_count, t4.previous_due_aql_pass_count,
                t5.today_plan_aql_fail_count, t6.previous_due_aql_fail_count,
                t7.previous_due_aql_action_today_count
                
                FROM 
                (SELECT brand FROM `tb_po_detail` GROUP BY brand) AS t0

                LEFT JOIN
                (SELECT A.brand, COUNT(A.so_no) AS today_plan_aql_count 
                FROM (SELECT brand, so_no FROM `tb_po_detail` 
                WHERE aql_plan_date!='0000-00-00'
                AND aql_plan_date='$date'
                AND aql_status IN (0, 1, 2)
                GROUP BY brand, so_no) AS A 
                GROUP BY A.brand) AS t1
                ON t0.brand=t1.brand
                
                LEFT JOIN
                (SELECT B.brand, COUNT(B.so_no) AS previous_due_aql_count 
                FROM (SELECT brand, so_no FROM `tb_po_detail` 
                WHERE aql_plan_date!='0000-00-00'
                AND aql_plan_date<'$date'
                AND aql_status IN (0, 2)
                GROUP BY brand, so_no) AS B 
                GROUP BY B.brand) AS t2
                ON t0.brand=t2.brand
                
                LEFT JOIN
                (SELECT C.brand, COUNT(C.so_no) AS today_plan_aql_pass_count 
                FROM (SELECT brand, so_no FROM `tb_po_detail` 
                WHERE aql_plan_date!='0000-00-00'
                AND aql_plan_date='$date'
                AND aql_status IN (1)
                GROUP BY brand, so_no) AS C 
                GROUP BY C.brand) AS t3
                ON t0.brand=t3.brand
                                     
                LEFT JOIN
                (SELECT F.brand, COUNT(F.so_no) AS previous_due_aql_pass_count 
                FROM (SELECT brand, so_no FROM `tb_po_detail` 
                WHERE aql_plan_date!='0000-00-00'
                AND aql_plan_date<'$date'
                AND aql_status IN (1)
                AND aql_action_date='$date'
                GROUP BY brand, so_no) AS F 
                GROUP BY F.brand) AS t4
                ON t0.brand=t4.brand
                    
                LEFT JOIN
                (SELECT E.brand, COUNT(E.so_no) AS today_plan_aql_fail_count 
                FROM (SELECT brand, so_no FROM `tb_po_detail` 
                WHERE aql_plan_date!='0000-00-00'
                AND aql_plan_date='$date'
                AND aql_status IN (2)
                GROUP BY brand, so_no) AS E 
                GROUP BY E.brand) AS t5
                ON t0.brand=t5.brand
                                
                LEFT JOIN
                (SELECT F.brand, COUNT(F.so_no) AS previous_due_aql_fail_count 
                FROM (SELECT brand, so_no FROM `tb_po_detail` 
                WHERE aql_plan_date!='0000-00-00'
                AND aql_plan_date<'$date'
                AND aql_status IN (2)
                GROUP BY brand, so_no) AS F 
                GROUP BY F.brand) AS t6
                ON t0.brand=t6.brand
                
                LEFT JOIN
                (SELECT G.brand, COUNT(G.so_no) AS previous_due_aql_action_today_count 
                FROM (SELECT brand, so_no FROM `tb_po_detail` 
                WHERE aql_plan_date!='0000-00-00'
                AND aql_plan_date<'$date'
                AND aql_status IN (0, 2)
                GROUP BY brand, so_no) AS G 
                GROUP BY G.brand) AS t7
                ON t0.brand=t7.brand";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getAqlTargetList($date, $brand){
        $sql = "SELECT so_no, purchase_order, item, quality, color, style_no, 
                style_name, brand, ex_factory_date, SUM(quantity) AS order_qty, 
                aql_plan_date, aql_status, aql_remarks 
                FROM `tb_po_detail` 
                WHERE aql_plan_date!='0000-00-00'
                AND aql_plan_date='$date'
                AND brand='$brand'
                AND aql_status IN (0, 1, 2)
                GROUP BY brand, so_no";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getDueAqlTargetList($date, $brand){
        $sql = "SELECT so_no, purchase_order, item, quality, color, style_no,style_name, 
                brand, ex_factory_date, SUM(quantity) AS order_qty, 
                aql_plan_date, aql_status, aql_remarks
                FROM `tb_po_detail` 
                WHERE aql_plan_date!='0000-00-00'
                AND aql_plan_date<'$date'
                AND brand='$brand'
                AND aql_status IN (0, 2)
                GROUP BY brand, so_no

                UNION

                SELECT so_no, purchase_order, item, quality, color, style_no,style_name, 
                brand, ex_factory_date, SUM(quantity) AS order_qty, 
                aql_plan_date, aql_status, aql_remarks
                FROM `tb_po_detail`
                WHERE aql_plan_date!='0000-00-00'
                AND aql_plan_date<'$date'
                AND aql_action_date='$date'
                AND brand='$brand'
                AND aql_status IN (0, 1, 2)
                GROUP BY brand, so_no";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function cartonShirt($carelabel_tracking_no, $status, $date_time, $floor_id)
    {
        $sql = "Update `tb_care_labels` 
                SET 
                carton_status = $status,
                finishing_floor_id = $floor_id,
                carton_date_time = '$date_time'
                where pc_tracking_no = '$carelabel_tracking_no'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function warehouseRelease($carelabel_tracking_no, $status)
    {
        $sql = "Update `tb_care_labels` 
                SET 
                warehouse_qa_type = $status
                where pc_tracking_no = '$carelabel_tracking_no'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function updateSmv($sales_order, $smv, $smv_set_date_time)
    {
        $sql = "Update `tb_po_detail` 
                SET 
                smv = '$smv',
                smv_set_date_time= '$smv_set_date_time'
                where so_no = '$sales_order'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function getSizesbyShipDate($where){
        $sql = "SELECT * FROM `tb_po_detail` 
                WHERE 1 $where 
                GROUP BY `size`";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getPOsbyShipDate($where){
        $sql = "SELECT * FROM `tb_po_detail` 
                WHERE 1 $where 
                GROUP BY so_no";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getPoSizeWiseCartonReport($where){
        $sql = "SELECT so_no, size, count(id) AS count_size_carton_qty 
                FROM `tb_care_labels` 
                WHERE carton_status=1 $where 
                GROUP BY so_no";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

	public function update_password($employee_code, $confirm_new_password){
		$emp_master_db = $this->load->database('emp_master', TRUE);
		
		$sql = "Update tb_employee_master set password = $confirm_new_password
               where employee_code='$employee_code'";

        $query = $this->db->query($sql);
        return $query;
	}

    public function updateTbl($tbl, $id, $data)
    {
        $this->db->where('id', $id);
        $query = $this->db->update($tbl, $data);

        return $query;
    }

    public function updateTblNew($tbl, $match_to_column, $value_to_match, $data)
    {
        $this->db->where($match_to_column, $value_to_match);
        $query = $this->db->update($tbl, $data);

        return $query;
    }

    // Manual Closing Start

    public function getAllPo()
    {
        $sql="SELECT * FROM `tb_po_detail` GROUP BY so_no";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getAllSo()
    {
        $sql="SELECT * FROM `tb_care_labels` GROUP BY so_no";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getTotalScannedQty($where){
        $sql="SELECT line_id, COUNT(id) AS line_scan_qty, cut_no 
              FROM `tb_care_labels` 
              WHERE 1 $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getAllSizesByCutNo($so_no, $cut_no){
        $sql="SELECT so_no, cut_no, `size`
              FROM `tb_cut_summary` 
              WHERE `so_no` = '$so_no' 
              AND cut_no='$cut_no'
              GROUP BY so_no, cut_no, `size`";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getCutSizeWiseGroups($so_no, $cut_no, $size){
        $sql="SELECT so_no, cut_no, `size`, cut_layer
              FROM `tb_cut_summary` 
              WHERE `so_no` = '$so_no' 
              AND cut_no='$cut_no'
              AND `size`='$size'
              GROUP BY so_no, cut_no, `size`, cut_layer";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function changingLinePlan($line_no_to, $where){
        $sql="UPDATE `tb_care_labels` 
              SET line_id='$line_no_to'
              WHERE 1 $where";

        $query = $this->db->query($sql);
        return $query;
    }

    public function chk_purchase_order($where)
    {
        $sql="SELECT purchase_order FROM tb_care_labels WHERE 1 $where 
              GROUP BY po_no,so_no, purchase_order";
        $query = $this->db->query($sql)->result();
        return $query;
    }

    public function chk_item_order($where)
    {
        $sql="SELECT item FROM `tb_care_labels` WHERE 1 $where 
          GROUP BY po_no,so_no, purchase_order, item";
        $query = $this->db->query($sql)->result();
        return $query;
    }

    public function chk_quality($where)
    {
        $sql="SELECT quality FROM `tb_care_labels` WHERE 1 $where 
            GROUP BY po_no,so_no,purchase_order,item,quality";
        $query = $this->db->query($sql)->result();
        return $query;
    }

    public function chk_color($where)
    {
        $sql="SELECT color FROM `tb_care_labels`
        WHERE 1 $where  GROUP BY po_no,so_no,purchase_order,item,quality,color";
        $query = $this->db->query($sql)->result();
        return $query;
    }

    public function search_manual_closing_report($where)
    {
        $sql="SELECT * FROM `tb_care_labels` WHERE 1 $where 
        AND carton_status=0 AND warehouse_qa_type=0";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function chk_wsh_gmt($so_no)
    {
        $sql="select * from tb_care_labels WHERE  so_no='$so_no' GROUP BY so_no, is_wash_gmt";
        $query = $this->db->query($sql)->result();
        return $query;
    }

    public function selectTableDataRowQuery($fields, $table_name, $where){
        $sql="SELECT $fields FROM $table_name WHERE 1 $where";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function manualClosedById($p_id)
    {
        $sql="select * from tb_care_labels where id=$p_id";
        $query=$this->db->query($sql)->result_array();
        return $query;
    }
    public function getWashInfo($where)
    {
        $sql="SELECT po_no, so_no, purchase_order, item, quality, color, style_no,
        style_name, ex_factory_date, is_wash_gmt
        FROM `tb_care_labels`
        WHERE 1 $where
        GROUP BY po_no, so_no, purchase_order, item, quality, color,is_wash_gmt";

        $query=$this->db->query($sql)->result_array();
        return $query;
    }
    public function update_care_labels($data, $p_id)
    {
        $this->db->where('id',$p_id);
        $this->db->update('tb_care_labels',$data);
    }


    // Manual Closing End

}

?>