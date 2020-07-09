<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>Finishing Target</h1>
        <h2 class="">Finishing Target Assign...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Finishing Target Assign</li>
        </ol>
    </div>
</div>
<form action="<?php echo base_url();?>access/assignFinishingTarget" method="post">
<div class="row">
    <div class="col-md-12">
        <div class="block-web">
            <div class="header">
                <div class="actions"> <a class="minimize" href="#"><i class="fa fa-chevron-down"></i></a><a class="close-down" href="#"><i class="fa fa-times"></i></a> </div>
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
            </div>
        </div>
        <div id="row">
            <div class="col-md-2">
                <div class="form-group">

                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <h3>Select Date*</h3>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <input type="text" class="form-control form-control-inline input-medium default-date-picker" id="target_date" name="target_date" required />
                </div>
            </div>
            <div class="col-md-6">

            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                <div class="porlets-content">


                </div>

            </div><!--/block-web-->
        </div><!--/col-md-12-->
        <div class="porlets-content">

                    <div id="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div id="set_form">
                                    <table class="display table table-bordered table-striped" id="sample_2">
                                        <thead>
                                            <tr>
                                                <th class="center">Floor</th>
                                                <th class="center">Target</th>
                                                <th class="center">Target Hour</th>
                                                <th class="center">Man-Power</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($floors as $v_f){ ?>
                                            <tr>
                                                <td class="center">
                                                    <?php echo $v_f['floor_name'];?>
                                                    <input type="hidden" id="floor_id" readonly name="floor_id[]" value="<?php echo $v_f['id'];?>" required>
                                                </td>
                                                <td class="center">
                                                    <input type="text" placeholder="Target" id="target" name="target[]">
                                                </td>
                                                <td class="center">
                                                    <input type="text" placeholder="Target Hour" id="target_hour" name="target_hour[]">
                                                </td>
                                                <td class="center">
                                                    <input type="text" placeholder="Man-Power" id="mp" name="mp[]">
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

            </div><!--/porlets-content-->

    </div><!--/col-md-12-->
</div>
<div id="row">
    <div class="col-md-5">

    </div>
    <div class="col-md-7">
        <div class="form-group">
            <button class="btn btn-success">Save</button>
        </div>
    </div>
</div>
<!--/row-->
</form>

<script type="text/javascript">
    $('select').select2();
</script>