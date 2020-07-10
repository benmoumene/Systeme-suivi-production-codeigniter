<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>Delete Cutting</h1>
        <h2 class="">Delete Cutting...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Delete Cutting</li>
        </ol>
    </div>
</div>
<div class="container clear_both padding_fix">
    <!--\\\\\\\ container  start \\\\\\-->
    <form action="<?php echo base_url();?>access/deletingCutting" method="post" onsubmit="return confirm('Do you really want to Delete?');">
        <div class="row">
            <div class="col-md-12">
                <div style="padding-top:10px">
                    <h4 style="color:red">
                        <?php
                        $exc = $this->session->userdata('exception');
                        if (isset($exc)) {
                            echo $exc;
                            $this->session->unset_userdata('exception');
                        } ?>
                    </h4>

                    <h4 style="color:green">
                        <?php
                        $msg = $this->session->userdata('message');
                        if (isset($msg)) {
                            echo $msg;
                            $this->session->unset_userdata('message');
                        }
                        ?>
                    </h4>
                </div>



                <!--              <div class="col-md-3">-->
                <!--                  <input type="text" class="form-control" name="carelabel_tracking_no" autofocus required id="carelabel_tracking_no" onkeyup="clickToSubmitBtn();" />-->
                <!---->
                <!--<!--                  <input type="text" class="form-control" name="cut_tracking_no_1" required id="cut_tracking_no_1" />-->
                <!--<!--                  <span id="er_msg" style="color: red;"></span>-->
                <!--<!--                  <span id="s_msg" style="color: green;"></span>-->
                <!--              </div>-->
                <!--              <div class="col-md-3">-->
                <!--                  <button style="display: none;" id="submit_btn" class="btn btn-success">Send</button>-->
                <!--              </div>-->

            </div><!--/block-web-->
        </div><!--/col-md-12-->
        <div class="row">
            <div class="col-md-3">
                <input type="text" class="form-control" placeholder="Sales Order No." name="po_no" autofocus required id="po_no" />

            </div>
            <div class="col-md-3">
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
            <div class="col-md-3">
                <span class="btn btn-success" onclick="getCuttingSummary();">Check</span>
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-md-4 col-sm-6">
                <div class="widgets_user">
                    <div class="system_body_title"> <i class="fa fa-user"></i> Cutting Summary</div>
                    <div class="system_bg">
                        <div class="centered-container">

                        </div>
                    </div>
                    <div class="widget-stats ">
                            <span class="item-number active_widget" style="font-size: 30px;" id="cl_qty">
                                0
                            </span>
                        <input type="hidden" name="cut_qty" id="cut_qty"/>
                        <span class="item-title active_widget" style="font-size: 18px;">Care Label Qty</span> </div>
                    <div class="widget-stats"> <span class="item-number active_orangewidget" style="font-size: 30px;" id="bundle_range">0</span> <span class="item-title active_orangewidget" style="font-size: 18px;">Bundle Range</span> </div>
                </div>
            </div>
            <button id="submit_btn" class="btn btn-danger" style="display: none;">Delete</button>
        </div>
    </form>

</div>

<script type="text/javascript">
    $('select').select2();

    $(document).ready(function(){
        $("#message").empty();
    });

    function getCuttingSummary() {

        var po_no = $("#po_no").val();
        var cut_no = $("#cut_no").val();

        $("#cut_qty").val('');
        $("#cl_qty").empty();
        $("#bundle_range").empty();

        if(po_no != '' && cut_no != ''){

            $.ajax({
                url: "<?php echo base_url();?>access/getCuttingSummary/",
                type: "POST",
                data: {po_no: po_no, cut_no: cut_no},
                dataType: "json",
                success: function (data) {

                    var total_cut_qty = data[0].total_cut_qty;
                    var bundle_range = data[0].bundle_start +' - '+ data[0].bundle_end;

                    $("#cut_qty").val(total_cut_qty);
                    $("#cl_qty").append(total_cut_qty);
                    $("#bundle_range").append(bundle_range);
                    $("#submit_btn").css('display', 'block');

                }
            });

        }else{
            alert("Please Enter Required Fields!");
            $("#submit_btn").css('display', 'none');
        }

    }

</script>