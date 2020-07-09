<div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
          <h1>QA Warehouse</h1>
          <h2 class="">QA Warehouse...</h2>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">QA Warehouse</li>
          </ol>
        </div>
      </div>
      <div class="container clear_both padding_fix">
        <!--\\\\\\\ container  start \\\\\\-->
        <form action="<?php echo base_url();?>access/saveAsWarehouse" method="post">
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
                    <input type="text" class="form-control" placeholder="Warehouse Type Code" name="warehouse_code" autofocus required id="warehouse_code" onkeyup="blurToCarelabelnoField();" />
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" placeholder="Indentity Label Code" readonly name="carelabel_tracking_no" required id="carelabel_tracking_no" onkeyup="clickToSubmitBtn();" />
                    <button style="display: none;" id="submit_btn" class="btn btn-success">Send</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 scroll">
                    <div class="block-web">

                        <div class="porlets-content">

                            <div class="table-responsive">
                                <table class="display table table-bordered table-striped" id="">
                                    <thead>
                                    <tr>
                                        <th class="hidden-phone" colspan="6"></th>
                                        <th class="hidden-phone center" colspan="1">Cutting</th>
                                        <th class="hidden-phone center" colspan="1">Sewing</th>
                                        <th class="hidden-phone center" colspan="2">Finishing</th>
                                        <th class="hidden-phone center" colspan="4">Warehouse</th>
                                        <th class="hidden-phone center" rowspan="2"><span data-toggle="tooltip" title="Balance Qty">Balance</span></th>
                                    </tr>
                                    <tr>
                                        <th class="hidden-phone center">PO-ITEM</th>
                                        <th class="hidden-phone center">Brand</th>
                                        <th class="hidden-phone center">STL</th>
                                        <th class="hidden-phone center">QL-CLR</th>
                                        <th class="hidden-phone center">OQ</th>
                                        <th class="hidden-phone center">ExFac</th>
                                        <th class="hidden-phone center"><span data-toggle="tooltip" title="Cut Pass QTY">Cut Pass</span></th>
                                        <th class="hidden-phone center"><span data-toggle="tooltip" title="End-Line Pass QTY">End Line</span></th>
                                        <th class="hidden-phone center"><span data-toggle="tooltip" title="Pack QTY">Pack</span></th>
                                        <th class="hidden-phone center"><span data-toggle="tooltip" title="Carton QTY">CTN</span></th>
                                        <th class="hidden-phone center"><span data-toggle="tooltip" title="Warehouse Production Sample">Sample</span></th>
                                        <th class="hidden-phone center"><span data-toggle="tooltip" title="Warehouse Factory">Factory</span></th>
                                        <th class="hidden-phone center"><span data-toggle="tooltip" title="Warehouse Buyer">Buyer</span></th>
                                        <th class="hidden-phone center"><span data-toggle="tooltip" title="Warehouse Trash">Trash</span></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($prod_summary as $k => $v) {

                                        $total_finishing_qa = $v['count_carton_pass'] + $v['count_wh_prod_sample'] + $v['count_wh_factory'] + $v['count_wh_buyer'] + $v['count_wh_trash'];

                                        if (($v['total_cut_qty'] - $total_finishing_qa) != 0) {
                                    ?>
                                            <tr>
                                                <td class="hidden-phone center"><span
                                                            style="color: #727dff; cursor: pointer;"
                                                            onclick="getSizeWiseReport('<?php echo $v['po_no'];?>', '<?php echo $v['purchase_order']; ?>','<?php echo $v['item']; ?>');"><?php echo $v['purchase_order'] . '-' . $v['item']; ?></span>
                                                </td>
                                                <td class="hidden-phone center"><?php echo $v['brand']; ?></td>
                                                <td class="hidden-phone center"><?php echo $v['style_no'] . '-' . $v['style_name']; ?></td>
                                                <td class="hidden-phone center"><?php echo $v['quality'] . '-' . $v['color']; ?></td>
                                                <td class="hidden-phone center"><?php echo $v['total_order_qty']; ?></td>
                                                <td class="hidden-phone center"><?php echo $v['ex_factory_date']; ?></td>
                                                <td class="hidden-phone center"><?php echo $v['total_cut_input_qty']; ?></td>
                                                <td class="hidden-phone center"><?php echo $v['count_end_line_qc_pass']; ?></td>
                                                <td class="hidden-phone center"><?php echo $v['count_packing_pass']; ?></td>
                                                <td class="hidden-phone center"><?php echo $v['count_carton_pass']; ?></td>
                                                <td class="hidden-phone center" style="background-color: darkblue; color: #ffffff; font-size: 19px;"><?php echo $v['count_wh_prod_sample']; ?></td>
                                                <td class="hidden-phone center" style="background-color: #55222c; color: #ffffff; font-size: 19px;"><?php echo $v['count_wh_factory']; ?></td>
                                                <td class="hidden-phone center" style="background-color: darkgreen; color: #ffffff; font-size: 19px;"><?php echo $v['count_wh_buyer']; ?></td>
                                                <td class="hidden-phone center" style="background-color: darkred; color: #ffffff; font-size: 19px;"><?php echo $v['count_wh_trash']; ?></td>
                                                <td class="hidden-phone center">
                                                    <?php echo $v['total_cut_qty'] - $total_finishing_qa; ?>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div><!--/table-responsive-->
                        </div>

                    </div><!--/porlets-content-->
                </div><!--/block-web-->
            </div><!--/col-md-12-->
        </form>
          <div class="row">
              <div class="col-md-8 scroll2">
                  <div class="block-web">

                      <div class="porlets-content">

                          <div class="table-responsive" id="size_tbl">
                              <table class="display table table-bordered table-striped">
                                  <thead>
                                  <tr>
                                      <th class="center">Size</th>
                                      <th class="center">Cut</th>
                                      <th class="center">End</th>
                                      <th class="center">Wash</th>
                                      <th class="center">Pack</th>
                                      <th class="center">Carton</th>
                                      <th class="center">Warehouse</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  <tr>
                                      <td class="hidden-phone center"></td>
                                      <td class="hidden-phone center"></td>
                                      <td class="hidden-phone center"></td>
                                      <td class="hidden-phone center"></td>
                                      <td class="hidden-phone center"></td>
                                      <td class="hidden-phone center"></td>
                                      <td class="hidden-phone center"></td>
                                  </tr>
                                  </tbody>
                              </table>
                          </div><!--/table-responsive-->
                      </div>

                  </div><!--/porlets-content-->
              </div><!--/block-web-->
<!--              <div class="col-md-4">-->
<!--                  <div class="block-web">-->
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

              <div class="col-md-3 scroll4">
                  <div class="porlets-content">
                      <div class="table-responsive" id="remain_cl_list">

                      </div>
                  </div>
              </div>

          </div><!--/col-md-12-->
      </div>

<script type="text/javascript">

    $(document).ready(function(){
        $("#message").empty();
    });

    function blurToCarelabelnoField(){
        var wh_code = $("#warehouse_code").val();
        var warehouse_code = wh_code.trim();

        var code_length = warehouse_code.length;

        if(code_length == 8){
            var fst_variable = warehouse_code.charAt(0);
            var last_variable = warehouse_code.slice(-1);
        }

        if(warehouse_code != '' && fst_variable == 'w' && last_variable == '.') {
            $("#carelabel_tracking_no").attr('readonly', false);
            $("#carelabel_tracking_no").focus();
        }
    };

    function clickToSubmitBtn() {
        var cl_no = $("#carelabel_tracking_no").val();
        var care_label_no = cl_no.trim();

        var last_variable = care_label_no.slice(-1);

        var wh_code = $("#carelabel_tracking_no").val();
        var warehouse_code = wh_code.trim();
        var code_length = warehouse_code.length;

        if(code_length == 8){
            var fst_variable = warehouse_code.charAt(0);
        }

        if(care_label_no != '' && fst_variable != 'w' && last_variable == '.'){
            document.getElementById("submit_btn").click();
        }

        if(care_label_no != '' && fst_variable == 'w' && last_variable == '.'){
            $("#carelabel_tracking_no").val('');
        }
    }

    function getSizeWiseReport(so_no, po, item) {
        $("#size_tbl").empty();

        $.ajax({
            url: "<?php echo base_url();?>access/getPoItemWiseSizeWhReport/",
            type: "POST",
            data: {po_no: so_no, purchase_order: po, item: item},
            dataType: "html",
            success: function (data) {
                $("#size_tbl").append(data);
            }
        });
    }

    function getRemainCLs(so_no, purchase_order, item, quality, color, size) {
        $("#remain_cl_list").empty();

        $.ajax({
            url: "<?php echo base_url();?>access/getPoItemWiseSizeRemainWhCL/",
            type: "POST",
            data: {po_no: so_no, purchase_order: purchase_order, item: item, quality: quality, color: color, size: size},
            dataType: "html",
            success: function (data) {
                $("#remain_cl_list").append(data);
            }
        });
    }
</script>