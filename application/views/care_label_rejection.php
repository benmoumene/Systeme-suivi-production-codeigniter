<div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
          <h1>CL Rejects</h1>
          <h2 class="">CL Rejects...</h2>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">CL Rejects</li>
          </ol>
        </div>
      </div>
      <div class="container clear_both padding_fix">
        <!--\\\\\\\ container  start \\\\\\-->
        <form action="<?php echo base_url();?>access/inputToLine" method="post">
        <div class="row">
        <div class="col-md-12">
          <div class="block-web">
            <div class="header">
              <div class="actions"> <a class="minimize" href="#"><i class="fa fa-chevron-down"></i></a> <a class="refresh" href="#"><i class="fa fa-repeat"></i></a> <a class="close-down" href="#"><i class="fa fa-times"></i></a> </div>
            </div>

              <div style="padding-top:10px">
                  <h6 style="color:red">
                      <?php
                      $exc = $this->session->userdata('exception');
                      if (isset($exc)) {
                          echo $exc;
                          $this->session->unset_userdata('exception');
                      } ?>
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



              <div class="col-md-3">
                  <input type="text" class="form-control" name="carelabel_tracking_no" autofocus required id="carelabel_tracking_no" onkeyup="clickToSubmitBtn();" />

<!--                  <input type="text" class="form-control" name="cut_tracking_no_1" required id="cut_tracking_no_1" />-->
<!--                  <span id="er_msg" style="color: red;"></span>-->
<!--                  <span id="s_msg" style="color: green;"></span>-->
              </div>
              <div class="col-md-3">
                  <button id="submit_btn" class="btn btn-success">Send</button>
              </div>

              <br />
              <br />
              <br />
               <div class="porlets-content">


               </div>

           </div><!--/porlets-content-->
          </div><!--/block-web-->
        </div><!--/col-md-12-->
        </form>
<!--          <div class="row">-->
<!--              <div class="col-md-12">-->
<!--                  <div class="block-web">-->
<!--                      <div class="header">-->
<!--                          <div class="actions"> <a class="minimize" href="#"><i class="fa fa-chevron-down"></i></a> <a class="refresh" href="#"><i class="fa fa-repeat"></i></a> <a class="close-down" href="#"><i class="fa fa-times"></i></a> </div>-->
<!--                      </div>-->
<!--                      <div class="col-md-3">-->
<!--                          <table id="sample_1" border="1">-->
<!--                              <thead>-->
<!--                              <tr>-->
<!--                                  <th>Care Label No.</th>-->
<!--                                  <th>Status</th>-->
<!--                              </tr>-->
<!--                              </thead>-->
<!--                              <tbody>-->
<!--                              <tr>-->
<!--                                  <td></td>-->
<!--                                  <td></td>-->
<!--                              </tr>-->
<!--                              </tbody>-->
<!--                          </table>-->
<!--                      </div>-->
<!--                  </div><!--/porlets-content-->
<!--              </div><!--/block-web-->
<!--          </div><!--/col-md-12-->
      </div>

<script type="text/javascript">

    $(document).ready(function(){
        $("#message").empty();
    });

//    $("#carelabel_tracking_no").blur(function(){
//        $("#carelabel_tracking_no").focus();
//    });

//    function clickToSubmitBtn() {
//        var cl_no = $("#carelabel_tracking_no").val();
//        var care_label_no = cl_no.trim();
//
//        var last_variable = care_label_no.slice(-1);
//
//        if(care_label_no != '' && last_variable == '.'){
//            document.getElementById("submit_btn").click();
//        }
//    }

</script>