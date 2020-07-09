<div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
          <h1>CL Send to Production</h1>
          <h2 class="">CL Send to Production...</h2>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">CL Send to Production</li>
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
            </div>
              <div class="col-md-3">
                  <input type="text" class="form-control" name="cut_tracking_no" autofocus required id="cut_tracking_no" onkeyup="sendToProduction();" />
<!--                  <input type="text" class="form-control" name="cut_tracking_no_1" required id="cut_tracking_no_1" />-->
              </div>
              <br />
              <br />
              <br />
               <div class="porlets-content">


               </div>
         
           </div><!--/porlets-content-->  
          </div><!--/block-web--> 
        </div><!--/col-md-12--> 
      </div>

<script type="text/javascript">
//    function sendToProduction() {
//        var cut_track_no = document.getElementById("cut_tracking_no").value;
//        var cut_tracking_no = cut_track_no.trim();
//
//        var last_variable = cut_tracking_no.slice(-1);
//
//        if(cut_tracking_no != '' && last_variable == '.'){
//            $.ajax({
//                url: "<?php //echo base_url();?>//access/sendingToProduction/",
//                type: "POST",
//                data: {cut_tracking_no:cut_tracking_no},
//                dataType: "html",
//                success: function (data) {
////                    alert("Successfully Completed Final Stage.")
//                    window.location.reload(true);
//
//                }
//            });
//        }
//    }


    $(document).ready(function(){
        $("#message").empty();
    });

    $("#bundle_tracking_no").blur(function(){
        $("#bundle_tracking_no").focus();
    });

    function clickToSubmitBtn() {
        var cl_no = $("#bundle_tracking_no").val();
        var care_label_no = cl_no.trim();

        var last_variable = care_label_no.slice(-1);
        var last_variable_1 = care_label_no.substr(care_label_no.length - 4);

        if((last_variable == '.') && ((last_variable_1 == 'clr.') || (last_variable_1 == 'cff.'))){
            document.getElementById("submit_btn").click();
        }
    }
</script>