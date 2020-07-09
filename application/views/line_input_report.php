<!--\\\\\\\ contentpanel start\\\\\\-->
    <div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
            <h1>Line Input Report of <?php echo $date;?></h1>
            <h2 class="">Line Input Report...</h2>
        </div>
        <div class="pull-right">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#">DASHBOARD</a></li>
                <li class="active">Line Input Report</li>
            </ol>
        </div>
    </div>
    <div class="container clear_both padding_fix">
        <!--\\\\\\\ container  start \\\\\\-->
<!--        <div class="row">-->
<!--            <div class="form-group">-->
<!--                <div class="col-md-12">-->
<!--                <div class="col-md-3">-->
<!--                    <div class="form-group">-->
<!--                        <select required class="form-control" id="po_no" name="po_no" onchange="getReportByPo(id);">-->
<!--                                <option value="">Select PO No...</option>-->
<!--                            --><?php
//                                foreach ($purchase_order_nos as $pos){ ?>
<!--                                    <option value="--><?php //echo $pos['purchase_order'].'_'.$pos['item'].'_'.$pos['color'];?><!--">--><?php //echo $pos['purchase_order'].'-'.$pos['item'].'-'.$pos['color'];?><!--</option>-->
<!--                            --><?php
//                                }
////                            ?>
<!--                        </select>-->
<!--                        <span style="font-size: 11px;">* Select PO No.</span>-->
<!--                    </div>-->
<!--                </div>-->
<!---->
<!---->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <br />-->

        <div class="row" id="report_content">
            <?php
            foreach ($line_input_report as $v){
                $line_id = $v['line_id'];
                $line_name = $v['line_name'];
                $floor_name = $v['floor_name'];
                $count_qty_line = $v['count_qty_line'];
                $count_wip_qty = $v['count_wip_qty'];
                $count_mid_line_qc_pass = $v['count_mid_line_qc_pass'];
                $count_mid_line_qc_defect = $v['count_mid_line_qc_defect'];
                $count_mid_line_qc_reject = $v['count_mid_line_qc_reject'];
                $count_end_line_qc_pass = $v['count_end_line_qc_pass'];
                $count_end_line_qc_defect = $v['count_end_line_qc_defect'];
                $count_end_line_qc_reject = $v['count_end_line_qc_reject'];
                $line_input_date = $v['line_input_date'];

                ?>
            <div class="col-lg-12">
                <section class="panel default blue_title h2">

                    <div class="panel-body">

                        <table class="table" border="1">
                            <thead>
                            <tr>
                                <th class="center" colspan="4"></th>
                                <th class="center" colspan="3">Mid-QC</th>
                                <th class="center" colspan="3">End-QC</th>
<!--                                <th class="center">Date</th>-->
                            </tr>
                            <tr>
                                    <th class="center">Line</th>
                                    <th class="center">Floor</th>
                                    <th class="center">Input Qty</th>
                                    <th class="center">WIP Qty</th>
                                    <th class="center">Pass Qty</th>
                                    <th class="center">Defect Qty</th>
                                    <th class="center">Reject Qty</th>
                                    <th class="center">Pass Qty</th>
                                    <th class="center">Defect Qty</th>
                                    <th class="center">Reject Qty</th>
<!--                                    <th class="center">Date</th>-->
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="center"><?php echo $line_name;?></td>
                                    <td class="center"><?php echo $floor_name;?></td>
                                    <td class="center"><a class="btn btn-primary" target="_blank" href="<?php echo base_url();?>access/lineInputQty/<?php echo $line_id;?>"><?php echo ($count_qty_line == '' ? "0" : $count_qty_line);?></a></td>
                                    <td class="center"><a class="btn btn-default" target="_blank" href="<?php echo base_url();?>access/lineWipQty/<?php echo $line_id;?>"><?php echo ($count_wip_qty == '' ? "0" : $count_wip_qty);?></a></td>
                                    <td class="center"><a class="btn btn-success" target="_blank" href="<?php echo base_url();?>access/midQcPass/<?php echo $line_id;?>"><?php echo ($count_mid_line_qc_pass == '' ? "0" : $count_mid_line_qc_pass);?></a></td>
                                    <td class="center"><a class="btn btn-warning" target="_blank" href="<?php echo base_url();?>access/midQcDefects/<?php echo $line_id;?>"><?php echo ($count_mid_line_qc_defect == '' ? "0" : $count_mid_line_qc_defect);?></a></td>
                                    <td class="center"><a class="btn btn-danger" target="_blank" href="<?php echo base_url();?>access/midQcRejects/<?php echo $line_id;?>"><?php echo ($count_mid_line_qc_reject == '' ? "0" : $count_mid_line_qc_reject);?></a></td>
                                    <td class="center"><a class="btn btn-success" target="_blank" href="<?php echo base_url();?>access/endQcPass/<?php echo $line_id;?>"><?php echo ($count_end_line_qc_pass == '' ? "0" : $count_end_line_qc_pass);?></a></td>
                                    <td class="center"><a class="btn btn-warning" target="_blank" href="<?php echo base_url();?>access/endQcDefects/<?php echo $line_id;?>"><?php echo ($count_end_line_qc_defect == '' ? "0" : $count_end_line_qc_defect);?></a></td>
                                    <td class="center"><a class="btn btn-danger" target="_blank" href="<?php echo base_url();?>access/endQcRejects/<?php echo $line_id;?>"><?php echo ($count_end_line_qc_reject == '' ? "0" : $count_end_line_qc_reject);?></a></td>
<!--                                    <td class="center">--><?php //echo $line_input_date;?><!--</td>-->
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
            <?php
            }
            ?>
    </div>
    <!--\\\\\\\ container  end \\\\\\-->

<script type="text/javascript">
//    $('select').select2();

        setTimeout(function(){
            window.location.reload(1);
        }, 3000);
</script>