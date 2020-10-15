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
          <h1>Manual Carton</h1>
          <h2 class="">Manual Carton...</h2>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">Manual Carton</li>
          </ol>
        </div>
      </div>
      <div class="container clear_both padding_fix">
        <!--\\\\\\\ container  start \\\\\\-->
        <div class="row">
            <div class="col-md-12">
              <div class="col-md-3">
                  <select class="form-control" name="warehouse_type" id="warehouse_type">
                      <option value="">Select Warehouse Type</option>
                      <?php foreach ($wh_types as $v_1){
                          if($v_1['id'] != 5){
                              ?>
                              <option value="<?php echo $v_1['id']?>"><?php echo $v_1['warehouse_type']?></option>
                              <?php
                          }
                      }
                      ?>
                  </select>
                  <span><b>* Select Warehouse Type</b></span>
              </div>
              <div class="col-md-3">
                  <span class="btn btn-primary" onclick="saveToWarehouse()">SAVE</span>
              </div>
              <div class="col-md-4"></div>
                <div class="col-md-2">
                    <a class="btn btn-warning" href="<?php echo base_url();?>access/cartonCompleteListBySoSize/<?php echo $so_no;?>/<?php echo $size;?>">CARTON COMPLETE LIST</a>
                </div>
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-md-12">
                <div class="block-web">

                    <div class="porlets-content">

                        <div class="table-responsive">

                            <table class="display table table-bordered table-striped" id="table_id">
                                <thead>
                                    <tr>
                                        <th class="hidden-phone center">
                                            <button class="btn btn-success" onclick="addToCarton()">ADD To CARTON</button>
                                        </th>
                                        <th class="hidden-phone center" colspan="8">
                                            <h3><b>CARTON INCOMPLETE LIST</b></h3>
                                        </th>
                                        <th class="hidden-phone center">
                                            <h3><b>Size: <?php echo $size;?></b></h3>
                                        </th>
                                    </tr>
                                    <tr style="font-size: 15px; font-weight: 900;">
                                        <th class="hidden-phone center"><input type="checkbox" id="checkAll"/></th>
                                        <th class="hidden-phone center">Piece No.</th>
                                        <th class="hidden-phone center">SIZE</th>
                                        <th class="hidden-phone center">SO</th>
                                        <th class="hidden-phone center">PO</th>
                                        <th class="hidden-phone center">ITEM</th>
                                        <th class="hidden-phone center">QUALITY</th>
                                        <th class="hidden-phone center">COLOR</th>
                                        <th class="hidden-phone center">STYLE</th>
                                        <th class="hidden-phone center">Last Scan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php

                                foreach ($balance_pcs AS $b){

                                    $last_scanning_point = "";

                                    if($b['warehouse_qa_type'] == 1){
                                        $last_scanning_point = "Buyer Warehouse";
                                    } elseif($b['warehouse_qa_type'] == 2){
                                        $last_scanning_point = "Factory Warehouse";
                                    } elseif($b['warehouse_qa_type'] == 3){
                                        $last_scanning_point = "Trash";
                                    } elseif($b['warehouse_qa_type'] == 4){
                                        $last_scanning_point = "Production Sample Warehouse";
                                    } elseif($b['warehouse_qa_type'] == 5){
                                        $last_scanning_point = "Other Purpose";
                                    } elseif($b['warehouse_qa_type'] == 6){
                                        $last_scanning_point = "Lost";
                                    } elseif($b['warehouse_qa_type'] == 7){
                                        $last_scanning_point = "Size Set";
                                    } elseif($b['carton_status'] == 1){
                                        $last_scanning_point = "Carton";
                                    } elseif($b['packing_status'] == 1){
                                        $last_scanning_point = "Packing";
                                    } elseif($b['washing_status'] == 1){
                                        $last_scanning_point = "Wash Return";
                                    } elseif($b['is_going_wash'] == 1){
                                        $last_scanning_point = "Wash Send";
                                    } elseif(($b['access_points'] == 4) && ($b['access_points_status'] == 4)){
                                        $last_scanning_point = "End Line";
                                    } elseif(($b['access_points'] == 4) && ($b['access_points_status'] == 2)){
                                        $last_scanning_point = "Mid Line";
                                    } elseif($b['access_points'] == 3){
                                        $last_scanning_point = "Mid Line";
                                    } elseif($b['access_points'] == 2){
                                        $last_scanning_point = "Input Line";
                                    } elseif($b['sent_to_production'] == 1){
                                        $last_scanning_point = "Cutting";
                                    } elseif($b['sent_to_production'] == 0){
                                        $last_scanning_point = "Cutting not Sent";
                                    }

                                ?>
                                    <tr>
                                        <td class="hidden-phone center">
                                            <input class="checkItem" type="checkbox" name="checkItem[]" id="checkItem" value="<?php echo $b['pc_tracking_no'];?>">
                                        </td>
                                        <td class="hidden-phone center"><?php echo $b['pc_tracking_no'];?></td>
                                        <td class="hidden-phone center"><?php echo $b['size'];?></td>
                                        <td class="hidden-phone center"><?php echo $b['so_no'];?></td>
                                        <td class="hidden-phone center"><?php echo $b['purchase_order'];?></td>
                                        <td class="hidden-phone center"><?php echo $b['item'];?></td>
                                        <td class="hidden-phone center"><?php echo $b['quality'];?></td>
                                        <td class="hidden-phone center"><?php echo $b['color'];?></td>
                                        <td class="hidden-phone center"><?php echo $b['style_no'];?></td>
                                        <td class="hidden-phone center">
                                            <?php echo $last_scanning_point;?>
                                            <input type="hidden" class="last_scan" name="last_scan[]" id="last_scan" value="<?php echo $last_scanning_point;?>" />
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div><!--/table-responsive-->
                    </div>

                </div><!--/porlets-content-->
            </div><!--/block-web-->
        </div><!--/col-md-12-->

      </div>

<script type="text/javascript">

    $('select').select2();

    $(document).on('click','#checkAll',function () {
        $('.checkItem').not(this).prop('checked', this.checked);
    });


    function addToCarton(){
        var pcs_nos = [];
        var last_scan_points = [];

        $('input.checkItem:checkbox:checked').each(function () {
            var sThisVal = $(this).val();

            pcs_nos.push(sThisVal);

        });

        if(pcs_nos.length > 0){
            $.ajax({
                url:"<?php echo base_url('access/addToCarton')?>",
                type:"post",
                dataType:"html",
                data:{ pcs_nos: pcs_nos },
                success:function (data) {
                    if(data='done'){
                        alert('Process Successful!');
                        location.reload();
                    }
                }
            });
        }else{
            alert('Sorry, No Pieces are Selected !');
        }
    }

    function saveToWarehouse() {
        var pcs_nos = [];
        var last_scan_points = [];

        $('input.checkItem:checkbox:checked').each(function () {
            var sThisVal = $(this).val();

            pcs_nos.push(sThisVal);

        });

        $('input.last_scan').each(function () {
            var sThisVal = $(this).val();

            last_scan_points.push(sThisVal);

        });

        var warehouse_type = $("#warehouse_type").val();

        if(warehouse_type != ''){
            if(pcs_nos.length > 0){
                $.ajax({
                    url:"<?php echo base_url('access/saveToWarehouse')?>",
                    type:"post",
                    dataType:"html",
                    data:{ pcs_nos: pcs_nos, warehouse_type: warehouse_type },
                    success:function (data) {
                        if(data='done'){
                            alert('Process Successful!');
                            location.reload();
                        }
                    }
                });
            }else{
                alert('Sorry, No Pieces are Selected !');
            }
        }else{
            alert('Please Select Warehouse Type !');
        }

    }

</script>