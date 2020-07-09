<div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
          <h1>EXCEL of PO-ITEM-SIZE QTY</h1>
          <h2 class="">EXCEL of PO-ITEM-SIZE QTY...</h2>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">EXCEL of PO-ITEM-SIZE QTY</li>
          </ol>
        </div>
      </div>
      <div class="container clear_both padding_fix">
        <!--\\\\\\\ container  start \\\\\\-->
          <div class="header">
              <div class="actions">
                  <button class="btn btn-primary" style="color: #FFF;" id="btnExport"><b>Export Excel</b></button>
                  <a href="<?php echo base_url();?>uploads/cutting_calculator/tb_size_serial_Cal.xlsx" class="btn btn-success" style="color: #FFF;" id="btnExport2"><b>Export Calculator</b></a>
              </div>
          </div>
        <div class="row center">
        <div class="col-lg-12 ">
        <section class="panel default green_title h2">
        <div class="panel-heading border"></div>
        <form role="form" class="form-horizontal" action="<?php echo base_url(); ?>access/save_smv" method="post">
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
        <div class="porlets-content">
            <div class="row">
                <div class="form-group">
                    <label class="col-md-2"><b>Sales Order</b> <span style="color: red;">*</span></label>
                  <div class="col-md-2">
                      <select name="sales_order" id="sales_order" class="form-control" onchange="getPoItemSizeRemainQty();" required>
                          <option value="">Sales Order</option>
                          <?php foreach ($so_list as $v_so){ ?>
                              <option value="<?php echo $v_so['po_no'];?>"><?php echo $v_so['po_no'];?></option>
                          <?php } ?>
                      </select>
                  </div>
                </div>
                </div>


         
        <div class="row">
            <div class="form-group">
                <div class="col-md-12">
                    <div class="block-web">

                        <div class="porlets-content">

                            <div class="table-responsive" id="size_tbl">
                                <table class="display table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="hidden-phone center">Size</th>
                                            <th class="hidden-phone center">PO-Item</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="hidden-phone center"></td>
                                            <td class="hidden-phone center"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div><br />
        </form>
        </section>
        </div>
            
        </div>
        
      <!--\\\\\\\ container  end \\\\\\-->
    </div>
    
    <script type="text/javascript">
        $('select').select2();

        function getPoItemSizeRemainQty() {
            var sales_order = $("#sales_order").val();

            $("#size_tbl").empty();

            if(sales_order != ''){
                $.ajax({
                    url: "<?php echo base_url();?>access/getPoItemSizeRemainQty/",
                    type: "POST",
                    data: {sales_order: sales_order},
                    dataType: "html",
                    success: function (data) {
                        $("#size_tbl").append(data);
                    }
                });
            }
        }


        $(function(){
            $('#btnExport').click(function(){
                var url='data:application/vnd.ms-excel,' + encodeURIComponent($('#size_tbl').html())
                location.href=url
                return false
            })
        })

    </script>