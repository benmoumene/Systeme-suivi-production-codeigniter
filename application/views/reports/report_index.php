<style>
    .loader {
        border: 20px solid #f3f3f3;
        border-radius: 50%;
        border-top: 20px solid #3498db;
        width: 35px;
        height: 35px;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
    }

    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1><?php echo $title;?></h1>
        <h2 class=""><?php echo $title;?>...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active"><?php echo $title;?></li>
        </ol>
    </div>
</div>
<div class="container clear_both padding_fix">
    <!--\\\\\\\ container  start \\\\\\-->
    <div class="header">
        <div class="actions">
            <div class="row">

                <div class="col-md-2">
<!--                    <span style="font-size: 15px; margin-left: 1px; background-color: darkgreen; color: white;">PL=Planned Lines / OQ=Order Qty / CQ=Cut Qty / CPQ=Cut Pass Qty / CBQ=Cut Balance Qty / BR=Bundle Range / INR=Identity Number Range / IN= Line Input  </span> <br />-->
<!--                    <span style="font-size: 15px; margin-left: 1px; background-color: darkgreen; color: white;">MPQ=Mid Pass Qty / EPQ=End Pass Qty / WGQ=Wash Going QTY / WQ=Wash Qty / PQ=Pack Qty / CTN=Carton Qty / WQ=Warehouse Qty / BQ=Balance Qty </span>-->
                    <select class="form-control" name="brands[]" id="brands" multiple data-placeholder="Select Brands" onchange="getShipDateLists();">
                        <?php foreach ($brands as $v){
                            if($v['brand'] != ''){
                                ?>
                                <option value="<?php echo "'".$v['brand']."'"?>"><?php echo $v['brand']?></option>
                                <?php
                            }
                        } ?>
                    </select>
                    <br />
                    <span><b>* Select Brands </b></span>
                </div>
                <div class="col-md-2">
                    <span class="btn btn-success" onclick="getRunningPOs()">SEARCH</span>
                </div>
                <div class="col-md-1">
                    <div id="loader" style="display: none;"><div class="loader"></div></div>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-1">
                    <span class="btn btn-primary" style="color: #FFF;" id="btnExport123" onclick="ExportToExcel('table_id')"><b>Export Excel</b></span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">

        <div style="padding-top:10px">
            <h6 style="color:red">
                <?php
                $exc = $this->session->userdata('exception');
                if (isset($exc)) {
                    echo $exc;
                    $this->session->unset_userdata('exception');
                } ?>
            </h6>

            <h6 style="color:green">
                <?php
                $msg = $this->session->userdata('message');
                if (isset($msg)) {
                    echo $msg;
                    $this->session->unset_userdata('message');
                }
                ?>
            </h6>
        </div>
        <div class="porlets-content">


        </div>

    </div><!--/block-web-->
</div><!--/col-md-12-->

