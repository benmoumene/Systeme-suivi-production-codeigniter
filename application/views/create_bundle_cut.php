
<script type="text/javascript">
	$(function(){
		$('#btnExport').click(function(){
			var url='data:application/vnd.ms-excel,' + encodeURIComponent($('#tableWrap').html()) 
			location.href=url
			return false
		})
	})
</script>
<?php foreach ($po_info_cut as $key => $v){
    $po_no = $v['po_no'];
    $style_no = $v['style_no'];
    $style_name = $v['style_name'];
    $color = $v['color'];
}
?>
<div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
          <h1>Create Bundle Cut</h1>
          <h2 class="">Create Bundle Cut...</h2>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">Create Bundle Cut</li>
          </ol>
        </div>
      </div>
      <div class="container clear_both padding_fix">
        <!--\\\\\\\ container  start \\\\\\-->
        <div class="row">
        <div class="col-md-12">
          <div class="block-web">
            <div class="header">
<!--              <div class="actions"> <button class="btn btn-primary" style="color: #FFF;" id="btnExport"><b>Export Excel</b></button> </div>-->
              <h3 class="content-header">Create Bundle Cut</h3>
            </div>
      <form role="form" class="form-horizontal" action="<?php echo base_url();?>access/bundle_creation" method="post">
         <div class="porlets-content">
          <div class="row"> 
            <div class="form-group">
            	<div class="col-md-2">
                    <b>Production Order: </b><input type="text" value="<?php echo $po_no;?>" class="form-control" required name="po_no" id="po_no" readonly />
                </div>
                <div class="col-md-1">
                    <b>Style No: </b><input type="text" value="<?php echo $style_no;?>" class="form-control" required name="style_no" id="style_no" readonly />
                </div>
                <div class="col-md-1">
                    <b>Style Name: </b><input type="text" value="<?php echo $style_name;?>" class="form-control" required name="style_name" id="style_name" readonly />
                </div>
                <div class="col-md-1">
                    <b>Color: </b><input type="text" value="<?php echo $color;?>" class="form-control" required name="color" id="color" readonly />
                </div>
<!--                <div class="col-md-2">-->
<!--                    <b>Quality: </b>-->
<!--                    <select value="--><?php //echo $quality;?><!--" class="form-control" name="quality" id="quality">-->
<!--                        <option value="">Select Quality...</option>-->
<!--                        --><?php //foreach ($po_info_cut as $v){?>
<!--                            <option value="--><?php //echo $v['quality'];?><!--">--><?php //echo $v['quality'];?><!--</option>-->
<!--                        --><?php //} ?>
<!--                    </select>-->
<!--                </div>-->
                <div class="col-md-1">
                    <b>Cut No: </b><input type="text" value="<?php echo '';?>" class="form-control" required name="cut_no" id="cut_no" readonly />
                </div>
                <div class="col-md-1">
                    <b>Lay: <span style="color: red;">*</span></b><input type="text" class="form-control" required name="lay" id="lay" />
                </div>
               </div>
             </div>
             <br />
             <br />
            <div class="row">
<!--            <div class="form-group">-->
<!--                <div class="col-md-4"></div>-->
<!--                <div class="col-md-6">-->
<!--                    <table>-->
<!--                        <tr>-->
<!--                            <td><input type="radio" name="submit_type" id="grouping"></td>-->
<!--                            <td>Grouping</td>-->
<!--                            <td><input type="radio" name="submit_type" id="continuous"</td>-->
<!--                            <td>Continuous</td>-->
<!--                        </tr>-->
<!--                    </table>-->
<!--                </div>-->
<!--                <div class="col-md-2"></div>-->
<!--             </div>-->
          </div>
             <br />
             <br />
         <div class="porlets-content">
         <div class="table-responsive" id="tableWrap">
                <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="sample_3">
                  <thead>
                    <tr>
                      <th class="hidden-phone" style="text-align:center;">	Size </th>
                      <th class="hidden-phone" style="text-align:center;">	Quality </th>
                      <th class="hidden-phone" style="text-align:center;">	Quantity </th>
                      <th class="hidden-phone" style="text-align:center;"><input type="text" name="common_marker" id="common_marker" placeholder="Common Marker" onblur="markerCopy('common_marker');"></th>
                      <th class="hidden-phone" style="text-align:center;"><input type="text" name="common_bundle_ration" id="common_bundle_ration" placeholder="Common Bundle Ratio" onblur="bundleRatioCopy('common_bundle_ration');" ></th>
                      <th class="hidden-phone" style="text-align:center;"><input type="text" name="common_lot" id="common_lot" placeholder="Common Lot" onblur="lotCopy('common_lot');" ></th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($po_info_cut as $key => $v){ ?>
                    <tr class="gradeX">
                      <td class="center hidden-phone">
                          <?php echo $v['size']?>
                          <input type="hidden" name="po_no_id[]" id="po_no_id<?php echo $key;?>" value="<?php echo $v['id'];?>">
                          <input type="hidden" name="size[]" id="size<?php echo $key;?>" value="<?php echo $v['size'];?>">
                      </td>
                      <td class="center hidden-phone">
                          <?php echo $v['quality']?>
                          <input type="hidden" name="quality[]" id="quality<?php echo $key;?>" value="<?php echo $v['quality'];?>">
                      </td>
                      <td class="center hidden-phone"><?php echo $v['quantity']?><input type="hidden" name="quantity[]" id="quantity<?php echo $key;?>" value="<?php echo $v['quantity'];?>"></td>
                      <td class="center hidden-phone"><input type="text" class="marker" name="marker[]" id="marker<?php echo $key;?>" ></td>
                      <td class="center hidden-phone"><input type="text" class="bundle_ratio" name="bundle_ratio[]" id="bundle_ratio<?php echo $key;?>" ></td>
                      <td class="center hidden-phone"><input type="text" class="lot" name="lot[]" id="lot<?php echo $key;?>" ></td>
                    </tr>
                  <?php } ?>
                  </tbody>
                </table>
              </div><!--/table-responsive-->
              </div>
             <button class="btn btn-primary" name="save_btn">Save</button>

           </div><!--/porlets-content-->
      </form>
          </div><!--/block-web--> 
        </div><!--/col-md-12--> 
      </div>
      

<script type="text/javascript">
	
    function getInOutCostReport() {
        var month = document.getElementById("month").value;
        var year = document.getElementById("year").value;
		var company = document.getElementById("company").value;
		
        $("#sample_3 tbody tr").remove();


        $.ajax({
            url: "<?php echo base_url();?>access/getInOutCostReport/",
            type: "POST",
            data: {month:month, year:year, company:company},
            dataType: "html",
            success: function (data) {
                $('#sample_3 tbody').append(data);
            }
        });
    }

    function markerCopy(id) {
        var marker_val = $('#'+id).val();

        $('.marker').val(marker_val);
    }

    function bundleRatioCopy(id) {
        var bundle_ratio_val = $('#'+id).val();

        $('.bundle_ratio').val(bundle_ratio_val);
    }

    function lotCopy(id) {
        var lot_val = $('#'+id).val();

        $('.lot').val(lot_val);
    }
</script>