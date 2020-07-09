<style>
    .loader {
        border: 20px solid #f3f3f3;
        border-radius: 50%;
        border-top: 20px solid #3498db;
        width: 20px;
        height: 20px;
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
          <h1>Bundle Scanning</h1>
            <a href="<?php echo base_url();?>access/care_label_send_to_production_individual" id="bundle_scan_tab" class="btn btn-primary">Label Scan</a>
            <a href="<?php echo base_url();?>access/package_send_to_sew" class="btn btn-warning">INPUT To SEW</a>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">Bundle Scanning</li>
          </ol>
        </div>
      </div>
      <div class="container clear_both padding_fix">
        <!--\\\\\\\ container  start \\\\\\-->
<!--        <form action="" method="post">-->
          <div class="row">
        <div class="col-md-12">
            <div style="padding-top:10px">
                <h6 style="color:red" id="err_msg"></h6>

                <h6 style="color:green" id="suc_msg"></h6>
            </div>

          </div><!--/block-web--> 
        </div><!--/col-md-12-->
            <div class="row">
                <div class="col-md-1">
                    <select class="form-control" name="line_no" id="line_no" style="font-size: 18px;">
                        <option value="" id="blank">Line...</option>
                        <?php foreach ($lines as $lns){ ?>
                            <option value = "<?php echo $lns['id'];?>" ><?php echo $lns['line_name'];?></option>

<!--                        --><?php //
//                            if($lns['id'] != 10 && $lns['id'] != 8){ ?>
<!--                                <option value = "--><?php //echo $lns['id'];?><!--" >--><?php //echo $lns['line_name'];?><!--</option>-->
<!--                        --><?php
//                            }
//                            if($lns['id'] == 8){ ?>
<!--                                <option value = "--><?php //echo $lns['id'];?><!--" >--><?php //echo $lns['line_name'].'/18';?><!--</option>-->
<!--                        --><?php
//                            }
//                        ?>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-1">
                    <input type="text" class="form-control" name="bundle_tracking_no" autofocus id="bundle_tracking_no" onkeyup="clickToSubmitBtn();" />
                    <br />
                    <div class="col-md-1" id="loader" style="display: none;"><div class="loader"></div></div>
                    <br />
                    <br />
                    <span style="margin-top: 30px;" id="refresh_report" class="btn btn-success" onclick="getCuttingCollarCuffReport();">Report</span>
                </div>
                <div class="col-md-4">
                    <div class="block-web scroll3">
                        <div class="porlets-content">

                            <div class="table-responsive">
                                <table class="display table table-bordered table-striped" id="bundle_tbl">
                                    <thead>
                                    <tr>
                                        <th class="hidden-phone center">Bundle Code</th>
                                    </tr>
                                    </thead>
                                    <tbody id="bundle_tbl_bdy">

                                    </tbody>
                                </table>
                            </div><!--/table-responsive-->
                        </div>
                    </div>

                </div><!--/block-web-->

                <div class="col-md-2" style="margin-left: 150px;">
                    <button id="submit_btn" class="btn btn-lg btn-success" onclick="sendingCollarCuffToProduction();">Save</button>
                </div>

<!--                <div class="col-md-4 scroll4" style="margin-left: 150px;">-->
<!--                    <div class="block-web">-->
<!---->
<!--                        <div class="porlets-content">-->
<!---->
<!--                            <div class="table-responsive" id="size_tbl">-->
<!--                                <table class="display table table-bordered table-striped">-->
<!--                                    <thead>-->
<!--                                    <tr>-->
<!--                                        <th class="hidden-phone center">Size</th>-->
<!--                                        <th class="hidden-phone center">Order</th>-->
<!--                                        <th class="hidden-phone center">Cut</th>-->
<!--                                        <th class="hidden-phone center">Collar</th>-->
<!--                                        <th class="hidden-phone center">Cuff</th>-->
<!--                                    </tr>-->
<!--                                    </thead>-->
<!--                                    <tbody>-->
<!--                                    <tr>-->
<!--                                        <td class="hidden-phone center"></td>-->
<!--                                        <td class="hidden-phone center"></td>-->
<!--                                        <td class="hidden-phone center"></td>-->
<!--                                        <td class="hidden-phone center"></td>-->
<!--                                        <td class="hidden-phone center"></td>-->
<!--                                    </tr>-->
<!--                                    </tbody>-->
<!--                                </table>-->
<!--                            </div><!--/table-responsive-->
<!--                        </div>-->
<!---->
<!--                    </div><!--/porlets-content-->
<!--                </div><!--/block-web-->
            </div><!--/col-md-12-->
<!--        </form>-->

          <div class="row">
              <div class="col-md-12">
                  <div class="block-web scroll6" id="reload_div">


                  </div><!--/porlets-content-->
              </div><!--/block-web-->

              <!--              <div class="col-md-4">-->
              <!--                  <div class="">-->
              <!---->
              <!--                      <div class="porlets-content">-->
              <!---->
              <!--                          <div class="table-responsive">-->
              <!--                              <table class="display table table-bordered table-striped" id="">-->
              <!--                                  <thead>-->
              <!--                                  <tr>-->
              <!--                                      <th class="hidden-phone center"><a target="_blank" href="--><?php //echo base_url();?><!--dashboard/poWiseCuttingReport" class="btn btn-danger">Cutting</a></th>-->
              <!--                                      <th class="hidden-phone center" colspan="2"><a target="_blank" href="--><?php //echo base_url();?><!--dashboard/lineWisePoItemReport" class="btn btn-primary">LINE</a></th>-->
              <!--                                      <th class="hidden-phone center" colspan="3"><a target="_blank" href="--><?php //echo base_url();?><!--dashboard/poWisePackingReport" class="btn btn-success">Packing</a></th>-->
              <!--                                  </tr>-->
              <!--                                  </thead>-->
              <!--                                  <tbody>-->
              <!---->
              <!--                                  </tbody>-->
              <!--                              </table>-->
              <!--                          </div>-->
              <!--                      </div>-->
              <!---->
              <!--                  </div>-->
              <!--              </div>-->
<!--              <div class="col-md-3 scroll4">-->
<!--                  <div class="porlets-content">-->
<!--                      <div class="table-responsive" id="remain_bundle_list_1">-->
<!---->
<!--                      </div>-->
<!--                  </div>-->
<!--              </div>-->
          </div>
      </div>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>

                <div class="modal-body">
                    <div class="col-md-3 scroll4">
                        <div class="porlets-content">
                            <div class="table-responsive" id="remain_cc_bundle_list">

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
//    $('select').select2();

    $(document).ready(function(){
        setInterval(function(){

            $.ajax({
                url: "<?php echo base_url();?>access/checkSession/", //Change this URL as per your settings
                type: "POST",
                data: {},
                dataType: "html",
                success: function(newVal) {
                    if (newVal == ''){
                        location.reload(true);
                    }
                }
            });


        }, 60000);
    });

    $("#bundle_tracking_no").blur(function(){
        $("#bundle_tracking_no").focus();
    });

    function clickToSubmitBtn() {
        var cl_no = $("#bundle_tracking_no").val();
        var care_label_no = cl_no.trim();

        var bundle_array = [];

        var last_variable = care_label_no.slice(-1);
        var last_variable_1 = care_label_no.substr(care_label_no.length - 4);

        if((last_variable == '.') && ((last_variable_1 == 'clr.') || (last_variable_1 == 'cff.') || (last_variable_1 == 'bck.') ||
            (last_variable_1 == 'yok.') || (last_variable_1 == 'slv.') || (last_variable_1 == 'spt.') || (last_variable_1 == 'pkt.'))){


            $("input[name='bundle_codes[]']").each(function() {
                bundle_array.push($(this).val());
            });

            var index_find = bundle_array.indexOf(cl_no);

            $("#suc_msg").empty();
            $("#err_msg").empty();

            if(index_find < 0){
                $("#bundle_tbl_bdy").append('<tr><td><input type="text" name="bundle_codes[]" id="bundle_codes" class="form-control" value="'+cl_no+'" /></td></tr>');
                $("#bundle_tracking_no").val('');
            }
            if(index_find >= 0){
                $("#err_msg").append("This Bundle Already Added!");
                $("#bundle_tracking_no").val('');
            }

        }

    }
    
    function sendingCollarCuffToProduction(){
        var bundle_array = [];

        $("input[name='bundle_codes[]']").each(function() {
            bundle_array.push($(this).val());
        });

//        console.log(bundle_array);
        $("#loader").css("display", "block");
        var line_id = $("#line_no").val();

        if(line_id != '') {
            $.ajax({
                url: "<?php echo base_url();?>access/sendingCollarCuffToProduction/",
                type: "POST",
                data: {bundle_array: bundle_array, line_id: line_id},
                dataType: "html",
                success: function (data) {
                    console.log(data);
                    if (data == 'DONE') {
                        location.reload();
                    }
                }
            });
        }else{
            alert("Please Select Line!");
        }
    }

    function getSizeWiseReport(sap_no, so_no, po, item, quality, color) {
        $("#size_tbl").empty();
        $("#remain_bundle_list").empty();
        $("#loader").css("display", "block");

        $.ajax({
            url: "<?php echo base_url();?>access/getPoItemWiseSizeCutCCReport/",
            type: "POST",
            data: {po_no: sap_no, so_no: so_no, purchase_order: po, item: item, quality: quality, color: color},
            dataType: "html",
            success: function (data) {
                $("#size_tbl").append(data);
                $("#loader").css("display", "none");
            }
        });
    }

    function getRemainingCollarBundlesBySize(po_no, so_no, purchase_order, item, quality, color, size) {
//        alert("Collar "+po_no+' '+purchase_order+' '+item+' '+quality+' '+color+' '+size);

        $("#remain_cc_bundle_list").empty();
        $("#loader").css("display", "block");

        $.ajax({
            url: "<?php echo base_url();?>access/getRemainingCutCollarBundlesBySize/",
            type: "POST",
            data: {po_no: po_no, so_no: so_no, purchase_order: purchase_order, item: item, quality: quality, color: color, size: size},
            dataType: "html",
            success: function (data) {
                $("#remain_cc_bundle_list").append(data);
                $("#loader").css("display", "none");
            }
        });
    }

    function getRemainingCuffBundlesBySize(po_no, so_no, purchase_order, item, quality, color, size) {
//        alert("Cuff "+po_no+' '+purchase_order+' '+item+' '+quality+' '+color+' '+size);

        $("#remain_cc_bundle_list").empty();

        $.ajax({
            url: "<?php echo base_url();?>access/getRemainingCutCuffBundlesBySize/",
            type: "POST",
            data: {po_no: po_no, so_no: so_no, purchase_order: purchase_order, item: item, quality: quality, color: color, size: size},
            dataType: "html",
            success: function (data) {
                $("#remain_cc_bundle_list").append(data);
            }
        });
    }

    function getCuttingCollarCuffReport() {
        var line_id = $("#line_no").val();

        if(line_id != ''){
            $("#loader").css("display", "block");
//            $("#reload_div").load('<?php //echo base_url();?>//access/getProductionSummaryReport');

            $("#reload_div").empty();
            $("#remain_cl_list").empty();
            $("#size_tbl").empty();

//            setInterval(function(){
//                $("#loader").css("display", "none");
//            }, 15000);

            $.ajax({
                url: "<?php echo base_url();?>access/get_collar_cuff_send_to_prod_data/",
                type: "POST",
                data: {line_id: line_id},
                dataType: "html",
                success: function (data) {
                    $("#reload_div").append(data);
                    $("#loader").css("display", "none");
                    document.getElementById("blank").selected = "true";
                }
            });

        }else{
            alert("Please Select Line ID");
        }


    }
</script>