<div class="row">

    <div  id="reload_div">
        <div class="col-md-12 well1" id="tableWrap">
            <table class="table table-scroll table-striped" border="1" id="table_id">
                <thead>
                <tr style="background-color: #defa9e; font-size: 20px;">
                    <th class="text-center" colspan="10" style="width: 53%;">RUNNING PO LIST</th>
                    <th class="" colspan="3" style="text-align: center;">Cutting</th>
                    <!--            <th class="" colspan="1" style="text-align: center;">Range</th>-->
                    <th class="" colspan="5" style="text-align: center;">Sewing</th>
                    <th class="" colspan="6" style="text-align: center;">Finishing</th>
                </tr>
                <tr>
                    <th class="" style="width: 10%"><span data-toggle="tooltip" title="PO-ITEM">PO-ITEM</span></th>
                    <th class=""><span data-toggle="tooltip" title="Sales Order">SO</span></th>
                    <th class=""><span data-toggle="tooltip" title="Plan Lines">PL</span></th>
                    <th class=""><span data-toggle="tooltip" title="Responsible Lines">Line</span></th>
                    <th class=""><span data-toggle="tooltip" title="Sales Order">PO TYPE</span></th>
                    <th class=""><span data-toggle="tooltip" title="Brand">Brand</span></th>
                    <th class="" style="width: 9.7%"><span data-toggle="tooltip" title="Style">STL</span></th>
                    <th class="" style="width: 10%"><span data-toggle="tooltip" title="Quality-Color">QL-CLR</span></th>
                    <th class=""><span data-toggle="tooltip" title="Order Qty">OQ</span></th>
                    <th class=""><span data-toggle="tooltip" title="Ex-Factory Date">ExFac</span></th>
                    <th class=""><span data-toggle="tooltip" title="Cut QTY">CQ</span></th>
                    <th class=""><span data-toggle="tooltip" title="Cut Balance">CBQ</span></th>
                    <th class=""><span data-toggle="tooltip" title="Cut Pass QTY">CPQ</span></th>
                    <!--            <th class=""><span data-toggle="tooltip" title="Bundle Range">BR</span></th>-->
                    <!--            <th class=""><span data-toggle="tooltip" title="Identity Number Range">INR</span></th>-->
                    <th class=""><span data-toggle="tooltip" title="Line Input">IN</span></th>
                    <th class=""><span data-toggle="tooltip" title="Collar ">Collar</span></th>
                    <th class=""><span data-toggle="tooltip" title="Cuff">Cuff</span></th>
                    <th class=""><span data-toggle="tooltip" title="Mid-Line Pass QTY">MPQ</span></th>
                    <th class=""><span data-toggle="tooltip" title="End-Line Pass QTY">EPQ</span></th>
                    <th class=""><span data-toggle="tooltip" title="Wash Going QTY">WGQ</span></th>
                    <th class=""><span data-toggle="tooltip" title="Wash QTY">WQ</span></th>
                    <th class=""><span data-toggle="tooltip" title="Packing QTY">PQ</span></th>
                    <th class=""><span data-toggle="tooltip" title="Carton QTY">CTN</span></th>
                    <th class=""><span data-toggle="tooltip" title="Warehouse QTY">WHQ</span></th>
                    <th class=""><span data-toggle="tooltip" title="Balance QTY">BQ</span></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $cur_date = date('Y-m-d');
                $till_date = date("Y-m-d", strtotime("+ 30 days"));
                foreach($prod_summary as $k => $v){

                    $total_finishing_wh_qa = $v['count_carton_pass'] + $v['total_wh_qa'];
                    $total_wh_qa = $v['total_wh_qa'];

//            if(((($v['total_cut_qty'] - $total_finishing_wh_qa) != 0) && ($v['responsible_line'] != ''))){
//            if(($cur_date <= $v['ex_factory_date']) || ($till_date <= $v['ex_factory_date']) || (($v['total_cut_qty'] - $total_finishing_wh_qa) > 0)){

                    $ship_date = $v['ex_factory_date'];

                    $upcoming_month = date('Y-m-d', strtotime('+1 month'));

                    if($v['balance'] > 0){

                        ?>

                        <tr>
                            <td class="" style="width: 10%; <?php if($v['status'] == 'CLOSE'){ ?> background-color: #ff481f; color: #fff;<?php } ?>">
                                <!--<span style="cursor: pointer;" onclick="getSizeWiseReport('<?php echo $v['po_no']; ?>', '<?php echo $v['so_no']; ?>', '<?php echo $v['purchase_order'];?>','<?php echo $v['item'];?>', '<?php echo $v['quality']; ?>', '<?php echo $v['color']; ?>');">-->
                                <span>
                            <?php
                            if($v['item'] != ''){
                                echo $v['purchase_order'] . '_' . $v['item'];
                            }else{
                                echo $v['purchase_order'];
                            }
                            ?>
                        </span>
                            </td>
                            <td class=""><?php echo $v['so_no'];?></td>
                            <td class=""><?php echo $v['planned_lines'];?></td>
                            <td class=""><?php echo $v['responsible_line'];?></td>
                            <td class="">
                                <?php
                                if($v['po_type'] == 0){
                                    echo 'BULK';
                                }
                                if($v['po_type'] == 1){
                                    echo 'SIZE SET';
                                }
                                if($v['po_type'] == 2){
                                    echo 'SAMPLE';
                                }
                                ?>
                            </td>
                            <td class=""><?php echo $v['brand'];?></td>
                            <td class="" style="width: 9.7%"><?php echo $v['style_no'].'-'.$v['style_name'];?></td>
                            <td class="" style="width: 10%"><?php echo $v['quality'].'_'.$v['color'];?></td>
                            <td class=""><?php echo $v['total_order_qty'];?></td>
                            <td class="" <?php if($cur_date > $ship_date){ ?> style="background-color: #ff481f; color: #fff;" <?php } ?> >
                                <?php echo $v['ex_factory_date'];?>
                            </td>
                            <td class=""><?php echo $v['total_cut_qty'];?></td>
                            <td class=""><?php echo $v['total_cut_qty']-$v['total_cut_input_qty'];?></td>
                            <td class=""><?php echo $v['total_cut_input_qty'];?></td>
                            <!--                    <td class=""><span style="color: #ffffff;">'</span>--><?php //echo $v['bundle_start'].'-'.$v['bundle_end'];?><!--</td>-->
                            <!--                    <td class="" title="Bundles: --><?php //echo $v['bundle_start'].'-'.$v['bundle_end'];?><!--">--><?php //echo $v['min_care_label'].'-'.$v['max_care_label'];?><!--</td>-->
                            <td class="">
                                <?php echo $v['count_input_qty_line'];?>
                            </td>
                            <td class=""><?php echo $v['collar_bndl_qty'];?></td>
                            <td class=""><?php echo $v['cuff_bndl_qty'];?></td>
                            <td class=""><?php echo $v['count_mid_line_qc_pass'];?></td>
                            <td class=""><?php echo $v['count_end_line_qc_pass'];?></td>
                            <td class=""><?php echo $v['count_washing_qty'];?></td>
                            <td class="" <?php if($v['wash_gmt'] == 1){ ?> style="background-color: #faff88;" <?php } ?>>
                                <?php echo $v['count_washing_pass'];?>
                            </td>
                            <td class=""><?php echo $v['count_packing_pass'];?></td>
                            <td class=""><?php echo $v['count_carton_pass'];?></td>
                            <td class="" style="cursor: pointer;" onclick="getWarehousePcs('<?php echo $v['po_no']; ?>', '<?php echo $v['purchase_order'];?>','<?php echo $v['item'];?>', '<?php echo $v['quality']; ?>', '<?php echo $v['color']; ?>');" data-target="#myModal3" data-toggle="modal" ><?php echo $total_wh_qa;?></td>
                            <!--                    <td class=""><a target="_blank" href="--><?php //echo base_url();?><!--dashboard/remainQtyStatus/--><?php //echo $v['po_no'];?><!--/--><?php //echo $v['purchase_order'];?><!--/--><?php //echo $item;?><!--/4">--><?php //echo $v['total_cut_qty'] - $total_finishing_wh_qa;?><!--</a></td>-->
                            <td class="">
                        <span class="center btn btn-danger" data-target="#myModal2" data-toggle="modal" onclick="getPoItemWiseRemainCL('<?php echo $v['po_no']; ?>', '<?php echo $v['so_no']; ?>', '<?php echo $v['purchase_order'];?>','<?php echo $v['item'];?>', '<?php echo $v['quality']; ?>', '<?php echo $v['color']; ?>');">
                        <?php echo $v['total_cut_qty'] - $total_finishing_wh_qa;?>
                        </span>
                            </td>
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
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<div class="row">
    <div class="col-md-12">
        <div class="col-md-4">
            <div class="block-web">

                <div class="porlets-content">

                    <div class="table-responsive">
                        <table class="display table table-bordered table-striped" id="">
                            <thead>
                            <tr>
                                <!--                                <th class="hidden-phone center"><a target="_blank" href="--><?php //echo base_url();?><!--dashboard/poWiseCuttingReport" class="btn btn-danger">Cutting</a></th>-->
                                <th class="hidden-phone center"><a target="" href="<?php echo base_url();?>dashboard/poWiseSizeReport" class="btn btn-success">PO Report</a></th>
                                <th class="hidden-phone center" colspan="2"><a href="<?php echo base_url();?>dashboard/lineWisePoItemReport" class="btn btn-primary">LINE</a></th>
                                <th class="hidden-phone center" colspan="2"><a href="<?php echo base_url();?>dashboard/finishingRunningPoReportByBrand" class="btn btn-warning">Finishing</a></th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div><!--/table-responsive-->
                </div>

            </div><!--/porlets-content-->
        </div><!--/block-web-->
    </div><!--/col-md-12-->
</div>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>

            <div class="modal-body">
                <div class="col-md-3 scroll4">
                    <div class="porlets-content">
                        <div class="table-responsive" id="remain_cl_list">

                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <!--                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                <!--                <button type="button" class="btn btn-primary">Save changes</button>-->
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1"></h4>
            </div>

            <div class="modal-body">
                <div class="col-md-3 scroll4">
                    <div class="porlets-content">
                        <div class="table-responsive" id="wh_cl_list">

                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <!--                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                <!--                <button type="button" class="btn btn-primary">Save changes</button>-->
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    $('select').select2();

    $(function(){
        $('#btnExport').click(function(){
            var url='data:application/vnd.ms-excel,' + encodeURIComponent($('#tableWrap').html())
            location.href=url
            return false
        })
    })

    function getSizeWiseReport(sap_no, so_no, po, item, quality, color) {
        $("#size_tbl").empty();

//        alert(sap_no+'-'+po+'-'+item+'-'+quality+'-'+color);

        $("#loader").css("display", "block");

        $.ajax({
            url: "<?php echo base_url();?>dashboard/getPoItemWiseSizeReport/",
            type: "POST",
            data: {po_no: sap_no, so_no: so_no, purchase_order: po, item: item, quality: quality, color: color},
            dataType: "html",
            success: function (data) {
                $("#size_tbl").append(data);
                $("#loader").css("display", "none");
            }
        });
    }


    function getWarehousePcs(po_no, purchase_order,item, quality, color) {
        $("#wh_cl_list").empty();

        $.ajax({
            url: "<?php echo base_url();?>dashboard/getWarehousePcs/",
            type: "POST",
            data: {po_no: po_no, purchase_order: purchase_order, item: item, quality: quality, color: color},
            dataType: "html",
            success: function (data) {
                $("#wh_cl_list").append(data);
            }
        });

    }
    
    function getRunningPOs() {
        var brands = $("#brands").val();
        var brands_string = brands.toString();

        $("#loader").css("display", "block");

        $.ajax({
            url: "<?php echo base_url();?>dashboard/getRunningPOs/",
            type: "POST",
            data: {brands: brands_string},
            dataType: "html",
            success: function (data) {
                $("#reload_div").empty();
                $("#reload_div").append(data);
                $("#loader").css("display", "none");
            }
        });
    }

    function getRemainCLs(po_no, so_no, purchase_order, item, quality, color, size, access_point) {
        $("#remain_cl_list").empty();


        if(access_point == 1){
            $.ajax({
                url: "<?php echo base_url();?>dashboard/getPoItemWiseSizeRemainCutSendCL/",
                type: "POST",
                data: {po_no: po_no, so_no: so_no, purchase_order: purchase_order, item: item, quality: quality, color: color, size: size},
                dataType: "html",
                success: function (data) {
                    $("#remain_cl_list").append(data);
                }
            });
        }

        if(access_point == 2){
            $.ajax({
                url: "<?php echo base_url();?>dashboard/getPoItemWiseSizeRemainInputCL/",
                type: "POST",
                data: {po_no: po_no, so_no: so_no, purchase_order: purchase_order, item: item, quality: quality, color: color, size: size},
                dataType: "html",
                success: function (data) {
                    $("#remain_cl_list").append(data);
                }
            });
        }

        if(access_point == 3){
            $.ajax({
                url: "<?php echo base_url();?>dashboard/getPoItemWiseSizeRemainMidCL/",
                type: "POST",
                data: {po_no: po_no, so_no: so_no, purchase_order: purchase_order, item: item, quality: quality, color: color, size: size},
                dataType: "html",
                success: function (data) {
                    $("#remain_cl_list").append(data);
                }
            });
        }

        if(access_point == 4){
            $.ajax({
                url: "<?php echo base_url();?>dashboard/getPoItemWiseSizeRemainEndCL/",
                type: "POST",
                data: {po_no: po_no, so_no: so_no, purchase_order: purchase_order, item: item, quality: quality, color: color, size: size},
                dataType: "html",
                success: function (data) {
                    $("#remain_cl_list").append(data);
                }
            });
        }

        if(access_point == 5){
            $.ajax({
                url: "<?php echo base_url();?>dashboard/getPoItemWiseSizeRemainWashCL/",
                type: "POST",
                data: {po_no: po_no, so_no: so_no, purchase_order: purchase_order, item: item, quality: quality, color: color, size: size},
                dataType: "html",
                success: function (data) {
                    $("#remain_cl_list").append(data);
                }
            });
        }

        if(access_point == 10){
            $.ajax({
                url: "<?php echo base_url();?>dashboard/getPoItemWiseSizeRemainWashGoingCL/",
                type: "POST",
                data: {po_no: po_no, so_no: so_no, purchase_order: purchase_order, item: item, quality: quality, color: color, size: size},
                dataType: "html",
                success: function (data) {
                    $("#remain_cl_list").append(data);
                }
            });
        }

        if(access_point == 7){
            $.ajax({
                url: "<?php echo base_url();?>dashboard/getPoItemWiseSizeRemainPackCL/",
                type: "POST",
                data: {po_no: po_no, so_no: so_no, purchase_order: purchase_order, item: item, quality: quality, color: color, size: size},
                dataType: "html",
                success: function (data) {
                    $("#remain_cl_list").append(data);
                }
            });
        }

        if(access_point == 9){
            $.ajax({
                url: "<?php echo base_url();?>dashboard/getPoItemWiseSizeRemainCartonCL/",
                type: "POST",
                data: {po_no: po_no, so_no: so_no, purchase_order: purchase_order, item: item, quality: quality, color: color, size: size},
                dataType: "html",
                success: function (data) {
                    $("#remain_cl_list").append(data);
                }
            });
        }
    }

    function getPoItemWiseRemainCL(po_no, so_no, purchase_order, item, quality, color) {
        $("#remain_cl_list").empty();

        console.log(po_no+' - '+so_no+' - '+purchase_order+' - '+item+' - '+quality+' - '+color);

        $.ajax({
            url: "<?php echo base_url();?>dashboard/getPoItemWiseRemainCL/",
            type: "POST",
            data: {po_no: po_no, so_no: so_no, purchase_order: purchase_order, item: item, quality: quality, color: color},
            dataType: "html",
            success: function (data) {
                console.log(data);
                $("#remain_cl_list").append(data);
            }
        });

    }

    function ExportToExcel(tableid) {
        var tab_text = "<table border='2px'><tr>";
        var textRange; var j = 0;
        tab = document.getElementById(tableid);//.getElementsByTagName('table'); // id of table
        if (tab==null) {
            return false;
        }
        if (tab.rows.length == 0) {
            return false;
        }

        for (j = 0 ; j < tab.rows.length ; j++) {
            tab_text = tab_text + tab.rows[j].innerHTML + "</tr>";
            //tab_text=tab_text+"</tr>";
        }

        tab_text = tab_text + "</table>";
        tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
        tab_text = tab_text.replace(/<img[^>]*>/gi, ""); // remove if u want images in your table
        tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

        var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE ");

        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
        {
            txtArea1.document.open("txt/html", "replace");
            txtArea1.document.write(tab_text);
            txtArea1.document.close();
            txtArea1.focus();
            sa = txtArea1.document.execCommand("SaveAs", true, "download.xls");
        }
        else                 //other browser not tested on IE 11
        //sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
            try {
                var blob = new Blob([tab_text], { type: "application/vnd.ms-excel" });
                window.URL = window.URL || window.webkitURL;
                link = window.URL.createObjectURL(blob);
                a = document.createElement("a");
                if (document.getElementById("caption")!=null) {
                    a.download=document.getElementById("caption").innerText;
                }
                else
                {
                    a.download = 'download';
                }

                a.href = link;

                document.body.appendChild(a);

                a.click();

                document.body.removeChild(a);
            } catch (e) {
            }


        return false;
        //return (sa);
    }

</script>