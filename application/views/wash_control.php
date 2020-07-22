<div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
          <h1>Wash Control</h1>
          <h2 class="">Wash Control...</h2>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">Wash Control</li>
          </ol>
        </div>
      </div>
<div class="container clear_both padding_fix">
    <!--\\\\\\\ container  start \\\\\\-->
    <div class="row">
        <div class="form-group">
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <select required class="form-control" id="po_no" name="po_no" onchange="getPoItemDetail();">
                            <option value="">SO_PO_ITEM_QUALITY_COLOR_STYLE_STYLE NAME_ExFacDate</option>
                            <?php
                            foreach ($purchase_order_nos as $pos){ ?>
                                <option value="<?php echo $pos['so_no'].'_'.$pos['po_no'].'_'.$pos['purchase_order'].'_'.$pos['item'].'_'.$pos['quality'].'_'.$pos['color'];?>"><?php echo $pos['so_no'].'_'.$pos['po_no'].'_'.$pos['purchase_order'].'_'.$pos['item'].'_'.$pos['quality'].'_'.$pos['color'].'_'.$pos['style_no'].'_'.$pos['style_name'].'_'.$pos['ex_factory_date'];?></option>
                                <?php
                            }
                            //                            ?>
                        </select>
                        <span style="font-size: 11px;">* SO_PO_ITEM_QUALITY_COLOR_STYLE_STYLE NAME</span>
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

    $(document).ready(function(){
        $("#message").empty();
    });

    function getPoItemDetail() {
        $("#report_content").empty();

        var po_no_all = $("#po_no").val();

        var res = po_no_all.split("_");

        var so_no = res[0];
        var po_no = res[1];
        var purchase_order = res[2];
        var item = res[3];
        var quality = res[4];
        var color = res[5];

        $.ajax({
            url: "<?php echo base_url();?>access/getPoDetail/",
            type: "POST",
            data: {so_no: so_no, po_no: po_no, purchase_order: purchase_order, item: item, quality: quality, color: color},
            dataType: "html",
            success: function (data) {
                $("#report_content").append(data);
            }
        });
    }
</script>