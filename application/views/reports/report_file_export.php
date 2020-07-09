<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $title ?></title>
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
    <script src="<?php echo base_url(); ?>assets/js/jquery-latest.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/css/jquery-1.9.0.js"></script>
    <link href="<?php echo base_url(); ?>assets/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/animate.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/admin.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/bootstrap-timepicker/compiled/timepicker.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/bootstrap-colorpicker/css/colorpicker.css" />
    <link href="<?php echo base_url(); ?>assets/plugins/data-tables/DT_bootstrap.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/plugins/advanced-datatable/css/demo_table.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/plugins/advanced-datatable/css/demo_page.css" rel="stylesheet" />

    <!--Select2 Start-->
    <script src="<?php echo base_url(); ?>assets/select2/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/select2/select2.min.js"></script>
    <link href="<?php echo base_url(); ?>assets/select2/select2.min.css" rel="stylesheet"/>

    <style type="text/css">

        .has-error .select2-selection {
            /*border: 1px solid #a94442;
            border-radius: 4px;*/
            border-color:rgb(185, 74, 72) !important;
        }

        div.scroll {
            /*background-color: #00FFFF;*/
            width: 1900px;
            height: 500px;
            overflow: scroll;
        }

        div.scroll2 {
            /*background-color: #00FFFF;*/
            width: 1200px;
            height: 500px;
            overflow: scroll;
        }

        div.scroll3 {
            /*background-color: #00FFFF;*/
            width: 700px;
            height: 500px;
            overflow: scroll;
        }

        div.scroll4 {
            /*background-color: #00FFFF;*/
            width: 520px;
            height: 300px;
            overflow: scroll;
        }
        /*table thead fixed*/
        .table-fixed thead {
            width: 100%;
        }
        .table-fixed tbody {
            height: 230px;
            overflow-y: auto;
            width: 100%;
        }
        .table-fixed thead, .table-fixed tbody, .table-fixed tr, .table-fixed td, .table-fixed th {
            display: block;
        }
        .table-fixed tbody td, .table-fixed thead > tr> th {
            float: left;
            border-bottom-width: 0;
        }
        /*table thead fixed*/

        .well1 {
            background: none;
            height: 400px;
        }

        .well {
            background: none;
            height: 600px;
        }

        .table-scroll tbody {
            position: absolute;
            overflow-y: scroll;
            height: 450px;
        }

        .table-scroll tr {
            width: 100%;
            table-layout: fixed;
            display: inline-table;
        }

        .table-scroll thead > tr > th {
            /*border: none;*/
        }
    </style>
    <!--Select2 End-->
