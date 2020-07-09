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


<div class="row" style="padding-left: 10px">
    <div class="form-group">

        <div class="col-md-3">
            <div class="form-group">
                <select required type="text" class="form-control" id="po_no" name="po_no">

                    <option value="">Select PO No...</option>
                    <?php foreach ($sap_no as $v){ ?>
                        <option value="<?php echo $v['po_no'];?>"><?php echo $v['po_no'];?></option>
                    <?php } ?>
                </select>
                <span style="font-size: 11px;">* PO No.</span>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
<!--                <select required type="text" class="form-control" id="part" name="part[]">-->
                    <select class="form-control" name="part[]" id="part" multiple data-placeholder="Select Part">

                    <option value="">Select Part Name...</option>
                    <?php foreach ($part_name as $v){ ?>
                        <option value="<?php echo $v['part_code'];?>"><?php echo $v['part_name'];?></option>

                    <?php } ?>

                </select>
                <span style="font-size: 11px;">* Part Name.</span>
            </div>
        </div>


<!--        <div class="col-md-3">-->
<!--            <div class="form-group">-->
<!--<!--                <select required class="form-control" id="part" name="part">-->-->
<!--                    <select class="form-control" name="part[]" id="part" multiple data-placeholder="Select Part">-->
<!--                    <option value="">Select Part</option>-->
<!--                    <option value="back">Back</option>-->
<!--                    <option value="front_l">Front_L</option>-->
<!--                        <option value="front_r">Front_R</option>-->
<!--                    <option value="yoke_upper">Yoke_Outer</option>-->
<!--                    <option value="yoke_inner">Yoke_Inner</option>-->
<!--                    <option value="sleeve_r">Sleeve_R</option>-->
<!--                    <option value="sleeve_l">Sleeve_L</option>-->
<!--                    <option value="slv_plkt_r">SLV_PLKT_R</option>-->
<!--                    <option value="slv_plkt_l">SLV_PLKT_L</option>-->
<!--                    <option value="pocket">Pocket</option>-->
<!--                    <option value="collar_inner">Collar_Inner</option>-->
<!--                    <option value="collar_inner_2">Collar_Inner_2</option>-->
<!--                    <option value="collar_outer_2">Collar_Outer_2</option>-->
<!--                    <option value="band_upper">Band_Outer</option>-->
<!--                    <option value="band_inner">Band_Inner</option>-->
<!--                    <option value="cuff_inner">Cuff_Inner</option>-->
<!--                </select>-->
<!--                <span style="font-size: 11px;">* SO No.</span>-->
<!--            </div>-->
<!--        </div>-->


        <div class="col-md-3"style="padding-top: 6px" >
            <div class="form-group">
                <button onclick="generateBundleTicket()">Save Part</button>
            </div>
        </div>


    </div>
</div>







<script type="text/javascript">
    $('select').select2();

    function generateBundleTicket() {
        var part_name = $("#part").val();
        var po_no = $("#po_no").val();
        var part_string = part_name.toString();
        console.log(part_name);
        console.log(po_no);
        //        console.log(part_string);
        var cut_tracking_no = $("#cut_tracking_no").val();

        $.ajax({
            url: "<?php echo base_url();?>access/poPartInsert/",
            type: "POST",
            data: {part_name: part_name, po_no: po_no},
            dataType: "html",
            success: function (data) {
                alert('Part Uploded Successfully');
                location.reload(true);
            }
        });

//        window.open('<?php //echo base_url();?>//access/generateBundleTicketOtherParts/'+part_name+'/'+po_no+'/'+so_no+'/'+cut_tracking_no, '_blank');
    }
</script>