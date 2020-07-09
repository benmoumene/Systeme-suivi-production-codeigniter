<!--\\\\\\\ contentpanel start\\\\\\-->
    <div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
            <h1>Cutting-Stock Report</h1>
            <h2 class="">Cutting-Stock Report...</h2>
        </div>
        <div class="pull-right">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#">DASHBOARD</a></li>
                <li class="active">Cutting-Stock Report</li>
            </ol>
        </div>
    </div>
    <div class="container clear_both padding_fix">
        <!--\\\\\\\ container  start \\\\\\-->
<!--        <div class="row">-->
<!--            <div class="form-group">-->
<!--                <!--                            <div class="col-md-12">-->
<!--                <div class="col-md-3">-->
<!--                    <div class="form-group">-->
<!--                        <select required class="form-control" id="po_no" name="po_no" onchange="getReportByPo(id);">-->
<!--                                <option value="">Select PO No...</option>-->
<!--                            --><?php
//                                foreach ($purchase_order_nos as $pos){ ?>
<!--                                    <option value="--><?php //echo $pos['purchase_order'];?><!--">--><?php //echo $pos['purchase_order'];?><!--</option>-->
<!--                            --><?php
//                                }
//                            ?>
<!--                        </select>-->
<!--                        <span style="font-size: 11px;">* Select PO No.</span>-->
<!--                    </div>-->
<!--                </div>-->
<!---->
<!---->
<!--                <!--                            </div>-->
<!--            </div>-->
<!--        </div><!--/form-group-->
<!--        <br />-->

        <div class="row" id="report_content">
            <div class="col-md-4 col-sm-6">
                <section class="panel default blue_title h2">

                    <div class="panel-body">
                        Cutting Stock report Here......
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!--\\\\\\\ container  end \\\\\\-->



<script type="text/javascript">
//    $('select').select2();

//    setTimeout(function(){
//        window.location.reload(1);
//    }, 5000);

//    function getReportByPo(id) {
//        var purchase_order = $("#"+id).val();
//
//
//        $("#report_content").empty();
//
//        $.ajax({
//            url: "<?php //echo base_url();?>//access/getSummaryReportbyPo/",
//            type: "POST",
//            data: {purchase_order: purchase_order},
//            dataType: "html",
//            success: function (data) {
//                $("#report_content").append(data);
//            }
//        });
//
//    }
</script>