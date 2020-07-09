<!--\\\\\\\ contentpanel start\\\\\\-->
    <div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
            <h1>Cutting Report</h1>
            <h2 class="">Cutting Report...</h2>
        </div>
        <div class="pull-right">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#">DASHBOARD</a></li>
                <li class="active">Cutting Report</li>
            </ol>
        </div>
    </div>
    <div class="container clear_both padding_fix">
        <!--\\\\\\\ container  start \\\\\\-->
        <div class="row">
            <div class="form-group">
                <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <select required class="form-control" id="po_no" name="po_no" onchange="getReportByPo(id);">
                                <option value="">Select PO No...</option>
                            <?php
                                foreach ($purchase_order_nos as $pos){ ?>
                                    <option value="<?php echo $pos['purchase_order'].'_'.$pos['item'].'_'.$pos['color'];?>"><?php echo $pos['purchase_order'].'-'.$pos['item'].'-'.$pos['color'];?></option>
                            <?php
                                }
//                            ?>
                        </select>
                        <span style="font-size: 11px;">* Select PO No.</span>
                    </div>
                </div>


                </div>
            </div>
        </div>
        <div style="padding-top:10px">
            <h6 style="color:red">
                <?php
                $exc = $this->session->userdata('exception');
                if (isset($exc)) {
                    echo $exc;
                    $this->session->unset_userdata('exception');
                }
                ?>
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

        <div class="row" id="report_content">

        </div>
    <!--\\\\\\\ container  end \\\\\\-->



<script type="text/javascript">
    $('select').select2();

//    setTimeout(function(){
//        window.location.reload(1);
//    }, 5000);

    function getReportByPo(id) {
        var purchase_order_stuff = $("#"+id).val();

        $("#report_content").empty();

        $.ajax({
            url: "<?php echo base_url();?>access/getPoWiseSizesWithLinesForm/",
            type: "POST",
            data: {purchase_order_stuff: purchase_order_stuff},
            dataType: "html",
            success: function (data) {
                $("#report_content").append(data);
            }
        });

    }
</script>