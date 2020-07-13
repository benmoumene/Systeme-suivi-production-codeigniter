<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>Care Label List</h1>
        <h2 class="">Care Label List...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Care Label List</li>
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
<!--                <div class="col-md-3">-->
<!--                    <input id="cl_no" onblur="getClDetailForActive();">-->
<!--                </div>-->
                <!--              <div class="col-md-3">-->
                <!--                  <select class="form-control" required id="cut_no">-->
                <!--                      <option>Search Cut No...</option>-->
                <!--                      <option>1</option>-->
                <!--                      <option>2</option>-->
                <!--                  </select>-->
                <!--              </div>-->
                <br />
                <br />
                <br />
                <div class="porlets-content">

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


                    <div class="table-responsive">

                        <div style="display:none;">
                            <table id="sample_table">
                                <tr id="">
                                    <td><span class="sn"></span>.</td>
                                    <td><input type="text" name="pc_no[]" id="pc_no" value="" onblur="checkPcNoValidity(this);"></td>
                                    <td><input type="text" name="reason[]" value=""></td>
                                    <td><input type="text" name="requested_by[]" value=""></td>
                                    <td><a class="btn btn-xs delete-record" data-id="1"><i class="glyphicon glyphicon-trash"></i></a></td>
                                </tr>
                            </table>
                        </div>

                        <div class="well clearfix">
                            <a class="btn btn-primary pull-right add-record" data-added="0"><i class="glyphicon glyphicon-plus"></i> Add Row</a>
                        </div>


                        <form action="<?php echo base_url();?>access/saveReprintRequest" method="post" >

                            <table class="table table-bordered" id="tbl_posts">
                                <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Pc No</th>
                                    <th>Reason</th>
                                    <th>Requested By</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody id="tbl_posts_body">

                                    <td><span class="sn">1</span>.</td>
                                    <td><input type="text" name="pc_no[]" id="pc_no" value="" required="required" onblur="checkPcNoValidity(this);"></td>
                                    <td><input type="text" name="reason[]" value="" required="required"></td>
                                    <td><input type="text" name="requested_by[]" value="" required="required"></td>
                                    <td><a class="btn btn-xs delete-record" data-id="1"><i class="glyphicon glyphicon-trash"></i></a></td>

                                </tbody>
                            </table>
                    </div>

                        <button type="submit" class="btn btn-success" id="save_btn">Save</button>
                    </form>




                    </div><!--/table-responsive-->
                </div>

            </div><!--/porlets-content-->
        </div><!--/block-web-->
    </div><!--/col-md-12-->
</div>

<script type="text/javascript">
    jQuery(document).delegate('a.add-record', 'click', function(e) {
        e.preventDefault();
        var content = jQuery('#sample_table tr'),
            size = jQuery('#tbl_posts >tbody >tr').length + 1,
            element = null,
            element = content.clone();
        element.attr('id', 'rec-'+size);
        element.find('.delete-record').attr('data-id', size);
        element.appendTo('#tbl_posts_body');
        element.find('.sn').html(size);
    });


    jQuery(document).delegate('a.delete-record', 'click', function(e) {
        e.preventDefault();
        var didConfirm = confirm("Are you sure You want to delete");
        if (didConfirm == true) {
            var id = jQuery(this).attr('data-id');
            var targetDiv = jQuery(this).attr('targetDiv');
            jQuery('#rec-' + id).remove();

            //regnerate index number on table
            $('#tbl_posts_body tr').each(function(index) {
                //alert(index);
                $(this).find('span.sn').html(index+1);
            });
            return true;
        } else {
            return false;
        }
    });

    function checkPcNoValidity(id) {
        var pc_no = id.value;

        if(pc_no != ''){
            $.ajax({
                url: "<?php echo base_url();?>access/checkPcNoValidity/",
                type: "POST",
                data: {pc_no: pc_no},
                dataType: "html",
                success: function (data) {

                    if(data == 'invalid'){
                        alert(pc_no+" Not Allowed to reprint!");
                        id.value='';
                    }

                }
            });
        }

    }
</script>