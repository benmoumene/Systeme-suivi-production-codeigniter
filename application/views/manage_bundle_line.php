<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>Bundle-Line Assign</h1>
        <h2 class="">Bundle-Line Assign...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Bundle-Line Assign</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="block-web">
            <div class="header">
                <div class="actions"> <a class="minimize" href="#"><i class="fa fa-chevron-down"></i></a><a class="close-down" href="#"><i class="fa fa-times"></i></a> </div>
                <h3 class="content-header">Bundle-Line Assign</h3>
            </div>
        </div>


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
                <div class="porlets-content">


                </div>

            </div><!--/block-web-->
        </div><!--/col-md-12-->
        <div class="porlets-content">
                <form action="<?php echo base_url();?>access/changeBundleLine" method="post">

                    <div id="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div id="set_form">
                                    <table class="display table table-bordered table-striped" id="sample_2">
                                        <tbody>
                                            <tr>
                                                <td class="center">Bundle Ticket *</td>
                                                <td class="center">
                                                    <select required id="bundle_ticket" name="bundle_ticket[]" multiple data-placeholder="Select Bundle Ticket...">
                                                            <?php foreach ($bundle_list as $v_b){ ?>
                                                                <option value="<?php echo $v_b['bundle_tracking_no'];?>"><?php echo $v_b['bundle_tracking_no'];?></option>
                                                            <?php } ?>
                                                    </select>
                                                    <br />
                                                    <span style="color: #2324ff;">SAP_Cut_PO_Item_S-Grp_B</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="center">Assign To *</td>
                                                <td class="center">
                                                    <select id="line_no" name="line_no" required>
                                                        <option value="">Select Line</option>
                                                        <?php foreach ($lines as $v_l){ ?>
                                                            <option value="<?php echo $v_l['id'];?>"><?php echo $v_l['line_name'];?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="center"></td>
                                                <td class="center">
                                                    <button type="submit" class="btn btn-success" id="submit_btn" name="submit_btn">Save</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div><!--/porlets-content-->

    </div><!--/col-md-12-->
</div><!--/row-->

<script type="text/javascript">
    $('select').select2();
</script>