</head>
<body style="background-color: #FFFFFF;">
<div class="container clear_both padding_fix">
    <!--\\\\\\\ container  start \\\\\\-->
    <div class="header">
        <div class="actions"> <button class="btn btn-primary" style="color: #FFF;" id="btnExport"><b>Export Excel</b></button> </div>
    </div>

    <div class="row">

        <div  id="reload_div">
            <div class="col-md-12 well1" id="tableWrap">
                <table class="" border="1">
                    <thead>
                    <tr>
                        <th class="" colspan="6" style="width: 42.8%"></th>
                        <th class="" colspan="3" style="text-align: center;">Cutting</th>
                        <th class="" colspan="2" style="text-align: center;">Range</th>
                        <th class="" colspan="5" style="text-align: center;">Sewing</th>
                        <th class="" colspan="3" style="text-align: center;">Finishing</th>
                    </tr>
                    <tr>
                        <th class="" style="width: 10%"><span data-toggle="tooltip" title="PO-ITEM">PO-ITEM</span></th>
                        <th class=""><span data-toggle="tooltip" title="Brand">Brand</span></th>
                        <th class="" style="width: 9.9%"><span data-toggle="tooltip" title="Style">STL</span></th>
                        <th class="" style="width: 10%"><span data-toggle="tooltip" title="Quality-Color">QL-CLR</span></th>
                        <th class=""><span data-toggle="tooltip" title="Order Qty">OQ</span></th>
                        <th class=""><span data-toggle="tooltip" title="Ex-Factory Date">ExFac</span></th>
                        <th class=""><span data-toggle="tooltip" title="Cut QTY">CQ</span></th>
                        <th class=""><span data-toggle="tooltip" title="Cut Balance">CBQ</span></th>
                        <th class=""><span data-toggle="tooltip" title="Cut Pass QTY">CPQ</span></th>
                        <th class=""><span data-toggle="tooltip" title="Bundle Range">BR</span></th>
                        <th class=""><span data-toggle="tooltip" title="Identity Number Range">INR</span></th>
                        <th class=""><span data-toggle="tooltip" title="Line Input">IN</span></th>
                        <th class=""><span data-toggle="tooltip" title="Collar">Collar</span></th>
                        <th class=""><span data-toggle="tooltip" title="Cuff">Cuff</span></th>
                        <th class=""><span data-toggle="tooltip" title="Mid-Line Pass QTY">MPQ</span></th>
                        <th class=""><span data-toggle="tooltip" title="End-Line Pass QTY">EPQ</span></th>
                        <th class=""><span data-toggle="tooltip" title="Wash QTY">WQ</span></th>
                        <th class=""><span data-toggle="tooltip" title="Packing QTY">PQ</span></th>
                        <th class=""><span data-toggle="tooltip" title="Packing Balance QTY">PBQ</span></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $cur_date = date('Y-m-d');

                    foreach($prod_summary as $k => $v){
                        if(($v['total_cut_qty'] - $v['count_packing_pass']) != 0){
                            $ship_date = $v['ex_factory_date'];

                            if($v['item'] == ''){
                                $item = 'NA';
                            }else{
                                $item = $v['item'];
                            }

                            ?>
                            <tr>
                                <td class="" style="width: 10%">
                                    <span style="color: #727dff; cursor: pointer;" onclick="getSizeWiseReport('<?php echo $v['po_no']; ?>', '<?php echo $v['purchase_order'];?>','<?php echo $v['item'];?>', '<?php echo $v['quality']; ?>', '<?php echo $v['color']; ?>');">
                                        <?php
                                        if($v['item'] != ''){
                                            echo $v['purchase_order'] . '_' . $v['item'];
                                        }else{
                                            echo $v['purchase_order'];
                                        }
                                        ?>
                                    </span>
                                </td>
                                <td class=""><?php echo $v['brand'];?></td>
                                <td class="" style="width: 9.9%"><?php echo $v['style_no'].'-'.$v['style_name'];?></td>
                                <td class="" style="width: 10%"><?php echo $v['quality'].'_'.$v['color'];?></td>
                                <td class=""><?php echo $v['total_order_qty'];?></td>
                                <td class="" <?php if($cur_date > $ship_date){ ?> style="background-color: #ff481f; color: #fff;" <?php } ?> >
                                    <?php echo $v['ex_factory_date'];?>
                                </td>
                                <td class=""><?php echo $v['total_cut_qty'];?></td>
                                <td class=""><?php echo $v['total_cut_qty']-$v['total_cut_input_qty'];?></td>
                                <td class=""><?php echo $v['total_cut_input_qty'];?></td>
                                <td class=""><span style="color: #ffffff;">'</span><?php echo $v['bundle_start'].'-'.$v['bundle_end'];?></td>
                                <td class=""><?php echo $v['min_care_label'].'-'.$v['max_care_label'];?></td>

                                <td class="" title="<?php echo $v['min_line_input_date_time'];?>">
                                        <?php echo $v['count_input_qty_line'];?>
                                </td>

                                <td class=""><?php echo $v['collar_bndl_qty'];?></td>
                                <td class=""><?php echo $v['cuff_bndl_qty'];?></td>
                                <td class=""><?php echo $v['count_mid_line_qc_pass'];?></td>
                                <td class=""><?php echo $v['count_end_line_qc_pass'];?></td>
                                <td class="" <?php if($v['wash_gmt'] == 1){ ?> style="background-color: #faff88;" <?php } ?>>
                                    <?php echo $v['count_washing_pass']; ?>
                                </td>
                                <td class=""><?php echo $v['count_packing_pass'];?></td>
                                <td class=""><a target="_blank" href="<?php echo base_url();?>dashboard/remainQtyStatus/<?php echo $v['po_no'];?>/<?php echo $v['purchase_order'];?>/<?php echo $item;?>/4"><?php echo $v['total_cut_qty'] - $v['count_packing_pass'];?></a></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div><!--/col-md-12-->
</div>

<?php $f = "\\10.234.15.22\c$\Users\ismef17\Downloads\download.xls";?>

</body>
</html>
<script type="text/javascript">

    $(function(){
        $('#btnExport').click(function(){
            var url='data:application/vnd.ms-excel,' + encodeURIComponent($('#tableWrap').html());
            location.href=url
            return false
        })
    });
</script>