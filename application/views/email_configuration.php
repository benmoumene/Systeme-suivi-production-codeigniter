<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>Email Configuration</h1>
        <h2 class="">Email Configuration...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Email Configuration</li>
        </ol>
    </div>
</div>

<div class="row" >
    <div class="col-md-12">
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

            </div><!--/block-web-->
        </div><!--/col-md-12-->
        <div class="porlets-content">
            <form action="<?php echo base_url();?>access/saveEmailConfiguration" method="post" onsubmit="return confirm('Sure to update the email configuration?');">

                <div id="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div id="set_form">
                                <table class="display table table-bordered table-striped" id="sample_2">
                                    <tbody>
                                    <tr>
                                        <td class="center" colspan="2">
                                            <span id="so_msg" style="color: red;"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="center">Email Config Type</td>
                                        <td class="center">
                                            <select required="required" id="email_type" class="form-control" name="email_type" onchange="getEmailConfigDetail();">
                                                <option value="">Email Config Type</option>
                                                <option value="0">Local</option>
                                                <option value="1">Global</option>
                                            </select>
                                            <span class="btn btn-warning" id="check_btn" name="check_btn" onclick="checkEmailConfiguration();"><i class="fa fa-check" aria-hidden="true"></i> CHECK</span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="center">Protocol *</td>
                                        <td class="center">
                                            <input type="text" name="protocol" id="protocol" required="required" />
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="center">SMTP Host *</td>
                                        <td class="center">
                                            <input type="text" name="smtp_host" id="smtp_host" required="required" />
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="center">SMTP Port *</td>
                                        <td class="center">
                                            <input type="text" name="smtp_port" id="smtp_port" required="required" />
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="center">SMTP User</td>
                                        <td class="center">
                                            <input type="text" name="smtp_user" id="smtp_user" />
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="center">SMTP Password</td>
                                        <td class="center">
                                            <input type="text" name="smtp_pass" id="smtp_pass" />
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="center">Mailtype *</td>
                                        <td class="center">
                                            <input type="text" name="mailtype" id="mailtype" required="required" />
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="center">Charset *</td>
                                        <td class="center">
                                            <input type="text" name="charset" id="charset" required="required" />
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="center">Wordwrap *</td>
                                        <td class="center">
                                            <input type="text" name="wordwrap" id="wordwrap" required="required" />
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="center">From Mail Address *</td>
                                        <td class="center">
                                            <input type="email" name="from_mail_address" id="from_mail_address" required="required" />
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="center">To Mail Address (Test)</td>
                                        <td class="center">
                                            <input type="email" name="to_mail_address" id="to_mail_address" />
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="center"></td>
                                        <td class="center">
                                            <button type="submit" class="btn btn-success" id="submit_btn" name="submit_btn">SAVE</button>
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
    $('#email_type').select2();

    function getEmailConfigDetail() {

        var email_type = $("#email_type").val();

        var protocol = $("#protocol").val('');
        var smtp_host = $("#smtp_host").val('');
        var smtp_port = $("#smtp_port").val('');
        var smtp_user = $("#smtp_user").val('');
        var smtp_pass = $("#smtp_pass").val('');
        var mailtype = $("#mailtype").val('');
        var charset = $("#charset").val('');
        var wordwrap = $("#wordwrap").val('');
        var from_mail_address = $("#from_mail_address").val('');

            $.ajax({
                url: "<?php echo base_url();?>access/getEmailConfigDetail/",
                type: "POST",
                data: {email_type: email_type},
                dataType: "json",
                success: function (data) {
                    $("#protocol").val(data[0].protocol);
                    $("#smtp_host").val(data[0].smtp_host);
                    $("#smtp_port").val(data[0].smtp_port);
                    $("#smtp_user").val(data[0].smtp_user);
                    $("#smtp_pass").val(data[0].smtp_pass);
                    $("#mailtype").val(data[0].mailtype);
                    $("#charset").val(data[0].charset);
                    $("#wordwrap").val(data[0].wordwrap);
                    $("#from_mail_address").val(data[0].from_mail_address);
                }
            });

    }
    
    function checkEmailConfiguration() {
        var email_type = $("#email_type").val();
        var to_mail_address = $("#to_mail_address").val();

        if(email_type != ''){
            if(to_mail_address != ''){
                window.open('<?php echo base_url();?>access/checkEmailConfiguration/'+email_type+'/'+to_mail_address, '_blank');
            }else{
                alert('Destination Email Address not Set!');
            }

        }else{
            alert('Please Select Email Config Type!');
        }
    }

</script>