<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>Change Approved ExFactory</h1>
        <h2 class="">Change Approved ExFactory...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Change Approved ExFactory</li>
        </ol>
    </div>
</div>

<div class="row" >
    <div class="col-md-12">
        <div class="block-web">
            <div class="header">
                <div class="actions"> <a class="minimize" href="#"><i class="fa fa-chevron-down"></i></a><a class="close-down" href="#"><i class="fa fa-times"></i></a> </div>
                <h3 class="content-header">Change Approved ExFactory</h3>
            </div>
        </div>


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
                <div class="porlets-content">


                </div>

            </div><!--/block-web-->
        </div><!--/col-md-12-->
        <div class="porlets-content">
            <form action="<?php echo base_url();?>access/changingApprovedExfactory" method="post">

                <div id="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div id="set_form">
                                <table class="display table table-bordered table-striped" id="sample_2">
                                    <tbody>
                                    <tr>
                                        <td class="center" colspan="2">
                                            <span id="so_msg" style="color: red;"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="center">SO No *</td>
                                        <td class="center">
                                            <select required id="so_no" class="form-control" name="so_no" onchange="getExfatory();">
                                                <option value="">Select SO No</option>
                                                <?php
                                                $po_type = '';
                                                foreach ($so_nos as $v_s){
                                                    if($v_s['po_type'] == 0){
                                                        $po_type='BULK';
                                                    }
                                                    if($v_s['po_type'] == 1){
                                                        $po_type='SIZE SET';
                                                    }
                                                    if($v_s['po_type'] == 2){
                                                        $po_type='SAMPLE';
                                                    }
                                                ?>
                                                    <option value="<?php echo $v_s['so_no'];?>"><?php echo $v_s['so_no'].'~'.$v_s['purchase_order'].'~'.$v_s['item'].'~'.$v_s['quality'].'~'.$v_s['color'].'~'.$v_s['style_no'].'~'.$v_s['style_name'].'~'.$v_s['ex_factory_date'].'~'.$po_type;?></option>
                                                <?php } ?>
                                            </select>
                                            <span id="" style="color: red;">SO~PO~ITEM~QUALITY~COLOR~StyleNo~StyleName~ExFacDate~TYPE</span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="center">Ex-Factory</td>
                                        <td class="center">
                                            <input type="text" name="ex_factory" id="ex_factory" readonly="readonly" />
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="center">Approved Ex-Factory *</td>
                                        <td class="center">
                                            <input type="text" class="form-control-inline input-small default-date-picker" id="approved_exfactory" name="approved_exfactory" required autocomplete="off" />
                                        </td>
                                    </tr>


                                    <tr>
                                        <td class="center"></td>
                                        <td class="center">
                                            <button type="submit" class="btn btn-success" id="submit_btn" name="submit_btn">Save</button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div><!--/porlets-content-->

    </div><!--/col-md-12-->
</div><!--/row-->

<script type="text/javascript">
    $('#so_no').select2();


    function getExfatory() {

        $("#ex_factory").empty();

        var so_no = $("#so_no").val();
        var target_exfactory = $("#target_exfactory").val();


            $.ajax({
                url: "<?php echo base_url();?>access/getExfactory/",
                type: "POST",
                data: {so_no: so_no},
                dataType: "json",
                success: function (data) {
                    $("#ex_factory").val(data[0].ex_factory_date);

                    var str_date = data[0].approved_ex_factory_date;
                    var splitArr = str_date.split('-');

                    var yr = splitArr[0];
                    var mon = splitArr[1];
                    var dt = splitArr[2];

                    var approved_ship_date =  mon+'-'+dt+'-'+yr;
                    $("#approved_exfactory").val(approved_ship_date);

                }
            });



    }

</script>