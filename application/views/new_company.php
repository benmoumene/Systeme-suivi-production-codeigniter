<div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
          <h1>New Company</h1>
          <h2 class="">New Company...</h2>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">New Company</li>
          </ol>
        </div>
      </div>
      <div class="container clear_both padding_fix">
        <!--\\\\\\\ container  start \\\\\\-->
        <div class="row center">
        <div class="col-lg-12 ">
        <section class="panel default green_title h2">
        <div class="panel-heading border">New Company</div>
        <form role="form" class="form-horizontal" action="<?php echo base_url(); ?>access/adding_new_company" method="post">
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
                      <input type="text" placeholder="Type Company Name" name="company_name" id="company_name" onblur="isCompanyExist();" onkeyup="disableBtn();" class="form-control" required>
                  </div>
                </div>
                </div><br />
         
        <div class="row">
            <div class="form-group">
                <div class="col-sm-2"></div>
                <div class="col-sm-1">
                    <button class="btn btn-primary" id="submit_btn" disabled="disabled">Add Company</button>
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
	
    		function isCompanyExist(){
				var company_name = $("#company_name").val();
				
				$.ajax({
					url: "<?php echo base_url();?>access/isCompanyExist/",
					type: "POST",
					data: {company_name:company_name},
					dataType: "json",
					success: function (data) {
						console.log(data.length);
						if(data.length != 0){
							alert("Sorry, User is Already Exist!");
							$("#user_id").val('');
							document.getElementById("submit_btn").disabled = true;
						}else{
							document.getElementById("submit_btn").disabled = false;
						}
						
					}
				});
			}
			
			function disableBtn(){
				document.getElementById("submit_btn").disabled = true;
			}
    </script>