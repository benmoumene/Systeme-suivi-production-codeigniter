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
<!--\\\\\\\ contentpanel start\\\\\\-->
<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>Bundle Summary</h1>
        <h2 class="">Bundle Summary...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li><a href="#">DASHBOARD</a></li>
            <li class="active">Bundle Summary</li>
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
                            <option value="">SO_PO_Item_Quality_Color</option>
                            <?php

                            foreach ($purchase_order_nos as $pos){ ?>
                                <option value="<?php echo $pos['po_no'].'_'.$pos['purchase_order'].'_'.$pos['item'].'_'.$pos['color'];?>"><?php echo $pos['po_no'].'_'.$pos['purchase_order'].'_'.$pos['item'].'_'.$pos['quality'].'_'.$pos['color'];?></option>
                                <?php
                            }
                            //                            ?>
                        </select>
                        <span style="font-size: 11px;">* Select SO_PO_Item_Quality_Color</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <select required class="form-control" id="cut_no" name="cut_no">
                            <option value="">Select Cut No...</option>
                            <?php
                            foreach ($cut_no as $v_c){
                                ?>
                                <option value="<?php echo $v_c['cut_no'];?>"><?php echo $v_c['cut_no'];?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <span style="font-size: 11px;">* Cut No.</span>
                    </div>
                </div>

                <div class="col-md-1">
                    <div class="form-group">
                        <button style="cursor: pointer;" required class="btn btn-success" id="search_btn" name="search_btn" onclick="getBundleSummary();">Search</button>
                    </div>
                </div>

                <div class="col-md-1" id="loader" style="display: none;"><div class="loader"></div></div>
            </div>
        </div>
    </div>
    <br />

    <div class="row" id="report_content">

    </div>
    <!--\\\\\\\ container  end \\\\\\-->



    <script type="text/javascript">
        $('select').select2();

        //    setTimeout(function(){
        //        window.location.reload(1);
        //    }, 5000);

        function getBundleSummary() {
            var purchase_order_stuff = $("#po_no").val();
            var cut_no = $("#cut_no").val();

            $("#report_content").empty();
            $("#loader").css("display", "block");

            $.ajax({
                url: "<?php echo base_url();?>dashboard/getBundleSummary/",
                type: "POST",
                data: {purchase_order_stuff:purchase_order_stuff, cut_no: cut_no},
                dataType: "html",
                success: function (data) {
                    console.log(data);
                    $("#report_content").append(data);
                    $("#loader").css("display", "none");
                }
            });

        }

        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>