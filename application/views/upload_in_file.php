<div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
          <h1>Upload In File</h1>
          <h2 class="">Upload In File...</h2>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li>Upload In File</li>
          </ol>
        </div>
      </div>
      <div class="container clear_both padding_fix">
        <!--\\\\\\\ container  start \\\\\\-->
        <div class="row center">
        <div class="col-lg-12 ">
        <section class="panel default green_title h2">
        <div class="panel-heading border">Upload In File</div>
        <form action="<?php echo base_url();?>access/uploading_exl_in_file" method="post" enctype="multipart/form-data">
        <!--<form action="<?php echo base_url();?>access/uploading_in_file" method="post" enctype="multipart/form-data">-->
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
            <div class="row">
                <div class="col-md-4">
                    <div class="panel-body">
                        <input type="file" name="in_file" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="panel-body">
                        <button class="btn btn-primary btn-icon glyphicons envelope"><i></i> Upload </button>
                    </div>
                </div>
            </div>
        </form>
        </section>
        </div>
        </div>
      <!--\\\\\\\ container  end \\\\\\-->
    </div>