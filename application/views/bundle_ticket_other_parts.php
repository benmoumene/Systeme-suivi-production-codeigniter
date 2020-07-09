<div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
          <h1>Bundle Ticket Parts</h1>
          <h2 class="">Bundle Ticket Parts...</h2>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">Bundle Ticket Parts</li>
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
                        <select required type="text" class="form-control" id="part" name="part">

                            <option value="">Select Part...</option>
                            <?php foreach ($bundle_ticket_part as $v){ ?>
                                <option value="<?php echo $v['part_code'];?>"><?php echo $v['part_code'];?></option>
                            <?php } ?>
                            <input type="hidden" name="cut_tracking_no" id="cut_tracking_no" value="<?php echo $cut_tracking_no;?>">
                            <input type="hidden" name="po_no" id="po_no" value="<?php echo $po_no;?>">
                            <input type="hidden" name="so_no" id="so_no" value="<?php echo $so_no;?>">
                        </select>
                        <span style="font-size: 11px;">* Bundle Ticket Part.</span>
                    </div>
                </div>



<!--                <div class="col-md-3">-->
<!--                    <div class="form-group">-->
<!--                        <select required class="form-control" id="part" name="part">-->
<!--                            <option value="">Select Part</option>-->
<!--                            <option value="collar_outer">Collar Outer</option>-->
<!--                            <option value="cuff_outer">Cuff Outer</option>-->
<!--                            <option value="back">Back</option>-->
<!--                            <option value="front_l">Front_L</option>-->
<!--                            <option value="front_r">Front_R</option>-->
<!--                            <option value="yoke_upper">Yoke_Outer</option>-->
<!--                            <option value="yoke_inner">Yoke_Inner</option>-->
<!--                            <option value="sleeve_r">Sleeve_R</option>-->
<!--                            <option value="sleeve_l">Sleeve_L</option>-->
<!--                            <option value="slv_plkt_r">SLV_PLKT_R</option>-->
<!--                            <option value="slv_plkt_l">SLV_PLKT_L</option>-->
<!--                            <option value="pocket">Pocket</option>-->
<!--                            <option value="collar_inner">Collar_Inner</option>-->
<!--                            <option value="collar_inner_2">Collar_Inner_2</option>-->
<!--                            <option value="collar_outer_2">Collar_Outer_2</option>-->
<!--                            <option value="band_upper">Band_Outer</option>-->
<!--                            <option value="band_inner">Band_Inner</option>-->
<!--                            <option value="cuff_inner">Cuff_Inner</option>-->
<!--                        </select>-->
<!--                        <span style="font-size: 11px;">* Bundle Ticket Parts</span>-->
<!---->
<!--                        <input type="hidden" name="cut_tracking_no" id="cut_tracking_no" value="--><?php //echo $cut_tracking_no;?><!--">-->
<!--                        <input type="hidden" name="po_no" id="po_no" value="--><?php //echo $po_no;?><!--">-->
<!--                        <input type="hidden" name="so_no" id="so_no" value="--><?php //echo $so_no;?><!--">-->
<!--                    </div>-->
<!--                </div>-->


                <div class="col-md-3">
                    <div class="form-group">
                        <button class="btn btn-success" name="submit_btn" id="submit_btn" onclick="generateBundleTicket();">
                            Generate Ticket
                        </button>
                    </div>
                </div>

            </div>
        </div>





    </div>
    <br />

    <div class="row" id="report_content">

    </div>
</div>

<script type="text/javascript">
    $('select').select2();

    function generateBundleTicket() {
        var part_name = $("#part").val();
        var po_no = $("#po_no").val();
        var so_no = $("#so_no").val();

        var cut_tracking_no = $("#cut_tracking_no").val();

//        $.ajax({
//            url: "<?php //echo base_url();?>//access/generateBundleTicketOtherParts/",
//            type: "POST",
//            data: {part_name: part_name, cut_tracking_no: cut_tracking_no},
//            dataType: "html",
//            success: function (data) {
//            }
//        });

        window.open('<?php echo base_url();?>access/generateBundleTicketOtherParts/'+part_name+'/'+po_no+'/'+so_no+'/'+cut_tracking_no, '_blank');
    }
</script>