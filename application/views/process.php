<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Compose New Task</h4>
      </div>
      <div class="modal-body"> content </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
          <h1>Process</h1>
          <h2 class="">Process...</h2>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">Process</li>
          </ol>
        </div>
      </div>
      <div class="container clear_both padding_fix">
        <!--\\\\\\\ container  start \\\\\\-->
        <div class="row">
        <div class="col-md-12">
          <div class="block-web">
            <div class="header">
              <div class="actions"> <a class="minimize" href="#"><i class="fa fa-chevron-down"></i></a> <a class="refresh" href="#"><i class="fa fa-repeat"></i></a> <a class="close-down" href="#"><i class="fa fa-times"></i></a> </div>
              <h3 class="content-header">Vehicle In-Out Process</h3>
            </div>
         <div class="porlets-content">
          <div class="row"> 
            <div class="form-group">
               <div class="col-md-3">
                   <select class="form-control" required id="month">
                       <option>Select Month...</option>
                       <option value="1">January</option>
                       <option value="2">February</option>
                       <option value="3">March</option>
                       <option value="4">April</option>
                       <option value="5">May</option>
                       <option value="6">June</option>
                       <option value="7">July</option>
                       <option value="8">August</option>
                       <option value="9">September</option>
                       <option value="10">October</option>
                       <option value="11">November</option>
                       <option value="12">December</option>
                   </select>
                 </div>
               <div class="col-md-3">
                   <select class="form-control" required id="year">
                       <option>Select Year...</option>
                       <!--<option selected="selected"><?php echo date('Y');?></option>-->
                       <?php foreach($years as $v){?>
                       <option><?php echo $v['year'] ?></option>
                       <?php } ?>
                   </select>
                 </div>
               <div class="col-md-6">
                    
         <input class="btn btn-success" onclick="processAndGetInOutData();" id="btn_search" type="button" value="Process" />
         <input class="btn btn-primary" disabled="disabled" onclick="finalProcess();" id="final_btn_search" type="button" value="Final Process" />
                 </div>
               </div>
             </div>
          </div>
       <div class="porlets-content">
         <div class="table-responsive">
                <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="sample_3">
                  <thead>
                    <tr>
                      <th class="hidden-phone">SL No.</th>
                      <th class="hidden-phone">User ID</th>
                      <th class="hidden-phone">User Name</th>
                      <th class="hidden-phone">Card No.</th>
                      <th class="hidden-phone">In Date</th>
                      <th class="hidden-phone">In Time</th>
                      <th class="hidden-phone">Out Date</th>
                      <th class="hidden-phone">Out Time</th>
                      <th class="hidden-phone">Spending Time</th>
                      <th class="hidden-phone">Vehicle Size</th>
                      <th class="hidden-phone">Cost</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="gradeX">
                      <td></td>
                      <td></td>
                      <td class="hidden-phone"></td>
                      <td class="center hidden-phone"></td>
                      <td class="center hidden-phone"></td>
                      <td class="center hidden-phone"></td>
                      <td class="center hidden-phone"></td>
                      <td class="center hidden-phone"></td>
                      <td class="center hidden-phone"></td>
                      <td class="center hidden-phone"></td>
                      <td class="center hidden-phone"></td>
                    </tr>
                  </tbody>
                </table>
              </div><!--/table-responsive-->
              </div>
         
           </div><!--/porlets-content-->  
          </div><!--/block-web--> 
        </div><!--/col-md-12--> 
      </div>

<script type="text/javascript">
	
	
    function processAndGetInOutData() {
        var month = document.getElementById("month").value;
        var year = document.getElementById("year").value;
		
        $("#sample_3 tbody tr").remove();
        if((month != '') && (year != '')){
			$.ajax({
				url: "<?php echo base_url();?>access/ProcessAndGetInOutData/",
				type: "POST",
				data: {month:month, year:year},
				dataType: "html",
				success: function (data) {
					console.log(data);
					if(data == '<input type="hidden" class="form-control" name="ids" id="ids" value="" required />'){
						document.getElementById("final_btn_search").disabled = true;
					}
					if(data != '<input type="hidden" class="form-control" name="ids" id="ids" value="" required />'){
						document.getElementById("final_btn_search").disabled = false;
					}
					$('#sample_3 tbody').append(data);
				}
			});
		}
    }
	
	
    function finalProcess() {
		if (confirm('Are You Sure to Complete the Process?')) {
			var ids = document.getElementById("ids").value;
			if(ids != ''){
				$.ajax({
					url: "<?php echo base_url();?>access/finalProcessDone/",
					type: "POST",
					data: {ids:ids, process_stage:1},
					dataType: "html",
					success: function (data) {
						alert("Successfully Completed Final Stage.")
						location.reload();
					}
				});
			}
		} 
		
        
    }
</script>