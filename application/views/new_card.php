<div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
          <h1>New Card</h1>
          <h2 class="">New Card...</h2>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">New Card</li>
          </ol>
        </div>
      </div>
      <div class="container clear_both padding_fix">
        <!--\\\\\\\ container  start \\\\\\-->
        <div class="row center">
        <div class="col-lg-12 ">
        <section class="panel default green_title h2">
        <div class="panel-heading border">New Card</div>
        <form role="form" class="form-horizontal" action="<?php echo base_url(); ?>access/adding_new_card" method="post">
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
                    <label class="col-sm-2"><b>Company</b> <span style="color: red;">*</span></label>
                  <div class="col-sm-4">
                    <select name="company_id" class="form-control" required>
                        <option>Select Company...</option>
                        <?php foreach ($companies as $v){?>
                        <option value="<?php echo $v['id']?>"><?php echo $v['company_name']?></option>
                        <?php } ?>
                    </select>
                  </div>
                </div>
                </div><br />
         
                <div class="row">
                <div class="form-group">
                  <label class="col-sm-2"><b>User ID</b> <span style="color: red;">*</span></label>
                  <div class="col-sm-4">
                      <input type="text" placeholder="Type User ID" name="user_id" id="user_id" onkeyup="isUserIDExist();" class="form-control" required>
                  </div>
                </div>
                </div><br />
                
                <div class="row">
                <div class="form-group">
                  <label class="col-sm-2"><b>Card No.</b> <span style="color: red;">*</span></label>
                  <div class="col-sm-4">
 <input type="text" placeholder="Type Card No." name="card_no" id="card_no" onkeyup="isCardNoExist();" class="form-control" required>
                  </div>
                </div>
                </div><br />
                
                <div class="row">
                <div class="form-group">
                  <label class="col-sm-2"><b>Vehicle Size</b>  <span style="color: red;">*</span></label>
                  <div class="col-sm-4">
                    <select name="vehicle_type_id" class="form-control" required>
                        <option>Select Vehicle Size...</option>
                        <?php foreach ($v_sizes as $v){?>
                        <option value="<?php echo $v['id']?>"><?php echo $v['vehicle_type']?></option>
                        <?php } ?>
                    </select>
                  </div>
                </div>
                </div><br />
         </div>
        
        <div class="row">
            <div class="form-group">
                <div class="col-sm-2"></div>
                <div class="col-sm-1">
                   <?php /*?> <button class="btn btn-primary btn-icon glyphicons envelope" id="submit_btn" disabled="disabled"><i></i> Add Card </button><?php */?>
                   
                    <button class="btn btn-primary" id="submit_btn" disabled="disabled">Add Card</button>
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
    		function isUserIDExist(){
				var user_id = $("#user_id").val();
				
				$.ajax({
					url: "<?php echo base_url();?>access/isUserIDExist/",
					type: "POST",
					data: {user_id:user_id},
					dataType: "json",
					success: function (data) {
						console.log(data);
						if(data.length != ''){
							alert("Sorry, User ID is Already Exist!");
							$("#user_id").val('');
							document.getElementById("submit_btn").disabled = true;
						}
						if(data.length == 0){
							document.getElementById("submit_btn").disabled = false;
						}
						
					}
				});
			}
			
			function isCardNoExist(){
				var card_no = $("#card_no").val();
				
				$.ajax({
					url: "<?php echo base_url();?>access/isCardNoExist/",
					type: "POST",
					data: {card_no:card_no},
					dataType: "json",
					success: function (data) {
						/*console.log(data);*/
						if(data.length != 0){
							alert("Sorry, The Card No Already Exist!");
							$("#card_no").val('');
							document.getElementById("submit_btn").disabled = true;
						}
						if(data.length == 0){
							document.getElementById("submit_btn").disabled = false;
						}
						
					}
				});
			}
    </script>