<div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
          <h1>Change Password</h1>
          <h2 class="">Change Password...</h2>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">Change Password</li>
          </ol>
        </div>
      </div>
      <div class="container clear_both padding_fix">
        <!--\\\\\\\ container  start \\\\\\-->
        <div class="row center">
        <div class="col-lg-12 ">
        <section class="panel default green_title h2">
        <div class="panel-heading border">Change Password</div>
        <form role="form" class="form-horizontal" action="<?php echo base_url(); ?>access/changing_password" method="post">
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
                    <label class="col-sm-3"><b>Old Password</b> <span style="color: red;">*</span></label>
                  <div class="col-sm-4">
                  	  <input type="password" placeholder="Type Old Password" name="old_password" 
                      id="old_password" onblur="isOldPasswordExist();"
                      class="form-control" required>
                      <b><span id="error_message" style="color: red"></span></b>
                  </div>
                </div>
                </div>
                <div class="row">
                <div class="form-group">
                    <label class="col-sm-3"><b>New Password</b> <span style="color: red;">*</span></label>
                  <div class="col-sm-4">
                      <input type="password" readonly="readonly" placeholder="Type New Password" name="new_password" 
                      id="new_password" onblur="isMatchedNewPassword();" class="form-control" required>
                      <b><span id="error_message_1" style="color: red"></span></b>
                      <b><span id="error_message_2" style="color: red"></span></b>
                  </div>
                </div>
                </div>
                <div class="row">
                <div class="form-group">
                    <label class="col-sm-3"><b>Confirm New Password</b> <span style="color: red;">*</span></label>
                  <div class="col-sm-4">
                      <input type="password" readonly="readonly" placeholder="Type New Password Again" 
                      name="confirm_new_password" onblur="isMatchedNewPassword();" id="confirm_new_password" 
                      class="form-control" required>
                  </div>
                </div>
                </div><br />
         
        <div class="row">
            <div class="form-group">
                <div class="col-sm-3"></div>
                <div class="col-sm-2">
                    <button class="btn btn-primary" id="submit_btn" disabled="disabled">Change Password</button>
                </div>
                <div class="col-sm-1">
                    <button class="btn btn-primary" id="reset_btn" type="reset">Reset</button>
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
	
    		function isOldPasswordExist(){
				var old_password = $("#old_password").val();
				var error_message = $("#error_message").val();
				
				$.ajax({
					url: "<?php echo base_url();?>access/isOldPasswordExist/",
					type: "POST",
					data: {old_password:old_password},
					dataType: "json",
					success: function (data) {
						if(data.length != 0){
							$("#new_password").attr("readonly", false);
							$("#confirm_new_password").attr("readonly", false);
							$("#error_message").text("");
						}
						else{
							$("#submit_btn").attr("disabled", true);
							$("#new_password").attr("readonly", true);
							$("#confirm_new_password").attr("readonly", true);
							$("#error_message").text("Entered Password is Wrong!");
						}
						
					}
				});
			}
			
			function isMatchedNewPassword(){
				
					var old_password = $("#old_password").val();
					var new_password = $("#new_password").val();
					var confirm_new_password = $("#confirm_new_password").val();
					//console.log(old_password);
					
					if(old_password.length == 0 || new_password.length == 0  || confirm_new_password.length == 0 ){
						$("#submit_btn").attr("disabled", true);
					}
					
					if((old_password == new_password) || (old_password == confirm_new_password)){
							$("#error_message_1").text("Previous Password cannot be used as New Password!");
							$("#submit_btn").attr("disabled", true);
					}else{
						$("#error_message_1").text("");
						//$("#submit_btn").attr("disabled", false);
					}
					
					//var pass_length = new_password.length;
//					
//					if(pass_length <= 6){
//						$("#error_message_2").text("Password Lenth 6-Characters required!");
//						$("#submit_btn").attr("disabled", true);
//					}else{
//						$("#error_message_2").text("");
//					}
					
					if((new_password == confirm_new_password) && (old_password != confirm_new_password)
						&& (confirm_new_password.length != 0) && (new_password.length != 0)){
						$("#submit_btn").attr("disabled", false);
					}
					//else{
//						$("#submit_btn").attr("disabled", true);
//					}
				
			}
			//function disableBtn(){
//				document.getElementById("submit_btn").disabled = true;
//			}
    </script>