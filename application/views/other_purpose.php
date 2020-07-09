      <div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
          <h1>Other Purpose</h1>
          <h2 class="">Other Purpose...</h2>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">Other Purpose</li>
          </ol>
        </div>
      </div>
      <div class="container clear_both padding_fix">
        <!--\\\\\\\ container  start \\\\\\-->
        <form action="<?php echo base_url();?>access/saveAsOtherPurpose" method="post">
        <div class="row">
        <div class="col-md-12">
              <div style="padding-top:10px">
                  <h4 style="color:red">
                      <?php
                      $exc = $this->session->userdata('exception');
                      if (isset($exc)) {
                          echo $exc;
                          $this->session->unset_userdata('exception');
                      } ?>
                  </h4>

                  <h4 style="color:green">
                      <?php
                      $msg = $this->session->userdata('message');
                      if (isset($msg)) {
                          echo $msg;
                          $this->session->unset_userdata('message');
                      }
                      ?>
                  </h4>
              </div>



<!--              <div class="col-md-3">-->
<!--                  <input type="text" class="form-control" name="carelabel_tracking_no" autofocus required id="carelabel_tracking_no" onkeyup="clickToSubmitBtn();" />-->
<!---->
<!--<!--                  <input type="text" class="form-control" name="cut_tracking_no_1" required id="cut_tracking_no_1" />-->
<!--<!--                  <span id="er_msg" style="color: red;"></span>-->
<!--<!--                  <span id="s_msg" style="color: green;"></span>-->
<!--              </div>-->
<!--              <div class="col-md-3">-->
<!--                  <button style="display: none;" id="submit_btn" class="btn btn-success">Send</button>-->
<!--              </div>-->

          </div><!--/block-web--> 
        </div><!--/col-md-12-->
            <div class="row">
                <div class="col-md-3">
                    <input type="text" class="form-control" placeholder="Indentity Label Code" name="carelabel_tracking_no" autofocus required id="carelabel_tracking_no" onkeyup="clickToSubmitBtn();" />
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" placeholder="Reason" name="other_purpose_reason" required id="carelabel_tracking_no" onkeyup="clickToSubmitBtn();" />
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" placeholder="Responsible Person" name="other_purpose_liable_person" required id="carelabel_tracking_no" onkeyup="clickToSubmitBtn();" />
                </div>
                <div class="col-md-3">
                    <button id="submit_btn" class="btn btn-success">Send</button>
                </div>
            </div>
        </form>

      </div>

<script type="text/javascript">

    $(document).ready(function(){
        $("#message").empty();
    });


</script>