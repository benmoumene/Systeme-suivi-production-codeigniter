
<script type="text/javascript">
	$(function(){
		$('#btnExport').click(function(){
			var url='data:application/vnd.ms-excel,' + encodeURIComponent($('#tableWrap').html()) 
			location.href=url
			return false
		})
	})
</script>

<div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
          <h1>Report</h1>
          <h2 class="">Report...</h2>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">Report</li>
          </ol>
        </div>
      </div>
      <div class="container clear_both padding_fix">
        <!--\\\\\\\ container  start \\\\\\-->
        <div class="row">
        <div class="col-md-12">
          <div class="block-web">
            <div class="header">
              <div class="actions"> <button class="btn btn-primary" style="color: #FFF;" id="btnExport"><b>Export Excel</b></button> </div>
              <h3 class="content-header">Vehicle In-Out Report</h3>
            </div>
         <div class="porlets-content">
          <div class="row"> 
            <div class="form-group">
            	<div class="col-md-3">
                   <select class="form-control" required id="company">
                       <option>Select Company...</option>
                       <?php foreach($companies as $v){?>
                       	<option value="<?php echo $v['company_name']?>"><?php echo $v['company_name']?></option>
                       <?php } ?>
                   </select>
                 </div>
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
                       <!--<option selected="selected"><?php //echo date('Y');?></option>-->
                       <?php foreach($years as $v){?>
                       <option><?php echo $v['year'] ?></option>
                       <?php } ?>
                   </select>
                 </div>
               	<div class="col-md-3 ">
                    
         			<input class="btn btn-success" onclick="getInOutCostReport();" id="btn_search" type="button" value="Search" />
         
                 </div>
               </div>
             </div>
          </div>
         <div class="porlets-content">
         <div class="table-responsive" id="tableWrap">
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

</script>